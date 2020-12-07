<?php

namespace Modules\Frontend\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class InfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string255'],
            'user_name' => ['required', 'string255'],
            'title' => ['nullable', 'string255'],
            'sector_id' => ['required', 'exists:sectors,id'],
            'description' => ['nullable', 'string'],
            'size_id' => ['required', 'exists:job_company_sizes,id'],

            'address' => ['required', 'string255'],
            'address_2' => ['nullable', 'string255'],
            'city_id' => ['required', 'exists:us_cities,id'],
            'zip' => ['required', 'string', 'max:5'],

            'phone' => ['required', 'phone:US'],
            'email' => ['nullable', 'email', 'string255'],

            'social' => ['nullable', 'array'],
            'social.website' => ['nullable', 'url'],
            'social.linkedin' => ['nullable', 'url'],
            'social.twitter' => ['nullable', 'url'],
            'social.facebook' => ['nullable', 'url'],
            'social.instagram' => ['nullable', 'url'],
            'social.youtube' => ['nullable', 'url'],
            'social.reddit' => ['nullable', 'url'],
            'social.pinterest' => ['nullable', 'url'],
            'social.quora' => ['nullable', 'url']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
