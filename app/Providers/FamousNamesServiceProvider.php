<?php

namespace App\Providers;

use App\Services\FamousNamesCacheService;
use App\Services\FamousNamesService;
use Illuminate\Support\ServiceProvider;

class FamousNamesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FamousNamesService::class, function ($app) {
            return new FamousNamesService(new FamousNamesCacheService());
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
