<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectorRolesTable extends Migration
{
    public function up()
    {
        Schema::create('sector_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sector_roles');
    }
}
