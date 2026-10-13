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

        <!-- Card Notifikasi Otomatis -->
        <div class="card" style="margin-top: 1.5rem;">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h3 class="card-title">Integrasi Notifikasi Otomatis (WhatsApp & Gmail)</h3>
                <span style="font-size: 0.75rem; background: #dbeafe; color: #1e40af; padding: 4px 10px; border-radius: 20px; font-weight: 600;">Otomatisasi Aktif</span>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #166534; line-height: 1.5;">
                    💡 <strong>Cara Kerja Notifikasi Otomatis:</strong>
                    <ul style="margin: 0.5rem 0 0 1.25rem; padding: 0;">
                        <li><strong>WhatsApp:</strong> Menggunakan layanan gateway <a href="https://fonnte.com" target="_blank" style="color: #059669; font-weight: 600; text-decoration: underline;">Fonnte (fonnte.com)</a>. Cukup daftarkan nomor WA pengirim di Fonnte, lalu tempelkan <em>API Token</em> di bawah ini.</li>
                        <li><strong>Gmail:</strong> Notifikasi email dikirimkan otomatis menggunakan akun SMTP Gmail yang dikonfigurasi pada berkas <code>.env</code>.</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="form-label">WhatsApp Gateway API Token (Fonnte Token)</label>
                    <input type="text" name="wa_gateway_token" class="form-control" value="{{ $settings['wa_gateway_token'] ?? '' }}" placeholder="Contoh: aBcDeFgHiJkLmNoPqRsTuVwXyZ123456">
                    <p class="form-help">Dapatkan token dari dashboard <a href="https://fonnte.com" target="_blank" style="color: #08a6d9;">fonnte.com</a> setelah menghubungkan perangkat WhatsApp.</p>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Nomor WhatsApp Admin (Penerima Notifikasi)</label>
                        <input type="text" name="wa_admin_phone" class="form-control" value="{{ $settings['wa_admin_phone'] ?? '' }}" placeholder="Contoh: 081234567890">
                        <p class="form-help">Nomor WA petugas yang akan menerima notif instan setiap ada peminjaman baru masuk.</p>
                    </div>

                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Email Admin (Penerima Notifikasi)</label>
                        <input type="email" name="email_admin_notification" class="form-control" value="{{ $settings['email_admin_notification'] ?? 'admin@bakorwil3.go.id' }}" placeholder="admin@bakorwil3.go.id">
                        <p class="form-help">Email petugas yang akan menerima rincian permohonan baru untuk diverifikasi.</p>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection
