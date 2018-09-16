<?php

namespace App\Providers;

use App\Services\DataUpdater;
use Illuminate\Support\ServiceProvider;

class DataUpdaterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DataUpdater::class, function ($app) {
            return new DataUpdater();
        });
    }
}
