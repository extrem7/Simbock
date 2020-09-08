<?php

namespace Modules\Admin\Http\Requests\Jobs;

use App\Models\Jobs\Role;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sectors' => ['required', 'array'],
            'sectors.*' => ['exists:sectors,id']
        ];
    }

    public function syncSectors(Role $role)
    {
        $role->sectors()->sync($this->input('sectors'));
    }

    public function authorize()
    {
        return true;
    }
}
