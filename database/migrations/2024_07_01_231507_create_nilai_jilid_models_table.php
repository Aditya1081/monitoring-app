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
        Schema::create('tb_nilai_jilid', function (Blueprint $table) {
            $table->bigIncrements('id_nilai_jilid'); // ID unik dengan auto increment
            $table->unsignedbigInteger('id_santri'); // Id santri yang digunakan untuk foreign key
            $table->bigInteger('id_jilid'); // Id santri yang digunakan untuk foreign key
            $table->string('keterangan_nilai', 5); // Nama pelanggaran
            $table->string('halaman', 5); // Nama pelanggaran
            $table->string('catatan', 100)->nullable(); // Nama pelanggaran
            $table->date('tanggal_penilaian'); // Tanggal absensi
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
        Schema::dropIfExists('nilai_jilid_models');
    }
};
