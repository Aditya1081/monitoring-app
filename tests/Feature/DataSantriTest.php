<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\DataSantriModel;
use App\Models\User; // Import the User model

class DataSantriTest extends TestCase
{
    /**
     * Test menambahkan data santri baru.
     *
     * @return void
     */
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Ambil user admin yang sudah ada di database
        $this->admin = User::where('email', 'admin@gmail.com')->first();
    }

    public function test_1_lihat_data_santri()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $response = $this->get(route('data_santri.index'));
        $response->assertStatus(200);
    }

    // public function test_1_tambah_Data_Santri_valid()
    // {
    //     // Login sebagai admin yang sudah ada
    //      $this->actingAs($this->admin);

    //     // Data santri baru yang akan diuji
    //     $data = [
    //         'id_kamar' => 1, // Ganti dengan ID kamar yang tersedia
    //         'id_kelas' => 1, // Ganti dengan ID kelas yang tersedia
    //         'nama_santri' => 'Irma Dwi',
    //         'NIS' => '12345678901', // Ganti dengan NIS yang valid
    //         'NIK' => '123456789012', // Ganti dengan NIK yang valid
    //         'NISN' => '1357924680123', // Ganti dengan NISN yang valid
    //         'kota_lahir' => 'Banyuwangi',
    //         'tanggal_lahir' => '2001-01-01', // Format tanggal yang valid
    //         'jenis_kelamin' => 'Perempuan', // Atau 'Perempuan'
    //         'alamat' => 'Banyuwangi',
    //         'no_telp_wali' => '085707277767', // Nomor telepon wali yang valid
    //         'nama_wali_santri' => 'Febriana',
    //         'no_va' => '1234567890', // Nomor VA yang valid
    //         'id_kelas_madin' => '1',
    //         'id_jilid' => '1'
    //     ];

    //     // Melakukan request POST ke endpoint store
    //     $response = $this->post(route('data_santri.store'), $data);

    //     // Memastikan redirect berhasil dilakukan setelah penyimpanan data
    //     $response->assertRedirect();

    //     // Memastikan data santri berhasil ditambahkan ke dalam database
    //     $this->assertDatabaseHas('tb_data_santri', ['nama_santri' => 'Irma Dwi']);
    // }

    public function test_2_tambah_data_santri_invalid_tambah_data_kosong()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

         // Data santri baru yang akan diuji
         $data = [
            'id_kamar' => 1, // Ganti dengan ID kamar yang tersedia
            'id_kelas' => 1, // Ganti dengan ID kelas yang tersedia
            'nama_santri' => 'Irma Dwi',
            'NIS' => '12345678901', // Ganti dengan NIS yang valid
            'NIK' => '123456789012', // Ganti dengan NIK yang valid
            'NISN' => '', // Ganti dengan NISN yang valid
            'kota_lahir' => 'Banyuwangi',
            'tanggal_lahir' => '', // Format tanggal yang valid
            'jenis_kelamin' => 'Perempuan', // Atau 'Perempuan'
            'alamat' => 'Banyuwangi',
            'no_telp_wali' => '085707277767', // Nomor telepon wali yang valid
            'nama_wali_santri' => 'Febriana',
            'no_va' => '1234567890', // Nomor VA yang valid
            'id_kelas_madin' => '1',
            'id_jilid' => '1'
        ];

        $response = $this->from(route('data_santri.create'))
            ->post(route('data_santri.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);
        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('NISN', 'tanggal_lahir');
        $response->assertRedirect(route('data_santri.create'));
    }

    public function test_4_tambah_data_santri_invalid_tambah_data_melebihi_batas_maksimum()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Membuat data dengan point data_santri melebihi panjang maksimum
        $data = [
            'id_kamar' => 1, // Ganti dengan ID kamar yang tersedia
            'id_kelas' => 1, // Ganti dengan ID kelas yang tersedia
            'nama_santri' => 'Irma Dwi',
            'NIS' => '12345678901', // Ganti dengan NIS yang valid
            'NIK' => '12345678901234567', // Ganti dengan NIK yang valid
            'NISN' => '135792468012345678', // Ganti dengan NISN yang valid
            'kota_lahir' => 'Banyuwangi',
            'tanggal_lahir' => '2001-01-01', // Format tanggal yang valid
            'jenis_kelamin' => 'Perempuan', // Atau 'Perempuan'
            'alamat' => 'Banyuwangi',
            'no_telp_wali' => '085707277767', // Nomor telepon wali yang valid
            'nama_wali_santri' => 'Febriana',
            'no_va' => '1234567890', // Nomor VA yang valid
            'id_kelas_madin' => '1',
            'id_jilid' => '1'
        ];

        $response = $this->from(route('data_santri.create'))
            ->post(route('data_santri.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);
        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('NIK', 'NISN');
        $response->assertRedirect(route('data_santri.create'));
    }

    public function test_5_tambah_data_santri_invalid_tambah_data_kosong_dan_lebih()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        $data = [
            'id_kamar' => 1, // Ganti dengan ID kamar yang tersedia
            'id_kelas' => 1, // Ganti dengan ID kelas yang tersedia
            'nama_santri' => '',
            'NIS' => '12345678901', // Ganti dengan NIS yang valid
            'NIK' => '123456789012', // Ganti dengan NIK yang valid
            'NISN' => '135792468012345678', // Ganti dengan NISN yang valid
            'kota_lahir' => 'Banyuwangi',
            'tanggal_lahir' => '2001-01-01', // Format tanggal yang valid
            'jenis_kelamin' => 'Perempuan', // Atau 'Perempuan'
            'alamat' => 'Banyuwangi',
            'no_telp_wali' => '085707277767', // Nomor telepon wali yang valid
            'nama_wali_santri' => 'Febriana',
            'no_va' => '1234567890', // Nomor VA yang valid
            'id_kelas_madin' => '1',
            'id_jilid' => '1'
        ];

        $response = $this->from(route('data_santri.create'))
            ->post(route('data_santri.store'), $data);

        // Memastikan bahwa respons kembali dengan status yang sesuai (biasanya 302 untuk redirect)
        $response->assertStatus(302);
        // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
        $response->assertSessionHasErrors('nama_santri', 'NISN');
        $response->assertRedirect(route('data_santri.create'));
    }

    // public function test_6_edit_data_santri_valid()
    // {
    //     // Login sebagai admin yang sudah ada
    //     $this->actingAs($this->admin);

    //     // Mengambil data data_santri dari database dengan id_data_santri 3
    //     $data_santri = DataSantriModel::find(5);

    //     // Memastikan bahwa data data_santri yang ingin diedit tersedia di halaman edit
    //     $response = $this->get(route('data_santri.edit', $data_santri->id_santri));
    //     $response->assertSee($data_santri->nama_santri);
    //     $response->assertSee($data_santri->tanggal_lahir);
    //     $response->assertSee($data_santri->alamat);

    //     // Simulasi pengiriman data yang diperbarui
    //     $updatedData = [
    //         'id_kamar' => 1, // Ganti dengan ID kamar yang tersedia
    //         'id_kelas' => 1, // Ganti dengan ID kelas yang tersedia
    //         'nama_santri' => 'Cendy Tri Aulia',
    //         'NIS' => '12345678901', // Ganti dengan NIS yang valid
    //         'NIK' => '123456789012', // Ganti dengan NIK yang valid
    //         'NISN' => '1357924680123', // Ganti dengan NISN yang valid
    //         'kota_lahir' => 'Banyuwangi',
    //         'tanggal_lahir' => '2008-01-27', // Format tanggal yang valid
    //         'jenis_kelamin' => 'Perempuan', // Atau 'Perempuan'
    //         'alamat' => 'Desa Siliragung Kabupaten Banyuwangi',
    //         'no_telp_wali' => '085707277767', // Nomor telepon wali yang valid
    //         'nama_wali_santri' => 'Febriana',
    //         'no_va' => '1234567890', // Nomor VA yang valid
    //         'id_kelas_madin' => '1',
    //         'id_jilid' => '1'
    //     ];

    //     // Melakukan permintaan untuk menyimpan perubahan data data_santri
    //     $response = $this->put(route('data_santri.update', $data_santri->id_santri), $updatedData);

    //     // Memastikan bahwa pengguna diarahkan kembali ke halaman indeks setelah berhasil menyimpan perubahan
    //     $response->assertStatus(302);
    //     $response->assertRedirect(route('data_santri.index'));

    //     // Memastikan bahwa perubahan data sudah tersimpan di database
    //     $this->assertDatabaseHas('tb_data_santri', $updatedData);
    // }


    // public function test_7_edit_invalid_data_santri_kosong_dan_data_lebih()
    // {
    //     // Login sebagai admin yang sudah ada
    //     $this->actingAs($this->admin);

    //     // Mengambil data data_santri dari database dengan id_santri 5
    //     $data_santri = DataSantriModel::find(5);

    //     // Memastikan bahwa data data_santri yang ingin diedit tersedia di halaman edit
    //     $response = $this->get(route('data_santri.edit', $data_santri->id_santri));
    //     $response->assertStatus(200);
    //     $response->assertSee($data_santri->nama_santri);
    //     $response->assertSee($data_santri->NIS);
    //     $response->assertSee($data_santri->tanggal_lahir);

    //     // Simulasi pengiriman data yang tidak valid (kosong) dan lebih dari batas maksimal
    //     $data = [
    //         'id_kamar' => 1, // Ganti dengan ID kamar yang tersedia
    //         'id_kelas' => 1, // Ganti dengan ID kelas yang tersedia
    //         'nama_santri' => 'Cendy Tri Aulia',
    //         'NIS' => '123456789012345678', // NIS lebih dari batas maksimal
    //         'NIK' => '123456789012', // Ganti dengan NIK yang valid
    //         'NISN' => '1357924680123', // Ganti dengan NISN yang valid
    //         'kota_lahir' => 'Banyuwangi',
    //         'tanggal_lahir' => '', // Tanggal lahir kosong
    //         'jenis_kelamin' => 'Perempuan', // Atau 'Perempuan'
    //         'alamat' => 'Desa Siliragung Kabupaten Banyuwangi',
    //         'no_telp_wali' => '085707277767', // Nomor telepon wali yang valid
    //         'nama_wali_santri' => 'Febriana',
    //         'no_va' => '1234567890', // Nomor VA yang valid
    //         'id_kelas_madin' => '1',
    //         'id_jilid' => '1'
    //     ];

    //     // Melakukan permintaan untuk menyimpan perubahan data data_santri
    //     $response = $this->put(route('data_santri.update', $data_santri->id_santri), $data);

    //     // Memastikan bahwa pengguna diarahkan kembali ke halaman edit setelah gagal menyimpan perubahan
    //     $response->assertStatus(302);
    //     $response->assertRedirect(route('data_santri.edit', $data_santri->id_santri));

    //     // Memastikan bahwa pesan kesalahan yang sesuai dikembalikan kepada pengguna
    //     $response->assertSessionHasErrors(['NIS', 'tanggal_lahir']);

    //     // Memastikan bahwa data data_santri tidak berubah di database
    //     $this->assertDatabaseMissing('tb_data_santri', [
    //         'NIS' => '123456789012345678',
    //         'tanggal_lahir' => ''
    //     ]);
    // }

    // public function test_10_data_santri_delete()
    // {
    //     // Login sebagai admin yang sudah ada
    //     $this->actingAs($this->admin);

    //     // Mengambil data data_santri dari database dengan id_data_santri 5
    //     $data_santri = DataSantriModel::find(5);

    //     // Melakukan permintaan untuk menghapus data data_santri
    //     $response = $this->delete(route('data_santri.destroy', $data_santri->id_santri));

    //     // Memastikan bahwa pengguna diarahkan kembali ke halaman indeks setelah berhasil menghapus data
    //     $response->assertRedirect(route('data_santri.index'));

    //     // Memastikan bahwa data data_santri sudah terhapus dari database
    //     $this->assertDatabaseMissing('tb_data_santri', ['id_santri' => $data_santri->id_santri]);
    // }

    // public function test_show_data_santri()
    // {
    //     // Login sebagai admin yang sudah ada
    //     $this->actingAs($this->admin);

    //     // Mengambil data data_santri dari database dengan id_data_santri 5
    //     $data_santri = DataSantriModel::find(1);

    //     // Mengakses halaman detail data santri
    //     $response = $this->get(route('data_santri.detail', $data_santri->id_santri));

    //     // Memastikan halaman ditampilkan dengan status 200
    //     $response->assertStatus(200);

    //     $response->assertSee('Aditya Lukman Syah');
    //     $response->assertSee('1234567890');
    //     $response->assertSee('Banyuwangi');
    //     $response->assertSee('27 Juni 2024');
    // }

    public function test_show_data_santri()
    {
        // Login sebagai admin yang sudah ada
        $this->actingAs($this->admin);

        // Mengambil data data_santri dari database dengan id_santri 1
        $data_santri = DataSantriModel::find(1);

        // Memastikan data santri yang diambil memiliki nama yang diharapkan
        $this->assertEquals('Aditya Lukman Syah', $data_santri->nama_santri);

        // Mengakses halaman detail data santri
        $response = $this->get(route('data_santri.detail', $data_santri->id_santri));

        // Memastikan halaman ditampilkan dengan status 200
        $response->assertStatus(200);

        // Memastikan halaman detail menampilkan data yang benar
        $response->assertSee('Aditya Lukman Syah');

        // Jika 1234567890 adalah NIK
        // $response->assertSee($data_santri->NIK);

        // Jika 1234567890 adalah NIS
        // $response->assertSee($data_santri->nis);

        // Jika 1234567890 adalah NISN
        // $response->assertSee($data_santri->nisn);

        $response->assertSee('Banyuwangi');
        $response->assertSee('27 Juni 2024');
    }

}
