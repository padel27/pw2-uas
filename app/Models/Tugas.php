<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi lewat mass-assignment (create, update)
    protected $fillable = [
        'nama_tugas',
        'kategori_id',
        'prioritas',
        'tenggat_waktu',
        'user_id',
        'selesai',
    ];

    // Relasi ke User (setiap tugas dimiliki oleh 1 user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kategori (opsional)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
