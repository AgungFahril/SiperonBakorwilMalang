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

    public function images(): HasMany
    {
        return $this->hasMany(RoomImage::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Dapatkan daftar fasilitas sebagai array rapi
     */
    public function getFacilitiesListAttribute(): array
    {
        if (empty($this->facilities)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $this->facilities))));
    }

    // Daftar tanggal yang sudah disetujui/terpakai (dipakai kalender publik)
    public function bookedDates()
    {
        return $this->bookings()
            ->where('status', 'disetujui')
            ->pluck('tanggal');
    }
}
