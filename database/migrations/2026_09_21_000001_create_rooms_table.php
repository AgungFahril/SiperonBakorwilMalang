<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // Ruang Arjuno
            $table->string('slug')->unique();        // ruang-arjuno
            $table->unsignedInteger('capacity');      // 80
            $table->text('facilities')->nullable();   // Meja Besar, Layar LED, ...
            $table->string('image')->nullable();      // path file di storage
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
