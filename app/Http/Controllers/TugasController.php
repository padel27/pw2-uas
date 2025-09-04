<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\User;
use App\Models\Kategori;

class TugasController extends Controller
{
    /**
     * Menampilkan halaman dashboard.
     * Admin melihat semua tugas, user biasa hanya melihat miliknya.
     */
    public function index()
    {
        $user = auth()->user();
        $data = [];

        // Ambil semua kategori untuk form tambah tugas
        $data['semua_kategori'] = Kategori::orderBy('nama_kategori')->get();

        if ($user->isAdmin()) {
            $data['semua_tugas'] = Tugas::with('user', 'kategori')
                ->orderBy('created_at', 'desc')
                ->get();

            $data['semua_pengguna'] = User::where('id', '!=', $user->id)
                ->orderBy('name')
                ->get();
        } else {
            $data['semua_tugas'] = $user->tugas()
                ->with('kategori')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('dashboard', $data);
    }

    /**
     * Menyimpan tugas baru ke database.
     * Admin bisa memilih user, user biasa otomatis miliknya sendiri.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'nama_tugas'    => 'required|string|max:255',
            'kategori_id'   => 'nullable|exists:kategoris,id',
            'prioritas'     => 'required|string',
            'tenggat_waktu' => 'nullable|date',
        ];

        // Kalau admin boleh pilih user
        if ($user->isAdmin()) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        // Kalau bukan admin, isi otomatis pakai user yang login
        if (! $user->isAdmin()) {
            $validated['user_id'] = $user->id;
        }

        Tugas::create($validated);

        return redirect()->route('dashboard')->with('success', 'Tugas baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman edit tugas.
     * Hanya bisa diakses oleh pemilik atau admin.
     */
    public function edit(Tugas $tugas)
    {
        if ($tugas->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'AKSES DITOLAK');
        }

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('tugas.edit', [
            'tugas'     => $tugas,
            'kategoris' => $kategoris,
        ]);
    }

    /**
     * Memproses update tugas dari form edit.
     */
    public function update(Request $request, Tugas $tugas)
    {
        // Cek apakah user pemilik tugas atau admin
        if ($tugas->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'AKSES DITOLAK');
        }

        $validated = $request->validate([
            'nama_tugas'    => 'required|string|max:255',
            'kategori_id'   => 'nullable|exists:kategoris,id',
            'prioritas'     => 'nullable|in:Rendah,Sedang,Tinggi',
            'tenggat_waktu' => 'nullable|date',
        ]);

        $tugas->update($validated);

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Menghapus tugas dari database.
     */
    public function destroy(Tugas $tugas)
    {
        $tugas->delete();

        return back()->with('success', 'Tugas berhasil dihapus!');
    }

    /**
     * Menandai tugas sebagai selesai.
     */
    public function updateStatus(Tugas $tugas)
    {
        $tugas->selesai = true;
        $tugas->save();

        return back()->with('success', 'Status tugas berhasil diperbarui!');
    }

    /**
     * Menampilkan daftar tugas yang sudah selesai.
     */
    public function history()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $tugas_selesai = Tugas::with('user')
                ->where('selesai', true)
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $tugas_selesai = $user->tugas()
                ->where('selesai', true)
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        return view('riwayat.history', [
            'semua_tugas_selesai' => $tugas_selesai,
        ]);
    }
}
