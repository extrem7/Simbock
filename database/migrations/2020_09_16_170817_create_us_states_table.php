<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsStatesTable extends Migration
{
    public function up()
    {
        Schema::create('us_states', function (Blueprint $table) {
            $table->char('id', 2)->unique()->primary();
            $table->string('name', 50);
        });
    }

    public function down()
    {
        Schema::dropIfExists('us_states');
    }
}
