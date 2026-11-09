<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingHistory;
use App\Models\Room;
use App\Models\Setting;
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
        $rooms = Room::with('images')->where('is_active', true)->get();

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

    /**
     * Halaman Publik: Ketersediaan Ruangan per Tanggal (Kiri: Tanggal, Kanan: Status Ruangan)
     */
    public function ketersediaan(Request $request)
    {
        // 1. Tentukan tanggal yang dipilih (default hari ini, atau dari request YYYY-MM-DD)
        $dateParam = $request->get('tanggal');
        try {
            $selectedDate = $dateParam ? Carbon::parse($dateParam) : Carbon::today();
        } catch (\Throwable $e) {
            $selectedDate = Carbon::today();
        }

        // 2. Bulan & Tahun untuk kalender di sebelah kiri
        $calMonth = (int) $request->get('cal_month', $selectedDate->month);
        $calYear  = (int) $request->get('cal_year', $selectedDate->year);
        $calCurrent = Carbon::create($calYear, $calMonth, 1);
        $daysInMonth = $calCurrent->daysInMonth;
        $startDayOffset = $calCurrent->dayOfWeekIso - 1;

        // Ambil semua tanggal yang memiliki booking di bulan kalender mini
        $monthBookings = Booking::whereIn('status', ['disetujui', 'pending'])
            ->whereYear('tanggal', $calYear)
            ->whereMonth('tanggal', $calMonth)
            ->get(['tanggal', 'status']);

        $bookedDayCounts = [];
        foreach ($monthBookings as $mb) {
            $day = $mb->tanggal->day;
            if (!isset($bookedDayCounts[$day])) {
                $bookedDayCounts[$day] = ['approved' => 0, 'pending' => 0];
            }
            if ($mb->status === 'disetujui') {
                $bookedDayCounts[$day]['approved']++;
            } else {
                $bookedDayCounts[$day]['pending']++;
            }
        }

        // 3. Ambil semua ruangan aktif
        $rooms = Room::with('images')->where('is_active', true)->get();

        // 4. Ambil booking di tanggal yang dipilih ($selectedDate)
        $dayBookings = Booking::with('room')
            ->whereDate('tanggal', $selectedDate->toDateString())
            ->whereIn('status', ['disetujui', 'pending'])
            ->orderBy('jam_mulai')
            ->get();

        // 5. Susun status ketersediaan untuk masing-masing ruangan
        $roomStatuses = [];
        $totalTersedia = 0;
        $totalTerbooking = 0;

        foreach ($rooms as $room) {
            $rBookings = $dayBookings->where('room_id', $room->id)->values();

            if ($rBookings->isEmpty()) {
                $status = 'tersedia';
                $totalTersedia++;
            } else {
                $status = 'terbooking';
                $totalTerbooking++;
            }

            $roomStatuses[] = [
                'room'     => $room,
                'status'   => $status, // 'tersedia' | 'terbooking'
                'bookings' => $rBookings,
            ];
        }

        $viewData = [
            'selectedDate'    => $selectedDate,
            'calCurrent'      => $calCurrent,
            'daysInMonth'     => $daysInMonth,
            'startDayOffset'  => $startDayOffset,
            'bookedDayCounts' => $bookedDayCounts,
            'roomStatuses'    => $roomStatuses,
            'totalRooms'      => $rooms->count(),
            'totalTersedia'   => $totalTersedia,
            'totalTerbooking' => $totalTerbooking,
        ];

        if ($request->ajax()) {
            return view('partials.ketersediaan-content', $viewData);
        }

        return view('ketersediaan', $viewData);
    }

    /**
     * Form Pengajuan Peminjaman Multi-Ruangan (PUBLIK)
     * Mengizinkan pemohon mengisi identitas 1 kali dan memilih 1 atau lebih ruangan.
     */
    public function bookingFormMulti(Request $request)
    {
        $rooms = Room::with('images')->where('is_active', true)->orderBy('name')->get();

        // Pre-selected room ID jika ada parameter query
        $selectedRoomId = null;
        if ($request->has('room')) {
            $selectedRoomId = (int) $request->get('room');
        } elseif ($request->has('room_id')) {
            $selectedRoomId = (int) $request->get('room_id');
        } elseif ($rooms->isNotEmpty()) {
            $selectedRoomId = $rooms->first()->id;
        }

        // Default tanggal: minimal H+3
        $minDate = Carbon::now()->addDays(3)->format('Y-m-d');
        $defaultDate = $request->get('tanggal', $minDate);
        if ($defaultDate < $minDate) {
            $defaultDate = $minDate;
        }

        $settings = Setting::pluck('value', 'key')->all();

        return view('booking-form', compact('rooms', 'selectedRoomId', 'defaultDate', 'settings'));
    }

    /**
     * Menyimpan pengajuan peminjaman multi-ruangan (PUBLIK)
     */
    public function bookingStoreMulti(Request $request)
    {
        $request->validate([
            'nama_pemohon'           => 'required|string|max:255',
            'instansi'               => 'nullable|string|max:255',
            'no_whatsapp'            => 'required|string|max:20',
            'email'                  => 'required|email|max:255',
            'keterangan'             => 'nullable|string|max:1000',
            'surat_pengajuan'        => 'required|file|mimes:pdf|max:15360',
            'rooms'                  => 'required|array|min:1',
            'rooms.*.room_id'        => 'required|exists:rooms,id',
            'rooms.*.tanggal'        => 'required|date|after_or_equal:' . Carbon::now()->addDays(3)->format('Y-m-d'),
            'rooms.*.jam_mulai'      => 'required',
            'rooms.*.jam_selesai'    => 'required|after:rooms.*.jam_mulai',
            'rooms.*.nama_kegiatan'  => 'required|string|max:255',
            'rooms.*.jumlah_peserta' => 'required|integer|min:1',
        ], [
            'rooms.required'                 => 'Minimal tentukan 1 ruangan yang ingin dipinjam.',
            'rooms.*.room_id.required'       => 'Pilih ruangan yang valid.',
            'rooms.*.tanggal.required'       => 'Tanggal peminjaman wajib diisi.',
            'rooms.*.tanggal.after_or_equal' => 'Tanggal peminjaman minimal 3 hari dari sekarang.',
            'rooms.*.jam_selesai.after'      => 'Jam selesai harus lebih akhir dari jam mulai.',
            'rooms.*.nama_kegiatan.required' => 'Nama kegiatan / keperluan wajib diisi.',
            'rooms.*.jumlah_peserta.required'=> 'Jumlah peserta wajib diisi.',
            'surat_pengajuan.required'       => 'Surat permohonan / pengajuan (PDF) wajib diupload.',
        ]);

        $roomsInput = $request->input('rooms', []);

        // 1. Cek bentrok internal antar slot inputan pengguna sendiri
        for ($i = 0; $i < count($roomsInput); $i++) {
            for ($j = $i + 1; $j < count($roomsInput); $j++) {
                $itemA = $roomsInput[$i];
                $itemB = $roomsInput[$j];

                if ($itemA['room_id'] == $itemB['room_id'] && $itemA['tanggal'] == $itemB['tanggal']) {
                    if ($itemA['jam_mulai'] < $itemB['jam_selesai'] && $itemA['jam_selesai'] > $itemB['jam_mulai']) {
                        $roomObj = Room::find($itemA['room_id']);
                        $rName = $roomObj ? $roomObj->name : 'Ruangan';
                        $tgl = Carbon::parse($itemA['tanggal'])->translatedFormat('d F Y');
                        return back()->withErrors([
                            'rooms' => "Jadwal untuk {$rName} pada {$tgl} bertabrakan di formulir Anda sendiri ({$itemA['jam_mulai']}-{$itemA['jam_selesai']} dan {$itemB['jam_mulai']}-{$itemB['jam_selesai']})."
                        ])->withInput();
                    }
                }
            }
        }

        // 2. Cek bentrok dengan database untuk setiap slot ruangan
        foreach ($roomsInput as $idx => $item) {
            $conflict = Booking::where('room_id', $item['room_id'])
                ->where('tanggal', $item['tanggal'])
                ->whereIn('status', ['disetujui', 'pending'])
                ->where(function ($q) use ($item) {
                    $q->where(function ($q2) use ($item) {
                        $q2->where('jam_mulai', '<', $item['jam_selesai'])
                           ->where('jam_selesai', '>', $item['jam_mulai']);
                    });
                })
                ->exists();

            if ($conflict) {
                $roomObj = Room::find($item['room_id']);
                $rName = $roomObj ? $roomObj->name : 'Ruangan terpilih';
                $tglFormatted = Carbon::parse($item['tanggal'])->translatedFormat('d F Y');
                return back()->withErrors([
                    "rooms.{$idx}.tanggal" => "Maaf, {$rName} pada tanggal {$tglFormatted} pukul {$item['jam_mulai']} - {$item['jam_selesai']} sudah terisi atau sedang menunggu persetujuan. Silakan sesuaikan waktu atau pilih ruangan lain."
                ])->withInput();
            }
        }

        // 3. Simpan file surat pengajuan (1 berkas untuk seluruh paket peminjaman)
        $suratPengajuanPath = null;
        if ($request->hasFile('surat_pengajuan')) {
            $suratPengajuanPath = $request->file('surat_pengajuan')->store('surat_pengajuan', 'public');
        }

        // 4. Buat record Booking dalam DB Transaction
        $createdBookings = collect();
        $groupCode = Booking::generateGroupCode();

        DB::transaction(function () use ($request, $roomsInput, $suratPengajuanPath, $groupCode, &$createdBookings) {
            foreach ($roomsInput as $item) {
                $booking = Booking::create([
                    'room_id'         => $item['room_id'],
                    'kode_booking'    => Booking::generateKodeBooking(),
                    'group_code'      => $groupCode,
                    'nama_pemohon'    => $request->nama_pemohon,
                    'instansi'        => $request->instansi,
                    'no_whatsapp'     => $request->no_whatsapp,
                    'kontak'          => $request->no_whatsapp,
                    'email'           => $request->email,
                    'nama_kegiatan'   => $item['nama_kegiatan'],
                    'jumlah_peserta'  => $item['jumlah_peserta'],
                    'tanggal'         => $item['tanggal'],
                    'jam_mulai'       => $item['jam_mulai'],
                    'jam_selesai'     => $item['jam_selesai'],
                    'keterangan'      => $request->keterangan,
                    'surat_pengajuan' => $suratPengajuanPath,
                    'status'          => 'pending',
                ]);

                BookingHistory::create([
                    'booking_id'        => $booking->id,
                    'status_sebelumnya' => null,
                    'status_baru'       => 'pending',
                    'tanggal_baru'      => $booking->tanggal,
                    'perubahan'         => 'Pengajuan peminjaman baru (Multi-ruangan)',
                ]);

                $createdBookings->push($booking->load('room'));
            }
        });

        // 5. Kirim Notifikasi Terkonsolidasi (Email, WA, DB Notification)
        try {
            $notificationService = new NotificationService();
            $notificationService->notifyAdminNewBookings($createdBookings);
        } catch (\Throwable $e) {
            \Log::error("Gagal mengirim notifikasi multi-booking: " . $e->getMessage());
        }

        // 6. Redirect ke halaman sukses dengan membawa daftar kode booking
        $kodes = $createdBookings->pluck('kode_booking')->implode(',');
        return redirect()->route('booking.success', ['kodes' => $kodes]);
    }

    /**
     * Backward-compatibility: Redirect rute /ruangan/{room}/ajukan ke form multi
     */
    public function bookingForm(Request $request, Room $room)
    {
        return redirect()->route('booking.form.multi', [
            'room'    => $room->id,
            'tanggal' => $request->get('tanggal'),
        ]);
    }

    /**
     * Backward-compatibility: Booking store single room
     */
    public function bookingStore(Request $request, Room $room)
    {
        $data = $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'jumlah_peserta'  => 'required|integer|min:1',
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
        $data['group_code']   = $data['kode_booking'];
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

        return redirect()->route('booking.success', ['kodes' => $booking->kode_booking]);
    }

    /**
     * Halaman sukses setelah booking (Mendukung 1 atau multi-booking)
     */
    public function bookingSuccess(Request $request)
    {
        $kodesParam = $request->get('kodes', $request->get('kode'));
        if (!$kodesParam) {
            return redirect()->route('home');
        }

        $kodes = array_filter(array_map('trim', explode(',', $kodesParam)));
        $bookings = Booking::with('room')->whereIn('kode_booking', $kodes)->get();

        if ($bookings->isEmpty()) {
            return redirect()->route('home');
        }

        $booking = $bookings->first();

        return view('booking-success', compact('bookings', 'booking'));
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

        $searchCode = trim(strtoupper($request->kode_booking));

        $booking = Booking::with(['room', 'histories.admin'])
            ->where('kode_booking', $searchCode)
            ->orWhere('group_code', $searchCode)
            ->first();

        if (!$booking) {
            return back()->withErrors([
                'kode_booking' => 'Kode booking tidak ditemukan. Pastikan kode yang Anda masukkan benar.'
            ])->withInput();
        }

        $groupBookings = Booking::with(['room', 'histories.admin'])
            ->where('group_code', $booking->group_code)
            ->get();

        return view('cek-booking', compact('booking', 'groupBookings'));
    }
}
