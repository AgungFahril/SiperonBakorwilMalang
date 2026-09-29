@extends('layouts.auth')

@section('title', 'Daftar - SIPERON')
@section('subtitle', 'Buat akun baru untuk mengakses sistem')

@section('content')
<form class="auth-form" action="{{ route('register.post') }}" method="POST">
    @csrf

    @if ($errors->any())
        <div style="background: #fee2e2; color: #ef4444; padding: 0.75rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.85rem;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required>
    </div>
    
    <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Masukkan alamat email" value="{{ old('email') }}" required>
    </div>
    
    <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Buat password (min. 8 karakter)" required>
    </div>
    
    <div class="form-group">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
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
