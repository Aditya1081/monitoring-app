<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JilidModel;

class Jilidctrl extends Controller
{
    public function index()
    {
        // Mengambil jumlah total keseluruhan data
        $totalItems = JilidModel::count();
        $jilids = JilidModel::SimplePaginate(5);
        return view('jilid.index', compact('jilids' , 'totalItems'));
    }

    public function create()
    {
        return view('jilid.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_jilid' => 'required|string|max:15',
        ],[
            'nama_jilid.required' => 'Kolom nama kelas wajib diisi.',
            'nama_jilid.string' => 'Kolom nama kelas harus berupa teks.',
            'nama_jilid.max' => 'Kolom nama kelas tidak boleh lebih dari 15 karakter.',
        ]);

        if ($validatedData) {
            JilidModel::create([
                'nama_jilid' => $request->nama_jilid,
            ]);

            return redirect()->route('jilid.index')->with('success', 'Jilid berhasil ditambahkan.');
        } else {
            return redirect()->route('jilid.create')->withErrors($validator)->withInput();
        }
    }


    public function edit(JilidModel $jilid)
    {
        return view('jilid.edit', compact('jilid'));
    }

    public function update(Request $request, JilidModel $jilid)
    {
        $request->validate([
            'nama_jilid' => 'required|string|max:15',
        ],[
            'nama_jilid.required' => 'Kolom nama kelas wajib diisi.',
            'nama_jilid.string' => 'Kolom nama kelas harus berupa teks.',
            'nama_jilid.max' => 'Kolom nama kelas tidak boleh lebih dari 15 karakter.',
        ]);

        $jilid->update([
            'nama_jilid' => $request->nama_jilid,
        ]);

        return redirect()->route('jilid.index')->with('success', 'Jilid berhasil diperbarui.');
    }

    public function destroy(JilidModel $jilid)
    {
        $jilid->delete();
        return redirect()->route('jilid.index')->with('success', 'Jilid berhasil dihapus.');
    }
}
