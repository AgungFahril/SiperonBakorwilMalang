@extends('layouts.app')

@section('title', 'Cek Status Booking - SIPERON')

@section('content')
<section style="padding: 70px 0 90px; min-height: 65vh; background: #f8fafc;">
    <div class="container" style="max-width: 760px;">

        <div style="text-align: center; margin-bottom: 2rem;">
            <span style="background: #e0f2fe; color: #0284c7; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 700; letter-spacing: 0.8px;">PELACAKAN STATUS</span>
            <h1 style="font-size: 2rem; font-weight: 800; color: #0f172a; margin: 6px 0;">Cek Status Permohonan Booking</h1>
            <p style="color: #64748b; font-size: 0.95rem; max-width: 500px; margin: 0 auto;">Masukkan kode booking Anda (misal: <code>BR-20261103-0001</code> atau <code>PG-20261103-0001</code>) untuk melihat status persetujuan.</p>
        </div>

        <form method="POST" action="{{ route('cek.booking') }}" class="cek-booking-form-inline" style="display: flex; gap: 12px; margin-bottom: 2rem; flex-wrap: wrap; background: #ffffff; padding: 12px; border-radius: 14px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
            @csrf
            <input type="text" name="kode_booking" value="{{ old('kode_booking', request('kode_booking')) }}" placeholder="Masukkan Kode Booking atau Kode Paket..."
                   style="flex: 1 1 240px; padding: 12px 18px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 1rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;"
                   required>
            <button type="submit" class="btn btn-primary" style="white-space: nowrap; flex: 0 0 auto; padding: 12px 24px; font-weight: 700;">Cek Status</button>
        </form>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #b91c1c; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 2rem; font-size: 0.9rem; border: 1px solid #fecaca;">
                {{ $errors->first() }}
            </div>
        @endif

        @if (isset($booking))
            @php
                $isMulti = isset($groupBookings) && $groupBookings->count() > 1;
            @endphp

            {{-- Jika Multi Ruangan: Tampilkan Rangkuman Seluruh Ruangan --}}
            @if($isMulti)
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; flex-wrap: wrap; gap: 8px;">
                        <div>
                            <span style="font-size: 11px; font-weight: 700; color: #08a6d9; text-transform: uppercase; letter-spacing: 0.5px;">Paket Pengajuan Multi-Ruangan</span>
                            <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 2px 0 0;">{{ $groupBookings->count() }} Ruangan Diajukan</h3>
                        </div>
                        <span style="font-size: 12px; color: #64748b;">Pemohon: <strong>{{ $booking->nama_pemohon }}</strong></span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 10px;">
                        @foreach($groupBookings as $idx => $gb)
                            @php
                                $isSel = $gb->id === $booking->id;
                                $bgCol = $gb->status === 'disetujui' ? '#d1fae5' : ($gb->status === 'ditolak' ? '#fee2e2' : ($gb->status === 'dijadwalkan_ulang' ? '#e0e7ff' : '#fef3c7'));
                                $textCol = $gb->status === 'disetujui' ? '#065f46' : ($gb->status === 'ditolak' ? '#991b1b' : ($gb->status === 'dijadwalkan_ulang' ? '#3730a3' : '#92400e'));
                            @endphp
                            <form method="POST" action="{{ route('cek.booking') }}" style="margin: 0;">
                                @csrf
                                <input type="hidden" name="kode_booking" value="{{ $gb->kode_booking }}">
                                <button type="submit" style="width: 100%; text-align: left; background: {{ $isSel ? '#f0fdfa' : '#f8fafc' }}; border: 1.5px solid {{ $isSel ? '#08a6d9' : '#e2e8f0' }}; border-radius: 10px; padding: 12px; cursor: pointer; transition: all 0.15s ease;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                        <strong style="color: #0f172a; font-size: 13.5px;">{{ $idx + 1 }}. {{ $gb->room->name ?? 'Ruangan' }}</strong>
                                        <span style="background: {{ $bgCol }}; color: {{ $textCol }}; font-size: 10.5px; font-weight: 700; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">
                                            {{ $gb->status }}
                                        </span>
                                    </div>
                                    <div style="font-size: 12px; color: #64748b;">
                                        <code>{{ $gb->kode_booking }}</code> &bull; {{ $gb->tanggal->translatedFormat('d M Y') }}
                                    </div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            @endif

            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">

                {{-- Header --}}
                <div style="padding: 1.5rem 2rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; background: #fafcff;">
                    <div>
                        <p style="font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 2px 0;">KODE BOOKING RUANGAN INI</p>
                        <h2 style="font-size: 1.6rem; color: #08a6d9; letter-spacing: 1px; font-weight: 800; margin: 0; font-family: ui-monospace, monospace;">{{ $booking->kode_booking }}</h2>
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
                <div style="padding: 1.75rem 2rem;">
                    <table style="width: 100%; font-size: 0.92rem; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 10px 0; color: #64748b; width: 35%; border-bottom: 1px solid #f8fafc;">Ruangan</td>
                            <td style="padding: 10px 0; font-weight: 700; color: #0f172a; border-bottom: 1px solid #f8fafc;">{{ $booking->room->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; color: #64748b; border-bottom: 1px solid #f8fafc;">Pemohon</td>
                            <td style="padding: 10px 0; font-weight: 600; color: #1e293b; border-bottom: 1px solid #f8fafc;">{{ $booking->nama_pemohon }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; color: #64748b; border-bottom: 1px solid #f8fafc;">Instansi</td>
                            <td style="padding: 10px 0; color: #1e293b; border-bottom: 1px solid #f8fafc;">{{ $booking->instansi ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; color: #64748b; border-bottom: 1px solid #f8fafc;">Tanggal Pelaksanaan</td>
                            <td style="padding: 10px 0; font-weight: 600; color: #1e293b; border-bottom: 1px solid #f8fafc;">{{ $booking->tanggal->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; color: #64748b; border-bottom: 1px solid #f8fafc;">Waktu</td>
                            <td style="padding: 10px 0; font-weight: 600; color: #1e293b; border-bottom: 1px solid #f8fafc;">{{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; color: #64748b; border-bottom: 1px solid #f8fafc;">Keperluan / Acara</td>
                            <td style="padding: 10px 0; color: #1e293b; border-bottom: 1px solid #f8fafc;">{{ $booking->nama_kegiatan }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; color: #64748b; border-bottom: 1px solid #f8fafc;">Jumlah Peserta</td>
                            <td style="padding: 10px 0; font-weight: 600; color: #1e293b; border-bottom: 1px solid #f8fafc;">{{ $booking->jumlah_peserta ? $booking->jumlah_peserta . ' Orang' : '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; color: #64748b; border-bottom: 1px solid #f8fafc;">Diajukan Pada</td>
                            <td style="padding: 10px 0; color: #64748b; border-bottom: 1px solid #f8fafc;">{{ $booking->created_at->translatedFormat('d F Y, H:i') }}</td>
                        </tr>
                        @if($booking->catatan)
                        <tr>
                            <td style="padding: 10px 0; color: #64748b;">Catatan dari Petugas</td>
                            <td style="padding: 10px 0; color: #0f172a; font-weight: 600;">{{ $booking->catatan }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                {{-- Riwayat Perubahan --}}
                @if($booking->histories->count() > 0)
                <div style="padding: 1.5rem 2rem; border-top: 1px solid #e2e8f0; background: #fafcff;">
                    <h3 style="font-size: 0.95rem; font-weight: 700; margin: 0 0 1rem; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px;">Riwayat Status</h3>
                    @foreach($booking->histories as $history)
                        <div style="display: flex; gap: 12px; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: #08a6d9; margin-top: 6px; flex-shrink: 0;"></div>
                            <div>
                                <p style="font-size: 0.88rem; font-weight: 700; color: #1e293b; margin: 0 0 2px;">
                                    {{ $history->status_sebelumnya ? ucfirst(str_replace('_', ' ', $history->status_sebelumnya)) : 'Pengajuan Baru' }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin: 0 3px;"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 5"/></svg>
                                    {{ ucfirst(str_replace('_', ' ', $history->status_baru)) }}
                                </p>
                                @if($history->alasan)
                                    <p style="font-size: 0.82rem; color: #dc2626; margin: 2px 0;">Alasan: {{ $history->alasan }}</p>
                                @endif
                                @if($history->perubahan)
                                    <p style="font-size: 0.82rem; color: #64748b; margin: 2px 0;">{{ $history->perubahan }}</p>
                                @endif
                                <p style="font-size: 0.78rem; color: #94a3b8; margin: 4px 0 0;">
                                    {{ $history->created_at->translatedFormat('d F Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

            </div>

            @if($booking->status === 'dijadwalkan_ulang')
                <div style="margin-top: 1.5rem; background: #e0e7ff; border-left: 4px solid #6366f1; padding: 1.25rem 1.5rem; border-radius: 10px;">
                    <p style="font-weight: 700; color: #3730a3; margin: 0 0 0.5rem 0;">Peminjaman Anda Perlu Dijadwalkan Ulang</p>
                    <p style="font-size: 0.9rem; color: #4338ca; margin: 0 0 1rem 0;">Silakan ajukan permohonan baru untuk memilih tanggal alternatif lain yang tersedia.</p>
                    <a href="{{ route('booking.form.multi') }}" class="btn btn-primary" style="display: inline-block;">Ajukan Peminjaman Baru</a>
                </div>
            @endif

        @endif

        <div style="text-align: center; margin-top: 2.5rem;">
            <a href="{{ route('home') }}" style="color: #08a6d9; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali ke Beranda
            </a>
        </div>

    </div>
</section>
@endsection
