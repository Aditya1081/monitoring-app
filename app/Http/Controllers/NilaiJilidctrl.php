<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DataSantriModel;
use App\Models\NilaiJilidModel;
use App\Models\JilidModel;

class NilaiJilidctrl extends Controller
{
    protected $dataSantriModel;
    protected $jilidModel;
    protected $nilaiJilidModel;

    public function __construct()
    {
        $this->dataSantriModel = new DataSantriModel();  // Inisialisasi DataSantriModel
        $this->jilidModel = new JilidModel();  // Inisialisasi DataSantriModel
        $this->nilaiJilidModel = new NilaiJilidModel();  // Inisialisasi Pelanggaran
    }

    // public function index(Request $request)
    // {
    //     // Menghitung jumlah total kamar
    //     $totalItems = DB::table('tb_jilid')->count();

    //     // Ambil tanggal dari request atau gunakan tanggal hari ini jika tidak ada tanggal yang dipilih
    //     $tanggal = $request->input('tanggal', date('Y-m-d'));

    //     // Query untuk nilaiJilid
    //     $nilaiJilid = DB::table('tb_nilai_jilid')
    //         ->join('tb_jilid', 'tb_nilai_jilid.id_jilid', '=', 'tb_jilid.id_jilid')
    //         ->whereDate('tb_nilai_jilid.tanggal_penilaian', $tanggal)
    //         ->groupBy('tb_jilid.id_jilid', 'tb_jilid.nama_jilid')
    //         ->orderBy('tb_nilai_jilid.tanggal_penilaian', 'desc')
    //         ->simplePaginate(5);

    //     return view('nilai_jilid.index', compact('nilaiJilid', 'totalItems', 'tanggal'));
    // }

    // public function index(Request $request)
    // {
    //     // Menghitung jumlah total kamar
    //     $totalItems = DB::table('nilai_jilid_models')->count();

    //     // Ambil tanggal dari request atau gunakan tanggal hari ini jika tidak ada tanggal yang dipilih
    //     $tanggal = $request->input('tanggal', date('Y-m-d'));

    //     // Query untuk nilaiJilid
    //     $nilaiJilid = DB::table('nilai_jilid_models as data')
    //         ->join('tb_jilid', 'data.id_jilid', '=', 'tb_jilid.id_jilid')
    //         ->whereDate('data.tanggal_penilaian', $tanggal)
    //         ->select('data.*', 'tb_jilid.nama_jilid')
    //         ->orderBy('data.tanggal_penilaian', 'desc')
    //         ->simplePaginate(5);

    //     return view('nilai_jilid.index', compact('nilaiJilid', 'totalItems', 'tanggal'));
    // }

    public function index(Request $request)
    {
        if (auth()->user()->hasRole('user')) {
            return $this->indexUser($request);
        }

        // Menghitung jumlah total nilai jilid
        $totalItems = DB::table('tb_nilai_jilid')->count();

        // Ambil tanggal dari request atau gunakan tanggal hari ini jika tidak ada tanggal yang dipilih
        $tanggal = $request->input('tanggal', date('Y-m-d'));

        // Query untuk nilaiJilid
        $nilaiJilid = DB::table('tb_nilai_jilid as data')
                        ->join('tb_jilid', 'data.id_jilid', '=', 'tb_jilid.id_jilid')
                        ->whereDate('data.tanggal_penilaian', $tanggal)
                        ->select('data.id_jilid', 'tb_jilid.nama_jilid', 'data.tanggal_penilaian')
                        ->groupBy('data.id_jilid', 'tb_jilid.nama_jilid', 'data.tanggal_penilaian')
                        ->orderBy('data.tanggal_penilaian', 'desc')
                        ->simplePaginate(5);

        return view('nilai_jilid.index', compact('nilaiJilid', 'totalItems', 'tanggal'));
    }

    public function indexUser(Request $request)
    {
        // Mengambil id_santri dari pengguna yang sedang login
        $id_santri = auth()->user()->id_santri;

        // Mengambil bulan dan tahun yang dipilih dari request atau menggunakan bulan dan tahun ini sebagai default
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Mengambil data perizinan yang sesuai dengan id_santri dan tanggal yang dipilih
        $nilaiJilid = NilaiJilidModel::where('id_santri', $id_santri)
            ->whereYear('tanggal_penilaian', $year)
            ->whereMonth('tanggal_penilaian', $month)
            ->orderBy('tanggal_penilaian', 'desc')
            ->get();

        // Jika tidak ada data yang ditemukan, set dataPerizinan menjadi null atau array kosong
        // untuk memastikan bahwa Blade dapat menampilkan pesan "Data Perizinan tidak ditemukan".
        if ($nilaiJilid->isEmpty()) {
            $nilaiJilid = null; // atau $dataPerizinan = [];
        }

        // Mengembalikan tampilan dengan data perizinan dan tanggal untuk form
        return view('nilai_jilid.indexUser', compact('nilaiJilid', 'month', 'year'));
    }

