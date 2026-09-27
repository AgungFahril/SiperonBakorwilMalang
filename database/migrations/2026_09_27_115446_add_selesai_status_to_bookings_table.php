<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambah 'selesai' ke enum status pada tabel bookings.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'disetujui', 'ditolak', 'selesai') DEFAULT 'pending'");
    }

    /**
     * Kembalikan ke enum semula.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'disetujui', 'ditolak') DEFAULT 'pending'");
    }
};
