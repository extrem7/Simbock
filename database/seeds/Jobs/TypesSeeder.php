<?php

use App\Models\Jobs\Type;
use Illuminate\Database\Seeder;

class TypesSeeder extends Seeder
{
    public function run()
    {
        $types = [
            'Permanent', 'Temporary', 'Contract', 'Weekend volunteering Jobs',
            'Graduate Jobs (Select if you are a recent graduate)', 'No experience volunteering Jobs',
            'Evening volunteering Jobs', 'Sport volunteering'];
        foreach ($types as $name) Type::create(compact('name'));
    }
}
