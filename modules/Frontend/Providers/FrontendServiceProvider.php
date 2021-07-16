<?php

namespace Modules\Frontend\Providers;

use App\Models\Page;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Schema;

class FrontendServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Frontend';

    protected string $moduleNameLower = 'frontend';

    public function boot()
    {
        $this->registerConfig();
        $this->registerViews();
        $this->viewComposer();
        $this->schema();
        $this->directives();
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(BroadcastServiceProvider::class);
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

    protected function viewComposer()
    {
        \View::composer('frontend::layouts.master', function ($view) {
            $bodyClass = \Route2Class::getClasses()->join(' ');
            $view->with('bodyClass', $bodyClass);
        });
    }

    private function schema(): void
    {
        View::composer('frontend::layouts.master', function ($view) {
            $schema = collect();

            $page = Page::find(1);

            $organization = Schema::organization()
                ->name($page->meta_title ?? $page->title)
                ->email('contact@simbock.com')
                ->description($page->meta_description)
                ->logo(asset('dist/img/logo.svg'))
                ->url(url('/'));

            $schema->push($organization);

            $schema = $schema->map(fn(BaseType $item) => $item->toScript());

            $view->with('schema', $schema);
        });
    }

    private function directives(): void
    {
        \Blade::directive('schema', function () {
            return '<?php $schema->each(fn($item)=>print($item)); ?>';
        });
    }
}
