<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerSurveysTable extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_surveys', function (Blueprint $table) {
            $table->id();

            $table->foreignId('volunteer_id')->constrained('volunteers')->cascadeOnDelete();
            $table->foreignId('source_id')->constrained('volunteer_survey_sources');
            $table->string('specified')->nullable();

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->text('description')->nullable();

            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_surveys');
    }
}
