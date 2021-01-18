<?php

namespace Modules\Frontend\Http\Requests\Volunteer\Survey;

use Illuminate\Foundation\Http\FormRequest;

class InitialRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'source_id' => ['required', 'exists:volunteer_survey_sources,id'],
            'specified' => ['nullable', 'string255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
