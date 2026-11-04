<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingHistory;
use App\Models\Room;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Tampilkan daftar peminjaman dengan filter status (dikelompokkan per pengajuan/group_code).
     */
    public function index(Request $request)
    {
        // Auto update status 'disetujui' menjadi 'selesai' jika tanggalnya sudah lewat
        Booking::where('status', 'disetujui')
            ->whereDate('tanggal', '<', now()->toDateString())
            ->update(['status' => 'selesai']);

        $status = $request->get('status');
        $search = $request->get('search');

        $query = Booking::query();

        // Filter status
        if ($status && in_array($status, ['pending', 'disetujui', 'ditolak', 'dijadwalkan_ulang', 'selesai'])) {
            $query->where('status', $status);
        }

        // Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('instansi', 'like', "%{$search}%")
                  ->orWhere('nama_kegiatan', 'like', "%{$search}%")
                  ->orWhere('kode_booking', 'like', "%{$search}%")
                  ->orWhere('group_code', 'like', "%{$search}%");
            });
        }

        // Ambil group_code unik terbaru (mengelompokkan multi-booking dalam 1 pengajuan)
        $groupCodesQuery = $query->select('group_code', DB::raw('MAX(id) as max_id'))
            ->whereNotNull('group_code')
            ->groupBy('group_code')
            ->orderByDesc('max_id');

        $paginatedGroups = $groupCodesQuery->paginate(10);
        $groupCodes = $paginatedGroups->pluck('group_code')->toArray();

        // Ambil semua booking untuk group_code di halaman ini
        $allBookings = Booking::with(['room', 'admin'])
            ->whereIn('group_code', $groupCodes)
            ->orderBy('id', 'asc')
            ->get();

        $groupedBookings = $allBookings->groupBy('group_code');

        // Hitung per status untuk tab counts (berdasarkan unik paket pengajuan)
        $counts = [
            'all'                 => Booking::distinct('group_code')->count('group_code'),
            'pending'             => Booking::where('status', 'pending')->distinct('group_code')->count('group_code'),
            'disetujui'           => Booking::where('status', 'disetujui')->distinct('group_code')->count('group_code'),
            'dijadwalkan_ulang'   => Booking::where('status', 'dijadwalkan_ulang')->distinct('group_code')->count('group_code'),
            'ditolak'             => Booking::where('status', 'ditolak')->distinct('group_code')->count('group_code'),
            'selesai'             => Booking::where('status', 'selesai')->distinct('group_code')->count('group_code'),
        ];

        $rooms = Room::where('is_active', true)->orderBy('name')->get();

        return view('admin.peminjaman', compact('paginatedGroups', 'groupedBookings', 'counts', 'rooms', 'status'));
    }

    /**
     * Tampilkan detail booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['room', 'histories.admin', 'admin']);

        // Load semua booking dalam grup / pengajuan yang sama
        $groupBookings = Booking::with(['room', 'histories.admin', 'admin'])
            ->where('group_code', $booking->group_code)
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.peminjaman-detail', compact('booking', 'groupBookings'));
    }

    /**
     * Setujui atau tolak seluruh ruangan dalam 1 paket pengajuan (group_code) sekaligus.
     */
    public function updateGroupStatus(Request $request, string $group_code)
    {
        $data = $request->validate([
            'status'  => 'required|in:pending,disetujui,ditolak,selesai',
            'catatan' => 'nullable|string',
        ]);

        $bookings = Booking::with('room')->where('group_code', $group_code)->get();

        if ($bookings->isEmpty()) {
            return back()->withErrors(['msg' => 'Data pengajuan tidak ditemukan.']);
        }

        $statusBaru = $data['status'];
        $catatan = $data['catatan'] ?? null;
        $updatedBookings = collect();

        DB::transaction(function () use ($bookings, $statusBaru, $catatan, &$updatedBookings) {
            foreach ($bookings as $b) {
                $oldStatus = $b->status;
                $updateData = [
                    'status'  => $statusBaru,
                    'catatan' => $catatan ?: $b->catatan,
                ];

                if ($statusBaru === 'disetujui') {
                    $updateData['admin_id'] = auth()->id();
                    $updateData['approved_at'] = now();
                }

                $b->update($updateData);

                BookingHistory::create([
                    'booking_id'         => $b->id,
                    'status_sebelumnya'  => $oldStatus,
                    'status_baru'        => $statusBaru,
                    'tanggal_sebelumnya' => $b->tanggal,
                    'perubahan'          => $catatan ?: ("Status diubah menjadi {$statusBaru} sekaligus oleh admin"),
                    'admin_id'           => auth()->id(),
                ]);

                $updatedBookings->push($b);
            }
        });

        // Kirim 1 notifikasi terkonsolidasi ke pemohon
        try {
            $notificationService = new NotificationService();
            $notificationService->notifyPemohonGroupStatusChange($updatedBookings, $statusBaru, $catatan);
        } catch (\Throwable $e) {
            \Log::error("Gagal mengirim notifikasi update group status: " . $e->getMessage());
        }

        $label = ucfirst(str_replace('_', ' ', $statusBaru));
        $count = $updatedBookings->count();
        $first = $updatedBookings->first();

        // Siapkan tautan WhatsApp manual dengan template resmi terisi otomatis
        $waMessage = \App\Services\WhatsAppService::buildConfirmationMessage($updatedBookings, $statusBaru, $catatan);
        $waUrl = \App\Services\WhatsAppService::generateWaLink($first->no_whatsapp, $waMessage);

        $waConfirm = [
            'url'         => $waUrl,
            'phone'       => $first->no_whatsapp,
            'nama'        => $first->nama_pemohon,
            'instansi'    => $first->instansi,
            'status'      => $statusBaru,
            'message'     => $waMessage,
            'room_count'  => $count,
            'group_code'  => $group_code,
        ];

        return back()
            ->with('success', "Seluruh pengajuan ({$count} ruangan) berhasil diperbarui menjadi {$label}.")
            ->with('wa_confirm', $waConfirm);
    }

    /**
     * Hapus seluruh data peminjaman dalam satu kelompok pengajuan.
     */
    public function destroyGroup(string $group_code)
    {
        $bookings = Booking::where('group_code', $group_code)->get();
        $count = $bookings->count();

        foreach ($bookings as $b) {
            $b->delete();
        }

        return back()->with('success', "Data pengajuan ({$count} ruangan) berhasil dihapus.");
    }

    /**
     * Simpan peminjaman baru dari admin.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'        => 'required|exists:rooms,id',
            'nama_pemohon'   => 'required|string|max:255',
            'instansi'       => 'nullable|string|max:255',
            'no_whatsapp'    => 'required|string|max:20',
            'email'          => 'required|email|max:255',
            'nama_kegiatan'  => 'required|string|max:255',
            'jumlah_peserta' => 'nullable|integer|min:1',
            'tanggal'        => 'required|date',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required|after:jam_mulai',
            'catatan'        => 'nullable|string',
            'status'         => 'nullable|in:pending,disetujui,ditolak,selesai',
        ]);

        $data['status'] = $data['status'] ?? 'pending';
        $data['kode_booking'] = Booking::generateKodeBooking();
        $data['group_code']   = $data['kode_booking'];
        $data['kontak'] = $data['no_whatsapp'];

        if ($data['status'] === 'disetujui') {
            $data['admin_id'] = auth()->id();
            $data['approved_at'] = now();
        }

        $booking = Booking::create($data);

        // Catat riwayat
        BookingHistory::create([
            'booking_id'       => $booking->id,
            'status_sebelumnya' => null,
            'status_baru'      => $data['status'],
            'tanggal_baru'     => $booking->tanggal,
            'perubahan'        => 'Peminjaman dibuat oleh admin',
            'admin_id'         => auth()->id(),
        ]);

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan. Kode: ' . $booking->kode_booking);
    }

    /**
     * Update status peminjaman individual (setujui / tolak 1 ruangan).
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'status'  => 'required|in:pending,disetujui,ditolak,selesai',
            'catatan' => 'nullable|string',
        ]);

        $oldStatus = $booking->status;

        if ($data['status'] === 'disetujui') {
            $data['admin_id'] = auth()->id();
            $data['approved_at'] = now();
        }

        $booking->update($data);

        // Catat riwayat
        BookingHistory::create([
            'booking_id'        => $booking->id,
            'status_sebelumnya' => $oldStatus,
            'status_baru'       => $data['status'],
            'tanggal_sebelumnya' => $booking->tanggal,
            'perubahan'         => $data['catatan'] ?? null,
            'admin_id'          => auth()->id(),
        ]);

        // Notifikasi ke pemohon
        $notificationService = new NotificationService();
        $notificationService->notifyPemohonStatusChange($booking, $data['status'], $data['catatan'] ?? null);

        // Siapkan tautan WhatsApp manual dengan template resmi terisi otomatis
        $waMessage = \App\Services\WhatsAppService::buildConfirmationMessage(collect([$booking]), $data['status'], $data['catatan'] ?? null);
        $waUrl = \App\Services\WhatsAppService::generateWaLink($booking->no_whatsapp, $waMessage);

        $waConfirm = [
            'url'         => $waUrl,
            'phone'       => $booking->no_whatsapp,
            'nama'        => $booking->nama_pemohon,
            'instansi'    => $booking->instansi,
            'status'      => $data['status'],
            'message'     => $waMessage,
            'room_count'  => 1,
            'kode_booking'=> $booking->kode_booking,
        ];

        return redirect()
            ->back()
            ->with('success', 'Status peminjaman ' . $booking->kode_booking . ' berhasil diubah menjadi ' . ucfirst(str_replace('_', ' ', $data['status'])) . '.')
            ->with('wa_confirm', $waConfirm);
    }

    /**
     * Minta penjadwalan ulang individual.
     */
    public function reschedule(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'alasan' => 'required|string|max:1000',
        ]);

        $oldStatus = $booking->status;

        // Update status booking
        $booking->update([
            'status' => 'dijadwalkan_ulang',
        ]);

        // Catat riwayat
        BookingHistory::create([
            'booking_id'            => $booking->id,
            'status_sebelumnya'     => $oldStatus,
            'status_baru'           => 'dijadwalkan_ulang',
            'tanggal_sebelumnya'    => $booking->tanggal,
            'jam_mulai_sebelumnya'  => $booking->jam_mulai,
            'jam_selesai_sebelumnya' => $booking->jam_selesai,
            'alasan'                => $data['alasan'],
            'perubahan'             => 'Diminta penjadwalan ulang karena kegiatan prioritas instansi',
            'admin_id'              => auth()->id(),
        ]);

        // Notifikasi ke pemohon
        $notificationService = new NotificationService();
        $notificationService->notifyPemohonStatusChange($booking, 'dijadwalkan_ulang', $data['alasan']);

        // Siapkan tautan WhatsApp manual dengan template resmi terisi otomatis
        $waMessage = \App\Services\WhatsAppService::buildConfirmationMessage(collect([$booking]), 'dijadwalkan_ulang', $data['alasan']);
        $waUrl = \App\Services\WhatsAppService::generateWaLink($booking->no_whatsapp, $waMessage);

        $waConfirm = [
            'url'         => $waUrl,
            'phone'       => $booking->no_whatsapp,
            'nama'        => $booking->nama_pemohon,
            'instansi'    => $booking->instansi,
            'status'      => 'dijadwalkan_ulang',
            'message'     => $waMessage,
            'room_count'  => 1,
            'kode_booking'=> $booking->kode_booking,
        ];

        return redirect()
            ->back()
            ->with('success', 'Booking ' . $booking->kode_booking . ' telah diminta penjadwalan ulang.')
            ->with('wa_confirm', $waConfirm);
    }

    /**
     * Hapus data peminjaman individual.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()
            ->back()
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
