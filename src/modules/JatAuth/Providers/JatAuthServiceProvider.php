<?php

namespace Modules\JatAuth\Providers;

use Illuminate\Support\ServiceProvider;

class JatAuthServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
//        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
//        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'JatAuth');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
//        $this->loadViewsFrom(__DIR__ . '/../views', 'JatAuth');

    }
}
