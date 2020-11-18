<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerEducationsTable extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_09_23_142340_create_volunteer_educations_table.php */
    public function up()
    {
        Schema::create('volunteer_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('volunteers')->cascadeOnDelete();

            $table->string('school');
            $table->string('degree');
            $table->string('field')->nullable();
            $table->unsignedSmallInteger('start');
            $table->unsignedSmallInteger('end');
            $table->string('description')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_educations');
    }
}
