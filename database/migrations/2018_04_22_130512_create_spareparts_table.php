<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pn')->unique();
            $table->string('description')->nullable();
            $table->string('ded_price')->nullable();
            $table->string('ger_price')->nullable();
            $table->string('quick_reference')->nullable();
            $table->boolean('deleted')->default(FALSE);
            $table->timestamps();
        });
        DB::statement('ALTER TABLE spare_parts ADD FULLTEXT fulltext_index (pn,quick_reference)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spare_parts');
    }
}
