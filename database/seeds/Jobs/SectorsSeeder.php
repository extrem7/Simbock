<?php

use App\Models\Jobs\Role;
use App\Models\Jobs\Sector;
use Illuminate\Database\Seeder;

class SectorsSeeder extends Seeder
{
    public function run()
    {
        $sectors = [
            'Accountancy' => 2,
            'Accountancy (Qualified)' => 100,
            'Admin, Secretarial & PA' => 3,
            'Apprenticeships' => 1964,
            'Banking' => 5,
            'Charity & Voluntary' => 500,
            'Construction & Property' => 146,
            'Customer Service' => 66,
            'Education' => 68,
            'Energy' => 1961,
            'Engineering' => 12,
            'Estate Agency' => 1962,
            'Financial Services' => 117,
            'FMCG' => 1722,
            'General Insurance' => 16,
            'Graduate Training & Internships' => 169,
            'Health & Medicine' => 36,
            'Hospitality & Catering' => 6,
            'Human Resources' => 24,
            'IT & Telecoms' => 52,
            'Legal' => 101,
            'Leisure & Tourism' => 92,
            'Manufacturing' => 168,
            'Marketing & PR' => 18,
            'Media, Digital & Creative' => 71,
            'Motoring & Automotive' => 1700,
            'Public Sector' => 501,
            'Purchasing' => 27,
            'Recruitment Consultancy' => 338,
            'Retail' => 90,
            'Sales' => 30,
            'Scientific' => 89,
            'Security & Safety' => 1963,
            'Social Care' => 34,
            'Strategy & Consultancy' => 1755,
            'Training' => 1909,
            'Transport & Logistics' => 11,
            'Other' => 21,
        ];

        $this->command->getOutput()->progressStart(count($sectors));

        \DB::transaction(function () use ($sectors) {
            foreach ($sectors as $name => $id) {
                $sector = Sector::create(compact('name'));

                $response = \Http::get("https://www.reed.co.uk/api/sector/registrationsubsectors?parentSectorId=$id")->body();
                $reedRoles = collect(json_decode($response, true))->pluck('Name');

                $roles = Role::findOrCreate($reedRoles->toArray());
                $sector->roles()->sync($roles->pluck('id')->toArray());
                $this->command->getOutput()->progressAdvance();
            }
        });

        $this->command->getOutput()->progressFinish();
    }
}
