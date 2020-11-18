<?php

namespace Modules\Frontend\Http\Requests\Volunteer;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
    public function rules(): array
    {
        $fluencies = implode(',', array_keys(Language::$fluencies));
        return [
            'language_id' => ['required', 'exists:languages,id'],
            'fluency' => ['required', "in:$fluencies"]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
