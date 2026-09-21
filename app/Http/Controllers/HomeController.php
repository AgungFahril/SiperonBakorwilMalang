<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::where('is_active', true)->get();

        // Bulan yang sedang ditampilkan di kalender (default bulan berjalan)
        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year', now()->year);
        $current = Carbon::create($year, $month, 1);

        $daysInMonth = $current->daysInMonth;

        // Tanggal-tanggal yang sudah disetujui (status = disetujui) di bulan ini
        $bookedDays = Booking::where('status', 'disetujui')
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->pluck('tanggal')
            ->map(fn ($d) => $d->day)
            ->unique();

        return view('home', [
            'rooms'        => $rooms,
            'current'      => $current,
            'daysInMonth'  => $daysInMonth,
            'bookedDays'   => $bookedDays,
        ]);
    }

    // Menampilkan form pengajuan peminjaman untuk 1 ruangan
    public function bookingForm(Room $room)
    {
        return view('booking-form', compact('room'));
    }

    // Menyimpan pengajuan peminjaman dari publik (status default: pending)
    public function bookingStore(Request $request, Room $room)
    {
        $data = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'nama_pemohon'  => 'required|string|max:255',
            'instansi'      => 'nullable|string|max:255',
            'kontak'        => 'nullable|string|max:50',
            'tanggal'       => 'required|date|after_or_equal:today',
            'jam_mulai'     => 'required',
            'jam_selesai'   => 'required|after:jam_mulai',
        ]);

        $room->bookings()->create($data + ['status' => 'pending']);

        return redirect()
            ->route('home')
            ->with('status', 'Pengajuan peminjaman berhasil dikirim. Silakan tunggu konfirmasi dari pengelola.');
    }
}
