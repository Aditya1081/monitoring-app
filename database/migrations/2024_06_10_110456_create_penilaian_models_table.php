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
        Schema::create('tb_nilai_madin', function (Blueprint $table) {
            $table->bigIncrements('id_nilai_madin'); // ID unik dengan auto increment
            $table->unsignedbigInteger('id_santri'); // Id santri yang digunakan untuk foreign key
            $table->bigInteger('id_kelas_madin'); // Id santri yang digunakan untuk foreign key
            $table->bigInteger('id_mapel_madin'); // Id santri yang digunakan untuk foreign key
            $table->string('nilai', 5); // Nama pelanggaran
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
        Schema::dropIfExists('penilaian_models');
    }
};
