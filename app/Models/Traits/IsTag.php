<?php

namespace App\Models\Traits;

use Illuminate\Support\Collection;

trait IsTag
{
    /* @return self[]|Collection */
    public static function findOrCreate(array $values): Collection
    {
        return collect($values)->map(function ($value) {
            return static::findOrCreateFromString($value);
        });
    }

    protected static function findOrCreateFromString(string $name)
    {

        $tag = static::findFromString($name);

        if (!$tag) {
            $tag = static::create(['name' => $name]);
        }

        return $tag;
    }

    protected static function findFromString(string $name)
    {
        return static::query()
            ->where('name', $name)
            ->first();
    }
}
