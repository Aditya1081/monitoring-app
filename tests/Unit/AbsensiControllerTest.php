<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\AbsensiModel;

use App\Models\PerizinanModel;
use App\Models\DataSantriModel;
use App\Models\KamarModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery;
use Carbon\Carbon;

class AbsensiControllerTest extends TestCase
{
    // use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(); // Menonaktifkan middleware otentikasi sementara untuk pengujian
        Session::start(); // Pastikan session dimulai
    }

    public function testStoreAbsensi()
    {
        // Prepare mock request data
        $requestData = [
            'id_kamar' => 1,
            'jenis_absensi' => [
                1 => 'Pagi',
                2 => 'Sore',
            ],
            'status_absensi' => [
                1 => 'hadir',
                2 => 'tidak hadir',
                3 => 'sakit',
                4 => 'izin',
            ],
            'tanggal_absensi' => [
                1 => Carbon::now()->format('Y-m-d'),
                2 => Carbon::now()->format('Y-m-d'),
            ],
        ];

        // Send mock POST request
        $response = $this->post(route('absensi.store'), $requestData);

        // Assert the data was stored correctly in the database
        $this->assertDatabaseHas('tb_absensi', [
            'id_kamar' => 1,
            'id_santri' => 1,
            'jenis_absensi' => 'Pagi',
            'tanggal_absensi' => $requestData['tanggal_absensi'][1],
            'status_absensi' => 'hadir',
        ]);

        $this->assertDatabaseHas('tb_absensi', [
            'id_kamar' => 1,
            'id_santri' => 2,
            'jenis_absensi' => 'Sore',
            'tanggal_absensi' => $requestData['tanggal_absensi'][2],
            'status_absensi' => 'tidak hadir',
        ]);

        // Assert the violation record was created for 'tidak hadir' status
        $this->assertDatabaseHas('tb_pelanggaran', [
            'id_kamar' => 1,
            'id_santri' => 2,
            'nama_pelanggaran' => 'Tidak Hadir',
            'point' => 10,
            'deskripsi_pelanggaran' => 'Tidak hadir pada absensi sore',
            'tanggal_pelanggaran' => $requestData['tanggal_absensi'][2],
        ]);
    }
}
