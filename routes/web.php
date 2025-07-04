<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenggunaController;

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

// 1. Redirect halaman utama ('/') ke halaman login.
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Rute-rute yang memerlukan autentikasi dan verifikasi email
Route::middleware(['auth', 'verified'])->group(function () {

    // Rute untuk PROFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk DASHBOARD (lihat semua tugas)
    Route::get('/dashboard', [TugasController::class, 'index'])->name('dashboard');

    // CRUD untuk TUGAS
    Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
    Route::get('/tugas/{tugas}/edit', [TugasController::class, 'edit'])->name('tugas.edit');
    Route::put('/tugas/{tugas}', [TugasController::class, 'update'])->name('tugas.update');
    Route::delete('/tugas/{tugas}', [TugasController::class, 'destroy'])->name('tugas.destroy');
    Route::patch('/tugas/{tugas}/status', [TugasController::class, 'updateStatus'])->name('tugas.updateStatus');

    // Halaman Riwayat Tugas
    Route::get('/riwayat', [TugasController::class, 'history'])->name('riwayat.history');

    // Rute khusus untuk ADMIN
    Route::middleware('admin')->group(function () {

        // Daftar Pengguna
        Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');

        // CRUD untuk KATEGORI
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    });
});

// 3. Memuat semua rute autentikasi (login, register, dll.)
require __DIR__.'/auth.php';