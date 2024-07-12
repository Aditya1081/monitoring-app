<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerizinanModel;
use App\Models\AbsensiModel;
use App\Models\PelanggaranModel;
use App\Models\DataSantriModel;
use Carbon\Carbon;


class Dashboard extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('user')) {
            return $this->indexUser();
        }

        // Ambil data pengajuan perizinan yang menunggu konfirmasi
        $pengajuanPerizinan = PerizinanModel::where('status_perizinan', 'Menunggu Konfirmasi')->get();

         // Hitung total pengajuan perizinan
        $rekapPengajuanPerizinan = $pengajuanPerizinan->count();

        $timezone = 'Asia/Jakarta';
        $today = Carbon::today($timezone);

        // Rekapitulasi absensi untuk hari ini
        $rekapAbsensiPagi = AbsensiModel::whereDate('tanggal_absensi', $today)
                                        ->where('jenis_absensi', 'pagi')
                                        ->selectRaw('SUM(status_absensi = "tidak hadir") as total_alpa,
                                                    SUM(status_absensi = "izin") as total_izin,
                                                    SUM(status_absensi = "sakit") as total_sakit')
                                        ->first();

        // Rekapitulasi absensi sore untuk hari ini
        $rekapAbsensiSore = AbsensiModel::whereDate('tanggal_absensi', $today)
                                        ->where('jenis_absensi', 'sore')
                                        ->selectRaw('SUM(status_absensi = "tidak hadir") as total_alpa,
                                                    SUM(status_absensi = "izin") as total_izin,
                                                    SUM(status_absensi = "sakit") as total_sakit')
                                        ->first();

        // Rekapitulasi pelanggaran untuk hari ini

        $currentMonth = $today->month;

        $rekapPelanggaranBulanan = PelanggaranModel::whereMonth('tanggal_pelanggaran', $currentMonth)
                                                    ->selectRaw('COUNT(*) as total_pelanggaran')
                                                    ->first();

        // Inisialisasi nilai default jika tidak ada data
        $total_alpa_pagi = $rekapAbsensiPagi->total_alpa ?? 0;
        $total_izin_pagi = $rekapAbsensiPagi->total_izin ?? 0;
        $total_sakit_pagi = $rekapAbsensiPagi->total_sakit ?? 0;

        $total_alpa_sore = $rekapAbsensiSore->total_alpa ?? 0;
        $total_izin_sore = $rekapAbsensiSore->total_izin ?? 0;
        $total_sakit_sore = $rekapAbsensiSore->total_sakit ?? 0;
        $total_pelanggaran = $rekapPelanggaranBulanan ? $rekapPelanggaranBulanan->total_pelanggaran : 0;

        $currentDate = Carbon::now($timezone)->locale('id')->translatedFormat('l, d F Y');

        return view('dashboard.dashboard_admin', compact(
            'rekapPengajuanPerizinan',
            'total_alpa_pagi',
            'total_izin_pagi',
            'total_sakit_pagi',
            'total_alpa_sore',
            'total_izin_sore',
            'total_sakit_sore',
            'total_pelanggaran',
            'currentDate'
        ));
    }

    public function indexUser()
    {
        // Mendapatkan id_santri dari user yang sedang login (ini hanya contoh, Anda mungkin memperoleh id_santri dari sesi atau cara otentikasi lainnya)
        $id_santri = auth()->user()->id_santri; // Anda perlu menyesuaikan ini dengan cara Anda mengambil id_santri dari user saat login

        // Mendapatkan data santri terkait
        $dataSantri = DataSantriModel::where('id_santri', $id_santri)->first();

        // Jika data santri tidak ditemukan, bisa menangani kondisi ini sesuai kebutuhan aplikasi Anda
        if (!$dataSantri) {
            // Contoh jika tidak menemukan data santri
            return redirect()->route('home')->with('error', 'Data santri tidak ditemukan.');
        }

        $timezone = 'Asia/Jakarta';
        $today = Carbon::today($timezone);
        $currentMonth = Carbon::now($timezone)->month;
        $currentYear = Carbon::now($timezone)->year;
        $currentDate = Carbon::now($timezone)->locale('id')->translatedFormat('l, d F Y');

        // Rekapitulasi absensi untuk hari ini
        $rekapAbsensiPagi = AbsensiModel::where('id_santri', $id_santri)
                                        ->whereDate('tanggal_absensi', $today)
                                        ->where('jenis_absensi', 'pagi')
                                        ->selectRaw('SUM(status_absensi = "tidak hadir") as total_alpa,
                                                    SUM(status_absensi = "izin") as total_izin,
                                                    SUM(status_absensi = "sakit") as total_sakit')
                                        ->first();

        $rekapAbsensiSore = AbsensiModel::where('id_santri', $id_santri)
                                        ->whereDate('tanggal_absensi', $today)
                                        ->where('jenis_absensi', 'sore')
                                        ->selectRaw('SUM(status_absensi = "tidak hadir") as total_alpa,
                                                    SUM(status_absensi = "izin") as total_izin,
                                                    SUM(status_absensi = "sakit") as total_sakit')
                                        ->first();

        // Inisialisasi nilai default jika tidak ada data
        $total_alpa_pagi = $rekapAbsensiPagi->total_alpa ?? 0;
        $total_izin_pagi = $rekapAbsensiPagi->total_izin ?? 0;
        $total_sakit_pagi = $rekapAbsensiPagi->total_sakit ?? 0;

        $total_alpa_sore = $rekapAbsensiSore->total_alpa ?? 0;
        $total_izin_sore = $rekapAbsensiSore->total_izin ?? 0;
        $total_sakit_sore = $rekapAbsensiSore->total_sakit ?? 0;

        $totalPengajuanPerizinan = PerizinanModel::where('id_santri', $id_santri)
                                        ->whereMonth('tanggal_mulai', $currentMonth)
                                        ->whereYear('tanggal_mulai', $currentYear)
                                        ->where('status_perizinan', 'Menunggu Konfirmasi')
                                        ->count();

        $rekapPelanggaranBulanan = PelanggaranModel::where('id_santri', $id_santri)
                                        ->whereMonth('tanggal_pelanggaran', $currentMonth)
                                        ->whereYear('tanggal_pelanggaran', $currentYear)
                                        ->count();

        return view('dashboard.dashboard_user', compact(
            'dataSantri',
            'total_alpa_pagi',
            'total_izin_pagi',
            'total_sakit_pagi',
            'total_alpa_sore',
            'total_izin_sore',
            'total_sakit_sore',
            'currentDate',
            'totalPengajuanPerizinan',
            'rekapPelanggaranBulanan'
        ));
    }
}
