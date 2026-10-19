@extends('layouts.app')

@section('title', 'Pengajuan Berhasil - SIPERON')

@section('content')
<section style="padding: 80px 0; min-height: 60vh; display: flex; align-items: center;">
    <div class="container" style="max-width: 600px; text-align: center;">

        <div style="background: #d1fae5; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#059669">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </div>

        <h1 style="font-size: 1.8rem; color: #171717; margin-bottom: 0.5rem;">Pengajuan Berhasil Dikirim!</h1>
        <p style="color: #666; margin-bottom: 2rem;">Silakan simpan kode booking Anda untuk mengecek status peminjaman.</p>

        <div style="background: #f8fafc; border: 2px dashed #08a6d9; border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
            <p style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Kode Booking Anda:</p>
            <h2 style="font-size: 2rem; color: #08a6d9; letter-spacing: 2px; font-weight: 800; margin-bottom: 0.5rem;">{{ $booking->kode_booking }}</h2>
            <p style="font-size: 0.85rem; color: #999;">Status: <strong style="color: #f59e0b;">MENUNGGU PERSETUJUAN</strong></p>
        </div>

        <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.5rem; text-align: left; margin-bottom: 2rem;">
            <h3 style="font-size: 1rem; margin-bottom: 1rem; color: #171717;">Detail Peminjaman</h3>
            <table style="width: 100%; font-size: 0.9rem;">
                <tr>
                    <td style="padding: 6px 0; color: #666; width: 40%;">Ruangan</td>
                    <td style="padding: 6px 0; font-weight: 600;">{{ $booking->room->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #666;">Pemohon</td>
                    <td style="padding: 6px 0; font-weight: 600;">{{ $booking->nama_pemohon }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #666;">Tanggal</td>
                    <td style="padding: 6px 0; font-weight: 600;">{{ $booking->tanggal->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #666;">Waktu</td>
                    <td style="padding: 6px 0; font-weight: 600;">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #666;">Keperluan</td>
                    <td style="padding: 6px 0; font-weight: 600;">{{ $booking->nama_kegiatan }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #666;">Jumlah Peserta</td>
                    <td style="padding: 6px 0; font-weight: 600;">{{ $booking->jumlah_peserta ? $booking->jumlah_peserta . ' Orang' : '-' }}</td>
                </tr>
            </table>
        </div>

        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="btn btn-outline">Kembali ke Beranda</a>
            <a href="{{ route('cek.booking.form') }}" class="btn btn-primary">Cek Status Booking</a>
        </div>

    </div>
</section>
@endsection
