<?php

namespace App\Services;

use App\Models\Setting;
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
     * Dapatkan API Token Fonnte / Gateway dari Setting DB atau .env.
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
     * Dapatkan status koneksi perangkat dari Fonnte API.
     */
    public static function getDeviceStatus(): array
    {
        $token = self::getToken();
        if (empty($token)) {
            return [
                'configured' => false,
                'connected'  => false,
                'status'     => 'no_token',
                'message'    => 'Token belum diisi'
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->timeout(6)->post('https://api.fonnte.com/device');

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
                    'message'       => ($devStatus === 'connect') ? 'Terhubung (Online)' : 'Terputus (Belum Scan QR / Disconnected)',
                ];
            }

            return [
                'configured' => true,
                'connected'  => false,
                'status'     => 'invalid',
                'message'    => $result['reason'] ?? 'Token tidak valid atau gagal terhubung ke Fonnte'
            ];
        } catch (\Throwable $e) {
            return [
                'configured' => true,
                'connected'  => false,
                'status'     => 'error',
                'message'    => 'Koneksi ke server Fonnte timeout / error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Kirim pesan WhatsApp otomatis via Fonnte Gateway.
     */
    public static function send(string $targetPhone, string $message): array
    {
        $phone = self::formatPhoneNumber($targetPhone);
        if (!$phone) {
            return ['success' => false, 'message' => 'Nomor WhatsApp tidak valid'];
        }

        $token = self::getToken();

        if (empty($token)) {
            Log::info("WhatsApp Gateway: Token belum diisi. Pesan tidak dikirim via API ke {$phone}.", [
                'preview' => substr($message, 0, 100)
            ]);
            return [
                'success' => false,
                'message' => 'Token WhatsApp Gateway belum dikonfigurasi di Pengaturan atau .env'
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->timeout(10)->post('https://api.fonnte.com/send', [
                'target'  => $phone,
                'message' => $message,
                'countryCode' => '62',
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status'] === true) {
                Log::info("WhatsApp berhasil dikirim ke {$phone}: " . ($result['detail'] ?? 'OK'));
                return ['success' => true, 'response' => $result];
            } else {
                Log::warning("Gagal mengirim WhatsApp ke {$phone}: " . ($result['reason'] ?? $response->body()));
                return ['success' => false, 'response' => $result];
            }
        } catch (\Throwable $e) {
            Log::error("Exception saat kirim WhatsApp ke {$phone}: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Buat URL wa.me untuk fallback 1-klik buka WhatsApp Web/App.
     */
    public static function generateWaLink(string $targetPhone, string $message): string
    {
        $phone = self::formatPhoneNumber($targetPhone);
        return "https://wa.me/{$phone}?text=" . rawurlencode($message);
    }
}
