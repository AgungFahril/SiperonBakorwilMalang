@extends('layouts.app')

@section('title', 'Riwayat Peminjaman - SIPERON')

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: 80px; min-height: 80vh;">
    
    <div style="max-width: 900px; margin: 0 auto;">
        
        <h2 style="font-size: 28px; color: #1e293b; margin-bottom: 10px;">Riwayat Peminjaman</h2>
        <p style="color: #64748b; margin-bottom: 30px;">Pantau status pengajuan peminjaman ruangan Anda di sini.</p>

        @if (session('status'))
            <div class="alert alert-success" style="margin-bottom: 30px;">
                {{ session('status') }}
            </div>
        @endif

        @if($bookings->isEmpty())
            <div style="background: #f8fafc; border: 1px dashed #cbd5e1; padding: 40px; text-align: center; border-radius: 12px;">
                <p style="color: #64748b; font-size: 16px; margin-bottom: 15px;">Anda belum memiliki riwayat peminjaman.</p>
                <a href="{{ route('home') }}#ruangan" class="btn btn-primary" style="padding: 10px 20px; border-radius: 6px;">Ajukan Peminjaman Sekarang</a>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @foreach($bookings as $booking)
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                            <div>
                                <h3 style="margin: 0; font-size: 18px; color: #0f172a;">{{ $booking->nama_kegiatan }}</h3>
                                <div style="color: #64748b; font-size: 14px; margin-top: 4px;">
                                    <strong>Ruangan:</strong> {{ $booking->room ? $booking->room->name : 'Ruangan Dihapus' }}
                                </div>
                            </div>
                            <div>
                                @if($booking->status == 'pending')
                                    <span style="background: #fef08a; color: #854d0e; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Menunggu Konfirmasi</span>
                                @elseif($booking->status == 'disetujui')
                                    <span style="background: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Disetujui</span>
                                @elseif($booking->status == 'ditolak')
                                    <span style="background: #fee2e2; color: #991b1b; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Ditolak</span>
                                @else
                                    <span style="background: #e2e8f0; color: #475569; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Selesai</span>
                                @endif
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; padding: 15px; background: #f8fafc; border-radius: 8px; font-size: 14px;">
                            <div>
                                <div style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal</div>
                                <div style="color: #334155; font-weight: 500;">{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('l, d F Y') }}</div>
                            </div>
                            <div>
                                <div style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Waktu</div>
                                <div style="color: #334155; font-weight: 500;">{{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB</div>
                            </div>
                            <div>
                                <div style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Pemohon</div>
                                <div style="color: #334155; font-weight: 500;">{{ $booking->nama_pemohon }} {{ $booking->instansi ? '('.$booking->instansi.')' : '' }}</div>
                            </div>
                            <div>
                                <div style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Diajukan Pada</div>
                                <div style="color: #334155; font-weight: 500;">{{ $booking->created_at->diffForHumans() }}</div>
                            </div>
                        </div>

                        @if($booking->catatan)
                            <div style="margin-top: 15px; padding: 12px 15px; border-left: 4px solid {{ $booking->status == 'ditolak' ? '#ef4444' : '#3b82f6' }}; background: {{ $booking->status == 'ditolak' ? '#fef2f2' : '#eff6ff' }}; border-radius: 0 8px 8px 0;">
                                <div style="font-size: 13px; font-weight: 600; color: {{ $booking->status == 'ditolak' ? '#991b1b' : '#1e40af' }}; margin-bottom: 4px;">Pesan dari Pengelola:</div>
                                <div style="font-size: 14px; color: #334155;">{{ $booking->catatan }}</div>
                            </div>
                        @endif

                        @if($booking->surat_pengajuan)
                            <div style="margin-top: 15px; display: flex; align-items: center; gap: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ef4444"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                                <a href="{{ asset('storage/' . $booking->surat_pengajuan) }}" target="_blank" style="color: #08a6d9; font-weight: 600; font-size: 14px; text-decoration: none;">
                                    Lihat Surat Pengajuan (PDF)
                                </a>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
