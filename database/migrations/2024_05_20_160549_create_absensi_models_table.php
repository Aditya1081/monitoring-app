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
        Schema::create('tb_absensi', function (Blueprint $table) {
            $table->bigIncrements('id_absensi'); // ID unik dengan auto increment
            $table->unsignedbigInteger('id_santri'); // Id santri yang digunakan untuk foreign key
            $table->bigInteger('id_kamar'); // Id santri yang digunakan untuk foreign key
            $table->string('jenis_absensi', 5); // Nama pelanggaran
            $table->string('status_absensi', 20); // Nama pelanggaran
            $table->date('tanggal_absensi'); // Tanggal absensi
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });

        Schema::table('tb_absensi', function (Blueprint $table) {
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
        Schema::dropIfExists('tb_absensi');
    }
};
