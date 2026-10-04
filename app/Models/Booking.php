<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
        'nama_kegiatan',
        'nama_pemohon',
        'instansi',
        'kontak',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
        'catatan',
        'surat_pengajuan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
