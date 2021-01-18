<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerSurveySourcesTable extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_survey_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_survey_sources');
    }
}
