<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_data_santri', function (Blueprint $table) {
            $table->bigIncrements('id_santri'); // ID unik dengan auto increment
            $table->bigInteger('id_kamar'); // Id kamar yang digunakan untuk foreign key
            $table->bigInteger('id_kelas'); // Id kelas yang digunakan untuk foreign key
            $table->string('nama_santri', 50); // Nama santri
            $table->string('NIS', 16)->unique(); // NIS unik dengan panjang maksimal 16 karakter
            $table->string('NISN', 16)->unique(); // NISN unik dengan panjang maksimal 16 karakter
            $table->string('NIK', 16)->unique(); // NIK unik dengan panjang maksimal 16 karakter
            $table->string('kota_lahir', 50); // Kota kelahiran
            $table->date('tanggal_lahir'); // Tanggal lahir
            $table->string('jenis_kelamin', 10); // Jenis kelamin
            $table->text('alamat'); // Alamat panjang
            $table->string('no_telp_wali', 15); // No. telepon wali
            $table->string('nama_wali_santri', 50); // Nama Wali Santri
            $table->string('no_va', 15); // Nama Wali Santri
            $table->bigInteger('id_kelas_madin')->nullable(); // Kelas madin, boleh kosong
            $table->bigInteger('id_jilid')->nullable(); // Kelas TPQ, boleh kosong
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_data_santri'); // Menghapus tabel jika migrasi dibatalkan
    }
};
