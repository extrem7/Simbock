<?php

namespace Modules\Admin\Repositories;

use Spatie\Permission\Models\Role;

class UserRepository
{
    public function getRoles()
    {
        return Role::all()->pluck('name', 'id');
    }

    public function shareForCRUD()
    {
        $roles = collect($this->getRoles())
            ->map(fn($val, $key) => ['value' => $key, 'label' => ucfirst($val)])->values();

        share(compact('roles'));
    }
}
