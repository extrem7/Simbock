<?php

use App\Models\Jobs\Benefit;
use App\Models\Jobs\Hour;
use App\Models\Jobs\Incentive;
use App\Models\Jobs\Skill;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;

class VacanciesSeeder extends Seeder
{
    public function run()
    {
        factory(Vacancy::class, 2)->create()->each(function (Vacancy $vacancy) {
            $vacancy->hours()->saveMany(Hour::inRandomOrder()->limit(rand(1, 2))->get());
            $vacancy->benefits()->saveMany(Benefit::inRandomOrder()->limit(2)->get());
            $vacancy->incentives()->saveMany(Incentive::inRandomOrder()->limit(2)->get());
            $vacancy->skills()->saveMany(Skill::inRandomOrder()->limit(3)->get());
        });
    }
}
