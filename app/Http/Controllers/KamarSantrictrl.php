<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KamarSantriModel;

class KamarSantrictrl extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 5); // Default 5 jika tidak ada input
        $totalItems = KamarSantriModel::count();
        $kamarsantris = KamarSantriModel::SimplePaginate($perPage)->appends(['perPage' => $perPage]);
        return view('kamar_santri.index', compact('kamarsantris', 'totalItems', 'perPage'));
    }

    public function create()
    {
        return view('kamar_santri.create');
    }

    public function store(Request $request)
    {
        // Melakukan validasi input
        $request->validate([
            'nama_kamar' => 'required|string|max:50',
        ], [
            'nama_kamar.required' => 'Kolom nama kamar wajib diisi.',
            'nama_kamar.string' => 'Kolom nama kamar harus berupa teks.',
            'nama_kamar.max' => 'Kolom nama kamar tidak boleh lebih dari 50 karakter.',
        ]);

        // Membuat entri baru dalam database jika validasi berhasil
        $kamarSantri = KamarSantriModel::create([
            'nama_kamar' => $request->nama_kamar,
        ]);

        // Mengarahkan pengguna ke halaman indeks dengan pesan sukses jika berhasil
        return redirect()->route('kamar_santri.index')->with('success', 'Kamar berhasil ditambahkan.');

    }



    public function edit(KamarSantriModel $kamarsantri)
    {
        return view('kamar_santri.edit', compact('kamarsantri'));
    }

    public function update(Request $request, KamarSantriModel $kamarsantri)
    {
        // Melakukan validasi input
        $validatedData = $request->validate([
            'nama_kamar' => 'required|string|max:50',
        ], [
            'nama_kamar.required' => 'Kolom nama kamar wajib diisi.',
            'nama_kamar.string' => 'Kolom nama kamar harus berupa teks.',
            'nama_kamar.max' => 'Kolom nama kamar tidak boleh lebih dari 50 karakter.',
        ]);

        // Memperbarui data jika validasi berhasil
        $kamarsantri->update([
            'nama_kamar' => $request->nama_kamar,
        ]);

        // Mengarahkan pengguna ke halaman indeks dengan pesan sukses jika berhasil
        return redirect()->route('kamar_santri.index')->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(KamarSantriModel $kamarsantri)
    {
        // Menghapus data
        $kamarsantri->delete();

        // Mengarahkan pengguna ke halaman indeks dengan pesan sukses jika berhasil
        return redirect()->route('kamar_santri.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
