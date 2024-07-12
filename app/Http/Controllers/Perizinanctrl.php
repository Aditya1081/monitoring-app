<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DataSantriModel;
use App\Models\PerizinanModel;
use App\Models\KamarSantriModel;
use App\Models\PelanggaranModel;
use App\Models\AbsensiModel;
use Carbon\Carbon;


class Perizinanctrl extends Controller
{
    protected $dataSantriModel;
    protected $kamarModel;
    protected $absensiModel;
    protected $perizinanModel;

    public function __construct()
    {
        $this->dataSantriModel = new DataSantriModel();  // Inisialisasi DataSantriModel
        $this->kamarModel = new KamarSantriModel();  // Inisialisasi DataSantriModel
        $this->absesniModel = new AbsensiModel();  // Inisialisasi Pelanggaran
        $this->perizinanModel = new PerizinanModel();
    }


    public function index(Request $request)
    {
        if (auth()->user()->hasRole('user')) {
            return $this->indexUser($request);
        }

        $pengajuanQuery = PerizinanModel::where('status_perizinan', 'Menunggu Konfirmasi');
        $sedangIzinQuery = PerizinanModel::where('status_perizinan', 'Disetujui');
        $izinDitolakQuery = PerizinanModel::where('status_perizinan', 'Ditolak');
        $izinSelesaiQuery = PerizinanModel::where('status_perizinan', 'Datang Terlambat')->orWhere('status_perizinan', 'Tepat Waktu');

        // Filter by month and year if provided
        if ($request->has('month') && $request->has('year')) {
            $month = $request->input('month');
            $year = $request->input('year');
            $pengajuanQuery->whereMonth('tanggal_mulai', $month)
                           ->whereYear('tanggal_mulai', $year);
            $sedangIzinQuery->whereMonth('tanggal_mulai', $month)
                            ->whereYear('tanggal_mulai', $year);
            $izinDitolakQuery->whereMonth('tanggal_mulai', $month)
                             ->whereYear('tanggal_mulai', $year);
            $izinSelesaiQuery->whereMonth('tanggal_mulai', $month)
                             ->whereYear('tanggal_mulai', $year);
        } else {
            $month = date('m'); // Default to current month
            $year = date('Y'); // Default to current year
        }

        // Order by 'tanggal_mulai' descending to show newest first
        $pengajuan = $pengajuanQuery->orderBy('tanggal_mulai', 'desc')->simplePaginate(5);
        $sedangIzin = $sedangIzinQuery->orderBy('tanggal_mulai', 'desc')->simplePaginate(5);
        $izinDitolak = $izinDitolakQuery->orderBy('tanggal_mulai', 'desc')->simplePaginate(5);
        $izinSelesai = $izinSelesaiQuery->orderBy('tanggal_mulai', 'desc')->simplePaginate(5);

        return view('perizinan.index', compact('pengajuan', 'sedangIzin', 'izinDitolak', 'izinSelesai', 'month', 'year'));
    }

    public function indexUser(Request $request)
    {
        // Mengambil id_santri dari pengguna yang sedang login
        $id_santri = auth()->user()->id_santri;

        // Mengambil bulan dan tahun yang dipilih dari request atau menggunakan bulan dan tahun ini sebagai default
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Mengambil data perizinan yang sesuai dengan id_santri dan bulan serta tahun yang dipilih
        $dataPerizinan = PerizinanModel::where('id_santri', $id_santri)
            ->whereYear('tanggal_mulai', $year)
            ->whereMonth('tanggal_mulai', $month)
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        // Jika tidak ada data yang ditemukan, set dataPerizinan menjadi null atau array kosong
        // untuk memastikan bahwa Blade dapat menampilkan pesan "Data Perizinan tidak ditemukan".
        if ($dataPerizinan->isEmpty()) {
            $dataPerizinan = null; // atau $dataPerizinan = [];
        }

        // Mengembalikan tampilan dengan data perizinan dan bulan serta tahun untuk form
        return view('perizinan.indexUser', compact('dataPerizinan', 'month', 'year'));
    }


    public function create()
    {
        $kamarList = $this->kamarModel->all();
        $santriList = $this->dataSantriModel->all(); // Mendapatkan daftar santri untuk dropdown
        return view('perizinan.create', compact('kamarList'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id_santri' => 'required',
            'id_kamar' => 'required',
            'nama_perizinan' => 'required|string|max:50',
            'tanggal_mulai' => 'required',
            'deskripsi_perizinan' => 'nullable',
        ],[
            'id_santri.required' => 'Santri harus dipilih.',
            'id_kamar.required' => 'Kamar harus dipilih.',
            'nama_perizinan.required' => 'Nama perizinan harus diisi.',
            'nama_perizinan.max' => 'Nama perizinan maksimal 50 karakter.',
            'tanggal_mulai.required' => 'Tanggal Mulai harus diisi.',
        ]);

        // Add status_perizinan field to the request data
        $data = $request->all();
        $data['status_perizinan'] = 'Menunggu Konfirmasi';
        $data['deskripsi_pengurus'] = '-';

        // Save the data to the model
        $this->perizinanModel->create($data);

        // Redirect to the index route with a success message
        return redirect()->route('perizinan.index')->with('success', 'Perizinan berhasil diajukan.');
    }

