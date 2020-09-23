<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerJobHasHours extends Migration
{
    public function up()
    {
        Schema::create('volunteer_job_has_hours', function (Blueprint $table) {
            $table->foreignId('job_id')->constrained('volunteer_jobs')->cascadeOnDelete();
            $table->foreignId('hour_id')->constrained('job_hours')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_job_has_hours');
    }
}
