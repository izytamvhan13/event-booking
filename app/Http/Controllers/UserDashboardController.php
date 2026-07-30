<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Venue;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'venue'])
            ->whereIn('status', ['pending', 'approved'])
            ->where('end_time', '>=', now())
            ->get();

        $currentUserId = auth()->id();

        $events = $bookings->map(function ($booking) use ($currentUserId) {
            $isMine = $booking->user_id === $currentUserId;

            return [
                'title' => $isMine
                    ? $booking->event_name . ' (Booking Anda)'
                    : 'Sudah Dipesan',
                'start' => $booking->start_time,
                'end' => $booking->end_time,
                'color' => $isMine
                    ? ($booking->status == 'approved' ? '#10b981' : '#f59e0b')
                    : '#94a3b8', // abu-abu untuk booking user lain, biar visualnya beda dari punya sendiri
                'extendedProps' => [
                    'venue' => $booking->venue->name ?? '-',
                    'status' => $booking->status,
                    'is_mine' => $isMine,
                    'event_name' => $booking->event_name,
                ]
            ];
        });

        return view('user.dashboard', compact('events'));
    }

    public function gachaSlot()
    {
        $now = Carbon::now();
        $start_time = $now->copy()->addHour()->startOfHour(); 
        $end_time = $start_time->copy()->addHours(2); 
        
        if ($start_time->hour >= 21) {
            return back()->with('error_gacha', 'Maaf, sudah tidak ada slot kosong untuk malam ini. Silakan cari untuk besok.');
        }

        $availableVenue = Venue::whereDoesntHave('bookings', function ($query) use ($start_time, $end_time) {
            $query->whereIn('status', ['pending', 'approved'])
                  ->where('start_time', '<', $end_time->copy()->addHour())
                  ->where('end_time', '>', $start_time->copy()->subHour());
        })->first();

        if ($availableVenue) {
            return redirect()->route('bookings.create', [
                'gacha_venue' => $availableVenue->id,
                'gacha_start' => $start_time->format('Y-m-d\TH:i'),
                'gacha_end' => $end_time->format('Y-m-d\TH:i'),
            ])->with('success_gacha', 'Yay! Kami menemukan slot kosong di ' . $availableVenue->name . ' untuk Anda!');
        }

        return back()->with('error_gacha', 'Waduh, kamu tidak bisa booking di jam terdekat. Silakan cek kalender untuk jam lainnya.');
    }
}