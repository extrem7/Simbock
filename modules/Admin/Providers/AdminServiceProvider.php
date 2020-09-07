<?php

namespace Modules\Admin\Providers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Auth;
use Cookie;
use Illuminate\Support\ServiceProvider;
use View;

class AdminServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Admin';

    protected string $moduleNameLower = 'admin';

    public function boot(): void
    {
        $this->registerConfig();
        $this->registerViews();

        $this->sharedData();
        $this->viewComposer();
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function registerViews(): void
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

    protected function sharedData()
    {
        View::composer('admin::layouts.master', function () {
            share([
                'app' => [
                    'name' => config('app.name'),
                    'env' => config('app.env'),
                ],
                'csrf' => csrf_token()
            ]);
        });
    }

    protected function viewComposer()
    {
        View::composer('admin::layouts.master', function ($view) {
            $bodyClass = \Route2Class::generateClassString();
            $bodyClass = (string)\Str::of($bodyClass)->replace('login', 'login-page');
            $view->with('bodyClass', $bodyClass);
        });
        View::composer(['admin::layouts.base'], function ($view) {
            \Route2Class::addClass('sidebar-mini');

            $title = str_replace(SEOMeta::getTitleSeparator() . SEOMeta::getDefaultTitle(), '', SEOMeta::getTitle());
            if ($title) {
                $view->with('pageTitle', $title);
            }

            if (Cookie::get('sidebar-toggle-collapsed')) {
                \Route2Class::addClass('sidebar-collapse');
            }
        });
        View::composer('admin::includes.sidebar', function ($view) {
            $view->with('name', ucfirst(Auth::getUser()->name));
        });
    }
}
