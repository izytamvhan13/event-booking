<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role === 'user') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $bookings = Booking::with(['user', 'venue', 'facilities'])
            ->whereMonth('start_time', $month)
            ->whereYear('start_time', $year)
            ->orderBy('start_time', 'asc')
            ->get();

        return view('admin.laporan', compact('bookings', 'month', 'year'));
    }
}