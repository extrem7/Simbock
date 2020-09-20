<?php

namespace App\Models\Map\US;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'us_cities';

    protected $fillable = ['id', 'state_id', 'name', 'county', 'lat', 'lng', 'zips', 'population'];

    public function scopeBiggest(Builder $query)
    {
        return $query->orderByDesc('population');
    }
}
