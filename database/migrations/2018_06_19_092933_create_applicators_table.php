<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('applicators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('sparepart_id');
            $table->integer('productionline_id')->nullable();
            $table->timestamps();
        });

        // Full Text Index
        DB::statement('ALTER TABLE applicators ADD FULLTEXT fulltext_index (name)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('applicators');
    }
}
