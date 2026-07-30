<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Venue;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEventBulanIni = Booking::whereMonth('start_time', Carbon::now()->month)
            ->whereYear('start_time', Carbon::now()->year)
            ->count();
        $menungguPersetujuan = Booking::where('status', 'pending')->count();
        $totalVenue = Venue::count();
        $pendingBookings = Booking::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $calendarStatuses = auth()->user()->role === 'pimpinan'
            ? ['approved']
            : ['pending', 'approved'];

        $bookings = Booking::with(['user', 'venue', 'facilities'])
            ->whereIn('status', $calendarStatuses)
            ->where('end_time', '>=', now())
            ->get();

        $events = $bookings->map(function ($booking) {
            return [
                'title' => $booking->event_name,
                'start' => $booking->start_time,
                'end' => $booking->end_time,
                'color' => $booking->status == 'approved' ? '#10b981' : '#f59e0b',
                'extendedProps' => [
                    'venue' => $booking->venue->name ?? '-',
                    'status' => $booking->status,
                    'booker' => $booking->user->name ?? 'Unknown',

                    'facilities' => $booking->facilities->map(function ($facility) {
                        return [
                            'name' => $facility->name,
                            'photo' => $facility->photo,
                        ];
                    })->values()
                ]
            ];
        });

        return view('admin.dashboard', compact(
            'totalEventBulanIni',
            'menungguPersetujuan',
            'totalVenue',
            'events',
            'pendingBookings'
        ));
    }
}