<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerCertificatesTable extends Migration
{
    public function up()
    {
        Schema::create('volunteer_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('volunteers')->cascadeOnDelete();

            $table->string('title');
            $table->string('issuing_authority')->nullable();
            $table->year('year')->nullable();
            $table->string('description')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_certificates');
    }
}
