<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetAlatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_setalat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('paket_id');
            $table->integer('kategori_alat_id');
            $table->integer('jumlah');
            $table->integer('per_paket');
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
        Schema::dropIfExists('set_alats');
    }
}
