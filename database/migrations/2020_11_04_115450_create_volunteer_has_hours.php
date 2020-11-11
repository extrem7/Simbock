<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerHasHours extends Migration
{
    public function up()
    {
        Schema::create('volunteer_has_hours', function (Blueprint $table) {
            $table->foreignId('volunteer_id')->constrained('volunteers')->cascadeOnDelete();
            $table->foreignId('hour_id')->constrained('job_hours')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_has_hours');
    }
}
