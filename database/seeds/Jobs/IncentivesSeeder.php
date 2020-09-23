<?php

use App\Models\Jobs\Incentive;
use Illuminate\Database\Seeder;

class IncentivesSeeder extends Seeder
{
    public function run()
    {
        $incentives = ['Best', 'work', 'ever'];
        foreach ($incentives as $name) {
            Incentive::create(compact('name'));
        }
    }
}
