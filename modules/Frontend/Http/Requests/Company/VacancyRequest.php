<?php

namespace Modules\Frontend\Http\Requests\Company;

use App\Models\Jobs\Benefit;
use App\Models\Jobs\Hour;
use App\Models\Jobs\Incentive;
use App\Models\Jobs\Skill;
use App\Models\Vacancy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class VacancyRequest extends FormRequest
{
    protected Vacancy $vacancy;

    public function rules(): array
    {
        return [
            'title' => ['required', 'string255'],
            'sector_id' => ['required', 'exists:sectors,id'],
            'city_id' => ['required', 'exists:us_cities,id'],
            'type_id' => ['required', 'exists:job_types,id'],
            'hours' => ['required', 'array'],
            'hours.*' => ['exists:job_hours,id'],
            'description' => ['required', 'string'],
            'benefits' => ['required', 'array'],
            'benefits.*' => ['exists:job_benefits,id'],
            'incentives' => ['nullable', 'array'],
            'incentives.*' => ['string'],
            'is_relocation' => ['nullable', 'boolean'],
            'is_remote_work' => ['nullable', 'boolean'],
            'address' => ['nullable', 'string255'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['string'],
            'company_title' => ['nullable', 'string255'],
            'company_description' => ['nullable', 'string255']
        ];
    }

    public function syncHours(): Collection
    {
        return $this->vacancy->hours()->saveMany(Hour::findMany($this->hours));
    }

    public function syncBenefits(): Collection
    {
        return $this->vacancy->benefits()->saveMany(Benefit::findMany($this->benefits));
    }

    public function syncIncentives(): array
    {
        if (($incentives = $this->incentives) && !empty($incentives)) {
            $incentives = Incentive::findOrCreate($incentives);
            $this->vacancy->incentives()->syncWithoutDetaching($incentives->pluck('id')->toArray());
        }
        return [];
    }

    public function syncSkills(): array
    {
        if (($skills = $this->skills) && !empty($skills)) {
            $skills = Skill::findOrCreate($skills);
            $this->vacancy->skills()->syncWithoutDetaching($skills->pluck('id')->toArray());
        }
        return [];
    }

    public function setVacancy(Vacancy $vacancy): void
    {
        $this->vacancy = $vacancy;
    }

    public function authorize(): bool
    {
        return true;
    }
}
