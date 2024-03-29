<?php

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {

        if (User::find(1) === null) {
            $user = new User([
                'name' => env('INITIAL_USER_NAME'),
                'email' => env('INITIAL_USER_EMAIL'),
                'password' => env('INITIAL_USER_PASSWORDHASH'),
            ]);
            $user->save();
            $user->assignRole('admin');
        }

        factory(User::class, 1)->create()->each(function (User $user) {
            $company = factory(Company::class)->make();
            $company->user_id = $user->id;
            $company->save();
        });
    }
}
