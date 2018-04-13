<?php

namespace App\Providers;

use App\Services\ContentLoaders\LocalContentLoader;
use Illuminate\Support\ServiceProvider;

class ContentLoaderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(){}

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind('ContentLoader', function(){
            return new LocalContentLoader();
        });
    }
}
