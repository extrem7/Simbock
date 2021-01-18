<?php

use App\Models\Volunteers\Surveys\Source;
use Illuminate\Database\Seeder;

class SurveySourcesSeeder extends Seeder
{
    public function run(): void
    {
        $sources = [
            'Simbok', 'Recruiting or staffing firm', 'Another job site', 'Through someone I know', 'Company site',
            'Specify'
        ];

        foreach ($sources as $name) {
            Source::create(compact('name'));
        }
    }
}
