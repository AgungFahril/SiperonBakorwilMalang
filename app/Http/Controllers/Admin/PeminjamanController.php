<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingHistory;
use App\Models\Room;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Tampilkan daftar peminjaman dengan filter status.
     */
    public function index(Request $request)
    {
        // Auto update status 'disetujui' menjadi 'selesai' jika tanggalnya sudah lewat
        Booking::where('status', 'disetujui')
            ->whereDate('tanggal', '<', now()->toDateString())
            ->update(['status' => 'selesai']);

        $status = $request->get('status');

        $query = Booking::with('room')->latest();

        if ($status && in_array($status, ['pending', 'disetujui', 'ditolak', 'dijadwalkan_ulang', 'selesai'])) {
            $query->where('status', $status);
        }

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('instansi', 'like', "%{$search}%")
                  ->orWhere('nama_kegiatan', 'like', "%{$search}%")
                  ->orWhere('kode_booking', 'like', "%{$search}%");
            });
        }

        $bookings = $query->paginate(10);

        // Hitung per status untuk tab counts
        $counts = [
            'all'                 => Booking::count(),
            'pending'             => Booking::where('status', 'pending')->count(),
            'disetujui'           => Booking::where('status', 'disetujui')->count(),
            'dijadwalkan_ulang'   => Booking::where('status', 'dijadwalkan_ulang')->count(),
            'ditolak'             => Booking::where('status', 'ditolak')->count(),
            'selesai'             => Booking::where('status', 'selesai')->count(),
        ];

        $rooms = Room::where('is_active', true)->orderBy('name')->get();

        return view('admin.peminjaman', compact('bookings', 'counts', 'rooms', 'status'));
    }

    /**
     * Tampilkan detail booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['room', 'histories.admin', 'admin']);
        return view('admin.peminjaman-detail', compact('booking'));
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
            'tanggal'        => 'required|date',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required|after:jam_mulai',
            'catatan'        => 'nullable|string',
            'status'         => 'nullable|in:pending,disetujui,ditolak,selesai',
        ]);

        $data['status'] = $data['status'] ?? 'pending';
        $data['kode_booking'] = Booking::generateKodeBooking();
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
     * Update status peminjaman (setujui / tolak).
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

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Status peminjaman berhasil diubah menjadi ' . ucfirst(str_replace('_', ' ', $data['status'])) . '.');
    }

    /**
     * Minta penjadwalan ulang.
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

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Booking ' . $booking->kode_booking . ' telah diminta penjadwalan ulang.');
    }

    /**
     * Hapus data peminjaman.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
