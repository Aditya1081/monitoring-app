<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSantriModel;
use App\Models\NilaiMadinModel;
use App\Models\MapelMadinModel;

class NilaiMadinctrl extends Controller
{
    protected $dataSantriModel;
    protected $kelasMadinModel;
    protected $mapelMadinModel;
    protected $nilaiMadinModel;

    public function __construct()
    {
        $this->dataSantriModel = new DataSantriModel();  // Inisialisasi DataSantriModel
        $this->kelasMadinModel = new KelasMadinModel();  // Inisialisasi DataSantriModel
        $this->nilaiMadinModel = new NilaiMadinModel();  // Inisialisasi penilaian
        $this->mapelMadinModel = new MapelMadinModel(); //Inisialisai mapel madin
    }

    public function index()
    {
        // Mengelompokkan dan menghitung total nilai per nama santri
        $nilaiMadins = NilaiMadinModel::select('id_santri', 'id_kelas_madin')
                                        ->groupBy('id_santri', 'id_kelas_madin', )
                                        ->SimplePaginate(5);

        // Menghitung total item
        $totalItems = $nilaiMadins->count();

        return view('penilaian.index', compact('nilaiMadins', 'totalItems'));
    }

    // Menampilkan form untuk menambahkan penilaian
    public function create()
    {
        $santriList = $this->dataSantriModel->all(); // Mendapatkan daftar santri untuk dropdown
        $kelasMadinList = $this->kelasMadinModel->all(); // Mendapatkan daftar santri untuk dropdown
        $mapelMadinList = $this->mapelMadinModel->all(); // Mendapatkan daftar santri untuk dropdown
        return view('penilaian.create', compact('santriList', 'kelasMadinList', 'mapelMadinList'));
    }

    // Menyimpan data penilaian yang baru dibuat
    public function store(Request $request)
    {
        $request->validate([
            'id_santri' => 'required',
            'id_kelas_madin' => 'required',
            'id_mapel_madin' => 'required',
            'nilai' => 'required|numeric|digits_between:1,5',
            'catatan' => 'nullable',
            'tanggal_penilaian' => 'required',
        ],[
            'id_kelas_madin.required' => 'Kelas Madin harus dipilih.',
            'id_santri.required' => 'Santri harus dipilih.',
            'id_mapel_madin.required' => 'Mata Pelajaran harus diisi.',
            'nilai.required' => 'Nilai penilaian harus diisi.',
            'nilai.numeric' => 'Nilai penilaian harus berupa angka.',
            'nilai.digits_between:1,5' => 'Kolom Nilai harus berisi minimal 1 karakter dan maksimal 5 karakter',
            'tanggal_penilaian.required' => 'Santri harus diisi.',
        ]);

        // Simpan data santri ke model
        $this->nilaiMadinModel->create($request->all());

        return redirect()->route('penilaian.index')->with('success', 'penilaian berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit data penilaian
    public function edit(NilaiMadinModel $penilaian)
    {
        $kelasMadinList = KelasMadinModel::all(); // Mendapatkan daftar kelas
        $mapelMadinList = MapelMadinModel::all(); // Mendapatkan daftar kelas
        $santriList = DataSantriModel::where('id_kelas_madin', $penilaian->DataSantri->id_kelas_madin)->get(); // Mendapatkan daftar santri berdasarkan kelas dari penilaian

        return view('penilaian.edit', compact('penilaian', 'kelasMadinList', 'mapelMadinList', 'santriList'));
    }


    // Menyimpan perubahan pada data penilaian
    public function update(Request $request, NilaiMadinModel $penilaian)
    {
        $request->validate([
            'nilai' => 'required|numeric|digits_between:1,5',
            'catatan' => 'nullable',
            'tanggal_penilaian' => 'required',
        ], [
            'nilai.required' => 'Nilai penilaian harus diisi.',
            'nilai.numeric' => 'Nilai penilaian harus berupa angka.',
            'nilai.digits_between:1,5' => 'Kolom Nilai harus berisi minimal 1 karakter dan maksimal 5 karakter',
            'tanggal_penilaian.required' => 'Tanggal penilaian harus diisi.',
        ]);

        // Update data penilaian
        $penilaian->update($request->all());

        // Ambil id_santri dari penilaian setelah diupdate
        $id_santri = $penilaian->id_santri;

        // Redirect ke halaman riwayat penilaian dengan id_santri
        return redirect()->route('penilaian.riwayat', ['id_santri' => $id_santri])->with('success', 'Data penilaian berhasil diperbarui.');
    }

    // Menghapus data penilaian
    public function destroy($id)
    {
        // Temukan model berdasarkan ID yang diberikan
        $penilaian = NilaiMadinModel::find($id);

        if (!$penilaian) {
            // Jika data penilaian tidak ditemukan, arahkan kembali dengan pesan error
            return redirect()->route('penilaian.index')->with('error', 'penilaian tidak ditemukan.');
        }

        // Hapus data penilaian yang ditemukan
        $penilaian->delete();

        // Arahkan kembali dengan pesan sukses
        return redirect()->route('penilaian.index')->with('success', 'penilaian berhasil dihapus.');
    }

    public function showMapel($id_santri)
    {
        // Mendapatkan data penilaian berdasarkan id_santri dengan pagination dan urutkan berdasarkan tanggal_penilaian
        $nilaiMadins = NilaiMadinModel::where('id_santri', $id_santri)
                                        ->orderBy('tanggal_penilaian', 'desc')
                                        ->simplePaginate(5);

        // Menghitung total item
        $totalItems = NilaiMadinModel::where('id_santri', $id_santri)->count();

        return view('penilaian.riwayat', compact('nilaiMadins', 'totalItems'));
    }
}
