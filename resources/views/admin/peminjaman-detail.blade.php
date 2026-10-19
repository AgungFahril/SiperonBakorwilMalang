@extends('layouts.admin')

@section('title', 'Detail Peminjaman - Admin SIPERON')

@section('content')
    <div class="page-header-row">
        <div>
            <div class="page-title">Detail Peminjaman</div>
            <p class="page-subtitle">{{ $booking->kode_booking }}</p>
        </div>
        <a href="{{ route('admin.peminjaman.index') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #08a6d9; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Daftar
        </a>
    </div>

    @if(session('success'))
        <div style="padding: 0.75rem 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">

        {{-- Informasi Booking --}}
        <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.2rem; color: #171717;">Informasi Peminjaman</h3>
            @php
                $statusColors = [
                    'pending'           => ['bg' => '#fef3c7', 'text' => '#92400e', 'label' => 'Menunggu Persetujuan'],
                    'disetujui'         => ['bg' => '#d1fae5', 'text' => '#065f46', 'label' => 'Disetujui'],
                    'ditolak'           => ['bg' => '#fee2e2', 'text' => '#991b1b', 'label' => 'Ditolak'],
                    'dijadwalkan_ulang' => ['bg' => '#e0e7ff', 'text' => '#3730a3', 'label' => 'Perlu Penjadwalan Ulang'],
                    'selesai'           => ['bg' => '#f3f4f6', 'text' => '#374151', 'label' => 'Selesai'],
                ];
                $sc = $statusColors[$booking->status] ?? ['bg' => '#f3f4f6', 'text' => '#374151', 'label' => ucfirst($booking->status)];
            @endphp
            <table style="width: 100%; font-size: 0.9rem;">
                <tr><td style="padding: 8px 0; color: #666; width: 40%;">Kode Booking</td><td style="padding: 8px 0; font-weight: 700; color: #08a6d9; letter-spacing: 1px;">{{ $booking->kode_booking }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Status</td><td style="padding: 8px 0;"><span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; background: {{ $sc['bg'] }}; color: {{ $sc['text'] }};">{{ $sc['label'] }}</span></td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Ruangan</td><td style="padding: 8px 0; font-weight: 600;">{{ $booking->room->name ?? '-' }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Tanggal</td><td style="padding: 8px 0; font-weight: 600;">{{ $booking->tanggal->translatedFormat('l, d F Y') }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Waktu</td><td style="padding: 8px 0; font-weight: 600;">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Keperluan</td><td style="padding: 8px 0;">{{ $booking->nama_kegiatan }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Jumlah Peserta</td><td style="padding: 8px 0; font-weight: 600;">{{ $booking->jumlah_peserta ? $booking->jumlah_peserta . ' Orang' : '-' }}</td></tr>
                @if($booking->keterangan)<tr><td style="padding: 8px 0; color: #666;">Keterangan</td><td style="padding: 8px 0;">{{ $booking->keterangan }}</td></tr>@endif
                @if($booking->surat_pengajuan)<tr><td style="padding: 8px 0; color: #666;">Surat Pengajuan</td><td style="padding: 8px 0;"><a href="{{ asset('storage/' . $booking->surat_pengajuan) }}" target="_blank" style="color: #08a6d9;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg> Lihat PDF</a></td></tr>@endif
                <tr><td style="padding: 8px 0; color: #666;">Diajukan Pada</td><td style="padding: 8px 0;">{{ $booking->created_at->translatedFormat('d F Y, H:i') }}</td></tr>
                @if($booking->admin)<tr><td style="padding: 8px 0; color: #666;">Diproses Oleh</td><td style="padding: 8px 0;">{{ $booking->admin->name }}</td></tr>@endif
                @if($booking->approved_at)<tr><td style="padding: 8px 0; color: #666;">Waktu Persetujuan</td><td style="padding: 8px 0;">{{ $booking->approved_at->translatedFormat('d F Y, H:i') }}</td></tr>@endif
                @if($booking->catatan)<tr><td style="padding: 8px 0; color: #666;">Catatan Admin</td><td style="padding: 8px 0;">{{ $booking->catatan }}</td></tr>@endif
            </table>
        </div>

        {{-- Informasi Pemohon --}}
        <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.2rem; color: #171717;">Informasi Pemohon</h3>
            <table style="width: 100%; font-size: 0.9rem;">
                <tr><td style="padding: 8px 0; color: #666; width: 40%;">Nama</td><td style="padding: 8px 0; font-weight: 600;">{{ $booking->nama_pemohon }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Instansi</td><td style="padding: 8px 0;">{{ $booking->instansi ?: '-' }}</td></tr>
                <tr>
                    <td style="padding: 8px 0; color: #666;">WhatsApp</td>
                    <td style="padding: 8px 0;">
                        @php
                            $roomName = $booking->room ? $booking->room->name : '-';
                            $waText = "Halo {$booking->nama_pemohon}, kami dari Pengelola Ruangan Bakorwil III Malang mengonfirmasi pengajuan peminjaman ruangan dengan Kode Booking: {$booking->kode_booking} (Ruangan {$roomName}).";
                            $waUrl = \App\Services\WhatsAppService::generateWaLink($booking->no_whatsapp, $waText);
                        @endphp
                        <a href="{{ $waUrl }}" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; background: #dcfce7; color: #15803d; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 0.85rem;" title="Klik untuk membuka chat WhatsApp langsung">
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> {{ $booking->no_whatsapp }}</span>
                            <span style="font-size: 0.75rem; text-decoration: underline;">(Buka Chat WA)</span>
                        </a>
                    </td>
                </tr>
                <tr><td style="padding: 8px 0; color: #666;">Email</td><td style="padding: 8px 0;"><a href="mailto:{{ $booking->email }}" style="color: #08a6d9;">{{ $booking->email }}</a></td></tr>
            </table>

            {{-- Aksi --}}
            @if(in_array($booking->status, ['pending', 'disetujui']))
            <div style="margin-top: 2rem; border-top: 1px solid #f3f4f6; padding-top: 1.5rem;">
                <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 1rem; color: #171717;">Aksi</h4>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    @if($booking->status === 'pending')
                        <form action="{{ route('admin.peminjaman.status', $booking) }}" method="POST" style="margin: 0;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="disetujui">
                            <button type="submit" style="padding: 8px 16px; background: #059669; color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Setujui</button>
                        </form>
                        <form action="{{ route('admin.peminjaman.status', $booking) }}" method="POST" style="margin: 0;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="ditolak">
                            <button type="submit" style="padding: 8px 16px; background: #dc2626; color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Tolak</button>
                        </form>
                    @endif
                    @if(in_array($booking->status, ['pending', 'disetujui']))
                        <button onclick="document.getElementById('rescheduleForm').style.display='block'" style="padding: 8px 16px; background: #6366f1; color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg> Minta Penjadwalan Ulang</button>
                    @endif
                </div>

                {{-- Form Reschedule (tersembunyi) --}}
                <div id="rescheduleForm" style="display: none; margin-top: 1.5rem; background: #f8fafc; padding: 1.5rem; border-radius: 10px; border: 1px solid #e5e7eb;">
                    <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: #3730a3;">Minta Penjadwalan Ulang</h4>
                    <div style="margin-bottom: 1rem; font-size: 0.85rem; color: #666;">
                        <p><strong>Jadwal saat ini:</strong></p>
                        <p>Ruangan: {{ $booking->room->name ?? '-' }}</p>
                        <p>Tanggal: {{ $booking->tanggal->translatedFormat('l, d F Y') }}</p>
                        <p>Jam: {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</p>
                    </div>
                    <form action="{{ route('admin.peminjaman.reschedule', $booking) }}" method="POST">
                        @csrf
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #374151;">Alasan perubahan: <span style="color: red;">*</span></label>
                        <textarea name="alasan" rows="3" required placeholder="Jelaskan alasan penjadwalan ulang..." style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.9rem; resize: vertical; margin-bottom: 1rem;"></textarea>
                        <div style="display: flex; gap: 8px;">
                            <button type="submit" style="padding: 8px 16px; background: #6366f1; color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">Konfirmasi Penjadwalan Ulang</button>
                            <button type="button" onclick="document.getElementById('rescheduleForm').style.display='none'" style="padding: 8px 16px; background: #e5e7eb; color: #374151; border: none; border-radius: 8px; font-size: 0.85rem; cursor: pointer;">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

    </div>

    {{-- Riwayat Perubahan --}}
    @if($booking->histories->count() > 0)
    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 1.5rem; margin-top: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.2rem; color: #171717;">Riwayat Perubahan</h3>
        @foreach($booking->histories as $history)
            <div style="display: flex; gap: 12px; margin-bottom: 1rem; padding-bottom: 1rem; {{ !$loop->last ? 'border-bottom: 1px solid #f3f4f6;' : '' }}">
                <div style="width: 10px; height: 10px; border-radius: 50%; background: #08a6d9; margin-top: 5px; flex-shrink: 0;"></div>
                <div>
                    <p style="font-size: 0.9rem; font-weight: 600; color: #171717; margin-bottom: 2px;">
                        {{ $history->status_sebelumnya ? ucfirst(str_replace('_', ' ', $history->status_sebelumnya)) : 'Baru' }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin: 0 2px;"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg> {{ ucfirst(str_replace('_', ' ', $history->status_baru)) }}
                    </p>
                    @if($history->alasan)
                        <p style="font-size: 0.85rem; color: #666; margin-bottom: 2px;">Alasan: {{ $history->alasan }}</p>
                    @endif
                    @if($history->perubahan)
                        <p style="font-size: 0.85rem; color: #666; margin-bottom: 2px;">{{ $history->perubahan }}</p>
                    @endif
                    <p style="font-size: 0.8rem; color: #999;">
                        {{ $history->created_at->translatedFormat('d F Y, H:i') }}
                        @if($history->admin) — oleh {{ $history->admin->name }} @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    @endif

@endsection
