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
@endsection
