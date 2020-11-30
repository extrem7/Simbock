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
            if (strlen($query) === 2) {
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

    public function parseLocation(string $query): array
    {
        $cityName = '';
        $countyName = '';
        $state = null;
        $locations = [];

        $parts = explode('--', $query);
        if (count($parts) > 1) {
            [$cityName, $countyState] = $parts;
            $cityName = implode(' ', explode('-', $cityName));
            $words = collect(explode('-', $countyState));
            $countyName = $words->reverse()->splice(1, 1)->first();
        } else {
            $words = collect(explode('-', $parts[0]));
            $cityName = $words->reverse()
                ->slice(strlen($words->last()) === 2 ? 1 : 0)
                ->reverse()
                ->join(' ');
        }

        if (strlen($words->last()) === 2) {
            $state = State::find($words->last());
            if ($county = \DB::table('us_cities')
                ->select('county')
                ->where('state_id', '=', $state->id)
                ->where('county', '=', $countyName)
                ->distinct()
                ->exists()
            ) {
                $locations = City::where('state_id', '=', $state->id)
                    ->where('county', '=', $countyName)
                    ->where('name', '=', $cityName)
                    ->pluck('id');
            } else {
                $locations = City::where('state_id', '=', $state->id)
                    ->where('name', '=', $cityName)
                    ->pluck('id');
            }
        } else {
            $locations = collect($this->searchCity($words->join(' ')))
                ->map(fn($c) => $c['value']);
        }
        return $locations->toArray();
    }

    public function searchCity(string $query): array
    {
        return City::where('name', $query)
            ->orWhere('name', 'like', "$query%")
            ->biggest()
            ->limit($this->resultsLimit)
            ->get($this->cityFields)
            ->map(fn(City $c) => ['text' => $this->mapCity($c), 'value' => $c->id, 'zips' => $c->zips])
            ->toArray();
    }

    public function mapCity(City $c): string
    {
        $name = $c->name;
        if (
            ($c->name !== $c->county)
            &&
            City::where('name', '=', $c->name)
                ->where('state_id', '=', $c->state_id)
                ->count() > 1
        ) {
            $name .= ", $c->county";
        }
        return "$name $c->state_id";
    }
}
