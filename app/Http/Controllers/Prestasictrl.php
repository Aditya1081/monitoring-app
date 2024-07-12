<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PrestasiModel;
use App\Models\DataSantriModel;
use App\Models\KamarSantriModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class Prestasictrl extends Controller
{
    public function index()
    {
        // Mengambil jumlah total keseluruhan data
        $totalItems = PrestasiModel::count();

        $prestasi = PrestasiModel::SimplePaginate(5);
        return view('prestasi.index', compact('prestasi', 'totalItems'));
    }


    public function create()
    {
        $kamarList = KamarSantriModel::all();
        $santriList = DataSantriModel::all(); // Mendapatkan daftar santri untuk dropdown
        return view('prestasi.create', compact('kamarList'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_kamar'      => 'required',
            'id_santri'     => 'required',
            'nama_prestasi' => 'required',
            'deskripsi'     => 'required',
            'tanggal_prestasi' => 'required',
            'file_prestasi' => 'required|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2024',
        ],[
            'id_kamar.required' => 'Kamar wajib diisi.',
            'id_santri.required' => 'Santri wajib diisi.',
            'nama_prestasi.required' => 'Nama prestasi wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'tanggal_prestasi.required' => 'Deskripsi wajib diisi.',
            'file_prestasi.required' => 'File prestasi wajib diunggah.',
            'file_prestasi.file' => 'File prestasi harus berupa file.',
            'file_prestasi.mimes' => 'File prestasi harus berformat jpeg, png, jpg, pdf, doc, atau docx.',
            'file_prestasi.max' => 'Ukuran file prestasi maksimal 2 MB.',
        ]);

        $slug_prestasi = Str::slug($request->nama_prestasi, '-');
        $file_prestasi = $request->file_prestasi;
        $new_file_prestasi = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . '_' . $file_prestasi->getClientOriginalName();

        $data = $request->all();
        $data['slug_prestasi'] = $slug_prestasi;
        $data['file_prestasi'] = 'images/prestasi/' . $new_file_prestasi;

        $file_prestasi->storeAs('public/images/prestasi', $new_file_prestasi);
        PrestasiModel::create($data);

        return redirect()->route('prestasi.index')->with('success', 'Berhasil menambahkan data prestasi baru');
    }

    public function edit(PrestasiModel $prestasi)
    {
        $kamarList = KamarSantriModel::all(); // Mendapatkan daftar kelas
        $santriList = DataSantriModel::where('id_kamar', $prestasi->DataSantri->id_kamar)->get(); // Mendapatkan daftar santri berdasarkan kelas dari pelanggaran
        return view('prestasi.edit', compact('prestasi', 'kamarList', 'santriList'));
    }

    public function update(Request $request, PrestasiModel $prestasi)
    {
        $this->validate($request, [
            'id_kamar'     => 'required',
            'id_santri'     => 'required',
            'nama_prestasi' => 'required',
            'deskripsi'     => 'required',
            'tanggal_prestasi' => 'required',
            'file_prestasi' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2024',
        ],[
            'id_kamar.required' => 'Kamar harus dipilih.',
            'id_santri.required' => 'Santri harus dipilih.',
            'nama_prestasi.required' => 'Nama prestasi harus diisi.',
            'deskripsi.required' => 'Deskripsi prestasi harus diisi.',
            'tanggal_prestasi.required' => 'Deskripsi wajib diisi.',
            'file_prestasi.mimes' => 'File prestasi harus dalam format jpeg, png, jpg, pdf, doc, atau docx.',
            'file_prestasi.max' => 'File prestasi tidak boleh lebih dari 2 MB.',
        ]);

        $data = $request->all();
        $data['slug_prestasi'] = Str::slug($request->nama_prestasi, '-');

        if ($request->hasFile('file_prestasi')) {
            // Delete old file
            Storage::disk('public')->delete($prestasi->file_prestasi);

            // Upload new file
            $file_prestasi = $request->file_prestasi;
            $new_file_prestasi = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . '_' . $file_prestasi->getClientOriginalName();
            $file_prestasi->storeAs('public/images/prestasi', $new_file_prestasi);

            // Update file path in data array
            $data['file_prestasi'] = 'images/prestasi/' . $new_file_prestasi;
        }

        $prestasi->update($data);

        return redirect()->route('prestasi.index')->with('success', 'Data prestasi berhasil diperbarui');
    }


    public function destroy($id)
    {
        $prestasi = PrestasiModel::find($id);
        if ($prestasi) {
            $filename = $prestasi->file_prestasi;
            Storage::disk('public')->delete($filename);
            $prestasi->delete();

            return redirect()->route('prestasi.index')->with('succes', 'Data Prestasi berhasil dihapus');
        }
    }

}
