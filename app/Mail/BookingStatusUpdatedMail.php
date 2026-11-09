<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class BookingStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public Collection $bookings;
    public string $statusBaru;
    public ?string $alasan;

    public function __construct($bookingOrBookings, string $statusBaru, ?string $alasan = null)
    {
        if ($bookingOrBookings instanceof Booking) {
            $this->booking = $bookingOrBookings;
            $this->bookings = collect([$bookingOrBookings]);
        } elseif ($bookingOrBookings instanceof Collection) {
            $this->bookings = $bookingOrBookings;
            $this->booking = $bookingOrBookings->first();
        } else {
            $this->bookings = collect($bookingOrBookings);
            $this->booking = $this->bookings->first();
        }

        $this->statusBaru = $statusBaru;
        $this->alasan = $alasan;
    }

    public function build()
    {
        $statusLabels = [
            'disetujui'         => 'DISETUJUI',
            'ditolak'           => 'DITOLAK',
            'dijadwalkan_ulang' => 'PERLU PENJADWALAN ULANG',
            'selesai'           => 'SELESAI',
        ];

        $label = $statusLabels[$this->statusBaru] ?? strtoupper($this->statusBaru);
        $count = $this->bookings->count();

        $subject = $count > 1
            ? "Update Status Peminjaman [{$label}] - {$count} Ruangan ({$this->booking->group_code})"
            : "Update Status Peminjaman [{$label}] - " . ($this->booking ? $this->booking->kode_booking : '');

        return $this->subject($subject)
                    ->view('emails.booking-status-updated');
    }
}
