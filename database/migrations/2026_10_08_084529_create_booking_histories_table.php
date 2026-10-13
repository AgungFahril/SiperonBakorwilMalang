<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('status_sebelumnya', 30)->nullable();
            $table->string('status_baru', 30);
            $table->date('tanggal_sebelumnya')->nullable();
            $table->date('tanggal_baru')->nullable();
            $table->time('jam_mulai_sebelumnya')->nullable();
            $table->time('jam_selesai_sebelumnya')->nullable();
            $table->text('alasan')->nullable();
            $table->text('perubahan')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_histories');
    }
};
