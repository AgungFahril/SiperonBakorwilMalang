@extends('layouts.app')

@section('title', 'Cek Status Booking - SIPERON')

@section('content')
<section style="padding: 80px 0; min-height: 60vh;">
    <div class="container" style="max-width: 700px;">

        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 1.8rem; color: #171717; margin-bottom: 0.5rem;">Cek Status Booking</h1>
            <p style="color: #666;">Masukkan kode booking Anda untuk melihat status peminjaman.</p>
        </div>

        <form method="POST" action="{{ route('cek.booking') }}" class="cek-booking-form-inline" style="display: flex; gap: 12px; margin-bottom: 2rem; flex-wrap: wrap;">
            @csrf
            <input type="text" name="kode_booking" value="{{ old('kode_booking') }}" placeholder="Contoh: BR-20261008-0001"
                   style="flex: 1 1 240px; padding: 14px 18px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 1rem; text-transform: uppercase; letter-spacing: 1px;"
                   required>
            <button type="submit" class="btn btn-primary" style="white-space: nowrap; flex: 0 0 auto;">Cek Status</button>
        </form>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 10px; margin-bottom: 2rem; font-size: 0.9rem;">
                {{ $errors->first() }}
            </div>
        @endif

        @if (isset($booking))
            <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">

                {{-- Header --}}
                <div style="padding: 1.5rem 2rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <p style="font-size: 0.85rem; color: #666; margin-bottom: 4px;">Kode Booking</p>
                        <h2 style="font-size: 1.5rem; color: #08a6d9; letter-spacing: 1px; font-weight: 800;">{{ $booking->kode_booking }}</h2>
                    </div>
                    <div>
                        @php
                            $statusColors = [
                                'pending'             => ['bg' => '#fef3c7', 'text' => '#92400e', 'label' => 'MENUNGGU PERSETUJUAN'],
                                'disetujui'           => ['bg' => '#d1fae5', 'text' => '#065f46', 'label' => 'DISETUJUI'],
                                'ditolak'             => ['bg' => '#fee2e2', 'text' => '#991b1b', 'label' => 'DITOLAK'],
                                'dijadwalkan_ulang'   => ['bg' => '#e0e7ff', 'text' => '#3730a3', 'label' => 'PERLU PENJADWALAN ULANG'],
                                'selesai'             => ['bg' => '#f3f4f6', 'text' => '#374151', 'label' => 'SELESAI'],
                            ];
                            $sc = $statusColors[$booking->status] ?? ['bg' => '#f3f4f6', 'text' => '#374151', 'label' => strtoupper($booking->status)];
                        @endphp
                        <span style="display: inline-block; padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; background: {{ $sc['bg'] }}; color: {{ $sc['text'] }};">
                            {{ $sc['label'] }}
                        </span>
                    </div>
                </div>

                {{-- Detail --}}
                <div style="padding: 1.5rem 2rem;">
                    <table style="width: 100%; font-size: 0.9rem;">
                        <tr>
                            <td style="padding: 8px 0; color: #666; width: 35%;">Ruangan</td>
                            <td style="padding: 8px 0; font-weight: 600;">{{ $booking->room->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;">Pemohon</td>
                            <td style="padding: 8px 0; font-weight: 600;">{{ $booking->nama_pemohon }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;">Instansi</td>
                            <td style="padding: 8px 0;">{{ $booking->instansi ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;">Tanggal</td>
                            <td style="padding: 8px 0; font-weight: 600;">{{ $booking->tanggal->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;">Waktu</td>
                            <td style="padding: 8px 0; font-weight: 600;">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;">Keperluan</td>
                            <td style="padding: 8px 0;">{{ $booking->nama_kegiatan }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;">Jumlah Peserta</td>
                            <td style="padding: 8px 0; font-weight: 600;">{{ $booking->jumlah_peserta ? $booking->jumlah_peserta . ' Orang' : '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;">Diajukan Pada</td>
                            <td style="padding: 8px 0;">{{ $booking->created_at->translatedFormat('d F Y, H:i') }}</td>
                        </tr>
                        @if($booking->catatan)
                        <tr>
                            <td style="padding: 8px 0; color: #666;">Catatan Admin</td>
                            <td style="padding: 8px 0;">{{ $booking->catatan }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                {{-- Riwayat Perubahan --}}
                @if($booking->histories->count() > 0)
                <div style="padding: 1.5rem 2rem; border-top: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1rem; margin-bottom: 1rem; color: #171717;">Riwayat Perubahan</h3>
                    @foreach($booking->histories as $history)
                        <div style="display: flex; gap: 12px; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f3f4f6;">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: #08a6d9; margin-top: 6px; flex-shrink: 0;"></div>
                            <div>
                                <p style="font-size: 0.85rem; font-weight: 600; color: #171717; margin-bottom: 2px;">
                                    {{ $history->status_sebelumnya ? ucfirst(str_replace('_', ' ', $history->status_sebelumnya)) : 'Baru' }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin: 0 2px;"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg> {{ ucfirst(str_replace('_', ' ', $history->status_baru)) }}
                                </p>
                                @if($history->alasan)
                                    <p style="font-size: 0.82rem; color: #666; margin-bottom: 2px;">Alasan: {{ $history->alasan }}</p>
                                @endif
                                @if($history->perubahan)
                                    <p style="font-size: 0.82rem; color: #666; margin-bottom: 2px;">{{ $history->perubahan }}</p>
                                @endif
                                <p style="font-size: 0.78rem; color: #999;">
                                    {{ $history->created_at->translatedFormat('d F Y, H:i') }}
                                    @if($history->admin) — oleh {{ $history->admin->name }} @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

            </div>

            @if($booking->status === 'dijadwalkan_ulang')
                <div style="margin-top: 1.5rem; background: #e0e7ff; border-left: 4px solid #6366f1; padding: 1.2rem 1.5rem; border-radius: 8px;">
                    <p style="font-weight: 600; color: #3730a3; margin-bottom: 0.5rem;">Peminjaman Anda Perlu Dijadwalkan Ulang</p>
                    <p style="font-size: 0.9rem; color: #4338ca;">Silakan buat pengajuan baru dengan memilih ruangan dan jadwal yang masih tersedia.</p>
                    <a href="{{ route('home') }}#ruangan" class="btn btn-primary" style="margin-top: 1rem; display: inline-block;">Ajukan Peminjaman Baru</a>
                </div>
            @endif

        @endif

        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('home') }}" style="color: #08a6d9; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Kembali ke Beranda</a>
        </div>

    </div>
</section>
@endsection
