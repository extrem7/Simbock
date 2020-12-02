<?php

namespace Modules\Frontend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacanciesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_relocation' => ['nullable'],
            'is_remote_work' => ['nullable'],
            'hours' => ['nullable'],
            'types' => ['nullable'],
            'time' => ['nullable'],
            'sizes' => ['nullable'],
            'sectors' => ['nullable']
        ];
    }

    public function all($keys = null): array
    {
        $data = parent::all();

        foreach (['hours', 'types', 'sizes', 'sectors'] as $filter) {
            if (isset($data[$filter])) {
                $data[$filter] = explode('|', $data[$filter]);
            }
        }

        if (isset($data['time'])) {
            $data['time'] = (int)$data['time'];
        }

        return $data;
    }

    public function authorize(): bool
    {
        return true;
    }
}
