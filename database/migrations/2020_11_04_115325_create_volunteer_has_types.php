<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerHasTypes extends Migration
{
    public function up()
    {
        Schema::create('volunteer_has_types', function (Blueprint $table) {
            $table->foreignId('volunteer_id')->constrained('volunteers')->cascadeOnDelete();
            $table->foreignId('type_id')->constrained('job_types')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_has_types');
    }
}
