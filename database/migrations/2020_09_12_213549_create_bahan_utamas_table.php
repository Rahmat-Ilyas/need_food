<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanUtamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_item_paket', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('paket_id');
            $table->string('nama_bahan');
            $table->timestamps();

            //relasi
            // $table->foreign('paket_id')->references('id')->on('tb_paket');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bahan_utamas');
    }
}
