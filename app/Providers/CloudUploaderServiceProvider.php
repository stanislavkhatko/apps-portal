<?php

namespace App\Providers;

use App\Services\CloudUploaders\DigitalOceanCloudUploader;
use Illuminate\Support\ServiceProvider;

class CloudUploaderServiceProvider extends ServiceProvider
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
        \App::bind('CloudUploader', function(){
            return new DigitalOceanCloudUploader();
        });
    }
}
