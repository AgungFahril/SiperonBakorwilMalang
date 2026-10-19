<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Peminjaman Ruangan Baru</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 24px; color: #333333;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #1e293b, #0f172a); padding: 28px 32px; text-align: center; color: #ffffff;">
            <div style="font-size: 28px; margin-bottom: 6px;">&#9888;</div>
            <h1 style="margin: 0; font-size: 20px; font-weight: 700;">Pengajuan Peminjaman Baru Masuk</h1>
            <p style="margin: 6px 0 0; font-size: 13px; color: #94a3b8;">SIPERON Admin Notification</p>
        </div>

        <!-- Body Content -->
        <div style="padding: 32px;">
            <p style="font-size: 15px; margin-top: 0;">Halo <strong>Admin SIPERON</strong>,</p>
            <p style="font-size: 14px; line-height: 1.6; color: #4b5563;">
                Ada pengajuan peminjaman ruangan baru yang membutuhkan verifikasi Anda:
            </p>

            <!-- Card Info -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; margin: 20px 0;">
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; width: 38%;">Kode Booking</td>
                        <td style="padding: 6px 0; font-weight: 700; color: #08a6d9;">{{ $booking->kode_booking }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Nama Pemohon</td>
                        <td style="padding: 6px 0; font-weight: 600;">{{ $booking->nama_pemohon }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Instansi</td>
                        <td style="padding: 6px 0;">{{ $booking->instansi ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">WhatsApp</td>
                        <td style="padding: 6px 0; font-weight: 600; color: #059669;">{{ $booking->no_whatsapp }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Email</td>
                        <td style="padding: 6px 0;">{{ $booking->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Ruangan</td>
                        <td style="padding: 6px 0; font-weight: 600;">{{ $booking->room->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Tanggal Acara</td>
                        <td style="padding: 6px 0; font-weight: 600;">{{ $booking->tanggal->translatedFormat('l, d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Waktu</td>
                        <td style="padding: 6px 0;">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }} WIB</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Kegiatan</td>
                        <td style="padding: 6px 0;">{{ $booking->nama_kegiatan }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Jumlah Peserta</td>
                        <td style="padding: 6px 0; font-weight: 600;">{{ $booking->jumlah_peserta ? $booking->jumlah_peserta . ' Orang' : '-' }}</td>
                    </tr>
                </table>
            </div>

            <div style="text-align: center; margin: 30px 0 10px;">
                <a href="{{ route('admin.peminjaman.show', $booking) }}" style="background: #08a6d9; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px; display: inline-block;">
                    Buka Panel Admin & Proses
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #f9fafb; padding: 16px 32px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #e5e7eb;">
            SIPERON Bakorwil III Malang — Notifikasi Internal Petugas
        </div>

    </div>
</body>
</html>
