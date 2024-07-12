<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\JilidModel;
use App\Models\User;

class JilidTest extends TestCase
{
    // use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Ambil user admin yang sudah ada di database
        $this->admin = User::where('email', 'admin@gmail.com')->first();
    }

    public function test_view_jilid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Lakukan pengujian
        $response = $this->get(route('jilid.index'));
        $response->assertStatus(200);
    }

    public function test_create_data_jilid_valid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $data = [
            'nama_jilid' => 'Jilid 1', // Data valid
        ];

        $response = $this->post(route('jilid.store'), $data);
        // dd($response->headers->get('Location'));
        $response->assertRedirect(route('jilid.index'));
        $this->assertDatabaseHas('tb_jilid', $data);
    }

    public function test_create_data_lebih_jilid_invalid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Membuat data dengan nama jilid melebihi panjang maksimum
        $data = [
            'nama_jilid' => 'Al Quran Juz 12345', // Melebihi panjang maksimum 15 karakter
        ];

        $response = $this->from(route('jilid.create'))
            ->post(route('jilid.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);

        $response->assertRedirect(route('jilid.create'));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_jilid');
    }

    public function test_create_data_kosong_jilid_invalid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $data = [
            'nama_jilid' => '', // Data dikosongi
        ];

        $response = $this->from(route('jilid.create'))
        ->post(route('jilid.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_jilid');

        $response->assertRedirect(route('jilid.create'));
    }

    public function test__edit_data_jilid_valid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data jilid dari database dengan id_jilid 10
        $jilid = JilidModel::find(10);

        // Memastikan bahwa data jilid yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('jilid.edit', $jilid->id_jilid));
        $response->assertSee($jilid->nama_jilid);

        // Simulasi pengiriman data yang diperbarui
        $updatedData = [
            'nama_jilid' => 'Jilid 3', // Data yang diperbarui
        ];

        // Melakukan permintaan untuk menyimpan perubahan data jilid
        $response = $this->put(route('jilid.update', $jilid->id_jilid), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman indeks setelah berhasil menyimpan perubahan
        $response->assertRedirect(route('jilid.index'));

        // Memastikan bahwa perubahan data sudah tersimpan di database
        $this->assertDatabaseHas('tb_jilid', $updatedData);
    }

    public function test_edit_data_jilid_invalid_data_kosong()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data jilid dari database dengan id_jilid 11
        $jilid = JilidModel::find(11);

        // Memastikan bahwa data jilid yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('jilid.edit', $jilid->id_jilid));
        $response->assertStatus(200);
        $response->assertSee($jilid ->nama_jilid);

        // Simulasi pengiriman data yang tidak valid (kosong)
        $updatedData = [
            'nama_jilid' => '', // Data yang tidak valid (kosong)
        ];

        // Melakukan permintaan untuk menyimpan perubahan data jilid
        $response = $this->put(route('jilid.update', $jilid ->id_jilid), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman edit setelah gagal menyimpan perubahan
        $response->assertRedirect(route('jilid.edit', $jilid ->id_jilid));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_jilid');

        // Memastikan bahwa data jilid tidak berubah di database
        $this->assertDatabaseMissing('tb_jilid', ['nama_jilid' => '']);
    }

    public function test_jilid_edit_invalid_lebih_data()
    {
         // Login sebagai admin yang sudah ada
         $this->actingAs($this->admin);

        // Mengambil data jilid dari database dengan id_jilid 11
        $jilid = JilidModel::find(11);

        // Memastikan bahwa data jilid yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('jilid.edit', $jilid->id_jilid));
        $response->assertStatus(200);
        $response->assertSee($jilid->nama_jilid);

        // Simulasi pengiriman data yang tidak valid (lebih)
        $updatedData = [
            'nama_jilid' => 'Al Quran Juz 12345', // Data yang tidak valid (lebih)
        ];

        // Melakukan permintaan untuk menyimpan perubahan data jilid
        $response = $this->put(route('jilid.update', $jilid->id_jilid), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman edit setelah gagal menyimpan perubahan
        $response->assertRedirect(route('jilid.edit', $jilid->id_jilid));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_jilid');

        // Memastikan bahwa data jilid tidak berubah di database
        $this->assertDatabaseMissing('tb_jilid', ['nama_jilid' => '']);
    }

    public function test_jilid_delete()
    {
         // Login sebagai admin yang sudah ada
         $this->actingAs($this->admin);

        // Mengambil data jilid dari database dengan id_jilid 8
        $jilid = JilidModel::find(13);

        // Melakukan permintaan untuk menghapus data jilid
        $response = $this->delete(route('jilid.destroy', $jilid->id_jilid));

        // Memastikan bahwa pengguna diarahkan kembali ke halaman indeks setelah berhasil menghapus data
        $response->assertRedirect(route('jilid.index'));

        // Memastikan bahwa data jilid sudah terhapus dari database
        $this->assertDatabaseMissing('tb_jilid', ['id_jilid' => $jilid->id_jilid]);
    }
}

