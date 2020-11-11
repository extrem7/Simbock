<?php

use App\Models\Volunteers\MoreInfo\Degree;
use App\Models\Volunteers\MoreInfo\VeteranStatus;
use App\Models\Volunteers\MoreInfo\YearOfExperience;
use Illuminate\Database\Seeder;

class VolunteerMoreInfoSeeder extends Seeder
{
    public function run(): void
    {
        $years = [
            'Intern', 'Entry Level (0-2 years)', 'Mid Level (3-6 years)', 'Senior Level (7+ years)', 'Director',
            'Executive'
        ];
        $degrees = ['High School Diploma/GED', 'Associates Degree', 'Bachelors Degree', 'Masters or Ph.D'];
        $veterans = ['I am a Veteran', 'I do not wish to specify at this time'];

        foreach ($years as $name) YearOfExperience::create(compact('name'));
        foreach ($degrees as $name) Degree::create(compact('name'));
        foreach ($veterans as $name) VeteranStatus::create(compact('name'));
    }
}
