<?php

use App\Models\Jobs\Sector;
use Illuminate\Database\Seeder;

class SectorsSeeder extends Seeder
{
    public function run()
    {
        $sectors = [
            'Accountancy', 'Accountancy (Qualified)', 'Admin, Secretarial & PA', 'Apprenticeships', 'Banking',
            'Charity & Voluntary', 'Construction & Property', 'Customer Service', 'Education', 'Energy', 'Engineering',
            'Estate Agency', 'Financial Services', 'FMCG', 'General Insurance', 'Graduate Training & Internships',
            'Health & Medicine', 'Hospitality & Catering', 'Human Resources', 'IT & Telecoms', 'Legal',
            'Leisure & Tourism', 'Manufacturing', 'Marketing & PR', 'Motoring & Automotive', 'Public Sector',
            'Purchasing', 'Recruitment Consultancy', 'Retail', 'Sales', 'Scientific', 'Security & Safety',
            'Social Care', 'Strategy & Consultancy', 'Training', 'Transport & Logistics', 'Other'
        ];

        \DB::transaction(function () use ($sectors) {
            foreach ($sectors as $sector) Sector::create(['name' => $sector]);
        });
    }
}
