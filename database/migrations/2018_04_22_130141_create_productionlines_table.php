<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('company_id');
            $table->integer('plant_id');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE production_lines ADD Fulltext fulltext_index (name)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_lines');
    }
}
