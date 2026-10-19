<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'kode_booking',
        'nama_kegiatan',
        'jumlah_peserta',
        'nama_pemohon',
        'instansi',
        'kontak',
        'no_whatsapp',
        'email',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
        'catatan',
        'keterangan',
        'surat_pengajuan',
        'admin_id',
        'approved_at',
    ];

    protected $casts = [
        'tanggal'     => 'date',
        'approved_at' => 'datetime',
    ];

    /**
     * Generate kode booking unik: BR-YYYYMMDD-XXXX
     */
    public static function generateKodeBooking(): string
    {
        $date = now()->format('Ymd');
        $prefix = 'BR-' . $date . '-';

        $lastBooking = static::where('kode_booking', 'like', $prefix . '%')
            ->orderBy('kode_booking', 'desc')
            ->first();

        if ($lastBooking) {
            $lastNumber = (int) substr($lastBooking->kode_booking, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(BookingHistory::class)->orderBy('created_at', 'desc');
    }
}
