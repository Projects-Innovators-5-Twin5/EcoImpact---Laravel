<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RdfApiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RdfApiService::class, function ($app) {
            return new RdfApiService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
