<?php

namespace Modules\Frontend\Providers;

use Illuminate\Support\ServiceProvider;

class FrontendServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Frontend';

    protected string $moduleNameLower = 'frontend';

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

    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'config.php'), $this->moduleNameLower
        );
    }
}
