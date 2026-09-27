<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - SIPERON')</title>
    
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <a href="{{ url('/admin/dashboard') }}" class="sidebar-brand">
                <span>SIPERON</span>
            </a>
        </div>
        
        <nav class="sidebar-nav">
            <a href="{{ url('/admin/dashboard') }}" class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ url('/admin/peminjaman') }}" class="nav-item {{ request()->is('admin/peminjaman') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                <span>Data Peminjaman</span>
            </a>
            
            <a href="{{ url('/admin/ruangan') }}" class="nav-item {{ request()->is('admin/ruangan') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" /></svg>
                <span>Data Ruangan</span>
            </a>
            
            <a href="{{ url('/admin/pengguna') }}" class="nav-item {{ request()->is('admin/pengguna') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                <span>Pengguna</span>
            </a>
            
            <a href="{{ url('/admin/pengaturan') }}" class="nav-item {{ request()->is('admin/pengaturan') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                <span>Pengaturan</span>
            </a>
            
            <div style="flex: 1"></div>
            
            <a href="{{ url('/') }}" class="nav-item" style="color: var(--text-muted);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" /></svg>
                <span>Kembali ke Web</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="admin-main">
        
        <!-- Header -->
        <header class="admin-header">
            <div class="header-search">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                <input type="text" placeholder="Cari peminjaman atau ruangan...">
            </div>
            
            <div class="header-actions">
                <button class="action-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
                    <span class="badge">3</span>
                </button>
                
                <div class="user-profile">
                    <div class="user-info" style="text-align: right;">
                        <span class="user-name">Admin Bakorwil</span>
                        <span class="user-role">Administrator</span>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin+Bakorwil&background=0284c7&color=fff" alt="User Avatar" class="avatar">
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="admin-content" id="admin-content">
            @yield('content')
        </div>
        
    </main>

    <!-- Loading Bar -->
    <div class="page-loading-bar" id="loadingBar"></div>

    <script>
    (function() {
        const contentArea = document.getElementById('admin-content');
        const loadingBar = document.getElementById('loadingBar');

        // Attach SPA navigation to all admin nav links
        function attachNavListeners() {
            document.querySelectorAll('.sidebar-nav .nav-item').forEach(link => {
                const href = link.getAttribute('href');
                // Skip links that are "#" or external (non-admin)
                if (!href || href === '#' || !href.includes('/admin/')) return;

                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (window.location.pathname === new URL(href, window.location.origin).pathname) return;
                    navigateTo(href);
                });
            });

            // Also handle brand logo click
            const brand = document.querySelector('.sidebar-brand');
            if (brand) {
                brand.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo(this.getAttribute('href'));
                });
            }
        }

        async function navigateTo(url) {
            // Show loading bar
            loadingBar.classList.add('active');

            // Fade out current content
            contentArea.classList.add('content-exit');

            try {
                const response = await fetch(url);
                const html = await response.text();

                // Parse the fetched HTML
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Extract the new content
                const newContent = doc.getElementById('admin-content');
                const newTitle = doc.querySelector('title');

                if (newContent) {
                    // Wait for exit animation
                    await new Promise(r => setTimeout(r, 150));

                    // Replace content
                    contentArea.innerHTML = newContent.innerHTML;

                    // Update page title
                    if (newTitle) document.title = newTitle.textContent;

                    // Update browser URL
                    history.pushState(null, '', url);

                    // Update active state on sidebar
                    updateActiveNav(url);

                    // Re-bind modal events for new content
                    initModals();

                    // Animate in
                    contentArea.classList.remove('content-exit');
                    contentArea.classList.add('content-enter');
                    
                    // Scroll to top of content
                    contentArea.scrollTop = 0;

                    setTimeout(() => {
                        contentArea.classList.remove('content-enter');
                    }, 300);
                }
            } catch (err) {
                // On error, fallback to normal navigation
                window.location.href = url;
            } finally {
                // Hide loading bar
                setTimeout(() => loadingBar.classList.remove('active'), 300);
            }
        }

        function updateActiveNav(url) {
            const path = new URL(url, window.location.origin).pathname;
            document.querySelectorAll('.sidebar-nav .nav-item').forEach(link => {
                const linkPath = new URL(link.getAttribute('href') || '#', window.location.origin).pathname;
                if (linkPath === path) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        }

        // Handle browser back/forward
        window.addEventListener('popstate', function() {
            navigateTo(window.location.href);
        });

        // ================= MODAL LOGIC =================
        function initModals() {
            // Open Modals
            document.querySelectorAll('[data-modal-target]').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = button.getAttribute('data-modal-target');
                    const modal = document.getElementById(targetId);
                    if(modal) modal.classList.add('show');
                });
            });

            // Close Modals (X button or Cancel button)
            document.querySelectorAll('[data-modal-close]').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const modal = button.closest('.modal-backdrop');
                    if(modal) modal.classList.remove('show');
                });
            });

            // Close on backdrop click
            document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                backdrop.addEventListener('click', (e) => {
                    if (e.target === backdrop) backdrop.classList.remove('show');
                });
            });
        }

        // Initialize
        attachNavListeners();
        initModals(); // Init modals on first load
    })();
    </script>

</body>
</html>
