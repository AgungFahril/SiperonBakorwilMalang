@extends('layouts.app')

@section('title', 'Form Pengajuan Peminjaman Ruangan - SIPERON')

@section('content')
<section class="booking-multi-section">
    <div class="container" style="max-width: 980px;">

        <!-- Page Header -->
        <div class="booking-multi-header">
            <span class="form-badge-pill">SIPERON BAKORWIL III MALANG</span>
            <h1 class="page-title">Formulir Pengajuan Peminjaman Ruangan</h1>
            <p class="page-subtitle">
                Isi identitas Anda 1 kali, dan Anda dapat memilih satu atau <strong>beberapa ruangan sekaligus</strong> sesuai kebutuhan kegiatan Anda tanpa harus bolak-balik menu.
            </p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Mohon periksa kembali formulir Anda:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Quick Help Bar / Catalog Modal Trigger -->
        <div class="quick-catalog-bar">
            <div class="quick-catalog-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#08a6d9" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <span>Ingin membandingkan kapasitas & fasilitas semua ruangan terlebih dahulu?</span>
            </div>
            <button type="button" class="btn-open-catalog" onclick="openRoomCatalogModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                Lihat Katalog Semua Ruangan
            </button>
        </div>

        @if(isset($settings['default_rules']) && !empty($settings['default_rules']))
            <div class="rules-box">
                <div class="rules-box-header">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#08a6d9" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <span>Aturan & Ketentuan Peminjaman Ruangan:</span>
                </div>
                <div class="rules-box-content">
                    {!! nl2br(e($settings['default_rules'])) !!}
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('booking.store.multi') }}" class="multi-booking-form" enctype="multipart/form-data" id="bookingFormElement">
            @csrf

            <!-- ========================================== -->
            <!-- STEP 1: IDENTITAS PEMOHON (1 KALI SAJA)    -->
            <!-- ========================================== -->
            <div class="form-section-card">
                <div class="section-card-header">
                    <div class="step-circle">1</div>
                    <div>
                        <h2 class="section-card-title">Identitas Pemohon</h2>
                        <p class="section-card-sub">Data pemohon diisi 1 kali sebagai penanggung jawab peminjaman.</p>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_pemohon">Nama Lengkap Pemohon <span class="required-star">*</span></label>
                        <input type="text" id="nama_pemohon" name="nama_pemohon"
                               value="{{ old('nama_pemohon') }}" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="form-group">
                        <label for="instansi">Instansi / Organisasi / Komunitas</label>
                        <input type="text" id="instansi" name="instansi"
                               value="{{ old('instansi') }}" placeholder="Contoh: Dinas Kominfo Kab. Malang / Komunitas IT">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="no_whatsapp">Nomor WhatsApp Aktif <span class="required-star">*</span></label>
                        <input type="text" id="no_whatsapp" name="no_whatsapp"
                               value="{{ old('no_whatsapp') }}" placeholder="Contoh: 081234567890" required>
                        <small class="field-hint">Notifikasi konfirmasi dan update status akan dikirimkan ke nomor ini.</small>
                    </div>

                    <div class="form-group">
                        <label for="email">Alamat Email <span class="required-star">*</span></label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}" placeholder="Contoh: nama@domain.com" required>
                        <small class="field-hint">Tembusan bukti pengajuan juga dikirimkan melalui email.</small>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- STEP 2: DAFTAR RUANGAN YANG INGIN DIPINJAM -->
            <!-- ========================================== -->
            <div class="form-section-card">
                <div class="section-card-header section-card-header-flex">
                    <div style="display: flex; gap: 14px; align-items: center;">
                        <div class="step-circle">2</div>
                        <div>
                            <h2 class="section-card-title">Ruangan yang Dipinjam</h2>
                            <p class="section-card-sub">Pilih ruangan, tanggal, waktu, dan kegiatan untuk masing-masing ruangan yang dibutuhkan.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-add-room-top" onclick="addNewRoomSlot()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        + Tambah Ruangan Lain
                    </button>
                </div>

                <!-- Container Slot-Slot Ruangan Dinamis -->
                <div id="roomSlotsContainer" class="room-slots-container">
                    <!-- Slot di-render melalui Blade & JS di bawah -->
                </div>

                <!-- Tombol Tambah Ruangan Bawah -->
                <div class="add-room-banner" onclick="addNewRoomSlot()">
                    <div class="add-room-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </div>
                    <div>
                        <strong class="add-room-text">+ Tambah Ruangan Lain</strong>
                        <span class="add-room-sub">Butuh ruangan tambahan untuk acara paralel atau hari berbeda? Klik di sini untuk menambah ruangan berikutnya.</span>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- STEP 3: BERKAS PERSYARATAN & KETERANGAN   -->
            <!-- ========================================== -->
            <div class="form-section-card">
                <div class="section-card-header">
                    <div class="step-circle">3</div>
                    <div>
                        <h2 class="section-card-title">Berkas & Keterangan Tambahan</h2>
                        <p class="section-card-sub">Upload surat permohonan resmi dan tambahkan catatan pendukung jika ada.</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="surat_pengajuan">Upload Surat Permohonan / Pengajuan Resmi (Format PDF, Maks. 15MB) <span class="required-star">*</span></label>
                    <div class="file-upload-dropzone">
                        <input type="file" id="surat_pengajuan" name="surat_pengajuan" accept="application/pdf" required onchange="handleFileChange(this)">
                        <div class="upload-dropzone-inner" id="dropzoneContent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#08a6d9" stroke-width="1.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <span class="upload-title" id="fileUploadName">Pilih file PDF surat permohonan atau drag & drop ke sini</span>
                            <span class="upload-hint">1 berkas surat permohonan mencakup seluruh ruangan yang diajukan</span>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1.25rem;">
                    <label for="keterangan">Keterangan / Catatan Tambahan (Opsional)</label>
                    <textarea id="keterangan" name="keterangan" rows="3" placeholder="Informasi tambahan terkait tata ruang, kebutuhan teknis khusus, susunan acara, dll...">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <!-- Form Action Footer -->
            <div class="form-action-footer">
                <a href="{{ route('home') }}" class="btn btn-outline">Batal & Kembali</a>
                <button type="submit" class="btn btn-primary btn-submit-lg" id="btnSubmitBooking">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    <span id="btnSubmitText">Kirim Pengajuan Peminjaman</span>
                </button>
            </div>

        </form>

    </div>
