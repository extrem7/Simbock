<?php

namespace Modules\Frontend\Http\Requests\Volunteer;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class WorkExperienceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string255'],
            'company' => ['required', 'string255'],
            'start' => ['required', 'date', 'before:now'],
            'end' => ['nullable', 'date', 'after_or_equal:start'],
            'description' => ['nullable', 'string255'],
        ];
    }

    public function validated()
    {
        $data = parent::validated();
        $data['start'] = Carbon::parse($data['start'])->format('Y-m-d H:i');
        if ($end = $data['end']) {
            $data['end'] = Carbon::parse($end)->format('Y-m-d H:i');
        }
        return $data;
    }

    public function authorize(): bool
    {
        return true;
    }
}
