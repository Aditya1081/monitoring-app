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
        Schema::create('tb_perizinan', function (Blueprint $table) {
            $table->bigIncrements('id_perizinan'); // ID unik dengan auto increment
            $table->bigInteger('id_santri'); // Id santri yang digunakan untuk foreign key
            $table->bigInteger('id_kamar'); // Id santri yang digunakan untuk foreign key
            $table->string('nama_perizinan', 50); // Nama pelanggaran
            $table->text('deskripsi_perizinan', 100); // Nama pelanggaran
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->text('deskripsi_pengurus', 100)->nullable();
            $table->string('status_perizinan', 30);
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
        Schema::dropIfExists('tb_perizinan');
    }
};
