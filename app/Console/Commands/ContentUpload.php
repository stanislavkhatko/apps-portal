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
        // TODO upload content to cloud
        $contentItems = ContentItem::all();

        foreach ($contentItems as $item) {
            if ($item->preview && Storage::exists($item->preview)) {
                $image = Storage::get($item->preview);
                Storage::disc('spaces')->put($item->preview, $image);
                $this->info('Item id: ' . $item->id . ' preview image uploaded to spaces');
            }
        }
    }
}
