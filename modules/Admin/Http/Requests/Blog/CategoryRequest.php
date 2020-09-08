<?php

namespace Modules\Admin\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
