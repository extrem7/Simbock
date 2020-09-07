<?php

use App\Models\Article;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        $statuses = array_keys(Article::$statuses);

        Schema::create('articles', function (Blueprint $table) use ($statuses) {
            $table->id();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('article_categories')
                ->nullOnDelete();

            $table->string('slug')->unique();
            $table->string('title');
            $table->string('excerpt');
            $table->text('body');

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->enum('status', $statuses)->default(Article::DRAFT);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
