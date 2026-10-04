<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'SIPERON - Sistem Peminjaman Ruangan Online')
    </title>

    <meta name="description"
          content="Sistem Peminjaman Ruangan Online Bakorwil III Malang">

    {{-- Satu-satunya sumber CSS: resources/css/style.css --}}
    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>

<body>
    {{-- HEADER --}}
    <header class="site-header">

        <div class="top-header">
            <div class="container top-header-content" style="display: flex; align-items: center; justify-content: space-between;">

                <div class="social-links" style="flex: 1;">
                    <a href="#" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                    </a>
                    <a href="#" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" aria-label="Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" aria-label="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    <a href="#" aria-label="TikTok">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                    </a>
                </div>

                <div class="brand-area" style="flex: 1; display: flex; justify-content: center; padding: 0;">
                    <a href="{{ route('home') }}" class="navbar-brand">
                        <img src="{{ asset('images/logo-bakorwil.png') }}"
                             alt="Logo Bakorwil III Malang"
                             class="logo" style="height: 72px; width: auto;">
                    </a>
                </div>

                <div class="header-info" style="flex: 1; justify-content: flex-end; display: flex;">
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -2px; margin-right: 4px;"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>LPSE
                    </a>
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -2px; margin-right: 4px;"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>Informasi Berita
                    </a>
                </div>

            </div>
        </div>

        {{-- NAVBAR --}}
        <nav class="main-nav">
            <div class="container nav-container">

                <a href="{{ url('/') }}" class="nav-link active">
                    BERANDA
                </a>

                <a href="{{ url('/') }}#tentang" class="nav-link">
                    TENTANG
                </a>

                <a href="{{ url('/') }}#alur" class="nav-link">
                    ALUR PEMINJAMAN
                </a>

                <a href="{{ url('/') }}#ruangan" class="nav-link">
                    RUANGAN
                </a>

                <a href="{{ url('/') }}#jadwal" class="nav-link">
                    JADWAL
                </a>

                <a href="{{ url('/') }}#kontak" class="nav-link">
                    KONTAK
                </a>

                <a href="{{ url('/') }}#booking" class="nav-link">
                    AJUKAN PEMINJAMAN
                </a>

                @guest
                    <a href="{{ route('login') }}" class="nav-link" style="margin-left: auto;">
                        LOGIN
                    </a>
                    <a href="{{ route('register') }}" class="nav-link">
                        REGISTER
                    </a>
                @else
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            ADMIN PANEL
                        </a>
                    @else
                        <a href="{{ route('user.riwayat') }}" class="nav-link">
                            RIWAYAT PEMINJAMAN
                        </a>
                    @endif
                    
                    <div class="user-dropdown-container" style="margin-left: auto; position: relative; padding: 10px 0;">
                        <div style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                            <div style="text-align: right; line-height: 1.2;">
                                <span style="display: block; font-weight: bold; color: #171717; font-size: 14px;">{{ Auth::user()->name }}</span>
                                <span style="display: block; font-size: 12px; color: #666;">{{ Auth::user()->role == 'admin' ? 'Administrator' : 'Pengguna' }}</span>
                            </div>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=08a6d9&color=fff" alt="User Avatar" style="width: 42px; height: 42px; border-radius: 50%;">
                        </div>
                        
                        <div class="user-dropdown-menu">
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest

            </div>
        </nav>

    </header>


    {{-- CONTENT --}}
    <main>
        @yield('content')
    </main>


    {{-- FOOTER --}}
    <footer class="site-footer" id="kontak">

        <div class="container footer-grid">

            <div class="footer-column">
                <h3>SIPERON</h3>

                <p>
                    Sistem Peminjaman Ruangan Online
                    Bakorwil III Malang.
                </p>

                <p>
                    Memudahkan proses pengajuan,
                    pemeriksaan jadwal, dan pengelolaan
                    peminjaman ruangan secara digital.
                </p>
            </div>


            <div class="footer-column">

                <h3>Informasi</h3>

                <a href="#tentang">Tentang SIPERON</a>
                <a href="#alur">Alur Peminjaman</a>
                <a href="#ruangan">Daftar Ruangan</a>
                <a href="#jadwal">Jadwal Ruangan</a>

            </div>


            <div class="footer-column">

                <h3>Kontak</h3>

                <p>
                    {!! nl2br(e($settings['agency_address'] ?? "Jl. Simpang Ijen No. 2\nKota Malang, Jawa Timur")) !!}
                </p>

                <p>
                    Telepon: {{ $settings['agency_phone'] ?? '(0341) 362222' }}
                </p>

                <p>
                    Email: {{ $settings['agency_email'] ?? 'bakorwil3@jatimprov.go.id' }}
                </p>

            </div>


            <div class="footer-column">

                <h3>{{ $settings['agency_name'] ?? 'Bakorwil III Malang' }}</h3>

                <p>
                    Pemerintah Provinsi Jawa Timur
                </p>

                <div class="footer-social">
                    <a href="#">Instagram</a>
                    <a href="#">Facebook</a>
                    <a href="#">YouTube</a>
                </div>

            </div>

        </div>


        <div class="footer-bottom">

            <div class="container">

                <p>
                    © {{ date('Y') }} SIPERON Bakorwil III Malang.
                    Semua hak dilindungi.
                </p>

            </div>

        </div>

    </footer>

    @yield('scripts')
</body>
</html>