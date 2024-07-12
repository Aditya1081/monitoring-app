<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DataSantriModel;
use App\Models\AbsensiModel;
use App\Models\KamarSantriModel;
use App\Models\PelanggaranModel;
use Carbon\Carbon; // Import Carbon untuk manajemen waktu



class Absensictrl extends Controller
{
    protected $dataSantriModel;
    protected $kamarModel;
    protected $absensiModel;

    public function __construct()
    {
        $this->dataSantriModel = new DataSantriModel();  // Inisialisasi DataSantriModel
        $this->kamarModel = new KamarSantriModel();  // Inisialisasi DataSantriModel
        $this->absesniModel = new AbsensiModel();  // Inisialisasi Pelanggaran
    }



    public function index(Request $request)
    {
        if (auth()->user()->hasRole('user')) {
            return $this->indexUser($request);
        }

        // Menghitung jumlah total kamar
        $totalItems = DB::table('tb_kamar')->count();

        // Ambil tanggal dari request atau gunakan tanggal hari ini jika tidak ada tanggal yang dipilih
        $tanggal = $request->input('tanggal', date('Y-m-d'));

        // Query untuk absensi pagi
        $absensiPagi = DB::table('tb_absensi')
            ->join('tb_kamar', 'tb_absensi.id_kamar', '=', 'tb_kamar.id_kamar')
            ->where('tb_absensi.jenis_absensi', '=', 'Pagi')
            ->whereDate('tb_absensi.tanggal_absensi', $tanggal)
            ->select(
                'tb_kamar.id_kamar',
                'tb_kamar.nama_kamar',
                DB::raw('SUM(CASE WHEN tb_absensi.status_absensi = "hadir" THEN 1 ELSE 0 END) as jumlah_hadir_pagi'),
                DB::raw('SUM(CASE WHEN tb_absensi.status_absensi = "tidak hadir" THEN 1 ELSE 0 END) as jumlah_tidak_hadir_pagi'),
                DB::raw('SUM(CASE WHEN tb_absensi.status_absensi = "sakit" THEN 1 ELSE 0 END) as jumlah_sakit_pagi'),
                DB::raw('SUM(CASE WHEN tb_absensi.status_absensi = "izin" THEN 1 ELSE 0 END) as jumlah_izin_pagi')
            )
            ->groupBy('tb_kamar.id_kamar', 'tb_kamar.nama_kamar')
            ->orderBy('tb_absensi.tanggal_absensi', 'desc')
            ->simplePaginate(5);

        // Query untuk absensi sore
        $absensiSore = DB::table('tb_absensi')
            ->join('tb_kamar', 'tb_absensi.id_kamar', '=', 'tb_kamar.id_kamar')
            ->where('tb_absensi.jenis_absensi', '=', 'Sore')
            ->whereDate('tb_absensi.tanggal_absensi', $tanggal)
            ->select(
                'tb_kamar.id_kamar',
                'tb_kamar.nama_kamar',
                DB::raw('SUM(CASE WHEN tb_absensi.status_absensi = "hadir" THEN 1 ELSE 0 END) as jumlah_hadir_sore'),
                DB::raw('SUM(CASE WHEN tb_absensi.status_absensi = "tidak hadir" THEN 1 ELSE 0 END) as jumlah_tidak_hadir_sore'),
                DB::raw('SUM(CASE WHEN tb_absensi.status_absensi = "sakit" THEN 1 ELSE 0 END) as jumlah_sakit_sore'),
                DB::raw('SUM(CASE WHEN tb_absensi.status_absensi = "izin" THEN 1 ELSE 0 END) as jumlah_izin_sore')
            )
            ->groupBy('tb_kamar.id_kamar', 'tb_kamar.nama_kamar')
            ->orderBy('tb_absensi.tanggal_absensi', 'desc')
            ->simplePaginate(5);

        return view('absensi.index', compact('absensiPagi', 'absensiSore', 'totalItems', 'tanggal'));
    }

