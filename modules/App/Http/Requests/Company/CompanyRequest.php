<?php

namespace Modules\App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'company_name' => ['required', 'string255'],
            'name' => ['required', 'string255'],
            'title' => ['nullable', 'string255'],
            'sector_id' => ['required', 'exists:sectors,id'],
            'description' => ['nullable', 'string255'],//todo maybe longer
            'size_id' => ['required', 'exists:job_company_sizes,id'],

            'address' => ['required', 'string255'],
            'address_2' => ['nullable', 'string255'],
            'city_id' => ['required', 'exists:us_cities,id'],
            'state_id' => ['required', 'exists:us_states,id'],// todo ?
            'zip' => ['required', 'string255'],

            'phone' => ['nullable', 'regex:([0-9+() \-])\w+', 'string255'],
            'email' => ['required', 'email', 'string255'],

            'social' => ['nullable', 'array'],
            'social.website' => ['url'],
            'social.linkedin' => ['url'],
            'social.twitter' => ['url'],
            'social.facebook' => ['url'],
            'social.instagram' => ['url'],
            'social.youtube' => ['url'],
            'social.reddit' => ['url'],
            'social.pinterest' => ['url'],
            'social.quora' => ['url']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
