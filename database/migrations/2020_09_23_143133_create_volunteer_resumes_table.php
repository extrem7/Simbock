<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerResumesTable extends Migration
{
    public function up()
    {
        Schema::create('volunteer_resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('volunteers')->cascadeOnDelete();

            $table->string('title');
            $table->foreignId('file_id')->constrained('media')->cascadeOnDelete();

            $table->timestamp('created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_resumes');
    }
}
