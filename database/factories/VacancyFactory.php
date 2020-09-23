<?php

/** @var Factory $factory */

use App\Models\Company;
use App\Models\Jobs\Sector;
use App\Models\Jobs\Type;
use App\Models\Map\US\City;
use App\Models\Vacancy;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Vacancy::class, function (Faker $faker) {
    return [
        'company_id' => Company::inRandomOrder()->first()->id,
        'title' => $faker->unique()->sentence(3),
        'sector_id' => Sector::inRandomOrder()->first()->id,
        'city_id' => City::inRandomOrder()->first()->id,
        'type_id' => Type::inRandomOrder()->first()->id,
        'description' => $faker->realText(512),
        'is_relocation' => rand(0, 1) === 1,
        'is_remote_work' => rand(0, 1) === 1,
        'address' => $faker->address,
        'company_title' => $faker->unique()->sentence(6),
        'company_description' => $faker->unique()->sentence(16),
        'status' => collect(array_keys(Vacancy::$statuses))->random(),
    ];
});
