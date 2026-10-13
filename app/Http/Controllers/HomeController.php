<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingHistory;
use App\Models\Room;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        try {
            if (!app()->runningInConsole()) {
                // Auto update status 'disetujui' menjadi 'selesai' jika tanggalnya sudah lewat
                Booking::where('status', 'disetujui')
                    ->whereDate('tanggal', '<', now()->toDateString())
                    ->update(['status' => 'selesai']);
            }
        } catch (\Throwable $e) {
            // Ignore if DB is not ready
        }
    }

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

        $startDayOffset = $current->dayOfWeekIso - 1;

        if ($request->ajax()) {
            return view('partials.calendar', [
                'current'        => $current,
                'daysInMonth'    => $daysInMonth,
                'bookedDays'     => $bookedDays,
                'startDayOffset' => $startDayOffset,
            ]);
        }

        return view('home', [
            'rooms'          => $rooms,
            'current'        => $current,
            'daysInMonth'    => $daysInMonth,
            'bookedDays'     => $bookedDays,
            'startDayOffset' => $startDayOffset,
        ]);
    }

    // Menampilkan form pengajuan peminjaman untuk 1 ruangan (PUBLIK)
    public function bookingForm(Room $room)
    {
        return view('booking-form', compact('room'));
    }

    // Menyimpan pengajuan peminjaman dari publik (TANPA LOGIN)
    public function bookingStore(Request $request, Room $room)
    {
        $data = $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'nama_pemohon'    => 'required|string|max:255',
            'instansi'        => 'nullable|string|max:255',
            'no_whatsapp'     => 'required|string|max:20',
            'email'           => 'required|email|max:255',
            'tanggal'         => 'required|date|after_or_equal:' . Carbon::now()->addDays(3)->format('Y-m-d'),
            'jam_mulai'       => 'required',
            'jam_selesai'     => 'required|after:jam_mulai',
            'keterangan'      => 'nullable|string|max:1000',
            'surat_pengajuan' => 'required|file|mimes:pdf|max:15360',
        ]);

        // Cek double booking di backend
        $conflict = Booking::where('room_id', $room->id)
            ->where('tanggal', $data['tanggal'])
            ->whereIn('status', ['disetujui', 'pending'])
            ->where(function ($q) use ($data) {
                $q->where(function ($q2) use ($data) {
                    $q2->where('jam_mulai', '<', $data['jam_selesai'])
                       ->where('jam_selesai', '>', $data['jam_mulai']);
                });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'tanggal' => 'Maaf, jadwal yang Anda pilih sudah terisi atau sedang menunggu persetujuan. Silakan pilih jadwal lain.'
            ])->withInput();
        }

        if ($request->hasFile('surat_pengajuan')) {
            $data['surat_pengajuan'] = $request->file('surat_pengajuan')->store('surat_pengajuan', 'public');
        }

        // Generate kode booking unik
        $data['kode_booking'] = Booking::generateKodeBooking();
        $data['kontak'] = $data['no_whatsapp'];
        $data['status'] = 'pending';

        $booking = $room->bookings()->create($data);

        // Catat riwayat
        BookingHistory::create([
            'booking_id'       => $booking->id,
            'status_sebelumnya' => null,
            'status_baru'      => 'pending',
            'tanggal_baru'     => $booking->tanggal,
            'perubahan'        => 'Pengajuan peminjaman baru',
        ]);

        // Notifikasi ke admin
        $notificationService = new NotificationService();
        $notificationService->notifyAdminNewBooking($booking);

        return redirect()->route('booking.success', ['kode' => $booking->kode_booking]);
    }

    // Halaman sukses setelah booking
    public function bookingSuccess(Request $request)
    {
        $kode = $request->get('kode');
        $booking = Booking::with('room')->where('kode_booking', $kode)->firstOrFail();

        return view('booking-success', compact('booking'));
    }

    // Form cek booking
    public function cekBookingForm()
    {
        return view('cek-booking');
    }

    // Proses cek booking
    public function cekBooking(Request $request)
    {
        $request->validate([
            'kode_booking' => 'required|string',
        ]);

        $booking = Booking::with(['room', 'histories.admin'])
            ->where('kode_booking', strtoupper($request->kode_booking))
            ->first();

        if (!$booking) {
            return back()->withErrors([
                'kode_booking' => 'Kode booking tidak ditemukan. Pastikan kode yang Anda masukkan benar.'
            ])->withInput();
        }

        return view('cek-booking', compact('booking'));
    }
}
