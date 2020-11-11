<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerHasSectorsWithRoles extends Migration
{

    public function up()
    {
        Schema::create('volunteer_has_sectors_with_roles', function (Blueprint $table) {
            $table->foreignId('volunteer_id')->constrained('volunteers')->cascadeOnDelete();
            $table->foreignId('sector_id')->constrained('sectors')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('sector_roles')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_has_sectors_with_roles');
    }
}
