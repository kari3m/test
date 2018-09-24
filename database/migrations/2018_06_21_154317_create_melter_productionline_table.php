<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMelterProductionlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('melter_productionline', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('productionline_id');
            $table->integer('melter_id');
            $table->string('melter_name');
            $table->string('S_N');
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
        Schema::dropIfExists('melter_productionline');
    }
}
