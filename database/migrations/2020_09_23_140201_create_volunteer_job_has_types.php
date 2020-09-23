<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerJobHasTypes extends Migration
{
    public function up()
    {
        Schema::create('volunteer_job_has_types', function (Blueprint $table) {
            $table->foreignId('job_id')->constrained('volunteer_jobs')->cascadeOnDelete();
            $table->foreignId('type_id')->constrained('job_types')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_job_has_types');
    }
}
