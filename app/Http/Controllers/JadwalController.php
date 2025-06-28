<?php

// app/Http/Controllers/JadwalController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;

class JadwalController extends Controller
{
    // Menampilkan halaman utama dengan semua tugas
    public function index()
    {
        // Mengurutkan agar tugas terbaru di atas
        $daftar_tugas = Tugas::orderBy('created_at', 'desc')->get(); 

        return view('dashboard', [
            'semua_tugas' => $daftar_tugas
        ]);
    }

    // Menyimpan tugas baru
    public function store(Request $request)
    {
        $request->validate(['nama_tugas' => 'required|string|max:255']);
        Tugas::create($request->only('nama_tugas'));
        return back()->with('success', 'Tugas baru berhasil ditambahkan!');
    }

    // METHOD BARU: Menampilkan halaman form edit
    public function edit(Tugas $tugas)
    {
        return view('jadwal.edit', ['tugas' => $tugas]);
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
}