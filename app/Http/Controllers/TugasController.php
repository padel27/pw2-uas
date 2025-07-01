<?php

// app/Http/Controllers/JadwalController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;

class TugasController extends Controller
{
/**
 * Menampilkan dashboard.
 * Logika berbeda untuk Admin dan User biasa.
 */
public function index()
{
    $user = auth()->user();
    $daftar_tugas = [];

    if ($user->isAdmin()) {
        // Jika Admin, ambil SEMUA tugas dan data pemiliknya (user)
        // with('user') adalah untuk Eager Loading, sangat penting untuk performa
        $daftar_tugas = Tugas::with('user')->orderBy('created_at', 'desc')->get();
    } else {
        // Jika User biasa, ambil hanya tugas miliknya
        $daftar_tugas = $user->tugas()->orderBy('created_at', 'desc')->get();
    }

    return view('dashboard', [
        'semua_tugas' => $daftar_tugas
    ]);
}

    // Menyimpan tugas baru
    /**
 * Menyimpan tugas baru ke database dan mengaitkannya dengan pengguna yang login.
 */
public function store(Request $request)
{
    $validated = $request->validate(['nama_tugas' => 'required|string|max:255']);

    // SEBELUM: Tugas::create($request->only('nama_tugas'));
    // SESUDAH: Membuat tugas melalui relasi, 'user_id' akan terisi otomatis
    auth()->user()->tugas()->create($validated);

    return back()->with('success', 'Tugas baru berhasil ditambahkan!');
}

    // METHOD BARU: Menampilkan halaman form edit
    public function edit(Tugas $tugas)
    {
        return view('tugas.edit', ['tugas' => $tugas]);
    }

    // METHOD BARU: Memproses update data dari form edit
    public function update(Request $request, Tugas $tugas)
    {
        $request->validate(['nama_tugas' => 'required|string|max:255']);
        $tugas->update($request->only('nama_tugas'));
        return redirect()->route('dashboard')->with('success', 'Tugas berhasil diperbarui!');
    }

    // METHOD BARU: Menghapus tugas
    public function destroy(Tugas $tugas)
    {
        $tugas->delete();
        return back()->with('success', 'Tugas berhasil dihapus!');
    }

    // Mengubah status tugas menjadi selesai
    public function updateStatus(Tugas $tugas)
    {
        $tugas->selesai = true;
        $tugas->save();
        return back()->with('success', 'Status tugas berhasil diperbarui!');
    }

/**
 * METHOD BARU: Menampilkan halaman riwayat tugas yang sudah selesai.
 */
    /**
 * Menampilkan halaman riwayat.
 * Logika berbeda untuk Admin dan User biasa.
 */
public function history()
{
    $user = auth()->user();
    $tugas_selesai = [];

    if ($user->isAdmin()) {
        // Jika Admin, ambil SEMUA tugas yang selesai
        $tugas_selesai = Tugas::with('user')->where('selesai', true)
                            ->orderBy('updated_at', 'desc')
                            ->get();
    } else {
        // Jika User biasa, ambil hanya tugas selesai miliknya
        $tugas_selesai = $user->tugas()->where('selesai', true)
                            ->orderBy('updated_at', 'desc')
                            ->get();
    }

    return view('riwayat.history', ['semua_tugas_selesai' => $tugas_selesai]);
}
}