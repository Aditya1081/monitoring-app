<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\ParalelModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery;


class ParalelControllerTest extends TestCase
{

    public function test_store_paralel_with_valid_data()
    {
        $this->withoutMiddleware(); // Menonaktifkan middleware otentikasi sementara untuk pengujian

        // Mock model Paralel
        $mockParalel = Mockery::mock('alias:\App\Models\Paralel');
        $mockParalel->shouldReceive('create')->andReturn((object)['id' => 1, 'nama_kelas' => '9A']);

        // Mock request
        $request = new Request([
            'nama_kelas' => '9A'
        ]);

        // Fake session
        Session::start(); // Pastikan session dimulai

        // Buat instance controller
        $controller = new \App\Http\Controllers\Paralelctrl;

        // Panggil metode store
        $response = $controller->store($request);

        // Assert redirect
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('paralel.index'), $response->headers->get('Location'));

        // Assert session has success message
        $this->assertEquals('Paralel berhasil ditambahkan.', Session::get('success'));

        // Assert data in database
        $this->assertDatabaseHas('tb_kelas', [
            'nama_kelas' => '9A'
        ]);

        // Hentikan Mockery
        Mockery::close();
    }

}
