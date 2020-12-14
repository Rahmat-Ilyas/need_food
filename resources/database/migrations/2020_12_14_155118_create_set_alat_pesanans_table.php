<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetAlatPesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_alatpesanan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pemesanan_id');
            $table->integer('kategori_alat_id');
            $table->integer('alat_id');
            $table->integer('jumlah');
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
        Schema::dropIfExists('set_alat_pesanans');
    }
}
