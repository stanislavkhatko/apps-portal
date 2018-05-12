<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContentItem;
use Illuminate\Support\Facades\Storage;

class contentDownload extends Command
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
    protected $description = 'Download content from cloud  to server';

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
        $contentItems = ContentItem::all();

        foreach ($contentItems as $item) {
            if ($item->preview && Storage::disk('spaces')->exists($item->preview)) {
                $path = explode('/', $item->preview);
                $image = Storage::disk('spaces')->get($item->preview);
                Storage::put('public/' . $path[0] . '/' . $item->id . '/' . $path[1], $image);
                $item->preview = '/storage/' . $path[0] . '/' . $item->id . '/' . $path[1];
                $item->save();
                $this->info('Item id: ' . $item->id . ' preview image downloaded and saved');
            }


//            else if ($item->download && isset($item->download['link']) && strpos($item->download['link'], 'content-items') !== false && $item->id === 4) {
//                $path = explode('/', $item->download['link']);
//                $file = Storage::disk('spaces')->get($item->download['link']);
//                Storage::put('public/' . $path[0] . '/' . $item->id . '/' . $path[1], $file);
//                $item->download['link'] = '/storage/'  . $path[0] . '/' . $item->id . '/' . $path[1];
//                $item->save();
//                $this->info('Item id: ' . $item->id . ' content file was downloaded and saved');
//            }
        }

    }
}
