<?php

namespace App\Providers;

use App\Services\LogRecorders\SlackLogRecorder;
use Illuminate\Support\ServiceProvider;

class LogRecorderServiceProvider extends ServiceProvider
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
        \App::bind('LogRec', function(){
            return new SlackLogRecorder();
        });
    }
}
