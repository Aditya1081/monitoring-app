<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MapelMadinModel;

class MapelMadinctrl extends Controller
{
    public function index()
    {
        // Mengambil jumlah total keseluruhan data
        $totalItems = MapelMadinModel::count();

        $mapelmadins = MapelMadinModel::SimplePaginate(5);
        return view('mapel_madin.index', compact('mapelmadins' , 'totalItems'));
    }

    public function create()
    {
        return view('mapel_madin.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_mapel_madin' => 'required|string|max:10',
        ],[
            'nama_mapel_madin.required' => 'Kolom nama mapel wajib diisi.',
            'nama_mapel_madin.string' => 'Kolom nama mapel harus berupa teks.',
            'nama_mapel_madin.max' => 'Kolom nama mapel tidak boleh lebih dari 10 karakter.',
        ]);

        if ($validatedData) {
            MapelMadinModel::create([
                'nama_mapel_madin' => $request->nama_mapel_madin,
            ]);

            return redirect()->route('mapel_madin.index')->with('success', 'Mapel Madin berhasil ditambahkan.');
        } else {
            return redirect()->route('mapel_madin.create')->withErrors($validator)->withInput();
        }
    }


    public function edit(MapelMadinModel $mapelmadin)
    {
        return view('mapel_madin.edit', compact('mapelmadin'));
    }

    public function update(Request $request, MapelMadinModel $mapelmadin)
    {
        $request->validate([
            'nama_mapel_madin' => 'required|string|max:10',
        ],[
            'nama_mapel_madin.required' => 'Kolom nama mapel wajib diisi.',
            'nama_mapel_madin.string' => 'Kolom nama mapel harus berupa teks.',
            'nama_mapel_madin.max' => 'Kolom nama mapel tidak boleh lebih dari 10 karakter.',
        ]);

        $mapelmadin->update([
            'nama_mapel_madin' => $request->nama_mapel_madin,
        ]);

        return redirect()->route('mapel_madin.index')->with('success', 'Mapel Madin berhasil diperbarui.');
    }

    public function destroy(MapelMadinModel $mapelmadin)
    {
        $mapelmadin->delete();
        return redirect()->route('mapel_madin.index')->with('success', 'Mapel Madin berhasil dihapus.');
    }
}
