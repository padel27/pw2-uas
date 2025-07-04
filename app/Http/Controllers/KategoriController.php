<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('kategori.index', ['kategoris' => $kategoris]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['nama_kategori' => 'required|string|max:255|unique:kategoris']);
        Kategori::create($validated);
        return back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', ['kategori' => $kategori]);
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate(['nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id]);
        $kategori->update($validated);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}