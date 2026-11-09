<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('group_code', 30)->nullable()->index()->after('kode_booking');
        });

        // Set group_code default untuk data yang sudah ada sebelumnya
        DB::statement("UPDATE bookings SET group_code = kode_booking WHERE group_code IS NULL AND kode_booking IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('group_code');
        });
    }
};

