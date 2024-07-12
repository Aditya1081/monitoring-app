<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PelanggaranModel;
use App\Models\DataSantriModel;
use App\Models\KamarModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery;

class PelanggaranControllerTest extends TestCase
{
    // use DatabaseTransactions;

    // public function test_store_with_valid_data()
    // {
    //     $this->withoutMiddleware(); // Menonaktifkan middleware otentikasi sementara untuk pengujian

    //     // // Mock model
    //     // $mockSantri = Mockery::mock('alias:\App\Models\Santri');
    //     // $mockSantri->shouldReceive('findOrFail')->andReturn((object)['id' => 1]);

    //     // $mockKamar = Mockery::mock('alias:\App\Models\Kamar');
    //     // $mockKamar->shouldReceive('findOrFail')->andReturn((object)['id' => 1]);

    //     // Mock request
    //     $request = new Request([
    //         'id_santri' => 1,
    //         'id_kamar' => 1,
    //         'nama_pelanggaran' => 'terlambat',
    //         'point' => '5',
    //         'deskripsi_pelanggaran' => 'terlambat 15 menit',
    //         'tanggal_pelanggaran' => '2024-06-25',
    //     ]);

    //     // Fake session
    //     Session::start(); // Pastikan session dimulai

    //     // Buat instance controller
    //     $controller = new \App\Http\Controllers\Pelanggaranctrl;

    //     // Panggil metode store
    //     $response = $controller->store($request);

    //     // Assert redirect
    //     $this->assertEquals(302, $response->getStatusCode());
    //     $this->assertEquals(route('pelanggaran.index'), $response->headers->get('Location'));

    //     // Assert session has success message
    //     $this->assertEquals('Pelanggaran berhasil ditambahkan.', Session::get('success'));

    //     // Assert data in database
    //     $this->assertDatabaseHas('tb_pelanggaran', [
    //         'id_santri' => 1,
    //         'id_kamar' => 1,
    //         'nama_pelanggaran' => 'terlambat',
    //         'point' => '5',
    //         'deskripsi_pelanggaran' => 'terlambat 15 menit',
    //         'tanggal_pelanggaran' => '2024-06-25',
    //     ]);

    //     // // Hentikan Mockery
    //     // Mockery::close();
    // }


    public function test_store_with_invalid_data()
    {
        $this->withoutMiddleware(); // Menonaktifkan middleware otentikasi sementara untuk pengujian

        // Mock request dengan data tidak valid (nama_pelanggaran kosong)
        $request = new Request([
            'id_santri' => 1,
            'id_kamar' => 1,
            'nama_pelanggaran' => '', // Nama pelanggaran kosong
            'point' => '5',
            'deskripsi_pelanggaran' => 'terlambat 15 menit',
            'tanggal_pelanggaran' => '2024-06-25',
        ]);

        // Fake session
        Session::start(); // Pastikan session dimulai

        // Buat instance controller
        $controller = new \App\Http\Controllers\Pelanggaranctrl;

        // Panggil metode store dan tangkap exception
        try {
            $response = $controller->store($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $response = $e->validator->getMessageBag()->toArray();
        }

        // Assert bahwa validasi gagal
        $this->assertArrayHasKey('nama_pelanggaran', $response);

        // Assert pesan error yang sesuai
        $this->assertEquals('Nama pelanggaran harus diisi.', $response['nama_pelanggaran'][0]);

        // Pastikan tidak ada data yang masuk ke dalam database
        $this->assertDatabaseMissing('tb_pelanggaran', [
            'id_santri' => 1,
            'id_kamar' => 1,
            'nama_pelanggaran' => '',
            'point' => '5',
            'deskripsi_pelanggaran' => 'terlambat 15 menit',
            'tanggal_pelanggaran' => '2024-06-25',
        ]);

    }

    public function test_update_with_valid_data()
    {
        $request = new Request([
            'id_santri' => 1,
            'id_kamar' => 1,
            'nama_pelanggaran' => 'tidak hadir',
            'point' => '10',
            'deskripsi_pelanggaran' => 'tidak hadir 2 hari',
            'tanggal_pelanggaran' => '2024-06-26',
                ]);

        // Fake session
        Session::start(); // Pastikan session dimulai

        // Buat instance controller
        $controller = new \App\Http\Controllers\Pelanggaranctrl;

        // Ambil data Pelanggaran dengan id 2
        $pelanggaran = PelanggaranModel::find(2);

        // Panggil metode update
        $response = $controller->update($request, $pelanggaran);

        // Assert data in database
        $this->assertDatabaseHas('tb_pelanggaran', [
            'id_pelanggaran' => 2,
            'id_santri' => 1,
            'id_kamar' => 1,
            'nama_pelanggaran' => 'tidak hadir',
            'point' => '10',
            'deskripsi_pelanggaran' => 'tidak hadir 2 hari',
            'tanggal_pelanggaran' => '2024-06-26',
        ]);
    }

    public function test_update_with_invalid_data()
    {
        $request = new Request([
            'id_santri' => 1,
            'id_kamar' => 1,
            'nama_pelanggaran' => '',  // Data tidak valid
            'point' => '10',
            'deskripsi_pelanggaran' => 'tidak hadir 2 hari',
            'tanggal_pelanggaran' => '2024-06-26',
        ]);

        // Fake session
        Session::start();

        // Buat instance controller
        $controller = new \App\Http\Controllers\Pelanggaranctrl;

        // Ambil data Pelanggaran dengan id 2
        $pelanggaran = PelanggaranModel::find(2);

        // Tangkap exception saat memanggil metode update
        try {
            $controller->update($request, $pelanggaran);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $response = $e->validator->getMessageBag()->toArray();
        }

        // Assert bahwa validasi gagal
        $this->assertArrayHasKey('nama_pelanggaran', $response);

        // Assert pesan error yang sesuai
        $this->assertEquals('Nama pelanggaran harus diisi.', $response['nama_pelanggaran'][0]);

        // Assert data in database tidak berubah
        $this->assertDatabaseHas('tb_pelanggaran', [
            'id_pelanggaran' => 2,
            'id_santri' => 1,
            'id_kamar' => 1,
            'nama_pelanggaran' => $pelanggaran->nama_pelanggaran,  // Data lama tetap
            'point' => '10',
            'deskripsi_pelanggaran' => 'tidak hadir 2 hari',
            'tanggal_pelanggaran' => '2024-06-26',
        ]);
    }

    public function test_delete_with_valid_id()
{
    // Menonaktifkan middleware otentikasi sementara untuk pengujian
    $this->withoutMiddleware();

    // Fake session
    Session::start(); // Pastikan session dimulai

    // Buat instance controller
    $controller = new \App\Http\Controllers\Pelanggaranctrl;

    // Panggil metode destroy
    $response = $controller->destroy(1);

    // Ambil data Pelanggaran dengan id 2
    $pelanggaran = PelanggaranModel::find(2);

    // Assert data not in database
    $this->assertDatabaseMissing('tb_pelanggaran', [
        'id_pelanggaran' => 1,
    ]);
}
}
