<?php

use App\Models\Jobs\Size;
use Illuminate\Database\Seeder;

class SizesSeeder extends Seeder
{
    public function run()
    {
        $sizes = ['Company (1-6 employees)', 'Company (6-10 employees)', 'Company (10-50 employees)', 'Company (50+ employees)'];
        foreach ($sizes as $name) Size::create(compact('name'));
    }
}
