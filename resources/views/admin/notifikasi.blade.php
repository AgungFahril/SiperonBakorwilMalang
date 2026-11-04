@extends('layouts.admin')

@section('title', 'Notifikasi - Admin SIPERON')

@section('content')
    <style>
        /* ================== NOTIFICATION PAGE STYLES ================== */
        .notif-header-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .notif-stats {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .notif-stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
            transition: all var(--transition-smooth);
        }

        .notif-stat-chip:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-float-sm);
        }

        .notif-stat-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .notif-stat-count {
            font-weight: 700;
            color: var(--text-heading);
        }

        .notif-list {
            background: var(--bg-surface);
            border-radius: 16px;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .notif-item {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: all var(--transition-smooth);
            position: relative;
        }

        .notif-item:last-child {
            border-bottom: none;
        }

        .notif-item:hover {
            background-color: #f8fafc;
        }

        .notif-item.unread {
            background: linear-gradient(135deg, rgba(0, 188, 212, 0.04), rgba(2, 132, 199, 0.03));
            border-left: 3px solid var(--bakorwil-cyan);
        }

        .notif-item.unread:hover {
            background: linear-gradient(135deg, rgba(0, 188, 212, 0.07), rgba(2, 132, 199, 0.05));
        }

        .notif-icon-wrapper {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform var(--transition-smooth);
        }

        .notif-item:hover .notif-icon-wrapper {
            transform: scale(1.05);
        }

        .notif-icon-wrapper svg {
            width: 20px;
            height: 20px;
        }

        .notif-icon-new {
            background: linear-gradient(135deg, #dbeafe, #e0f2fe);
            color: var(--bakorwil-blue);
        }

        .notif-icon-approved {
            background: linear-gradient(135deg, #d1fae5, #ecfdf5);
            color: #059669;
        }

        .notif-icon-rejected {
            background: linear-gradient(135deg, #fee2e2, #fef2f2);
            color: #dc2626;
        }

        .notif-icon-info {
            background: linear-gradient(135deg, var(--bakorwil-cyan-light), #e0f7fa);
            color: var(--bakorwil-cyan-dark);
        }

        .notif-content {
            flex: 1;
            min-width: 0;
        }

        .notif-title {
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--text-heading);
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .notif-item.unread .notif-title {
            font-weight: 700;
        }

        .notif-message {
            font-size: 0.84rem;
            color: var(--text-muted);
            line-height: 1.55;
            white-space: pre-line;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notif-meta {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 0.6rem;
            flex-wrap: wrap;
        }

        .notif-time {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.76rem;
            color: #94a3b8;
            font-weight: 500;
        }

        .notif-time svg {
            width: 13px;
            height: 13px;
        }

        .notif-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .notif-btn {
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-size: 0.76rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all var(--transition-smooth);
            text-decoration: none;
            border: none;
        }

        .notif-btn svg {
            width: 13px;
            height: 13px;
        }

        .notif-btn-read {
            background: var(--bg-body);
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        .notif-btn-read:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-float-sm);
            color: var(--bakorwil-blue);
            border-color: var(--bakorwil-blue);
        }

        .notif-btn-view {
            background: var(--bakorwil-cyan);
            color: #ffffff;
        }

        .notif-btn-view:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-float-cyan);
            background: var(--bakorwil-cyan-dark);
        }

        .notif-empty {
            padding: 4rem 2rem;
            text-align: center;
        }

        .notif-empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.25rem;
            background: linear-gradient(135deg, var(--bakorwil-cyan-light), var(--bakorwil-blue-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notif-empty-icon svg {
            width: 36px;
            height: 36px;
            color: var(--bakorwil-cyan);
            opacity: 0.6;
        }

        .notif-empty-title {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--text-heading);
            margin-bottom: 0.35rem;
        }

        .notif-empty-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* Pagination wrapper */
        .notif-pagination {
            margin-top: 1.25rem;
            display: flex;
            justify-content: center;
        }

        /* Reset default Laravel pagination nav wrapper */
        .notif-pagination nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Hide the "Showing X to Y of Z results" text */
        .notif-pagination nav > div:first-child {
            display: none;
        }

        /* Target the actual pagination container */
        .notif-pagination nav > div:last-child {
            display: flex;
            align-items: center;
            gap: 0;
        }

        /* Reset default list styling */
        .notif-pagination .pagination,
        .notif-pagination nav > div > span,
        .notif-pagination nav > div:last-child > span {
            display: flex;
            gap: 0.35rem;
            list-style: none;
            padding: 0;
            margin: 0;
            align-items: center;
            flex-wrap: wrap;
        }

        /* All pagination links and spans (page numbers + prev/next) */
        .notif-pagination .page-item .page-link,
        .notif-pagination nav span a,
        .notif-pagination nav span span,
        .notif-pagination nav > div:last-child span a,
        .notif-pagination nav > div:last-child span span {
            min-width: 36px;
            height: 36px;
            padding: 0 0.6rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: var(--bg-surface);
            color: var(--text-muted);
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-smooth);
            text-decoration: none;
            white-space: nowrap;
            font-family: 'Inter', sans-serif;
        }

        /* Hover state */
        .notif-pagination .page-item .page-link:hover,
        .notif-pagination nav span a:hover,
        .notif-pagination nav > div:last-child span a:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-float-sm);
            color: var(--bakorwil-blue);
            border-color: var(--bakorwil-blue);
            background-color: var(--bg-surface);
        }

        /* Active page */
        .notif-pagination .page-item.active .page-link,
        .notif-pagination nav span span[aria-current="page"],
        .notif-pagination nav > div:last-child span span[aria-current="page"] {
            background-color: var(--bakorwil-cyan);
            color: #ffffff;
            border-color: var(--bakorwil-cyan);
            cursor: default;
            box-shadow: 0 2px 8px rgba(0, 188, 212, 0.25);
        }

        /* Disabled state (Previous when on first page, Next when on last) */
        .notif-pagination .page-item.disabled .page-link,
        .notif-pagination nav span span[aria-disabled="true"],
        .notif-pagination nav > div:last-child span span[aria-disabled="true"] {
            opacity: 0.35;
            cursor: not-allowed;
            pointer-events: none;
            transform: none;
            box-shadow: none;
        }

        /* Hide the verbose "Previous" / "Next" text — replace with cleaner arrows via CSS */
        .notif-pagination nav span a[rel="prev"],
        .notif-pagination nav span span[aria-disabled="true"]:first-child,
        .notif-pagination nav > div:last-child span a[rel="prev"],
        .notif-pagination nav > div:last-child span span[aria-disabled]:first-of-type {
            font-size: 0;
            min-width: 36px;
            width: 36px;
            padding: 0;
            position: relative;
        }

        .notif-pagination nav span a[rel="next"],
        .notif-pagination nav span span[aria-disabled="true"]:last-child,
        .notif-pagination nav > div:last-child span a[rel="next"],
        .notif-pagination nav > div:last-child span span[aria-disabled]:last-of-type {
            font-size: 0;
            min-width: 36px;
            width: 36px;
            padding: 0;
            position: relative;
        }

        /* Add arrow icons via pseudo-elements */
        .notif-pagination nav span a[rel="prev"]::after,
        .notif-pagination nav span span[aria-disabled="true"]:first-child::after,
        .notif-pagination nav > div:last-child span a[rel="prev"]::after,
        .notif-pagination nav > div:last-child span span[aria-disabled]:first-of-type::after {
            content: '';
            display: block;
            width: 10px;
            height: 10px;
            border-left: 2px solid currentColor;
            border-bottom: 2px solid currentColor;
            transform: rotate(45deg);
            font-size: 0.85rem;
        }

        .notif-pagination nav span a[rel="next"]::after,
        .notif-pagination nav span span[aria-disabled="true"]:last-child::after,
        .notif-pagination nav > div:last-child span a[rel="next"]::after,
        .notif-pagination nav > div:last-child span span[aria-disabled]:last-of-type::after {
            content: '';
            display: block;
            width: 10px;
            height: 10px;
            border-right: 2px solid currentColor;
            border-top: 2px solid currentColor;
            transform: rotate(45deg);
            font-size: 0.85rem;
        }

        /* Dots separator between page numbers */
        .notif-pagination nav span span.dots,
        .notif-pagination nav > div:last-child span span:not([aria-current]):not([aria-disabled]) {
            border: none;
            background: none;
            box-shadow: none;
            min-width: auto;
            padding: 0 0.25rem;
            cursor: default;
        }

        /* Success toast */
        .notif-toast {
            background: linear-gradient(135deg, #d1fae5, #ecfdf5);
            color: #065f46;
            padding: 0.85rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.25rem;
            font-size: 0.88rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            border: 1px solid #a7f3d0;
            animation: toastSlideIn 0.3s ease forwards;
        }

        .notif-toast svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            color: #059669;
        }

        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Animate notification items */
        .notif-item {
            animation: notifFadeIn 0.3s ease forwards;
            opacity: 0;
        }

        @keyframes notifFadeIn {
            to { opacity: 1; }
        }

        .notif-item:nth-child(1) { animation-delay: 0.05s; }
        .notif-item:nth-child(2) { animation-delay: 0.1s; }
        .notif-item:nth-child(3) { animation-delay: 0.15s; }
        .notif-item:nth-child(4) { animation-delay: 0.2s; }
        .notif-item:nth-child(5) { animation-delay: 0.25s; }
        .notif-item:nth-child(6) { animation-delay: 0.3s; }
        .notif-item:nth-child(7) { animation-delay: 0.35s; }
        .notif-item:nth-child(8) { animation-delay: 0.4s; }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .notif-item {
                flex-direction: column;
                gap: 0.75rem;
                padding: 1rem 1.25rem;
            }

            .notif-actions {
                align-self: flex-start;
            }

            .notif-stats {
                gap: 0.5rem;
            }

            .notif-stat-chip {
                padding: 0.4rem 0.75rem;
                font-size: 0.8rem;
            }

            .notif-header-actions {
                width: 100%;
            }

            .notif-header-actions .btn-outline,
            .notif-header-actions .btn-sm-outline {
                flex: 1;
                justify-content: center;
            }
        }
    </style>

    @if(session('success'))
        <div class="notif-toast">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="page-header-row">
        <div>
            <div class="page-title">Notifikasi</div>
            <p class="page-subtitle">Semua notifikasi pengajuan peminjaman ruangan</p>
        </div>
        @if($notifications->count() > 0)
        <div class="notif-header-actions">
            @if($notifications->where('is_read', false)->count() > 0)
            <form action="{{ route('admin.notifikasi.readAll') }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-outline" style="font-size: 0.82rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>
        @endif
    </div>

    {{-- Stats chips --}}
    @php
        $totalNotif = $notifications->total();
        $unreadCount = \App\Models\AdminNotification::where('is_read', false)->count();
        $readCount = \App\Models\AdminNotification::where('is_read', true)->count();
    @endphp
    <div class="notif-stats">
        <div class="notif-stat-chip">
            <span class="notif-stat-dot" style="background: var(--bakorwil-blue);"></span>
            Semua <span class="notif-stat-count">{{ $totalNotif }}</span>
        </div>
        <div class="notif-stat-chip">
            <span class="notif-stat-dot" style="background: var(--bakorwil-cyan);"></span>
            Belum Dibaca <span class="notif-stat-count">{{ $unreadCount }}</span>
        </div>
        <div class="notif-stat-chip">
            <span class="notif-stat-dot" style="background: #94a3b8;"></span>
            Sudah Dibaca <span class="notif-stat-count">{{ $readCount }}</span>
        </div>
    </div>

    {{-- Notification list --}}
    <div class="notif-list">
        @forelse($notifications as $notif)
            @php
                // Determine icon type based on notification title/message
                $iconType = 'info';
                $titleLower = strtolower($notif->title ?? '');
                $msgLower = strtolower($notif->message ?? '');
                if (str_contains($titleLower, 'disetujui') || str_contains($titleLower, 'diterima') || str_contains($msgLower, 'disetujui')) {
                    $iconType = 'approved';
                } elseif (str_contains($titleLower, 'ditolak') || str_contains($msgLower, 'ditolak')) {
                    $iconType = 'rejected';
                } elseif (str_contains($titleLower, 'baru') || str_contains($titleLower, 'pengajuan') || str_contains($msgLower, 'pengajuan baru')) {
                    $iconType = 'new';
                }
            @endphp
            <div class="notif-item {{ !$notif->is_read ? 'unread' : '' }}">
                {{-- Icon --}}
                <div class="notif-icon-wrapper notif-icon-{{ $iconType }}">
                    @if($iconType === 'approved')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    @elseif($iconType === 'rejected')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    @elseif($iconType === 'new')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
                    @endif
                </div>

                {{-- Content --}}
                <div class="notif-content">
                    <div class="notif-title">{{ $notif->title }}</div>
                    <p class="notif-message">{{ $notif->message }}</p>
                    <div class="notif-meta">
                        <span class="notif-time">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            {{ $notif->created_at->diffForHumans() }}
                        </span>
                        @if(!$notif->is_read)
                            <span style="font-size: 0.72rem; background: var(--bakorwil-cyan-light); color: var(--bakorwil-cyan-dark); padding: 2px 8px; border-radius: 10px; font-weight: 600;">Baru</span>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div class="notif-actions">
                    @if(!$notif->is_read)
                        <form action="{{ route('admin.notifikasi.read', $notif) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="notif-btn notif-btn-read" title="Tandai sudah dibaca">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                Dibaca
                            </button>
                        </form>
                    @endif
                    @if($notif->booking)
                        <a href="{{ route('admin.peminjaman.show', $notif->booking) }}" class="notif-btn notif-btn-view" title="Lihat detail peminjaman">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                            Lihat
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="notif-empty">
                <div class="notif-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
                </div>
                <div class="notif-empty-title">Belum ada notifikasi</div>
                <p class="notif-empty-desc">Notifikasi akan muncul ketika ada pengajuan peminjaman baru.</p>
            </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
        <div class="notif-pagination">
            {{ $notifications->links() }}
        </div>
    @endif
@endsection
