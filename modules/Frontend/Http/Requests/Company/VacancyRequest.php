<?php

namespace Modules\Frontend\Http\Requests\Company;

use App\Models\Jobs\Benefit;
use App\Models\Jobs\Hour;
use App\Models\Jobs\Incentive;
use App\Models\Jobs\Skill;
use App\Models\Vacancy;
use Illuminate\Foundation\Http\FormRequest;

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

    public function syncHours(): array
    {
        return $this->vacancy->hours()->sync(Hour::findMany($this->hours));
    }

    public function syncBenefits(): array
    {
        return $this->vacancy->benefits()->sync(Benefit::findMany($this->benefits));
    }

    public function syncIncentives(): array
    {
        if ($incentives = $this->incentives) {
            $incentives = Incentive::findOrCreate($incentives);
            $this->vacancy->incentives()->sync($incentives->pluck('id')->toArray());
        }
        return [];
    }

    public function syncSkills(): array
    {
        if ($skills = $this->skills) {
            $skills = Skill::findOrCreate($skills);
            return $this->vacancy->skills()->sync($skills->pluck('id')->toArray());
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
