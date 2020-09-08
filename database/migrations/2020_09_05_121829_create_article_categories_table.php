<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCategoriesTable extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_09_05_121829_create_article_categories_table.php */
    public function up()
    {
        Schema::create('article_categories', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique();
            $table->string('name');

            $table->unsignedBigInteger('order');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('article_categories');
    }
}
