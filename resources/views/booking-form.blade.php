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
                    <label for="nama_pemohon">Nama Pemohon <span style="color: red;">*</span></label>
                    <input type="text" id="nama_pemohon" name="nama_pemohon"
                           value="{{ old('nama_pemohon') }}" placeholder="Nama lengkap Anda" required>
                </div>

                <div class="form-group">
                    <label for="instansi">Instansi / Organisasi</label>
                    <input type="text" id="instansi" name="instansi"
                           value="{{ old('instansi') }}" placeholder="Nama instansi/lembaga (jika ada)">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="no_whatsapp">Nomor WhatsApp <span style="color: red;">*</span></label>
                    <input type="text" id="no_whatsapp" name="no_whatsapp"
                           value="{{ old('no_whatsapp') }}" placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="form-group">
                    <label for="email">Email <span style="color: red;">*</span></label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}" placeholder="email@contoh.com" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nama_kegiatan">Keperluan / Nama Kegiatan <span style="color: red;">*</span></label>
                    <input type="text" id="nama_kegiatan" name="nama_kegiatan"
                           value="{{ old('nama_kegiatan') }}" placeholder="Contoh: Rapat Koordinasi Bulanan" required>
                </div>
            </div>

            <div class="form-row form-row-3">
                <div class="form-group">
                    <label for="tanggal">Tanggal <span style="color: red;">*</span></label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" min="{{ \Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label for="jam_mulai">Jam Mulai <span style="color: red;">*</span></label>
                    <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                </div>

                <div class="form-group">
                    <label for="jam_selesai">Jam Selesai <span style="color: red;">*</span></label>
                    <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                </div>
            </div>

            <div class="form-group" style="margin-top: 1rem;">
                <label for="keterangan">Keterangan Tambahan (Opsional)</label>
                <textarea id="keterangan" name="keterangan" rows="3" placeholder="Informasi tambahan terkait kegiatan..." style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; resize: vertical;">{{ old('keterangan') }}</textarea>
            </div>

            <div class="form-group" style="margin-top: 1rem;">
                <label for="surat_pengajuan">Upload Surat Pengajuan (Wajib, format PDF, maksimal 15MB) <span style="color: red;">*</span></label>
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
