<?php

namespace Modules\Frontend\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Frontend\Http\Middleware\CompleteRegistration;
use Modules\Frontend\Http\Middleware\ServerPush;
use Modules\Frontend\Http\Middleware\SharedData;

class RouteServiceProvider extends ServiceProvider
{

    protected $moduleNamespace = 'Modules\Frontend\Http\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::domain(env('APP_DOMAIN'))
            ->middleware(['web', CompleteRegistration::class, SharedData::class, ServerPush::class])
            ->namespace($this->moduleNamespace)
            ->as('frontend.')
            ->group(module_path('Frontend', 'routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware(['web', 'api'])
            ->namespace($this->moduleNamespace . '\Api')
            ->group(module_path('Frontend', 'routes/api.php'));
    }
}
