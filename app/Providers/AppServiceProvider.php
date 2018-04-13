<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use DevIT\MelodiMedia\ApiClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapThree();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ApiClient::class, function ($app) {
            return new ApiClient(
                config('services.melodi.user'),
                config('services.melodi.password'),
                config('services.melodi.site_id')
            );
        });
    }
}
