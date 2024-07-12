<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\AbsensiModel;

class AbsensiTest extends TestCase
{
    // use RefreshDatabase;
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Ambil user admin yang sudah ada di database
        $this->admin = User::where('email', 'admin@gmail.com')->first();
    }

    public function test_view_absensi()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $response = $this->get(route('absensi.index'));
        $response->assertStatus(200);
    }

    public function test_absensi_data_valid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $data = [
            'id_santri' => '1',
            'id_kamar' => '1',
            'jenis_absensi' => 'Pagi',
            'tanggal_absensi' => '2024-05-23',
            'status_absensi' => 'hadir',
        ];

        $response = $this->post(route('absensi.store'), $data);
        $response->assertRedirect(route('absensi.index'));
        $this->assertDatabaseHas('tb_absensi', $data);
    }
}
