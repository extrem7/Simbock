<?php

use App\Models\Jobs\Skill;
use Illuminate\Database\Seeder;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            'Effective communication', 'Teamwork', 'Responsibility', 'Creativity', 'Problem-solving',
            'Leadership', 'Extroversion ', 'People skills', 'Openness', 'Adaptability'
        ];
        foreach ($skills as $name) {
            Skill::create(compact('name'));
        }
    }
}
