<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class NewBookingAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public Collection $bookings;

    public function __construct($bookingOrBookings)
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
    }

    public function build()
    {
        $count = $this->bookings->count();
        $nama = $this->booking ? $this->booking->nama_pemohon : 'Pemohon';
        $subject = $count > 1
            ? '[SIPERON] Permohonan Peminjaman Ruangan Baru (' . $count . ' Ruangan) - ' . $nama
            : '[SIPERON] Permohonan Peminjaman Ruangan Baru - ' . ($this->booking ? $this->booking->kode_booking : '');

        return $this->subject($subject)->view('emails.new-booking-admin');
    }
}
