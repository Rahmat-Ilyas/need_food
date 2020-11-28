<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pemesanan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kd_pemesanan');
            $table->string('nama');
            $table->string('no_telepon');
            $table->string('no_wa');
            $table->datetime('tanggal_antar');
            $table->string('waktu_antar');
            $table->string('deskripsi_lokasi');
            $table->string('latitude');
            $table->string('logitude');
            $table->string('catatan')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('pemesanans');
    }
}
