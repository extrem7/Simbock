<?php

use Illuminate\Database\Seeder;

class JobsTablesSeeder extends Seeder
{
    public function run()
    {
        $this->call(SectorsSeeder::class);
        $this->call(HoursSeeder::class);
        $this->call(TypesSeeder::class);
        $this->call(SizesSeeder::class);
        $this->call(BenefitsSeeder::class);
    }
}
