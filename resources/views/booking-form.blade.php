@extends('layouts.app')

@section('title', 'Ajukan Peminjaman - ' . $room->name)

@section('content')
<section class="container" style="max-width:640px;margin:60px auto;">

    <h1>Ajukan Peminjaman: {{ $room->name }}</h1>
    <p>Kapasitas {{ $room->capacity }} kursi.</p>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('booking.store', $room) }}">
        @csrf

        <label>Nama Kegiatan</label>
        <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required>

        <label>Nama Pemohon</label>
        <input type="text" name="nama_pemohon" value="{{ old('nama_pemohon') }}" required>

        <label>Instansi</label>
        <input type="text" name="instansi" value="{{ old('instansi') }}">

        <label>Kontak (No. HP / Email)</label>
        <input type="text" name="kontak" value="{{ old('kontak') }}">

        <label>Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal') }}" required>

        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" required>

        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" required>

        <button type="submit" class="btn btn-primary" style="margin-top:16px;">Kirim Pengajuan</button>
    </form>

</section>
@endsection
