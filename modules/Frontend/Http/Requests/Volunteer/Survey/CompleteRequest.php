<?php

namespace Modules\Frontend\Http\Requests\Volunteer\Survey;

use Illuminate\Foundation\Http\FormRequest;

class CompleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string255'],
            'email' => ['required', 'email'],
            'address' => ['required', 'string255'],
            'phone' => ['required', 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',/*'phone:US'*/],
            'company_name' => ['required', 'string255'],
            'description' => ['required', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
