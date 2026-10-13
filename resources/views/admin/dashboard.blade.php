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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Peminjaman Disetujui</span>
                <span class="stat-value">{{ $approvedCount }}</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon icon-purple">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">Jadwal Ulang</span>
                <span class="stat-value">{{ $rescheduleCount }}</span>
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
                        <th>Kode / Peminjam</th>
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
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <strong style="color: #08a6d9; letter-spacing: 0.5px;">{{ $booking->kode_booking ?? '#PMJ-'.$booking->id }}</strong>
                            </div>
                            <div style="font-weight: 600; color: var(--text-main); font-size: 0.85rem; margin-top: 2px;">{{ $booking->nama_pemohon }}</div>
                            <span style="color: var(--text-muted); font-size: 0.75rem;">{{ $booking->instansi ?? '-' }}</span>
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
                            @elseif($booking->status === 'dijadwalkan_ulang')
                                <span class="status-badge" style="background: #e0e7ff; color: #3730a3; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 0.75rem;">Jadwal Ulang</span>
                            @else
                                <span class="status-badge status-done">Selesai</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.peminjaman.show', $booking) }}" class="action-btn" title="Detail Peminjaman">
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
