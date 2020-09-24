<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteersTable extends Migration
{
    public function up()
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');

            $table->boolean('is_private')->default(false);

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('social')->nullable();

            $table->string('headline')->nullable();
            $table->foreignId('city_id')->constrained('us_cities');
            $table->char('zip', 5)->nullable();

            $table->boolean('is_relocating')->default(false);
            $table->boolean('is_working_remotely')->default(false);

            $table->text('executive_summary')->nullable();
            $table->string('objective')->nullable();
            $table->string('achievements')->nullable();
            $table->string('associations')->nullable();

            $table->foreignId('years_of_experience_id')->nullable()->constrained('volunteer_years_of_experience');
            $table->foreignId('level_of_education_id')->nullable()->constrained('volunteer_levels_of_education');
            $table->foreignId('veteran_status_id')->nullable()->constrained('volunteer_veteran_statuses');

            $table->text('cover_letter')->nullable();
            $table->string('personal_statement')->nullable();

            $table->boolean('has_driver_license')->default(false);
            $table->boolean('has_car')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteers');
    }
}
