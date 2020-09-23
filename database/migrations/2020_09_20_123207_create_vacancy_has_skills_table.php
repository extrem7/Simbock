<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyHasSkillsTable extends Migration
{
    public function up()
    {
        Schema::create('vacancy_has_skills', function (Blueprint $table) {
            $table->foreignId('vacancy_id')->constrained('vacancies')->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained('job_skills')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacancy_has_skills');
    }
}
