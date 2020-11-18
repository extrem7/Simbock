<?php

namespace Modules\Frontend\Http\Requests\Volunteer;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'school' => ['required', 'string255'],
            'degree' => ['required', 'string255'],
            'field' => ['nullable', 'string255'],
            'start' => ['required', 'numeric', 'min:1950', 'max:2030'],
            'end' => ['required', 'numeric', 'min:1950', 'max:2030', 'gte:start'],
            'description' => ['nullable', 'string255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
