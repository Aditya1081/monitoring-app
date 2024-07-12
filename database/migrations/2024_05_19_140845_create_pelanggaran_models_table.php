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
        Schema::create('tb_pelanggaran', function (Blueprint $table) {
            $table->bigIncrements('id_pelanggaran'); // ID unik dengan auto increment
            $table->unsignedbigInteger('id_santri'); // Id santri yang digunakan untuk foreign key
            $table->bigInteger('id_kamar'); // Id santri yang digunakan untuk foreign key
            $table->string('nama_pelanggaran', 255); // Nama pelanggaran
            $table->string('point', 16); // point pelanggaran
            $table->string('deskripsi_pelanggaran', 255); // Deskripsi pelanggaran
            $table->date('tanggal_pelanggaran');
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });

        Schema::table('tb_pelanggaran', function (Blueprint $table) {
            $table->foreign('id_santri')
                  ->references('id_santri')
                  ->on('tb_data_santri')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelanggaran_models');
    }
};
