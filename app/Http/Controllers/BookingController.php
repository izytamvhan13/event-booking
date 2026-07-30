<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Venue;
use App\Models\Facility;
use App\Models\User;
use App\Notifications\BookingStatusUpdated;
use App\Notifications\NewBookingSubmitted;
use App\Notifications\BookingForwardedToPimpinan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        if ($role === 'user') {
            $bookings = Booking::with(['user', 'venue', 'facilities'])
                ->where('user_id', auth()->id())
                ->latest()
                ->get();
        } elseif ($role === 'pimpinan') {
            $bookings = Booking::with(['user', 'venue', 'facilities'])
                ->where(function ($q) {
                    $q->where('admin_status', 'forwarded')
                        ->orWhereIn('status', ['approved', 'rejected']);
                })
                ->latest()
                ->get();
        } else {
            $bookings = Booking::with(['user', 'venue', 'facilities'])->latest()->get();
        }

        return view('bookings.index', compact('bookings'));
    }

    public function update(Request $request, Booking $booking)
    {
        $role = auth()->user()->role;

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'nullable|string|max:255'
        ]);

        if ($request->status === 'approved' && $role !== 'pimpinan') {
            return redirect()->back()->with('error', 'Hanya pimpinan yang dapat menyetujui booking secara final.');
        }

        if ($role === 'pimpinan' && $request->status === 'approved' && $booking->admin_status !== 'forwarded') {
            return redirect()->back()->with('error', 'Booking ini belum diteruskan oleh admin.');
        }

        $previousStatus = $booking->status;

        $booking->update([
            'status' => $request->status,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
        ]);

        if ($role === 'admin' && $request->status === 'rejected') {
            $booking->update([
                'admin_status' => 'rejected',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
        }

        if ($booking->user && in_array($request->status, ['approved', 'rejected'], true) && $previousStatus !== $request->status) {
            $booking->user->notify(new BookingStatusUpdated($booking->fresh(), $request->status));
        }

        return redirect()->back()->with('success', 'Booking berhasil diperbarui!');
    }

    public function forward(Request $request, Booking $booking)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $booking->update([
            'admin_status' => 'forwarded',
            'admin_note' => $request->admin_note,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $pimpinanUsers = User::where('role', 'pimpinan')->get();
        Notification::send($pimpinanUsers, new BookingForwardedToPimpinan($booking));

        return redirect()->back()->with('success', 'Booking berhasil diteruskan ke pimpinan.');
    }

    public function create()
    {
        $venues = Venue::with('facilities')->get();

        $bookedSlots = Booking::whereIn('status', ['pending', 'approved'])
            ->where('end_time', '>=', now())
            ->get(['venue_id', 'start_time', 'end_time', 'status'])
            ->map(function ($b) {
                return [
                    'venue_id' => $b->venue_id,
                    'start' => $b->start_time,
                    'end' => $b->end_time,
                    'status' => $b->status,
                ];
            });

        // Dipakai di form untuk menghitung sisa kuota fasilitas (misal kursi) secara live
        // begitu user memilih tanggal/jam, tanpa perlu menunggu submit.
        $facilityUsage = Booking::whereIn('status', ['pending', 'approved'])
            ->where('end_time', '>=', now())
            ->with('facilities')
            ->get(['id', 'start_time', 'end_time'])
            ->flatMap(function ($b) {
                return $b->facilities->map(function ($f) use ($b) {
                    return [
                        'facility_id' => $f->id,
                        'qty' => $f->pivot->qty ?? 1,
                        'start' => $b->start_time,
                        'end' => $b->end_time,
                    ];
                });
            })
            ->values();

        return view('bookings.create', compact('venues', 'bookedSlots', 'facilityUsage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'event_name' => 'required|string|max:255',
            'pic_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'facilities' => 'nullable|array',
            'ktp_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'permohonan_file' => 'required|mimes:pdf|max:4096',
            'proposal_file' => 'required|mimes:pdf|max:4096',
        ], [
            'pic_name.required' => 'Nama penanggung jawab wajib diisi.',
            'ktp_photo.required' => 'Foto/scan KTP penanggung jawab wajib diunggah.',
            'ktp_photo.image' => 'File KTP harus berupa gambar (JPG/PNG).',
            'permohonan_file.required' => 'Surat permohonan resmi wajib diunggah.',
            'permohonan_file.mimes' => 'Surat permohonan harus berformat PDF.',
            'proposal_file.required' => 'Proposal event wajib diunggah.',
            'proposal_file.mimes' => 'Proposal event harus berformat PDF.',
        ]);

        // Batas maksimal 2 booking aktif (pending/approved) per user, untuk mencegah spam.
        $activeCount = Booking::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($activeCount >= 2) {
            return back()->withInput()->withErrors(['limit' => 'Anda sudah memiliki 2 booking aktif (masih pending atau sudah disetujui). Selesaikan atau tunggu keputusan booking sebelumnya sebelum mengajukan booking baru.']);
        }

        $newStart = Carbon::parse($request->start_time);
        $newEnd = Carbon::parse($request->end_time);

        $overlap = function ($query) use ($newStart, $newEnd) {
            $query->where('start_time', '<', $newEnd->copy()->addHour())
                ->where('end_time', '>', $newStart->copy()->subHour());
        };

        $isVenueConflict = Booking::where('venue_id', $request->venue_id)
            ->whereIn('status', ['pending', 'approved'])
            ->where($overlap)
            ->exists();

        if ($isVenueConflict) {
            return back()->withInput()->withErrors(['waktu' => 'Jadwal terlalu dekat dengan event lain di venue ini! Sistem mewajibkan jeda minimal 1 jam untuk pembersihan venue.']);
        }

        // Validasi fasilitas: dibedakan antara fasilitas ber-kuota (quantity > 0, misal kursi,
        // bisa dibagi ke beberapa booking) dan fasilitas eksklusif (quantity = 0, misal proyektor
        // tunggal, sekali dipakai langsung dianggap penuh untuk siapapun di jadwal berdekatan).
        $facilityQtyToAttach = [];

        if ($request->filled('facilities')) {
            foreach ($request->facilities as $facilityId) {
                $facility = Facility::find($facilityId);
                if (!$facility) continue;

                if ($facility->quantity > 0) {
                    $requestedQty = (int) ($request->input("facility_qty.$facilityId", 1));
                    if ($requestedQty < 1) $requestedQty = 1;

                    $used = Booking::whereIn('status', ['pending', 'approved'])
                        ->where($overlap)
                        ->whereHas('facilities', function ($q) use ($facilityId) {
                            $q->where('facilities.id', $facilityId);
                        })
                        ->join('booking_facility', 'bookings.id', '=', 'booking_facility.booking_id')
                        ->where('booking_facility.facility_id', $facilityId)
                        ->sum('booking_facility.qty');

                    $remaining = $facility->quantity - $used;

                    if ($requestedQty > $remaining) {
                        return back()->withInput()->withErrors([
                            'fasilitas' => "Fasilitas \"{$facility->name}\" cuma tersisa {$remaining} unit pada jadwal ini, tapi Anda meminta {$requestedQty}."
                        ]);
                    }

                    $facilityQtyToAttach[$facilityId] = $requestedQty;
                } else {
                    $conflict = Booking::whereIn('status', ['pending', 'approved'])
                        ->where($overlap)
                        ->whereHas('facilities', function ($q) use ($facilityId) {
                            $q->where('facilities.id', $facilityId);
                        })
                        ->exists();

                    if ($conflict) {
                        return back()->withInput()->withErrors([
                            'fasilitas' => "Fasilitas \"{$facility->name}\" sedang digunakan oleh event lain (di venue berbeda) pada waktu yang berdekatan."
                        ]);
                    }

                    $facilityQtyToAttach[$facilityId] = 1;
                }
            }
        }

        $ktpPath = $request->file('ktp_photo')->store('bookings/ktp', 'public');
        $permohonanPath = $request->file('permohonan_file')->store('bookings/permohonan', 'public');
        $proposalPath = $request->file('proposal_file')->store('bookings/proposal', 'public');

        $booking = Booking::create([
            'user_id' => auth()->id() ?? 1,
            'venue_id' => $request->venue_id,
            'event_name' => $request->event_name,
            'pic_name' => $request->pic_name,
            'description' => $request->description,
            'ktp_photo' => $ktpPath,
            'permohonan_file' => $permohonanPath,
            'proposal_file' => $proposalPath,
            'start_time' => $newStart,
            'end_time' => $newEnd,
            'status' => 'pending',
        ]);

        foreach ($facilityQtyToAttach as $facilityId => $qty) {
            $booking->facilities()->attach($facilityId, ['qty' => $qty]);
        }

        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewBookingSubmitted($booking));

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibuat, menunggu peninjauan admin.');
    }
}