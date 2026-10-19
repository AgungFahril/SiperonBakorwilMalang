@extends('layouts.app')

@section('title', 'Ketersediaan Ruangan - SIPERON Bakorwil III Malang')

@section('content')

<!-- Banner Header Halaman -->
<section class="ketersediaan-hero">
    <div class="container">
        <div class="ketersediaan-hero-badge">JADWAL & KETERSEDIAAN</div>
        <h1 class="ketersediaan-hero-title">Cek Ketersediaan Ruangan</h1>
        <p class="ketersediaan-hero-subtitle">
            Pilih tanggal di sebelah kiri untuk melihat ruangan yang tersedia maupun yang sedang terbooking di Bakorwil III Malang.
        </p>
    </div>
</section>

<!-- Konten Utama 2 Kolom -->
<section class="ketersediaan-section">
    <div class="container" id="ketersediaan-container">
        @include('partials.ketersediaan-content')
    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('ketersediaan-container');

    // Fungsi fetch data via AJAX
    function loadKetersediaan(params) {
        // Tampilkan indikator loading halus
        const mainCard = container.querySelector('.main-card');
        if (mainCard) {
            mainCard.style.opacity = '0.5';
            mainCard.style.pointerEvents = 'none';
        }

        const url = new URL('{{ route('ketersediaan') }}', window.location.origin);
        Object.keys(params).forEach(key => url.searchParams.set(key, params[key]));

        // Update URL di browser history
        window.history.pushState({}, '', url);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.text())
        .then(html => {
            container.innerHTML = html;
            initEventHandlers();
        })
        .catch(err => {
            console.error('Error loading ketersediaan:', err);
            // Fallback reload biasa jika AJAX gagal
            window.location.href = url;
        });
    }

    function initEventHandlers() {
        // 1. Input date change
        const dateInput = document.getElementById('input-tanggal-ketersediaan');
        if (dateInput) {
            dateInput.addEventListener('change', function () {
                if (this.value) {
                    loadKetersediaan({ tanggal: this.value });
                }
            });
        }

        // 2. Quick date buttons
        const quickBtns = container.querySelectorAll('.btn-quick-date');
        quickBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const date = this.getAttribute('data-date');
                if (date) {
                    loadKetersediaan({ tanggal: date });
                }
            });
        });

        // 3. Mini Calendar Navigation (bulan sblm/sesdh)
        const miniCalNavs = container.querySelectorAll('.mini-cal-nav');
        miniCalNavs.forEach(nav => {
            nav.addEventListener('click', function () {
                const m = this.getAttribute('data-cal-month');
                const y = this.getAttribute('data-cal-year');
                const currentDate = document.getElementById('input-tanggal-ketersediaan')?.value || '';
                loadKetersediaan({
                    tanggal: currentDate,
                    cal_month: m,
                    cal_year: y
                });
            });
        });

        // 4. Mini Calendar Day Click
        const miniCalDays = container.querySelectorAll('.mini-cal-day[data-date]');
        miniCalDays.forEach(day => {
            day.addEventListener('click', function () {
                const date = this.getAttribute('data-date');
                if (date) {
                    loadKetersediaan({ tanggal: date });
                }
            });
        });

        // 5. Filter Tabs (Semua / Tersedia / Terbooking)
        const filterTabs = container.querySelectorAll('.filter-tab-btn');
        filterTabs.forEach(tab => {
            tab.addEventListener('click', function () {
                filterTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const filterVal = this.getAttribute('data-filter');
                const cards = container.querySelectorAll('.room-status-card');

                cards.forEach(card => {
                    const status = card.getAttribute('data-status');
                    if (filterVal === 'all') {
                        card.style.display = 'grid';
                    } else if (filterVal === status) {
                        card.style.display = 'grid';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }

    // Inisialisasi event pertama kali saat halaman dibuka
    initEventHandlers();
});
</script>
@endsection
