<!-- Top Loading Progress Bar (NProgress style) -->
<div id="siperonLoadingBar" class="siperon-loading-bar" aria-hidden="true"></div>

<!-- Global Loading Overlay -->
<div id="siperonLoadingOverlay" class="siperon-loading-overlay" aria-hidden="true">
    <div class="siperon-loading-card">
        <div class="siperon-spinner-wrapper">
            <div class="siperon-spinner-outer"></div>
            <div class="siperon-spinner-inner"></div>
            <div class="siperon-spinner-logo-box">
                <img src="{{ asset('images/logo_bakorwil.png') }}" alt="Logo SIPERON" class="siperon-spinner-logo">
            </div>
        </div>
        <div class="siperon-loading-brand">SIPERON BAKORWIL</div>
        <div class="siperon-loading-status">
            <span class="siperon-status-msg">Memuat halaman</span>
            <span class="siperon-loading-dots">
                <span class="s-dot s-d1">.</span>
                <span class="s-dot s-d2">.</span>
                <span class="s-dot s-d3">.</span>
            </span>
        </div>
        <div class="siperon-loading-tip">Mohon tunggu sebentar...</div>
    </div>
</div>

<style>
/* ==================== SIPERON GLOBAL LOADING ANIMATION ==================== */
.siperon-loading-bar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 3.5px;
    background: linear-gradient(90deg, #0284c7, #08a6d9, #38bdf8);
    box-shadow: 0 0 12px rgba(8, 166, 217, 0.85), 0 0 4px rgba(2, 132, 199, 0.6);
    z-index: 9999999;
    transform: scaleX(0);
    transform-origin: left;
    opacity: 0;
    pointer-events: none;
    transition: transform 0.2s ease, opacity 0.2s ease;
}

.siperon-loading-bar.active {
    opacity: 1;
    transform: scaleX(0.78);
    transition: transform 3.5s cubic-bezier(0.1, 0.85, 0.2, 1), opacity 0.15s ease;
}

.siperon-loading-bar.finish {
    opacity: 1;
    transform: scaleX(1);
    transition: transform 0.18s ease-out, opacity 0.3s ease 0.18s;
}

.siperon-loading-overlay {
    position: fixed;
    inset: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(248, 250, 252, 0.78);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    z-index: 9999990;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.22s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.22s;
}

.siperon-loading-overlay.active {
    opacity: 1;
    visibility: visible;
    pointer-events: all;
}

.siperon-loading-card {
    background: #ffffff;
    border: 1px solid rgba(226, 232, 240, 0.9);
    border-radius: 20px;
    padding: 1.85rem 2.25rem;
    box-shadow: 0 20px 40px -12px rgba(15, 23, 42, 0.16), 0 0 0 1px rgba(8, 166, 217, 0.08);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    min-width: 250px;
    max-width: 320px;
    transform: scale(0.92);
    transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.siperon-loading-overlay.active .siperon-loading-card {
    transform: scale(1);
}

.siperon-spinner-wrapper {
    position: relative;
    width: 72px;
    height: 72px;
    margin-bottom: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.siperon-spinner-outer {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 3.5px solid #e2e8f0;
    border-top-color: #08a6d9;
    border-right-color: #0284c7;
    animation: siperonSpin 0.9s linear infinite;
}

.siperon-spinner-inner {
    position: absolute;
    inset: 6px;
    border-radius: 50%;
    border: 2.5px solid transparent;
    border-bottom-color: #38bdf8;
    border-left-color: #0ea5e9;
    animation: siperonSpinReverse 1.25s linear infinite;
}

.siperon-spinner-logo-box {
    position: relative;
    z-index: 2;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    animation: siperonPulse 1.8s ease-in-out infinite;
}

.siperon-spinner-logo {
    width: 26px;
    height: auto;
    object-fit: contain;
}

.siperon-loading-brand {
    font-size: 0.76rem;
    font-weight: 800;
    color: #08a6d9;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    margin-bottom: 5px;
}

.siperon-loading-status {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2px;
}

.siperon-loading-dots .s-dot {
    animation: siperonDot 1.4s infinite;
    opacity: 0;
    font-weight: 800;
}
.siperon-loading-dots .s-d1 { animation-delay: 0.2s; }
.siperon-loading-dots .s-d2 { animation-delay: 0.4s; }
.siperon-loading-dots .s-d3 { animation-delay: 0.6s; }

.siperon-loading-tip {
    font-size: 0.76rem;
    color: #64748b;
    margin-top: 6px;
    font-weight: 500;
}

@keyframes siperonSpin {
    to { transform: rotate(360deg); }
}

@keyframes siperonSpinReverse {
    to { transform: rotate(-360deg); }
}

@keyframes siperonPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.08); }
}

