<?php

namespace Modules\Admin\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        $update = request()->isMethod('PATCH');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . ($update ? $this->user->id : '')],
            'password' => [$update ? 'nullable' : 'required', 'string', 'min:8'],
            'role' => ['required', 'numeric', 'exists:user_roles,id'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,bmp,png'],
        ];
    }

    public function uploadAvatar(User $user)
    {
        if ($this->hasFile('avatar')) {
            $user->uploadAvatar($this->file('avatar'));
            $user->load('avatarMedia');
            $user->append('avatar');
        }
    }

    public function authorize()
    {
        return true;
    }
}
