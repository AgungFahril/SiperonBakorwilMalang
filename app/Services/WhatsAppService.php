<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Format nomor HP ke standar Indonesia (628xxx).
     */
    public static function formatPhoneNumber(?string $number): ?string
    {
        if (!$number) {
            return null;
        }

        // Hapus semua karakter non-digit
        $clean = preg_replace('/[^0-9]/', '', $number);

        // Jika diawali dengan '08', ganti menjadi '628'
        if (str_starts_with($clean, '08')) {
            $clean = '62' . substr($clean, 1);
        } elseif (str_starts_with($clean, '8')) {
            $clean = '62' . $clean;
        } elseif (str_starts_with($clean, '+62')) {
            $clean = substr($clean, 1);
        }

        return $clean;
    }

    /**
     * Buat URL langsung ke WhatsApp Web dengan nomor dan pesan terisi otomatis (melewati halaman perantara wa.me).
     */
    public static function generateWaLink(?string $targetPhone, string $message): string
    {
        $phone = self::formatPhoneNumber($targetPhone);
        if (!$phone) {
            return '#';
        }
        return "https://web.whatsapp.com/send?phone={$phone}&text=" . rawurlencode($message);
    }

    /**
     * Susun template pesan konfirmasi WhatsApp resmi (untuk single ruangan maupun paket multi-ruangan).
     */
    public static function buildConfirmationMessage($bookings, string $statusBaru, ?string $alasan = null): string
    {
        if ($bookings instanceof Booking) {
            $bookings = collect([$bookings]);
        } elseif (!($bookings instanceof Collection)) {
            $bookings = collect($bookings);
        }

        if ($bookings->isEmpty()) {
            return '';
        }

        $first = $bookings->first();
        $count = $bookings->count();
        $namaPemohon = $first->nama_pemohon;
        $instansi = $first->instansi ? " ({$first->instansi})" : '';

        $statusLabels = [
            'disetujui'         => 'DISETUJUI',
            'ditolak'           => 'DITOLAK / TIDAK DISETUJUI',
            'dijadwalkan_ulang' => 'PERLU PENJADWALAN ULANG',
            'selesai'           => 'SELESAI',
            'pending'           => 'MENUNGGU PERSETUJUAN',
        ];
        $headerText = $statusLabels[$statusBaru] ?? strtoupper($statusBaru);

        $msg = "*SIPERON BAKORWIL III MALANG*\n"
             . "Pemerintah Provinsi Jawa Timur\n"
             . "Jl. Simpang Ijen No. 2, Kota Malang\n\n"
             . "Halo Bapak/Ibu *{$namaPemohon}*{$instansi},\n\n";

        if ($count === 1) {
            $b = $first;
            $rName = $b->room->name ?? 'Ruangan';
            $tgl = $b->tanggal->translatedFormat('l, d F Y');
            $jam = substr($b->jam_mulai, 0, 5) . " - " . substr($b->jam_selesai, 0, 5) . " WIB";
            $peserta = $b->jumlah_peserta ? $b->jumlah_peserta . ' Orang' : '-';

            $msg .= "Status permohonan peminjaman ruangan Anda telah diperbarui menjadi:\n"
                  . "*STATUS: {$headerText}*\n\n"
                  . "*Rincian Peminjaman:*\n"
                  . "• Kode Booking: *{$b->kode_booking}*\n"
                  . "• Ruangan: *{$rName}*\n"
                  . "• Tanggal: {$tgl}\n"
                  . "• Waktu: {$jam}\n"
                  . "• Keperluan: {$b->nama_kegiatan}\n"
                  . "• Jumlah Peserta: {$peserta}\n";
        } else {
            $groupCode = $first->group_code ?: $first->kode_booking;
            $msg .= "Status pengajuan peminjaman ruangan Anda (*{$count} Ruangan* - Paket: *{$groupCode}*) telah diperbarui menjadi:\n"
                  . "*STATUS: {$headerText}*\n\n"
                  . "*Rincian Ruangan:*\n";

            foreach ($bookings as $idx => $b) {
                $rName = $b->room->name ?? 'Ruangan';
                $tgl = $b->tanggal->translatedFormat('d F Y');
                $jam = substr($b->jam_mulai, 0, 5) . " - " . substr($b->jam_selesai, 0, 5) . " WIB";
                $msg .= ($idx + 1) . ". *{$rName}* ({$b->kode_booking})\n"
                     . "   • Tanggal: {$tgl} | {$jam}\n"
                     . "   • Acara: {$b->nama_kegiatan}\n";
            }
        }

        // Keterangan khusus sesuai status
        if ($statusBaru === 'disetujui') {
            $msg .= "\nSelamat! Pengajuan Anda telah disetujui. Silakan hadir tepat waktu sesuai jadwal dan mematuhi tata tertib penggunaan ruangan Bakorwil III Malang.";
        } elseif ($statusBaru === 'dijadwalkan_ulang') {
            $msg .= "\nMohon maaf, peminjaman Anda perlu dijadwalkan ulang karena adanya kegiatan prioritas dinas/instansi.";
            if ($alasan) {
                $msg .= "\n*Catatan Pengelola:* " . $alasan;
            }
            $msg .= "\nSilakan ajukan permohonan baru untuk memilih tanggal alternatif lain.";
        } elseif ($statusBaru === 'ditolak') {
            $msg .= "\nMohon maaf, permohonan peminjaman ruangan belum dapat disetujui.";
            if ($alasan) {
                $msg .= "\n*Alasan Penolakan:* " . $alasan;
            }
        }

        $msg .= "\n\nPantau status dan detail permohonan Anda melalui tautan resmi:\n"
              . route('cek.booking.form') . "\n\n"
              . "_Pesan resmi dari Pengelola Ruangan Bakorwil III Malang._";

        return $msg;
    }

    /**
     * Dapatkan API Token Fonnte / Gateway dari Setting DB atau .env (Opsional jika masih ada keperluan sistem).
     */
    public static function getToken(): ?string
    {
        $dbToken = Setting::where('key', 'wa_gateway_token')->value('value');
        if (!empty($dbToken)) {
            return trim($dbToken);
        }

        return env('FONNTE_TOKEN') ?: env('WA_API_TOKEN');
    }

    /**
     * Dapatkan status koneksi perangkat dari Fonnte API (Jika di masa mendatang ingin dicek).
     */
    public static function getDeviceStatus(): array
    {
        $token = self::getToken();
        if (empty($token)) {
            return [
                'configured' => false,
                'connected'  => false,
                'status'     => 'no_token',
                'message'    => 'Mode WhatsApp Manual Aktif (Tanpa Gateway Berbayar)'
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->timeout(4)->post('https://api.fonnte.com/device');

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status'] === true) {
                $devStatus = strtolower($result['device_status'] ?? 'disconnect');
                return [
                    'configured'    => true,
                    'connected'     => ($devStatus === 'connect'),
                    'status'        => $devStatus,
                    'device'        => $result['device'] ?? null,
                    'name'          => $result['name'] ?? null,
                    'quota'         => $result['quota'] ?? 0,
                    'expired'       => $result['expired'] ?? null,
                    'message'       => ($devStatus === 'connect') ? 'Terhubung (Online)' : 'Terputus (Disconnected)',
                ];
            }

            return [
                'configured' => true,
                'connected'  => false,
                'status'     => 'invalid',
                'message'    => $result['reason'] ?? 'Token tidak valid'
            ];
        } catch (\Throwable $e) {
            return [
                'configured' => true,
                'connected'  => false,
                'status'     => 'error',
                'message'    => 'Koneksi ke server gateway error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Kirim pesan WhatsApp otomatis (jika ada token aktif).
     */
    public static function send(string $targetPhone, string $message): array
    {
        $phone = self::formatPhoneNumber($targetPhone);
        if (!$phone) {
            return ['success' => false, 'message' => 'Nomor WhatsApp tidak valid'];
        }

        $token = self::getToken();
        if (empty($token)) {
            return [
                'success' => false,
                'message' => 'Gateway otomatis dinonaktifkan (Gunakan pengiriman manual via template wa.me)'
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->timeout(6)->post('https://api.fonnte.com/send', [
                'target'  => $phone,
                'message' => $message,
                'countryCode' => '62',
            ]);

            $result = $response->json();
            if ($response->successful() && isset($result['status']) && $result['status'] === true) {
                return ['success' => true, 'response' => $result];
            }
            return ['success' => false, 'response' => $result];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
