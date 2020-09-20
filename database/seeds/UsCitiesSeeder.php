<?php

use App\Models\Map\US\City;
use Illuminate\Database\Seeder;

class UsCitiesSeeder extends Seeder
{
    public function run()
    {
        $cities = [];

        $file_handle = fopen(resource_path('db/us_cities/uscities.csv'), 'r');
        while (!feof($file_handle)) {
            $cities[] = fgetcsv($file_handle, 0, ',');
        }
        fclose($file_handle);

        $columns = array_shift($cities);
        array_pop($cities);

        $cities = array_map(function ($city) use ($columns) {
            $mapped = [];

            foreach ($city as $key => $value) {
                $mapped[$columns[$key]] = $value;
            }

            return $mapped;
        }, $cities);

        \DB::transaction(function () use ($cities) {
            $this->command->getOutput()->progressStart(count($cities));
            foreach ($cities as $data) {
                City::insert([
                    'id' => $data['id'],
                    'state_id' => $data['state_id'],
                    'name' => $data['city'],
                    'county' => $data['county_name'],
                    'lat' => $data['lat'],
                    'lng' => $data['lng'],
                    'zips' => $data['zips'],
                    'population' => $data['population']
                ]);
                $this->command->getOutput()->progressAdvance();
            }
            $this->command->getOutput()->progressFinish();
        });
    }
}
