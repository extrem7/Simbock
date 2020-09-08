<?php

use App\Models\Jobs\Hour;
use Illuminate\Database\Seeder;

class HoursSeeder extends Seeder
{
    public function run()
    {
        $hours = ['Full-time', 'Part-time', 'Per diem'];
        foreach ($hours as $name) Hour::create(compact('name'));
    }
}
