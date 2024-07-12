<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParalelModel;

class Paralelctrl extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 5); // Default 5 jika tidak ada input
        $totalItems = ParalelModel::count();

        $paralels = ParalelModel::SimplePaginate($perPage)->appends(['perPage' => $perPage]);
        return view('paralel.index', compact('paralels' , 'totalItems' , 'perPage'));
    }

    public function create()
    {
        return view('paralel.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kelas' => 'required|string|max:3',
        ],[
            'nama_kelas.required' => 'Kolom nama kelas wajib diisi.',
            'nama_kelas.string' => 'Kolom nama kelas harus berupa teks.',
            'nama_kelas.max' => 'Kolom nama kelas tidak boleh lebih dari 3 karakter.',
        ]);

        if ($validatedData) {
            ParalelModel::create([
                'nama_kelas' => $request->nama_kelas,
            ]);

            return redirect()->route('paralel.index')->with('success', 'Paralel berhasil ditambahkan.');
        } else {
            return redirect()->route('paralel.create')->withErrors($validator)->withInput();
        }
    }


    public function edit(ParalelModel $paralel)
    {
        return view('paralel.edit', compact('paralel'));
    }

    public function update(Request $request, ParalelModel $paralel)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:3',
        ],[
            'nama_kelas.required' => 'Kolom nama kelas wajib diisi.',
            'nama_kelas.string' => 'Kolom nama kelas harus berupa teks.',
            'nama_kelas.max' => 'Kolom nama kelas tidak boleh lebih dari 3 karakter.',
        ]);

        $paralel->update([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('paralel.index')->with('success', 'Paralel berhasil diperbarui.');
    }

    public function destroy(ParalelModel $paralel)
    {
        $paralel->delete();
        return redirect()->route('paralel.index')->with('success', 'Paralel berhasil dihapus.');
    }
}