</section>

<!-- ======================================================== -->
<!-- MODAL KATALOG SEMUA RUANGAN (Agar pemohon tidak bolak-balik) -->
<!-- ======================================================== -->
<div id="roomCatalogModal" class="catalog-modal-overlay" onclick="closeCatalogOnBackdrop(event)">
    <div class="catalog-modal-dialog">
        <div class="catalog-modal-header">
            <div>
                <h3 class="catalog-modal-title">Katalog & Fasilitas Ruangan</h3>
                <p class="catalog-modal-sub">Daftar lengkap ruangan Bakorwil III Malang dengan foto, kapasitas, dan fasilitas.</p>
            </div>
            <button type="button" class="btn-close-modal" onclick="closeRoomCatalogModal()">&times;</button>
        </div>

        <div class="catalog-modal-body">
            <div class="catalog-rooms-grid">
                @foreach($rooms as $r)
                    @php
                        $rImages = $r->images->isNotEmpty() ? $r->images : collect();
                        $firstPath = $rImages->isNotEmpty() ? asset('storage/' . $rImages->first()->path) : ($r->image ? asset('storage/' . $r->image) : asset('images/room-default.jpg'));
                    @endphp
                    <div class="catalog-room-card">
                        <div class="catalog-card-image">
                            <img src="{{ $firstPath }}" alt="{{ $r->name }}">
                            <span class="catalog-photo-count">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                {{ $rImages->count() > 0 ? $rImages->count() : 1 }} Foto
                            </span>
                        </div>
                        <div class="catalog-card-content">
                            <div class="catalog-card-top">
                                <h4 class="catalog-room-name">{{ $r->name }}</h4>
                                <span class="catalog-capacity-badge">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    {{ $r->capacity }} Kursi
                                </span>
                            </div>
                            @if($r->description)
                                <p class="catalog-room-desc">{{ Str::limit($r->description, 110) }}</p>
                            @endif

                            @if(!empty($r->facilities_list))
                                <div class="catalog-facilities-list">
                                    @foreach(array_slice($r->facilities_list, 0, 4) as $fac)
                                        <span class="catalog-fac-chip">{{ $fac }}</span>
                                    @endforeach
                                    @if(count($r->facilities_list) > 4)
                                        <span class="catalog-fac-more">+{{ count($r->facilities_list) - 4 }}</span>
                                    @endif
                                </div>
                            @endif

                            <button type="button" class="btn-select-this-room" onclick="selectRoomFromCatalog({{ $r->id }})">
                                Gunakan Ruangan Ini &darr;
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- DATA JSON SEMUA RUANGAN (Untuk Instant Live Preview tanpa Reload) -->
@php
    $roomsJsonData = $rooms->mapWithKeys(function($room) {
        $images = $room->images->isNotEmpty()
            ? $room->images->map(fn($img) => asset('storage/' . $img->path))->values()
            : ($room->image ? collect([asset('storage/' . $room->image)]) : collect([asset('images/room-default.jpg')]));
        return [$room->id => [
            'id' => $room->id,
            'name' => $room->name,
            'capacity' => $room->capacity,
            'description' => $room->description ?: 'Ruangan pertemuan resmi Bakorwil III Malang dengan fasilitas penunjang lengkap.',
            'facilities' => $room->facilities_list,
            'images' => $images,
        ]];
    });

    $minDateAllowed = \Carbon\Carbon::now()->addDays(3)->format('Y-m-d');
