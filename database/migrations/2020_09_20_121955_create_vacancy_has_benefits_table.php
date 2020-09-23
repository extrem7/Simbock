<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyHasBenefitsTable extends Migration
{

    public function up()
    {
        Schema::create('vacancy_has_benefits', function (Blueprint $table) {
            $table->foreignId('vacancy_id')->constrained('vacancies')->cascadeOnDelete();
            $table->foreignId('benefit_id')->constrained('job_benefits')->cascadeOnDelete();
        });
    }


    public function down()
    {
        Schema::dropIfExists('vacancy_has_benefits');
    }
}
