<?php

namespace Modules\Frontend\Http\Requests\Volunteer;

use Illuminate\Foundation\Http\FormRequest;

class CertificateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string255'],
            'issuing_authority' => ['nullable', 'string255'],
            'year' => ['nullable', 'numeric', 'min:1950', 'max:' . date('Y')],
            'description' => ['nullable', 'string255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
