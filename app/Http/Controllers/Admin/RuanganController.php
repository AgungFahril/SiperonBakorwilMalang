<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RuanganController extends Controller
{
    /**
     * Tampilkan semua ruangan.
     */
    public function index()
    {
        $rooms = Room::withCount([
            'bookings as active_booking_count' => function ($q) {
                $q->where('status', 'disetujui')
                  ->whereDate('tanggal', today());
            }
        ])->orderBy('name')->get();

        $stats = [
            'total'        => $rooms->count(),
            'active'       => $rooms->where('is_active', true)->count(),
            'inactive'     => $rooms->where('is_active', false)->count(),
            'in_use_today' => $rooms->where('active_booking_count', '>', 0)->count(),
        ];

        return view('admin.ruangan', compact('rooms', 'stats'));
    }

    /**
     * Simpan ruangan baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'facilities'  => 'nullable|array',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
            'is_active'   => 'nullable|boolean',
        ]);

        // Handle facilities: array → comma string
        $data['facilities'] = isset($data['facilities'])
            ? implode(', ', $data['facilities'])
            : null;

        $data['is_active'] = $request->has('is_active') ? true : true; // default aktif
        $data['slug'] = Str::slug($data['name']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        Room::create($data);

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil ditambahkan.');
    }

    /**
     * Update data ruangan.
     */
    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'facilities'  => 'nullable|array',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['facilities'] = isset($data['facilities'])
            ? implode(', ', $data['facilities'])
            : null;

        $data['is_active'] = $request->has('is_active') ? true : false;
        $data['slug'] = Str::slug($data['name']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        $room->update($data);

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil diperbarui.');
    }

    /**
     * Hapus ruangan.
     */
    public function destroy(Room $room)
    {
        // Hapus gambar jika ada
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil dihapus.');
    }
}
