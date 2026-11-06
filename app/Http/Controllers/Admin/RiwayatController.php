<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Tampilkan halaman riwayat penggunaan ruangan dengan filter bulanan dan kalkulasi jam pemakaian.
     */
    public function index(Request $request)
    {
        Carbon::setLocale('id');

        // Otomatis ubah status disetujui yang tanggalnya sudah lewat menjadi selesai
        Booking::where('status', 'disetujui')
            ->whereDate('tanggal', '<', now()->toDateString())
            ->update(['status' => 'selesai']);

        // Filter Bulan (format: YYYY-MM)
        $selectedMonthStr = $request->input('bulan', now()->format('Y-m'));
        try {
            $selectedMonth = Carbon::createFromFormat('Y-m', $selectedMonthStr)->startOfMonth();
        } catch (\Exception $e) {
            $selectedMonth = now()->startOfMonth();
            $selectedMonthStr = $selectedMonth->format('Y-m');
        }

        $startOfMonth = $selectedMonth->copy()->startOfMonth()->toDateString();
        $endOfMonth = $selectedMonth->copy()->endOfMonth()->toDateString();

        $prevMonth = $selectedMonth->copy()->subMonth()->format('Y-m');
        $nextMonth = $selectedMonth->copy()->addMonth()->format('Y-m');

        // Filter Tambahan (Ruangan, Status, Pencarian)
        $roomId = $request->input('room_id');
        $statusFilter = $request->input('status', 'digunakan'); // default: disetujui & selesai
        $search = $request->input('search');

        // Base Query
        $query = Booking::with('room')
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth]);

        // Filter Status
        if ($statusFilter === 'digunakan' || empty($statusFilter)) {
            $query->whereIn('status', ['disetujui', 'selesai']);
        } elseif ($statusFilter === 'disetujui') {
            $query->where('status', 'disetujui');
        } elseif ($statusFilter === 'selesai') {
            $query->where('status', 'selesai');
        } elseif ($statusFilter === 'dijadwalkan_ulang') {
            $query->where('status', 'dijadwalkan_ulang');
        } elseif ($statusFilter === 'ditolak') {
            $query->where('status', 'ditolak');
        } elseif ($statusFilter === 'all') {
            // Semua status tanpa filter status
        }

        // Filter Ruangan
        if (!empty($roomId)) {
            $query->where('room_id', $roomId);
        }

        // Filter Pencarian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kegiatan', 'like', "%{$search}%")
                  ->orWhere('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('instansi', 'like', "%{$search}%")
                  ->orWhere('kode_booking', 'like', "%{$search}%");
            });
        }

        $bookings = $query->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Hitung akumulasi jam per kegiatan, per hari, dan total bulanan
        $totalMonthlyMinutes = 0;
        $roomUsage = []; // Rekapitulasi per ruangan
        $dailyData = []; // Kelompok data per tanggal

        foreach ($bookings as $booking) {
            $startTime = Carbon::parse($booking->jam_mulai);
            $endTime = Carbon::parse($booking->jam_selesai);

            $diffMinutes = max(0, $startTime->diffInMinutes($endTime, false));
            $diffHours = round($diffMinutes / 60, 2);

            $booking->durasi_menit = $diffMinutes;
            $booking->durasi_jam = $diffHours;
            $booking->durasi_label = $this->formatDuration($diffMinutes);

            $totalMonthlyMinutes += $diffMinutes;

            // Statistik per ruangan
            $roomName = $booking->room->name ?? 'Ruangan Dihapus';
            $roomIdVal = $booking->room_id ?? 0;
            if (!isset($roomUsage[$roomIdVal])) {
                $roomUsage[$roomIdVal] = [
                    'id' => $roomIdVal,
                    'name' => $roomName,
                    'minutes' => 0,
                    'hours' => 0,
                    'formatted_hours' => '0 Jam',
                    'count' => 0,
                ];
            }
            $roomUsage[$roomIdVal]['minutes'] += $diffMinutes;
            $roomUsage[$roomIdVal]['hours'] = round($roomUsage[$roomIdVal]['minutes'] / 60, 2);
            $roomUsage[$roomIdVal]['formatted_hours'] = $this->formatDuration($roomUsage[$roomIdVal]['minutes']);
            $roomUsage[$roomIdVal]['count']++;

            // Kelompokkan per tanggal
            $dateKey = $booking->tanggal->format('Y-m-d');
            if (!isset($dailyData[$dateKey])) {
                $dailyData[$dateKey] = [
                    'date' => $booking->tanggal,
                    'date_string' => $dateKey,
                    'day_name' => $booking->tanggal->locale('id')->translatedFormat('l'),
                    'formatted_date' => $booking->tanggal->locale('id')->translatedFormat('d F Y'),
                    'total_minutes' => 0,
                    'total_hours' => 0,
                    'total_label' => '',
                    'bookings' => [],
                    'rooms_used' => [],
                ];
            }

            $dailyData[$dateKey]['total_minutes'] += $diffMinutes;
            $dailyData[$dateKey]['bookings'][] = $booking;
            if (!in_array($roomName, $dailyData[$dateKey]['rooms_used'])) {
                $dailyData[$dateKey]['rooms_used'][] = $roomName;
            }
        }

        // Finalisasi data harian
        foreach ($dailyData as $key => &$day) {
            $day['total_hours'] = round($day['total_minutes'] / 60, 2);
            $day['total_label'] = $this->formatDuration($day['total_minutes']);
        }
        unset($day);

        // Urutkan statistik ruangan dari yang paling banyak terpakai
        uasort($roomUsage, function ($a, $b) {
            return $b['minutes'] <=> $a['minutes'];
        });

        // Ringkasan Bulanan
        $totalMonthlyHours = round($totalMonthlyMinutes / 60, 2);
        $totalMonthlyLabel = $this->formatDuration($totalMonthlyMinutes);
        $totalDaysUsed = count($dailyData);
        $totalBookingsCount = $bookings->count();
        $topRoom = !empty($roomUsage) ? reset($roomUsage) : null;

        // Daftar semua ruangan untuk dropdown filter
        $allRooms = Room::orderBy('name')->get();

        return view('admin.riwayat', compact(
            'bookings',
            'dailyData',
            'selectedMonth',
            'selectedMonthStr',
            'prevMonth',
            'nextMonth',
            'roomId',
            'statusFilter',
            'search',
            'totalMonthlyMinutes',
            'totalMonthlyHours',
            'totalMonthlyLabel',
            'totalDaysUsed',
            'totalBookingsCount',
            'roomUsage',
            'topRoom',
            'allRooms'
        ));
    }

    /**
     * Format durasi dari total menit ke representasi teks yang mudah dipahami.
     */
    private function formatDuration(int $minutes): string
    {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        if ($hours > 0 && $remainingMinutes > 0) {
            return "{$hours} Jam {$remainingMinutes} Menit";
        } elseif ($hours > 0) {
            return "{$hours} Jam";
        } else {
            return "{$remainingMinutes} Menit";
        }
    }
}
