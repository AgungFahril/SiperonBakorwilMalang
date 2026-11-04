@extends('layouts.app')

@section('title', 'SIPERON - Sistem Peminjaman Ruangan Online')

@section('content')

@if (session('status'))
    <div class="alert alert-success container">
        {{ session('status') }}
    </div>
@endif

{{-- =========================================
     HERO
========================================= --}}
<section class="hero" id="tentang">
    <div class="container hero-content">
        <span class="hero-label">LAYANAN DIGITAL</span>
        <h1>SIPERON</h1>
        <h2>Sistem Peminjaman Ruangan Online</h2>
        <p>
            Layanan peminjaman ruangan tersedia untuk rapat, seminar, koordinasi,
            maupun kegiatan instansi. Proses peminjaman mudah, cepat, dan terintegrasi
            secara digital.
        </p>
        <div class="hero-actions">
            <a href="{{ route('ketersediaan') }}" class="btn btn-primary">Cek Ketersediaan Ruangan</a>
            <a href="#ruangan" class="btn btn-outline">Lihat Ruangan</a>
            <a href="#alur" class="btn btn-outline">Pelajari Alur</a>
        </div>
    </div>
</section>


{{-- =========================================
     ALUR PEMINJAMAN  (statis, memang hanya penjelasan proses)
========================================= --}}
<section class="process-section" id="alur">
    <div class="container">
        <div class="section-heading">
            <span>PROSES PEMINJAMAN</span>
            <h2>Alur Peminjaman Ruang</h2>
            <p>Proses peminjaman ruangan dilakukan secara digital melalui SIPERON.</p>
        </div>

        <div class="process-grid">
            <div class="process-card">
                <div class="process-number">01</div>
                <div class="process-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #08a6d9;"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>
                </div>
                <h3>Pilih Ruangan</h3>
                <p>Pilih ruangan yang sesuai dengan kebutuhan kegiatan.</p>
            </div>
            <div class="process-card">
                <div class="process-number">02</div>
                <div class="process-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #08a6d9;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <h3>Periksa Jadwal</h3>
                <p>Periksa ketersediaan ruangan berdasarkan tanggal dan waktu.</p>
            </div>
            <div class="process-card">
                <div class="process-number">03</div>
                <div class="process-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #08a6d9;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <h3>Isi Pengajuan</h3>
                <p>Lengkapi data kegiatan dan dokumen persyaratan.</p>
            </div>
            <div class="process-card">
                <div class="process-number">04</div>
                <div class="process-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #08a6d9;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <h3>Tunggu Persetujuan</h3>
                <p>Pengajuan akan diperiksa dan dikonfirmasi oleh pengelola.</p>
            </div>
        </div>
    </div>
</section>


