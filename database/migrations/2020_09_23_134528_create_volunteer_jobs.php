<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerJobs extends Migration
{
    public function up()
    {
        Schema::create('volunteer_jobs', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->json('locations');
            $table->foreignId('sector_id')->constrained('sectors');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_jobs');
    }
}
