<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_bahan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kd_bahan');
            $table->string('nama');
            $table->string('foto');
            $table->string('kategori');
            $table->integer('jumlah_alat');
            $table->integer('alat_keluar')->nullable();
            $table->string('satuan');
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
        Schema::dropIfExists('bahans');
    }
}
