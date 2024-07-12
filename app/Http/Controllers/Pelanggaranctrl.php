<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSantriModel;
use App\Models\PelanggaranModel;
use App\Models\KamarSantriModel;
use Illuminate\Support\Facades\DB;


class Pelanggaranctrl extends Controller
{
    protected $dataSantriModel;
    protected $kamarModel;
    protected $pelanggaranModel;

    public function __construct()
    {
        $this->dataSantriModel = new DataSantriModel();  // Inisialisasi DataSantriModel
        $this->kamarModel = new KamarSantriModel();  // Inisialisasi DataSantriModel
        $this->pelanggaranModel = new PelanggaranModel();  // Inisialisasi Pelanggaran
    }

    public function index(Request $request)
    {
        if (auth()->user()->hasRole('user')) {
            return $this->indexUser($request);
        }

        // Mengelompokkan dan menghitung total point per nama santri
        $pelanggarans = PelanggaranModel::select('id_santri', 'id_kamar', DB::raw('SUM(point) as total_point'))
                                        ->groupBy('id_santri', 'id_kamar', )
                                        ->SimplePaginate(5);

        // Menghitung total item
        $totalItems = $pelanggarans->count();

        return view('pelanggaran.index', compact('pelanggarans', 'totalItems'));
    }

    public function indexUser(Request $request)
    {
        // Mengambil id_santri dari pengguna yang sedang login
        $id_santri = auth()->user()->id_santri;

        // Mengambil bulan dan tahun yang dipilih dari request atau menggunakan bulan dan tahun ini sebagai default
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Query untuk mengambil data pelanggaran sesuai dengan id_santri, bulan, dan tahun
        $pelanggarans = PelanggaranModel::where('id_santri', $id_santri)
            ->whereYear('tanggal_pelanggaran', $year)
            ->whereMonth('tanggal_pelanggaran', $month)
            ->select('nama_pelanggaran', 'deskripsi_pelanggaran', 'tanggal_pelanggaran', 'point')
            ->orderBy('tanggal_pelanggaran', 'desc')
            ->get();

        return view('pelanggaran.indexUser', compact('pelanggarans', 'month', 'year'));
    }


    // Menampilkan form untuk menambahkan pelanggaran
    public function create()
    {
        $santriList = $this->dataSantriModel->all(); // Mendapatkan daftar santri untuk dropdown
        $kamarList = $this->kamarModel->all(); // Mendapatkan daftar santri untuk dropdown
        return view('pelanggaran.create', compact('santriList', 'kamarList'));
    }

    // Menyimpan data pelanggaran yang baru dibuat
    public function store(Request $request)
    {
        $request->validate([
            'id_santri' => 'required',
            'id_kamar' => 'required',
            'nama_pelanggaran' => 'required',
            'point' => 'required|numeric|digits_between:1,5',
            'deskripsi_pelanggaran' => 'nullable',
            'tanggal_pelanggaran' => 'required',
        ],[
            'id_kamar.required' => 'Kamar harus dipilih.',
            'id_santri.required' => 'Santri harus dipilih.',
            'nama_pelanggaran.required' => 'Nama pelanggaran harus diisi.',
            'point.required' => 'Point pelanggaran harus diisi.',
            'point.numeric' => 'Point pelanggaran harus berupa angka.',
            'point.digits_between:1,5' => 'Kolom NIK harus berisi minimal 1 karakter dan maksimal 5 karakter',
            'tanggal_pelanggaran.required' => 'Santri harus diisi.',
        ]);

        // Simpan data santri ke model
        $this->pelanggaranModel->create($request->all());

        return redirect()->route('pelanggaran.index')->with('success', 'Pelanggaran berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit data pelanggaran
    public function edit(PelanggaranModel $pelanggaran)
    {
        $kamarList = KamarSantriModel::all(); // Mendapatkan daftar kelas
        $santriList = DataSantriModel::where('id_kamar', $pelanggaran->DataSantri->id_kamar)->get(); // Mendapatkan daftar santri berdasarkan kelas dari pelanggaran

        return view('pelanggaran.edit', compact('pelanggaran', 'kamarList', 'santriList'));
    }


    // Menyimpan perubahan pada data pelanggaran
    public function update(Request $request, PelanggaranModel $pelanggaran)
    {
        $request->validate([
            'nama_pelanggaran' => 'required',
            'point' => 'required|numeric|digits_between:1,5',
            'deskripsi_pelanggaran' => 'nullable',
            'tanggal_pelanggaran' => 'required',
        ], [
            'nama_pelanggaran.required' => 'Nama pelanggaran harus diisi.',
            'point.required' => 'Point pelanggaran harus diisi.',
            'point.numeric' => 'Point pelanggaran harus berupa angka.',
            'point.digits_between:1,5' => 'Kolom NIK harus berisi minimal 1 karakter dan maksimal 5 karakter',
            'tanggal_pelanggaran.required' => 'Tanggal pelanggaran harus diisi.',
        ]);

        // Update data pelanggaran
        $pelanggaran->update($request->all());

        // Ambil id_santri dari pelanggaran setelah diupdate
        $id_santri = $pelanggaran->id_santri;

        // Redirect ke halaman riwayat pelanggaran dengan id_santri
        return redirect()->route('pelanggaran.riwayat', ['id_santri' => $id_santri])->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    // Menghapus data pelanggaran
    public function destroy($id)
    {
        // Temukan model berdasarkan ID yang diberikan
        $pelanggaran = PelanggaranModel::find($id);

        if (!$pelanggaran) {
            // Jika data pelanggaran tidak ditemukan, arahkan kembali dengan pesan error
            return redirect()->route('pelanggaran.index')->with('error', 'Pelanggaran tidak ditemukan.');
        }

        // Hapus data pelanggaran yang ditemukan
        $pelanggaran->delete();

        // Arahkan kembali dengan pesan sukses
        return redirect()->route('pelanggaran.index')->with('success', 'Pelanggaran berhasil dihapus.');
    }

    public function showRiwayat($id_santri)
    {
        // Mendapatkan data pelanggaran berdasarkan id_santri dengan pagination dan urutkan berdasarkan tanggal_pelanggaran
        $pelanggarans = PelanggaranModel::where('id_santri', $id_santri)
                                        ->orderBy('tanggal_pelanggaran', 'desc')
                                        ->simplePaginate(5);

        // Menghitung total item
        $totalItems = PelanggaranModel::where('id_santri', $id_santri)->count();

        return view('pelanggaran.riwayat', compact('pelanggarans', 'totalItems'));
    }
}
