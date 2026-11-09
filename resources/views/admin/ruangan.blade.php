@extends('layouts.admin')

@section('title', 'Data Ruangan - Admin SIPERON')

@section('content')
    <div class="page-header-row">
        <div>
            <div class="page-title">Data Ruangan</div>
            <p class="page-subtitle">Kelola informasi ruangan, multi-foto dari berbagai sudut, dan fasilitas</p>
        </div>
        <a href="#" class="btn btn-primary" data-modal-target="modalTambahRuangan">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Tambah Ruangan
        </a>
    </div>

    @if(session('success'))
        <div style="padding: 0.85rem 1.25rem; background: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; border-radius: 8px; margin-bottom: 1.25rem; font-size: 0.92rem; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(16, 185, 129, 0.08);">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div style="padding: 0.85rem 1.25rem; background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; border-radius: 8px; margin-bottom: 1.25rem; font-size: 0.92rem; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.08);">
            <ul style="margin: 0; padding-left: 1.2rem;">
                @foreach(array_unique($errors->all()) as $error)
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
                @php
                    $displayImage = $room->image;
                    if (!$displayImage && $room->images->isNotEmpty()) {
                        $displayImage = $room->images->first()->path;
                    }
                    $photoCount = $room->images->count() ?: ($room->image ? 1 : 0);
                @endphp

                @if($displayImage && \Illuminate\Support\Facades\Storage::disk('public')->exists($displayImage))
                    <img src="{{ asset('storage/' . $displayImage) }}" alt="{{ $room->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div class="room-img-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" /></svg>
                    </div>
                @endif

                <!-- Photo Count Pill -->
                <span class="photo-counter-badge" title="{{ $photoCount }} Foto Ruangan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                    {{ $photoCount }} Foto
                </span>

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

                @if(!empty($room->facilities_list))
                <div class="room-facilities">
                    @foreach($room->facilities_list as $facility)
                        <span class="facility-tag">{{ $facility }}</span>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="room-card-footer">
                <button class="btn-sm btn-sm-outline" title="Edit" data-modal-target="modalEditRuangan{{ $room->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                    Edit & Foto
                </button>
                <form action="{{ route('admin.ruangan.destroy', $room) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus ruangan {{ $room->name }} beserta seluruh fotonya?')">
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
        <div class="modal-dialog modal-dialog-lg">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Ruangan Baru</h3>
                <button class="modal-close" data-modal-close>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form action="{{ route('admin.ruangan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group" style="flex: 2;">
                            <label class="form-label">Nama Ruangan <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Ruang Rapat Utama (Bhirawa)" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Kapasitas (Orang) <span style="color: #ef4444;">*</span></label>
                            <input type="number" name="capacity" class="form-control" placeholder="0" min="1" required>
                        </div>
                    </div>

                    <!-- Custom Facilities Tag Input -->
                    <div class="form-group">
                        <label class="form-label">
                            Fasilitas Ruangan
                            <span class="form-label-tip">(Ketik fasilitas sendiri secara bebas & tekan Enter / Koma)</span>
                        </label>
                        <div class="tag-input-container" data-container-id="new">
                            <div class="tags-wrapper" id="tagsWrapper_new"></div>
                            <input type="text" class="tag-text-input" placeholder="Ketik fasilitas baru lalu Enter / Koma..." onkeydown="handleTagInputKey(event, 'new')">
                            <input type="hidden" name="facilities" id="facilitiesHidden_new" value="">
                        </div>
                        <div class="quick-chips-wrapper">
                            <span class="chips-title">Rekomendasi Cepat (Klik untuk tambah):</span>
                            @foreach(['AC', 'Proyektor', 'Sound System', 'WiFi', 'Whiteboard', 'LED TV', 'Podium', 'Mic Wireless', 'Meja Rapat', 'Colokan Listrik', 'Panggung', 'Area Santai'] as $quickFac)
                                <button type="button" class="quick-chip-btn" onclick="addCustomTag('{{ $quickFac }}', 'new')">+ {{ $quickFac }}</button>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Ruangan (Opsional)</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Deskripsi singkat mengenai peruntukan atau keunggulan ruangan..."></textarea>
                    </div>
                    
                    <!-- Multi-Image Upload Section -->
                    <div class="form-group" style="margin-top: 1.25rem;">
                        <label class="form-label">
                            Upload Foto Ruangan (Bisa beberapa foto sekaligus / berbagai sudut)
                        </label>
                        <div class="upload-dropzone">
                            <input type="file" name="images[]" multiple accept="image/png, image/jpeg, image/jpg, image/webp, image/heic, image/heif, .png, .jpg, .jpeg, .webp, .jfif, .avif, .bmp, .heic, .HEIC, .heif, .HEIF" class="file-input-hidden" id="fileInput_new" onchange="handleMultipleImagePreview(this, 'preview_new')">
                            <label for="fileInput_new" class="dropzone-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="color: var(--bakorwil-cyan); margin-bottom: 6px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                <span class="dropzone-text"><strong>Klik di sini</strong> untuk memilih satu atau beberapa foto</span>
                                <span class="dropzone-sub">Pilih sudut tampak depan, dalam, meja podium, dll. (JPG, PNG, WEBP, atau foto HP/iPhone maks 20MB per file)</span>
                            </label>
                        </div>
                        <div class="image-preview-grid" id="preview_new"></div>
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
        <div class="modal-dialog modal-dialog-lg">
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
                    <div class="form-row">
                        <div class="form-group" style="flex: 2;">
                            <label class="form-label">Nama Ruangan <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $room->name }}" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Kapasitas (Orang) <span style="color: #ef4444;">*</span></label>
                            <input type="number" name="capacity" class="form-control" value="{{ $room->capacity }}" min="1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status Ruangan</label>
                        <label style="display: inline-flex; align-items: center; gap: 0.6rem; font-size: 0.92rem; color: var(--text-main); cursor: pointer; background: var(--surface-hover); padding: 8px 14px; border-radius: 8px; border: 1px solid var(--border-color);">
                            <input type="checkbox" name="is_active" value="1" {{ $room->is_active ? 'checked' : '' }} style="width: 17px; height: 17px; accent-color: var(--bakorwil-cyan);"> 
                            <span>Aktif (Tersedia untuk dipinjam pemohon)</span>
                        </label>
                    </div>

                    <!-- Custom Facilities Tag Input (Edit) -->
                    <div class="form-group">
                        <label class="form-label">
                            Fasilitas Ruangan
                            <span class="form-label-tip">(Ketik fasilitas sendiri secara bebas & tekan Enter / Koma)</span>
                        </label>
                        @php
                            $initialFacilities = $room->facilities_list;
                        @endphp
                        <div class="tag-input-container" data-container-id="{{ $room->id }}">
                            <div class="tags-wrapper" id="tagsWrapper_{{ $room->id }}">
                                @foreach($initialFacilities as $facItem)
                                    <span class="tag-badge">
                                        {{ $facItem }}
                                        <button type="button" class="tag-remove-btn" onclick="removeCustomTag(this, '{{ $room->id }}')">&times;</button>
                                    </span>
                                @endforeach
                            </div>
                            <input type="text" class="tag-text-input" placeholder="Ketik fasilitas baru lalu Enter / Koma..." onkeydown="handleTagInputKey(event, '{{ $room->id }}')">
                            <input type="hidden" name="facilities" id="facilitiesHidden_{{ $room->id }}" value="{{ implode(', ', $initialFacilities) }}">
                        </div>
                        <div class="quick-chips-wrapper">
                            <span class="chips-title">Rekomendasi Cepat:</span>
                            @foreach(['AC', 'Proyektor', 'Sound System', 'WiFi', 'Whiteboard', 'LED TV', 'Podium', 'Mic Wireless', 'Meja Rapat', 'Colokan Listrik', 'Panggung', 'Area Santai'] as $quickFac)
                                <button type="button" class="quick-chip-btn" onclick="addCustomTag('{{ $quickFac }}', '{{ $room->id }}')">+ {{ $quickFac }}</button>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Ruangan (Opsional)</label>
                        <textarea name="description" class="form-control" rows="2">{{ $room->description }}</textarea>
                    </div>

                    <!-- Existing Photos Gallery with Delete Button -->
                    <div class="form-group" style="margin-top: 1.5rem;">
                        <label class="form-label" style="display: flex; justify-content: space-between; align-items: center;">
                            <span>Foto Ruangan Saat Ini ({{ $room->images->count() }} Foto)</span>
                            <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-muted);">Klik tanda × merah untuk menghapus foto</span>
                        </label>

                        @if($room->images->isNotEmpty())
                            <div class="existing-photos-grid" id="existingGrid_{{ $room->id }}">
                                @foreach($room->images as $rImg)
                                    <div class="existing-photo-card" id="photoCard_{{ $rImg->id }}">
                                        <img src="{{ asset('storage/' . $rImg->path) }}" alt="Foto Ruangan">
                                        @if($room->image === $rImg->path)
                                            <span class="main-badge">Utama</span>
                                        @endif
                                        <button type="button" class="btn-delete-photo" title="Hapus foto ini" onclick="deleteExistingRoomImage({{ $rImg->id }}, '{{ route('admin.ruangan.destroyImage', $rImg) }}')">
                                            &times;
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="padding: 1rem; background: var(--surface-hover); border-radius: 8px; font-size: 0.85rem; color: var(--text-muted); text-align: center;">
                                Belum ada foto untuk ruangan ini. Silakan upload di bawah.
                            </div>
                        @endif
                    </div>

                    <!-- Upload Additional Photos -->
                    <div class="form-group" style="margin-top: 1.25rem;">
                        <label class="form-label">
                            Tambah Foto Baru (Bisa pilih beberapa sudut sekaligus)
                        </label>
                        <div class="upload-dropzone">
                            <input type="file" name="images[]" multiple accept="image/png, image/jpeg, image/jpg, image/webp, image/heic, image/heif, .png, .jpg, .jpeg, .webp, .jfif, .avif, .bmp, .heic, .HEIC, .heif, .HEIF" class="file-input-hidden" id="fileInput_{{ $room->id }}" onchange="handleMultipleImagePreview(this, 'preview_{{ $room->id }}')">
                            <label for="fileInput_{{ $room->id }}" class="dropzone-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="color: var(--bakorwil-cyan); margin-bottom: 4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                <span class="dropzone-text"><strong>Klik untuk menambah foto baru</strong></span>
                                <span class="dropzone-sub">Foto yang diupload akan otomatis ditambahkan ke galeri ruangan (JPG, PNG, WEBP, atau foto HP/iPhone)</span>
                            </label>
                        </div>
                        <div class="image-preview-grid" id="preview_{{ $room->id }}"></div>
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

    <style>
        .modal-dialog-lg {
            max-width: 680px !important;
            width: 95%;
        }

        .photo-counter-badge {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(15, 23, 42, 0.78);
            backdrop-filter: blur(4px);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            z-index: 2;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .form-label-tip {
            font-size: 0.8rem;
            font-weight: normal;
            color: var(--text-muted);
            margin-left: 4px;
        }

        /* Tag Input Styles */
        .tag-input-container {
            border: 1px solid var(--border-color);
            background: var(--surface-card);
            border-radius: 8px;
            padding: 8px 10px;
            min-height: 48px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .tag-input-container:focus-within {
            border-color: var(--bakorwil-cyan);
            box-shadow: 0 0 0 3px rgba(8, 166, 217, 0.15);
        }

        .tags-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .tag-badge {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            font-size: 0.84rem;
            font-weight: 500;
            padding: 4px 8px 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            line-height: 1.2;
        }

        .tag-remove-btn {
            background: transparent;
            border: none;
            color: #0284c7;
            font-size: 15px;
            cursor: pointer;
            line-height: 1;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            transition: all 0.15s;
        }

        .tag-remove-btn:hover {
            background: #0284c7;
            color: white;
        }

        .tag-text-input {
            border: none;
            outline: none;
            font-size: 0.9rem;
            color: var(--text-main);
            background: transparent;
            flex: 1;
            min-width: 180px;
            padding: 4px 0;
        }

        .quick-chips-wrapper {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
        }

        .chips-title {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-right: 2px;
        }

        .quick-chip-btn {
            background: var(--surface-hover);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            font-size: 0.78rem;
            padding: 3px 9px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .quick-chip-btn:hover {
            background: var(--bakorwil-cyan);
            border-color: var(--bakorwil-cyan);
            color: white;
            transform: translateY(-1px);
        }

        /* Upload Dropzone */
        .upload-dropzone {
            border: 2px dashed #cbd5e1;
            border-radius: 10px;
            background: #f8fafc;
            text-align: center;
            padding: 18px 14px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .upload-dropzone:hover {
            border-color: var(--bakorwil-cyan);
            background: #f0fdfa;
        }

        .file-input-hidden {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .dropzone-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            pointer-events: none;
        }

        .dropzone-text {
            font-size: 0.92rem;
            color: #334155;
            margin-bottom: 2px;
        }

        .dropzone-sub {
            font-size: 0.78rem;
            color: #64748b;
        }

        /* Image Previews */
        .image-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
            gap: 10px;
            margin-top: 12px;
        }

        .preview-item {
            position: relative;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 5px rgba(0,0,0,0.06);
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-item .preview-count {
            position: absolute;
            bottom: 3px;
            right: 3px;
            background: rgba(0,0,0,0.65);
            color: white;
            font-size: 10px;
            padding: 1px 5px;
            border-radius: 4px;
        }

        /* Existing Photos Grid */
        .existing-photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 12px;
            background: var(--surface-hover);
            padding: 12px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
        }

        .existing-photo-card {
            position: relative;
            height: 90px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .existing-photo-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .existing-photo-card .main-badge {
            position: absolute;
            bottom: 4px;
            left: 4px;
            background: #059669;
            color: white;
            font-size: 9px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .existing-photo-card .btn-delete-photo {
            position: absolute;
            top: 4px;
            right: 4px;
            background: #ef4444;
            color: white;
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: all 0.15s;
            line-height: 1;
        }

        .existing-photo-card .btn-delete-photo:hover {
            background: #dc2626;
            transform: scale(1.1);
        }
    </style>

    <!-- HEIC/HEIF Converter for iPhone / Smartphone Camera Photos -->
    <script src="https://cdn.jsdelivr.net/npm/heic2any@0.0.4/dist/heic2any.min.js"></script>

    <script>
        // === Custom Facility Tag Input Script ===
        function updateHiddenFacilities(id) {
            const wrapper = document.getElementById('tagsWrapper_' + id);
            const hiddenInput = document.getElementById('facilitiesHidden_' + id);
            if (!wrapper || !hiddenInput) return;

            const tags = [];
            wrapper.querySelectorAll('.tag-badge').forEach(badge => {
                const text = badge.childNodes[0].textContent.trim();
                if (text) tags.push(text);
            });

            hiddenInput.value = tags.join(', ');
        }

        function addCustomTag(name, id) {
            name = name.trim();
            if (!name) return;

            const wrapper = document.getElementById('tagsWrapper_' + id);
            if (!wrapper) return;

            // Check if tag already exists
            const existingTags = Array.from(wrapper.querySelectorAll('.tag-badge')).map(b => b.childNodes[0].textContent.trim().toLowerCase());
            if (existingTags.includes(name.toLowerCase())) {
                return; // Duplicate
            }

            const tagEl = document.createElement('span');
            tagEl.className = 'tag-badge';
            tagEl.innerHTML = name + ' <button type="button" class="tag-remove-btn" onclick="removeCustomTag(this, \'' + id + '\')">&times;</button>';
            wrapper.appendChild(tagEl);

            updateHiddenFacilities(id);
        }

        function removeCustomTag(btn, id) {
            const badge = btn.closest('.tag-badge');
            if (badge) {
                badge.remove();
                updateHiddenFacilities(id);
            }
        }

        function handleTagInputKey(e, id) {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                const input = e.target;
                const value = input.value.replace(/,/g, '').trim();
                if (value) {
                    addCustomTag(value, id);
                    input.value = '';
                }
            }
        }

        // === Multi Image Preview Script with HEIC/HEIF Auto-Conversion ===
        async function handleMultipleImagePreview(input, previewGridId) {
            const previewGrid = document.getElementById(previewGridId);
            if (!previewGrid) return;
            previewGrid.innerHTML = '';

            if (!input.files || input.files.length === 0) return;

            const originalFiles = Array.from(input.files);
            const hasHeic = originalFiles.some(f => {
                const ext = f.name.split('.').pop().toLowerCase();
                return ext === 'heic' || ext === 'heif' || f.type === 'image/heic' || f.type === 'image/heif';
            });

            // Status indikator jika ada proses konversi
            let statusBadge = null;
            if (hasHeic && typeof heic2any !== 'undefined') {
                statusBadge = document.createElement('div');
                statusBadge.style.cssText = 'grid-column: 1 / -1; padding: 8px 12px; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; border-radius: 6px; font-size: 0.82rem; display: flex; align-items: center; gap: 8px; margin-bottom: 4px;';
                statusBadge.innerHTML = '<span style="display:inline-block;width:12px;height:12px;border:2px solid currentColor;border-right-color:transparent;border-radius:50%;animation:spin 0.75s linear infinite;"></span> Sedang mengoptimasi & mengonversi foto kamera iPhone/HP (HEIC &rarr; JPG)...';
                previewGrid.appendChild(statusBadge);
            }

            try {
                const dt = new DataTransfer();

                for (let index = 0; index < originalFiles.length; index++) {
                    let file = originalFiles[index];
                    const ext = file.name.split('.').pop().toLowerCase();
                    const isHeic = ext === 'heic' || ext === 'heif' || file.type === 'image/heic' || file.type === 'image/heif';

                    if (isHeic && typeof heic2any !== 'undefined') {
                        try {
                            const convertedResult = await heic2any({
                                blob: file,
                                toType: 'image/jpeg',
                                quality: 0.88
                            });
                            const convertedBlob = Array.isArray(convertedResult) ? convertedResult[0] : convertedResult;
                            const newFileName = file.name.replace(/\.[^/.]+$/, "") + ".jpg";
                            file = new File([convertedBlob], newFileName, { type: 'image/jpeg' });
                        } catch (convErr) {
                            console.warn('Gagal mengonversi file HEIC:', file.name, convErr);
                        }
                    }

                    dt.items.add(file);

                    // Buat elemen preview
                    const item = document.createElement('div');
                    item.className = 'preview-item';

                    if (file.type && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            item.innerHTML = '<img src="' + e.target.result + '" alt="Preview"><span class="preview-count">#' + (index + 1) + '</span>';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        item.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;font-size:11px;color:#64748b;text-align:center;padding:4px;word-break:break-all;">' + file.name + '</div><span class="preview-count">#' + (index + 1) + '</span>';
                    }

                    previewGrid.appendChild(item);
                }

                // Ganti file input dengan daftar file yang sudah terkonversi (sehingga server menerima JPG)
                input.files = dt.files;
            } catch (err) {
                console.error('Error saat membaca file gambar:', err);
            } finally {
                if (statusBadge && statusBadge.parentNode) {
                    statusBadge.parentNode.removeChild(statusBadge);
                }
            }
        }

        // === Delete Existing Room Photo via AJAX ===
        function deleteExistingRoomImage(imageId, deleteUrl) {
            if (!confirm('Hapus foto ini dari galeri ruangan?')) {
                return;
            }

            fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const card = document.getElementById('photoCard_' + imageId);
                    if (card) {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.8)';
                        setTimeout(() => card.remove(), 250);
                    }
                } else {
                    alert('Gagal menghapus foto: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('Gagal menghapus foto. Silakan muat ulang halaman.');
            });
        }
    </script>
@endsection
