<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JadwalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda bisa mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan ditugaskan
| ke grup middleware "web".
|
*/

// 1. Mengalihkan halaman utama ('/') ke halaman login.
Route::get('/', function () {
    return redirect()->route('login');
});


// 2. Mengelompokkan semua rute yang memerlukan login.
//    Hanya user yang sudah login dan terverifikasi yang bisa mengakses rute di dalam grup ini.
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Rute untuk PROFIL (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk DASHBOARD (Menampilkan semua tugas)
    Route::get('/dashboard', [JadwalController::class, 'index'])->name('dashboard');

    // Rute untuk MENYIMPAN tugas baru
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');

    // Rute untuk MENAMPILKAN HALAMAN EDIT tugas
    Route::get('/jadwal/{tugas}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');

    // Rute untuk MEMPROSES UPDATE nama tugas dari form edit
    Route::put('/jadwal/{tugas}', [JadwalController::class, 'update'])->name('jadwal.update');

    // Rute untuk MENGHAPUS tugas
    Route::delete('/jadwal/{tugas}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

    // Rute untuk MENGUBAH STATUS tugas menjadi selesai
    Route::patch('/jadwal/{tugas}/status', [JadwalController::class, 'updateStatus'])->name('jadwal.updateStatus');
});


// 3. Memuat semua rute untuk autentikasi (login, register, logout, dll.)
require __DIR__.'/auth.php';