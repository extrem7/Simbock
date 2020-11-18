<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_09_23_154524_create_languages_table.php */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('code', 3);
        });
    }

    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
