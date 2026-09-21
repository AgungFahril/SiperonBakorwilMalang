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

    <!-- Filter & Search Bar -->
    <div class="filter-bar">
        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">Semua <span class="tab-count">24</span></button>
            <button class="filter-tab" data-filter="pending">Menunggu <span class="tab-count">5</span></button>
            <button class="filter-tab" data-filter="approved">Disetujui <span class="tab-count">14</span></button>
            <button class="filter-tab" data-filter="rejected">Ditolak <span class="tab-count">3</span></button>
            <button class="filter-tab" data-filter="done">Selesai <span class="tab-count">2</span></button>
        </div>
        <div class="filter-actions">
            <div class="search-input">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                <input type="text" placeholder="Cari peminjam, instansi...">
            </div>
            <button class="btn btn-outline">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" /></svg>
                Filter
            </button>
            <button class="btn btn-outline">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                Export
            </button>
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
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <div class="cell-main">Dinas Pendidikan Prov Jatim</div>
                            <div class="cell-sub">Bpk. Budi Santoso</div>
                        </td>
                        <td>Ruang Rapat Utama (Bhirawa)</td>
                        <td>24 Sep 2026</td>
                        <td>09:00 - 15:00</td>
                        <td><span class="purpose-text">Rapat Koordinasi</span></td>
                        <td><span class="status-badge status-pending">Menunggu</span></td>
                        <td>
                            <div class="action-group">
                                <button class="table-action-btn" title="Detail" data-modal-target="modalDetailPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                </button>
                                <button class="table-action-btn action-approve" title="Setujui" data-modal-target="modalSetujuPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                </button>
                                <button class="table-action-btn action-reject" title="Tolak" data-modal-target="modalTolakPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>
                            <div class="cell-main">Dinas Kominfo Malang</div>
                            <div class="cell-sub">Ibu Rina Susanti</div>
                        </td>
                        <td>Aula Pertemuan Bakorwil</td>
                        <td>25 Sep 2026</td>
                        <td>08:00 - 12:00</td>
                        <td><span class="purpose-text">Sosialisasi Program</span></td>
                        <td><span class="status-badge status-approved">Disetujui</span></td>
                        <td>
                            <div class="action-group">
                                <button class="table-action-btn" title="Detail" data-modal-target="modalDetailPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                </button>
                                <button class="table-action-btn" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>
                            <div class="cell-main">Universitas Brawijaya</div>
                            <div class="cell-sub">Panitia Seminar Nasional</div>
                        </td>
                        <td>Ruang Sidang</td>
                        <td>21 Sep 2026</td>
                        <td>13:00 - 16:00</td>
                        <td><span class="purpose-text">Seminar Nasional</span></td>
                        <td><span class="status-badge status-rejected">Ditolak</span></td>
                        <td>
                            <div class="action-group">
                                <button class="table-action-btn" title="Detail" data-modal-target="modalDetailPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>
                            <div class="cell-main">Dinas Pariwisata Jatim</div>
                            <div class="cell-sub">Bpk. Agus Widodo</div>
                        </td>
                        <td>Ruang Rapat Utama (Bhirawa)</td>
                        <td>28 Sep 2026</td>
                        <td>09:00 - 12:00</td>
                        <td><span class="purpose-text">FGD Pariwisata</span></td>
                        <td><span class="status-badge status-approved">Disetujui</span></td>
                        <td>
                            <div class="action-group">
                                <button class="table-action-btn" title="Detail" data-modal-target="modalDetailPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                </button>
                                <button class="table-action-btn" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>
                            <div class="cell-main">BPBD Kota Malang</div>
                            <div class="cell-sub">Ibu Dewi Anggraini</div>
                        </td>
                        <td>Ruang Rapat Utama (Bhirawa)</td>
                        <td>30 Sep 2026</td>
                        <td>10:00 - 14:00</td>
                        <td><span class="purpose-text">Rapat Mitigasi Bencana</span></td>
                        <td><span class="status-badge status-pending">Menunggu</span></td>
                        <td>
                            <div class="action-group">
                                <button class="table-action-btn" title="Detail" data-modal-target="modalDetailPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                </button>
                                <button class="table-action-btn action-approve" title="Setujui" data-modal-target="modalSetujuPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                </button>
                                <button class="table-action-btn action-reject" title="Tolak" data-modal-target="modalTolakPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>6</td>
                        <td>
                            <div class="cell-main">Politeknik Negeri Malang</div>
                            <div class="cell-sub">Dr. Hendra Pratama</div>
                        </td>
                        <td>Aula Pertemuan Bakorwil</td>
                        <td>02 Okt 2026</td>
                        <td>08:00 - 16:00</td>
                        <td><span class="purpose-text">Workshop Teknologi</span></td>
                        <td><span class="status-badge status-pending">Menunggu</span></td>
                        <td>
                            <div class="action-group">
                                <button class="table-action-btn" title="Detail" data-modal-target="modalDetailPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                </button>
                                <button class="table-action-btn action-approve" title="Setujui" data-modal-target="modalSetujuPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                </button>
                                <button class="table-action-btn action-reject" title="Tolak" data-modal-target="modalTolakPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>7</td>
                        <td>
                            <div class="cell-main">Kejaksaan Negeri Malang</div>
                            <div class="cell-sub">Bpk. Eko Prasetyo</div>
                        </td>
                        <td>Ruang Sidang</td>
                        <td>18 Sep 2026</td>
                        <td>09:00 - 11:00</td>
                        <td><span class="purpose-text">Pertemuan Internal</span></td>
                        <td><span class="status-badge status-done">Selesai</span></td>
                        <td>
                            <div class="action-group">
                                <button class="table-action-btn" title="Detail" data-modal-target="modalDetailPeminjaman">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="table-footer">
            <div class="table-info">
                Menampilkan <strong>1 - 7</strong> dari <strong>24</strong> data
            </div>
            <div class="pagination">
                <button class="page-btn" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">4</button>
                <button class="page-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Peminjaman -->
    <div class="modal-backdrop" id="modalTambahPeminjaman">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Form Tambah Peminjaman</h3>
                <button class="modal-close" data-modal-close>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Peminjam / Instansi</label>
                    <input type="text" class="form-control" placeholder="Contoh: Dinas Kesehatan Jatim / Budi Santoso">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Ruangan</label>
                    <select class="form-control">
                        <option value="">Pilih Ruangan...</option>
                        <option value="1">Ruang Rapat Utama (Bhirawa)</option>
                        <option value="2">Aula Pertemuan Bakorwil</option>
                        <option value="3">Ruang Sidang</option>
                        <option value="4">Ruang Kerja Bersama</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Tanggal Pelaksanaan</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Waktu Mulai - Selesai</label>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <input type="time" class="form-control" style="flex: 1;">
                            <span style="color: var(--text-muted);">-</span>
                            <input type="time" class="form-control" style="flex: 1;">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Keperluan / Acara</label>
                    <textarea class="form-control" rows="3" placeholder="Deskripsikan keperluan acara..."></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Lampiran Surat Permohonan (PDF)</label>
                    <input type="file" class="form-control" accept=".pdf">
                    <p class="form-help">Maksimal ukuran file: 2MB.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" data-modal-close>Batal</button>
                <button class="btn btn-primary">Simpan Peminjaman</button>
            </div>
        </div>
    </div>

    <div class="modal-backdrop" id="modalDetailPeminjaman">
        <div class="modal-dialog" style="max-width: 900px;">
            <div class="modal-header">
                <h3 class="modal-title">Detail Peminjaman</h3>
                <button class="modal-close" data-modal-close>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; min-height: 420px;">
                    <!-- Left: Detail Info -->
                    <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.15rem; border-right: 1px solid var(--border-color);">
                        <div>
                            <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Instansi / Peminjam</span>
                            <div style="font-weight: 600; font-size: 1rem; color: var(--text-main); margin-top: 0.25rem;">Dinas Pendidikan Prov Jatim</div>
                            <div style="font-size: 0.85rem; color: var(--text-muted);">Bpk. Budi Santoso</div>
                        </div>
                        <div>
                            <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Ruangan</span>
                            <div style="font-weight: 600; font-size: 1rem; color: var(--text-main); margin-top: 0.25rem;">Ruang Rapat Utama (Bhirawa)</div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Tanggal</span>
                                <div style="font-weight: 600; font-size: 1rem; color: var(--text-main); margin-top: 0.25rem;">24 Sep 2026</div>
                            </div>
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Waktu</span>
                                <div style="font-weight: 600; font-size: 1rem; color: var(--text-main); margin-top: 0.25rem;">09:00 - 15:00</div>
                            </div>
                        </div>
                        <div>
                            <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Keperluan Acara</span>
                            <div style="font-size: 0.9rem; color: var(--text-main); margin-top: 0.25rem; line-height: 1.6;">Rapat Koordinasi Evaluasi Pendidikan Tingkat Provinsi Jawa Timur Tahun 2026. Dihadiri oleh seluruh kepala dinas pendidikan kota/kabupaten.</div>
                        </div>
                        <div>
                            <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Status</span>
                            <div style="margin-top: 0.35rem;"><span class="status-badge status-pending">Menunggu</span></div>
                        </div>
                    </div>

                    <!-- Right: Document Preview -->
                    <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Preview Dokumen</span>
                            <a href="#" style="font-size: 0.8rem; color: var(--bakorwil-cyan); text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem; font-weight: 500;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                Unduh
                            </a>
                        </div>
                        <div style="flex: 1; border-radius: 8px; border: 1px solid var(--border-color); overflow: hidden; background-color: #f1f5f9; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; min-height: 350px;">
                            <!-- Simulated PDF preview -->
                            <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.5rem; text-align: center;">
                                <div style="width: 80px; height: 100px; background: white; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; position: relative;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="#dc2626" style="width: 36px; height: 36px;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                                    <span style="position: absolute; bottom: 6px; left: 50%; transform: translateX(-50%); font-size: 0.55rem; font-weight: 700; color: #dc2626; background: #fee2e2; padding: 1px 5px; border-radius: 3px;">PDF</span>
                                </div>
                                <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-main); margin-bottom: 0.25rem;">Surat_Permohonan_Peminjaman.pdf</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">245 KB • Diunggah 20 Sep 2026</div>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="#" class="btn-sm btn-sm-outline" style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.8rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                                        Buka di Tab Baru
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" data-modal-close>Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Setujui -->
    <div class="modal-backdrop" id="modalSetujuPeminjaman">
        <div class="modal-dialog" style="max-width: 400px; text-align: center; padding: 0;">
            <div style="padding: 2rem 1.5rem 1.5rem;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background-color: #d1fae5; color: #059669; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 30px; height: 30px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.5rem;">Setujui Peminjaman?</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.5;">Anda yakin ingin menyetujui permohonan peminjaman ruangan ini? Notifikasi akan dikirimkan ke peminjam.</p>
            </div>
            <div style="display: flex; gap: 0.75rem; padding: 1rem 1.5rem; background-color: var(--surface-hover); border-top: 1px solid var(--border-color); border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                <button class="btn btn-outline" style="flex: 1; justify-content: center;" data-modal-close>Batal</button>
                <button class="btn" style="flex: 1; justify-content: center; background-color: #059669; color: white;" data-modal-close>Ya, Setujui</button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Tolak -->
    <div class="modal-backdrop" id="modalTolakPeminjaman">
        <div class="modal-dialog" style="max-width: 400px;">
            <div class="modal-header">
                <h3 class="modal-title">Tolak Peminjaman</h3>
                <button class="modal-close" data-modal-close>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="modal-body">
                <div style="margin-bottom: 1.25rem; padding: 1rem; background-color: #fee2e2; color: #b91c1c; border-radius: 8px; font-size: 0.9rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" /></svg>
                    <span>Anda akan menolak permohonan ini. Silakan berikan alasan penolakan.</span>
                </div>
                <div class="form-group">
                    <label class="form-label">Alasan Penolakan</label>
                    <textarea class="form-control" rows="3" placeholder="Contoh: Jadwal bentrok dengan acara dinas internal..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" data-modal-close>Batal</button>
                <button class="btn" style="background-color: #dc2626; color: white;" data-modal-close>Tolak Peminjaman</button>
            </div>
        </div>
    </div>
@endsection
