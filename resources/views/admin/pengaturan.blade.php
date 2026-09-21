@extends('layouts.admin')

@section('title', 'Pengaturan - Admin SIPERON')

@section('content')
    <div class="page-header-row">
        <div>
            <div class="page-title">Pengaturan Sistem</div>
            <p class="page-subtitle">Konfigurasi umum aplikasi SIPERON Bakorwil III Malang</p>
        </div>
        <button class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" /></svg>
            Simpan Perubahan
        </button>
    </div>

    <div class="settings-grid">
        <!-- Sidebar Settings Nav -->
        <div class="settings-nav">
            <div class="card">
                <div class="settings-menu">
                    <button class="settings-menu-item active">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" /></svg>
                        Informasi Instansi
                    </button>
                    <button class="settings-menu-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
                        Notifikasi Email
                    </button>
                    <button class="settings-menu-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                        Keamanan
                    </button>
                    <button class="settings-menu-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                        Tampilan & Logo
                    </button>
                </div>
            </div>
        </div>

        <!-- Settings Form Area -->
        <div class="settings-content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Instansi</h3>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    
                    <div class="form-group">
                        <label class="form-label">Nama Aplikasi</label>
                        <input type="text" class="form-control" value="SIPERON - Sistem Informasi Peminjaman Ruangan">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Instansi</label>
                        <input type="text" class="form-control" value="Badan Koordinasi Wilayah Pemerintahan dan Pembangunan (Bakorwil) III Malang">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" rows="3">Jl. Simpang Ijen No.2, Oro-oro Dowo, Kec. Klojen, Kota Malang, Jawa Timur 65119</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Nomor Telepon / WhatsApp</label>
                            <input type="text" class="form-control" value="(0341) 362222">
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label">Email Resmi</label>
                            <input type="email" class="form-control" value="bakorwil3@jatimprov.go.id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Aturan Peminjaman Default</label>
                        <textarea class="form-control" rows="4">1. Peminjaman harus diajukan minimal H-3 sebelum pelaksanaan acara.
2. Dilarang membawa senjata tajam atau barang berbahaya lainnya.
3. Kebersihan ruangan menjadi tanggung jawab peminjam.
4. Segala bentuk kerusakan fasilitas ruangan yang diakibatkan oleh kelalaian peminjam akan dikenakan sanksi ganti rugi.</textarea>
                        <p class="form-help">Aturan ini akan ditampilkan pada saat pengguna (user) akan mengajukan form peminjaman ruangan baru.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
