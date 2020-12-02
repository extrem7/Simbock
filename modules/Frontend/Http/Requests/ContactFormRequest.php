<?php

namespace Modules\Frontend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string255'],
            'email' => ['required', 'email'],
            'comment' => ['nullable', 'string255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
