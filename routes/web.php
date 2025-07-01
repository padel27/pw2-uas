<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TugasController;

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
    Route::get('/dashboard', [TugasController::class, 'index'])->name('dashboard');

    // Rute untuk MENYIMPAN tugas baru
    Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');

    // Rute untuk MENAMPILKAN HALAMAN EDIT tugas
    Route::get('/tugas/{tugas}/edit', [TugasController::class, 'edit'])->name('tugas.edit');

    // Rute untuk MEMPROSES UPDATE nama tugas dari form edit
    Route::put('/tugas/{tugas}', [TugasController::class, 'update'])->name('tugas.update');

    // Rute untuk MENGHAPUS tugas
    Route::delete('/tugas/{tugas}', [TugasController::class, 'destroy'])->name('tugas.destroy');

    // Rute untuk MENGUBAH STATUS tugas menjadi selesai
    Route::patch('/tugas/{tugas}/status', [TugasController::class, 'updateStatus'])->name('tugas.updateStatus');

    Route::middleware(['auth', 'verified'])->group(function () {

    // ... (rute untuk profile, dashboard, store, edit, dll.)

    // RUTE BARU UNTUK HALAMAN RIWAYAT
    Route::get('/riwayat', [TugasController::class, 'history'])->name('riwayat.history');
});


});


// 3. Memuat semua rute untuk autentikasi (login, register, logout, dll.)
require __DIR__.'/auth.php';