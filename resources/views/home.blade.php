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
                <div class="process-icon">🏢</div>
                <h3>Pilih Ruangan</h3>
                <p>Pilih ruangan yang sesuai dengan kebutuhan kegiatan.</p>
            </div>
            <div class="process-card">
                <div class="process-number">02</div>
                <div class="process-icon">📅</div>
                <h3>Periksa Jadwal</h3>
                <p>Periksa ketersediaan ruangan berdasarkan tanggal dan waktu.</p>
            </div>
            <div class="process-card">
                <div class="process-number">03</div>
                <div class="process-icon">📝</div>
                <h3>Isi Pengajuan</h3>
                <p>Lengkapi data kegiatan dan dokumen persyaratan.</p>
            </div>
            <div class="process-card">
                <div class="process-number">04</div>
                <div class="process-icon">✓</div>
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

        <div class="calendar-wrapper">

            <div class="calendar-header">
                <a href="{{ route('home', ['month' => $current->copy()->subMonth()->month, 'year' => $current->copy()->subMonth()->year]) }}#jadwal"
                   aria-label="Bulan sebelumnya">‹</a>
                <h3>{{ $current->translatedFormat('F Y') }}</h3>
                <a href="{{ route('home', ['month' => $current->copy()->addMonth()->month, 'year' => $current->copy()->addMonth()->year]) }}#jadwal"
                   aria-label="Bulan berikutnya">›</a>
            </div>

            <div class="calendar-grid">
                <div class="calendar-day-name">Sen</div>
                <div class="calendar-day-name">Sel</div>
                <div class="calendar-day-name">Rab</div>
                <div class="calendar-day-name">Kam</div>
                <div class="calendar-day-name">Jum</div>
                <div class="calendar-day-name">Sab</div>
                <div class="calendar-day-name">Min</div>

                {{-- Sel kosong sebelum tanggal 1 (Senin = 0, Minggu = 6) --}}
                @for ($i = 0; $i < $current->copy()->startOfMonth()->dayOfWeekIso - 1; $i++)
                    <div class="calendar-day"></div>
                @endfor

                @for ($i = 1; $i <= $daysInMonth; $i++)
                    <div class="calendar-day">
                        <span>{{ $i }}</span>
                        @if ($bookedDays->contains($i))
                            <small class="calendar-event">Terpakai</small>
                        @endif
                    </div>
                @endfor
            </div>

            <div class="calendar-legend">
                <span><i class="legend available"></i> Tersedia</span>
                <span><i class="legend booked"></i> Terjadwal</span>
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
                <span>SIAP MENGAJUKAN PEMINJAMAN?</span>
                <h2>Ajukan Peminjaman Ruangan</h2>
                <p>Tidak perlu lagi menggunakan Google Form. Pengajuan dilakukan langsung melalui sistem SIPERON.</p>
            </div>

            <a href="#ruangan" class="btn btn-white">Ajukan Peminjaman</a>
        </div>
    </div>
</section>

@endsection