@keyframes siperonDot {
    0%, 100% { opacity: 0; }
    50% { opacity: 1; }
}
</style>

<script>
(function() {
    let loaderTimeout = null;

    window.SIPERON_LOADER = {
        show: function(msg) {
            clearTimeout(loaderTimeout);
            const overlay = document.getElementById('siperonLoadingOverlay');
            const bar = document.getElementById('siperonLoadingBar');
            const statusMsg = document.querySelector('.siperon-status-msg');

            if (statusMsg && msg) {
                statusMsg.textContent = msg;
            } else if (statusMsg) {
                statusMsg.textContent = 'Memuat halaman';
            }

            if (bar) {
                bar.classList.remove('finish');
                bar.classList.add('active');
            }
            if (overlay) {
                overlay.classList.add('active');
            }

            // Batas pengaman otomatis: 12 detik agar tidak pernah stuck jika koneksi terputus
            loaderTimeout = setTimeout(function() {
                window.SIPERON_LOADER.hide();
            }, 12000);
        },

        hide: function() {
            clearTimeout(loaderTimeout);
            const overlay = document.getElementById('siperonLoadingOverlay');
            const bar = document.getElementById('siperonLoadingBar');

            if (bar) {
                bar.classList.remove('active');
                bar.classList.add('finish');
                setTimeout(() => {
                    bar.classList.remove('finish');
                }, 400);
            }
            if (overlay) {
                overlay.classList.remove('active');
            }
        }
    };

    // Pastikan loader selalu sembunyi jika halaman dibuka dari cache browser (tombol back/forward)
    window.addEventListener('pageshow', function() {
        window.SIPERON_LOADER.hide();
    });

    // Pasang listener klik link global untuk memicu animasi seketika
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link) return;

        const href = link.getAttribute('href');
        if (!href) return;

        // Abaikan link khusus (anchor hash, tel, mailto, javascript, download, target blank/WhatsApp)
        if (href === '#' || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
        if (link.hasAttribute('download')) return;
        if (link.getAttribute('target') === '_blank' || link.getAttribute('target') === 'WhatsAppWeb') return;
        if (href.includes('whatsapp.com') || href.includes('wa.me')) return;
        if (link.hasAttribute('data-modal-target') || link.hasAttribute('data-modal-close')) return;

        try {
            const targetUrl = new URL(link.href, window.location.origin);
            if (targetUrl.origin !== window.location.origin) return; // Link eksternal

            // Abaikan jika klik link yang persis halaman saat ini
            if (targetUrl.pathname === window.location.pathname && targetUrl.search === window.location.search && !targetUrl.hash) {
                return;
            }

            // Jika di admin dan ada fungsi SPA adminNavigateTo, gunakan SPA
            if (typeof window.adminNavigateTo === 'function' && targetUrl.pathname.startsWith('/admin')) {
                e.preventDefault();
                window.adminNavigateTo(link.href);
                return;
            }
        } catch(err) {
            // Abaikan jika parsing URL gagal
        }

        // Tampilkan animasi loading seketika untuk navigasi halaman penuh
        window.SIPERON_LOADER.show('Memuat halaman');
    }, true);

    // Tampilkan animasi loading saat submit form (filter, form tambah, ubah status)
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (!form || form.getAttribute('target') === '_blank' || form.getAttribute('target') === 'WhatsAppWeb') return;

        setTimeout(() => {
            if (!e.defaultPrevented) {
                window.SIPERON_LOADER.show('Memproses data');
            }
        }, 10);
    });

    // Tangani navigasi riwayat browser
    window.addEventListener('popstate', function() {
        window.SIPERON_LOADER.show('Memuat halaman');
    });
})();
</script>

