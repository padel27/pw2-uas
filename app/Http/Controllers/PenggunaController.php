<?php

namespace App\Http\Controllers;

use App\Models\User; // <-- Jangan lupa import model User
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        // Ambil semua data pengguna, kecuali akun admin itu sendiri
        $users = User::where('email', '!=', 'admin@daftartugas.com')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('pengguna.index', ['users' => $users]);
    }
}