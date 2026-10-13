<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Auto update status 'disetujui' menjadi 'selesai' jika tanggalnya sudah lewat
        Booking::where('status', 'disetujui')
            ->whereDate('tanggal', '<', now()->toDateString())
            ->update(['status' => 'selesai']);

        $totalRooms     = Room::count();
        $pendingCount   = Booking::where('status', 'pending')->count();
        $approvedCount  = Booking::where('status', 'disetujui')->count();
        $rescheduleCount = Booking::where('status', 'dijadwalkan_ulang')->count();
        $todayBookings  = Booking::where('status', 'disetujui')
                            ->whereDate('tanggal', Carbon::today())
                            ->count();

        // 10 peminjaman terbaru
        $recentBookings = Booking::with('room')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'pendingCount',
            'approvedCount',
            'rescheduleCount',
            'todayBookings',
            'recentBookings'
        ));
    }

    public function notifications()
    {
        $notifications = AdminNotification::with('booking')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.notifikasi', compact('notifications'));
    }

    public function markAsRead(AdminNotification $notification)
    {
        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }
}
