<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_tugas',
        'user_id',
        'kategori_id',
    ];

    /**
     * Mendefinisikan relasi bahwa setiap tugas dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
{
    return $this->belongsTo(Kategori::class);
}
}