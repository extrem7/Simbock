<?php

namespace Modules\Frontend\Http\Requests\Volunteer\Survey;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'job_title' => ['required', 'string255'],
            'company_name' => ['required', 'string255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
