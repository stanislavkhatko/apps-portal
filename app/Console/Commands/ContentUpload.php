<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContentItem;
use Illuminate\Support\Facades\Storage;

class ContentUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload content to cloud';

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
        $contents = Storage::disk('local')->allFiles('');

        foreach ($contents as $imageFile) {
            // Take only image files from listed directories
            // Files stored as '/public/cotnent-item-images/2/name.png'
            if (strpos($imageFile, '/content-item-images/') !== false ||
                strpos($imageFile, '/local-content-type-images/') !== false ||
                strpos($imageFile, '/navbar-images/') !== false ||
                strpos($imageFile, '/footer-images/') !== false) {

                dump($imageFile);

                //saving image file to cloud
                $storageFolder = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
                $fullImagePath = $storageFolder . $imageFile;
                $handle = fopen($fullImagePath, 'r');
                Storage::disk('spaces')->put($imageFile, $handle, 'public');
                fclose($handle);
            }
        }
    }
}
