<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerWorkExperiences extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_09_23_140841_create_volunteer_work_experiences.php */
    public function up()
    {
        Schema::create('volunteer_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('volunteers')->cascadeOnDelete();

            $table->string('title');
            $table->string('company');
            $table->date('start');
            $table->date('end')->nullable();
            $table->string('description')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_work_experiences');
    }
}