    public function getSantriByJilid(Request $request)
    {
        $id_jilid = $request->input('id_jilid');
        $santriList = DataSantriModel::where('id_jilid', $id_jilid)->get(); // Ganti DataSantriModel dengan model yang sesuai

        return response()->json($santriList);
    }


    public function create()
    {
        $jilidList = $this->jilidModel->all();
        return view('nilai_jilid.create', compact('jilidList'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_jilid' => 'required',
            'keterangan_nilai' => 'required|array',
            'keterangan_nilai.*' => 'required',
            'halaman' => 'required|array',
            'halaman.*' => 'required',
            'tanggal_penilaian' => 'required|array',
            'tanggal_penilaian.*' => 'required',
        ], [
            'id_jilid.required' => 'Jilid harus dipilih.',
            'keterangan_nilai.required' => 'Keterangan Nilai harus terisi.',
            'halaman.required' => 'Halaman harus terisi.',
            'tanggal_penilaian.required' => 'Tanggal Penilaian harus dipilih.',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->keterangan_nilai as $id_santri => $keterangan_nilai) {
                // Periksa apakah data nilaiJilid sudah ada untuk tanggal dan jenis nilaiJilid yang sama
                $existingnilaiJilid = NilaiJilidModel::where('id_santri', $id_santri)
                    ->where('id_jilid', $request->id_jilid)
                    ->where('tanggal_penilaian', $request->tanggal_penilaian[$id_santri])
                    ->where('keterangan_nilai', $keterangan_nilai)
                    ->first();

                if ($existingnilaiJilid) {
                    // Jika data nilaiJilid sudah ada, batalkan transaksi dan kirim pesan kesalahan
                    $formattedDate = \Carbon\Carbon::parse($request->tanggal_penilaian[$id_santri])->locale('id')->translatedFormat('d F Y');
                    DB::rollBack();
                    return redirect()->route('nilai_jilid.index')->with('error', 'Data Nilai Jilid untuk tanggal ' . $formattedDate . ' dan keterangan nilai ' . $keterangan_nilai . ' sudah ada.');
                }

                // Simpan data nilaiJilid
                $nilaiJilidData = [
                    'id_santri' => $id_santri,
                    'id_jilid' => $request->id_jilid,
                    'keterangan_nilai' => $keterangan_nilai,
                    'tanggal_penilaian' => $request->tanggal_penilaian[$id_santri],
                    'halaman' => $request->halaman[$id_santri],
                ];

                $nilaiJilid = NilaiJilidModel::create($nilaiJilidData);
            }

            DB::commit();
            return redirect()->route('nilai_jilid.index')->with('success', 'Nilai Jilid berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('nilai_jilid.index')->with('error', 'Terjadi kesalahan saat menambahkan nilai jilid.');
        }
    }

    // public function edit($id)
    // {
    //     $nilaiJilid = NilaiJilidModel::find($id);
    //     if (!$nilaiJilid) {
    //         return redirect()->route('nilai_jilid.index')->with('error', 'Nilai Jilid tidak ditemukan.');
    //     }

    //     $jilidList = $this->jilidModel->all();
    //     return view('nilai_jilid.edit', compact('nilaiJilid', 'jilidList'));
    // }

    // public function edit($id)
    // {
    //     $nilaiJilid = NilaiJilidModel::find($id);

    //     if (!$nilaiJilid) {
    //         return redirect()->route('nilai_jilid.index')->with('error', 'Nilai Jilid dengan ID ' . $id . ' tidak ditemukan.');
    //     }

    //     $jilidList = JilidModel::all(); // Pastikan model JilidModel diimpor dan digunakan dengan benar

    //     return view('nilai_jilid.edit', compact('nilaiJilid', 'jilidList'));
    // }

    // public function update(Request $request, $id)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'id_jilid' => 'required',
    //         'keterangan_nilai' => 'required',
    //         'halaman' => 'required',
    //         'tanggal_penilaian' => 'required|date',
    //     ], [
    //         'id_jilid.required' => 'Jilid harus dipilih.',
    //         'keterangan_nilai.required' => 'Keterangan Nilai harus terisi.',
    //         'halaman.required' => 'Halaman harus terisi.',
    //         'tanggal_penilaian.required' => 'Tanggal Penilaian harus dipilih.',
    //     ]);

    //     $nilaiJilid = NilaiJilidModel::find($id);
    //     if (!$nilaiJilid) {
    //         return redirect()->route('nilai_jilid.index')->with('error', 'Nilai Jilid tidak ditemukan.');
    //     }

    //     // Periksa apakah data nilaiJilid sudah ada untuk tanggal dan jenis nilaiJilid yang sama
    //     $existingnilaiJilid = NilaiJilidModel::where('id_santri', $nilaiJilid->id_santri)
    //         ->where('id_jilid', $request->id_jilid)
    //         ->where('tanggal_penilaian', $request->tanggal_penilaian)
    //         ->where('keterangan_nilai', $request->keterangan_nilai)
    //         ->first();

    //     if ($existingnilaiJilid && $existingnilaiJilid->id != $id) {
    //         $formattedDate = \Carbon\Carbon::parse($request->tanggal_penilaian)->locale('id')->translatedFormat('d F Y');
    //         return redirect()->route('nilai_jilid.edit', $id)->with('error', 'Data Nilai Jilid untuk tanggal ' . $formattedDate . ' dan keterangan nilai ' . $request->keterangan_nilai . ' sudah ada.');
    //     }

    //     // Update data nilaiJilid
    //     $nilaiJilid->update([
    //         'id_jilid' => $request->id_jilid,
    //         'keterangan_jilid' => $request->keterangan_nilai,
    //         'tanggal_penilaian' => $request->tanggal_penilaian,
    //         'halaman' => $request->halaman,
    //     ]);

    //     return redirect()->route('nilai_jilid.index')->with('success', 'Nilai Jilid berhasil diperbarui.');
    // }

    public function destroy($id)
    {
        $nilaiJilid = NilaiJilidModel::find($id);
        if (!$nilaiJilid) {
            return redirect()->route('nilai_jilid.index')->with('error', 'Nilai Jilid tidak ditemukan.');
        }

        $nilaiJilid->delete();
        return redirect()->route('nilai_jilid.index')->with('success', 'Nilai Jilid berhasil dihapus.');
    }

    public function riwayat($id_jilid, Request $request)
{
    $tanggal = $request->input('tanggal', date('Y-m-d')); // Mengambil tanggal dari request, defaultnya hari ini jika tidak ada

    // Lakukan query atau proses lainnya untuk menampilkan riwayat penilaian jilid
    $nilaiJilid = DB::table('tb_nilai_jilid as data')
                    ->join('tb_data_santri', 'data.id_santri', '=', 'tb_data_santri.id_santri')
                    ->join('tb_jilid', 'data.id_jilid', '=', 'tb_jilid.id_jilid')
                    ->where('data.id_jilid', $id_jilid)
                    ->whereDate('data.tanggal_penilaian', $tanggal) // Filter berdasarkan tanggal_penilaian
                    ->select('data.id_nilai_jilid', 'tb_data_santri.nama_santri', 'tb_jilid.nama_jilid', 'data.keterangan_nilai', 'data.halaman', 'data.tanggal_penilaian')
                    ->orderBy('tb_data_santri.nama_santri', 'asc')
                    ->get();

    $jilid = DB::table('tb_jilid')->where('id_jilid', $id_jilid)->first();

    return view('nilai_jilid.riwayat', compact('nilaiJilid', 'jilid', 'tanggal'));
}



    public function updateNilaiJilid(Request $request, $id_jilid)
    {
        $data = $request->input('nilai_jilid');

        foreach ($data as $nilaiJilidData) {
            $id_nilai_jilid = $nilaiJilidData['id']; // Sesuaikan dengan kunci yang benar untuk id_nilai_jilid

            $nilaiJilid = NilaiJilidModel::find($id_nilai_jilid);

            if ($nilaiJilid) {
                // Perbarui keterangan_nilai dan halaman
                $nilaiJilid->keterangan_nilai = $nilaiJilidData['keterangan_nilai'];
                $nilaiJilid->halaman = $nilaiJilidData['halaman'];
                $nilaiJilid->save();
            }
        }

        return redirect()->back()->with('success', 'Nilai Jilid berhasil diperbarui.');
    }



}
