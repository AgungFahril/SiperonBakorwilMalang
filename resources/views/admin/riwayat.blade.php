@extends('layouts.admin')

@section('title', 'Riwayat Penggunaan Ruangan - Admin SIPERON')

@section('content')
<style>
    /* Styling khusus Riwayat Penggunaan */
    .riwayat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .filter-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .filter-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .month-nav-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #334155;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .month-nav-btn:hover {
        background: #e2e8f0;
        color: var(--bakorwil-blue);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8, 166, 217, 0.2);
    }
    .month-nav-btn:active {
        transform: translateY(0);
    }

    .month-input-group {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .month-input-group input[type="month"] {
        padding: 0.55rem 0.85rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-weight: 600;
        color: #1e293b;
        background: #ffffff;
        font-size: 0.95rem;
        outline: none;
    }
    .month-input-group input[type="month"]:focus {
        border-color: var(--bakorwil-cyan);
        box-shadow: 0 0 0 3px rgba(8, 166, 217, 0.15);
    }

    .filter-select {
        padding: 0.55rem 0.85rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #334155;
        background: #ffffff;
        outline: none;
    }
    .filter-select:focus {
        border-color: var(--bakorwil-cyan);
    }

    .search-input {
        padding: 0.55rem 0.85rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.9rem;
        outline: none;
        min-width: 200px;
    }
    .search-input:focus {
        border-color: var(--bakorwil-cyan);
    }

    /* Kartu Ringkasan Bulanan */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.75rem;
    }

    .summary-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.15rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .summary-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .summary-icon svg {
        width: 26px;
        height: 26px;
    }
    .icon-cyan {
        background: #e0f2fe;
        color: #0284c7;
    }
    .icon-emerald {
        background: #d1fae5;
        color: #059669;
    }
    .icon-indigo {
        background: #e0e7ff;
        color: #4f46e5;
    }
    .icon-amber {
        background: #fef3c7;
        color: #d97706;
    }

    .summary-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .summary-val {
        font-size: 1.45rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.2;
    }

    .summary-subtext {
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-top: 3px;
    }

    /* Ruangan distribution section */
    .room-dist-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .room-dist-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .room-bars-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
    }

    .room-bar-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.85rem 1rem;
    }

    .room-bar-head {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 6px;
    }

    .room-bar-name {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1e293b;
    }

    .room-bar-stat {
        font-size: 0.82rem;
        font-weight: 700;
        color: #0284c7;
    }

    .progress-track {
        height: 7px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #0284c7, #38bdf8);
        border-radius: 4px;
    }

    /* Rekapitulasi Harian Section */
    .daily-section-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        margin-top: 0.5rem;
    }

    .daily-group-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .daily-header {
        background: #f8fafc;
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .daily-date-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .day-badge {
        background: var(--bakorwil-blue);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .daily-date-text {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
    }

    .daily-rooms-pills {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        align-items: center;
    }

    .room-pill {
        background: #e0f2fe;
        color: #0369a1;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 4px;
        border: 1px solid #bae6fd;
    }

    .daily-total-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.88rem;
        font-weight: 700;
    }

    .badge-duration {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #f1f5f9;
        color: #1e293b;
        border: 1px solid #cbd5e1;
        padding: 4px 9px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    /* Print styles */
    @media print {
        .admin-sidebar,
        .admin-header,
        .filter-card,
        .riwayat-header .btn,
        .action-column,
        .page-loading-bar {
            display: none !important;
        }

        .admin-main {
            margin-left: 0 !important;
            padding: 0 !important;
        }

        .admin-content {
            padding: 0 !important;
        }

        .daily-group-card,
        .summary-card,
        .room-dist-card {
            box-shadow: none !important;
            border: 1px solid #94a3b8 !important;
            page-break-inside: avoid;
        }

        body {
            background: #ffffff !important;
            color: #000000 !important;
        }

        .print-header {
            display: block !important;
            margin-bottom: 2rem;
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 1rem;
        }
    }

    .print-header {
        display: none;
    }
</style>

{{-- Header Cetak Resmi (Hanya muncul saat print) --}}
<div class="print-header">
    <h2 style="margin: 0; font-size: 1.3rem; text-transform: uppercase;">Pemerintah Provinsi Jawa Timur</h2>
    <h3 style="margin: 4px 0; font-size: 1.15rem; font-weight: 700;">Badan Koordinasi Wilayah Pemerintahan dan Pembangunan Malang</h3>
    <h4 style="margin: 6px 0 0 0; font-size: 1rem; color: #334155;">LAPORAN REKAPITULASI PENGGUNAAN RUANGAN</h4>
    <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: #64748b;">
        Periode Bulan: <strong>{{ $selectedMonth->locale('id')->translatedFormat('F Y') }}</strong> &bull; Dicetak pada: {{ now()->locale('id')->translatedFormat('d F Y H:i') }} WIB
    </p>
</div>

{{-- Top Row Header --}}
<div class="riwayat-header">
    <div>
        <div class="page-title">Riwayat Penggunaan Ruangan</div>
        <p class="page-subtitle" style="margin-top: 2px;">
            Laporan dan rekapitulasi durasi pemakaian ruangan per hari dan per bulan
        </p>
    </div>
    <div style="display: flex; gap: 8px; align-items: center;">
        <button type="button" class="btn btn-secondary" onclick="window.print()" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
            <span>Cetak / Cetak PDF</span>
        </button>
    </div>
</div>

{{-- Filter Card --}}
<div class="filter-card">
    <form action="{{ route('admin.riwayat.index') }}" method="GET" id="filterForm">
        <div class="filter-row">
            {{-- Navigasi Bulan --}}
            <div style="display: flex; align-items: center; gap: 6px;">
                <a href="{{ route('admin.riwayat.index', array_merge(request()->query(), ['bulan' => $prevMonth])) }}" class="month-nav-btn" title="Bulan Sebelumnya ({{ \Carbon\Carbon::createFromFormat('Y-m', $prevMonth)->locale('id')->translatedFormat('F Y') }})">
                    &larr;
                </a>
                
                <div class="month-input-group">
                    <input type="month" name="bulan" id="bulanInput" value="{{ $selectedMonthStr }}" onchange="document.getElementById('filterForm').submit()">
                </div>

                <a href="{{ route('admin.riwayat.index', array_merge(request()->query(), ['bulan' => $nextMonth])) }}" class="month-nav-btn" title="Bulan Berikutnya ({{ \Carbon\Carbon::createFromFormat('Y-m', $nextMonth)->locale('id')->translatedFormat('F Y') }})">
                    &rarr;
                </a>
                
                @if($selectedMonthStr !== now()->format('Y-m'))
                    <a href="{{ route('admin.riwayat.index', array_merge(request()->query(), ['bulan' => now()->format('Y-m')])) }}" class="btn btn-secondary" style="padding: 0.55rem 0.85rem; font-size: 0.82rem; font-weight: 600;">
                        Bulan Ini
                    </a>
                @endif
            </div>

            <div style="height: 24px; width: 1px; background: #cbd5e1; margin: 0 4px;"></div>

            {{-- Filter Ruangan --}}
            <div>
                <select name="room_id" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="">-- Semua Ruangan --</option>
                    @foreach($allRooms as $room)
                        <option value="{{ $room->id }}" {{ $roomId == $room->id ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Status --}}
            <div>
                <select name="status" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="digunakan" {{ $statusFilter === 'digunakan' ? 'selected' : '' }}>Status: Disetujui & Selesai</option>
                    <option value="disetujui" {{ $statusFilter === 'disetujui' ? 'selected' : '' }}>Status: Disetujui</option>
                    <option value="selesai" {{ $statusFilter === 'selesai' ? 'selected' : '' }}>Status: Selesai</option>
                    <option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>Status: Semua Status</option>
                </select>
            </div>

            {{-- Search Box --}}
            <div style="flex: 1; min-width: 180px;">
                <input type="text" name="search" value="{{ $search }}" class="search-input" placeholder="Cari kegiatan/pemohon..." style="width: 100%;">
            </div>

            <div style="display: flex; gap: 6px;">
                <button type="submit" class="btn btn-primary" style="padding: 0.55rem 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Filter</span>
                </button>
                @if($roomId || $statusFilter !== 'digunakan' || $search)
                    <a href="{{ route('admin.riwayat.index', ['bulan' => $selectedMonthStr]) }}" class="btn btn-secondary" style="padding: 0.55rem 0.85rem;" title="Reset filter">
                        Reset
                    </a>
                @endif
            </div>
        </div>
    </form>
</div>

{{-- Kartu Ringkasan Bulanan (Summary) --}}
<div class="summary-grid">
    {{-- Card 1: Total Jam Terpakai --}}
    <div class="summary-card">
        <div class="summary-icon icon-cyan">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <div>
            <div class="summary-label">Total Jam Terpakai</div>
            <div class="summary-val">{{ number_format($totalMonthlyHours, 1, ',', '.') }} Jam</div>
            <div class="summary-subtext">{{ $totalMonthlyLabel }} di bulan ini</div>
        </div>
    </div>

    {{-- Card 2: Hari Pemakaian --}}
    <div class="summary-card">
        <div class="summary-icon icon-emerald">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
        </div>
        <div>
            <div class="summary-label">Hari Terpakai</div>
            <div class="summary-val">{{ $totalDaysUsed }} Hari</div>
            <div class="summary-subtext">Dari {{ $selectedMonth->daysInMonth }} hari kalender</div>
        </div>
    </div>

    {{-- Card 3: Total Kegiatan / Sesi --}}
    <div class="summary-card">
        <div class="summary-icon icon-indigo">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <div>
            <div class="summary-label">Total Sesi Kegiatan</div>
            <div class="summary-val">{{ $totalBookingsCount }} Sesi</div>
            <div class="summary-subtext">Peminjaman disetujui / terlaksana</div>
        </div>
    </div>

    {{-- Card 4: Ruangan Paling Sering Dipakai --}}
    <div class="summary-card">
        <div class="summary-icon icon-amber">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
            </svg>
        </div>
        <div>
            <div class="summary-label">Ruangan Terbanyak Dipakai</div>
            <div class="summary-val" style="font-size: 1.15rem; word-break: break-word;">
                {{ $topRoom['name'] ?? '-' }}
            </div>
            <div class="summary-subtext">
                {{ $topRoom ? $topRoom['hours'] . ' Jam (' . $topRoom['count'] . ' kegiatan)' : 'Belum ada data' }}
            </div>
        </div>
    </div>
</div>

{{-- Rekapitulasi Pemakaian Per Ruangan --}}
@if(!empty($roomUsage))
    <div class="room-dist-card">
        <div class="room-dist-title">
            <span>Rekapitulasi Jam Pemakaian Tiap Ruangan &bull; {{ $selectedMonth->locale('id')->translatedFormat('F Y') }}</span>
            <span style="font-size: 0.8rem; font-weight: 500; color: var(--text-muted);">Total: {{ number_format($totalMonthlyHours, 1, ',', '.') }} Jam</span>
        </div>
        <div class="room-bars-grid">
            @foreach($roomUsage as $r)
                @php
                    $percentage = $totalMonthlyMinutes > 0 ? round(($r['minutes'] / $totalMonthlyMinutes) * 100) : 0;
                @endphp
                <div class="room-bar-item">
                    <div class="room-bar-head">
                        <span class="room-bar-name">{{ $r['name'] }}</span>
                        <span class="room-bar-stat">{{ number_format($r['hours'], 1, ',', '.') }} Jam ({{ $r['count'] }}x)</span>
                    </div>
                    <div class="progress-track" title="{{ $r['formatted_hours'] }} ({{ $percentage }}%)">
                        <div class="progress-fill" style="width: {{ $percentage }}%;"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 4px; font-size: 0.72rem; color: #64748b;">
                        <span>{{ $r['formatted_hours'] }}</span>
                        <span>{{ $percentage }}% dari total</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

{{-- Section Rekapitulasi Harian --}}
<div class="daily-section-title">
    <div>
        <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text-main); margin: 0;">
            Detail Penggunaan Tiap Hari
        </h3>
        <p style="margin: 2px 0 0 0; font-size: 0.85rem; color: var(--text-muted);">
            Rincian jam dan kegiatan pada masing-masing hari aktif di bulan {{ $selectedMonth->locale('id')->translatedFormat('F Y') }}
        </p>
    </div>
</div>

@forelse($dailyData as $dateKey => $day)
    <div class="daily-group-card">
        {{-- Header Kartu Harian --}}
        <div class="daily-header">
            <div class="daily-date-info">
                <span class="day-badge">{{ $day['day_name'] }}</span>
                <span class="daily-date-text">{{ $day['formatted_date'] }}</span>
                <div class="daily-rooms-pills">
                    @foreach($day['rooms_used'] as $rName)
                        <span class="room-pill">{{ $rName }}</span>
                    @endforeach
                </div>
            </div>

            <div class="daily-total-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Total Hari Ini: <strong>{{ number_format($day['total_hours'], 1, ',', '.') }} Jam</strong> ({{ $day['total_label'] }})</span>
            </div>
        </div>

        {{-- Tabel Peminjaman pada Hari Ini --}}
        <div class="table-responsive">
            <table class="table" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th style="width: 140px;">Waktu & Jam</th>
                        <th style="width: 120px;">Durasi</th>
                        <th>Ruangan</th>
                        <th>Nama Kegiatan</th>
                        <th>Pemohon & Instansi</th>
                        <th style="width: 100px;">Status</th>
                        <th class="action-column" style="width: 90px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($day['bookings'] as $booking)
                        <tr>
                            <td>
                                <strong style="color: #0f172a; font-size: 0.9rem;">
                                    {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                </strong>
                                <div style="font-size: 0.72rem; color: var(--text-muted);">WIB</div>
                            </td>
                            <td>
                                <span class="badge-duration">
                                    {{ $booking->durasi_label }}
                                </span>
                            </td>
                            <td>
                                <strong style="color: var(--bakorwil-blue);">{{ $booking->room->name ?? '-' }}</strong>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: var(--text-main); font-size: 0.88rem;">
                                    {{ $booking->nama_kegiatan }}
                                </div>
                                <div style="font-size: 0.75rem; color: var(--bakorwil-cyan); font-weight: 600; margin-top: 2px;">
                                    {{ $booking->kode_booking ?? '#'.$booking->id }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 600; font-size: 0.85rem; color: #1e293b;">
                                    {{ $booking->nama_pemohon }}
                                </div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">
                                    {{ $booking->instansi ?? '-' }}
                                </div>
                            </td>
                            <td>
                                @if($booking->status === 'disetujui')
                                    <span class="status-badge status-approved">Disetujui</span>
                                @elseif($booking->status === 'selesai')
                                    <span class="status-badge status-done">Selesai</span>
                                @elseif($booking->status === 'dijadwalkan_ulang')
                                    <span class="status-badge" style="background: #e0e7ff; color: #3730a3; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 0.75rem;">Jadwal Ulang</span>
                                @elseif($booking->status === 'ditolak')
                                    <span class="status-badge status-rejected">Ditolak</span>
                                @else
                                    <span class="status-badge status-pending">Menunggu</span>
                                @endif
                            </td>
                            <td class="action-column" style="text-align: center;">
                                <a href="{{ route('admin.peminjaman.show', $booking) }}" class="btn-table-detail" title="Lihat Detail Peminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@empty
    <div class="card" style="padding: 3rem 2rem; text-align: center;">
        <div style="width: 64px; height: 64px; border-radius: 50%; background: #f1f5f9; color: #94a3b8; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-3.75h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
            </svg>
        </div>
        <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e293b; margin: 0 0 6px 0;">
            Tidak Ada Riwayat Penggunaan Ruangan
        </h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; max-width: 480px; margin: 0 auto 1.25rem auto;">
            Tidak ditemukan catatan pemakaian ruangan pada bulan <strong>{{ $selectedMonth->locale('id')->translatedFormat('F Y') }}</strong> dengan kriteria filter yang dipilih.
        </p>
        <div style="display: flex; gap: 8px; justify-content: center;">
            @if($selectedMonthStr !== now()->format('Y-m'))
                <a href="{{ route('admin.riwayat.index', ['bulan' => now()->format('Y-m')]) }}" class="btn btn-primary" style="font-size: 0.85rem;">
                    Buka Bulan Ini ({{ now()->locale('id')->translatedFormat('F Y') }})
                </a>
            @endif
            @if($roomId || $statusFilter !== 'digunakan' || $search)
                <a href="{{ route('admin.riwayat.index', ['bulan' => $selectedMonthStr]) }}" class="btn btn-secondary" style="font-size: 0.85rem;">
                    Reset Filter
                </a>
            @endif
        </div>
    </div>
@endforelse

@endsection
