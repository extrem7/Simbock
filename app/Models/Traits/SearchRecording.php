<?php

namespace App\Models\Traits;

use App\Models\SearchQuery;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait SearchRecording
{
    public function searchQueries(): HasMany
    {
        return $this->hasMany(SearchQuery::class);
    }
}
