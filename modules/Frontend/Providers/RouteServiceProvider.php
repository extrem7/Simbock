<?php

namespace Modules\Frontend\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    protected $moduleNamespace = 'Modules\Frontend\Http\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        // $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::domain(env('APP_DOMAIN'))
            ->middleware('web')
            ->namespace($this->moduleNamespace)
            ->as('frontend.')
            ->group(module_path('Frontend', 'routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Frontend', '/Routes/api.php'));
    }
}
