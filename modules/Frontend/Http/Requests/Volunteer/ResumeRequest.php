<?php

namespace Modules\Frontend\Http\Requests\Volunteer;

use Illuminate\Foundation\Http\FormRequest;

class ResumeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string255'],
            'file' => ['required', 'file', 'mimetypes:application/pdf', 'max:1024']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
