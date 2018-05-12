<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ContentDownload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download content from cloud to server';

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
        $contents = Storage::disk('spaces')->allFiles('');

        foreach ($contents as $imageFile) {
            // Take only image files from listed directories
            // Files stored as '/public/cotnent-item-images/2/name.png'
            if (strpos($imageFile, 'public/') === 0) {

                dump($imageFile);

                $image = Storage::disk('spaces')->get($imageFile);
                Storage::put($imageFile, $image);
            }
        }
    }
}
