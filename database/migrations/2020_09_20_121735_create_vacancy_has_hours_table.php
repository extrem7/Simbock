<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyHasHoursTable extends Migration
{
    public function up()
    {
        Schema::create('vacancy_has_hours', function (Blueprint $table) {
            $table->foreignId('vacancy_id')->constrained('vacancies')->cascadeOnDelete();
            $table->foreignId('hour_id')->constrained('job_hours')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacancy_has_hours');
    }
}
