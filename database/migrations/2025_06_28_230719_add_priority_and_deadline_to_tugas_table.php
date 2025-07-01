<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            // Tambahkan kolom baru setelah kolom 'selesai'
            $table->string('prioritas')->default('Rendah')->after('selesai');
            $table->date('tenggat_waktu')->nullable()->after('prioritas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $table->dropColumn(['prioritas', 'tenggat_waktu']);
        });
    }
};