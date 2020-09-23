<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyHasIncentivesTable extends Migration
{
    public function up()
    {
        Schema::create('vacancy_has_incentives', function (Blueprint $table) {
            $table->foreignId('vacancy_id')->constrained('vacancies')->cascadeOnDelete();
            $table->foreignId('incentive_id')->constrained('job_incentives')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacancy_has_incentives');
    }
}
