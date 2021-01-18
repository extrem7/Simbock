<?php

namespace Modules\Frontend\Http\Requests\Volunteer\Survey;

use Illuminate\Foundation\Http\FormRequest;

class CompleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string255'],
            'email' => ['required', 'string255'],
            'address' => ['required', 'string255'],
            'phone' => ['required', 'string255'],
            'company_name' => ['required', 'string255'],
            'description' => ['required', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
