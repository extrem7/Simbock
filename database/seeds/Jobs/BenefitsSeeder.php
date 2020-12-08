<?php

use App\Models\Jobs\Benefit;
use Illuminate\Database\Seeder;

class BenefitsSeeder extends Seeder
{
    public function run()
    {
        $benefist = [
            'Medical Insurance', 'Dental Insurance', 'Vision Insurance', '401K', 'Life Insurance'
        ];
        foreach ($benefist as $name) Benefit::create(compact('name'));
    }
}
