@extends('layouts.app')

@section('title', 'Ajukan Peminjaman - ' . $room->name)

@section('content')
<section class="booking-form-section">
    <div class="container">

        <div class="booking-form-header">
            <span class="form-label-tag">FORM PENGAJUAN</span>
            <h1>Ajukan Peminjaman: {{ $room->name }}</h1>
            <p>Kapasitas {{ $room->capacity }} kursi. Lengkapi data di bawah ini dengan benar.</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Mohon periksa kembali isian Anda:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($settings['default_rules']))
            <div style="background-color: #f8fafc; border-left: 4px solid var(--bakorwil-cyan); padding: 1.5rem; margin-bottom: 2rem; border-radius: 4px;">
                <h4 style="margin-top: 0; color: var(--text-heading); font-size: 1.1rem; margin-bottom: 0.5rem;">Aturan Peminjaman:</h4>
                <div style="color: var(--text-body); line-height: 1.6;">
                    {!! nl2br(e($settings['default_rules'])) !!}
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('booking.store', $room) }}" class="booking-form" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" id="nama_kegiatan" name="nama_kegiatan"
                           value="{{ old('nama_kegiatan') }}" placeholder="Contoh: Rapat Koordinasi Bulanan" required>
                </div>

                <div class="form-group">
                    <label for="nama_pemohon">Nama Pemohon</label>
                    <input type="text" id="nama_pemohon" name="nama_pemohon"
                           value="{{ old('nama_pemohon', Auth::check() ? Auth::user()->name : '') }}" placeholder="Nama lengkap Anda" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="instansi">Instansi</label>
                    <input type="text" id="instansi" name="instansi"
                           value="{{ old('instansi') }}" placeholder="Nama instansi/lembaga">
                </div>

                <div class="form-group">
                    <label for="kontak">Kontak (No. HP / Email)</label>
                    <input type="text" id="kontak" name="kontak"
                           value="{{ old('kontak', Auth::check() ? Auth::user()->email : '') }}" placeholder="08xxxxxxxxxx atau email@contoh.com">
                </div>
            </div>

            <div class="form-row form-row-3">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                </div>

                <div class="form-group">
                    <label for="jam_mulai">Jam Mulai</label>
                    <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                </div>

                <div class="form-group">
                    <label for="jam_selesai">Jam Selesai</label>
                    <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                </div>
            </div>

            <div class="form-group" style="margin-top: 1rem;">
                <label for="surat_pengajuan">Upload Surat Pengajuan (Wajib, format PDF, maksimal 15MB)</label>
                <input type="file" id="surat_pengajuan" name="surat_pengajuan" accept="application/pdf" style="padding-top: 12px;" required>
            </div>

            <div class="form-actions">
                <a href="{{ route('home') }}#ruangan" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
            </div>

        </form>

    </div>
</section>
@endsection
