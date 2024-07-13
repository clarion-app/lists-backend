<?php

namespace ClarionApp\ListsBackend;

use Illuminate\Support\ServiceProvider;

class ListsBackendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        if(!$this->app->routesAreCached())
        {
            require __DIR__.'/Routes.php';
        }
    }
}
