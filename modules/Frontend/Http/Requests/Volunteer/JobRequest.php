<?php

namespace Modules\Frontend\Http\Requests\Volunteer;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'job_title' => ['required', 'string255'],
            'locations' => ['required', 'array'],
            'locations.*' => ['exists:us_cities,id', 'distinct'],
            'types' => ['required', 'array'],
            'types.*' => ['exists:job_types,id'],
            'hours' => ['required', 'array'],
            'hours.*' => ['exists:job_hours,id'],
            'sectors' => ['required', 'array', 'max:10'],
            'sectors.*.id' => ['exists:sectors,id', 'distinct'],
            'sectors.*.roles' => ['required', 'array', 'max:5'],
            'sectors.*.roles.*' => ['exists:sector_roles,id', 'distinct']
        ];
    }

    public function attributes(): array
    {
        $attributes = parent::attributes();
        $attributes['sectors.*.roles'] = 'roles';
        return $attributes;
    }

    public function messages(): array
    {
        $messages = parent::messages();
        $messages['sectors.*.roles.required'] = 'Please select :attribute.';
        return $messages;
    }

    public function authorize(): bool
    {
        return true;
    }
}
