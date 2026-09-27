{{-- resources/views/partials/navbar.blade.php --}}

<div class="topbar">
    <div class="container topbar-inner">
        <div class="topbar-social">
            <a href="#" aria-label="Instagram">📷</a>
            <a href="#" aria-label="Facebook">f</a>
            <a href="#" aria-label="Twitter/X">𝕏</a>
            <a href="#" aria-label="YouTube">▶</a>
            <a href="#" aria-label="TikTok">🎵</a>
        </div>
        <div class="topbar-links">
            <a href="#">⬛ LPSE</a>
            <a href="#">🕒 Informasi Berita</a>
        </div>
    </div>
</div>

<header class="site-header">
    <div class="container brand-row">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ asset('images/logo-bakorwil.png') }}" alt="Logo Bakorwil III Malang" class="logo">
            <div class="brand-text">
                <span class="brand-title">
                    BAKORWIL
                    <span class="highlight">III MALANG</span>
                    PROV JATIM
                </span>
            </div>
        </a>
    </div>

    <nav class="navbar container">
        <ul class="nav-menu">
            <li><a href="{{ route('home') }}" class="active">BERANDA</a></li>
            <li><a href="#tentang">TENTANG</a></li>
            <li><a href="#alur">ALUR PEMINJAMAN</a></li>
            <li><a href="#ruangan">RUANGAN</a></li>
            <li><a href="#jadwal">JADWAL</a></li>
            <li><a href="#kontak">KONTAK</a></li>
        </ul>
        <a href="#ruangan" class="btn btn-primary nav-cta">AJUKAN PEMINJAMAN</a>
    </nav>
</header>
