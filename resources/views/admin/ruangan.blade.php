@extends('layouts.admin')

@section('title', 'Data Ruangan - Admin SIPERON')

@section('content')
    <div class="page-header-row">
        <div>
            <div class="page-title">Data Ruangan</div>
            <p class="page-subtitle">Kelola informasi ruangan yang tersedia untuk dipinjam</p>
        </div>
        <a href="#" class="btn btn-primary" data-modal-target="modalTambahRuangan">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Tambah Ruangan
        </a>
    </div>

    @if(session('success'))
        <div style="padding: 0.75rem 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="padding: 0.75rem 1rem; background: #fee2e2; color: #b91c1c; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem;">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Room Stats -->
    <div class="room-stats-row">
        <div class="room-stat-chip">
            <span class="chip-dot dot-all"></span>
            Total: <strong>{{ $stats['total'] }}</strong>
        </div>
        <div class="room-stat-chip">
            <span class="chip-dot dot-available"></span>
            Tersedia: <strong>{{ $stats['active'] }}</strong>
        </div>
        <div class="room-stat-chip">
            <span class="chip-dot dot-used"></span>
            Dipakai Hari Ini: <strong>{{ $stats['in_use_today'] }}</strong>
        </div>
        <div class="room-stat-chip">
            <span class="chip-dot dot-maintenance"></span>
            Nonaktif: <strong>{{ $stats['inactive'] }}</strong>
        </div>
    </div>

    <!-- Room Cards Grid -->
    <div class="room-grid">
        @forelse($rooms as $room)
        <div class="room-card">
            <div class="room-card-img">
                @if($room->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($room->image))
                    <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div class="room-img-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" /></svg>
                    </div>
                @endif
                @if($room->is_active)
                    @if($room->active_booking_count > 0)
                        <span class="room-status-tag tag-used">Dipakai</span>
                    @else
                        <span class="room-status-tag tag-available">Tersedia</span>
                    @endif
                @else
                    <span class="room-status-tag tag-maintenance">Nonaktif</span>
                @endif
            </div>
            <div class="room-card-body">
                <h3 class="room-name">{{ $room->name }}</h3>
                <div class="room-meta">
                    <div class="meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                        <span>{{ $room->capacity }} Orang</span>
                    </div>
                </div>
                @if($room->facilities)
                <div class="room-facilities">
                    @foreach(explode(',', $room->facilities) as $facility)
                        <span class="facility-tag">{{ trim($facility) }}</span>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="room-card-footer">
                <button class="btn-sm btn-sm-outline" title="Edit" data-modal-target="modalEditRuangan{{ $room->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                    Edit
                </button>
                <form action="{{ route('admin.ruangan.destroy', $room) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus ruangan {{ $room->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sm btn-sm-danger" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: var(--text-muted);">
            <p>Belum ada ruangan. Klik "Tambah Ruangan" untuk menambahkan.</p>
        </div>
        @endforelse
    </div>

    <!-- ============ MODALS ============ -->

    <!-- Modal Tambah Ruangan -->
    <div class="modal-backdrop" id="modalTambahRuangan">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Form Tambah Ruangan</h3>
                <button class="modal-close" data-modal-close>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form action="{{ route('admin.ruangan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Ruangan</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Ruang Rapat Utama (Bhirawa)" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Kapasitas (Orang)</label>
                            <input type="number" name="capacity" class="form-control" placeholder="0" min="1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Fasilitas Ruangan</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-top: 0.5rem;">
                            @foreach(['AC', 'Proyektor', 'Sound System', 'WiFi', 'Whiteboard', 'Panggung', 'LED TV', 'Meja Besar'] as $fac)
                            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; color: var(--text-main); cursor: pointer;">
                                <input type="checkbox" name="facilities[]" value="{{ $fac }}" style="width: 16px; height: 16px; accent-color: var(--bakorwil-cyan);"> {{ $fac }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Deskripsi singkat ruangan..."></textarea>
                    </div>
                    
                    <div class="form-group" style="margin-top: 1rem;">
                        <label class="form-label">Foto Ruangan (Opsional)</label>
                        <input type="file" name="image" class="form-control" accept="image/png, image/jpeg">
                        <p class="form-help">Format: JPG, PNG. Maks 20MB.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Ruangan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit per Ruangan -->
    @foreach($rooms as $room)
    <div class="modal-backdrop" id="modalEditRuangan{{ $room->id }}">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Edit Ruangan: {{ $room->name }}</h3>
                <button class="modal-close" data-modal-close>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form action="{{ route('admin.ruangan.update', $room) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Ruangan</label>
                        <input type="text" name="name" class="form-control" value="{{ $room->name }}" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Kapasitas (Orang)</label>
                            <input type="number" name="capacity" class="form-control" value="{{ $room->capacity }}" min="1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; color: var(--text-main); cursor: pointer; margin-top: 0.5rem;">
                            <input type="checkbox" name="is_active" value="1" {{ $room->is_active ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: var(--bakorwil-cyan);"> Aktif (tersedia untuk dipinjam)
                        </label>
                    </div>

                    @php
                        $currentFacilities = $room->facilities ? array_map('trim', explode(',', $room->facilities)) : [];
                        $allFacilities = ['AC', 'Proyektor', 'Sound System', 'WiFi', 'Whiteboard', 'Panggung', 'LED TV', 'Meja Besar', 'Meja Rapat', 'Layar LED', 'Layar Presentasi', 'Pendingin Ruangan', 'Colokan Listrik', 'WiFi Cepat', 'Area Santai', 'Layar Monitoring', 'Perangkat Command Center', 'Meja Kerja Bersama'];
                        
                        foreach($currentFacilities as $cf) {
                            if (!in_array($cf, $allFacilities)) {
                                $allFacilities[] = $cf;
                            }
                        }
                    @endphp

                    <div class="form-group">
                        <label class="form-label">Fasilitas Ruangan</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-top: 0.5rem;">
                            @foreach($allFacilities as $fac)
                                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; color: var(--text-main); cursor: pointer;">
                                    <input type="checkbox" name="facilities[]" value="{{ $fac }}" {{ in_array($fac, $currentFacilities) ? 'checked' : '' }} style="width: 16px; height: 16px; accent-color: var(--bakorwil-cyan);"> {{ $fac }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control" rows="2">{{ $room->description }}</textarea>
                    </div>
                    
                    <div class="form-group" style="margin-top: 1rem;">
                        <label class="form-label">Foto Ruangan (Ganti foto lama jika ada)</label>
                        <input type="file" name="image" class="form-control" accept="image/png, image/jpeg">
                        <p class="form-help">Format: JPG, PNG. Maks 20MB. Biarkan kosong jika tidak ingin mengganti.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
@endsection
