<?php

namespace ClarionApp\ListsBackend;

use ClarionApp\Backend\ClarionPackageServiceProvider;

class ListsBackendServiceProvider extends ClarionPackageServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        if(!$this->app->routesAreCached())
        {
            require __DIR__.'/Routes.php';
        }
    }
}
