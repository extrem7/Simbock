<?php

/** @var Factory $factory */

use App\Models\Company;
use App\Models\Jobs\Sector;
use App\Models\Jobs\Size;
use App\Models\Map\US\City;
use App\Models\Map\US\State;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
        'title' => $faker->unique()->sentence(2),
        'sector_id' => Sector::inRandomOrder()->first()->id,
        'description' => $faker->unique()->sentence(16),
        'size_id' => Size::inRandomOrder()->first()->id,
        'address' => $faker->address,
        'address_2' => $faker->address,
        'city_id' => City::inRandomOrder()->first()->id,
        'state_id' => State::inRandomOrder()->first()->id,
        'zip' => $faker->numberBetween(0, 99999),
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'social' => [
            'website' => $faker->url,
            'linkedin' => $faker->url,
            'twitter' => $faker->url,
            'facebook' => $faker->url,
            'instagram' => $faker->url,
            'youtube' => $faker->url,
            'reddit' => $faker->url,
            'pinterest' => $faker->url,
            'quora' => $faker->url
        ]
    ];
});
