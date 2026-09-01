@extends('layouts.app')

@section('title', 'SIPERON - Sistem Peminjaman Ruangan Online')

@section('content')

{{-- =========================================
     HERO
========================================= --}}

<section class="hero" id="tentang">

    <div class="container hero-content">

        <span class="hero-label">
            LAYANAN DIGITAL
        </span>

        <h1>
            SIPERON
        </h1>

        <h2>
            Sistem Peminjaman Ruangan Online
        </h2>

        <p>
            Layanan peminjaman ruangan tersedia untuk rapat,
            seminar, koordinasi, maupun kegiatan instansi.
            Proses peminjaman mudah, cepat, dan terintegrasi
            secara digital.
        </p>

        <div class="hero-actions">

            <a href="#ruangan" class="btn btn-primary">
                Lihat Ruangan
            </a>

            <a href="#alur" class="btn btn-outline">
                Pelajari Alur
            </a>

        </div>

    </div>

</section>



{{-- =========================================
     ALUR PEMINJAMAN
========================================= --}}

<section class="process-section" id="alur">

    <div class="container">

        <div class="section-heading">

            <span>PROSES PEMINJAMAN</span>

            <h2>
                Alur Peminjaman Ruang
            </h2>

            <p>
                Proses peminjaman ruangan dilakukan secara
                digital melalui SIPERON.
            </p>

        </div>


        <div class="process-grid">

            <div class="process-card">

                <div class="process-number">
                    01
                </div>

                <div class="process-icon">
                    🏢
                </div>

                <h3>
                    Pilih Ruangan
                </h3>

                <p>
                    Pilih ruangan yang sesuai dengan
                    kebutuhan kegiatan.
                </p>

            </div>


            <div class="process-card">

                <div class="process-number">
                    02
                </div>

                <div class="process-icon">
                    📅
                </div>

                <h3>
                    Periksa Jadwal
                </h3>

                <p>
                    Periksa ketersediaan ruangan
                    berdasarkan tanggal dan waktu.
                </p>

            </div>


            <div class="process-card">

                <div class="process-number">
                    03
                </div>

                <div class="process-icon">
                    📝
                </div>

                <h3>
                    Isi Pengajuan
                </h3>

                <p>
                    Lengkapi data kegiatan dan
                    dokumen persyaratan.
                </p>

            </div>


            <div class="process-card">

                <div class="process-number">
                    04
                </div>

                <div class="process-icon">
                    ✓
                </div>

                <h3>
                    Tunggu Persetujuan
                </h3>

                <p>
                    Pengajuan akan diperiksa dan
                    dikonfirmasi oleh pengelola.
                </p>

            </div>

        </div>

    </div>

</section>



{{-- =========================================
     KATALOG RUANGAN
========================================= --}}

<section class="rooms-section" id="ruangan">

    <div class="container">

        <div class="section-heading">

            <span>FASILITAS</span>

            <h2>
                Katalog Informasi Ruang
            </h2>

            <p>
                Bakorwil III Malang menyediakan pilihan
                ruangan representatif dengan kapasitas
                yang beragam.
            </p>

        </div>


        <div class="rooms-grid">

            {{-- RUANG ARJUNO --}}
            <article class="room-card">

                <div class="room-image room-arjuno">
                    <span>RUANG ARJUNO</span>
                </div>

                <div class="room-content">

                    <h3>
                        Ruang Arjuno
                    </h3>

                    <div class="room-capacity">
                        Kapasitas <strong>80 Kursi</strong>
                    </div>

                    <p>
                        Fasilitas:
                        Meja Besar, Layar LED,
                        Sound System, Pendingin Ruangan
                        dan WiFi.
                    </p>

                    <a href="#booking" class="room-link">
                        Lihat Detail →
                    </a>

                </div>

            </article>


            {{-- RUANG PANDERMAN --}}
            <article class="room-card">

                <div class="room-image room-panderman">
                    <span>RUANG PANDERMAN</span>
                </div>

                <div class="room-content">

                    <h3>
                        Ruang Panderman
                    </h3>

                    <div class="room-capacity">
                        Kapasitas <strong>30 Kursi</strong>
                    </div>

                    <p>
                        Fasilitas:
                        Meja, LED Proyektor,
                        Sound System, Pendingin Ruangan
                        dan WiFi.
                    </p>

                    <a href="#booking" class="room-link">
                        Lihat Detail →
                    </a>

                </div>

            </article>


            {{-- RUANG SEMERU --}}
            <article class="room-card">

                <div class="room-image room-semeru">
                    <span>RUANG SEMERU</span>
                </div>

                <div class="room-content">

                    <h3>
                        Ruang Semeru
                    </h3>

                    <div class="room-capacity">
                        Kapasitas <strong>25 Kursi</strong>
                    </div>

                    <p>
                        Fasilitas:
                        Meja, LED Proyektor,
                        Sound System, Pendingin Ruangan
                        dan WiFi.
                    </p>

                    <a href="#booking" class="room-link">
                        Lihat Detail →
                    </a>

                </div>

            </article>


            {{-- RUANG EJSC --}}
            <article class="room-card">

                <div class="room-image room-ejsc">
                    <span>EJSC</span>
                </div>

                <div class="room-content">

                    <h3>
                        Ruang EJSC
                    </h3>

                    <div class="room-capacity">
                        Kapasitas <strong>20+ Kursi</strong>
                    </div>

                    <p>
                        Ruang representatif untuk
                        kegiatan koordinasi, diskusi,
                        dan pertemuan.
                    </p>

                    <a href="#booking" class="room-link">
                        Lihat Detail →
                    </a>

                </div>

            </article>

        </div>

    </div>

</section>



{{-- =========================================
     JADWAL
========================================= --}}

<section class="schedule-section" id="jadwal">

    <div class="container">

        <div class="section-heading">

            <span>JADWAL</span>

            <h2>
                Jadwal Peminjaman Ruangan
            </h2>

            <p>
                Periksa jadwal penggunaan ruangan sebelum
                mengajukan peminjaman.
            </p>

        </div>


        <div class="calendar-wrapper">

            <div class="calendar-header">

                <button type="button">
                    ‹
                </button>

                <h3>
                    Juni 2026
                </h3>

                <button type="button">
                    ›
                </button>

            </div>


            <div class="calendar-grid">

                <div class="calendar-day-name">Sen</div>
                <div class="calendar-day-name">Sel</div>
                <div class="calendar-day-name">Rab</div>
                <div class="calendar-day-name">Kam</div>
                <div class="calendar-day-name">Jum</div>
                <div class="calendar-day-name">Sab</div>
                <div class="calendar-day-name">Min</div>


                @for ($i = 1; $i <= 30; $i++)

                    <div class="calendar-day">

                        <span>
                            {{ $i }}
                        </span>

                        @if ($i == 5 || $i == 12 || $i == 19)

                            <small class="calendar-event">
                                Terpakai
                            </small>

                        @endif

                    </div>

                @endfor

            </div>


            <div class="calendar-legend">

                <span>
                    <i class="legend available"></i>
                    Tersedia
                </span>

                <span>
                    <i class="legend booked"></i>
                    Terjadwal
                </span>

            </div>

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

                <span>
                    SIAP MENGAJUKAN PEMINJAMAN?
                </span>

                <h2>
                    Ajukan Peminjaman Ruangan
                </h2>

                <p>
                    Tidak perlu lagi menggunakan Google Form.
                    Pengajuan akan dilakukan langsung melalui
                    sistem SIPERON.
                </p>

            </div>


            <a href="#" class="btn btn-white">
                Ajukan Peminjaman
            </a>

        </div>

    </div>

</section>

@endsection