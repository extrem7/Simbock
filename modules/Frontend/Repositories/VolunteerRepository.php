<?php

namespace Modules\Frontend\Repositories;

use App\Models\Jobs\Hour;
use App\Models\Jobs\Sector;
use App\Models\Jobs\Skill;
use App\Models\Jobs\Type;
use App\Models\Language;
use App\Models\Map\US\City;
use App\Models\Volunteers\MoreInfo\Degree;
use App\Models\Volunteers\MoreInfo\VeteranStatus;
use App\Models\Volunteers\MoreInfo\YearOfExperience;
use App\Models\Volunteers\Volunteer;
use App\Services\LocationService;
use Illuminate\Support\Collection;

class VolunteerRepository
{
    public function setupRelations(Volunteer $volunteer): Volunteer
    {
        $volunteer->load(['locations', 'roles', 'types', 'hours', 'educations', 'resume', 'skills']);
        $volunteer->setRelation(
            'workExperiences', $volunteer->workExperiences()->orderByDesc('start')->get()
        );
        $volunteer->setRelation('certificates', $volunteer->certificates()->orderByDesc('year')->get());
        $volunteer->setRelation(
            'languages', $volunteer->languages()
            ->orderBy('language_id')
            ->get()
            ->map(fn(Language $l) => ['id' => $l->id, 'fluency' => $l->pivot->fluency])
        );

        $volunteer->locations->transform(fn(City $c) => $c->id);
        $volunteer->types->transform(fn(Type $t) => $t->id);
        $volunteer->hours->transform(fn(Hour $h) => $h->id);

        return $volunteer;
    }

    public function setupAppends(Volunteer $volunteer): Volunteer
    {
        $volunteer->append(['name']);
        if ($volunteer->avatarMedia) {
            $volunteer->append(['avatar']);
        }

        return $volunteer;
    }

    public function shareVolunteer(Volunteer $volunteer): void
    {
        $locationService = app(LocationService::class);

        $volunteerArray = $volunteer->toArray();

        /* @var $city City */
        if ($city = $volunteer->city) {
            $volunteerArray['city'] = [
                'text' => $locationService->mapCity($city),
                'value' => $city->id,
                'zips' => $city->zips
            ];
        }

        $volunteerArray['skills'] = collect($volunteer['skills'])->pluck('name');

        $ids = $volunteer['locations'];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $volunteerArray['cities'] = $ids->isNotEmpty() ? City::whereIn('id', $ids)
            ->orderByRaw("field(id,{$placeholders})", $ids)->get()
            ->map(fn(City $c) => [[
                'text' => $locationService->mapCity($c),
                'value' => $c->id
            ]]) : [];

        $volunteerArray['sectors'] = $volunteer->roles()
            ->select(['sector_id', 'role_id'])
            ->distinct()
            ->get()
            ->groupBy('sector_id')
            ->map(fn(Collection $items) => $items->map(fn($item) => $item->role_id)->toArray());

        share(['volunteer' => $volunteerArray]);
    }

    public function shareForView(): void
    {
        $types = Type::all('name', 'id')->map(fn(Type $t) => ['text' => $t->name, 'value' => $t->id]);
        $sectors = Sector::with('roles')
            ->get(['name', 'id'])
            ->map(fn(Sector $s) => [
                'text' => $s->name,
                'value' => $s->id,
                'roles' => $s->roles->chunk(ceil($s->roles->count() / 2))]);
        $hours = Hour::all('name', 'id')->map(fn(Hour $h) => ['text' => $h->name, 'value' => $h->id]);

        $yearsOfExperience = YearOfExperience::all(['name', 'id'])
            ->map(fn(YearOfExperience $y) => ['text' => $y->name, 'value' => $y->id]);
        $degrees = Degree::all(['name', 'id'])
            ->map(fn(Degree $d) => ['text' => $d->name, 'value' => $d->id]);
        $veteranStatuses = VeteranStatus::all(['name', 'id'])
            ->map(fn(VeteranStatus $s) => ['text' => $s->name, 'value' => $s->id]);

        $languages = Language::all(['name', 'id'])->map(fn(Language $l) => ['text' => $l->name, 'value' => $l->id]);
        $fluencies = collect(Language::$fluencies)->map(
            fn($label, $fluency) => ['text' => $label, 'value' => $fluency]
        )->values();

        share(compact('types', 'sectors', 'hours', 'yearsOfExperience', 'degrees', 'veteranStatuses', 'languages', 'fluencies'));
    }

    public function shareForEdit(): void
    {
        $skills = Skill::all(['name', 'id'])->map(fn(Skill $s) => ['text' => $s->name]);

        share(
            compact('skills')
        );
    }
}
