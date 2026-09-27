@extends('layouts.auth')

@section('title', 'Login - SIPERON')
@section('subtitle', 'Silakan masuk ke akun Anda')

@section('content')
<form class="auth-form" action="{{ url('/admin/dashboard') }}" method="GET">
    <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" placeholder="Masukkan alamat email" required>
    </div>
    
    <div class="form-group">
        <label class="form-label" style="display: flex; justify-content: space-between;">
            Password
            <a href="#" class="auth-link" style="font-size: 0.8rem; font-weight: 500;">Lupa Password?</a>
        </label>
        <input type="password" class="form-control" placeholder="Masukkan password" required>
    </div>
    
    <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
        <input type="checkbox" id="remember" style="accent-color: var(--bakorwil-cyan); width: 16px; height: 16px;">
        <label for="remember" style="font-size: 0.85rem; color: var(--text-muted); cursor: pointer;">Ingat Saya</label>
    </div>
    
    <button type="submit" class="auth-button">Masuk</button>
</form>

<div class="auth-divider">ATAU</div>

<div class="auth-footer">
    Belum punya akun? <a href="{{ url('/register') }}" class="auth-link">Daftar Sekarang</a>
</div>
@endsection
