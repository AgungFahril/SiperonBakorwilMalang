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
        'group_code',
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

    /**
     * Generate kode pengajuan kelompok (group_code): PG-YYYYMMDD-XXXX
     */
    public static function generateGroupCode(): string
    {
        $date = now()->format('Ymd');
        $prefix = 'PG-' . $date . '-';

        $lastGroup = static::where('group_code', 'like', $prefix . '%')
            ->orderBy('group_code', 'desc')
            ->first();

        if ($lastGroup) {
            $lastNumber = (int) substr($lastGroup->group_code, -4);
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

    /**
     * Semua booking yang berada dalam 1 kelompok / paket pengajuan yang sama
     */
    public function groupBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'group_code', 'group_code')->with('room');
    }

    /**
     * Apakah booking ini bagian dari pengajuan multi-ruangan?
     */
    public function isMultiRoom(): bool
    {
        if (!$this->group_code) return false;
        return static::where('group_code', $this->group_code)->count() > 1;
    }
}
