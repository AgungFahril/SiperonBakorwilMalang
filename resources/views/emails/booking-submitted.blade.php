<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Peminjaman Ruangan</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 24px; color: #333333;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #08a6d9, #0284c7); padding: 28px 32px; text-align: center; color: #ffffff;">
            <h1 style="margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 0.5px;">SIPERON BAKORWIL III MALANG</h1>
            <p style="margin: 6px 0 0; font-size: 14px; opacity: 0.9;">Sistem Peminjaman Ruangan Online</p>
        </div>

        <!-- Body Content -->
        <div style="padding: 32px;">
            <p style="font-size: 16px; margin-top: 0;">Yth. <strong>{{ $booking->nama_pemohon }}</strong>,</p>
            <p style="font-size: 14px; line-height: 1.6; color: #4b5563;">
                Pengajuan peminjaman ruangan Anda telah berhasil kami terima dan saat ini sedang dalam status <strong>MENUNGGU PERSETUJUAN</strong> oleh pengelola Bakorwil III Malang.
            </p>

            <!-- Box Kode Booking -->
            <div style="background: #f0fdf4; border: 2px dashed #08a6d9; border-radius: 8px; padding: 18px; text-align: center; margin: 24px 0;">
                <span style="font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; letter-spacing: 1px;">KODE BOOKING ANDA</span>
                <div style="font-size: 26px; font-weight: 800; color: #08a6d9; letter-spacing: 2px; margin: 6px 0;">{{ $booking->kode_booking }}</div>
                <span style="font-size: 12px; color: #4b5563;">Simpan kode booking ini untuk mengecek status permohonan Anda.</span>
            </div>

            <!-- Detail Peminjaman -->
            <table style="width: 100%; border-collapse: collapse; font-size: 14px; margin-bottom: 24px;">
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; width: 38%; border-bottom: 1px solid #f3f4f6;">Ruangan</td>
                    <td style="padding: 8px 0; font-weight: 600; color: #111827; border-bottom: 1px solid #f3f4f6;">{{ $booking->room->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6;">Tanggal Acara</td>
                    <td style="padding: 8px 0; font-weight: 600; color: #111827; border-bottom: 1px solid #f3f4f6;">{{ $booking->tanggal->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6;">Waktu</td>
                    <td style="padding: 8px 0; font-weight: 600; color: #111827; border-bottom: 1px solid #f3f4f6;">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }} WIB</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6;">Nama Kegiatan</td>
                    <td style="padding: 8px 0; color: #111827; border-bottom: 1px solid #f3f4f6;">{{ $booking->nama_kegiatan }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6;">Jumlah Peserta</td>
                    <td style="padding: 8px 0; font-weight: 600; color: #111827; border-bottom: 1px solid #f3f4f6;">{{ $booking->jumlah_peserta ? $booking->jumlah_peserta . ' Orang' : '-' }}</td>
                </tr>
                @if($booking->instansi)
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6;">Instansi</td>
                    <td style="padding: 8px 0; color: #111827; border-bottom: 1px solid #f3f4f6;">{{ $booking->instansi }}</td>
                </tr>
                @endif
            </table>

            <div style="text-align: center; margin: 30px 0 10px;">
                <a href="{{ route('cek.booking.form') }}" style="background: #08a6d9; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px; display: inline-block;">
                    Cek Status Booking Sekarang
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #f9fafb; padding: 20px 32px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #e5e7eb;">
            <p style="margin: 0;">Bakorwil III Malang — Pemerintah Provinsi Jawa Timur</p>
            <p style="margin: 4px 0 0;">Jl. Simpang Ijen No. 2 Kota Malang | Email ini dikirim otomatis oleh sistem SIPERON.</p>
        </div>

    </div>
</body>
</html>
