<div class="ketersediaan-layout">
    <!-- =========================================
         KOLOM KIRI: TANGGAL - BULAN - TAHUN
    ========================================= -->
    <aside class="ketersediaan-sidebar">
        <div class="sidebar-card">
            <div class="sidebar-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #08a6d9;"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                <h3>Pilih Tanggal</h3>
            </div>

            <!-- Form Pilih Tanggal Langsung -->
            <div class="date-picker-box">
                <label for="input-tanggal-ketersediaan" class="date-picker-label">Pilih Tanggal, Bulan, & Tahun:</label>
                <div class="date-input-wrapper">
                    <input type="date" 
                           id="input-tanggal-ketersediaan" 
                           class="date-input-field" 
                           value="{{ $selectedDate->format('Y-m-d') }}"
                           data-url="{{ route('ketersediaan') }}">
                </div>

                <!-- Tombol Pintas Tanggal -->
                <div class="quick-date-buttons">
                    <button type="button" class="btn-quick-date {{ $selectedDate->isToday() ? 'active' : '' }}" data-date="{{ now()->toDateString() }}">Hari Ini</button>
                    <button type="button" class="btn-quick-date {{ $selectedDate->isTomorrow() ? 'active' : '' }}" data-date="{{ now()->addDay()->toDateString() }}">Besok</button>
                    <button type="button" class="btn-quick-date {{ $selectedDate->isSameDay(now()->addDays(2)) ? 'active' : '' }}" data-date="{{ now()->addDays(2)->toDateString() }}">Lusa</button>
                    <button type="button" class="btn-quick-date {{ $selectedDate->isSameDay(now()->addDays(3)) ? 'active' : '' }}" data-date="{{ now()->addDays(3)->toDateString() }}">H+3</button>
                </div>
            </div>

            <!-- Kalender Mini Interaktif -->
            <div class="mini-calendar">
                <div class="mini-cal-header">
                    <button type="button" class="mini-cal-nav" data-cal-month="{{ $calCurrent->copy()->subMonth()->month }}" data-cal-year="{{ $calCurrent->copy()->subMonth()->year }}" title="Bulan Sebelumnya">‹</button>
                    <span class="mini-cal-title">{{ $calCurrent->translatedFormat('F Y') }}</span>
                    <button type="button" class="mini-cal-nav" data-cal-month="{{ $calCurrent->copy()->addMonth()->month }}" data-cal-year="{{ $calCurrent->copy()->addMonth()->year }}" title="Bulan Berikutnya">›</button>
                </div>

                <div class="mini-cal-grid">
                    <div class="mini-cal-day-name">Sen</div>
                    <div class="mini-cal-day-name">Sel</div>
                    <div class="mini-cal-day-name">Rab</div>
                    <div class="mini-cal-day-name">Kam</div>
                    <div class="mini-cal-day-name">Jum</div>
                    <div class="mini-cal-day-name">Sab</div>
                    <div class="mini-cal-day-name">Min</div>

                    @for ($i = 0; $i < $startDayOffset; $i++)
                        <div class="mini-cal-day empty"></div>
                    @endfor

                    @for ($d = 1; $d <= $daysInMonth; $d++)
                        @php
                            $loopDate = \Carbon\Carbon::create($calCurrent->year, $calCurrent->month, $d);
                            $isCurrentSelected = $loopDate->isSameDay($selectedDate);
                            $isToday = $loopDate->isToday();
                            $hasBooking = isset($bookedDayCounts[$d]);
                        @endphp
                        <button type="button" 
                                class="mini-cal-day {{ $isCurrentSelected ? 'selected' : '' }} {{ $isToday ? 'today' : '' }} {{ $hasBooking ? 'has-event' : '' }}"
                                data-date="{{ $loopDate->toDateString() }}"
                                title="{{ $loopDate->translatedFormat('d F Y') }} {{ $hasBooking ? '('.($bookedDayCounts[$d]['approved'] + $bookedDayCounts[$d]['pending']).' booking)' : '' }}">
                            <span class="day-number">{{ $d }}</span>
                            @if($hasBooking)
                                <span class="day-dot {{ ($bookedDayCounts[$d]['approved'] > 0) ? 'dot-approved' : 'dot-pending' }}"></span>
                            @endif
                        </button>
                    @endfor
                </div>
            </div>

            <!-- Ringkasan Ketersediaan Tanggal Ini -->
            <div class="sidebar-summary">
                <div class="summary-badge-date">
                    <span>Tanggal Terpilih:</span>
                    <strong>{{ $selectedDate->translatedFormat('l, d F Y') }}</strong>
                </div>

                <div class="summary-stats-grid">
                    <div class="stat-pill stat-total">
                        <span class="stat-num">{{ $totalRooms }}</span>
                        <span class="stat-lbl">Total Ruangan</span>
                    </div>
                    <div class="stat-pill stat-available">
                        <span class="stat-num">{{ $totalTersedia }}</span>
                        <span class="stat-lbl">Tersedia</span>
                    </div>
                    <div class="stat-pill stat-booked">
                        <span class="stat-num">{{ $totalTerbooking }}</span>
                        <span class="stat-lbl">Terbooking</span>
                    </div>
                </div>
            </div>

            <!-- Legenda Keterangan -->
            <div class="sidebar-legend">
                <span class="legend-item"><span class="legend-bullet bullet-available"></span> Ruangan Tersedia</span>
                <span class="legend-item"><span class="legend-bullet bullet-booked"></span> Ruangan Terbooking</span>
            </div>
        </div>
    </aside>

    <!-- =========================================
         KOLOM KANAN: STATUS RUANGAN (TERSEDIA & TERBOOKING)
    ========================================= -->
    <section class="ketersediaan-main">
        <div class="main-card">
            
            <div class="main-header-row">
                <div>
                    <span class="header-pre-title">KETERSEDIAAN RUANGAN</span>
                    <h2 class="main-date-title">{{ $selectedDate->translatedFormat('l, d F Y') }}</h2>
                    <p class="main-date-desc">
                        Berikut adalah status seluruh ruangan di Bakorwil III Malang pada tanggal yang Anda pilih.
                    </p>
                </div>

                <!-- Filter Tabs -->
                <div class="room-filter-tabs">
                    <button type="button" class="filter-tab-btn active" data-filter="all">Semua ({{ $totalRooms }})</button>
                    <button type="button" class="filter-tab-btn" data-filter="tersedia">Tersedia ({{ $totalTersedia }})</button>
                    <button type="button" class="filter-tab-btn" data-filter="terbooking">Terbooking ({{ $totalTerbooking }})</button>
                </div>
            </div>

            <!-- Daftar Ruangan -->
            <div class="rooms-status-list">
                @forelse($roomStatuses as $item)
                    @php
                        $room = $item['room'];
                        $status = $item['status'];
                        $bookings = $item['bookings'];
                        $isAvailable = ($status === 'tersedia');
                    @endphp

                    <article class="room-status-card {{ $isAvailable ? 'card-available' : 'card-booked' }}" data-status="{{ $status }}">
                        <div class="room-card-thumbnail" @if($room->image) style="background-image: url('{{ asset('storage/'.$room->image) }}')" @endif>
                            @unless($room->image)
                                <div class="thumbnail-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                    <span>{{ $room->name }}</span>
                                </div>
                            @endunless

                            <!-- Badge Status di atas gambar -->
                            <div class="thumbnail-status-badge {{ $isAvailable ? 'badge-green' : 'badge-red' }}">
                                @if($isAvailable)
                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#22c55e" stroke="none"><circle cx="12" cy="12" r="10"/></svg> TERSEDIA</span>
                                @else
                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#ef4444" stroke="none"><circle cx="12" cy="12" r="10"/></svg> TERBOOKING</span>
                                @endif
                            </div>
                        </div>

                        <div class="room-card-info">
                            <div class="room-info-header">
                                <div>
                                    <h3 class="room-title">{{ $room->name }}</h3>
                                    <div class="room-meta-tags">
                                        <span class="meta-tag">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                            Kapasitas {{ $room->capacity }} Kursi
                                        </span>
                                        @if($room->facilities)
                                            <span class="meta-tag meta-facility" title="{{ $room->facilities }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                                {{ Str::limit($room->facilities, 38) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="status-indicator-box">
                                    @if($isAvailable)
                                        <span class="status-pill status-pill-available">
                                            <span class="status-pulse-dot"></span>
                                            Tersedia Sepanjang Hari
                                        </span>
                                    @else
                                        <span class="status-pill status-pill-booked">
                                            <span class="status-solid-dot"></span>
                                            {{ $bookings->count() }} Kegiatan Terjadwal
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($isAvailable)
                                <!-- Keterangan Ruangan Tersedia -->
                                <div class="availability-notice notice-available">
                                    <div class="notice-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
                                    <div class="notice-text">
                                        <strong>Ruangan Kosong & Siap Digunakan</strong>
                                        <p>Belum ada jadwal peminjaman pada tanggal {{ $selectedDate->translatedFormat('d F Y') }}. Anda dapat langsung mengajukan peminjaman untuk ruangan ini.</p>
                                    </div>
                                </div>

                                <div class="room-action-row">
                                    <a href="{{ route('booking.form', [$room, 'tanggal' => $selectedDate->format('Y-m-d')]) }}" class="btn-action-book">
                                        Ajukan Peminjaman Ruangan Ini &rarr;
                                    </a>
                                </div>
                            @else
                                <!-- Jadwal Ruangan Terbooking -->
                                <div class="booked-schedule-box">
                                    <div class="booked-schedule-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        Jadwal Penggunaan Ruangan pada Tanggal Ini:
                                    </div>

                                    <div class="schedule-items-list">
                                        @foreach($bookings as $booking)
                                            <div class="schedule-item {{ $booking->status === 'disetujui' ? 'item-approved' : 'item-pending' }}">
                                                <div class="schedule-time-badge">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 3px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB
                                                </div>
                                                <div class="schedule-detail">
                                                    <div class="schedule-event-name">{{ $booking->nama_kegiatan }}</div>
                                                    <div class="schedule-instansi">
                                                        Oleh: <strong>{{ $booking->nama_pemohon }}</strong>
                                                        @if($booking->instansi)
                                                            ({{ $booking->instansi }})
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="schedule-status-badge">
                                                    @if($booking->status === 'disetujui')
                                                        <span class="badge-approved">Disetujui</span>
                                                    @else
                                                        <span class="badge-pending">Menunggu Konfirmasi</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="schedule-slot-hint">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg> <em>Catatan: Jika acara Anda berlangsung di luar jam kegiatan di atas, Anda masih dapat mengajukan peminjaman selama jadwal tidak berbenturan.</em>
                                    </div>
                                </div>

                                <div class="room-action-row">
                                    <a href="{{ route('booking.form', [$room, 'tanggal' => $selectedDate->format('Y-m-d')]) }}" class="btn-action-book btn-action-alternative">
                                        Ajukan Peminjaman (Pilih Jam Lain) &rarr;
                                    </a>
                                </div>
                            @endif

                        </div>
                    </article>
                @empty
                    <div class="empty-rooms-state">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <h3>Belum Ada Data Ruangan</h3>
                        <p>Silakan tambahkan data ruangan melalui Panel Administrator.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </section>
</div>
