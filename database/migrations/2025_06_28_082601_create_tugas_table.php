<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tugas'); // Kolom untuk nama tugasnya
            $table->text('deskripsi')->nullable(); // Kolom untuk deskripsi (opsional)
            $table->boolean('selesai')->default(false); // Status tugas, defaultnya "belum selesai"
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};