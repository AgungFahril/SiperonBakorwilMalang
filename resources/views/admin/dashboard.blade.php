@extends('layouts.admin')

@section('title', 'Dashboard - Admin SIPERON')

@section('content')
    <div class="page-title">Overview Dashboard</div>
    
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" /></svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Ruangan</span>
                <span class="stat-value">12</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-orange">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Menunggu Persetujuan</span>
                <span class="stat-value">5</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Peminjaman Hari Ini</span>
                <span class="stat-value">3</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-purple">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Pengguna</span>
                <span class="stat-value">148</span>
            </div>
        </div>
    </div>
    
    <!-- Recent Bookings Table -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Peminjaman Terbaru</h2>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Instansi / Peminjam</th>
                        <th>Ruangan</th>
                        <th>Tanggal Acara</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#PMJ-001</td>
                        <td>
                            <strong>Dinas Pendidikan Prov Jatim</strong><br>
                            <span style="color: var(--text-muted); font-size: 0.75rem;">Bpk. Budi Santoso</span>
                        </td>
                        <td>Ruang Rapat Utama (Bhirawa)</td>
                        <td>24 Sep 2026<br><span style="color: var(--text-muted); font-size: 0.75rem;">09:00 - 15:00</span></td>
                        <td><span class="status-badge status-pending">Menunggu</span></td>
                        <td>
                            <button class="action-btn" title="Detail"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg></button>
                            <button class="action-btn" title="Setujui" style="color: #059669;"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg></button>
                            <button class="action-btn" title="Tolak" style="color: #dc2626;"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" /></svg></button>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>#PMJ-002</td>
                        <td>
                            <strong>Dinas Kominfo Malang</strong><br>
                            <span style="color: var(--text-muted); font-size: 0.75rem;">Ibu Rina S.</span>
                        </td>
                        <td>Aula Pertemuan Bakorwil</td>
                        <td>25 Sep 2026<br><span style="color: var(--text-muted); font-size: 0.75rem;">08:00 - 12:00</span></td>
                        <td><span class="status-badge status-approved">Disetujui</span></td>
                        <td>
                            <button class="action-btn" title="Detail"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg></button>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>#PMJ-003</td>
                        <td>
                            <strong>Universitas Brawijaya</strong><br>
                            <span style="color: var(--text-muted); font-size: 0.75rem;">Panitia Seminar</span>
                        </td>
                        <td>Ruang Sidang</td>
                        <td>21 Sep 2026<br><span style="color: var(--text-muted); font-size: 0.75rem;">13:00 - 16:00</span></td>
                        <td><span class="status-badge status-rejected">Ditolak</span></td>
                        <td>
                            <button class="action-btn" title="Detail"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg></button>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>#PMJ-004</td>
                        <td>
                            <strong>Dinas Pariwisata</strong><br>
                            <span style="color: var(--text-muted); font-size: 0.75rem;">Bpk. Agus W.</span>
                        </td>
                        <td>Ruang Rapat Utama (Bhirawa)</td>
                        <td>28 Sep 2026<br><span style="color: var(--text-muted); font-size: 0.75rem;">09:00 - 12:00</span></td>
                        <td><span class="status-badge status-approved">Disetujui</span></td>
                        <td>
                            <button class="action-btn" title="Detail"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
