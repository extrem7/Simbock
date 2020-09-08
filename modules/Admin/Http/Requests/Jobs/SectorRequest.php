<?php

namespace Modules\Admin\Http\Requests\Jobs;

use Illuminate\Foundation\Http\FormRequest;

class SectorRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
