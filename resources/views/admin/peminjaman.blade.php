@extends('layouts.admin')

@section('title', 'Data Peminjaman - Admin SIPERON')

@section('content')
    <div class="page-header-row">
        <div>
            <div class="page-title">Data Peminjaman</div>
            <p class="page-subtitle">Kelola semua permintaan peminjaman ruangan</p>
        </div>
        <a href="#" class="btn btn-primary" data-modal-target="modalTambahPeminjaman">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Tambah Peminjaman
        </a>
    </div>

    @if(session('success'))
        <div style="padding: 0.75rem 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="padding: 0.75rem 1rem; background: #fee2e2; color: #b91c1c; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem;">
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
            <a href="{{ route('admin.peminjaman.index', ['status' => 'ditolak']) }}" class="filter-tab {{ $status === 'ditolak' ? 'active' : '' }}">Ditolak <span class="tab-count">{{ $counts['ditolak'] }}</span></a>
            <a href="{{ route('admin.peminjaman.index', ['status' => 'selesai']) }}" class="filter-tab {{ $status === 'selesai' ? 'active' : '' }}">Selesai <span class="tab-count">{{ $counts['selesai'] }}</span></a>
        </div>
        <div class="filter-actions">
            <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="search-input">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                <input type="text" name="search" placeholder="Cari peminjam, instansi..." value="{{ request('search') }}">
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
                        <th>No</th>
                        <th>Instansi / Peminjam</th>
                        <th>Ruangan</th>
                        <th>Tanggal Acara</th>
                        <th>Waktu</th>
                        <th>Keperluan</th>
                        <th>Surat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $index => $booking)
                    <tr>
                        <td>{{ $bookings->firstItem() + $index }}</td>
                        <td>
                            <div class="cell-main">{{ $booking->instansi ?? '-' }}</div>
                            <div class="cell-sub">{{ $booking->nama_pemohon }}</div>
                        </td>
                        <td>{{ $booking->room->name ?? '-' }}</td>
                        <td>{{ $booking->tanggal->translatedFormat('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}</td>
                        <td><span class="purpose-text">{{ $booking->nama_kegiatan }}</span></td>
                        <td>
                            @if($booking->surat_pengajuan)
                                <a href="{{ asset('storage/' . $booking->surat_pengajuan) }}" target="_blank" title="Lihat PDF" style="color: #dc2626; display: inline-flex; align-items: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                                </a>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.85rem;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($booking->status === 'pending')
                                <span class="status-badge status-pending">Menunggu</span>
                            @elseif($booking->status === 'disetujui')
                                <span class="status-badge status-approved">Disetujui</span>
                            @elseif($booking->status === 'ditolak')
                                <span class="status-badge status-rejected">Ditolak</span>
                            @else
                                <span class="status-badge status-done">Selesai</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <!-- Detail Button -->
                                <button class="table-action-btn" title="Detail" data-modal-target="modalDetail{{ $booking->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                </button>
                                @if($booking->status === 'pending')
                                    <!-- Setujui Button -->
                                    <button class="table-action-btn action-approve" title="Setujui" data-modal-target="modalSetuju{{ $booking->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                    </button>
                                    <!-- Tolak Button -->
                                    <button class="table-action-btn action-reject" title="Tolak" data-modal-target="modalTolak{{ $booking->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                    </button>
                                @endif
                                <!-- Hapus Button -->
                                <form action="{{ route('admin.peminjaman.destroy', $booking) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="table-action-btn action-reject" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            Belum ada data peminjaman.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
        <div class="table-footer">
            <div class="table-info">
                Menampilkan <strong>{{ $bookings->firstItem() }} - {{ $bookings->lastItem() }}</strong> dari <strong>{{ $bookings->total() }}</strong> data
            </div>
            <div class="pagination">
                @if($bookings->onFirstPage())
                    <button class="page-btn" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                    </button>
                @else
                    <a href="{{ $bookings->previousPageUrl() }}" class="page-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                    </a>
                @endif

                @foreach($bookings->getUrlRange(1, $bookings->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="page-btn {{ $page == $bookings->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                @endforeach

                @if($bookings->hasMorePages())
                    <a href="{{ $bookings->nextPageUrl() }}" class="page-btn">
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

    <!-- ============ MODALS ============ -->

    <!-- Modal Tambah Peminjaman -->
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

                    <div class="form-group">
                        <label class="form-label">Kontak (HP/WA)</label>
                        <input type="text" name="kontak" class="form-control" placeholder="08xxxxxxxxxx">
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

                    <div class="form-group">
                        <label class="form-label">Keperluan / Nama Kegiatan</label>
                        <textarea name="nama_kegiatan" class="form-control" rows="3" placeholder="Deskripsikan keperluan acara..." required></textarea>
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

    <!-- Modals per booking: Detail, Setujui, Tolak -->
    @foreach($bookings as $booking)
        <!-- Modal Detail -->
        <div class="modal-backdrop" id="modalDetail{{ $booking->id }}">
            <div class="modal-dialog" style="max-width: 600px;">
                <div class="modal-header">
                    <h3 class="modal-title">Detail Peminjaman #PMJ-{{ str_pad($booking->id, 3, '0', STR_PAD_LEFT) }}</h3>
                    <button class="modal-close" data-modal-close>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="display: flex; flex-direction: column; gap: 1.15rem;">
                        <div>
                            <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Instansi / Peminjam</span>
                            <div style="font-weight: 600; font-size: 1rem; color: var(--text-main); margin-top: 0.25rem;">{{ $booking->instansi ?? '-' }}</div>
                            <div style="font-size: 0.85rem; color: var(--text-muted);">{{ $booking->nama_pemohon }}</div>
                        </div>
                        <div>
                            <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Kontak</span>
                            <div style="font-weight: 600; font-size: 1rem; color: var(--text-main); margin-top: 0.25rem;">{{ $booking->kontak ?? '-' }}</div>
                        </div>
                        <div>
                            <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Ruangan</span>
                            <div style="font-weight: 600; font-size: 1rem; color: var(--text-main); margin-top: 0.25rem;">{{ $booking->room->name ?? '-' }}</div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Tanggal</span>
                                <div style="font-weight: 600; font-size: 1rem; color: var(--text-main); margin-top: 0.25rem;">{{ $booking->tanggal->translatedFormat('d M Y') }}</div>
                            </div>
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Waktu</span>
                                <div style="font-weight: 600; font-size: 1rem; color: var(--text-main); margin-top: 0.25rem;">{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}</div>
                            </div>
                        </div>
                        <div>
                            <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Keperluan Acara</span>
                            <div style="font-size: 0.9rem; color: var(--text-main); margin-top: 0.25rem; line-height: 1.6;">{{ $booking->nama_kegiatan }}</div>
                        </div>
                        @if($booking->catatan)
                        <div>
                            <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Catatan</span>
                            <div style="font-size: 0.9rem; color: var(--text-main); margin-top: 0.25rem; line-height: 1.6;">{{ $booking->catatan }}</div>
                        </div>
                        @endif
                        @if($booking->surat_pengajuan)
                        <div>
                            <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Surat Pengajuan</span>
                            <div style="margin-top: 0.35rem;">
                                <a href="{{ asset('storage/' . $booking->surat_pengajuan) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: #fef2f2; color: #dc2626; border-radius: 8px; font-weight: 600; font-size: 0.85rem; text-decoration: none; transition: 0.2s;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                                    Lihat / Download PDF
                                </a>
                            </div>
                        </div>
                        @endif
                        <div>
                            <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Status</span>
                            <div style="margin-top: 0.35rem;">
                                @if($booking->status === 'pending')
                                    <span class="status-badge status-pending">Menunggu</span>
                                @elseif($booking->status === 'disetujui')
                                    <span class="status-badge status-approved">Disetujui</span>
                                @elseif($booking->status === 'ditolak')
                                    <span class="status-badge status-rejected">Ditolak</span>
                                @else
                                    <span class="status-badge status-done">Selesai</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline" data-modal-close>Tutup</button>
                </div>
            </div>
        </div>

        @if($booking->status === 'pending')
            <!-- Modal Setujui -->
            <div class="modal-backdrop" id="modalSetuju{{ $booking->id }}">
                <div class="modal-dialog" style="max-width: 400px; text-align: center; padding: 0;">
                    <form action="{{ route('admin.peminjaman.status', $booking) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="disetujui">
                        <div style="padding: 2rem 1.5rem 1.5rem;">
                            <div style="width: 60px; height: 60px; border-radius: 50%; background-color: #d1fae5; color: #059669; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 30px; height: 30px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            </div>
                            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.5rem;">Setujui Peminjaman?</h3>
                            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.5;">Setujui permohonan <strong>{{ $booking->nama_pemohon }}</strong> untuk ruangan <strong>{{ $booking->room->name ?? '' }}</strong> pada <strong>{{ $booking->tanggal->translatedFormat('d M Y') }}</strong>?</p>
                        </div>
                        <div style="display: flex; gap: 0.75rem; padding: 1rem 1.5rem; background-color: var(--surface-hover); border-top: 1px solid var(--border-color); border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                            <button type="button" class="btn btn-outline" style="flex: 1; justify-content: center;" data-modal-close>Batal</button>
                            <button type="submit" class="btn" style="flex: 1; justify-content: center; background-color: #059669; color: white;">Ya, Setujui</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Tolak -->
            <div class="modal-backdrop" id="modalTolak{{ $booking->id }}">
                <div class="modal-dialog" style="max-width: 400px;">
                    <div class="modal-header">
                        <h3 class="modal-title">Tolak Peminjaman</h3>
                        <button class="modal-close" data-modal-close>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.peminjaman.status', $booking) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="ditolak">
                        <div class="modal-body">
                            <div style="margin-bottom: 1.25rem; padding: 1rem; background-color: #fee2e2; color: #b91c1c; border-radius: 8px; font-size: 0.9rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" /></svg>
                                <span>Anda akan menolak permohonan dari <strong>{{ $booking->nama_pemohon }}</strong>. Silakan berikan alasan penolakan.</span>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alasan Penolakan</label>
                                <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Jadwal bentrok dengan acara dinas internal..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-modal-close>Batal</button>
                            <button type="submit" class="btn" style="background-color: #dc2626; color: white;">Tolak Peminjaman</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endforeach
@endsection
