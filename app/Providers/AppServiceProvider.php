<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Validator::extend('string255', function ($attribute, $value, $parameters, $validator) {
            return is_string($value) && mb_strlen($value) <= 255;
        });
    }
}
