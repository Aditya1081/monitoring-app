<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\KelasMadinModel;
use App\Models\User;

class KelasMadinTest extends TestCase
{
    // use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Ambil user admin yang sudah ada di database
        $this->admin = User::where('email', 'admin@gmail.com')->first();
    }

    public function test_view_kelas_madin()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Lakukan pengujian
        $response = $this->get(route('kelas_madin.index'));
        $response->assertStatus(200);
    }

    public function test_create_data_kelas_madin_valid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $data = [
            'nama_kelas_madin' => 'Ulya 4', // Data valid
        ];

        $response = $this->post(route('kelas_madin.store'), $data);
        // dd($response->headers->get('Location'));
        $response->assertRedirect(route('kelas_madin.index'));
        $this->assertDatabaseHas('tb_kelas_madin', $data);
    }

    public function test_create_data_lebih_kelas_madin_invalid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Membuat data dengan nama kelas_madin melebihi panjang maksimum
        $data = [
            'nama_kelas_madin' => 'test uji coba lebih dari 20 karakter', // Melebihi panjang maksimum 20 karakter
        ];

        $response = $this->from(route('kelas_madin.create'))
            ->post(route('kelas_madin.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);

        $response->assertRedirect(route('kelas_madin.create'));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_kelas_madin');
    }

    public function test_create_data_kosong_kelas_madin_invalid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $data = [
            'nama_kelas_madin' => '', // Data dikosongi
        ];

        $response = $this->from(route('kelas_madin.create'))
        ->post(route('kelas_madin.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_kelas_madin');

        $response->assertRedirect(route('kelas_madin.create'));
    }

    public function test__edit_data_kelas_madin_valid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data kelas_madin dari database dengan id_kelas_madin 10
        $kelas_madin = KelasMadinModel::find(10);

        // Memastikan bahwa data kelas_madin yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('kelas_madin.edit', $kelas_madin->id_kelas_madin));
        $response->assertSee($kelas_madin->nama_kelas_madin);

        // Simulasi pengiriman data yang diperbarui
        $updatedData = [
            'nama_kelas_madin' => 'Ulya 6', // Data yang diperbarui
        ];

        // Melakukan permintaan untuk menyimpan perubahan data kelas_madin
        $response = $this->put(route('kelas_madin.update', $kelas_madin->id_kelas_madin), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman indeks setelah berhasil menyimpan perubahan
        $response->assertRedirect(route('kelas_madin.index'));

        // Memastikan bahwa perubahan data sudah tersimpan di database
        $this->assertDatabaseHas('tb_kelas_madin', $updatedData);
    }

    public function test_edit_data_kelas_madin_invalid_data_kosong()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data kelas_madin dari database dengan id_kelas_madin 11
        $kelas_madin = KelasMadinModel::find(11);

        // Memastikan bahwa data kelas_madin yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('kelas_madin.edit', $kelas_madin->id_kelas_madin));
        $response->assertStatus(200);
        $response->assertSee($kelas_madin ->nama_kelas_madin);

        // Simulasi pengiriman data yang tidak valid (kosong)
        $updatedData = [
            'nama_kelas_madin' => '', // Data yang tidak valid (kosong)
        ];

        // Melakukan permintaan untuk menyimpan perubahan data kelas_madin
        $response = $this->put(route('kelas_madin.update', $kelas_madin ->id_kelas_madin), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman edit setelah gagal menyimpan perubahan
        $response->assertRedirect(route('kelas_madin.edit', $kelas_madin ->id_kelas_madin));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_kelas_madin');

        // Memastikan bahwa data kelas_madin tidak berubah di database
        $this->assertDatabaseMissing('tb_kelas_madin', ['nama_kelas_madin' => '']);
    }

    public function test_kelas_madin_edit_invalid_data_lebih()
    {
         // Login sebagai admin yang sudah ada
         $this->actingAs($this->admin);

        // Mengambil data kelas_madin dari database dengan id_kelas_madin 11
        $kelas_madin = KelasMadinModel::find(11);

        // Memastikan bahwa data kelas_madin yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('kelas_madin.edit', $kelas_madin->id_kelas_madin));
        $response->assertStatus(200);
        $response->assertSee($kelas_madin->nama_kelas_madin);

        // Simulasi pengiriman data yang tidak valid (lebih)
        $updatedData = [
            'nama_kelas_madin' => 'test uji coba lebih dari 20 karakter', // Data yang tidak valid (lebih)
        ];

        // Melakukan permintaan untuk menyimpan perubahan data kelas_madin
        $response = $this->put(route('kelas_madin.update', $kelas_madin->id_kelas_madin), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman edit setelah gagal menyimpan perubahan
        $response->assertRedirect(route('kelas_madin.edit', $kelas_madin->id_kelas_madin));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_kelas_madin');

        // Memastikan bahwa data kelas_madin tidak berubah di database
        $this->assertDatabaseMissing('tb_kelas_madin', ['nama_kelas_madin' => '']);
    }

    public function test_kelas_madin_delete()
    {
         // Login sebagai admin yang sudah ada
         $this->actingAs($this->admin);

        // Mengambil data kelas_madin dari database dengan id_kelas_madin 8
        $kelas_madin = KelasMadinModel::find(12);

        // Melakukan permintaan untuk menghapus data kelas_madin
        $response = $this->delete(route('kelas_madin.destroy', $kelas_madin->id_kelas_madin));

        // Memastikan bahwa pengguna diarahkan kembali ke halaman indeks setelah berhasil menghapus data
        $response->assertRedirect(route('kelas_madin.index'));

        // Memastikan bahwa data kelas_madin sudah terhapus dari database
        $this->assertDatabaseMissing('tb_kelas_madin', ['id_kelas_madin' => $kelas_madin->id_kelas_madin]);
    }
}
