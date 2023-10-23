<?php

namespace App\Providers;

use App\Services\CacheRepositoryService;
use App\Services\FamousNamesService;
use App\Services\StorageRepositoryService;
use Illuminate\Support\ServiceProvider;

class FamousNamesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FamousNamesService::class, function ($app) {
            return new FamousNamesService(
                new CacheRepositoryService(),
                new StorageRepositoryService());
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
