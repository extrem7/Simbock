<?php

namespace Modules\App\Http\Requests\Company;

use App\Models\Vacancy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class VacancyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string255'],
            'sector_id' => ['required', 'exists:sectors,id'],
            'city_id' => ['required', 'exists:us_cities,id'],
            'type_id' => ['required', 'exists:job_types,id'],
            'hours' => ['required', 'array'],
            'hours.*' => ['exists:job_hours,id'],
            'description' => ['required', 'string255'],//todo maybe longer
            'benefits' => ['required', 'array'],
            'benefits.*' => ['exists:job_benefits,id'],
            'incentives' => ['nullable', 'array'],
            'incentives.*' => ['exists:job_incentives,id'],
            'is_relocation' => ['nullable', 'boolean'],
            'is_remote_work' => ['nullable', 'boolean'],
            'address' => ['nullable', 'string255'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['exists:job_skills,id'],
            'company_title' => ['nullable', 'string255'],
            'company_description' => ['nullable', 'string255']
        ];
    }

    public function syncHours(Vacancy $vacancy): Collection
    {
        return $vacancy->hours()->saveMany($this->input('hours'));
    }

    public function syncBenefits(Vacancy $vacancy): Collection
    {
        return $vacancy->benefits()->saveMany($this->input('benefits'));
    }

    public function authorize(): bool
    {
        return true;
    }
}
