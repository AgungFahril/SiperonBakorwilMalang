<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'status_sebelumnya',
        'status_baru',
        'tanggal_sebelumnya',
        'tanggal_baru',
        'jam_mulai_sebelumnya',
        'jam_selesai_sebelumnya',
        'alasan',
        'perubahan',
        'admin_id',
    ];

    protected $casts = [
        'tanggal_sebelumnya' => 'date',
        'tanggal_baru'       => 'date',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
