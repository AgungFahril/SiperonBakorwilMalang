@extends('layouts.admin')

@section('title', 'Notifikasi - Admin SIPERON')

@section('content')
    <div class="page-header-row">
        <div>
            <div class="page-title">Notifikasi</div>
            <p class="page-subtitle">Semua notifikasi sistem</p>
        </div>
    </div>

    @if(session('success'))
        <div style="padding: 0.75rem 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
        @forelse($notifications as $notif)
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f3f4f6; display: flex; align-items: flex-start; gap: 1rem; {{ !$notif->is_read ? 'background: #f0f9ff;' : '' }}">
                <div style="width: 10px; height: 10px; border-radius: 50%; margin-top: 6px; flex-shrink: 0; background: {{ !$notif->is_read ? '#08a6d9' : '#d1d5db' }};"></div>
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap;">
                        <div>
                            <h4 style="font-size: 0.95rem; font-weight: 600; color: #171717; margin-bottom: 4px;">{{ $notif->title }}</h4>
                            <p style="font-size: 0.85rem; color: #666; white-space: pre-line; line-height: 1.5;">{{ $notif->message }}</p>
                        </div>
                        <div style="display: flex; gap: 8px; align-items: center; flex-shrink: 0;">
                            <span style="font-size: 0.78rem; color: #999;">{{ $notif->created_at->diffForHumans() }}</span>
                            @if(!$notif->is_read)
                                <form action="{{ route('admin.notifikasi.read', $notif) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="background: none; border: 1px solid #08a6d9; color: #08a6d9; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; cursor: pointer;">
                                        Tandai Dibaca
                                    </button>
                                </form>
                            @endif
                            @if($notif->booking)
                                <a href="{{ route('admin.peminjaman.show', $notif->booking) }}" style="background: #08a6d9; color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; text-decoration: none;">
                                    Lihat
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div style="padding: 3rem; text-align: center; color: #999;">
                Belum ada notifikasi.
            </div>
        @endforelse
    </div>

    <div style="margin-top: 1rem;">
        {{ $notifications->links() }}
    </div>
@endsection
