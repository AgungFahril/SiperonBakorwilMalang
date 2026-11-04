@extends('layouts.admin')

@section('title', 'Data Peminjaman - Admin SIPERON')

@section('content')
    <div class="page-header-row">
        <div>
            <div class="page-title">Data Peminjaman Ruangan</div>
            <p class="page-subtitle">Kelola dan verifikasi seluruh pengajuan peminjaman ruangan</p>
        </div>
        <a href="#" class="btn btn-primary" data-modal-target="modalTambahPeminjaman">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Tambah Peminjaman
        </a>
    </div>

    {{-- Banner Notifikasi Berhasil --}}
    @if(session('success'))
        <div style="padding: 0.85rem 1.25rem; background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Banner Pop-up WhatsApp Siap Kirim (Template Otomatis Terisi) --}}
    @if(session('wa_confirm'))
        <div style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 2px solid #10b981; border-radius: 14px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 8px 24px rgba(16, 185, 129, 0.18); animation: slideDown 0.3s ease-out;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div style="display: flex; gap: 16px; align-items: center;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #25d366; color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.35);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    </div>
                    <div>
                        <span style="font-size: 11px; font-weight: 800; color: #047857; text-transform: uppercase; letter-spacing: 0.8px;">STATUS BERHASIL DIPERBARUI & WHATSAPP DIBUKA</span>
                        <h4 style="margin: 2px 0 4px 0; font-size: 1.15rem; font-weight: 800; color: #065f46;">
                            Konfirmasi untuk: {{ session('wa_confirm.nama') }}
                        </h4>
                        <p style="margin: 0; font-size: 0.88rem; color: #047857;">
                            Nomor: <strong>{{ session('wa_confirm.phone') }}</strong> &bull; Pesan resmi telah disiapkan di WhatsApp. Jika tab WhatsApp belum terbuka, silakan klik tombol di samping.
                        </p>
                    </div>
                </div>
                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <a href="{{ session('wa_confirm.url') }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; padding: 11px 22px; background: #25d366; color: white; border-radius: 9px; font-weight: 800; font-size: 0.95rem; text-decoration: none; box-shadow: 0 4px 14px rgba(37, 211, 102, 0.4); transition: transform 0.15s ease;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span>Buka Ulang WhatsApp &rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div style="padding: 0.85rem 1.25rem; background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.9rem;">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filter & Search Bar -->
    <div class="filter-bar">
        <div class="filter-tabs">
            <a href="{{ route('admin.peminjaman.index') }}" class="filter-tab {{ !$status ? 'active' : '' }}">Semua <span class="tab-count">{{ $counts['all'] }}</span></a>
            <a href="{{ route('admin.peminjaman.index', ['status' => 'pending']) }}" class="filter-tab {{ $status === 'pending' ? 'active' : '' }}">Menunggu <span class="tab-count">{{ $counts['pending'] }}</span></a>
            <a href="{{ route('admin.peminjaman.index', ['status' => 'disetujui']) }}" class="filter-tab {{ $status === 'disetujui' ? 'active' : '' }}">Disetujui <span class="tab-count">{{ $counts['disetujui'] }}</span></a>
            <a href="{{ route('admin.peminjaman.index', ['status' => 'dijadwalkan_ulang']) }}" class="filter-tab {{ $status === 'dijadwalkan_ulang' ? 'active' : '' }}">Jadwal Ulang <span class="tab-count">{{ $counts['dijadwalkan_ulang'] }}</span></a>
            <a href="{{ route('admin.peminjaman.index', ['status' => 'ditolak']) }}" class="filter-tab {{ $status === 'ditolak' ? 'active' : '' }}">Ditolak <span class="tab-count">{{ $counts['ditolak'] }}</span></a>
            <a href="{{ route('admin.peminjaman.index', ['status' => 'selesai']) }}" class="filter-tab {{ $status === 'selesai' ? 'active' : '' }}">Selesai <span class="tab-count">{{ $counts['selesai'] }}</span></a>
        </div>
        <div class="filter-actions">
            <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="search-input">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                <input type="text" name="search" placeholder="Cari peminjam, instansi, kode..." value="{{ request('search') }}">
                @if($status)
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th style="width: 220px;">Pengajuan / Pemohon</th>
                        <th>Ruangan & Jadwal Peminjaman</th>
                        <th style="width: 70px; text-align: center;">Surat</th>
                        <th style="width: 130px; text-align: center;">Status</th>
                        <th style="width: 170px; text-align: center;">Aksi & WhatsApp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paginatedGroups as $index => $groupItem)
                    @php
                        $groupCode = $groupItem->group_code;
                        $items = $groupedBookings[$groupCode] ?? collect();
                        $first = $items->first();
                        $roomCount = $items->count();
                        $pendingCount = $items->where('status', 'pending')->count();
                        $approvedCount = $items->where('status', 'disetujui')->count();
                        $rejectedCount = $items->where('status', 'ditolak')->count();
                        $rescheduleCount = $items->where('status', 'dijadwalkan_ulang')->count();
                        $doneCount = $items->where('status', 'selesai')->count();

                        // Tentukan status tampilan keseluruhan paket
                        if ($pendingCount > 0 && $pendingCount === $roomCount) {
                            $groupStatus = 'pending';
                        } elseif ($approvedCount === $roomCount) {
                            $groupStatus = 'disetujui';
                        } elseif ($rejectedCount === $roomCount) {
                            $groupStatus = 'ditolak';
                        } elseif ($rescheduleCount === $roomCount) {
                            $groupStatus = 'dijadwalkan_ulang';
                        } elseif ($doneCount === $roomCount) {
                            $groupStatus = 'selesai';
                        } else {
                            $groupStatus = 'sebagian';
                        }

                        // Buat link WhatsApp manual dengan template resmi terisi otomatis
                        $rowWaStatus = $pendingCount > 0 ? 'pending' : $first->status;
                        $rowWaMsg = \App\Services\WhatsAppService::buildConfirmationMessage($items, $rowWaStatus, $first->catatan);
                        $rowWaUrl = \App\Services\WhatsAppService::generateWaLink($first->no_whatsapp, $rowWaMsg);
                    @endphp
                    <tr>
                        <td>{{ $paginatedGroups->firstItem() + $index }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-bottom: 4px;">
                                <a href="{{ route('admin.peminjaman.show', $first) }}" style="font-weight: 700; color: #08a6d9; text-decoration: none; font-size: 0.95rem;">
                                    {{ $first->group_code ?: $first->kode_booking }}
                                </a>
                                @if($roomCount > 1)
                                    <span style="background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 12px; display: inline-flex; align-items: center; gap: 3px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                        {{ $roomCount }} Ruangan
                                    </span>
                                @endif
                            </div>
                            <div class="cell-main" style="font-weight: 600; font-size: 0.95rem; color: #1e293b;">
                                {{ $first->nama_pemohon }}
                            </div>
                            <div class="cell-sub" style="color: #64748b; font-size: 0.85rem; margin-top: 1px;">
                                {{ $first->instansi ?: 'Perorangan' }}
                            </div>
                            <div style="font-size: 0.8rem; color: #059669; margin-top: 3px; font-weight: 500;">
                                WA: {{ $first->no_whatsapp }}
                            </div>
                        </td>

                        <!-- DAFTAR RUANGAN & JADWAL (TERGABUNG JADI SATU) -->
                        <td>
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                @foreach($items as $subIdx => $item)
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; position: relative; border-left: 3px solid {{ $item->status === 'disetujui' ? '#10b981' : ($item->status === 'ditolak' ? '#ef4444' : ($item->status === 'dijadwalkan_ulang' ? '#6366f1' : '#08a6d9')) }};">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; flex-wrap: wrap; gap: 6px;">
                                            <div style="font-weight: 700; color: #0f172a; font-size: 0.92rem;">
                                                @if($roomCount > 1)
                                                    <span style="color: #94a3b8; font-size: 11px; margin-right: 2px;">#{{ $subIdx + 1 }}</span>
                                                @endif
                                                {{ $item->room->name ?? 'Ruangan' }}
                                                <span style="font-weight: 500; font-size: 11.5px; color: #64748b; margin-left: 4px;">({{ $item->kode_booking }})</span>
                                            </div>
                                            <!-- Mini Status Badge per Ruangan jika multi -->
                                            @if($roomCount > 1)
                                                <div>
                                                    @if($item->status === 'pending')
                                                        <span style="background: #fef3c7; color: #92400e; font-size: 10.5px; font-weight: 700; padding: 2px 7px; border-radius: 4px;">Menunggu</span>
                                                    @elseif($item->status === 'disetujui')
                                                        <span style="background: #d1fae5; color: #065f46; font-size: 10.5px; font-weight: 700; padding: 2px 7px; border-radius: 4px;">Disetujui</span>
                                                    @elseif($item->status === 'ditolak')
                                                        <span style="background: #fee2e2; color: #991b1b; font-size: 10.5px; font-weight: 700; padding: 2px 7px; border-radius: 4px;">Ditolak</span>
                                                    @elseif($item->status === 'dijadwalkan_ulang')
                                                        <span style="background: #e0e7ff; color: #3730a3; font-size: 10.5px; font-weight: 700; padding: 2px 7px; border-radius: 4px;">Jadwal Ulang</span>
                                                    @else
                                                        <span style="background: #f1f5f9; color: #475569; font-size: 10.5px; font-weight: 700; padding: 2px 7px; border-radius: 4px;">Selesai</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        <div style="font-size: 0.85rem; color: #334155; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: -1px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                <strong>{{ $item->tanggal->translatedFormat('d M Y') }}</strong>
                                            </span>
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: -1px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                {{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }} WIB
                                            </span>
                                            <span style="color: #64748b;">
                                                &bull; {{ $item->nama_kegiatan }}
                                                @if($item->jumlah_peserta)
                                                    ({{ $item->jumlah_peserta }} Peserta)
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </td>

                        <!-- SURAT PENGAJUAN (1 PDF UNTUK SELURUH RUANGAN) -->
                        <td style="text-align: center;">
                            @if($first->surat_pengajuan)
                                <a href="{{ asset('storage/' . $first->surat_pengajuan) }}" target="_blank" title="Lihat Surat Pengajuan (PDF)" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; border-radius: 8px; transition: transform 0.15s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                                </a>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.85rem;">-</span>
                            @endif
                        </td>

                        <!-- STATUS KESELURUHAN -->
                        <td style="text-align: center;">
                            @if($groupStatus === 'pending')
                                <span class="status-badge status-pending">Menunggu</span>
                            @elseif($groupStatus === 'disetujui')
                                <span class="status-badge status-approved">Disetujui</span>
                            @elseif($groupStatus === 'ditolak')
                                <span class="status-badge status-rejected">Ditolak</span>
                            @elseif($groupStatus === 'dijadwalkan_ulang')
                                <span class="status-badge" style="background: #e0e7ff; color: #3730a3; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 0.75rem;">Jadwal Ulang</span>
                            @elseif($groupStatus === 'sebagian')
                                <span class="status-badge" style="background: #fef3c7; color: #b45309; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.75rem;">Sebagian Disetujui</span>
                            @else
                                <span class="status-badge status-done">Selesai</span>
                            @endif
                        </td>

                        <!-- AKSI KONFIRMASI TERPADU + TOMBOL WHATSAPP MANUAL TEMPLATE -->
                        <td style="text-align: center;">
                            <div class="action-group" style="justify-content: center; gap: 6px;">
                                <!-- Tombol Setujui Semua (Muncul jika ada yang pending) -->
                                @if($pendingCount > 0)
                                    <button class="table-action-btn action-approve" title="Setujui {{ $roomCount > 1 ? 'Semua (' . $roomCount . ' Ruang)' : 'Peminjaman' }}" data-modal-target="modalSetujuGroup{{ preg_replace('/[^a-zA-Z0-9]/', '_', $groupCode) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                    </button>
                                    <button class="table-action-btn action-reject" title="Tolak {{ $roomCount > 1 ? 'Semua (' . $roomCount . ' Ruang)' : 'Peminjaman' }}" data-modal-target="modalTolakGroup{{ preg_replace('/[^a-zA-Z0-9]/', '_', $groupCode) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                    </button>
                                @endif

                                <!-- Tombol WhatsApp Manual: Pesan sudah terisi otomatis sesuai status -->
                                <a href="{{ $rowWaUrl }}" target="_blank" class="table-action-btn" title="Kirim Chat WhatsApp Manual (Template Pesan Otomatis Terisi)" style="color: #166534; background: #dcfce7; border: 1px solid #86efac;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                </a>

                                <!-- Tombol Detail Lengkap -->
                                <a href="{{ route('admin.peminjaman.show', $first) }}" class="table-action-btn" title="Detail & Riwayat Lengkap">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                </a>

                                <!-- Tombol Hapus Seluruh Pengajuan -->
                                <form action="{{ route('admin.peminjaman.destroyGroup', $groupCode) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus seluruh data pengajuan ini (termasuk {{ $roomCount }} ruangan terkait)?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="table-action-btn action-reject" title="Hapus Pengajuan">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                            <div style="font-size: 1rem; font-weight: 600; color: #475569;">Belum ada data peminjaman ruangan.</div>
                            <p style="font-size: 0.85rem; margin: 4px 0 0;">Pengajuan peminjaman dari publik atau penambahan admin akan tampil di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($paginatedGroups->hasPages())
        <div class="table-footer">
            <div class="table-info">
                Menampilkan <strong>{{ $paginatedGroups->firstItem() }} - {{ $paginatedGroups->lastItem() }}</strong> dari <strong>{{ $paginatedGroups->total() }}</strong> paket pengajuan
            </div>
            <div class="pagination">
                @if($paginatedGroups->onFirstPage())
                    <button class="page-btn" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                    </button>
                @else
                    <a href="{{ $paginatedGroups->previousPageUrl() }}" class="page-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                    </a>
                @endif

                @foreach($paginatedGroups->getUrlRange(1, $paginatedGroups->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="page-btn {{ $page == $paginatedGroups->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                @endforeach

                @if($paginatedGroups->hasMorePages())
                    <a href="{{ $paginatedGroups->nextPageUrl() }}" class="page-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                    </a>
                @else
                    <button class="page-btn" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                    </button>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- ============ MODALS KONFIRMASI TERPADU ============ -->

    <!-- Modal Tambah Peminjaman Manual oleh Admin -->
    <div class="modal-backdrop" id="modalTambahPeminjaman">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Form Tambah Peminjaman</h3>
                <button class="modal-close" data-modal-close>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Nama Peminjam</label>
                            <input type="text" name="nama_pemohon" class="form-control" placeholder="Contoh: Budi Santoso" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Instansi</label>
                            <input type="text" name="instansi" class="form-control" placeholder="Contoh: Dinas Kesehatan Jatim">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">No WhatsApp</label>
                            <input type="text" name="no_whatsapp" class="form-control" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status Awal</label>
                        <select name="status" class="form-control">
                            <option value="pending">Menunggu Persetujuan</option>
                            <option value="disetujui" selected>Langsung Disetujui</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Ruangan</label>
                        <select name="room_id" class="form-control" required>
                            <option value="">Pilih Ruangan...</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }} (Kapasitas: {{ $room->capacity }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Waktu Mulai - Selesai</label>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <input type="time" name="jam_mulai" class="form-control" style="flex: 1;" required>
                                <span style="color: var(--text-muted);">-</span>
                                <input type="time" name="jam_selesai" class="form-control" style="flex: 1;" required>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem;">
                        <div class="form-group" style="flex: 2;">
                            <label class="form-label">Keperluan / Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" class="form-control" placeholder="Deskripsikan keperluan acara..." required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Jumlah Peserta</label>
                            <input type="number" name="jumlah_peserta" class="form-control" min="1" placeholder="Cth: 50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Catatan (opsional)</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modals Konfirmasi Massal per Kelompok Pengajuan -->
    @foreach($paginatedGroups as $groupItem)
        @php
            $groupCode = $groupItem->group_code;
            $items = $groupedBookings[$groupCode] ?? collect();
            $first = $items->first();
            $roomCount = $items->count();
            $pendingItems = $items->where('status', 'pending');
            $safeModalId = preg_replace('/[^a-zA-Z0-9]/', '_', $groupCode);
            $cleanPhone = \App\Services\WhatsAppService::formatPhoneNumber($first->no_whatsapp);
            $waMsgSetuju = \App\Services\WhatsAppService::buildConfirmationMessage($items, 'disetujui');
            $waUrlSetuju = \App\Services\WhatsAppService::generateWaLink($first->no_whatsapp, $waMsgSetuju);
            $waMsgTolakBase = \App\Services\WhatsAppService::buildConfirmationMessage($items, 'ditolak', '___ALASAN___');
        @endphp

        @if($pendingItems->isNotEmpty())
            <!-- Modal Setujui Sekaligus & Kirim WA -->
            <div class="modal-backdrop" id="modalSetujuGroup{{ $safeModalId }}">
                <div class="modal-dialog" style="max-width: 550px; padding: 0; border-radius: 16px; overflow: hidden;">
                    <form action="{{ route('admin.peminjaman.groupStatus', $groupCode) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="disetujui">
                        <div style="padding: 1.75rem 2rem 1.25rem;">
                            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 1.25rem;">
                                <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #d1fae5; color: #059669; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 26px; height: 26px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                </div>
                                <div>
                                    <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 2px 0;">
                                        Setujui & Kirim WhatsApp {{ $roomCount > 1 ? '(' . $roomCount . ' Ruang)' : '' }}
                                    </h3>
                                    <p style="color: #64748b; font-size: 0.88rem; margin: 0;">
                                        Pemohon: <strong>{{ $first->nama_pemohon }}</strong> ({{ $first->instansi ?: 'Perorangan' }}) &bull; WA: <strong>{{ $first->no_whatsapp }}</strong>
                                    </p>
                                </div>
                            </div>

                            <!-- Daftar Ruangan yang Akan Disetujui -->
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; margin-bottom: 1rem; max-height: 130px; overflow-y: auto;">
                                <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px;">Daftar ruangan yang disetujui:</div>
                                @foreach($pendingItems as $pi)
                                    <div style="padding: 4px 0; border-bottom: 1px solid #edf2f7; font-size: 12.5px; display: flex; justify-content: space-between; gap: 8px;">
                                        <span style="font-weight: 700; color: #1e293b;">• {{ $pi->room->name ?? 'Ruangan' }}</span>
                                        <span style="color: #64748b; font-size: 12px;">{{ $pi->tanggal->translatedFormat('d M Y') }} ({{ substr($pi->jam_mulai, 0, 5) }}-{{ substr($pi->jam_selesai, 0, 5) }})</span>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Preview Pesan WhatsApp Resmi -->
                            <div style="text-align: left; background: #ecfdf5; border: 1.5px solid #a7f3d0; border-radius: 10px; padding: 10px 14px; margin-bottom: 0.85rem;">
                                <span style="font-size: 11px; font-weight: 800; color: #047857; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 5px; margin-bottom: 5px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    Template Pesan WhatsApp Otomatis:
                                </span>
                                <div style="font-size: 11.5px; color: #065f46; background: #ffffff; padding: 10px; border-radius: 6px; border: 1px solid #d1fae5; white-space: pre-wrap; max-height: 120px; overflow-y: auto; font-family: monospace; line-height: 1.45;">{{ $waMsgSetuju }}</div>
                            </div>

                            <p style="font-size: 11.5px; color: #047857; margin: 0; line-height: 1.4;">
                                💡 Mengklik tombol hijau di bawah akan <strong>langsung membuka WhatsApp</strong> ke nomor pemohon dengan pesan di atas, sekaligus <strong>menyetujui status permohonan</strong> di sistem.
                            </p>
                        </div>
                        <div style="display: flex; gap: 0.75rem; padding: 1rem 2rem; background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
                            <button type="button" class="btn btn-outline" style="flex: 1; justify-content: center;" data-modal-close>Batal</button>
                            <button type="submit" onclick="return kirimWaDanSetuju(this.form, '{{ $waUrlSetuju }}')" class="btn" style="flex: 2; justify-content: center; background-color: #25d366; color: white; font-weight: 800; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37,211,102,0.35);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                <span>Kirim WhatsApp & Setujui</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Tolak Sekaligus & Kirim WA -->
            <div class="modal-backdrop" id="modalTolakGroup{{ $safeModalId }}">
                <div class="modal-dialog" style="max-width: 530px;">
                    <div class="modal-header">
                        <h3 class="modal-title">Tolak & Kirim WhatsApp {{ $roomCount > 1 ? '(' . $roomCount . ' Ruangan)' : '' }}</h3>
                        <button class="modal-close" data-modal-close>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.peminjaman.groupStatus', $groupCode) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="ditolak">
                        <div class="modal-body">
                            <div style="margin-bottom: 1rem; padding: 0.85rem 1rem; background-color: #fee2e2; color: #991b1b; border-radius: 8px; font-size: 0.85rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" /></svg>
                                <span>Menolak permohonan dari <strong>{{ $first->nama_pemohon }}</strong> ({{ $roomCount }} ruangan). Nomor WA: <strong>{{ $first->no_whatsapp }}</strong></span>
                            </div>
                            <div class="form-group" style="margin-bottom: 1rem;">
                                <label class="form-label">Alasan Penolakan (Wajib diisi - Masuk ke Pesan WhatsApp): <span style="color: red;">*</span></label>
                                <textarea name="catatan" id="alasanTolak{{ $safeModalId }}" class="form-control" rows="2" placeholder="Contoh: Seluruh ruangan pada tanggal tersebut akan digunakan untuk agenda kedinasan prioritas..." required oninput="updateTolakPreview('{{ $safeModalId }}')"></textarea>
                            </div>

                            <!-- Live Preview WhatsApp Rejection -->
                            <div style="text-align: left; background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 10px; padding: 10px 12px; margin-bottom: 0.5rem;">
                                <span style="font-size: 11px; font-weight: 800; color: #991b1b; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    Live Preview Pesan WhatsApp Penolakan:
                                </span>
                                <div id="previewTolak{{ $safeModalId }}" style="font-size: 11.5px; color: #7f1d1d; background: #ffffff; padding: 8px 10px; border-radius: 6px; border: 1px solid #fee2e2; white-space: pre-wrap; max-height: 120px; overflow-y: auto; font-family: monospace; line-height: 1.45;">{{ str_replace('___ALASAN___', '(Ketik alasan di atas...)', $waMsgTolakBase) }}</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-modal-close>Batal</button>
                            <button type="submit" onclick="return kirimWaDanTolak(this.form, '{{ $safeModalId }}', '{{ $cleanPhone }}')" class="btn" style="background-color: #dc2626; color: white; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                <span>Kirim WhatsApp & Tolak</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                window.tolakBaseTemplates = window.tolakBaseTemplates || {};
                window.tolakBaseTemplates['{{ $safeModalId }}'] = @json($waMsgTolakBase);
            </script>
        @endif
    @endforeach

    <script>
        window.updateTolakPreview = function(id) {
            const input = document.getElementById('alasanTolak' + id);
            const preview = document.getElementById('previewTolak' + id);
            if (!input || !preview || !window.tolakBaseTemplates || !window.tolakBaseTemplates[id]) return;
            const val = input.value.trim() || '(Ketik alasan di atas...)';
            preview.textContent = window.tolakBaseTemplates[id].replace('___ALASAN___', val);
        };

        window.kirimWaDanSetuju = function(form, waUrl) {
            if (!form.checkValidity()) {
                form.reportValidity();
                return false;
            }
            if (waUrl && waUrl !== '#') {
                window.open(waUrl, '_blank');
            }
            return true;
        };

        window.kirimWaDanTolak = function(form, id, phone) {
            if (!form.checkValidity()) {
                form.reportValidity();
                return false;
            }
            const input = document.getElementById('alasanTolak' + id);
            const val = input ? input.value.trim() : '';
            const base = (window.tolakBaseTemplates && window.tolakBaseTemplates[id]) ? window.tolakBaseTemplates[id] : '';
            const msg = base.replace('___ALASAN___', val);
            const waUrl = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(msg);
            window.open(waUrl, '_blank');
            return true;
        };
    </script>
@endsection