@endphp

<script>
    const ROOMS_DATA = {!! json_encode($roomsJsonData) !!};
    const MIN_DATE_ALLOWED = "{{ $minDateAllowed }}";
    const DEFAULT_PRESELECTED_ROOM = {{ $selectedRoomId ?? ($rooms->first()->id ?? 0) }};
    const DEFAULT_PRESELECTED_DATE = "{{ $defaultDate ?? $minDateAllowed }}";

    // Simpan data slot lama dari old() jika terjadi error validation
    const OLD_ROOMS = {!! json_encode(old('rooms', [])) !!};
</script>

<style>
    /* Multi Booking Form General */
    .booking-multi-section {
        padding: 50px 0 80px;
        background: #f8fafc;
        min-height: 85vh;
    }

    .booking-multi-header {
        text-align: center;
        margin-bottom: 2.25rem;
    }

    .form-badge-pill {
        display: inline-block;
        background: #e0f2fe;
        color: #0284c7;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.8px;
        padding: 4px 14px;
        border-radius: 20px;
        margin-bottom: 8px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        font-size: 1rem;
        color: #64748b;
        max-width: 680px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Quick Catalog Bar */
    .quick-catalog-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-left: 4px solid var(--bakorwil-cyan);
        border-radius: 12px;
        padding: 14px 20px;
        margin-bottom: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .quick-catalog-info {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #334155;
        font-size: 14px;
        font-weight: 500;
    }

    .btn-open-catalog {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f0fdfa;
        color: #0f766e;
        border: 1px solid #ccfbf1;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-open-catalog:hover {
        background: var(--bakorwil-cyan);
        color: #ffffff;
        border-color: var(--bakorwil-cyan);
    }

    /* Rules Box */
    .rules-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid var(--bakorwil-cyan);
        border-radius: 10px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
    }

    .rules-box-header {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rules-box-content {
        color: #475569;
        font-size: 13.5px;
        line-height: 1.6;
    }

    /* Section Cards */
    .form-section-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .section-card-header {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        margin-bottom: 22px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .section-card-header-flex {
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .step-circle {
        background: linear-gradient(135deg, #08a6d9, #0284c7);
        color: #ffffff;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(8, 166, 217, 0.25);
    }

    .section-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 2px 0;
    }

    .section-card-sub {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    .btn-add-room-top {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f0fdfa;
        color: #0f766e;
        border: 1.5px solid #0d9488;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-add-room-top:hover {
        background: #0d9488;
        color: #ffffff;
    }

    /* Form Fields */
    .required-star {
        color: #ef4444;
        font-weight: 700;
    }

    .field-hint {
        color: #64748b;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }

    /* Room Slot Item */
    .room-slot-card {
        background: #fcfdfd;
        border: 1.5px solid #cbd5e1;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 20px;
        position: relative;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .room-slot-card:hover {
        border-color: #08a6d9;
        box-shadow: 0 6px 20px rgba(8, 166, 217, 0.08);
    }

    .room-slot-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
    }

    .slot-pill-badge {
        background: #0f172a;
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 6px;
        letter-spacing: 0.5px;
    }

    .btn-remove-slot {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
    }

    .btn-remove-slot:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
    }

    /* LIVE ROOM PREVIEW EMBEDDED IN SLOT */
    .slot-live-preview {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        margin: 14px 0 20px;
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .slot-preview-media {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .slot-preview-main-img {
        position: relative;
        height: 145px;
        background: #0f172a;
        border-radius: 8px;
        overflow: hidden;
    }

    .slot-preview-main-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.2s ease;
    }

    .slot-photo-count-badge {
        position: absolute;
        bottom: 6px;
        left: 6px;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-size: 10px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 4px;
    }

    .slot-preview-thumbs {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        padding-bottom: 2px;
    }

    .slot-preview-thumb-box {
        width: 48px;
        height: 34px;
        border-radius: 5px;
        overflow: hidden;
        cursor: pointer;
        opacity: 0.6;
        border: 1.5px solid transparent;
        flex-shrink: 0;
        transition: all 0.15s ease;
    }

    .slot-preview-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .slot-preview-thumb-box.active {
        opacity: 1;
        border-color: var(--bakorwil-cyan);
        transform: scale(1.05);
    }

    .slot-preview-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .slot-preview-title {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .slot-capacity-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f0fdfa;
        color: #0f766e;
        border: 1px solid #ccfbf1;
        font-size: 12px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        width: fit-content;
        margin-bottom: 8px;
    }

    .slot-preview-desc {
        font-size: 12.5px;
        color: #64748b;
        line-height: 1.5;
        margin: 0 0 10px 0;
    }

    .slot-facilities-group {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .slot-facility-chip {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        font-size: 11px;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .slot-facility-chip svg {
        color: #08a6d9;
    }

    /* Add Room Banner */
    .add-room-banner {
        background: #f8fafc;
        border: 2px dashed #94a3b8;
        border-radius: 12px;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 10px;
    }

    .add-room-banner:hover {
        background: #f0fdfa;
        border-color: #08a6d9;
    }

    .add-room-icon {
        width: 44px;
        height: 44px;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #08a6d9;
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }

    .add-room-banner:hover .add-room-icon {
        background: #08a6d9;
        color: #ffffff;
        border-color: #08a6d9;
        transform: scale(1.08);
    }

    .add-room-text {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        display: block;
    }

    .add-room-sub {
        font-size: 12.5px;
        color: #64748b;
    }

    /* File Upload Dropzone */
    .file-upload-dropzone {
        position: relative;
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 28px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .file-upload-dropzone:hover {
        border-color: #08a6d9;
        background: #f0fdfa;
    }

    .file-upload-dropzone input[type="file"] {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 5;
    }

    .upload-dropzone-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .upload-title {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    .upload-hint {
        font-size: 12px;
        color: #64748b;
    }

    /* Action Footer */
    .form-action-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .btn-submit-lg {
        padding: 13px 32px;
        font-size: 15px;
        font-weight: 700;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* Catalog Modal Styles */
    .catalog-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(5px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .catalog-modal-overlay.open {
        display: flex;
    }

    .catalog-modal-dialog {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 900px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        animation: modalScaleUp 0.25s ease-out;
    }

    @keyframes modalScaleUp {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .catalog-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .catalog-modal-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 2px 0;
    }

    .catalog-modal-sub {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    .btn-close-modal {
        background: none;
        border: none;
        font-size: 26px;
        line-height: 1;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
    }

    .btn-close-modal:hover {
        color: #0f172a;
    }

    .catalog-modal-body {
        padding: 24px;
        overflow-y: auto;
    }

    .catalog-rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 18px;
    }

    .catalog-room-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .catalog-room-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        border-color: #08a6d9;
    }

    .catalog-card-image {
        position: relative;
        height: 140px;
        background: #0f172a;
    }

    .catalog-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .catalog-photo-count {
        position: absolute;
        bottom: 6px;
        right: 6px;
        background: rgba(15, 23, 42, 0.85);
        color: #ffffff;
        font-size: 10px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .catalog-card-content {
        padding: 14px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .catalog-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 6px;
    }

    .catalog-room-name {
        font-size: 14.5px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .catalog-capacity-badge {
        background: #f0fdfa;
        color: #0f766e;
        border: 1px solid #ccfbf1;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 12px;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }

    .catalog-room-desc {
        font-size: 12px;
        color: #64748b;
        line-height: 1.45;
        margin: 0 0 10px 0;
        flex: 1;
    }

    .catalog-facilities-list {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-bottom: 12px;
    }

    .catalog-fac-chip {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        font-size: 10px;
        color: #475569;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .catalog-fac-more {
        font-size: 10px;
        color: #08a6d9;
        font-weight: 700;
        padding: 2px;
    }

    .btn-select-this-room {
        background: #08a6d9;
        color: #ffffff;
        border: none;
        padding: 8px 12px;
        border-radius: 7px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        width: 100%;
        transition: background 0.2s ease;
    }

    .btn-select-this-room:hover {
        background: #0284c7;
    }

    @media (max-width: 768px) {
        .slot-live-preview {
            grid-template-columns: 1fr;
        }
        .form-row.form-row-3 {
            grid-template-columns: 1fr;
        }
        .section-card-header-flex {
            gap: 12px;
        }
        .btn-add-room-top {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    let activeSlotCount = 0;
    let targetSlotIndexForCatalog = 0;

    // Template HTML untuk slot ruangan baru
    function createRoomSlotHTML(index, data = {}) {
        const roomId = data.room_id || DEFAULT_PRESELECTED_ROOM;
        const tanggal = data.tanggal || (index === 0 ? DEFAULT_PRESELECTED_DATE : MIN_DATE_ALLOWED);
        const jamMulai = data.jam_mulai || '';
        const jamSelesai = data.jam_selesai || '';
        const namaKegiatan = data.nama_kegiatan || '';
        const jumlahPeserta = data.jumlah_peserta || '';

        // Generate options untuk dropdown
        let roomOptions = '';
        Object.values(ROOMS_DATA).forEach(r => {
            const isSelected = r.id == roomId ? 'selected' : '';
            roomOptions += `<option value="${r.id}" ${isSelected}>${r.name} (Kapasitas: ${r.capacity} Kursi)</option>`;
        });

        return `
            <div class="room-slot-card" id="roomSlot_${index}" data-index="${index}">
                <div class="room-slot-header">
                    <span class="slot-pill-badge">RUANGAN #${index + 1}</span>
                    ${index > 0 ? `
                        <button type="button" class="btn-remove-slot" onclick="removeRoomSlot(${index})" title="Hapus Ruangan Ini">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            Hapus Ruangan Ini
                        </button>
                    ` : ''}
                </div>

                <!-- Dropdown Pilihan Ruangan -->
                <div class="form-group" style="margin-bottom: 0.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="room_select_${index}" style="margin: 0; font-weight: 700; color: #1e293b;">
                            Pilih Ruangan <span class="required-star">*</span>
                        </label>
                        <button type="button" class="btn-open-catalog" style="padding: 4px 10px; font-size: 11.5px;" onclick="openCatalogForSlot(${index})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            Lihat Katalog Ruangan
                        </button>
                    </div>
                    <select id="room_select_${index}" name="rooms[${index}][room_id]" class="room-dropdown-select" required onchange="onRoomChanged(${index}, this.value)">
                        ${roomOptions}
                    </select>
                </div>

                <!-- LIVE ROOM PREVIEW PANEL IN THE FORM -->
                <div class="slot-live-preview" id="livePreview_${index}">
                    <!-- Konten di-render dinamis oleh updateLivePreview -->
                </div>

                <!-- Detail Penggunaan Ruangan Ini -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="kegiatan_${index}">Keperluan / Nama Kegiatan <span class="required-star">*</span></label>
                        <input type="text" id="kegiatan_${index}" name="rooms[${index}][nama_kegiatan]"
                               value="${escapeHtml(namaKegiatan)}" placeholder="Contoh: Rapat Koordinasi Wilayah" required>
                    </div>

                    <div class="form-group">
                        <label for="peserta_${index}">Jumlah Peserta <span class="required-star">*</span></label>
                        <input type="number" id="peserta_${index}" name="rooms[${index}][jumlah_peserta]"
                               value="${escapeHtml(jumlahPeserta)}" placeholder="Contoh: 35" min="1" required oninput="validateCapacityHint(${index})">
                        <small class="field-hint" id="capacityHint_${index}"></small>
                    </div>
                </div>

                <div class="form-row form-row-3">
                    <div class="form-group">
                        <label for="tanggal_${index}">Tanggal Peminjaman <span class="required-star">*</span></label>
                        <input type="date" id="tanggal_${index}" name="rooms[${index}][tanggal]"
                               value="${escapeHtml(tanggal)}" min="${MIN_DATE_ALLOWED}" required>
                        <small class="field-hint">Minimal H+3 hari dari sekarang</small>
                    </div>

                    <div class="form-group">
                        <label for="jam_mulai_${index}">Jam Mulai <span class="required-star">*</span></label>
                        <input type="time" id="jam_mulai_${index}" name="rooms[${index}][jam_mulai]"
                               value="${escapeHtml(jamMulai)}" required onchange="checkTimeSequence(${index})">
                    </div>

                    <div class="form-group">
                        <label for="jam_selesai_${index}">Jam Selesai <span class="required-star">*</span></label>
                        <input type="time" id="jam_selesai_${index}" name="rooms[${index}][jam_selesai]"
                               value="${escapeHtml(jamSelesai)}" required onchange="checkTimeSequence(${index})">
                    </div>
                </div>

            </div>
        `;
    }

    // Helper escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        return String(text)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Update Live Preview box ketika ruangan dipilih
    function updateLivePreview(index, roomId) {
        const previewContainer = document.getElementById(`livePreview_${index}`);
        const room = ROOMS_DATA[roomId];
        if (!previewContainer || !room) return;

        const images = room.images && room.images.length > 0 ? room.images : ['{{ asset("images/room-default.jpg") }}'];
        const mainImgUrl = images[0];

        // Buat thumbnail strip jika foto > 1
        let thumbsHtml = '';
        if (images.length > 1) {
            thumbsHtml = '<div class="slot-preview-thumbs">';
            images.forEach((imgUrl, thumbIdx) => {
                thumbsHtml += `
                    <div class="slot-preview-thumb-box ${thumbIdx === 0 ? 'active' : ''}" 
                         onclick="changePreviewImage(${index}, '${imgUrl}', ${thumbIdx + 1}, ${images.length}, this)">
                        <img src="${imgUrl}" alt="Sudut ${thumbIdx + 1}">
                    </div>
                `;
            });
            thumbsHtml += '</div>';
        }

        // Fasilitas chips
        let facilitiesHtml = '';
        if (room.facilities && room.facilities.length > 0) {
            facilitiesHtml = '<div class="slot-facilities-group">';
            room.facilities.forEach(fac => {
                facilitiesHtml += `
                    <span class="slot-facility-chip">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        ${fac}
                    </span>
                `;
            });
            facilitiesHtml += '</div>';
        }

        previewContainer.innerHTML = `
            <div class="slot-preview-media">
                <div class="slot-preview-main-img">
                    <img id="slotMainImg_${index}" src="${mainImgUrl}" alt="${room.name}">
                    <span class="slot-photo-count-badge" id="slotBadge_${index}">${images.length} Foto</span>
                </div>
                ${thumbsHtml}
            </div>

            <div class="slot-preview-info">
                <h4 class="slot-preview-title">${room.name}</h4>
                <div class="slot-capacity-pill">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Kapasitas: <strong>${room.capacity} Orang / Kursi</strong>
                </div>
                <p class="slot-preview-desc">${room.description}</p>
                ${facilitiesHtml}
            </div>
        `;

        // Update capacity hint input
        validateCapacityHint(index);
    }

    // Switch image inside live preview
    function changePreviewImage(slotIndex, imgUrl, photoNum, totalPhotos, thumbElement) {
        const img = document.getElementById(`slotMainImg_${slotIndex}`);
        const badge = document.getElementById(`slotBadge_${slotIndex}`);
        if (!img) return;

        img.style.opacity = '0.3';
        img.src = imgUrl;
        img.onload = () => { img.style.opacity = '1'; };

        if (badge) {
            badge.textContent = `Sudut ${photoNum} dari ${totalPhotos}`;
        }

        const slotCard = document.getElementById(`roomSlot_${slotIndex}`);
        if (slotCard) {
            slotCard.querySelectorAll('.slot-preview-thumb-box').forEach(el => el.classList.remove('active'));
        }
        if (thumbElement) {
            thumbElement.classList.add('active');
        }
    }

    // Event handler dropdown ruangan diubah
    function onRoomChanged(index, roomId) {
        updateLivePreview(index, roomId);
    }

    // Hint kapasitas
    function validateCapacityHint(index) {
        const select = document.getElementById(`room_select_${index}`);
        const pesertaInput = document.getElementById(`peserta_${index}`);
        const hint = document.getElementById(`capacityHint_${index}`);
        if (!select || !hint) return;

        const room = ROOMS_DATA[select.value];
        if (!room) return;

        const maxCap = room.capacity;
        const val = parseInt(pesertaInput.value || 0);

        if (val > maxCap) {
            hint.innerHTML = `<span style="color: #dc2626; font-weight: 600;">⚠️ Perhatian: Jumlah peserta (${val}) melebihi kapasitas standar ruangan ini (${maxCap} kursi).</span>`;
        } else {
            hint.innerHTML = `Kapasitas ruangan ini: <strong>${maxCap} kursi</strong>.`;
        }
    }

    // Validasi jam selesai > jam mulai
    function checkTimeSequence(index) {
        const start = document.getElementById(`jam_mulai_${index}`);
        const end = document.getElementById(`jam_selesai_${index}`);
        if (!start || !end || !start.value || !end.value) return;

        if (end.value <= start.value) {
            alert('Perhatian: Jam selesai harus lebih akhir daripada jam mulai!');
            end.focus();
        }
    }

    // Tambah slot baru
    function addNewRoomSlot(initialData = null) {
        const container = document.getElementById('roomSlotsContainer');
        const newIndex = activeSlotCount;
        activeSlotCount++;

        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = createRoomSlotHTML(newIndex, initialData || {});
        const newElement = tempDiv.firstElementChild;
        container.appendChild(newElement);

        // Inisialisasi preview untuk ruangan yang terpilih
        const select = document.getElementById(`room_select_${newIndex}`);
        if (select) {
            updateLivePreview(newIndex, select.value);
        }

        // Scroll halus ke slot yang baru ditambahkan jika bukan slot 0
        if (newIndex > 0) {
            newElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    // Hapus slot
    function removeRoomSlot(index) {
        const slot = document.getElementById(`roomSlot_${index}`);
        if (!slot) return;

        if (confirm('Apakah Anda yakin ingin membatalkan pemilihan ruangan ini?')) {
            slot.remove();
            renumberSlots();
        }
    }

    // Tata ulang nomor dan atribut name jika ada slot yang dihapus
    function renumberSlots() {
        const container = document.getElementById('roomSlotsContainer');
        const cards = container.querySelectorAll('.room-slot-card');
        activeSlotCount = cards.length;

        cards.forEach((card, idx) => {
            card.id = `roomSlot_${idx}`;
            card.dataset.index = idx;

            const badge = card.querySelector('.slot-pill-badge');
            if (badge) badge.textContent = `RUANGAN #${idx + 1}`;

            // Update names of all inputs
            const select = card.querySelector('.room-dropdown-select');
            if (select) {
                select.id = `room_select_${idx}`;
                select.name = `rooms[${idx}][room_id]`;
                select.setAttribute('onchange', `onRoomChanged(${idx}, this.value)`);
            }

            const livePreview = card.querySelector('.slot-live-preview');
            if (livePreview) livePreview.id = `livePreview_${idx}`;

            const kegiatan = card.querySelector('input[name*="[nama_kegiatan]"]');
            if (kegiatan) {
                kegiatan.id = `kegiatan_${idx}`;
                kegiatan.name = `rooms[${idx}][nama_kegiatan]`;
            }

            const peserta = card.querySelector('input[name*="[jumlah_peserta]"]');
            if (peserta) {
                peserta.id = `peserta_${idx}`;
                peserta.name = `rooms[${idx}][jumlah_peserta]`;
                peserta.setAttribute('oninput', `validateCapacityHint(${idx})`);
            }

            const hint = card.querySelector('[id^="capacityHint_"]');
            if (hint) hint.id = `capacityHint_${idx}`;

            const tgl = card.querySelector('input[name*="[tanggal]"]');
            if (tgl) {
                tgl.id = `tanggal_${idx}`;
                tgl.name = `rooms[${idx}][tanggal]`;
            }

            const jmMulai = card.querySelector('input[name*="[jam_mulai]"]');
            if (jmMulai) {
                jmMulai.id = `jam_mulai_${idx}`;
                jmMulai.name = `rooms[${idx}][jam_mulai]`;
                jmMulai.setAttribute('onchange', `checkTimeSequence(${idx})`);
            }

            const jmSelesai = card.querySelector('input[name*="[jam_selesai]"]');
            if (jmSelesai) {
                jmSelesai.id = `jam_selesai_${idx}`;
                jmSelesai.name = `rooms[${idx}][jam_selesai]`;
                jmSelesai.setAttribute('onchange', `checkTimeSequence(${idx})`);
            }

            // Hapus tombol remove pada slot pertama jika hanya tersisa 1 slot
            const removeBtn = card.querySelector('.btn-remove-slot');
            if (idx === 0 && removeBtn) {
                removeBtn.remove();
            }
        });
    }

    // Modal Katalog Ruangan
    function openRoomCatalogModal() {
        targetSlotIndexForCatalog = 0;
        document.getElementById('roomCatalogModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function openCatalogForSlot(slotIndex) {
        targetSlotIndexForCatalog = slotIndex;
        document.getElementById('roomCatalogModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeRoomCatalogModal() {
        document.getElementById('roomCatalogModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    function closeCatalogOnBackdrop(e) {
        if (e.target.id === 'roomCatalogModal') {
            closeRoomCatalogModal();
        }
    }

    function selectRoomFromCatalog(roomId) {
        closeRoomCatalogModal();
        const select = document.getElementById(`room_select_${targetSlotIndexForCatalog}`);
        if (select) {
            select.value = roomId;
            updateLivePreview(targetSlotIndexForCatalog, roomId);
            const slotCard = document.getElementById(`roomSlot_${targetSlotIndexForCatalog}`);
            if (slotCard) {
                slotCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }

    // File name handler for PDF
    function handleFileChange(input) {
        const label = document.getElementById('fileUploadName');
        if (input.files && input.files[0]) {
            label.innerHTML = `<strong>File Terpilih:</strong> ${input.files[0].name} (${(input.files[0].size / 1024 / 1024).toFixed(2)} MB)`;
            label.style.color = '#059669';
        }
    }

    // Inisialisasi saat DOM siap
    document.addEventListener('DOMContentLoaded', function() {
        // Jika ada data old() (karena validation error), render ulang semua slot tersebut
        if (Array.isArray(OLD_ROOMS) && OLD_ROOMS.length > 0) {
            OLD_ROOMS.forEach(oldItem => {
                addNewRoomSlot(oldItem);
            });
        } else {
            // Default 1 slot pertama
            addNewRoomSlot({
                room_id: DEFAULT_PRESELECTED_ROOM,
                tanggal: DEFAULT_PRESELECTED_DATE,
            });
        }

        // Loading spinner saat form disubmit
        const form = document.getElementById('bookingFormElement');
        const btn = document.getElementById('btnSubmitBooking');
        const btnText = document.getElementById('btnSubmitText');

        if (form && btn) {
            form.addEventListener('submit', function() {
                btn.disabled = true;
                btn.style.opacity = '0.85';
                btn.style.cursor = 'not-allowed';
                btnText.innerHTML = '<span class="spinner-border-sm"></span> Memproses & Mengirim Pengajuan...';
            });
        }
    });
</script>
@endsection
