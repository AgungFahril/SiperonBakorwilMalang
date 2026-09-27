<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();

        if ($rooms->isEmpty()) {
            return;
        }

        $bookings = [
            [
                'room_id'        => $rooms[0]->id ?? 1,
                'nama_kegiatan'  => 'Rapat Koordinasi Evaluasi Pendidikan',
                'nama_pemohon'   => 'Bpk. Budi Santoso',
                'instansi'       => 'Dinas Pendidikan Prov Jatim',
                'kontak'         => '08123456789',
                'tanggal'        => Carbon::today()->addDays(2),
                'jam_mulai'      => '09:00',
                'jam_selesai'    => '15:00',
                'status'         => 'pending',
            ],
            [
                'room_id'        => $rooms[1]->id ?? 2,
                'nama_kegiatan'  => 'Sosialisasi Program Digital',
                'nama_pemohon'   => 'Ibu Rina Susanti',
                'instansi'       => 'Dinas Kominfo Malang',
                'kontak'         => '08234567890',
                'tanggal'        => Carbon::today()->addDays(3),
                'jam_mulai'      => '08:00',
                'jam_selesai'    => '12:00',
                'status'         => 'disetujui',
            ],
            [
                'room_id'        => $rooms[2]->id ?? 3,
                'nama_kegiatan'  => 'Seminar Nasional Teknologi',
                'nama_pemohon'   => 'Panitia Seminar Nasional',
                'instansi'       => 'Universitas Brawijaya',
                'kontak'         => '08345678901',
                'tanggal'        => Carbon::today()->subDays(3),
                'jam_mulai'      => '13:00',
                'jam_selesai'    => '16:00',
                'status'         => 'ditolak',
                'catatan'        => 'Ruangan sedang dalam renovasi pada tanggal tersebut.',
            ],
            [
                'room_id'        => $rooms[0]->id ?? 1,
                'nama_kegiatan'  => 'FGD Pariwisata Jawa Timur',
                'nama_pemohon'   => 'Bpk. Agus Widodo',
                'instansi'       => 'Dinas Pariwisata Jatim',
                'kontak'         => '08456789012',
                'tanggal'        => Carbon::today()->addDays(5),
                'jam_mulai'      => '09:00',
                'jam_selesai'    => '12:00',
                'status'         => 'disetujui',
            ],
            [
                'room_id'        => $rooms[0]->id ?? 1,
                'nama_kegiatan'  => 'Rapat Mitigasi Bencana',
                'nama_pemohon'   => 'Ibu Dewi Anggraini',
                'instansi'       => 'BPBD Kota Malang',
                'kontak'         => '08567890123',
                'tanggal'        => Carbon::today()->addDays(7),
                'jam_mulai'      => '10:00',
                'jam_selesai'    => '14:00',
                'status'         => 'pending',
            ],
            [
                'room_id'        => $rooms[1]->id ?? 2,
                'nama_kegiatan'  => 'Workshop Teknologi Informasi',
                'nama_pemohon'   => 'Dr. Hendra Pratama',
                'instansi'       => 'Politeknik Negeri Malang',
                'kontak'         => '08678901234',
                'tanggal'        => Carbon::today()->addDays(10),
                'jam_mulai'      => '08:00',
                'jam_selesai'    => '16:00',
                'status'         => 'pending',
            ],
            [
                'room_id'        => $rooms[2]->id ?? 3,
                'nama_kegiatan'  => 'Pertemuan Internal Kejaksaan',
                'nama_pemohon'   => 'Bpk. Eko Prasetyo',
                'instansi'       => 'Kejaksaan Negeri Malang',
                'kontak'         => '08789012345',
                'tanggal'        => Carbon::today()->subDays(5),
                'jam_mulai'      => '09:00',
                'jam_selesai'    => '11:00',
                'status'         => 'selesai',
            ],
            [
                'room_id'        => $rooms->count() > 3 ? $rooms[3]->id : $rooms[0]->id,
                'nama_kegiatan'  => 'Pelatihan ASN Digital',
                'nama_pemohon'   => 'Ibu Sri Wahyuni',
                'instansi'       => 'BKD Provinsi Jawa Timur',
                'kontak'         => '08890123456',
                'tanggal'        => Carbon::today(),
                'jam_mulai'      => '08:00',
                'jam_selesai'    => '15:00',
                'status'         => 'disetujui',
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::updateOrCreate(
                [
                    'nama_kegiatan' => $booking['nama_kegiatan'],
                    'tanggal'       => $booking['tanggal'],
                ],
                $booking
            );
        }
    }
}