{{-- =========================================
     KATALOG RUANGAN — DIAMBIL DARI DATABASE
========================================= --}}
<section class="rooms-section" id="ruangan">
    <div class="container">
        <div class="section-heading">
            <span>FASILITAS REPRESENTATIF</span>
            <h2>Katalog Informasi Ruang</h2>
            <p>Bakorwil III Malang menyediakan berbagai pilihan ruangan representatif dengan fasilitas lengkap dan foto dari berbagai sudut.</p>
        </div>

        <div class="rooms-grid">
            @forelse ($rooms as $room)
                @php
                    $roomImages = $room->images->isNotEmpty() 
                        ? $room->images 
                        : ($room->image ? collect([(object)['path' => $room->image]]) : collect());
                    $totalPhotos = $roomImages->count();
                @endphp

                <article class="room-card modern-room-card" data-room-id="{{ $room->id }}">
                    <!-- Media Carousel Container -->
                    <div class="room-media-box">
                        @if($totalPhotos > 0)
                            <div class="room-carousel" id="carousel_{{ $room->id }}" data-current-index="0" data-total="{{ $totalPhotos }}">
                                <div class="carousel-track">
                                    @foreach($roomImages as $idx => $img)
                                        <div class="carousel-slide {{ $idx === 0 ? 'active' : '' }}" data-slide-index="{{ $idx }}">
                                            <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $room->name }} - Sudut {{ $idx + 1 }}" loading="lazy" onclick="openRoomLightbox({{ $room->id }}, {{ $idx }})">
                                        </div>
                                    @endforeach
                                </div>

                                @if($totalPhotos > 1)
                                    <!-- Carousel Controls -->
                                    <button type="button" class="carousel-nav-btn btn-prev" onclick="moveRoomSlide({{ $room->id }}, -1, event)" aria-label="Foto Sebelumnya">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                    </button>
                                    <button type="button" class="carousel-nav-btn btn-next" onclick="moveRoomSlide({{ $room->id }}, 1, event)" aria-label="Foto Selanjutnya">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                    </button>

                                    <!-- Dots indicator -->
                                    <div class="carousel-indicators">
                                        @foreach($roomImages as $idx => $img)
                                            <span class="indicator-dot {{ $idx === 0 ? 'active' : '' }}" onclick="goToRoomSlide({{ $room->id }}, {{ $idx }}, event)"></span>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Angle Count Pill -->
                                <div class="photo-angle-pill" onclick="openRoomLightbox({{ $room->id }}, 0)" title="Klik untuk memperbesar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                                    <span id="counterText_{{ $room->id }}">{{ $totalPhotos > 1 ? '1/' . $totalPhotos . ' Sudut' : '1 Foto' }}</span>
                                </div>

                                <button type="button" class="btn-quick-zoom" onclick="openRoomLightbox({{ $room->id }}, 0)" title="Perbesar foto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                                </button>
                            </div>
                        @else
                            <div class="room-media-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>{{ $room->name }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="room-content modern-room-content">
                        <div class="room-header-row">
                            <h3 class="room-title-text">{{ $room->name }}</h3>
                            <div class="room-capacity-pill">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                {{ $room->capacity }} Kursi
                            </div>
                        </div>

                        @if($room->description)
                            <p class="room-description-text">{{ Str::limit($room->description, 100) }}</p>
                        @endif

                        <!-- Modern Facilities Badges -->
                        @if(!empty($room->facilities_list))
                            <div class="facilities-section-box">
                                <div class="facilities-label">Fasilitas Ruangan:</div>
                                <div class="facility-badges-wrap">
                                    @foreach($room->facilities_list as $fItem)
                                        <span class="facility-chip">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            {{ $fItem }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="room-footer-actions">
                            <a href="{{ route('booking.form.multi', ['room' => $room->id]) }}" class="room-action-btn">
                                <span>Ajukan Peminjaman</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>
                    </div>

                    {{-- Data JSON untuk Lightbox Modal --}}
                    <script type="application/json" id="roomGalleryData_{{ $room->id }}">
                        {!! json_encode([
                            'id' => $room->id,
                            'name' => $room->name,
                            'capacity' => $room->capacity,
                            'facilities' => $room->facilities_list,
                            'images' => $roomImages->map(function($img) {
                                return asset('storage/' . $img->path);
                            })->values()
                        ]) !!}
                    </script>
                </article>
            @empty
                <div class="empty-rooms-box">
                    <p>Belum ada data ruangan aktif. Silakan tambahkan melalui panel admin.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>


{{-- =========================================
     JADWAL — DIAMBIL DARI DATABASE (booking berstatus 'disetujui')
========================================= --}}
<section class="schedule-section" id="jadwal">
    <div class="container">
        <div class="section-heading">
            <span>JADWAL</span>
            <h2>Jadwal Peminjaman Ruangan</h2>
            <p>Periksa jadwal penggunaan ruangan sebelum mengajukan peminjaman.</p>
            <div style="margin-top: 14px;">
                <a href="{{ route('ketersediaan') }}" class="btn btn-outline" style="font-size: 13px; padding: 8px 18px; border-color: #08a6d9; color: #08a6d9; display: inline-flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    Buka Kalender & Status Ketersediaan per Tanggal &rarr;
                </a>
            </div>
        </div>

        <div class="calendar-wrapper" id="calendar-container">
            @include('partials.calendar')
        </div>
    </div>
</section>


{{-- =========================================
     CTA BOOKING
========================================= --}}
<section class="booking-section" id="booking">
    <div class="container">
        <div class="booking-box">
            <div>
                <span>SIAP MENGAJUKAN PEMINJAMAN?</span>
                <h2>Ajukan Peminjaman Ruangan</h2>
                <p>Tidak perlu lagi menggunakan Google Form. Pengajuan dilakukan langsung melalui sistem SIPERON.</p>
            </div>

            <a href="#ruangan" class="btn btn-white">Ajukan Peminjaman</a>
        </div>
    </div>
</section>

{{-- =========================================
     MODAL LIGHTBOX GALERI FOTO RUANGAN (FULLSCREEN INTERAKTIF)
========================================= --}}
<div id="roomLightboxModal" class="room-lightbox-backdrop" style="display: none;" onclick="closeRoomLightbox(event)">
    <div class="room-lightbox-dialog" onclick="event.stopPropagation()">
        <div class="lightbox-top-bar">
            <div class="lightbox-room-info">
                <h3 id="lightboxRoomTitle" class="lightbox-title">Nama Ruangan</h3>
                <span id="lightboxRoomCapacity" class="lightbox-badge">Kapasitas Kursi</span>
            </div>
            <button type="button" class="lightbox-close-btn" onclick="closeRoomLightbox(event)" title="Tutup (ESC)">&times;</button>
        </div>

        <div class="lightbox-main-stage">
            <button type="button" class="lightbox-arrow-btn arrow-prev" onclick="stepLightbox(-1)" title="Foto Sebelumnya" id="lightboxBtnPrev">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <div class="lightbox-img-wrapper">
                <img id="lightboxMainImg" src="" alt="Foto Ruangan Bakorwil III Malang">
            </div>
            <button type="button" class="lightbox-arrow-btn arrow-next" onclick="stepLightbox(1)" title="Foto Selanjutnya" id="lightboxBtnNext">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>

        <div class="lightbox-bottom-bar">
            <div class="lightbox-thumbs-scroll" id="lightboxThumbStrip"></div>
            <div class="lightbox-counter-label" id="lightboxCounter">1 / 1 Sudut Foto</div>
        </div>
    </div>
</div>

<style>
    /* Modern Room Card Enhancements */
    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 20px;
    }

    .modern-room-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }

    .modern-room-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 36px rgba(8, 166, 217, 0.12);
        border-color: #cbd5e1;
    }

    /* Media Box & Carousel */
    .room-media-box {
        position: relative;
        height: 250px;
        background: #0f172a;
        overflow: hidden;
    }

    .room-carousel {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .carousel-track {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .carousel-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease-in-out, visibility 0.4s;
    }

    .carousel-slide.active {
        opacity: 1;
        visibility: visible;
        z-index: 1;
    }

    .carousel-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        cursor: pointer;
        transition: transform 0.5s ease;
    }

    .modern-room-card:hover .carousel-slide.active img {
        transform: scale(1.04);
    }

    /* Carousel Nav Buttons */
    .carousel-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 34px;
        height: 34px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(6px);
        color: #0f172a;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 3;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
        opacity: 0;
        transition: all 0.25s ease;
    }

    .modern-room-card:hover .carousel-nav-btn {
        opacity: 1;
    }

    .carousel-nav-btn.btn-prev { left: 12px; }
    .carousel-nav-btn.btn-next { right: 12px; }

    .carousel-nav-btn:hover {
        background: #ffffff;
        color: var(--bakorwil-cyan);
        transform: translateY(-50%) scale(1.12);
    }

    /* Indicators */
    .carousel-indicators {
        position: absolute;
        bottom: 12px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 6px;
        z-index: 3;
        padding: 4px 8px;
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(4px);
        border-radius: 20px;
    }

    .indicator-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .indicator-dot.active {
        width: 18px;
        border-radius: 10px;
        background: #ffffff;
    }

    /* Photo Count Badge */
    .photo-angle-pill {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(15, 23, 42, 0.82);
        backdrop-filter: blur(6px);
        color: #ffffff;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        z-index: 2;
        cursor: pointer;
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.2s ease;
    }

    .photo-angle-pill:hover {
        background: var(--bakorwil-cyan);
        color: white;
        border-color: transparent;
    }

    .btn-quick-zoom {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 32px;
        height: 32px;
        background: rgba(15, 23, 42, 0.82);
        backdrop-filter: blur(6px);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 2;
        transition: all 0.2s ease;
    }

    .btn-quick-zoom:hover {
        background: var(--bakorwil-cyan);
        transform: scale(1.1);
    }

    .room-media-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #94a3b8;
        background: linear-gradient(135deg, #1e293b, #334155);
    }

    /* Modern Card Body */
    .modern-room-content {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .room-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 10px;
    }

    .room-title-text {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        line-height: 1.3;
    }

    .room-capacity-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f0fdfa;
        color: #0f766e;
        border: 1px solid #ccfbf1;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .room-description-text {
        font-size: 13.5px;
        color: #64748b;
        line-height: 1.55;
        margin: 0 0 16px 0;
    }

    /* Modern Facilities Badges */
    .facilities-section-box {
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px dashed #e2e8f0;
        margin-bottom: 20px;
    }

    .facilities-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    .facility-badges-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .facility-chip {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        font-size: 12px;
        font-weight: 500;
        padding: 3px 9px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .facility-chip svg {
        color: #08a6d9;
    }

    .facility-chip:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    /* Card Action Button */
    .room-footer-actions {
        margin-top: 6px;
    }

    .room-action-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: linear-gradient(135deg, #08a6d9, #0284c7);
        color: #ffffff !important;
        font-size: 14px;
        font-weight: 600;
        padding: 12px 20px;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(8, 166, 217, 0.25);
    }

    .room-action-btn:hover {
        background: linear-gradient(135deg, #0284c7, #0369a1);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(8, 166, 217, 0.35);
        color: white !important;
    }

    .room-action-btn svg {
        transition: transform 0.25s ease;
    }

    .room-action-btn:hover svg {
        transform: translateX(4px);
    }

    /* Lightbox Modal Styles */
    .room-lightbox-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(10, 15, 29, 0.92);
        backdrop-filter: blur(8px);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .room-lightbox-dialog {
        background: #111827;
        width: 100%;
        max-width: 960px;
        max-height: 92vh;
        border-radius: 18px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .lightbox-top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        background: #1f2937;
    }

    .lightbox-title {
        color: #ffffff;
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0 0 2px 0;
    }

    .lightbox-badge {
        color: #38bdf8;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .lightbox-close-btn {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #ffffff;
        font-size: 26px;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        transition: all 0.2s;
    }

    .lightbox-close-btn:hover {
        background: #ef4444;
        transform: rotate(90deg);
    }

    .lightbox-main-stage {
        position: relative;
        flex: 1;
        min-height: 380px;
        max-height: 520px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #0b0f19;
        overflow: hidden;
    }

    .lightbox-img-wrapper {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
    }

    .lightbox-img-wrapper img {
        max-width: 100%;
        max-height: 480px;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        transition: opacity 0.25s ease;
    }

    .lightbox-arrow-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(6px);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 5;
        transition: all 0.2s;
    }

    .lightbox-arrow-btn:hover {
        background: var(--bakorwil-cyan);
        transform: translateY(-50%) scale(1.1);
    }

    .lightbox-arrow-btn.arrow-prev { left: 16px; }
    .lightbox-arrow-btn.arrow-next { right: 16px; }

    .lightbox-bottom-bar {
        padding: 14px 20px;
        background: #1f2937;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .lightbox-thumbs-scroll {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 4px;
    }

    .lightbox-thumb-item {
        width: 56px;
        height: 42px;
        border-radius: 6px;
        overflow: hidden;
        cursor: pointer;
        opacity: 0.5;
        border: 2px solid transparent;
        flex-shrink: 0;
        transition: all 0.2s;
    }

    .lightbox-thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .lightbox-thumb-item.active {
        opacity: 1;
        border-color: #38bdf8;
        transform: scale(1.05);
    }

    .lightbox-counter-label {
        color: #94a3b8;
        font-size: 0.85rem;
        font-weight: 500;
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .rooms-grid {
            grid-template-columns: 1fr;
        }
        .lightbox-main-stage {
            min-height: 260px;
        }
    }
</style>

@endsection

@section('scripts')
<script>
    // === ROOM CARD CAROUSEL SCRIPT ===
    function moveRoomSlide(roomId, step, event) {
        if (event) {
            event.stopPropagation();
            event.preventDefault();
        }

        const carousel = document.getElementById('carousel_' + roomId);
        if (!carousel) return;

        const slides = carousel.querySelectorAll('.carousel-slide');
        const dots = carousel.querySelectorAll('.indicator-dot');
        const counterEl = document.getElementById('counterText_' + roomId);
        const total = slides.length;
        if (total <= 1) return;

        let currentIndex = parseInt(carousel.getAttribute('data-current-index') || '0', 10);
        let newIndex = (currentIndex + step + total) % total;

        slides[currentIndex].classList.remove('active');
        slides[newIndex].classList.add('active');

        if (dots.length > 0) {
            dots[currentIndex].classList.remove('active');
            dots[newIndex].classList.add('active');
        }

        if (counterEl) {
            counterEl.textContent = (newIndex + 1) + '/' + total + ' Sudut';
        }

        carousel.setAttribute('data-current-index', newIndex);
    }

    function goToRoomSlide(roomId, targetIndex, event) {
        if (event) {
            event.stopPropagation();
            event.preventDefault();
        }

        const carousel = document.getElementById('carousel_' + roomId);
        if (!carousel) return;

        const slides = carousel.querySelectorAll('.carousel-slide');
        const dots = carousel.querySelectorAll('.indicator-dot');
        const counterEl = document.getElementById('counterText_' + roomId);
        const total = slides.length;
        if (total <= 1 || targetIndex < 0 || targetIndex >= total) return;

        let currentIndex = parseInt(carousel.getAttribute('data-current-index') || '0', 10);
        if (currentIndex === targetIndex) return;

        slides[currentIndex].classList.remove('active');
        slides[targetIndex].classList.add('active');

        if (dots.length > 0) {
            dots[currentIndex].classList.remove('active');
            dots[targetIndex].classList.add('active');
        }

        if (counterEl) {
            counterEl.textContent = (targetIndex + 1) + '/' + total + ' Sudut';
        }

        carousel.setAttribute('data-current-index', targetIndex);
    }

    // === ROOM GALLERY LIGHTBOX SCRIPT ===
    let currentLightboxRoom = null;
    let currentLightboxIndex = 0;

    function openRoomLightbox(roomId, initialIndex) {
        const dataEl = document.getElementById('roomGalleryData_' + roomId);
        if (!dataEl) return;

        try {
            currentLightboxRoom = JSON.parse(dataEl.textContent);
        } catch (e) {
            console.error('Error parsing room gallery JSON:', e);
            return;
        }

        if (!currentLightboxRoom || !currentLightboxRoom.images || currentLightboxRoom.images.length === 0) {
            return;
        }

        currentLightboxIndex = (typeof initialIndex === 'number' && initialIndex >= 0) ? initialIndex : 0;

        document.getElementById('lightboxRoomTitle').textContent = currentLightboxRoom.name;
        document.getElementById('lightboxRoomCapacity').textContent = 'Kapasitas ' + currentLightboxRoom.capacity + ' Kursi';

        // Render Thumbnails
        const thumbStrip = document.getElementById('lightboxThumbStrip');
        thumbStrip.innerHTML = '';

        currentLightboxRoom.images.forEach((imgUrl, i) => {
            const thumb = document.createElement('div');
            thumb.className = 'lightbox-thumb-item' + (i === currentLightboxIndex ? ' active' : '');
            thumb.innerHTML = '<img src="' + imgUrl + '" alt="Thumb ' + (i + 1) + '">';
            thumb.onclick = function() {
                setLightboxIndex(i);
            };
            thumbStrip.appendChild(thumb);
        });

        // Hide arrows if only 1 image
        const hasMultiple = currentLightboxRoom.images.length > 1;
        document.getElementById('lightboxBtnPrev').style.display = hasMultiple ? 'flex' : 'none';
        document.getElementById('lightboxBtnNext').style.display = hasMultiple ? 'flex' : 'none';

        updateLightboxStage();

        const modal = document.getElementById('roomLightboxModal');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // prevent bg scroll
    }

    function setLightboxIndex(index) {
        if (!currentLightboxRoom) return;
        currentLightboxIndex = index;
        updateLightboxStage();
    }

    function stepLightbox(step) {
        if (!currentLightboxRoom || currentLightboxRoom.images.length <= 1) return;
        const total = currentLightboxRoom.images.length;
        currentLightboxIndex = (currentLightboxIndex + step + total) % total;
        updateLightboxStage();
    }

    function updateLightboxStage() {
        if (!currentLightboxRoom) return;

        const mainImg = document.getElementById('lightboxMainImg');
        const counterEl = document.getElementById('lightboxCounter');
        const total = currentLightboxRoom.images.length;

        mainImg.style.opacity = '0.3';
        mainImg.src = currentLightboxRoom.images[currentLightboxIndex];
        mainImg.onload = function() {
            mainImg.style.opacity = '1';
        };

        counterEl.textContent = 'Sudut ' + (currentLightboxIndex + 1) + ' dari ' + total + ' Foto';

        // Update active thumb
        const thumbs = document.querySelectorAll('.lightbox-thumb-item');
        thumbs.forEach((th, idx) => {
            if (idx === currentLightboxIndex) {
                th.classList.add('active');
                th.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } else {
                th.classList.remove('active');
            }
        });
    }

    function closeRoomLightbox(event) {
        if (event) {
            event.preventDefault();
        }
        const modal = document.getElementById('roomLightboxModal');
        if (modal) {
            modal.style.display = 'none';
        }
        document.body.style.overflow = '';
        currentLightboxRoom = null;
    }

    // Keyboard support: ESC to close, Left/Right arrow to navigate
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('roomLightboxModal');
        if (modal && modal.style.display === 'flex') {
            if (e.key === 'Escape') {
                closeRoomLightbox();
            } else if (e.key === 'ArrowLeft') {
                stepLightbox(-1);
            } else if (e.key === 'ArrowRight') {
                stepLightbox(1);
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const calendarContainer = document.getElementById('calendar-container');

        calendarContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('calendar-nav-btn')) {
                e.preventDefault();
                
                const month = e.target.getAttribute('data-month');
                const year = e.target.getAttribute('data-year');
                
                fetch(`/?month=${month}&year=${year}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => { calendarContainer.innerHTML = html; })
                .catch(error => console.error('Error fetching calendar:', error));
            }
        });

        // ScrollSpy functionality
        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('section, footer');

        // Initial click handler
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Intersection Observer for scrolling
        const observerOptions = {
            root: null,
            rootMargin: '-50% 0px -50% 0px', // Trigger exactly in the middle of viewport
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    if (id) {
                        // Special case: if we are at the very top, highlight BERANDA instead of TENTANG
                        const scrollPos = window.scrollY;
                        
                        navLinks.forEach(nav => {
                            nav.classList.remove('active');
                            const href = nav.getAttribute('href');
                            
                            if (scrollPos < 100 && id === 'tentang') {
                                if (href === '{{ url('/') }}') nav.classList.add('active');
                            } else {
                                if (href && href.endsWith('#' + id)) {
                                    nav.classList.add('active');
                                }
                            }
                        });
                    }
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            if (section.getAttribute('id')) {
                observer.observe(section);
            }
        });
        
        // Listen to scroll to handle the absolute top position
        window.addEventListener('scroll', function() {
            if (window.scrollY < 100) {
                navLinks.forEach(nav => {
                    nav.classList.remove('active');
                    if (nav.getAttribute('href') === '{{ url('/') }}') {
                        nav.classList.add('active');
                    }
                });
            }
        });
    });
</script>
@endsection
