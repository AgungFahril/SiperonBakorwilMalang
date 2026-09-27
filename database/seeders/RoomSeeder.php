<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'name'        => 'Ruang Arjuno',
                'capacity'    => 80,
                'facilities'  => 'Meja Besar, Layar LED, Sound System, Pendingin Ruangan, WiFi',
                'description' => 'Ruang representatif untuk rapat besar, seminar, dan kegiatan koordinasi skala luas.',
                'image'       => 'rooms/ruang-arjuno.jpg',
            ],
            [
                'name'        => 'Ruang Panderman',
                'capacity'    => 30,
                'facilities'  => 'Meja, LED Proyektor, Sound System, Pendingin Ruangan, WiFi',
                'description' => 'Cocok untuk rapat kelompok kerja dan pertemuan skala menengah.',
                'image'       => 'rooms/ruang-panderman.jpg',
            ],
            [
                'name'        => 'Ruang Semeru',
                'capacity'    => 25,
                'facilities'  => 'Meja, LED Proyektor, Sound System, Pendingin Ruangan, WiFi',
                'description' => 'Ruang pertemuan untuk diskusi dan koordinasi tim.',
                'image'       => 'rooms/ruang-semeru.jpg',
            ],
            [
                'name'        => 'Meeting Room EJSC',
                'capacity'    => 20,
                'facilities'  => 'Meja Rapat, Layar Presentasi, Sound System, Pendingin Ruangan, WiFi',
                'description' => 'Ruang rapat representatif di gedung EJSC untuk kegiatan koordinasi dan diskusi.',
                'image'       => 'rooms/meeting-room-ejsc.jpg',
            ],
            [
                'name'        => 'Co-Working Space EJSC',
                'capacity'    => 40,
                'facilities'  => 'Meja Kerja Bersama, Colokan Listrik, WiFi Cepat, Area Santai',
                'description' => 'Ruang kerja bersama yang nyaman untuk kegiatan kolaboratif dan diskusi santai.',
                'image'       => 'rooms/coworking-space-ejsc.jpg',
            ],
            [
                'name'        => 'Command Center EJSC',
                'capacity'    => 15,
                'facilities'  => 'Layar Monitoring, Perangkat Command Center, Sound System, Pendingin Ruangan, WiFi',
                'description' => 'Ruang kendali dan monitoring untuk kegiatan koordinasi strategis.',
                'image'       => 'rooms/command-center-ejsc.jpg',
            ],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(
                ['name' => $room['name']], // hindari duplikat kalau seeder dijalankan ulang
                $room + ['is_active' => true]
            );
        }
    }
}