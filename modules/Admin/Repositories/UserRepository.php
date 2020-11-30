<?php

namespace Modules\Admin\Repositories;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRepository
{
    public function getRoles()
    {
        return Role::all()->pluck('name', 'id');
    }

    public function shareForCRUD()
    {
        $types = User::$types;
        $roles = collect($this->getRoles())
            ->map(fn($val, $key) => ['value' => $key, 'text' => ucfirst($val)])->values();

        share(compact('types', 'roles'));
    }
}
