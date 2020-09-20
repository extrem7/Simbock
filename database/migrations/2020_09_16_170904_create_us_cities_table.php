<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsCitiesTable extends Migration
{
    public function up()
    {
        Schema::create('us_cities', function (Blueprint $table) {
            $table->id();
            $table->char('state_id', 2);
            $table->string('name');
            $table->string('county');
            $table->double('lat');
            $table->double('lng');
            $table->string('zips', 1900);
            $table->unsignedInteger('population');

            $table->foreign('state_id')->references('id')->on('us_states');
        });
    }

    public function down()
    {
        Schema::dropIfExists('us_cities');
    }
}
