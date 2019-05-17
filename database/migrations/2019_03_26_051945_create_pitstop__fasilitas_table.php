<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePitstopFasilitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pitstop__fasilitas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('pitstop_id');
            $table->unsignedInteger('fasilitas_id');
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
        Schema::dropIfExists('pitstop__fasilitas');
    }
}
