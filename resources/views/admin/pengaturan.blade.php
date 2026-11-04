@extends('layouts.admin')

@section('title', 'Pengaturan - Admin SIPERON')

@section('content')
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.pengaturan.update') }}" method="POST">
        @csrf
        
        <div class="page-header-row">
            <div>
                <div class="page-title">Pengaturan Sistem</div>
                <p class="page-subtitle">Konfigurasi umum aplikasi SIPERON Bakorwil III Malang</p>
            </div>
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" /></svg>
                Simpan Perubahan
            </button>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Instansi</h3>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                
                <div class="form-group">
                    <label class="form-label">Nama Aplikasi</label>
                    <input type="text" name="app_name" class="form-control" value="{{ $settings['app_name'] ?? 'SIPERON - Sistem Informasi Peminjaman Ruangan' }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Instansi</label>
                    <input type="text" name="agency_name" class="form-control" value="{{ $settings['agency_name'] ?? 'Badan Koordinasi Wilayah Pemerintahan dan Pembangunan (Bakorwil) III Malang' }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="agency_address" class="form-control" rows="3">{{ $settings['agency_address'] ?? 'Jl. Simpang Ijen No.2, Oro-oro Dowo, Kec. Klojen, Kota Malang, Jawa Timur 65119' }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="agency_phone" class="form-control" value="{{ $settings['agency_phone'] ?? '(0341) 362222' }}">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Email Resmi</label>
                        <input type="email" name="agency_email" class="form-control" value="{{ $settings['agency_email'] ?? 'bakorwil3@jatimprov.go.id' }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Aturan Peminjaman Default</label>
                    <textarea name="default_rules" class="form-control" rows="4">{{ $settings['default_rules'] ?? "1. Peminjaman harus diajukan minimal H-3 sebelum pelaksanaan acara.\n2. Dilarang membawa senjata tajam atau barang berbahaya lainnya.\n3. Kebersihan ruangan menjadi tanggung jawab peminjam.\n4. Segala bentuk kerusakan fasilitas ruangan yang diakibatkan oleh kelalaian peminjam akan dikenakan sanksi ganti rugi." }}</textarea>
                    <p class="form-help">Aturan ini akan ditampilkan pada saat pengguna (user) akan mengajukan form peminjaman ruangan baru.</p>
                </div>

            </div>
        </div>

        <!-- Card Notifikasi Otomatis & WhatsApp Template -->
        <div class="card" style="margin-top: 1.5rem;">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h3 class="card-title">Integrasi Notifikasi & Template WhatsApp</h3>
                <span style="font-size: 0.75rem; background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 20px; font-weight: 700;">Gratis & Siap Pakai</span>
            </div>
            <div class="card-body" style="padding: 1.5rem;">

                {{-- Banner Informasi Mode Template Gratis --}}
                <div style="display: flex; align-items: flex-start; gap: 14px; background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 10px; padding: 14px 18px; margin-bottom: 1.5rem;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #22c55e; color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div style="font-size: 0.88rem; color: #166534; line-height: 1.6;">
                        <strong style="font-size: 0.95rem; display: block; margin-bottom: 2px; color: #14532d;">Konfirmasi WhatsApp Mode Manual Ber-template (100% Gratis):</strong>
                        Saat admin menyetujui, menolak, atau meminta jadwal ulang (baik satu ruangan maupun seluruh paket), sistem otomatis memformat isi pesan resmi lengkap (nama pemohon, nama instansi, ruangan, tanggal, jam, kegiatan, alasan, dan link cek status).
                        Admin cukup klik tombol <strong>"Buka WhatsApp Sekarang"</strong> di notifikasi popup atau tabel — aplikasi WhatsApp Web/Desktop akan langsung terbuka dengan pesan yang sudah terisi rapi, tinggal tekan kirim tanpa perlu berlangganan API berbayar.
                    </div>
                </div>

                <!-- Status Perangkat WhatsApp Fonnte (Opsional) -->
                @if(isset($waStatus))
                    @if($waStatus['connected'])
                        <div style="display: flex; align-items: center; gap: 12px; background: #ecfdf5; border: 1px solid #6ee7b7; border-radius: 8px; padding: 12px 16px; margin-bottom: 1.5rem; color: #065f46;">
                            <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background: #22c55e;"></span>
                            <div>
                                <strong style="font-size: 0.95rem;">WhatsApp Gateway Fonnte Terhubung (Opsional)</strong>
                                <div style="font-size: 0.85rem; color: #047857; margin-top: 2px;">
                                    Device: <strong>{{ $waStatus['device'] ?? '-' }}</strong> ({{ $waStatus['name'] ?? 'Akun' }}) | Sisa Kuota: <strong>{{ $waStatus['quota'] ?? 0 }}</strong> pesan.
                                </div>
                            </div>
                        </div>
                    @elseif($waStatus['status'] === 'disconnect')
                        <div style="display: flex; align-items: flex-start; gap: 12px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 14px 16px; margin-bottom: 1.5rem; color: #92400e;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#b45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            <div>
                                <strong style="font-size: 0.95rem; color: #b45309;">Perangkat Fonnte Belum Terhubung (Status: Disconnected)</strong>
                                <p style="font-size: 0.85rem; margin: 4px 0 8px 0; color: #78350f;">
                                    Token Fonnte terdeteksi untuk nomor <strong>{{ $waStatus['device'] ?? '-' }}</strong> namun statusnya saat ini Disconnected. (Ini tidak menghambat sistem karena Anda dapat memakai mode template manual gratis di atas).
                                </p>
                                <a href="https://fonnte.com" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; background: #f59e0b; color: #ffffff; padding: 6px 14px; border-radius: 6px; font-size: 0.82rem; font-weight: 600; text-decoration: none;">
                                    Scan QR di Fonnte &rarr;
                                </a>
                            </div>
                        </div>
                    @elseif($waStatus['status'] === 'no_token')
                        <div style="display: flex; align-items: center; gap: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 16px; margin-bottom: 1.5rem; color: #475569;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            <div style="font-size: 0.85rem;">
                                Token WhatsApp Gateway (Fonnte) tidak diisi. Sistem tetap berjalan 100% menggunakan <strong>Template WhatsApp Manual Gratis</strong>.
                            </div>
                        </div>
                    @else
                        <div style="display: flex; align-items: center; gap: 12px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 12px 16px; margin-bottom: 1.5rem; color: #991b1b;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#991b1b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <div style="font-size: 0.85rem;">
                                <strong>Status Gateway:</strong> {{ $waStatus['message'] ?? 'Gagal memeriksa koneksi' }} (Konfirmasi manual tetap aktif normal).
                            </div>
                        </div>
                    @endif
                @endif

                <div class="form-group">
                    <label class="form-label">WhatsApp Gateway API Token (Fonnte Token - Opsional)</label>
                    <input type="text" name="wa_gateway_token" class="form-control" value="{{ $settings['wa_gateway_token'] ?? '' }}" placeholder="Opsional: aBcDeFgHiJkLmNoPqRsTuVwXyZ123456">
                    <p class="form-help">Kosongkan jika tidak menggunakan Fonnte berbayar. Pengiriman konfirmasi tetap berjalan lancar melalui template WhatsApp resmi 1-klik.</p>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Nomor WhatsApp Admin (Penerima Notifikasi)</label>
                        <input type="text" name="wa_admin_phone" class="form-control" value="{{ $settings['wa_admin_phone'] ?? '' }}" placeholder="Contoh: 081234567890">
                    </div>

                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Email Admin (Penerima Notifikasi)</label>
                        <input type="email" name="email_admin_notification" class="form-control" value="{{ $settings['email_admin_notification'] ?? config('mail.from.address', 'admin@bakorwil3.go.id') }}" placeholder="Contoh: namaadmin@gmail.com">
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection
