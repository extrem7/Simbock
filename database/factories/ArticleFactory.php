<?php

/** @var Factory $factory */

use App\Models\Blog\Article;
use App\Models\Blog\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'category_id' => Category::inRandomOrder()->first()->id,
        'title' => $faker->unique()->sentence(6),
        'body' => $faker->realText(1000),
        'excerpt' => $faker->text(140),
        'meta_title' => $faker->unique()->sentence(6),
        'meta_description' => $faker->unique()->sentence(16),
        'status' => Article::PUBLISHED,
    ];
});
