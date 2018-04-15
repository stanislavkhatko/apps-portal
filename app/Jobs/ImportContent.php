<?php

namespace App\Jobs;

use App\ContentProviders\ContentProviderContract;
use function class_exists;
use ErrorException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportContent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Content providers that contain api processing calls. (app/ContentProviders)
     *
     * @var array|\App\ContentProviders\ContentProviderContract
     */
    protected $providers = [
         'melodimedia',
//        'mobibase',
    ];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \ErrorException
     */
    public function handle()
    {
        foreach ($this->providers as $providerName) {
            $providerClass = '\App\ContentProviders\\'.ucfirst($providerName).'ContentProvider';
            if (! class_exists($providerClass)) {
                throw new ErrorException("No content provider found for `$providerName`");
            }

            /** @var ContentProviderContract $provider */
            $provider = new $providerClass;
            $provider->importContent();
        }
    }
}
