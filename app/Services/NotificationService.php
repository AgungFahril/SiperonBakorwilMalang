<?php

namespace App\Services;

use App\Mail\BookingStatusUpdatedMail;
use App\Mail\BookingSubmittedMail;
use App\Mail\NewBookingAdminMail;
use App\Models\AdminNotification;
use App\Models\Booking;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Collection;
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
     * Kirim notifikasi ketika ada 1 booking baru diajukan (proxy ke notifyAdminNewBookings).
     */
    public function notifyAdminNewBooking(Booking $booking): void
    {
        $this->notifyAdminNewBookings(collect([$booking]));
    }

    /**
     * Kirim notifikasi terkonsolidasi ketika ada 1 atau beberapa booking baru diajukan.
     */
    public function notifyAdminNewBookings($bookings): void
    {
        if ($bookings instanceof Booking) {
            $bookings = collect([$bookings]);
        } elseif (!($bookings instanceof Collection)) {
            $bookings = collect($bookings);
        }

        if ($bookings->isEmpty()) {
            return;
        }

        $first = $bookings->first();
        $count = $bookings->count();

        // 1. Catat ke Database Internal Admin Notification
        try {
            if ($count === 1) {
                AdminNotification::create([
                    'type'       => 'booking_baru',
                    'title'      => 'Pengajuan Peminjaman Baru',
                    'message'    => "Pemohon: {$first->nama_pemohon} (" . ($first->instansi ?: '-') . ")\n"
                                  . "Ruangan: " . ($first->room->name ?? 'Ruangan') . "\n"
                                  . "Tanggal: " . $first->tanggal->format('d/m/Y') . "\n"
                                  . "Jam: {$first->jam_mulai} - {$first->jam_selesai}\n"
                                  . "Kode Booking: {$first->kode_booking}",
                    'booking_id' => $first->id,
                ]);
            } else {
                $detailList = $bookings->map(function ($b, $i) {
                    $rName = $b->room->name ?? 'Ruangan';
                    $tgl = $b->tanggal->format('d/m/Y');
                    return ($i + 1) . ". {$rName} [{$b->kode_booking}]\n   {$tgl} ({$b->jam_mulai} - {$b->jam_selesai} WIB)\n   Kegiatan: {$b->nama_kegiatan}";
                })->implode("\n\n");

                AdminNotification::create([
                    'type'       => 'booking_baru',
                    'title'      => "Pengajuan Peminjaman Baru ({$count} Ruangan)",
                    'message'    => "Pemohon: {$first->nama_pemohon} (" . ($first->instansi ?: '-') . ")\n"
                                  . "Total: {$count} Ruangan\n\n"
                                  . "Daftar Ruangan:\n{$detailList}",
                    'booking_id' => $first->id,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error("Gagal simpan AdminNotification DB: " . $e->getMessage());
        }

        // 2. Kirim Email ke Pemohon
        if (!empty($first->email)) {
            try {
                Mail::to($first->email)->send(new BookingSubmittedMail($bookings));
                Log::info("Email pengajuan terkirim ke pemohon: {$first->email} ({$count} ruangan)");
            } catch (\Throwable $e) {
                Log::error("Gagal kirim email ke pemohon ({$first->email}): " . $e->getMessage());
            }
        }

        // 3. Kirim Email ke Admin
        $adminEmail = $this->getAdminEmail();
        if (!empty($adminEmail)) {
            try {
                Mail::to($adminEmail)->send(new NewBookingAdminMail($bookings));
                Log::info("Email pengajuan baru terkirim ke admin: {$adminEmail} ({$count} ruangan)");
            } catch (\Throwable $e) {
                Log::error("Gagal kirim email ke admin ({$adminEmail}): " . $e->getMessage());
            }
        }

        // 4. Kirim WhatsApp ke Pemohon
        if (!empty($first->no_whatsapp)) {
            if ($count === 1) {
                $pesanWaPemohon = "*SIPERON BAKORWIL III MALANG*\n\n"
                    . "Halo *{$first->nama_pemohon}*,\n"
                    . "Pengajuan peminjaman ruangan Anda telah kami terima.\n\n"
                    . "*Rincian Pengajuan:*\n"
                    . "• Kode Booking: *{$first->kode_booking}*\n"
                    . "• Ruangan: " . ($first->room->name ?? 'Ruangan') . "\n"
                    . "• Tanggal: " . $first->tanggal->translatedFormat('d F Y') . "\n"
                    . "• Waktu: {$first->jam_mulai} - {$first->jam_selesai} WIB\n"
                    . "• Kegiatan: {$first->nama_kegiatan}\n"
                    . "• Jumlah Peserta: " . ($first->jumlah_peserta ? $first->jumlah_peserta . ' Orang' : '-') . "\n"
                    . "• Status: *MENUNGGU PERSETUJUAN*\n\n"
                    . "Simpan kode booking Anda dan pantau status peminjaman melalui tautan berikut:\n"
                    . route('cek.booking.form') . "\n\n"
                    . "_Pesan ini dikirim otomatis oleh SIPERON Bakorwil III Malang._";
            } else {
                $itemsText = "";
                foreach ($bookings as $idx => $b) {
                    $rName = $b->room->name ?? 'Ruangan';
                    $tgl = $b->tanggal->translatedFormat('d F Y');
                    $peserta = $b->jumlah_peserta ? $b->jumlah_peserta . ' Orang' : '-';
                    $itemsText .= ($idx + 1) . ". *{$rName}*\n"
                               . "   • Kode Booking: *{$b->kode_booking}*\n"
                               . "   • Tanggal: {$tgl}\n"
                               . "   • Waktu: {$b->jam_mulai} - {$b->jam_selesai} WIB\n"
                               . "   • Kegiatan: {$b->nama_kegiatan}\n"
                               . "   • Peserta: {$peserta}\n\n";
                }

                $pesanWaPemohon = "*SIPERON BAKORWIL III MALANG*\n\n"
                    . "Halo *{$first->nama_pemohon}*,\n"
                    . "Pengajuan peminjaman ruangan Anda (*{$count} Ruangan*) telah kami terima.\n\n"
                    . "*Rincian Pengajuan Ruangan:*\n"
                    . trim($itemsText) . "\n\n"
                    . "• Status: *MENUNGGU PERSETUJUAN*\n\n"
                    . "Simpan kode booking Anda dan pantau status peminjaman melalui tautan berikut:\n"
                    . route('cek.booking.form') . "\n\n"
                    . "_Pesan ini dikirim otomatis oleh SIPERON Bakorwil III Malang._";
            }

            WhatsAppService::send($first->no_whatsapp, $pesanWaPemohon);
        }

        // 5. Kirim WhatsApp ke Admin (jika nomor admin diisi)
        $adminWa = $this->getAdminWhatsApp();
        if (!empty($adminWa)) {
            if ($count === 1) {
                $pesanWaAdmin = "*[PEMBERITAHUAN] PERMOHONAN PEMINJAMAN BARU (SIPERON)*\n\n"
                    . "• Kode: *{$first->kode_booking}*\n"
                    . "• Pemohon: {$first->nama_pemohon} (" . ($first->instansi ?: '-') . ")\n"
                    . "• Ruangan: " . ($first->room->name ?? 'Ruangan') . "\n"
                    . "• Tanggal: " . $first->tanggal->translatedFormat('d F Y') . "\n"
                    . "• Waktu: {$first->jam_mulai} - {$first->jam_selesai} WIB\n"
                    . "• Keperluan: {$first->nama_kegiatan}\n"
                    . "• Jumlah Peserta: " . ($first->jumlah_peserta ? $first->jumlah_peserta . ' Orang' : '-') . "\n\n"
                    . "Silakan periksa dan verifikasi melalui panel admin:\n"
                    . route('admin.peminjaman.show', $first);
            } else {
                $itemsText = "";
                foreach ($bookings as $idx => $b) {
                    $rName = $b->room->name ?? 'Ruangan';
                    $tgl = $b->tanggal->translatedFormat('d F Y');
                    $itemsText .= ($idx + 1) . ". {$rName} (*{$b->kode_booking}*)\n"
                               . "   {$tgl} | {$b->jam_mulai} - {$b->jam_selesai} WIB\n"
                               . "   Kegiatan: {$b->nama_kegiatan}\n\n";
                }

                $pesanWaAdmin = "*[PEMBERITAHUAN] PERMOHONAN PEMINJAMAN BARU ({$count} RUANGAN)*\n\n"
                    . "• Pemohon: {$first->nama_pemohon} (" . ($first->instansi ?: '-') . ")\n"
                    . "• WhatsApp: {$first->no_whatsapp}\n"
                    . "• Email: {$first->email}\n"
                    . "• Total: {$count} Ruangan\n\n"
                    . "*Daftar Ruangan:*\n"
                    . trim($itemsText) . "\n\n"
                    . "Silakan periksa dan verifikasi melalui panel admin:\n"
                    . route('admin.peminjaman.index');
            }

            WhatsAppService::send($adminWa, $pesanWaAdmin);
        }
    }

    /**
     * Kirim notifikasi ke pemohon ketika status 1 booking berubah.
     */
    public function notifyPemohonStatusChange(Booking $booking, string $statusBaru, ?string $alasan = null): void
    {
        $this->notifyPemohonGroupStatusChange(collect([$booking]), $statusBaru, $alasan);
    }

    /**
     * Kirim notifikasi terkonsolidasi ketika status satu atau kelompok booking diperbarui.
     */
    public function notifyPemohonGroupStatusChange($bookings, string $statusBaru, ?string $alasan = null): void
    {
        if ($bookings instanceof Booking) {
            $bookings = collect([$bookings]);
        } elseif (!($bookings instanceof Collection)) {
            $bookings = collect($bookings);
        }

        if ($bookings->isEmpty()) {
            return;
        }

        $first = $bookings->first();
        $count = $bookings->count();

        // 1. Kirim Email ke Pemohon
        if (!empty($first->email)) {
            try {
                Mail::to($first->email)->send(new BookingStatusUpdatedMail($bookings, $statusBaru, $alasan));
                Log::info("Email status updated ({$statusBaru}) terkirim ke: {$first->email}");
            } catch (\Throwable $e) {
                Log::error("Gagal kirim email update status ke {$first->email}: " . $e->getMessage());
            }
        }

        // 2. Siapkan Pesan WhatsApp sesuai status menggunakan template terpadu
        $pesanWa = WhatsAppService::buildConfirmationMessage($bookings, $statusBaru, $alasan);

        // 3. Simpan log notifikasi di internal database
        try {
            $statusHeader = [
                'disetujui'         => 'DISETUJUI',
                'ditolak'           => 'DITOLAK',
                'dijadwalkan_ulang' => 'PERLU PENJADWALAN ULANG',
                'selesai'           => 'SELESAI',
            ];
            $headerText = $statusHeader[$statusBaru] ?? strtoupper($statusBaru);

            AdminNotification::create([
                'type'       => 'notifikasi_pemohon_' . $statusBaru,
                'title'      => "Notifikasi Status ({$headerText}) Disiapkan untuk Pemohon",
                'message'    => "Kepada: {$first->nama_pemohon} (WA: {$first->no_whatsapp}, Email: {$first->email})\nStatus: {$statusBaru}" . ($alasan ? "\nAlasan: {$alasan}" : ''),
                'booking_id' => $first->id,
            ]);
        } catch (\Throwable $e) {
            Log::error("Gagal simpan AdminNotification DB: " . $e->getMessage());
        }
    }
}
