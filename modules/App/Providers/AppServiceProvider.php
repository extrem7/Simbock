<?php

namespace Modules\App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'App';

    protected string $moduleNameLower = 'app';

    public function boot()
    {
        $this->registerConfig();
        $this->registerViews();
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function registerViews()
    {
        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->loadViewsFrom($sourcePath, $this->moduleNameLower);
    }

    public function provides()
    {
        return [];
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'config.php'), 'application'
        );
    }

}
