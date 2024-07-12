<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\PerizinanModel;
use App\Models\DataSantriModel;
use App\Models\PrestasiModel;
use App\Models\KamarModel;
use App\Http\Controllers\PrestasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery;
use Carbon\Carbon;

class PrestasiControllerTest extends TestCase
{
    // use DatabaseTransactions;
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(); // Menonaktifkan middleware otentikasi sementara untuk pengujian
        Session::start(); // Pastikan session dimulai
    }

    // public function testStoresAPrestasi()
    // {
    //     $this->withoutMiddleware();

    //     Storage::fake('public');

    //     $file = UploadedFile::fake()->create('Prestasi.png', 1000); // Sesuaikan nama dan ukuran file sesuai kebutuhan

    //     $data = [
    //         'id_kamar' => 1,
    //         'id_santri' => 1,
    //         'nama_prestasi' => 'Prestasi Test',
    //         'deskripsi' => 'Deskripsi Prestasi Test',
    //         'slug_prestasi' => 'prestasi-test',
    //         'tanggal_prestasi' => Carbon::now()->format('Y-m-d'), // Sesuaikan format tanggal sesuai kebutuhan
    //         'file_prestasi' => $file,
    //     ];

    //     $response = $this->post(route('prestasi.store'), $data);

    //     // Pastikan data tersimpan di dalam database
    //     $this->assertDatabaseHas('tb_prestasi', [
    //         'id_kamar' => 1,
    //         'id_santri' => 1,
    //         'nama_prestasi' => 'Prestasi Test',
    //         'deskripsi' => 'Deskripsi Prestasi Test',
    //         'slug_prestasi' => 'prestasi-test',
    //         // tambahkan kolom lainnya sesuai kebutuhan
    //     ]);
    // }

    public function test_update_with_valid_data()
    {
        $this->withoutMiddleware();

        Storage::fake('public');

        $newFile = UploadedFile::fake()->create('UpdatedPrestasi.png', 1000);

        $request = new Request([
            'id_kamar' => 1, // Ganti nilai sesuai yang diinginkan
            'id_santri' => 1, // Ganti nilai sesuai yang diinginkan
            'nama_prestasi' => 'Updated Prestasi',
            'deskripsi' => 'Deskripsi Prestasi yang Diperbarui',
            'slug_prestasi' => 'updated-prestasi',
            'tanggal_prestasi' => Carbon::now()->format('Y-m-d'),
            'file_prestasi' => $newFile,
        ]);

        // Fake session
        Session::start(); // Pastikan session dimulai

        // Buat instance controller
        $controller = new \App\Http\Controllers\Prestasictrl;

        // Ambil data Pelanggaran dengan id 19
        $prestasi = PrestasiModel::find(22);

        // Panggil metode update
        $response = $controller->update($request, $prestasi);

        // Assert data in database
        $this->assertDatabaseHas('tb_prestasi', [
            'id_prestasi' => 22,
            'id_kamar' => 1,
            'id_santri' => 1,
            'nama_prestasi' => 'Updated Prestasi',
            'deskripsi' => 'Deskripsi Prestasi yang Diperbarui',
            'slug_prestasi' => 'updated-prestasi',
        ]);
    }

}
