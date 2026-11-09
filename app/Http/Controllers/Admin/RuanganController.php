<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RuanganController extends Controller
{
    /**
     * Tampilkan semua ruangan beserta foto dan fasilitasnya.
     */
    public function index()
    {
        $rooms = Room::with(['images'])->withCount([
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
     * Proses fasilitas (bisa berupa array atau teks koma).
     */
    protected function processFacilities($facilitiesInput): ?string
    {
        if (is_array($facilitiesInput)) {
            $cleaned = array_filter(array_map('trim', $facilitiesInput));
            return !empty($cleaned) ? implode(', ', $cleaned) : null;
        }

        if (is_string($facilitiesInput)) {
            $parts = explode(',', $facilitiesInput);
            $cleaned = array_filter(array_map('trim', $parts));
            return !empty($cleaned) ? implode(', ', $cleaned) : null;
        }

        return null;
    }

    /**
     * Simpan ruangan baru beserta multi-gambar.
     */
    public function store(Request $request)
    {
        // Deteksi berkas HEIC/HEIF dari HP/iPhone dan berikan peringatan edukatif yang jelas
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $f) {
                if ($f) {
                    $ext = strtolower($f->getClientOriginalExtension());
                    if (in_array($ext, ['heic', 'heif'])) {
                        return back()->withInput()->withErrors([
                            'images' => 'Foto "' . $f->getClientOriginalName() . '" berformat HEIC (format bawaan kamera iPhone/HP). Mohon simpan/ekspor foto tersebut ke format JPG atau PNG terlebih dahulu sebelum diunggah.'
                        ]);
                    }
                }
            }
        }

        $rules = [
            'name'         => 'required|string|max:255',
            'capacity'     => 'required|integer|min:1',
            'facilities'   => 'nullable',
            'description'  => 'nullable|string',
            'images'       => 'nullable|array',
            'images.*'     => 'file|mimes:jpg,jpeg,png,webp,jfif,avif,bmp|max:20480',
            'image'        => 'nullable|file|mimes:jpg,jpeg,png,webp,jfif,avif,bmp|max:20480',
            'is_active'    => 'nullable|boolean',
        ];

        $messages = [
            'name.required'       => 'Nama ruangan wajib diisi.',
            'capacity.required'   => 'Kapasitas ruangan wajib diisi.',
            'capacity.min'        => 'Kapasitas ruangan minimal 1 orang.',
            'images.array'        => 'Format daftar foto ruangan tidak valid.',
            'images.*.file'       => 'Berkas foto harus berupa file yang valid.',
            'images.*.mimes'      => 'Foto ruangan harus berformat gambar (JPG, JPEG, PNG, atau WEBP).',
            'images.*.max'        => 'Ukuran masing-masing foto tidak boleh melebihi 20MB.',
            'image.file'          => 'Berkas foto utama harus berupa file yang valid.',
            'image.mimes'         => 'Foto utama harus berformat gambar (JPG, JPEG, PNG, atau WEBP).',
            'image.max'           => 'Ukuran foto utama tidak boleh melebihi 20MB.',
        ];

        $data = $request->validate($rules, $messages);

        $data['facilities'] = $this->processFacilities($request->input('facilities'));
        $data['is_active'] = $request->has('is_active') ? true : true; // default aktif
        $data['slug'] = Str::slug($data['name']);

        // Hilangkan images dari data create room
        unset($data['images']);

        $room = Room::create($data);

        // Upload multiple images
        if ($request->hasFile('images')) {
            $firstPath = null;
            foreach ($request->file('images') as $idx => $file) {
                $path = $file->store('rooms', 'public');
                $room->images()->create([
                    'path'       => $path,
                    'sort_order' => $idx,
                ]);
                if (!$firstPath) {
                    $firstPath = $path;
                }
            }
            if ($firstPath) {
                $room->update(['image' => $firstPath]);
            }
        } elseif ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public');
            $room->images()->create([
                'path'       => $path,
                'sort_order' => 0,
            ]);
            $room->update(['image' => $path]);
        }

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil ditambahkan.');
    }

    /**
     * Update data ruangan & tambah foto baru.
     */
    public function update(Request $request, Room $room)
    {
        // Deteksi berkas HEIC/HEIF dari HP/iPhone dan berikan peringatan edukatif yang jelas
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $f) {
                if ($f) {
                    $ext = strtolower($f->getClientOriginalExtension());
                    if (in_array($ext, ['heic', 'heif'])) {
                        return back()->withInput()->withErrors([
                            'images' => 'Foto "' . $f->getClientOriginalName() . '" berformat HEIC (format bawaan kamera iPhone/HP). Mohon simpan/ekspor foto tersebut ke format JPG atau PNG terlebih dahulu sebelum diunggah.'
                        ]);
                    }
                }
            }
        }

        $rules = [
            'name'         => 'required|string|max:255',
            'capacity'     => 'required|integer|min:1',
            'facilities'   => 'nullable',
            'description'  => 'nullable|string',
            'images'       => 'nullable|array',
            'images.*'     => 'file|mimes:jpg,jpeg,png,webp,jfif,avif,bmp|max:20480',
            'image'        => 'nullable|file|mimes:jpg,jpeg,png,webp,jfif,avif,bmp|max:20480',
            'is_active'    => 'nullable|boolean',
        ];

        $messages = [
            'name.required'       => 'Nama ruangan wajib diisi.',
            'capacity.required'   => 'Kapasitas ruangan wajib diisi.',
            'capacity.min'        => 'Kapasitas ruangan minimal 1 orang.',
            'images.array'        => 'Format daftar foto ruangan tidak valid.',
            'images.*.file'       => 'Berkas foto harus berupa file yang valid.',
            'images.*.mimes'      => 'Foto ruangan harus berformat gambar (JPG, JPEG, PNG, atau WEBP).',
            'images.*.max'        => 'Ukuran masing-masing foto tidak boleh melebihi 20MB.',
            'image.file'          => 'Berkas foto utama harus berupa file yang valid.',
            'image.mimes'         => 'Foto utama harus berformat gambar (JPG, JPEG, PNG, atau WEBP).',
            'image.max'           => 'Ukuran foto utama tidak boleh melebihi 20MB.',
        ];

        $data = $request->validate($rules, $messages);

        $data['facilities'] = $this->processFacilities($request->input('facilities'));
        $data['is_active'] = $request->has('is_active') ? true : false;
        $data['slug'] = Str::slug($data['name']);

        unset($data['images']);

        $room->update($data);

        // Handle upload foto-foto baru (ditambahkan ke koleksi foto ruangan)
        if ($request->hasFile('images')) {
            $maxOrder = $room->images()->max('sort_order') ?? -1;
            foreach ($request->file('images') as $file) {
                $maxOrder++;
                $path = $file->store('rooms', 'public');
                $room->images()->create([
                    'path'       => $path,
                    'sort_order' => $maxOrder,
                ]);
                // Jika belum ada foto utama, jadikan foto ini foto utama
                if (empty($room->image)) {
                    $room->update(['image' => $path]);
                }
            }
        } elseif ($request->hasFile('image')) {
            $maxOrder = ($room->images()->max('sort_order') ?? -1) + 1;
            $path = $request->file('image')->store('rooms', 'public');
            $room->images()->create([
                'path'       => $path,
                'sort_order' => $maxOrder,
            ]);
            if (empty($room->image)) {
                $room->update(['image' => $path]);
            }
        }

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil diperbarui.');
    }

    /**
     * Hapus satu foto dari ruangan.
     */
    public function destroyImage(Request $request, RoomImage $image)
    {
        $room = $image->room;
        $deletedPath = $image->path;

        if (Storage::disk('public')->exists($deletedPath)) {
            Storage::disk('public')->delete($deletedPath);
        }

        $image->delete();

        // Jika foto yang dihapus adalah foto utama ruangan, perbarui ke foto lain yang ada
        if ($room->image === $deletedPath) {
            $nextImage = $room->images()->first();
            $room->update(['image' => $nextImage ? $nextImage->path : null]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus.',
                'remaining' => $room->images()->count(),
            ]);
        }

        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }

    /**
     * Hapus ruangan beserta semua fotonya.
     */
    public function destroy(Room $room)
    {
        // Hapus semua file foto dari storage
        foreach ($room->images as $img) {
            if (Storage::disk('public')->exists($img->path)) {
                Storage::disk('public')->delete($img->path);
            }
        }
        $room->images()->delete();

        // Hapus fallback image jika berbeda
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil dihapus.');
    }
}
