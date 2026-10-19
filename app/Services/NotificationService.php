<?php

namespace App\Services;

use App\Mail\BookingStatusUpdatedMail;
use App\Mail\BookingSubmittedMail;
use App\Mail\NewBookingAdminMail;
use App\Models\AdminNotification;
use App\Models\Booking;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Dapatkan email tujuan admin (dari Setting, User admin, atau env).
     */
    protected function getAdminEmail(): ?string
    {
        $settingEmail = Setting::where('key', 'email_admin_notification')->value('value');
        if (!empty($settingEmail)) {
            return trim($settingEmail);
        }

        $adminUser = User::where('role', 'admin')->first();
        if ($adminUser && !empty($adminUser->email)) {
            return $adminUser->email;
        }

        return env('ADMIN_EMAIL', 'admin@bakorwil3.go.id');
    }

    /**
     * Dapatkan nomor WA admin (dari Setting atau env).
     */
    protected function getAdminWhatsApp(): ?string
    {
        $settingPhone = Setting::where('key', 'wa_admin_phone')->value('value');
        if (!empty($settingPhone)) {
            return trim($settingPhone);
        }

        return env('ADMIN_WA_PHONE');
    }

    /**
     * Kirim notifikasi ketika ada booking baru diajukan.
     * Mengirim ke:
     * 1. Internal DB (AdminNotification)
     * 2. Email Pemohon (konfirmasi & kode booking)
     * 3. Email Admin (pemberitahuan ada permohonan baru)
     * 4. WhatsApp Pemohon (konfirmasi & kode booking)
     * 5. WhatsApp Admin (pemberitahuan permohonan baru jika no WA admin diatur)
     */
    public function notifyAdminNewBooking(Booking $booking): void
    {
        // 1. Catat ke Database Internal Admin Notification
        try {
            AdminNotification::create([
                'type'       => 'booking_baru',
                'title'      => 'Pengajuan Peminjaman Baru',
                'message'    => "Pemohon: {$booking->nama_pemohon}\n"
                              . "Ruangan: {$booking->room->name}\n"
                              . "Tanggal: {$booking->tanggal->format('d/m/Y')}\n"
                              . "Jam: {$booking->jam_mulai} - {$booking->jam_selesai}\n"
                              . "Kode Booking: {$booking->kode_booking}",
                'booking_id' => $booking->id,
            ]);
        } catch (\Throwable $e) {
            Log::error("Gagal simpan AdminNotification DB: " . $e->getMessage());
        }

        // 2. Kirim Email ke Pemohon
        if (!empty($booking->email)) {
            try {
                Mail::to($booking->email)->send(new BookingSubmittedMail($booking));
                Log::info("Email pengajuan terkirim ke pemohon: {$booking->email}");
            } catch (\Throwable $e) {
                Log::error("Gagal kirim email ke pemohon ({$booking->email}): " . $e->getMessage());
            }
        }

        // 3. Kirim Email ke Admin
        $adminEmail = $this->getAdminEmail();
        if (!empty($adminEmail)) {
            try {
                Mail::to($adminEmail)->send(new NewBookingAdminMail($booking));
                Log::info("Email pengajuan baru terkirim ke admin: {$adminEmail}");
            } catch (\Throwable $e) {
                Log::error("Gagal kirim email ke admin ({$adminEmail}): " . $e->getMessage());
            }
        }

        // 4. Kirim WhatsApp ke Pemohon
        if (!empty($booking->no_whatsapp)) {
            $pesanWaPemohon = "*SIPERON BAKORWIL III MALANG*\n\n"
                . "Halo *{$booking->nama_pemohon}*,\n"
                . "Pengajuan peminjaman ruangan Anda telah kami terima.\n\n"
                . "*Rincian Pengajuan:*\n"
                . "• Kode Booking: *{$booking->kode_booking}*\n"
                . "• Ruangan: {$booking->room->name}\n"
                . "• Tanggal: {$booking->tanggal->translatedFormat('d F Y')}\n"
                . "• Waktu: {$booking->jam_mulai} - {$booking->jam_selesai} WIB\n"
                . "• Kegiatan: {$booking->nama_kegiatan}\n"
                . "• Jumlah Peserta: " . ($booking->jumlah_peserta ? $booking->jumlah_peserta . ' Orang' : '-') . "\n"
                . "• Status: *MENUNGGU PERSETUJUAN*\n\n"
                . "Simpan kode booking Anda dan pantau status peminjaman melalui tautan berikut:\n"
                . route('cek.booking.form') . "\n\n"
                . "_Pesan ini dikirim otomatis oleh SIPERON Bakorwil III Malang._";

            WhatsAppService::send($booking->no_whatsapp, $pesanWaPemohon);
        }

        // 5. Kirim WhatsApp ke Admin (jika nomor admin diisi)
        $adminWa = $this->getAdminWhatsApp();
        if (!empty($adminWa)) {
            $pesanWaAdmin = "*[PEMBERITAHUAN] PERMOHONAN PEMINJAMAN BARU (SIPERON)*\n\n"
                . "• Kode: *{$booking->kode_booking}*\n"
                . "• Pemohon: {$booking->nama_pemohon} (" . ($booking->instansi ?: '-') . ")\n"
                . "• Ruangan: {$booking->room->name}\n"
                . "• Tanggal: {$booking->tanggal->translatedFormat('d F Y')}\n"
                . "• Waktu: {$booking->jam_mulai} - {$booking->jam_selesai} WIB\n"
                . "• Keperluan: {$booking->nama_kegiatan}\n"
                . "• Jumlah Peserta: " . ($booking->jumlah_peserta ? $booking->jumlah_peserta . ' Orang' : '-') . "\n\n"
                . "Silakan periksa dan verifikasi melalui panel admin:\n"
                . route('admin.peminjaman.show', $booking);

            WhatsAppService::send($adminWa, $pesanWaAdmin);
        }
    }

    /**
     * Kirim notifikasi ke pemohon ketika status permohonan berubah.
     * Mengirim ke:
     * 1. Email Pemohon (status baru & alasan)
     * 2. WhatsApp Pemohon (status baru & alasan)
     * 3. Catatan log di internal DB
     */
    public function notifyPemohonStatusChange(Booking $booking, string $statusBaru, ?string $alasan = null): void
    {
        // 1. Kirim Email ke Pemohon
        if (!empty($booking->email)) {
            try {
                Mail::to($booking->email)->send(new BookingStatusUpdatedMail($booking, $statusBaru, $alasan));
                Log::info("Email status updated ({$statusBaru}) terkirim ke: {$booking->email}");
            } catch (\Throwable $e) {
                Log::error("Gagal kirim email update status ke {$booking->email}: " . $e->getMessage());
            }
        }

        // 2. Siapkan Pesan WhatsApp sesuai status
        $statusHeader = [
            'disetujui'         => 'DISETUJUI',
            'ditolak'           => 'DITOLAK',
            'dijadwalkan_ulang' => 'PERLU PENJADWALAN ULANG',
            'selesai'           => 'SELESAI',
        ];

        $headerText = $statusHeader[$statusBaru] ?? strtoupper($statusBaru);

        $pesanWa = "*SIPERON BAKORWIL III MALANG*\n\n"
            . "Halo *{$booking->nama_pemohon}*,\n"
            . "Status peminjaman ruangan Anda (*{$booking->kode_booking}*) telah diperbarui menjadi:\n\n"
            . "*STATUS: {$headerText}*\n\n"
            . "*Rincian Acara:*\n"
            . "• Ruangan: {$booking->room->name}\n"
            . "• Tanggal: {$booking->tanggal->translatedFormat('d F Y')}\n"
            . "• Waktu: {$booking->jam_mulai} - {$booking->jam_selesai} WIB\n"
            . "• Kegiatan: {$booking->nama_kegiatan}\n"
            . "• Jumlah Peserta: " . ($booking->jumlah_peserta ? $booking->jumlah_peserta . ' Orang' : '-') . "\n";

        if ($statusBaru === 'disetujui') {
            $pesanWa .= "\nSelamat, pengajuan Anda telah disetujui! Silakan hadir tepat waktu sesuai jadwal yang telah ditentukan.";
        } elseif ($statusBaru === 'dijadwalkan_ulang') {
            $pesanWa .= "\nMohon maaf, jadwal perlu disesuaikan kembali karena agenda prioritas instansi."
                     . ($alasan ? "\n*Alasan:* {$alasan}" : '')
                     . "\nSilakan ajukan permohonan baru untuk memilih tanggal alternatif lain yang tersedia di: " . route('home') . "#ruangan";
        } elseif ($statusBaru === 'ditolak') {
            $pesanWa .= "\nMohon maaf, permohonan belum dapat disetujui."
                     . ($alasan ? "\n*Alasan:* {$alasan}" : '');
        }

        $pesanWa .= "\n\nCek rincian status lengkap di:\n" . route('cek.booking.form');

        // Kirim WhatsApp jika nomor ada
        if (!empty($booking->no_whatsapp)) {
            $waRes = WhatsAppService::send($booking->no_whatsapp, $pesanWa);
            if (!($waRes['success'] ?? false)) {
                Log::warning("Pengiriman WA update status ke {$booking->no_whatsapp} tidak berhasil: " . json_encode($waRes));
            }
        }

        // 3. Simpan log notifikasi di internal database
        try {
            AdminNotification::create([
                'type'       => 'notifikasi_pemohon_' . $statusBaru,
                'title'      => 'Notifikasi Status Dikirim ke Pemohon',
                'message'    => "Kepada: {$booking->nama_pemohon} (WA: {$booking->no_whatsapp}, Email: {$booking->email})\nStatus: {$statusBaru}" . ($alasan ? "\nAlasan: {$alasan}" : ''),
                'booking_id' => $booking->id,
            ]);
        } catch (\Throwable $e) {
            Log::error("Gagal simpan AdminNotification DB: " . $e->getMessage());
        }
    }
}
