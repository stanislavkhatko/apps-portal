<?php

namespace App\ContentProviders;

use App\Models\Category;
use App\Models\ContentItem;
use App\Models\ContentType;
use Clients\Mobibase\Client;

class MobibaseContentProvider implements ContentProviderContract
{
    public $client;

    public function __construct()
    {
        $this->client = new Client(config('services.mobibase.api_key'));
    }

    public function importContent(): bool
    {
        $contentType = ContentType::firstOrNew(['remote_id' => '99999999']);
        $contentType->label = 'Videos';
        $contentType->provider = 'mobibase';
        $contentType->save();

        $this->importCategories($contentType);
        return true;
    }

    public function importCategories($contentType)
    {
        $service = $this->client->getPackages();
        dump($service);
        if ($service->status == 'OK') {
            $packages = $service->response->packages;
            echo $service->response->contents, ' package(s) in the VOD
service';
            echo '<ul>';
            foreach ($packages as $package) {
                $category = Category::firstOrNew(['remote_id' => $package->id]);
                $category->content_type_id = $contentType->id;
                $category->remote_id = $package->id;
                $category->label = $package->name ?? '';
                $category->adult = 0;
                $category->save();

                $this->importPackage($category);
            }
            echo '</ul>';
        }

    }

    public function importPackage($category): bool
    {
        $perpage = 10;

        $getMeta = $this->client->getPackage($category->remote_id, ['perpage' => $perpage]);
        $pages = 1;
        if ($getMeta->status = 'OK') {
            $pages = ceil($getMeta->response->package->contents / $perpage);
        }

        for ($page = 1; $page <= $pages; $page++) {
            $getPackage = $this->client->getPackage($category->remote_id, ['page' => $page, 'perpage' => 10]);
            if ($getPackage == null) {
                dump('Packages is null.');

                continue;
            }
            if ($getPackage->status == 'OK') {
                $package = $getPackage->response->package;

                foreach ($package->videos as $video) {
                    $contentItem = ContentItem::firstOrNew(['remote_id' => $video->id, 'provider' => 'mobibase']);
                    $contentItem->category_id = $category->id;
                    $contentItem->title = ['en' => $video->name];
                    $contentItem->preview = $video->preview;
                    $contentItem->provider = 'mobibase';
                    $contentItem->description = '';
                    $contentItem->type = 'video';

                    $contentItem->save();
                }

                // Need to sleep between pagination, api starts returning empty responses
                // when asking to fast.
                sleep(1);
            }
        }

        return true;
    }

    public function importVideos($id): bool
    {
        $service = $this->client->getVideos();

        $videos = $service->response->videos; // array of video objects
    }
}
