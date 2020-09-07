<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{

    public function run(): void
    {
        /*
        Eloquent::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        */

        $permissions = [
            'access admin panel',
            'edit settings',
            'manage pages',
            'manage articles',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            if (Permission::where('name', $permission)->first() === null)
                Permission::create(['name' => $permission]);
        }

        $roles = [
            'admin' => $permissions,
            'moderator' => [
                'access admin panel',
            ],
            'seo' => [
                'access admin panel',
                'manage pages',
                'manage articles',
            ],
            'writer' => [
                'access admin panel',
                'manage articles'
            ],
        ];

        foreach ($roles as $name => $permissions) {
            $role = null;
            try {
                $role = Role::findByName($name);
            } catch (Exception $e) {
            }
            if ($role === null) {
                $role = new Role(['name' => $name]);
                $role->save();
            }
            $role->syncPermissions($permissions);
        }
    }
}
