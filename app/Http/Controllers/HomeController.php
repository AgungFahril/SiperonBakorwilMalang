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

        // Tanggal-tanggal yang sudah disetujui atau pending beserta nama ruangannya
        $bookingsThisMonth = Booking::with('room')
            ->whereIn('status', ['disetujui', 'pending'])
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->get();

        $bookedDays = [];
        foreach ($bookingsThisMonth as $b) {
            $day = $b->tanggal->day;
            if (!isset($bookedDays[$day])) {
                $bookedDays[$day] = [];
            }
            if ($b->room) {
                $bookedDays[$day][] = [
                    'room'   => $b->room->name,
                    'status' => $b->status,
                ];
            }
        }

        if ($request->ajax()) {
            return view('partials.calendar', [
                'current'      => $current,
                'daysInMonth'  => $daysInMonth,
                'bookedDays'   => $bookedDays,
            ]);
        }

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
            'nama_kegiatan'   => 'required|string|max:255',
            'nama_pemohon'    => 'required|string|max:255',
            'instansi'        => 'nullable|string|max:255',
            'kontak'          => 'nullable|string|max:50',
            'tanggal'         => 'required|date|after_or_equal:today',
            'jam_mulai'       => 'required',
            'jam_selesai'     => 'required|after:jam_mulai',
            'surat_pengajuan' => 'required|file|mimes:pdf|max:15360',
        ]);

        if ($request->hasFile('surat_pengajuan')) {
            $data['surat_pengajuan'] = $request->file('surat_pengajuan')->store('surat_pengajuan', 'public');
        }

        $room->bookings()->create($data + [
            'status'  => 'pending',
            'user_id' => auth()->id()
        ]);

        return redirect()
            ->route('user.riwayat')
            ->with('status', 'Pengajuan peminjaman berhasil dikirim. Silakan tunggu konfirmasi dari pengelola.');
    }

    // Menampilkan riwayat peminjaman pengguna
    public function riwayat()
    {
        $bookings = Booking::with('room')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat', compact('bookings'));
    }
}
