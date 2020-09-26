<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddBahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_add_bahan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bahan_id');
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
        Schema::dropIfExists('add_bahans');
    }
}
