<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasMadinModel;

class KelasMadinctrl extends Controller
{
    public function index()
    {
        // Mengambil jumlah total keseluruhan data
        $totalItems = KelasMadinModel::count();

        $kelasmadins = KelasMadinModel::SimplePaginate(5);
        return view('kelas_madin.index', compact('kelasmadins' , 'totalItems'));
    }

    public function create()
    {
        return view('kelas_madin.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kelas_madin' => 'required|string|max:10',
        ],[
            'nama_kelas_madin.required' => 'Kolom nama kelas wajib diisi.',
            'nama_kelas_madin.string' => 'Kolom nama kelas harus berupa teks.',
            'nama_kelas_madin.max' => 'Kolom nama kelas tidak boleh lebih dari 10 karakter.',
        ]);

        if ($validatedData) {
            KelasMadinModel::create([
                'nama_kelas_madin' => $request->nama_kelas_madin,
            ]);

            return redirect()->route('kelas_madin.index')->with('success', 'Kelas Madin berhasil ditambahkan.');
        } else {
            return redirect()->route('kelas_madin.create')->withErrors($validator)->withInput();
        }
    }


    public function edit(KelasMadinModel $kelasmadin)
    {
        return view('kelas_madin.edit', compact('kelasmadin'));
    }

    public function update(Request $request, KelasMadinModel $kelasmadin)
    {
        $request->validate([
            'nama_kelas_madin' => 'required|string|max:10',
        ],[
            'nama_kelas_madin.required' => 'Kolom nama kelas wajib diisi.',
            'nama_kelas_madin.string' => 'Kolom nama kelas harus berupa teks.',
            'nama_kelas_madin.max' => 'Kolom nama kelas tidak boleh lebih dari 10 karakter.',
        ]);

        $kelasmadin->update([
            'nama_kelas_madin' => $request->nama_kelas_madin,
        ]);

        return redirect()->route('kelas_madin.index')->with('success', 'Kelas Madin berhasil diperbarui.');
    }

    public function destroy(KelasMadinModel $kelasmadin)
    {
        $kelasmadin->delete();
        return redirect()->route('kelas_madin.index')->with('success', 'Kelas Madin berhasil dihapus.');
    }
}
