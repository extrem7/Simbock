<?php

namespace App\Services;

use App\Models\Map\US\City;
use App\Models\Map\US\State;

class LocationService
{
    protected array $cityFields = ['id', 'name', 'county', 'state_id', 'zips'];

    protected int $resultsLimit = 8;

    public function search(string $query): array
    {
        $isZip = preg_match('#[0-9]{5}#', $query);

        if ($isZip) {
            $cities = City::where('zips', 'LIKE', "% $query %")
                ->orWhere('zips', 'LIKE', "$query %")
                ->orWhere('zips', 'LIKE', "$query%")
                ->orWhere('zips', 'LIKE', "% $query%")
                ->orWhere('zips', 'LIKE', "% $query")
                ->orWhere('zips', $query)
                ->orderByDesc('population')
                ->limit($this->resultsLimit)
                ->get($this->cityFields);

            return $cities->map(function (City $c) use ($query) {
                $zips = array_filter(explode(' ', $c->zips), fn($zip) => str_contains($zip, $query));
                $zip = array_shift($zips);
                $mapped = $this->mapCity($c);
                $mapped = "$zip, $mapped";
                return $mapped;
            })->toArray();
        } else {
            if (strlen($query) == 2) {
                $state = State::find($query);
                if ($state) {
                    /* @var $cities City */
                    $cities = $state->cities();
                    $cities = $cities->biggest()
                        ->limit($this->resultsLimit - 1)
                        ->get($this->cityFields)
                        ->map(fn(City $c) => $this->mapCity($c));
                    return ["$state->name state", ...$cities];
                }
            } else if (strlen($query) > 2) {
                return City::where('name', $query)
                    ->orWhere('name', 'like', "$query%")
                    ->biggest()
                    ->limit($this->resultsLimit)
                    ->get($this->cityFields)
                    ->map(fn(City $c) => $this->mapCity($c))
                    ->toArray();
            }
        }
        return [];
    }

    protected function mapCity(City $c)
    {
        return "$c->name, $c->county $c->state_id";
    }
}
