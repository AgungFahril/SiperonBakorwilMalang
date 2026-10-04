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
                <span class="stat-value">{{ $totalRooms }}</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-orange">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Menunggu Persetujuan</span>
                <span class="stat-value">{{ $pendingCount }}</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Peminjaman Hari Ini</span>
                <span class="stat-value">{{ $todayBookings }}</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-purple">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Pengguna</span>
                <span class="stat-value">{{ $totalUsers }}</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div style="padding: 0.75rem 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem;">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Recent Bookings Table -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Peminjaman Terbaru</h2>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Instansi / Peminjam</th>
                        <th>Ruangan</th>
                        <th>Tanggal Acara</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                    <tr>
                        <td>
                            <strong>{{ $booking->instansi ?? '-' }}</strong><br>
                            <span style="color: var(--text-muted); font-size: 0.75rem;">{{ $booking->nama_pemohon }}</span>
                        </td>
                        <td>{{ $booking->room->name ?? '-' }}</td>
                        <td>{{ $booking->tanggal->translatedFormat('d M Y') }}<br><span style="color: var(--text-muted); font-size: 0.75rem;">{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}</span></td>
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
                            <a href="{{ route('admin.peminjaman.index') }}" class="action-btn" title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                            </a>
                            @if($booking->status === 'pending')
                                <form action="{{ route('admin.peminjaman.status', $booking) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="disetujui">
                                    <button type="submit" class="action-btn" title="Setujui" style="color: #059669;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.peminjaman.status', $booking) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="action-btn" title="Tolak" style="color: #dc2626;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            Belum ada data peminjaman.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
