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
        // Tambahkan foreign key 'kategori_id' setelah 'user_id'
        // Boleh null karena mungkin ada tugas yang tidak memiliki kategori
        $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('tugas', function (Blueprint $table) {
        $table->dropForeign(['kategori_id']);
        $table->dropColumn('kategori_id');
    });
}

};