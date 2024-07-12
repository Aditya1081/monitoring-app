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
        Schema::create('tb_prestasi', function (Blueprint $table) {
            $table->bigIncrements('id_prestasi');
            $table->bigInteger('id_santri'); // Id santri yang digunakan untuk foreign key
            $table->bigInteger('id_kamar'); // Id santri yang digunakan untuk foreign key
            $table->string('nama_prestasi');
            $table->string('slug_prestasi');
            $table->text('deskripsi');
            $table->date('tanggal_prestasi');
            $table->string('file_prestasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestasi_models');
    }
};
