<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat admin user
        User::updateOrCreate(
            ['email' => 'admin@bakorwil3.go.id'],
            [
                'name'     => 'Admin Bakorwil',
                'password' => Hash::make('password'),
            ]
        );

        // Seed rooms dulu
        $this->call(RoomSeeder::class);

        // Seed sample bookings
        $this->call(BookingSeeder::class);
    }
}
