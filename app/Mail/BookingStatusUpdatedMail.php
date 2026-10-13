<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public string $statusBaru;
    public ?string $alasan;

    public function __construct(Booking $booking, string $statusBaru, ?string $alasan = null)
    {
        $this->booking = $booking;
        $this->statusBaru = $statusBaru;
        $this->alasan = $alasan;
    }

    public function build()
    {
        $statusLabels = [
            'disetujui'         => 'DISETUJUI ✅',
            'ditolak'           => 'DITOLAK ❌',
            'dijadwalkan_ulang' => 'PERLU PENJADWALAN ULANG ⚠️',
            'selesai'           => 'SELESAI 🏁',
        ];

        $label = $statusLabels[$this->statusBaru] ?? strtoupper($this->statusBaru);

        return $this->subject("Update Status Peminjaman [{$label}] - {$this->booking->kode_booking}")
                    ->view('emails.booking-status-updated');
    }
}
