@extends('layouts.auth')

@section('title', 'Daftar - SIPERON')
@section('subtitle', 'Buat akun baru untuk mengakses sistem')

@section('content')
<form class="auth-form" action="{{ url('/login') }}" method="GET">
    <div class="form-group">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" placeholder="Masukkan nama lengkap Anda" required>
    </div>
    
    <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" placeholder="Masukkan alamat email" required>
    </div>
    
    <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" placeholder="Buat password (min. 8 karakter)" required>
    </div>
    
    <div class="form-group">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" class="form-control" placeholder="Ulangi password" required>
    </div>
    
    <div class="form-group" style="display: flex; align-items: flex-start; gap: 0.5rem;">
        <input type="checkbox" id="terms" required style="accent-color: var(--bakorwil-cyan); width: 16px; height: 16px; margin-top: 3px;">
        <label for="terms" style="font-size: 0.85rem; color: var(--text-muted); cursor: pointer; line-height: 1.4;">
            Saya setuju dengan <a href="#" class="auth-link">Syarat & Ketentuan</a> serta <a href="#" class="auth-link">Kebijakan Privasi</a>
        </label>
    </div>
    
    <button type="submit" class="auth-button">Daftar Akun</button>
</form>

<div class="auth-divider">SUDAH PUNYA AKUN?</div>

<div class="auth-footer" style="margin-top: 0;">
    <a href="{{ url('/login') }}" class="auth-link">Masuk ke Akun Anda</a>
</div>
@endsection
