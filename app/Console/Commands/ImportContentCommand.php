<?php

namespace App\Console\Commands;

use function camel_case;
use function class_basename;
use function dispatch;
use Illuminate\Console\Command;
use function str_contains;

class ImportContentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import content from all providers.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Output only visible when command triggered in terminal when queues arent enabled.
        \Event::listen('eloquent.*', function($eventName, $data) {
            $formattedEventName = explode(':', $eventName)[0];
            $catching = ['Category', 'ContentItem', 'ContentType'];

            $name = $data[0]->label ?? $data[0]->title ?? '-';
            if ($formattedEventName == 'eloquent.saved') {
                $this->info('Saved new '.class_basename($data[0]).' `'. $name .'`');

            }
        });

        dispatch(new \App\Jobs\ImportContent());
        $this->info('Import job dispatched');
    }
}
