<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\KamarSantriModel;

class KamarSantriTest extends TestCase
{
    // use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Ambil user admin yang sudah ada di database
        $this->admin = User::where('email', 'admin@gmail.com')->first();
    }

    public function test_view_kamar_santri()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $response = $this->get(route('kamar_santri.index'));
        $response->assertStatus(200);
    }

    public function test_kamar_santri_data_valid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $data = [
            'nama_kamar' => 'Hijrah 22', // Data valid
        ];

        $response = $this->post(route('kamar_santri.store'), $data);
        // dd($response->headers->get('Location'));
        $response->assertRedirect(route('kamar_santri.index'));
        $this->assertDatabaseHas('tb_kamar', $data);
    }

    public function test_kamar_santri_data_invalid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Membuat data dengan nama kamar melebihi panjang maksimum
        $data = [
            'nama_kamar' => 'Pada tahap ini, proses perancangan desain aplikasi
            dimulai. Pada tahap awal dilakukan perancangan wireframe. Wireframe merupakan rancangan awal yang menggambarkan
            tampilan pada aplikasi sebenarnya.', // Melebihi panjang maksimum 50 karakter
        ];

        $response = $this->from(route('kamar_santri.create'))
            ->post(route('kamar_santri.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);

        $response->assertRedirect(route('kamar_santri.create'));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_kamar');

    }


    public function test_kamar_santri_invalid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $data = [];

        $response = $this->from(route('kamar_santri.create'))
        ->post(route('kamar_santri.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_kamar');

        $response->assertRedirect(route('kamar_santri.create'));


    }

    public function test_kamar_santri_edit()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data kamar santri dari database dengan id_kamar 8
        $kamarSantri = KamarSantriModel::find(2);

        // Memastikan bahwa data kamar santri yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('kamar_santri.edit', $kamarSantri->id_kamar));
        $response->assertSee($kamarSantri->nama_kamar);

        // Simulasi pengiriman data yang diperbarui
        $updatedData = [
            'nama_kamar' => 'Kamar 9', // Data yang diperbarui
        ];

        // Melakukan permintaan untuk menyimpan perubahan data kamar santri
        $response = $this->put(route('kamar_santri.update', $kamarSantri->id_kamar), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman indeks setelah berhasil menyimpan perubahan
        $response->assertRedirect(route('kamar_santri.index'));

        // Memastikan bahwa perubahan data sudah tersimpan di database
        $this->assertDatabaseHas('tb_kamar', $updatedData);
    }

    public function test_kamar_santri_edit_invalid_data()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data kamar santri dari database dengan id_kamar 8
        $kamarSantri = KamarSantriModel::find(2);

        // Memastikan bahwa data kamar santri yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('kamar_santri.edit', $kamarSantri->id_kamar));
        $response->assertStatus(200);
        $response->assertSee($kamarSantri->nama_kamar);

        // Simulasi pengiriman data yang tidak valid (kosong)
        $updatedData = [
            'nama_kamar' => '', // Data yang tidak valid (kosong)
        ];

        // Melakukan permintaan untuk menyimpan perubahan data kamar santri
        $response = $this->put(route('kamar_santri.update', $kamarSantri->id_kamar), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman edit setelah gagal menyimpan perubahan
        $response->assertRedirect(route('kamar_santri.edit', $kamarSantri->id_kamar));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_kamar');

        // Memastikan bahwa data kamar santri tidak berubah di database
        $this->assertDatabaseMissing('tb_kamar', ['nama_kamar' => '']);
    }

    public function test_kamar_santri_edit_invalid_lebih_data()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data kamar santri dari database dengan id_kamar 8
        $kamarSantri = KamarSantriModel::find(2);

        // Memastikan bahwa data kamar santri yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('kamar_santri.edit', $kamarSantri->id_kamar));
        $response->assertStatus(200);
        $response->assertSee($kamarSantri->nama_kamar);

        // Simulasi pengiriman data yang tidak valid (kosong)
        $updatedData = [
            'nama_kamar' => 'Pada tahap ini, proses perancangan desain aplikasi
            dimulai. Pada tahap awal dilakukan perancangan wireframe. Wireframe merupakan rancangan awal yang menggambarkan
            tampilan pada aplikasi sebenarnya.', // Data yang tidak valid (kosong)
        ];

        // Melakukan permintaan untuk menyimpan perubahan data kamar santri
        $response = $this->put(route('kamar_santri.update', $kamarSantri->id_kamar), $updatedData);

        // Memastikan bahwa pengguna diarahkan kembali ke halaman edit setelah gagal menyimpan perubahan
        $response->assertRedirect(route('kamar_santri.edit', $kamarSantri->id_kamar));

        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_kamar');

        // Memastikan bahwa data kamar santri tidak berubah di database
        $this->assertDatabaseMissing('tb_kamar', ['nama_kamar' => '']);
    }

    public function test_kamar_santri_delete()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data kamar santri dari database dengan id_kamar 8
        $kamarSantri = KamarSantriModel::find(4);

        // Melakukan permintaan untuk menghapus data kamar santri
        $response = $this->delete(route('kamar_santri.destroy', $kamarSantri->id_kamar));

        // Memastikan bahwa pengguna diarahkan kembali ke halaman indeks setelah berhasil menghapus data
        $response->assertRedirect(route('kamar_santri.index'));

        // Memastikan bahwa data kamar santri sudah terhapus dari database
        $this->assertDatabaseMissing('tb_kamar', ['id_kamar' => $kamarSantri->id_kamar]);
    }

}
