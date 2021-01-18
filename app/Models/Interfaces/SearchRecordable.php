<?php


namespace App\Models\Interfaces;


use Illuminate\Database\Eloquent\Relations\HasMany;

interface SearchRecordable
{
    public function searchQueries(): HasMany;
}
