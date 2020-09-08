<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobDetailsTables extends Migration
{
    public function up()
    {
        Schema::create('job_hours', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('job_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('job_company_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('job_company_benefits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_hours');
        Schema::dropIfExists('job_types');
        Schema::dropIfExists('job_company_sizes');
        Schema::dropIfExists('job_company_benefits');
    }
}
