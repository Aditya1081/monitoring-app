<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PelanggaranModel;

class PelanggaranTest extends TestCase
{
    // use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Ambil user admin yang sudah ada di database
        $this->admin = User::where('email', 'admin@gmail.com')->first();
    }

    public function test_1_view_data_pelanggaran_santri()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $response = $this->get(route('pelanggaran.index'));
        $response->assertStatus(200);
    }

    public function test_2_pelanggaran_tambah_data_valid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Menambahkan data ynag valid (sesuai)
        $data = [
            'id_santri' => '1',
            'id_kamar' => '1',
            'nama_pelanggaran' => 'terlambat',
            'point' => '10',
            'deskripsi_pelanggaran' => 'Terlamat 15 menit',
            'tanggal_pelanggaran' => '2024-05-25',
        ];

        $response = $this->post(route('pelanggaran.store'), $data);
        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);
        $response->assertRedirect(route('pelanggaran.index'));
        $this->assertDatabaseHas('tb_pelanggaran', $data);
    }

    public function test_3_pelanggaran_invalid_tambah_data_kosong()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $data = [
            'id_santri' => '', // data dikosongi
            'id_kamar' => '1',
            'nama_pelanggaran' => 'terlambat',
            'point' => '', // data dikosongi
            'deskripsi_pelanggaran' => 'terlambat 15 menit',
            'tanggal_pelanggaran' => '2024-05-25',
        ];

        $response = $this->from(route('pelanggaran.create'))
            ->post(route('pelanggaran.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);
        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('id_santri', 'point');
        $response->assertRedirect(route('pelanggaran.create'));
    }

    public function test_4_pelanggaran_invalid_tambah_data_melebihi_batas_maksimum()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Membuat data dengan point pelanggaran melebihi panjang maksimum
        $data = [
            'id_santri' => '1',
            'id_kamar' => '1',
            'nama_pelanggaran' => 'terlambat',
            'point' => '123456', // data dilebihi
            'deskripsi_pelanggaran' => 'terlambat 15 menit',
            'tanggal_pelanggaran' => '2024-05-25',
        ];

        $response = $this->from(route('pelanggaran.create'))
            ->post(route('pelanggaran.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);
        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('point');
        $response->assertRedirect(route('pelanggaran.create'));
    }

    public function test_5_pelanggaran_invalid_tambah_data_kosong_dan_lebih()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $data = [
            'id_santri' => '1',
            'id_kamar' => '1',
            'nama_pelanggaran' => '', // data dikosongi
            'point' => '123456', // data lebih dari batas maksimal
            'deskripsi_pelanggaran' => 'terlambat 30 menit',
            'tanggal_pelanggaran' => '2024-05-25',
        ];

        $response = $this->from(route('pelanggaran.create'))
            ->post(route('pelanggaran.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);
        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_pelanggaran', 'point');
        $response->assertRedirect(route('pelanggaran.create'));
    }

    public function test_6_pelanggaran_edit_valid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data pelanggaran dari database dengan id_pelanggaran 3
        $pelanggaran = pelanggaranModel::find(3);

        // Memastikan bahwa data pelanggaran yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('pelanggaran.edit', $pelanggaran->id_pelanggaran));
        $response->assertSee($pelanggaran->nama_pelanggaran);
        $response->assertSee($pelanggaran->point);

        // Simulasi pengiriman data yang diperbarui
        $updatedData = [
            'nama_pelanggaran' => 'kabur',
            'point' => '20',
            'deskripsi_pelanggaran' => '', // data boleh kosong
            'tanggal_pelanggaran' => '2024-05-25',
        ];

        // Melakukan permintaan untuk menyimpan perubahan data pelanggaran
        $response = $this->put(route('pelanggaran.update', $pelanggaran->id_pelanggaran), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman indeks setelah berhasil menyimpan perubahan
        $response->assertStatus(302);
        $response->assertRedirect(route('pelanggaran.index'));

        // Memastikan bahwa perubahan data sudah tersimpan di database
        $this->assertDatabaseHas('tb_pelanggaran', $updatedData);
    }

    public function test_7_pelanggaran_santri_edit_invalid_data_kosong()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data pelanggaran santri dari database dengan id_pelanggaran 2
        $pelanggaran = pelanggaranModel::find(2);

        // Memastikan bahwa data pelanggaran yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('pelanggaran.edit', $pelanggaran->id_pelanggaran));
        $response->assertStatus(200);
        $response->assertSee($pelanggaran->nama_pelanggaran);

        // Simulasi pengiriman data yang tidak valid (kosong)
        $updatedData = [
            'nama_pelanggaran' => '', // data dikosongi
            'point' => '25',
            'deskripsi_pelanggaran' => 'keluar tanpa ijin',
            'tanggal_pelanggaran' => '2024-05-25',
        ];

        // Melakukan permintaan untuk menyimpan perubahan data pelanggaran
        $response = $this->put(route('pelanggaran.update', $pelanggaran->id_pelanggaran), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman edit setelah gagal menyimpan perubahan
        $response->assertRedirect(route('pelanggaran.edit', $pelanggaran->id_pelanggaran));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_pelanggaran');

        // Memastikan bahwa data pelanggaran tidak berubah di database
        $this->assertDatabaseMissing('tb_pelanggaran', ['nama_pelanggaran' => '']);
    }

    public function test_8_pelanggaran_edit_invalid_lebih_data()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data pelanggaran dari database dengan id_pelanggaran 2
        $pelanggaran = pelanggaranModel::find(2);

        // Memastikan bahwa data pelanggaran yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('pelanggaran.edit', $pelanggaran->id_pelanggaran));
        $response->assertStatus(200);
        $response->assertSee($pelanggaran->nama_pelanggaran);

        // Simulasi pengiriman data point lebih dari 5 karakter
        $updatedData = [
            'nama_pelanggaran' => 'kabur',
            'point' => '123456789',
            'deskripsi_pelanggaran' => 'keluar tanpa ijin',
            'tanggal_pelanggaran' => '2024-05-25',
        ];

        // Melakukan permintaan untuk menyimpan perubahan data pelanggaran
        $response = $this->put(route('pelanggaran.update', $pelanggaran->id_pelanggaran), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman edit setelah gagal menyimpan perubahan
        $response->assertRedirect(route('pelanggaran.edit', $pelanggaran->id_pelanggaran));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('point');

        // Memastikan bahwa data pelanggaran tidak berubah di database
        $this->assertDatabaseMissing('tb_pelanggaran', ['point' => '']);
    }



    public function test_9_pelanggaran_santri_edit_invalid_data_kosong_dan_lebih()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data pelanggaran santri dari database dengan id_pelanggaran 2
        $pelanggaran = pelanggaranModel::find(2);

        // Memastikan bahwa data pelanggaran yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('pelanggaran.edit', $pelanggaran->id_pelanggaran));
        $response->assertStatus(200);
        $response->assertSee($pelanggaran->nama_pelanggaran);
        $response->assertSee($pelanggaran->point);

        // Simulasi pengiriman data yang tidak valid (kosong)
        $updatedData = [
            'nama_pelanggaran' => '', // data dikosongi
            'point' => '123456789', // data lebih dari maksimal
            'deskripsi_pelanggaran' => 'keluar tanpa ijin',
            'tanggal_pelanggaran' => '2024-05-25',
        ];

        // Melakukan permintaan untuk menyimpan perubahan data pelanggaran
        $response = $this->put(route('pelanggaran.update', $pelanggaran->id_pelanggaran), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman edit setelah gagal menyimpan perubahan
        $response->assertRedirect(route('pelanggaran.edit', $pelanggaran->id_pelanggaran));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_pelanggaran', 'point');

        // Memastikan bahwa data pelanggaran tidak berubah di database
        $this->assertDatabaseMissing('tb_pelanggaran', ['nama_pelanggaran' => '']);
    }

    public function test_10_pelanggaran_delete()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data pelanggaran dari database dengan id_pelanggaran 5
        $pelanggaran = pelanggaranModel::find(10);

        // Melakukan permintaan untuk menghapus data pelanggaran
        $response = $this->delete(route('pelanggaran.destroy', $pelanggaran->id_pelanggaran));

        // Memastikan bahwa pengguna diarahkan kembali ke halaman indeks setelah berhasil menghapus data
        $response->assertRedirect(route('pelanggaran.index'));

        // Memastikan bahwa data pelanggaran sudah terhapus dari database
        $this->assertDatabaseMissing('tb_pelanggaran', ['id_pelanggaran' => $pelanggaran->id_pelanggaran]);
    }
}
