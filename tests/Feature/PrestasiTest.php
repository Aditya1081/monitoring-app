<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PrestasiModel;
use App\Models\User;

class PrestasiTest extends TestCase
{
    // use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Ambil user admin yang sudah ada di database
        $this->admin = User::where('email', 'admin@gmail.com')->first();
    }

    public function test_1_view_prestasi()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $response = $this->get(route('prestasi.index'));
        $response->assertStatus(200);
    }

    public function test_2_prestasi_create_data_valid()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Buat file palsu untuk diunggah
        $file = \Illuminate\Http\UploadedFile::fake()->create('prestasi.png', 1024, 'image/png');

        // Siapkan data termasuk unggahan file
        $data = [
            'id_kamar'     => '1',
            'id_santri'     => '2',
            'nama_prestasi' => 'Juara 1 Lomba Dakwah',
            'deskripsi'     => 'Juara 1 dari 10 peserta di kabupaten Banyuwangi',
            'tanggal_prestasi' => '2024-05-06',
            'file_prestasi' => $file,
        ];

        // Lakukan permintaan POST termasuk unggahan file
        $response = $this->post(route('prestasi.store'), $data);

        // Periksa apakah respons adalah pengalihan ke rute yang diharapkan
        $response->assertRedirect(route('prestasi.index'));

        // Verifikasi bahwa catatan ada di database
        // Catatan: Kecualikan 'file_prestasi' dari pemeriksaan database karena nilainya diproses dan disimpan secara berbeda (misalnya, jalur file)
        $this->assertDatabaseHas('tb_prestasi', [
            'id_kamar' => '1',
            'id_santri' => '2',
            'nama_prestasi' => 'Juara 1 Lomba Dakwah',
            'deskripsi' => 'Juara 1 dari 10 peserta di kabupaten Banyuwangi',
            'tanggal_prestasi' => '2024-05-06',
            'file_prestasi' => 'images/prestasi/' . date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . '_prestasi.png',
        ]);

        // Periksa apakah file berhasil diunggah
        \Storage::disk('public')->assertExists('images/prestasi/' . date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . '_prestasi.png');
    }

    public function test_3_prestasi_create_data_invalid_kosong()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Siapkan data dengan kolom id_santri dan file_prestasi kosong
        $data = [
            'id_kamar'     => '1',
            'id_santri'    => '',  // Kosong
            'nama_prestasi' => 'Juara 1 Lomba Dakwah',
            'deskripsi'     => 'Juara 1 dari 10 peserta di kabupaten Banyuwangi',
            'tanggal_prestasi' => '2024-05-06',
            'file_prestasi' => '',  // Kosong
        ];

        $response = $this->from(route('prestasi.create'))
            ->post(route('prestasi.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);

        $response->assertRedirect(route('prestasi.create'));

        // Periksa apakah respons mengandung kesalahan validasi
        $response->assertSessionHasErrors(['id_santri', 'file_prestasi']);
    }

    public function test_4_prestasi_edit()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data prestasi dari database dengan id tertentu, misalnya id 2
        $prestasi = PrestasiModel::find(2);

        // Memastikan bahwa data prestasi yang ingin diedit tersedia di halaman edit
        $response = $this->get(route('prestasi.edit', ['prestasi' => $prestasi->id_prestasi]));
        $response->assertSee($prestasi->nama_prestasi);

        // Buat file palsu untuk diunggah
        $file = \Illuminate\Http\UploadedFile::fake()->create('prestasi_baru.png', 1024, 'image/png');

        // Simulasi pengiriman data yang diperbarui
        $updatedData = [
            'id_kamar' => '1',
            'id_santri' => '2',
            'nama_prestasi' => 'Juara 2 Lomba Dakwah', // Data yang diperbarui
            'deskripsi' => 'Juara 2 dari 15 peserta di kabupaten Banyuwangi',
            'tanggal_prestasi' => '2024-06-10',
            'file_prestasi' => $file, // Foto baru
        ];

        // Melakukan permintaan untuk menyimpan perubahan data prestasi
        $response = $this->put(route('prestasi.update', ['prestasi' => $prestasi->id_prestasi]), $updatedData);
        $response->assertStatus(302);
        // Memastikan bahwa pengguna diarahkan kembali ke halaman indeks setelah berhasil menyimpan perubahan
        $response->assertRedirect(route('prestasi.index'));

        // Memastikan bahwa perubahan data sudah tersimpan di database
        $this->assertDatabaseHas('tb_prestasi', [
            'id_prestasi' => $prestasi->id_prestasi,
            'id_kamar' => '1',
            'id_santri' => '2',
            'nama_prestasi' => 'Juara 2 Lomba Dakwah',
            'deskripsi' => 'Juara 2 dari 15 peserta di kabupaten Banyuwangi',
            'tanggal_prestasi' => '2024-06-10',
            'file_prestasi' => 'images/prestasi/' . date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . '_prestasi_baru.png',
        ]);

        // Periksa apakah file baru berhasil diunggah
        \Storage::disk('public')->assertExists('images/prestasi/' . date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . '_prestasi_baru.png');
    }

    public function test_5_prestasi_delete()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data prestasi dari database dengan id_prestasi 4
        $prestasi = PrestasiModel::find(4);

        // Melakukan permintaan untuk menghapus data prestasi
        $response = $this->delete(route('prestasi.destroy', $prestasi->id_prestasi));

        // Memastikan bahwa pengguna diarahkan kembali ke halaman indeks setelah berhasil menghapus data
        $response->assertRedirect(route('prestasi.index'));

        // Memastikan bahwa data prestasi sudah terhapus dari database
        $this->assertDatabaseMissing('tb_prestasi', ['id_prestasi' => $prestasi->id_prestasi]);
    }
}
