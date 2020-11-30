<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectorRolesTable extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_09_07_155706_create_sector_roles_table.php */
    public function up()
    {
        Schema::create('sector_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('order')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sector_roles');
    }
}
