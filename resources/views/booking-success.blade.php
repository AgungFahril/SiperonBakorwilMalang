@extends('layouts.app')

@section('title', 'Pengajuan Berhasil - SIPERON')

@section('content')
<section class="booking-success-section">
    <div class="container" style="max-width: 780px;">

        <!-- Success Animation/Icon -->
        <div class="success-icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#059669">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </div>

        <div class="success-header-text">
            <h1>Pengajuan Berhasil Dikirim!</h1>
            <p>Terima kasih, permohonan peminjaman ruangan Anda telah kami terima dan saat ini sedang menunggu verifikasi petugas Bakorwil III Malang.</p>
        </div>

        @php
            $count = isset($bookings) ? $bookings->count() : 1;
            $first = isset($bookings) && $bookings->isNotEmpty() ? $bookings->first() : $booking;
        @endphp

        @if($count > 1)
            <!-- Multi-Room Success Card -->
            <div class="multi-code-card">
                <div class="multi-code-top">
                    <div>
                        <span class="multi-code-label">TOTAL PENGAJUAN</span>
                        <h3 class="multi-code-count">{{ $count }} Ruangan Diajukan</h3>
                    </div>
                    <button type="button" class="btn-copy-all" onclick="copyAllCodes()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        <span id="copyAllText">Salin Semua Kode</span>
                    </button>
                </div>
                <p class="multi-code-desc">Setiap ruangan memiliki kode booking unik untuk memantau status persetujuan masing-masing:</p>

                <div class="codes-chips-grid">
                    @foreach($bookings as $b)
                        <div class="code-chip-item">
                            <div class="chip-room-name">{{ $b->room->name ?? 'Ruangan' }}</div>
                            <div class="chip-code-val">
                                <code>{{ $b->kode_booking }}</code>
                                <button type="button" class="btn-chip-copy" onclick="copyCode('{{ $b->kode_booking }}', this)" title="Salin Kode">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- List of Room Details -->
            <div class="booking-cards-list">
                <h3 class="section-title-sub">Rincian Ruangan yang Dipinjam</h3>

                @foreach($bookings as $idx => $b)
                    <div class="room-success-item">
                        <div class="item-header">
                            <div class="item-number-badge">{{ $idx + 1 }}</div>
                            <div class="item-title-box">
                                <h4 class="item-room-name">{{ $b->room->name ?? 'Ruangan' }}</h4>
                                <span class="item-code-tag">Kode: <strong>{{ $b->kode_booking }}</strong></span>
                            </div>
                            <span class="status-badge-pending">Menunggu Persetujuan</span>
                        </div>

                        <div class="item-grid-details">
                            <div class="grid-col">
                                <span class="detail-label">Tanggal Pelaksanaan:</span>
                                <span class="detail-val font-semibold">{{ $b->tanggal->translatedFormat('l, d F Y') }}</span>
                            </div>
                            <div class="grid-col">
                                <span class="detail-label">Waktu Penggunaan:</span>
                                <span class="detail-val font-semibold">{{ substr($b->jam_mulai, 0, 5) }} - {{ substr($b->jam_selesai, 0, 5) }} WIB</span>
                            </div>
                            <div class="grid-col col-full">
                                <span class="detail-label">Keperluan / Kegiatan:</span>
                                <span class="detail-val">{{ $b->nama_kegiatan }}</span>
                            </div>
                            <div class="grid-col">
                                <span class="detail-label">Jumlah Peserta:</span>
                                <span class="detail-val">{{ $b->jumlah_peserta ? $b->jumlah_peserta . ' Orang' : '-' }}</span>
                            </div>
                            <div class="grid-col">
                                <span class="detail-label">Kapasitas Ruangan:</span>
                                <span class="detail-val">{{ $b->room->capacity ?? '-' }} Kursi</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <!-- Single Booking Display -->
            <div class="single-code-card">
                <p class="code-intro">Kode Booking Anda:</p>
                <div class="code-display-row">
                    <h2 class="single-code-text">{{ $first->kode_booking }}</h2>
                    <button type="button" class="btn-copy-single" onclick="copyCode('{{ $first->kode_booking }}', this)" title="Salin Kode Booking">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        <span>Salin Kode</span>
                    </button>
                </div>
                <div class="status-pill-row">
                    Status: <strong class="status-highlight">MENUNGGU PERSETUJUAN</strong>
                </div>
            </div>

            <div class="details-card-box">
                <h3 class="details-card-title">Detail Peminjaman Ruangan</h3>
                <table class="details-table">
                    <tr>
                        <td class="col-label">Ruangan</td>
                        <td class="col-val font-semibold">{{ $first->room->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="col-label">Tanggal Acara</td>
                        <td class="col-val font-semibold">{{ $first->tanggal->translatedFormat('l, d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="col-label">Waktu Peminjaman</td>
                        <td class="col-val font-semibold">{{ substr($first->jam_mulai, 0, 5) }} - {{ substr($first->jam_selesai, 0, 5) }} WIB</td>
                    </tr>
                    <tr>
                        <td class="col-label">Nama Kegiatan</td>
                        <td class="col-val">{{ $first->nama_kegiatan }}</td>
                    </tr>
                    <tr>
                        <td class="col-label">Jumlah Peserta</td>
                        <td class="col-val">{{ $first->jumlah_peserta ? $first->jumlah_peserta . ' Orang' : '-' }}</td>
                    </tr>
                </table>
            </div>
        @endif

        <!-- Applicant Summary Card -->
        <div class="applicant-summary-card">
            <h4 class="applicant-card-title">Data Pemohon</h4>
            <div class="applicant-grid">
                <div>
                    <span class="detail-label">Nama Pemohon:</span>
                    <span class="detail-val">{{ $first->nama_pemohon }}</span>
                </div>
                <div>
                    <span class="detail-label">Instansi / Organisasi:</span>
                    <span class="detail-val">{{ $first->instansi ?: '-' }}</span>
                </div>
                <div>
                    <span class="detail-label">Nomor WhatsApp:</span>
                    <span class="detail-val">{{ $first->no_whatsapp }}</span>
                </div>
                <div>
                    <span class="detail-label">Email:</span>
                    <span class="detail-val">{{ $first->email }}</span>
                </div>
            </div>
        </div>

        <!-- Info Note Box -->
        <div class="success-note-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#08a6d9" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <div>
                <strong>Informasi Verifikasi:</strong>
                <p>Notifikasi konfirmasi permohonan telah dikirimkan ke WhatsApp & Email Anda. Petugas kami akan memverifikasi permohonan dalam waktu 1x24 jam kerja.</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="success-action-buttons">
            <a href="{{ route('home') }}" class="btn btn-outline">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Kembali ke Beranda
            </a>
            <a href="{{ route('booking.form.multi') }}" class="btn btn-outline" style="border-color: #cbd5e1;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Ajukan Peminjaman Lain
            </a>
            <a href="{{ route('cek.booking.form') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                Cek Status Booking
            </a>
        </div>

    </div>
</section>

<style>
    .booking-success-section {
        padding: 60px 0 80px;
        background: #f8fafc;
        min-height: 80vh;
    }

    .success-icon-wrapper {
        background: #d1fae5;
        width: 84px;
        height: 84px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.25);
    }

    .success-header-text {
        text-align: center;
        margin-bottom: 2.25rem;
    }

    .success-header-text h1 {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 0.5rem 0;
    }

    .success-header-text p {
        font-size: 1rem;
        color: #64748b;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Single Code Card */
    .single-code-card {
        background: #ffffff;
        border: 2px dashed #08a6d9;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .code-intro {
        font-size: 0.95rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin: 0 0 0.5rem 0;
    }

    .code-display-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 0.75rem;
    }

    .single-code-text {
        font-size: 2.25rem;
        font-weight: 800;
        color: #08a6d9;
        letter-spacing: 2px;
        margin: 0;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    }

    .btn-copy-single, .btn-copy-all {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f0fdfa;
        color: #0f766e;
        border: 1px solid #ccfbf1;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-copy-single:hover, .btn-copy-all:hover {
        background: #08a6d9;
        color: #ffffff;
        border-color: #08a6d9;
    }

    .status-pill-row {
        font-size: 0.9rem;
        color: #64748b;
    }

    .status-highlight {
        color: #d97706;
        font-weight: 700;
    }

    /* Multi Code Card */
    .multi-code-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.75rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .multi-code-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 0.5rem;
    }

    .multi-code-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.8px;
        color: var(--bakorwil-cyan);
        text-transform: uppercase;
        display: block;
    }

    .multi-code-count {
        font-size: 1.4rem;
        font-weight: 800;
        color: #0f172a;
        margin: 2px 0 0 0;
    }

    .multi-code-desc {
        color: #64748b;
        font-size: 13.5px;
        margin: 0 0 1.25rem 0;
    }

    .codes-chips-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 12px;
    }

    .code-chip-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .chip-room-name {
        font-size: 12px;
        font-weight: 600;
        color: #475569;
    }

    .chip-code-val {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chip-code-val code {
        font-size: 14px;
        font-weight: 700;
        color: #08a6d9;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    }

    .btn-chip-copy {
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: color 0.15s ease;
    }

    .btn-chip-copy:hover {
        color: #08a6d9;
        background: #e0f2fe;
    }

    /* Room Items */
    .section-title-sub {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 1rem 0;
    }

    .room-success-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .item-header {
        display: flex;
        align-items: center;
        gap: 14px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 12px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }

    .item-number-badge {
        background: #e0f2fe;
        color: #0284c7;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
        flex-shrink: 0;
    }

    .item-title-box {
        flex: 1;
    }

    .item-room-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 2px 0;
    }

    .item-code-tag {
        font-size: 12px;
        color: #64748b;
    }

    .item-code-tag strong {
        color: #08a6d9;
    }

    .status-badge-pending {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fef3c7;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        margin-left: auto;
    }

    .item-grid-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px 20px;
    }

    .grid-col.col-full {
        grid-column: span 2;
    }

    .detail-label {
        display: block;
        font-size: 11.5px;
        color: #64748b;
        margin-bottom: 2px;
    }

    .detail-val {
        font-size: 13.5px;
        color: #1e293b;
    }

    .font-semibold {
        font-weight: 600;
    }

    /* Single Details Card */
    .details-card-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }

    .details-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 1rem 0;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
    }

    .details-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .details-table td {
        padding: 10px 0;
        border-bottom: 1px solid #f8fafc;
    }

    .col-label {
        color: #64748b;
        width: 38%;
    }

    .col-val {
        color: #1e293b;
    }

    /* Applicant Summary */
    .applicant-summary-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .applicant-card-title {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin: 0 0 1rem 0;
    }

    .applicant-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px 20px;
    }

    /* Note Box */
    .success-note-box {
        background: #f0fdfa;
        border: 1px solid #ccfbf1;
        border-radius: 10px;
        padding: 1rem 1.25rem;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 2rem;
    }

    .success-note-box strong {
        color: #0f766e;
        font-size: 13.5px;
        display: block;
        margin-bottom: 2px;
    }

    .success-note-box p {
        color: #334155;
        font-size: 13px;
        margin: 0;
        line-height: 1.5;
    }

    /* Action Buttons */
    .success-action-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .success-action-buttons .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 10px;
        text-decoration: none;
    }

    @media (max-width: 640px) {
        .item-grid-details, .applicant-grid {
            grid-template-columns: 1fr;
        }
        .grid-col.col-full {
            grid-column: span 1;
        }
        .single-code-text {
            font-size: 1.75rem;
        }
    }
</style>

<script>
    function copyCode(text, btnElement) {
        navigator.clipboard.writeText(text).then(() => {
            const originalHTML = btnElement.innerHTML;
            btnElement.innerHTML = '<span>Tersalin!</span>';
            setTimeout(() => {
                btnElement.innerHTML = originalHTML;
            }, 2000);
        }).catch(err => {
            alert('Kode: ' + text);
        });
    }

    function copyAllCodes() {
        const codes = [];
        @if(isset($bookings))
            @foreach($bookings as $b)
                codes.push('{{ $b->room->name ?? "Ruangan" }}: {{ $b->kode_booking }}');
            @endforeach
        @endif
        const fullText = codes.join("\n");
        navigator.clipboard.writeText(fullText).then(() => {
            const label = document.getElementById('copyAllText');
            if (label) {
                label.textContent = 'Semua Tersalin!';
                setTimeout(() => {
                    label.textContent = 'Salin Semua Kode';
                }, 2000);
            }
        });
    }
</script>
@endsection