    // Menampilkan form untuk mengedit data absensi
    public function edit(PerizinanModel $perizinan)
    {
        $kamarList = KamarSantriModel::all(); // Mendapatkan daftar kelas
        $santriList = DataSantriModel::where('id_kamar', $perizinan->DataSantri->id_kamar)->get(); // Mendapatkan daftar santri berdasarkan kelas dari pelanggaran

        return view('perizinan.edit', compact('perizinan', 'kamarList', 'santriList'));
    }

    public function update(Request $request, PerizinanModel $perizinan)
    {
        $request->validate([
            'status_perizinan' => 'required',
        ],[
            'status_perizinan.required' => 'Status Perizinan harus dipilih.',
        ]);

        // Update data hanya untuk status_perizinan dan deskripsi_pengurus
        $perizinan->update([
            'status_perizinan' => $request->status_perizinan,
            'deskripsi_pengurus' => $request->deskripsi_pengurus,
            'tanggal_akhir' => $request->tanggal_akhir,
        ]);

        return redirect()->route('perizinan.index')->with('success', 'Data perizinan berhasil diperbarui.');
    }


    // Menghapus data absensi
    public function destroy($id)
    {
        // Temukan model berdasarkan ID yang diberikan
        $perizinan = PerizinanModel::find($id);

        if (!$perizinan) {
            // Jika data absensi tidak ditemukan, arahkan kembali dengan pesan error
            return redirect()->route('perizinan.index')->with('error', 'Perizinan tidak ditemukan.');
        }

        // Hapus data absensi yang ditemukan
        $perizinan->delete();

        // Arahkan kembali dengan pesan sukses
        return redirect()->route('perizinan.index')->with('success', 'Perizinan berhasil dihapus.');
    }


    // public function showRiwayat($id_kamar, $jenis_absensi)
    // {
    //     // Mendapatkan data absensi berdasarkan id_kamar dan jenis_absensi dengan pagination dan urutkan berdasarkan created_at
    //     $absensis = AbsensiModel::with('dataSantri')
    //                             ->where('id_kamar', $id_kamar)
    //                             ->where('jenis_absensi', $jenis_absensi)
    //                             ->orderBy('created_at', 'desc')
    //                             ->get();

    //     // Menghitung total item
    //     $totalItems = AbsensiModel::where('id_kamar', $id_kamar)
    //                               ->where('jenis_absensi', $jenis_absensi)
    //                               ->count();

    //     // Mengambil nama kamar untuk ditampilkan
    //     $kamar = KamarSantriModel::find($id_kamar);

    //     if (!$kamar) {
    //         // Handle case where kamar is not found
    //         abort(404, 'Kamar not found.');
    //     }

    //     return view('absensi.riwayat', compact('absensis', 'totalItems', 'kamar', 'jenis_absensi'));
    // }


    public function updateStatus(Request $request, $id)
    {
        $santri = PerizinanModel::findOrFail($id);
        $tanggal_kembali = Carbon::now(); // Tanggal kembali saat ini
        $tanggal_akhir = Carbon::parse($santri->tanggal_akhir); // Tanggal akhir yang disimpan di database

        if ($tanggal_kembali->greaterThan($tanggal_akhir)) {
            // Jika tanggal kembali melewati tanggal_akhir
            $santri->status_perizinan = 'Datang Terlambat';
            // Tambahkan data pelanggaran
            PelanggaranModel::create([
                'id_santri' => $santri->id_santri,
                'id_kamar' => $santri->id_kamar,
                'nama_pelanggaran' => 'Terlambat',
                'point' => 10,
                'deskripsi_pelanggaran' => 'Tanggal kembali tidak sesuai dengan persetujuan pengurus',
                'tanggal_pelanggaran' => $tanggal_kembali
            ]);
        } else {
            // Jika tanggal kembali tidak melewati tanggal_akhir
            $santri->status_perizinan = 'Tepat Waktu';
        }

        // Simpan perubahan status santri
        $santri->save();
        return redirect()->back()->with('success', 'Status Kembali berhasil diperbarui.');
    }

}
