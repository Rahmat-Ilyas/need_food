<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_alat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kd_alat');
            $table->string('nama');
            $table->string('foto');
            $table->string('kategori');
            $table->integer('jumlah_alat');
            $table->integer('alat_keluar')->nullable();
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
        Schema::dropIfExists('alats');
    }
}
