<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PerizinanModel;

class PerizinanTest extends TestCase
{
    // use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Ambil user admin yang sudah ada di database
        $this->admin = User::where('email', 'admin@gmail.com')->first();
    }

    public function test_1_view_perizinan()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $response = $this->get(route('perizinan.index'));
        $response->assertStatus(200);
    }

    public function test_2_create_perizinan_create_data_valid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $data = [
            'id_santri' => '1',
            'id_kamar' => '1',
            'nama_perizinan' => 'kunjungan wisata pendidikan',
            'tanggal_mulai' => '2024-05-25',
            'tanggal_akhir' => '2024-05-28',
            'deskripsi_perizinan' => 'perjalanan selama 3 hari', // boleh dikosongi
        ];

        $response = $this->post(route('perizinan.store'), $data);
        // dd($response->headers->get('Location'));
        $response->assertRedirect(route('perizinan.index'));
        $this->assertDatabaseHas('tb_perizinan', $data);
    }

    public function test_3_create_perizinan_invalid_data_kosong()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Membuat data dengan nama kamar melebihi panjang maksimum
        $data = [
            'id_santri' => '',
            'id_kamar' => '1',
            'nama_perizinan' => 'kunjungan wisata pendidikan',
            'tanggal_mulai' => '2024-05-25',
            'tanggal_akhir' => '2024-05-28',
            'deskripsi_perizinan' => '', // boleh dikosongi
        ];

        $response = $this->from(route('perizinan.create'))
            ->post(route('perizinan.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);

        $response->assertRedirect(route('perizinan.create'));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('id_santri');

    }

    public function test_4_create_perizinan_invalid_data_kosong_2()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Membuat data dengan nama kamar melebihi panjang maksimum
        $data = [
            'id_santri' => '1',
            'id_kamar' => '1',
            'nama_perizinan' => 'kunjungan wisata pendidikan',
            'tanggal_mulai' => '',
            'tanggal_akhir' => '',
            'deskripsi_perizinan' => 'perjalanan selama 3 hari', // boleh dikosongi
        ];

        $response = $this->from(route('perizinan.create'))
            ->post(route('perizinan.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);

        $response->assertRedirect(route('perizinan.create'));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('tanggal_mulai', 'tanggal_akhir');
    }

    public function test_5_create_perizinan_invalid_data_lebih()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $data = [
            'id_santri' => '1',
            'id_kamar' => '1',
            'nama_perizinan' => 'Izin untuk melaksanakan kunjungan wisata pendidikan ke Museum Nasional Indonesia pada tanggal 25 mei 2024. Kegiatan ini bertujuan untuk menambah wawasan siswa mengenai sejarah dan budaya Indonesia.', // teks melebihi batas maksimum 50 karakter
            'tanggal_mulai' => '2024-05-25',
            'tanggal_akhir' => '2024-05-28',
            'deskripsi_perizinan' => 'perjalanan selama 3 hari', // boleh dikosongi
        ];

        $response = $this->from(route('perizinan.create'))
        ->post(route('perizinan.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_perizinan');

        $response->assertRedirect(route('perizinan.create'));
    }
}
