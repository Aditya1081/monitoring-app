<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PerizinanModel;
use App\Models\DataSantriModel;
use App\Models\KamarModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery;

class PerizinanControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(); // Menonaktifkan middleware otentikasi sementara untuk pengujian
        Session::start(); // Pastikan session dimulai
    }

    public function test_store_with_valid_data()
    {
        // Mock request
        $request = new Request([
            'id_santri' => 1,
            'id_kamar' => 1,
            'nama_perizinan' => 'Izin Pulang Sekarang',
            'tanggal_mulai' => '2024-06-25',
            'tanggal_akhir' => '2024-06-25',
            'deskripsi_perizinan' => 'Izin pulang ke rumah orang tua sekarang',
        ]);

        // Buat instance controller
        $controller = new \App\Http\Controllers\Perizinanctrl;

        // Panggil metode store
        $response = $controller->store($request);

        // Assert data in database
        $this->assertDatabaseHas('tb_perizinan', [
            'id_santri' => 1,
            'id_kamar' => 1,
            'nama_perizinan' => 'Izin Pulang Sekarang',
            'tanggal_mulai' => '2024-06-25',
            'tanggal_akhir' => '2024-06-25',
            'deskripsi_perizinan' => 'Izin pulang ke rumah orang tua sekarang',
        ]);
    }

    public function test_store_with_invalid_data()
    {
        // Mock request with invalid data (missing required fields)
        $request = new Request([
            'id_santri' => 1,
            'id_kamar' => 1,
            'nama_perizinan' => '', // Invalid: empty name
            'tanggal_mulai' => '',
            'tanggal_akhir' => '2024-06-25',
            'deskripsi_perizinan' => 'Izin pulang ke rumah orang tua',
        ]);

        // Buat instance controller
        $controller = new \App\Http\Controllers\Perizinanctrl;

        // Panggil metode store dan tangkap exception
        try {
            $response = $controller->store($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $response = $e->validator->getMessageBag();
        }

        // Assert bahwa validasi gagal
        $this->assertTrue($response->has('nama_perizinan', 'tanggal_mulai'));

        // Assert data not in database
        $this->assertDatabaseMissing('tb_perizinan', [
            'id_santri' => 1,
            'id_kamar' => 1,
            'nama_perizinan' => '',
            'tanggal_mulai' => '',
            'tanggal_akhir' => '2024-06-25',
            'deskripsi_perizinan' => 'Izin pulang ke rumah orang tua'
        ]);

    }

    public function test_store_with_invalid_data2()
    {
        // Mock request with invalid data (missing required fields)
        $request = new Request([
            'id_santri' => 1,
            'id_kamar' => 1,
            'nama_perizinan' => 'Izin pulang hari ini karena ada keperluan mendesak yang harus segera diselesaikan di rumah.', // Invalid: empty name
            'tanggal_mulai' => '2024-06-24',
            'tanggal_akhir' => '2024-06-25',
            'deskripsi_perizinan' => 'Izin pulang ke rumah orang tua',
        ]);

        // Buat instance controller
        $controller = new \App\Http\Controllers\Perizinanctrl;

        // Panggil metode store dan tangkap exception
        try {
            $response = $controller->store($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $response = $e->validator->getMessageBag();
        }

        // Assert bahwa validasi gagal
        $this->assertTrue($response->has('nama_perizinan'));

        // Assert data not in database
        $this->assertDatabaseMissing('tb_perizinan', [
            'id_santri' => 1,
            'id_kamar' => 1,
            'nama_perizinan' => 'Izin pulang hari ini karena ada keperluan mendesak yang harus segera diselesaikan di rumah.',
            'tanggal_mulai' => '2024-06-24',
            'tanggal_akhir' => '2024-06-25',
            'deskripsi_perizinan' => 'Izin pulang ke rumah orang tua'
        ]);
    }

    public function test_update_with_valid_data()
    {
        // Mock request
        $request = new Request([
            'status_perizinan' => 'Disetujui',
            'deskripsi_pengurus' => 'Perizinan disetujui.',
            'tanggal_akhir' => now()->addDays(10)->format('Y-m-d'),
        ]);

        // Fake session
        Session::start(); // Pastikan session dimulai

        // Buat instance controller
        $controller = new \App\Http\Controllers\Perizinanctrl;

        // Ambil data perizinan dengan id 3
        $perizinan = PerizinanModel::find(3);

        // Panggil metode update
        $response = $controller->update($request, $perizinan);

        // Assert data in database
        $this->assertDatabaseHas('tb_perizinan', [
            'id_perizinan' => 2,
            'status_perizinan' => 'Disetujui',
            'deskripsi_pengurus' => 'Perizinan disetujui.',
            'tanggal_akhir' => now()->addDays(10)->format('Y-m-d'),
        ]);
    }
}
