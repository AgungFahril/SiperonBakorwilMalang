<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'capacity',
        'facilities',
        'image',
        'description',
        'is_active',
    ];

    protected static function booted(): void
    {
        static::creating(function (Room $room) {
            if (empty($room->slug)) {
                $room->slug = Str::slug($room->name);
            }
        });
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Daftar tanggal yang sudah disetujui/terpakai (dipakai kalender publik)
    public function bookedDates()
    {
        return $this->bookings()
            ->where('status', 'disetujui')
            ->pluck('tanggal');
    }
}
