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
        <label class="form-label">Kata Sandi</label>
        <div style="position: relative;">
            <input type="password" id="password" name="password" class="form-control" placeholder="Buat kata sandi (min. 8 karakter)" required style="padding-right: 40px;">
            <button type="button" onclick="togglePassword('password', 'eye-icon-1', 'eye-slash-icon-1')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280; padding: 0;">
                <svg id="eye-icon-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <svg id="eye-slash-icon-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px; display: none;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
            </button>
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label">Konfirmasi Kata Sandi</label>
        <div style="position: relative;">
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required style="padding-right: 40px;">
            <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-2', 'eye-slash-icon-2')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280; padding: 0;">
                <svg id="eye-icon-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <svg id="eye-slash-icon-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px; display: none;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
            </button>
        </div>
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

<script>
function togglePassword(inputId, eyeIconId, eyeSlashIconId) {
    const passwordInput = document.getElementById(inputId);
    const eyeIcon = document.getElementById(eyeIconId);
    const eyeSlashIcon = document.getElementById(eyeSlashIconId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.style.display = 'none';
        eyeSlashIcon.style.display = 'block';
    } else {
        passwordInput.type = 'password';
        eyeIcon.style.display = 'block';
        eyeSlashIcon.style.display = 'none';
    }
}
</script>
@endsection
