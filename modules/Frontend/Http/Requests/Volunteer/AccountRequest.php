<?php

namespace Modules\Frontend\Http\Requests\Volunteer;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string255'],
            'headline' => ['nullable', 'string255'],
            'city_id' => ['nullable', 'exists:us_cities,id'],
            'zip' => ['nullable', 'string', 'max:5'],
            'is_relocating' => ['nullable', 'boolean'],
            'is_working_remotely' => ['nullable', 'boolean'],

            'email' => ['nullable', 'email', 'string255'],
            'phone' => ['nullable', 'string255', 'phone:US'],

            'social' => ['nullable', 'array'],
            'social.website' => ['nullable', 'url'],
            'social.linkedin' => ['nullable', 'url'],
            'social.twitter' => ['nullable', 'url'],
            'social.facebook' => ['nullable', 'url'],
            'social.instagram' => ['nullable', 'url'],
            'social.youtube' => ['nullable', 'url'],
            'social.reddit' => ['nullable', 'url'],
            'social.pinterest' => ['nullable', 'url'],
            'social.quora' => ['nullable', 'url'],

            'executive_summary' => ['nullable', 'string', 'max:512'],
            'objective' => ['nullable', 'string', 'max:512'],
            'achievements' => ['nullable', 'string', 'max:512'],
            'associations' => ['nullable', 'string', 'max:512'],

            'years_of_experience_id' => ['nullable', 'exists:volunteer_years_of_experience,id'],
            'level_of_education_id' => ['nullable', 'exists:volunteer_levels_of_education,id'],
            'veteran_status_id' => ['nullable', 'exists:volunteer_veteran_statuses,id'],

            'cover_letter' => ['nullable', 'string', 'max:512'],
            'personal_statement' => ['nullable', 'string', 'max:512'],

            'has_driver_license' => ['nullable', 'boolean'],
            'has_car' => ['nullable', 'boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
