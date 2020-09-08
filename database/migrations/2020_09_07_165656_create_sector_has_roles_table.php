<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectorHasRolesTable extends Migration
{
    public function up()
    {
        Schema::create('sector_has_roles', function (Blueprint $table) {
            $table->foreignId('sector_id')->constrained('sectors')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('sector_roles')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sector_has_roles');
    }
}
