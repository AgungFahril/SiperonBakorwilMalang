@extends('layouts.admin')

@section('title', 'Detail Peminjaman - Admin SIPERON')

@section('content')
    <div class="page-header-row">
        <div>
            <div class="page-title">Detail Peminjaman Ruangan</div>
            <p class="page-subtitle">
                Kode: <strong>{{ $booking->kode_booking }}</strong>
                @if(isset($groupBookings) && $groupBookings->count() > 1)
                    &bull; <span style="color: #08a6d9; font-weight: 700;">Paket Pengajuan: {{ $booking->group_code }} ({{ $groupBookings->count() }} Ruangan)</span>
                @endif
            </p>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('admin.peminjaman.index') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #08a6d9; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali ke Daftar
            </a>
            @if(isset($groupBookings) && $groupBookings->count() > 1)
                <form action="{{ route('admin.peminjaman.destroyGroup', $booking->group_code) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Yakin ingin menghapus seluruh paket pengajuan ini ({{ $groupBookings->count() }} ruangan)? Data yang dihapus tidak dapat dikembalikan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                        Hapus Seluruh Paket
                    </button>
                </form>
            @else
                <form action="{{ route('admin.peminjaman.destroy', $booking) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini? Data yang dihapus tidak dapat dikembalikan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                        Hapus Peminjaman
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div style="padding: 0.85rem 1.25rem; background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Banner Pop-up WhatsApp Siap Kirim (Template Otomatis Terisi) --}}
    @if(session('wa_confirm'))
        <div style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 2px solid #10b981; border-radius: 14px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 8px 24px rgba(16, 185, 129, 0.18); animation: slideDown 0.3s ease-out;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div style="display: flex; gap: 16px; align-items: center;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #25d366; color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.35);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    </div>
                    <div>
                        <span style="font-size: 11px; font-weight: 800; color: #047857; text-transform: uppercase; letter-spacing: 0.8px;">KONFIRMASI WHATSAPP SIAP KIRIM (GRATIS)</span>
                        <h4 style="margin: 2px 0 4px 0; font-size: 1.15rem; font-weight: 800; color: #065f46;">
                            Kirim Pesan Konfirmasi ke: {{ session('wa_confirm.nama') }}
                        </h4>
                        <p style="margin: 0; font-size: 0.88rem; color: #047857;">
                            Nomor: <strong>{{ session('wa_confirm.phone') }}</strong> &bull; Pesan template resmi sudah terisi otomatis, tinggal klik tombol di bawah untuk membuka WhatsApp & kirim.
                        </p>
                    </div>
                </div>
                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <a href="{{ session('wa_confirm.url') }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; padding: 11px 22px; background: #25d366; color: white; border-radius: 9px; font-weight: 800; font-size: 0.95rem; text-decoration: none; box-shadow: 0 4px 14px rgba(37, 211, 102, 0.4); transition: transform 0.15s ease;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span>Buka WhatsApp Sekarang &rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    @php
        $isMulti = isset($groupBookings) && $groupBookings->count() > 1;
        $pendingInGroup = $isMulti ? $groupBookings->where('status', 'pending') : collect();
        $cleanGroupPhone = $isMulti ? \App\Services\WhatsAppService::formatPhoneNumber($booking->no_whatsapp) : '';
        $waMsgGroupSetuju = $isMulti ? \App\Services\WhatsAppService::buildConfirmationMessage($groupBookings, 'disetujui') : '';
        $waUrlGroupSetuju = $isMulti ? \App\Services\WhatsAppService::generateWaLink($booking->no_whatsapp, $waMsgGroupSetuju) : '#';
        $waMsgGroupTolakBase = $isMulti ? \App\Services\WhatsAppService::buildConfirmationMessage($groupBookings, 'ditolak', '___ALASAN___') : '';

        // Variabel WhatsApp untuk permohonan / ruangan terpilih
        $waSingleApprove = \App\Services\WhatsAppService::buildConfirmationMessage(collect([$booking]), 'disetujui');
        $waUrlSingleApprove = \App\Services\WhatsAppService::generateWaLink($booking->no_whatsapp, $waSingleApprove);
        $waSingleTolakBase = \App\Services\WhatsAppService::buildConfirmationMessage(collect([$booking]), 'ditolak', '___ALASAN___');
        $waSingleRescheduleBase = \App\Services\WhatsAppService::buildConfirmationMessage(collect([$booking]), 'dijadwalkan_ulang', '___ALASAN___');
        $cleanSinglePhone = \App\Services\WhatsAppService::formatPhoneNumber($booking->no_whatsapp);
    @endphp

    {{-- JIKA PENGURUSAN MULTI-RUANGAN: TAMPILKAN PANEL MASSAL DI ATAS --}}
    @if($isMulti)
        <div style="background: #ffffff; border: 1.5px solid #08a6d9; border-radius: 14px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(8, 166, 217, 0.08);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 1.25rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
                <div>
                    <span style="font-size: 11px; font-weight: 700; color: #08a6d9; letter-spacing: 0.8px; text-transform: uppercase;">PENGURUSAN TERPADU</span>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 2px 0 0 0;">
                        Paket Pengajuan: {{ $groupBookings->count() }} Ruangan
                    </h3>
                    <p style="font-size: 13px; color: #64748b; margin: 2px 0 0 0;">
                        Diajukan bersama oleh: <strong>{{ $booking->nama_pemohon }}</strong> ({{ $booking->instansi ?: 'Perorangan' }})
                    </p>
                </div>

                {{-- Tombol Aksi Massal Sekaligus --}}
                @if($pendingInGroup->isNotEmpty())
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <form action="{{ route('admin.peminjaman.groupStatus', $booking->group_code) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="disetujui">
                            <button type="submit" onclick="return kirimWaDanSetuju(this.form, '{{ $waUrlGroupSetuju }}')" style="padding: 10px 18px; background: #25d366; color: white; border: none; border-radius: 8px; font-size: 0.9rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37,211,102,0.35);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                <span>Kirim WhatsApp & Setujui Semua ({{ $groupBookings->count() }} Ruang)</span>
                            </button>
                        </form>

                        <button onclick="document.getElementById('modalTolakGroupDetail').style.display='flex'" style="padding: 10px 18px; background: #dc2626; color: white; border: none; border-radius: 8px; font-size: 0.9rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>Kirim WhatsApp & Tolak Semua</span>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Rincian Kartu Ruangan-Ruangan dalam Paket Ini -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 14px;">
                @foreach($groupBookings as $idx => $gb)
                    @php
                        $isCurrent = $gb->id === $booking->id;
                        $badgeBg = $gb->status === 'disetujui' ? '#d1fae5' : ($gb->status === 'ditolak' ? '#fee2e2' : ($gb->status === 'dijadwalkan_ulang' ? '#e0e7ff' : '#fef3c7'));
                        $badgeColor = $gb->status === 'disetujui' ? '#065f46' : ($gb->status === 'ditolak' ? '#991b1b' : ($gb->status === 'dijadwalkan_ulang' ? '#3730a3' : '#92400e'));
                    @endphp
                    <div style="background: {{ $isCurrent ? '#f0fdfa' : '#f8fafc' }}; border: 1.5px solid {{ $isCurrent ? '#08a6d9' : '#e2e8f0' }}; border-radius: 10px; padding: 14px; position: relative;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                            <div>
                                <span style="font-size: 11px; font-weight: 700; color: #64748b;">RUANGAN #{{ $idx + 1 }}</span>
                                <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 2px 0 0 0;">
                                    {{ $gb->room->name ?? 'Ruangan' }}
                                </h4>
                                <span style="font-size: 12px; color: #08a6d9; font-weight: 600;">{{ $gb->kode_booking }}</span>
                            </div>
                            <span style="background: {{ $badgeBg }}; color: {{ $badgeColor }}; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">
                                {{ $gb->status }}
                            </span>
                        </div>

                        <div style="font-size: 13px; color: #334155; line-height: 1.6; margin-bottom: 12px;">
                            <div><strong>Tanggal:</strong> {{ $gb->tanggal->translatedFormat('l, d F Y') }}</div>
                            <div><strong>Waktu:</strong> {{ substr($gb->jam_mulai, 0, 5) }} - {{ substr($gb->jam_selesai, 0, 5) }} WIB</div>
                            <div><strong>Kegiatan:</strong> {{ $gb->nama_kegiatan }}</div>
                            <div><strong>Peserta:</strong> {{ $gb->jumlah_peserta ? $gb->jumlah_peserta . ' Orang' : '-' }} (Kapasitas: {{ $gb->room->capacity ?? '-' }})</div>
                        </div>

                        <!-- Tombol Aksi per Ruangan -->
                        <div style="display: flex; gap: 6px; flex-wrap: wrap; border-top: 1px dashed #cbd5e1; padding-top: 10px;">
                            @if(!$isCurrent)
                                <a href="{{ route('admin.peminjaman.show', $gb) }}" style="padding: 5px 10px; background: #e0f2fe; color: #0284c7; border-radius: 6px; font-size: 11.5px; font-weight: 600; text-decoration: none;">
                                    Buka Riwayat
                                </a>
                            @endif

                            @if($gb->status === 'pending')
                                @php
                                    $gbMsgApprove = \App\Services\WhatsAppService::buildConfirmationMessage(collect([$gb]), 'disetujui');
                                    $gbUrlApprove = \App\Services\WhatsAppService::generateWaLink($booking->no_whatsapp, $gbMsgApprove);
                                    $gbMsgTolakBase = \App\Services\WhatsAppService::buildConfirmationMessage(collect([$gb]), 'ditolak', '___ALASAN___');
                                @endphp
                                <form action="{{ route('admin.peminjaman.status', $gb) }}" method="POST" style="margin: 0;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="disetujui">
                                    <button type="submit" onclick="return kirimWaDanSetuju(this.form, '{{ $gbUrlApprove }}')" style="padding: 5px 10px; background: #059669; color: white; border: none; border-radius: 6px; font-size: 11.5px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                        ✓ Setujui & Buka WA
                                    </button>
                                </form>
                                <form action="{{ route('admin.peminjaman.status', $gb) }}" method="POST" style="margin: 0;" onsubmit="const r = prompt('Alasan penolakan ruangan {{ addslashes($gb->room->name ?? 'ini') }}:'); if(!r) return false; this.querySelector('input[name=catatan]').value = r; const base = @json($gbMsgTolakBase); window.open('https://wa.me/{{ $cleanGroupPhone }}?text=' + encodeURIComponent(base.replace('___ALASAN___', r)), '_blank'); return true;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="ditolak">
                                    <input type="hidden" name="catatan" value="">
                                    <button type="submit" style="padding: 5px 10px; background: #dc2626; color: white; border: none; border-radius: 6px; font-size: 11.5px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                        ✗ Tolak & Buka WA
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modal Tolak Sekaligus dari Detail -->
        <div id="modalTolakGroupDetail" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
            <div style="background: white; border-radius: 14px; width: 100%; max-width: 520px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
                <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
                    <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #0f172a;">Tolak Seluruh Ruangan ({{ $groupBookings->count() }} Ruangan)</h3>
                    <button type="button" onclick="document.getElementById('modalTolakGroupDetail').style.display='none'" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #94a3b8;">&times;</button>
                </div>
                <form action="{{ route('admin.peminjaman.groupStatus', $booking->group_code) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="ditolak">
                    <div style="padding: 24px;">
                        <label style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; color: #1e293b;">Alasan Penolakan untuk Pemohon: <span style="color: red;">*</span></label>
                        <textarea name="catatan" id="alasanTolakGroupDetail" rows="3" required placeholder="Contoh: Seluruh ruangan pada tanggal tersebut akan digunakan untuk acara dinas..." oninput="updateTolakPreview('GroupDetail')" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13.5px; resize: vertical; margin-bottom: 1rem;"></textarea>

                        <!-- Live Preview WhatsApp Rejection -->
                        <div style="text-align: left; background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 10px; padding: 10px 12px; margin-bottom: 1rem;">
                            <span style="font-size: 11px; font-weight: 800; color: #991b1b; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                Live Preview Pesan WhatsApp Penolakan:
                            </span>
                            <div id="previewTolakGroupDetail" style="font-size: 11.5px; color: #7f1d1d; background: #ffffff; padding: 8px 10px; border-radius: 6px; border: 1px solid #fee2e2; white-space: pre-wrap; max-height: 120px; overflow-y: auto; font-family: monospace; line-height: 1.45;">{{ str_replace('___ALASAN___', '(Ketik alasan di atas...)', $waMsgGroupTolakBase) }}</div>
                        </div>

                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <button type="button" onclick="document.getElementById('modalTolakGroupDetail').style.display='none'" class="btn btn-outline">Batal</button>
                            <button type="submit" onclick="return kirimWaDanTolak(this.form, 'GroupDetail', '{{ $cleanGroupPhone }}')" class="btn" style="background: #dc2626; color: white; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                <span>Kirim WhatsApp & Tolak Semua</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            window.tolakBaseTemplates = window.tolakBaseTemplates || {};
            window.tolakBaseTemplates['GroupDetail'] = @json($waMsgGroupTolakBase);
        </script>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">

        {{-- Informasi Booking Terpilih --}}
        <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.2rem; color: #171717;">
                Informasi Ruangan {{ $isMulti ? '(' . $booking->room->name . ')' : '' }}
            </h3>
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
                @if($booking->group_code)<tr><td style="padding: 8px 0; color: #666;">Kode Paket</td><td style="padding: 8px 0; font-weight: 700; color: #475569;">{{ $booking->group_code }}</td></tr>@endif
                <tr><td style="padding: 8px 0; color: #666;">Status</td><td style="padding: 8px 0;"><span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; background: {{ $sc['bg'] }}; color: {{ $sc['text'] }};">{{ $sc['label'] }}</span></td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Ruangan</td><td style="padding: 8px 0; font-weight: 600;">{{ $booking->room->name ?? '-' }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Tanggal</td><td style="padding: 8px 0; font-weight: 600;">{{ $booking->tanggal->translatedFormat('l, d F Y') }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Waktu</td><td style="padding: 8px 0; font-weight: 600;">{{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Keperluan</td><td style="padding: 8px 0;">{{ $booking->nama_kegiatan }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Jumlah Peserta</td><td style="padding: 8px 0; font-weight: 600;">{{ $booking->jumlah_peserta ? $booking->jumlah_peserta . ' Orang' : '-' }} (Kapasitas: {{ $booking->room->capacity ?? '-' }} Kursi)</td></tr>
                @if($booking->keterangan)<tr><td style="padding: 8px 0; color: #666;">Keterangan</td><td style="padding: 8px 0;">{{ $booking->keterangan }}</td></tr>@endif
                @if($booking->surat_pengajuan)<tr><td style="padding: 8px 0; color: #666;">Surat Pengajuan</td><td style="padding: 8px 0;"><a href="{{ asset('storage/' . $booking->surat_pengajuan) }}" target="_blank" style="color: #dc2626; font-weight: 600; text-decoration: none;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg> Buka Dokumen PDF Surat</a></td></tr>@endif
                <tr><td style="padding: 8px 0; color: #666;">Diajukan Pada</td><td style="padding: 8px 0;">{{ $booking->created_at->translatedFormat('d F Y, H:i') }}</td></tr>
                @if($booking->admin)<tr><td style="padding: 8px 0; color: #666;">Diproses Oleh</td><td style="padding: 8px 0;">{{ $booking->admin->name }}</td></tr>@endif
                @if($booking->approved_at)<tr><td style="padding: 8px 0; color: #666;">Waktu Persetujuan</td><td style="padding: 8px 0;">{{ $booking->approved_at->translatedFormat('d F Y, H:i') }}</td></tr>@endif
                @if($booking->catatan)<tr><td style="padding: 8px 0; color: #666;">Catatan Admin</td><td style="padding: 8px 0;">{{ $booking->catatan }}</td></tr>@endif
            </table>
        </div>

        {{-- Informasi Pemohon & Aksi Individual --}}
        <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.2rem; color: #171717;">Informasi Pemohon</h3>
            <table style="width: 100%; font-size: 0.9rem;">
                <tr><td style="padding: 8px 0; color: #666; width: 40%;">Nama</td><td style="padding: 8px 0; font-weight: 600;">{{ $booking->nama_pemohon }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Instansi</td><td style="padding: 8px 0;">{{ $booking->instansi ?: '-' }}</td></tr>
                <tr>
                    <td style="padding: 8px 0; color: #666;">WhatsApp</td>
                    <td style="padding: 8px 0;">
                        @php
                            $targetBookings = (isset($groupBookings) && $groupBookings->count() > 1) ? $groupBookings : collect([$booking]);
                            $waMessage = \App\Services\WhatsAppService::buildConfirmationMessage($targetBookings, $booking->status, $booking->catatan);
                            $waUrl = \App\Services\WhatsAppService::generateWaLink($booking->no_whatsapp, $waMessage);
                        @endphp
                        <a href="{{ $waUrl }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; background: #25d366; color: white; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(37, 211, 102, 0.3);" title="Buka WhatsApp dengan pesan template resmi yang sudah otomatis terisi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>{{ $booking->no_whatsapp }}</span>
                            <span style="font-size: 0.74rem; background: rgba(0,0,0,0.18); padding: 2px 7px; border-radius: 4px; font-weight: 600;">Buka WhatsApp Template &rarr;</span>
                        </a>
                    </td>
                </tr>
                <tr><td style="padding: 8px 0; color: #666;">Email</td><td style="padding: 8px 0;"><a href="mailto:{{ $booking->email }}" style="color: #08a6d9;">{{ $booking->email }}</a></td></tr>
            </table>

            {{-- Aksi Ruangan Ini --}}
            @if(in_array($booking->status, ['pending', 'disetujui']))
            <div style="margin-top: 2rem; border-top: 1px solid #f3f4f6; padding-top: 1.5rem;">
                <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 1rem; color: #171717;">
                    Aksi untuk Ruangan Ini ({{ $booking->room->name }})
                </h4>
                @php
                    $waSingleApprove = \App\Services\WhatsAppService::buildConfirmationMessage(collect([$booking]), 'disetujui');
                    $waUrlSingleApprove = \App\Services\WhatsAppService::generateWaLink($booking->no_whatsapp, $waSingleApprove);
                    $waSingleTolakBase = \App\Services\WhatsAppService::buildConfirmationMessage(collect([$booking]), 'ditolak', '___ALASAN___');
                    $waSingleRescheduleBase = \App\Services\WhatsAppService::buildConfirmationMessage(collect([$booking]), 'dijadwalkan_ulang', '___ALASAN___');
                    $cleanSinglePhone = \App\Services\WhatsAppService::formatPhoneNumber($booking->no_whatsapp);
                @endphp
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    @if($booking->status === 'pending')
                        <form action="{{ route('admin.peminjaman.status', $booking) }}" method="POST" style="margin: 0;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="disetujui">
                            <button type="submit" onclick="return kirimWaDanSetuju(this.form, '{{ $waUrlSingleApprove }}')" style="padding: 8px 16px; background: #059669; color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                <span>Kirim WA & Setujui Ruangan Ini</span>
                            </button>
                        </form>
                        <button onclick="document.getElementById('modalTolakSingleDetail').style.display='flex'" style="padding: 8px 16px; background: #dc2626; color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>Kirim WA & Tolak Ruangan Ini</span>
                        </button>
                    @endif
                    @if(in_array($booking->status, ['pending', 'disetujui']))
                        <button onclick="document.getElementById('rescheduleForm').style.display='block'" style="padding: 8px 16px; background: #6366f1; color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>Kirim WA & Minta Jadwal Ulang</span>
                        </button>
                    @endif
                </div>

                <!-- Modal Tolak Single Room dari Detail -->
                <div id="modalTolakSingleDetail" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
                    <div style="background: white; border-radius: 14px; width: 100%; max-width: 500px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
                        <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
                            <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #0f172a;">Tolak Ruangan: {{ $booking->room->name ?? 'Ruangan' }}</h3>
                            <button type="button" onclick="document.getElementById('modalTolakSingleDetail').style.display='none'" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #94a3b8;">&times;</button>
                        </div>
                        <form action="{{ route('admin.peminjaman.status', $booking) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="ditolak">
                            <div style="padding: 24px;">
                                <label style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 6px; color: #1e293b;">Alasan Penolakan untuk Pemohon: <span style="color: red;">*</span></label>
                                <textarea name="catatan" id="alasanTolakSingleDetail" rows="3" required placeholder="Contoh: Ruangan pada tanggal tersebut akan digunakan rapat dinas..." oninput="updateTolakPreview('SingleDetail')" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13.5px; resize: vertical; margin-bottom: 1rem;"></textarea>
                                
                                <div style="text-align: left; background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 10px; padding: 10px 12px; margin-bottom: 1rem;">
                                    <span style="font-size: 11px; font-weight: 800; color: #991b1b; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        Live Preview Pesan WhatsApp Penolakan:
                                    </span>
                                    <div id="previewTolakSingleDetail" style="font-size: 11.5px; color: #7f1d1d; background: #ffffff; padding: 8px 10px; border-radius: 6px; border: 1px solid #fee2e2; white-space: pre-wrap; max-height: 120px; overflow-y: auto; font-family: monospace; line-height: 1.45;">{{ str_replace('___ALASAN___', '(Ketik alasan di atas...)', $waSingleTolakBase) }}</div>
                                </div>

                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <button type="button" onclick="document.getElementById('modalTolakSingleDetail').style.display='none'" class="btn btn-outline">Batal</button>
                                    <button type="submit" onclick="return kirimWaDanTolak(this.form, 'SingleDetail', '{{ $cleanSinglePhone }}')" class="btn" style="background: #dc2626; color: white; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        <span>Kirim WhatsApp & Tolak</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    window.tolakBaseTemplates = window.tolakBaseTemplates || {};
                    window.tolakBaseTemplates['SingleDetail'] = @json($waSingleTolakBase);
                </script>

                {{-- Form Reschedule (tersembunyi) --}}
                <div id="rescheduleForm" style="display: none; margin-top: 1.5rem; background: #f8fafc; padding: 1.5rem; border-radius: 10px; border: 1px solid #e5e7eb;">
                    <h4 style="font-size: 0.95rem; margin-bottom: 1rem; color: #3730a3; font-weight: 700;">Minta Penjadwalan Ulang Ruangan Ini</h4>
                    <div style="margin-bottom: 1rem; font-size: 0.85rem; color: #666;">
                        <p><strong>Jadwal saat ini:</strong></p>
                        <p>Ruangan: {{ $booking->room->name ?? '-' }}</p>
                        <p>Tanggal: {{ $booking->tanggal->translatedFormat('l, d F Y') }}</p>
                        <p>Jam: {{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB</p>
                    </div>
                    <form action="{{ route('admin.peminjaman.reschedule', $booking) }}" method="POST">
                        @csrf
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #374151;">Alasan perubahan: <span style="color: red;">*</span></label>
                        <textarea name="alasan" id="alasanRescheduleDetail" rows="3" required placeholder="Jelaskan alasan penjadwalan ulang..." oninput="updateReschedulePreview()" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.9rem; resize: vertical; margin-bottom: 1rem;"></textarea>

                        <div style="text-align: left; background: #e0e7ff; border: 1.5px solid #c7d2fe; border-radius: 10px; padding: 10px 12px; margin-bottom: 1rem;">
                            <span style="font-size: 11px; font-weight: 800; color: #3730a3; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                Live Preview Pesan WhatsApp Penjadwalan Ulang:
                            </span>
                            <div id="previewRescheduleDetail" style="font-size: 11.5px; color: #312e81; background: #ffffff; padding: 8px 10px; border-radius: 6px; border: 1px solid #c7d2fe; white-space: pre-wrap; max-height: 120px; overflow-y: auto; font-family: monospace; line-height: 1.45;">{{ str_replace('___ALASAN___', '(Ketik alasan di atas...)', $waSingleRescheduleBase) }}</div>
                        </div>

                        <div style="display: flex; gap: 8px;">
                            <button type="submit" onclick="return kirimWaDanReschedule(this.form, '{{ $cleanSinglePhone }}')" style="padding: 8px 16px; background: #6366f1; color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                <span>Kirim WhatsApp & Jadwalkan Ulang</span>
                            </button>
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
        <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.2rem; color: #171717;">Riwayat Perubahan Status</h3>
        @foreach($booking->histories as $history)
            <div style="display: flex; gap: 12px; margin-bottom: 1rem; padding-bottom: 1rem; {{ !$loop->last ? 'border-bottom: 1px solid #f3f4f6;' : '' }}">
                <div style="width: 10px; height: 10px; border-radius: 50%; background: #08a6d9; margin-top: 5px; flex-shrink: 0;"></div>
                <div>
                    <p style="font-size: 0.9rem; font-weight: 600; color: #171717; margin-bottom: 2px;">
                        {{ $history->status_sebelumnya ? ucfirst(str_replace('_', ' ', $history->status_sebelumnya)) : 'Pengajuan Baru' }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin: 0 2px;"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg> {{ ucfirst(str_replace('_', ' ', $history->status_baru)) }}
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

    <script>
        window.tolakBaseTemplates = window.tolakBaseTemplates || {};
        window.rescheduleBaseTemplate = @json($waSingleRescheduleBase ?? '');

        window.updateTolakPreview = function(id) {
            const input = document.getElementById('alasanTolak' + id);
            const preview = document.getElementById('previewTolak' + id);
            if (!input || !preview || !window.tolakBaseTemplates || !window.tolakBaseTemplates[id]) return;
            const val = input.value.trim() || '(Ketik alasan di atas...)';
            preview.textContent = window.tolakBaseTemplates[id].replace('___ALASAN___', val);
        };

        window.updateReschedulePreview = function() {
            const input = document.getElementById('alasanRescheduleDetail');
            const preview = document.getElementById('previewRescheduleDetail');
            if (!input || !preview || !window.rescheduleBaseTemplate) return;
            const val = input.value.trim() || '(Ketik alasan di atas...)';
            preview.textContent = window.rescheduleBaseTemplate.replace('___ALASAN___', val);
        };

        window.kirimWaDanSetuju = function(form, waUrl) {
            if (!form.checkValidity()) {
                form.reportValidity();
                return false;
            }
            if (waUrl && waUrl !== '#') {
                window.open(waUrl, '_blank');
            }
            return true;
        };

        window.kirimWaDanTolak = function(form, id, phone) {
            if (!form.checkValidity()) {
                form.reportValidity();
                return false;
            }
            const input = document.getElementById('alasanTolak' + id);
            const val = input ? input.value.trim() : '';
            const base = (window.tolakBaseTemplates && window.tolakBaseTemplates[id]) ? window.tolakBaseTemplates[id] : '';
            const msg = base.replace('___ALASAN___', val);
            const waUrl = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(msg);
            window.open(waUrl, '_blank');
            return true;
        };

        window.kirimWaDanReschedule = function(form, phone) {
            if (!form.checkValidity()) {
                form.reportValidity();
                return false;
            }
            const input = document.getElementById('alasanRescheduleDetail');
            const val = input ? input.value.trim() : '';
            const base = window.rescheduleBaseTemplate || '';
            const msg = base.replace('___ALASAN___', val);
            const waUrl = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(msg);
            window.open(waUrl, '_blank');
            return true;
        };
    </script>
@endsection
