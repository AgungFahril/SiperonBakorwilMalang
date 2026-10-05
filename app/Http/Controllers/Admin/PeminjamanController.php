<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
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

        $status = $request->get('status'); // pending|disetujui|ditolak|selesai

        $query = Booking::with('room')->latest();

        if ($status && in_array($status, ['pending', 'disetujui', 'ditolak', 'selesai'])) {
            $query->where('status', $status);
        }

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('instansi', 'like', "%{$search}%")
                  ->orWhere('nama_kegiatan', 'like', "%{$search}%");
            });
        }

        $bookings = $query->paginate(10);

        // Hitung per status untuk tab counts
        $counts = [
            'all'       => Booking::count(),
            'pending'   => Booking::where('status', 'pending')->count(),
            'disetujui' => Booking::where('status', 'disetujui')->count(),
            'ditolak'   => Booking::where('status', 'ditolak')->count(),
            'selesai'   => Booking::where('status', 'selesai')->count(),
        ];

        $rooms = Room::where('is_active', true)->orderBy('name')->get();

        return view('admin.peminjaman', compact('bookings', 'counts', 'rooms', 'status'));
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
            'kontak'         => 'nullable|string|max:50',
            'nama_kegiatan'  => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required|after:jam_mulai',
            'catatan'        => 'nullable|string',
            'status'         => 'nullable|in:pending,disetujui,ditolak,selesai',
        ]);

        $data['status'] = $data['status'] ?? 'pending';

        Booking::create($data);

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan.');
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

        $booking->update($data);

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Status peminjaman berhasil diubah.');
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
