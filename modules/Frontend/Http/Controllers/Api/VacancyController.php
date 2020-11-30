<?php

namespace Modules\Frontend\Http\Controllers\Api;

use App\Models\Jobs\Role;
use Illuminate\Support\Collection;
use Modules\Frontend\Http\Controllers\Controller;

class VacancyController extends Controller
{
    public function search(string $query): Collection
    {
        return Role::where('name', 'REGEXP', "^.*$query.*$")
            ->pluck('name');
    }
}
