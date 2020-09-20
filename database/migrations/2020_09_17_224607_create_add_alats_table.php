<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddAlatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_add_alat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('alat_id');
            $table->string('kd_beli');
            $table->integer('jumlah_beli');
            $table->double('total_harga');
            $table->integer('supplier_id');
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
        Schema::dropIfExists('add_alats');
    }
}
