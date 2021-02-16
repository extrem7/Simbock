<?php

namespace Modules\Frontend\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Broadcast::routes();

        require module_path('Frontend', 'routes/channels.php');
    }
}
