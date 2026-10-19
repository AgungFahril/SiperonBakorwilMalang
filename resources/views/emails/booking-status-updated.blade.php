<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembaruan Status Peminjaman Ruangan</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 24px; color: #333333;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
        
        @php
            $headerStyles = [
                'disetujui' => ['bg' => 'linear-gradient(135deg, #059669, #047857)', 'title' => 'Peminjaman Disetujui!'],
                'ditolak'   => ['bg' => 'linear-gradient(135deg, #dc2626, #b91c1c)', 'title' => 'Permohonan Tidak Disetujui'],
                'dijadwalkan_ulang' => ['bg' => 'linear-gradient(135deg, #4f46e5, #4338ca)', 'title' => 'Peminjaman Perlu Dijadwalkan Ulang'],
                'selesai'   => ['bg' => 'linear-gradient(135deg, #4b5563, #374151)', 'title' => 'Peminjaman Telah Selesai'],
            ];
            $h = $headerStyles[$statusBaru] ?? ['bg' => 'linear-gradient(135deg, #08a6d9, #0284c7)', 'title' => 'Update Status Peminjaman'];
        @endphp

        <!-- Header -->
        <div style="background: {{ $h['bg'] }}; padding: 28px 32px; text-align: center; color: #ffffff;">
            <h1 style="margin: 0; font-size: 22px; font-weight: 700;">{{ $h['title'] }}</h1>
            <p style="margin: 6px 0 0; font-size: 14px; opacity: 0.9;">Kode: {{ $booking->kode_booking }}</p>
        </div>

        <!-- Body Content -->
        <div style="padding: 32px;">
            <p style="font-size: 16px; margin-top: 0;">Yth. <strong>{{ $booking->nama_pemohon }}</strong>,</p>

            @if($statusBaru === 'disetujui')
                <div style="background: #ecfdf5; border-left: 4px solid #10b981; padding: 14px 18px; border-radius: 6px; margin-bottom: 20px;">
                    <p style="margin: 0; font-size: 14px; color: #065f46; line-height: 1.5;">
                        Selamat! Pengajuan peminjaman ruangan Anda telah <strong>DISETUJUI</strong> oleh pihak pengelola Bakorwil III Malang. Silakan hadir sesuai jadwal yang disetujui.
                    </p>
                </div>
            @elseif($statusBaru === 'dijadwalkan_ulang')
                <div style="background: #eef2ff; border-left: 4px solid #6366f1; padding: 14px 18px; border-radius: 6px; margin-bottom: 20px;">
                    <p style="margin: 0; font-size: 14px; color: #3730a3; line-height: 1.5;">
                        Mohon maaf, peminjaman Anda perlu <strong>DIJADWALKAN ULANG</strong> karena adanya kegiatan instansi yang lebih prioritas.
                    </p>
                    @if($alasan)
                        <p style="margin: 8px 0 0; font-size: 13px; color: #4338ca;">
                            <strong>Alasan dari pengelola:</strong> {{ $alasan }}
                        </p>
                    @endif
                    <p style="margin: 10px 0 0; font-size: 13px; color: #3730a3;">
                        Silakan buka kembali SIPERON untuk memilih ruangan atau tanggal alternatif lainnya.
                    </p>
                </div>
            @elseif($statusBaru === 'ditolak')
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 14px 18px; border-radius: 6px; margin-bottom: 20px;">
                    <p style="margin: 0; font-size: 14px; color: #991b1b; line-height: 1.5;">
                        Mohon maaf, pengajuan peminjaman ruangan Anda belum dapat kami setujui.
                    </p>
                    @if($alasan)
                        <p style="margin: 8px 0 0; font-size: 13px; color: #b91c1c;">
                            <strong>Alasan penolakan:</strong> {{ $alasan }}
                        </p>
                    @endif
                </div>
            @endif

            <!-- Rincian Peminjaman -->
            <table style="width: 100%; border-collapse: collapse; font-size: 14px; margin: 20px 0;">
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; width: 38%; border-bottom: 1px solid #f3f4f6;">Kode Booking</td>
                    <td style="padding: 8px 0; font-weight: 700; color: #08a6d9; border-bottom: 1px solid #f3f4f6;">{{ $booking->kode_booking }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6;">Ruangan</td>
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
                    <td style="padding: 8px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6;">Kegiatan</td>
                    <td style="padding: 8px 0; color: #111827; border-bottom: 1px solid #f3f4f6;">{{ $booking->nama_kegiatan }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6;">Jumlah Peserta</td>
                    <td style="padding: 8px 0; font-weight: 600; color: #111827; border-bottom: 1px solid #f3f4f6;">{{ $booking->jumlah_peserta ? $booking->jumlah_peserta . ' Orang' : '-' }}</td>
                </tr>
            </table>

            <div style="text-align: center; margin: 30px 0 10px;">
                <a href="{{ route('cek.booking.form') }}" style="background: #08a6d9; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px; display: inline-block;">
                    Lihat Detail di Halaman Cek Booking
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
