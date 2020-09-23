<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerDetailsTables extends Migration
{
    public function up()
    {
        Schema::create('volunteer_years_of_experience', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('volunteer_levels_of_education', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('volunteer_veteran_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_years_of_experience');
        Schema::dropIfExists('volunteer_levels_of_education');
        Schema::dropIfExists('volunteer_veteran_statuses');
    }
}
