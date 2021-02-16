<?php

namespace Modules\Frontend\Http\Controllers\Api;

use App\Services\LocationService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Frontend\Http\Controllers\Controller;

class LocationController extends Controller
{
    protected LocationService $service;

    public function __construct()
    {
        $this->service = app(LocationService::class);
    }

    public function all(string $query)
    {
        return $this->service->search($query);
    }

    public function cities(string $query)
    {
        return $this->service->searchCity($query);
    }
}