    public function indexUser(Request $request)
    {
        // Mengambil id_santri dari pengguna yang sedang login
        $id_santri = auth()->user()->id_santri;

        // Mengambil bulan dan tahun yang dipilih dari request atau menggunakan bulan dan tahun ini sebagai default
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Query untuk absensi pagi sesuai dengan id_santri, bulan, dan tahun
        $absensiPagi = AbsensiModel::where('id_santri', $id_santri)
        ->where('jenis_absensi', 'Pagi')
        ->whereYear('tanggal_absensi', $year)
        ->whereMonth('tanggal_absensi', $month)
        ->select('tanggal_absensi', 'jenis_absensi', 'status_absensi')
        ->orderBy('tanggal_absensi', 'desc')
        ->get();

        // Query untuk absensi sore sesuai dengan id_santri, bulan, dan tahun
        $absensiSore = AbsensiModel::where('id_santri', $id_santri)
            ->where('jenis_absensi', 'Sore')
            ->whereYear('tanggal_absensi', $year)
            ->whereMonth('tanggal_absensi', $month)
            ->select('tanggal_absensi', 'jenis_absensi', 'status_absensi')
            ->orderBy('tanggal_absensi', 'desc')
            ->get();

        // Jika tidak ada data yang ditemukan, set dataAbsensi menjadi null atau array kosong
        // untuk memastikan bahwa Blade dapat menampilkan pesan "Data Absensi tidak ditemukan".
        if ($absensiPagi->isEmpty()) {
            $absensiPagi = null; // atau $absensiPagi = [];
        }

        if ($absensiSore->isEmpty()) {
            $absensiSore = null; // atau $absensiSore = [];
        }

        return view('absensi.indexUser', compact('absensiPagi', 'absensiSore', 'month', 'year'));
    }

