<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms     = Room::count();
        $pendingCount   = Booking::where('status', 'pending')->count();
        $todayBookings  = Booking::where('status', 'disetujui')
                            ->whereDate('tanggal', Carbon::today())
                            ->count();
        $totalUsers     = User::count();

        // 10 peminjaman terbaru
        $recentBookings = Booking::with('room')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'pendingCount',
            'todayBookings',
            'totalUsers',
            'recentBookings'
        ));
    }
}
