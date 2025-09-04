<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->string('prioritas')->default('Rendah')->after('status'); 
            $table->date('tenggat_waktu')->nullable()->after('prioritas'); 
        });
    }

    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->dropColumn(['prioritas', 'tenggat_waktu']);
        });
    }
};