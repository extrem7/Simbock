<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobDetailsTables extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_09_08_113654_create_job_details_tables.php */
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
        Schema::create('job_benefits', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });
        Schema::create('job_incentives', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });
        Schema::create('job_skills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_hours');
        Schema::dropIfExists('job_types');
        Schema::dropIfExists('job_company_sizes');
        Schema::dropIfExists('job_benefits');
        Schema::dropIfExists('job_skills');
    }
}
