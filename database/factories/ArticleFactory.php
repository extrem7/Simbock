<?php

/** @var Factory $factory */

use App\Models\Blog\Article;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->sentence(12),
        'body' => $faker->realText(1000),
        'excerpt' => $faker->text(140),
        'status' => Article::PUBLISHED,
    ];
});
