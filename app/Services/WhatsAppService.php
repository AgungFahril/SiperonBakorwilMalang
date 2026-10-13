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
                Log::info("WhatsApp berhasil terkirim ke {$phone}");
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
