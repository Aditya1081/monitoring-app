<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\KamarSantriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery;
use Carbon\Carbon;

class KamarControllerTest extends TestCase
{
    // use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(); // Menonaktifkan middleware otentikasi sementara untuk pengujian
        Session::start(); // Pastikan session dimulai
    }

    public function testIndexKamar()
    {
        // Siapkan data dummy secara manual untuk KamarSantriModel
        // KamarSantriModel::create(['nama_kamar' => 'Kamar A']);
        // KamarSantriModel::create(['nama_kamar' => 'Kamar B']);
        // KamarSantriModel::create(['nama_kamar' => 'Kamar C']);
        // KamarSantriModel::create(['nama_kamar' => 'Kamar D']);
        // KamarSantriModel::create(['nama_kamar' => 'Kamar E']);
        // KamarSantriModel::create(['nama_kamar' => 'Kamar F']);
        // KamarSantriModel::create(['nama_kamar' => 'Kamar G']);
        // KamarSantriModel::create(['nama_kamar' => 'Kamar H']);
        // KamarSantriModel::create(['nama_kamar' => 'Kamar I']);
        // KamarSantriModel::create(['nama_kamar' => 'Kamar J']);

        // Buat request dengan parameter perPage
        $request = Request::create(route('kamar_santri.index'), 'GET', ['perPage' => 5]);

        // Buat instance controller
        $controller = new \App\Http\Controllers\KamarSantrictrl;

        // Panggil metode index
        $response = $controller->index($request);

        // Pastikan respon adalah instance dari View
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);

        // Pastikan view yang benar dipanggil
        $this->assertEquals('kamar_santri.index', $response->getName());

        // Pastikan data yang dikirim ke view benar
        $this->assertArrayHasKey('kamarsantris', $response->getData());
        $this->assertArrayHasKey('totalItems', $response->getData());
        $this->assertArrayHasKey('perPage', $response->getData());

        // Pastikan jumlah total items benar
        $this->assertEquals(12, $response->getData()['totalItems']);

        // Pastikan pagination bekerja dengan benar
        $this->assertCount(5, $response->getData()['kamarsantris']);
    }

    // public function testStoreKamar()
    // {
    //     // Prepare mock request data
    //     $requestData = [
    //         'nama_kamar' => 'Al-Azhar 3',
    //     ];

    //     // Send mock POST request
    //     $response = $this->post(route('kamar_santri.store'), $requestData);

    //     // Assert the data was stored correctly in the database
    //     $this->assertDatabaseHas('tb_kamar', [
    //         'nama_kamar' => 'Al-Azhar 3',
    //     ]);
    // }

    // // Pengujian nama kamar Dikosongi
    // public function testInvalidStoreKamar()
    // {
    //     // Prepare mock request data
    //     $requestData = [
    //         'nama_kamar' => '',
    //     ];

    //     // Send mock POST request
    //     $response = $this->post(route('kamar_santri.store'), $requestData);

    //     // Assert bahwa validasi gagal
    //     $response->assertSessionHasErrors('nama_kamar');

    //     $errors = session('errors');

    //     // Assert pesan error yang sesuai
    //     $this->assertEquals('Kolom nama kamar wajib diisi.', $errors->first('nama_kamar'));

    //     // Pastikan tidak ada data yang masuk ke dalam database
    //     $this->assertDatabaseMissing('tb_kamar', [
    //         'nama_kamar' => '',
    //     ]);
    // }

    // public function testUpdateKamar()
    // {
    //     // Prepare mock request data
    //     $requestData = [
    //         'nama_kamar' => 'Al 3',
    //     ];

    //     // Fake session
    //     Session::start(); // Pastikan session dimulai

    //     // Buat instance controller
    //     $controller = new \App\Http\Controllers\KamarSantrictrl;

    //     // Buat instance Request dan isi dengan request data
    //     $request = Request::create(route('kamar_santri.update', ['kamarsantri' => 4]), 'PUT', $requestData);

    //     // Ambil data Kamar dengan id 4
    //     $kamar = KamarSantriModel::find(4);

    //     // Panggil metode update
    //     $response = $controller->update($request, $kamar);

    //     // Assert data in database
    //     $this->assertDatabaseHas('tb_kamar', [
    //         'nama_kamar' => 'Al 3'
    //     ]);
    // }

    // public function testInvalidUpdateKamar()
    // {
    //     // Prepare mock request data with empty nama_kamar
    //     $requestData = [
    //         'nama_kamar' => '',
    //     ];

    //     // Fake session
    //     Session::start(); // Pastikan session dimulai

    //     // Buat instance controller
    //     $controller = new \App\Http\Controllers\KamarSantrictrl;

    //     // Buat instance Request dan isi dengan request data
    //     $request = Request::create(route('kamar_santri.update', ['kamarsantri' => 4]), 'PUT', $requestData);

    //     // Ambil data Kamar dengan id 4
    //     $kamar = KamarSantriModel::find(4);

    //     try {
    //         // Panggil metode update dan tangkap respon
    //         $response = $controller->update($request, $kamar);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         // Assert bahwa validasi gagal dan error ada di session
    //         $errors = $e->validator->errors();

    //         // Assert pesan error yang sesuai
    //         $this->assertEquals('Kolom nama kamar wajib diisi.', $errors->first('nama_kamar'));
    //     }

    //     // Pastikan data lama tetap ada dan tidak berubah di database
    //     $this->assertDatabaseHas('tb_kamar', [
    //         'nama_kamar' => $kamar->nama_kamar // Nama kamar sebelum update
    //     ]);
    // }

    // public function testDestroyKamar()
    // {
    //     // Buat instance controller
    //     $controller = new \App\Http\Controllers\KamarSantrictrl;

    //     // Ambil data Kamar dengan id 4
    //     $kamar = KamarSantriModel::find(4);

    //     // Pastikan data ada sebelum dihapus
    //     $this->assertNotNull($kamar);

    //     // Fake session
    //     Session::start(); // Pastikan session dimulai

    //     // Panggil metode destroy
    //     $response = $controller->destroy($kamar);

    //     // Pastikan data tidak ada lagi di database
    //     $this->assertDatabaseMissing('tb_kamar', [
    //         'id_kamar' => 4,
    //     ]);
    // }

}
