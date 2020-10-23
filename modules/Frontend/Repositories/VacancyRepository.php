<?php

namespace Modules\Frontend\Repositories;

use App\Models\Jobs\Benefit;
use App\Models\Jobs\Hour;
use App\Models\Jobs\Incentive;
use App\Models\Jobs\Sector;
use App\Models\Jobs\Skill;
use App\Models\Jobs\Type;
use App\Models\Vacancy;
use App\Services\LocationService;

class VacancyRepository
{
    public function sharedData()
    {
        $sectors = Sector::all('name', 'id')->map(fn(Sector $s) => ['text' => $s->name, 'value' => $s->id]);
        $types = Type::all('name', 'id')->map(fn(Type $t) => ['text' => $t->name, 'value' => $t->id]);
        $hours = Hour::all('name', 'id')->map(fn(Hour $h) => ['text' => $h->name, 'value' => $h->id]);
        $benefits = Benefit::all('name', 'id')->map(fn(Benefit $b) => ['text' => $b->name, 'value' => $b->id]);

        $incentives = Incentive::all(['name', 'id'])->map(fn(Incentive $i) => ['text' => $i->name]);
        $skills = Skill::all(['name', 'id'])->map(fn(Skill $s) => ['text' => $s->name]);

        share(compact('sectors', 'types', 'hours', 'benefits', 'incentives', 'skills'));
    }

    public function transformForEdit(Vacancy $vacancy): array
    {
        $locationService = app(LocationService::class);

        $vacancy->load('city', 'hours', 'benefits', 'incentives', 'skills');
        $city = $vacancy->city;
        $vacancy = $vacancy->toArray();

        $vacancy['hours'] = collect($vacancy['hours'])->map(fn(array $h) => $h['id']);
        $vacancy['benefits'] = collect($vacancy['benefits'])->map(fn(array $b) => $b['id']);
        $vacancy['incentives'] = collect($vacancy['incentives'])->map(fn(array $i) => ['text' => $i['name']]);
        $vacancy['skills'] = collect($vacancy['skills'])->map(fn(array $s) => ['text' => $s['name']]);

        $vacancy['city'] = [
            'text' => $locationService->mapCity($city),
            'value' => $city->id
        ];

        return $vacancy;
    }
}
