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
            <a href="#ruangan" class="btn btn-primary">Lihat Ruangan</a>
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
            <span>FASILITAS</span>
            <h2>Katalog Informasi Ruang</h2>
            <p>Bakorwil III Malang menyediakan pilihan ruangan representatif dengan kapasitas yang beragam.</p>
        </div>

        <div class="rooms-grid">
            @forelse ($rooms as $room)
                <article class="room-card">

                    <div class="room-image" @if($room->image) style="background-image:url('{{ asset('storage/'.$room->image) }}')" @endif>
                        @unless($room->image)
                            <span>{{ Str::upper($room->name) }}</span>
                        @endunless
                    </div>

                    <div class="room-content">
                        <h3>{{ $room->name }}</h3>

                        <div class="room-capacity">
                            Kapasitas <strong>{{ $room->capacity }} Kursi</strong>
                        </div>

                        <p>
                            @if($room->facilities)
                                Fasilitas: {{ $room->facilities }}
                            @else
                                {{ $room->description }}
                            @endif
                        </p>

                        <a href="{{ route('booking.form', $room) }}" class="room-link">
                            Ajukan Peminjaman →
                        </a>
                    </div>

                </article>
            @empty
                <p>Belum ada data ruangan. Silakan tambahkan melalui panel admin.</p>
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

@endsection

@section('scripts')
<script>
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
