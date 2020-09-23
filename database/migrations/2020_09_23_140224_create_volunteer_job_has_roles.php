<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerJobHasRoles extends Migration
{
    public function up()
    {
        Schema::create('volunteer_job_has_roles', function (Blueprint $table) {
            $table->foreignId('job_id')->constrained('volunteer_jobs')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('sector_roles')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_job_has_roles');
    }
}
