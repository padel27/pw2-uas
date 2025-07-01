<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            // Menambahkan foreign key 'user_id'
            // 'foreignId' membuat kolom bigint unsigned
            // 'constrained' merujuk ke tabel 'users' secara otomatis
            // 'cascadeOnDelete' akan menghapus semua tugas milik user jika user tersebut dihapus
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            // Hapus foreign key dan kolomnya jika di-rollback
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};