    public function create()
    {
        $kamarList = $this->kamarModel->all();
        return view('absensi.create', compact('kamarList'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_kamar' => 'required',
            'jenis_absensi' => 'required|array',
            'jenis_absensi.*' => 'required',
            'status_absensi' => 'required|array',
            'status_absensi.*' => 'required',
            'tanggal_absensi' => 'required|array',
            'tanggal_absensi.*' => 'required',
        ], [
            'id_kamar.required' => 'Kamar harus dipilih.',
            'jenis_absensi.required' => 'Jenis absensi harus terisi.',
            'status_absensi.required' => 'Status absensi harus dipilih.',
            'tanggal_absensi.required' => 'Tanggal absensi harus dipilih.',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->jenis_absensi as $id_santri => $jenis_absensi) {
                // Periksa apakah data absensi sudah ada untuk tanggal dan jenis absensi yang sama
                $existingAbsensi = AbsensiModel::where('id_santri', $id_santri)
                    ->where('id_kamar', $request->id_kamar)
                    ->where('tanggal_absensi', $request->tanggal_absensi[$id_santri])
                    ->where('jenis_absensi', $jenis_absensi)
                    ->first();

                if ($existingAbsensi) {
                    // Jika data absensi sudah ada, batalkan transaksi dan kirim pesan kesalahan
                    $formattedDate = \Carbon\Carbon::parse($request->tanggal_absensi[$id_santri])->locale('id')->translatedFormat('d F Y');
                    DB::rollBack();
                    return redirect()->route('absensi.index')->with('error', 'Data absensi untuk tanggal ' . $formattedDate . ' dan jenis absensi ' . $jenis_absensi . ' sudah ada.');
                }

                // Simpan data absensi
                $absensiData = [
                    'id_santri' => $id_santri,
                    'id_kamar' => $request->id_kamar,
                    'jenis_absensi' => $jenis_absensi,
                    'tanggal_absensi' => $request->tanggal_absensi[$id_santri],
                    'status_absensi' => $request->status_absensi[$id_santri],
                ];

                $absensi = AbsensiModel::create($absensiData);

                // Jika status absensi adalah 'tidak hadir', tambahkan ke pelanggaran
                if ($absensi->status_absensi == 'tidak hadir') {
                    // Tentukan deskripsi pelanggaran berdasarkan jenis absensi
                    $deskripsiPelanggaran = '';
                    switch ($jenis_absensi) {
                        case 'Pagi':
                            $deskripsiPelanggaran = 'Tidak hadir pada absensi pagi';
                            break;
                        case 'Sore':
                            $deskripsiPelanggaran = 'Tidak hadir pada absensi sore';
                            break;
                    }

                    // Buat record pelanggaran
                    PelanggaranModel::create([
                        'id_santri' => $id_santri,
                        'id_kamar' => $request->id_kamar,
                        'nama_pelanggaran' => 'Tidak Hadir',
                        'point' => 10,
                        'deskripsi_pelanggaran' => $deskripsiPelanggaran,
                        'tanggal_pelanggaran' => $absensi->tanggal_absensi,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('absensi.index')->with('success', 'Absensi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('absensi.index')->with('error', 'Terjadi kesalahan saat menambahkan absensi.');
        }
    }

    public function showRiwayat($id_kamar, $jenis_absensi, Request $request)
    {
        // Ambil tanggal dari request
        $tanggal = $request->input('tanggal');

        // Mendapatkan data absensi berdasarkan id_kamar dan jenis_absensi dengan pagination dan urutkan berdasarkan created_at
        $absensis = AbsensiModel::with(['dataSantri' => function($query) {
            $query->orderBy('nama_santri', 'asc');
        }])
            ->where('id_kamar', $id_kamar)
            ->where('jenis_absensi', $jenis_absensi)
            ->when($tanggal, function ($query, $tanggal) {
                return $query->whereDate('tanggal_absensi', '=', $tanggal);
            })
            ->orderBy('tanggal_absensi', 'desc')
            ->paginate(10);

        // Menghitung total item
        $totalItems = AbsensiModel::where('id_kamar', $id_kamar)
            ->where('jenis_absensi', $jenis_absensi)
            ->when($tanggal, function ($query, $tanggal) {
                return $query->whereDate('tanggal_absensi', '=', $tanggal);
            })
            ->count();

        // Mengambil nama kamar untuk ditampilkan
        $kamar = KamarSantriModel::find($id_kamar);

        if (!$kamar) {
            // Handle case where kamar is not found
            abort(404, 'Kamar not found.');
        }

        return view('absensi.riwayat', compact('absensis', 'totalItems', 'kamar', 'jenis_absensi', 'tanggal'));
    }

    public function updateStatus(Request $request)
    {
        $data = $request->input('absensi');

        foreach ($data as $absensiData) {
            $absensi = AbsensiModel::find($absensiData['id']);

            if ($absensi) {
                // Cek apakah status diubah dari 'tidak hadir' ke status lain
                if ($absensi->status_absensi == 'tidak hadir' && $absensiData['status'] != 'tidak hadir') {
                    // Temukan dan hapus data pelanggaran terkait dengan tanggal absensi dan deskripsi absensi yang sama
                    PelanggaranModel::where('id_santri', $absensi->id_santri)
                        ->where('nama_pelanggaran', 'Tidak Hadir')
                        ->whereDate('tanggal_pelanggaran', $absensi->created_at->toDateString())
                        ->where('deskripsi_pelanggaran', $absensi->jenis_absensi == 'Pagi' ? 'Tidak hadir pada absensi pagi' : 'Tidak hadir pada absensi sore')
                        ->delete();
                }

                // Cek apakah status diubah menjadi 'tidak hadir'
                if ($absensiData['status'] == 'tidak hadir' && $absensi->status_absensi != 'tidak hadir') {
                    // Tentukan deskripsi pelanggaran berdasarkan jenis absensi
                    $deskripsiPelanggaran = '';
                    switch ($absensi->jenis_absensi) {
                        case 'Pagi':
                            $deskripsiPelanggaran = 'Tidak hadir pada absensi pagi';
                            break;
                        case 'Sore':
                            $deskripsiPelanggaran = 'Tidak hadir pada absensi sore';
                            break;
                    }

                    // Buat data pelanggaran baru
                    PelanggaranModel::create([
                        'id_santri' => $absensi->id_santri,
                        'id_kamar' => $absensi->id_kamar,
                        'nama_pelanggaran' => 'Tidak Hadir',
                        'point' => 10,
                        'deskripsi_pelanggaran' => $deskripsiPelanggaran,
                        'tanggal_pelanggaran' => $absensi->created_at->toDateString(),
                    ]);
                }

                // Perbarui status_absensi
                $absensi->status_absensi = $absensiData['status'];
                $absensi->save();
            }
        }

        return redirect()->back()->with('success', 'Status absensi berhasil diperbarui.');
    }


}
