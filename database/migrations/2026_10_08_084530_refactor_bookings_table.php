<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('kode_booking')->unique()->nullable()->after('id');
            $table->string('no_whatsapp')->nullable()->after('kontak');
            $table->string('email')->nullable()->after('no_whatsapp');
            $table->text('keterangan')->nullable()->after('catatan');
            $table->foreignId('admin_id')->nullable()->after('status')->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable()->after('admin_id');
        });

        // Ubah enum status agar mendukung 'dijadwalkan_ulang'
        // Karena Laravel/MySQL tidak mudah alter enum, kita ubah ke string
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('status', 30)->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn(['kode_booking', 'no_whatsapp', 'email', 'keterangan', 'admin_id', 'approved_at']);
        });
    }
};
