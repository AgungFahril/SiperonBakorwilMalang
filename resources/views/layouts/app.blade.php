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
            <div class="container top-header-content">

                <div class="social-links">
                    <a href="#" aria-label="Instagram">◎</a>
                    <a href="#" aria-label="Facebook">f</a>
                    <a href="#" aria-label="Twitter">𝕏</a>
                    <a href="#" aria-label="YouTube">▶</a>
                    <a href="#" aria-label="TikTok">♪</a>
                </div>

                <div class="header-info">
                    <a href="#">▣ LPSE</a>
                    <a href="#">◔ Informasi Berita</a>
                </div>

            </div>
        </div>

        <div class="brand-area">
            <div class="container brand-container">

                <a href="{{ route('home') }}" class="navbar-brand">
                    <img src="{{ asset('images/logo-bakorwil.png') }}"
                         alt="Logo Bakorwil III Malang"
                         class="logo">
                </a>

            </div>
        </div>

        {{-- NAVBAR --}}
        <nav class="main-nav">
            <div class="container nav-container">

                <a href="{{ url('/') }}" class="nav-link active">
                    BERANDA
                </a>

                <a href="#tentang" class="nav-link">
                    TENTANG
                </a>

                <a href="#alur" class="nav-link">
                    ALUR PEMINJAMAN
                </a>

                <a href="#ruangan" class="nav-link">
                    RUANGAN
                </a>

                <a href="#jadwal" class="nav-link">
                    JADWAL
                </a>

                <a href="#kontak" class="nav-link">
                    KONTAK
                </a>

                <a href="#booking" class="nav-button">
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
                    <div style="margin-left: auto; display: flex; align-items: center; gap: 1rem;">
                        <span style="color: var(--text-heading); font-weight: 500;">
                            Hai, {{ Auth::user()->name }}
                        </span>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="nav-link" style="background: var(--bakorwil-cyan); color: white; padding: 0.5rem 1rem; border-radius: 4px;">
                                Admin Panel
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 600; cursor: pointer; padding: 0.5rem;">
                                LOGOUT
                            </button>
                        </form>
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
                    Jl. Simpang Ijen No. 2<br>
                    Kota Malang, Jawa Timur
                </p>

                <p>
                    Telepon: (0341) XXXXXXX
                </p>

                <p>
                    Email: bakorwilmalang@jatimprov.go.id
                </p>

            </div>


            <div class="footer-column">

                <h3>Bakorwil III Malang</h3>

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

</body>
</html>