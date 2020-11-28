<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetBahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_setbahan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('paket_id');
            $table->integer('bahan_id');
            $table->integer('jumlah');
            $table->integer('per_paket');
            $table->string('jenis');
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
        Schema::dropIfExists('set_bahans');
    }
}
