<?php

namespace App\ContentProviders;

use App\Models\ContentItem;
use App\Models\ContentType;
use App\Models\Category;
use DevIT\MelodiMedia\ApiClient;

class MelodimediaContentProvider implements ContentProviderContract
{
    /**
     * @var ApiClient Melodimedia api client
     */
    protected $client;

    public function __construct()
    {
        $this->client = app(ApiClient::class);
    }

    /**
     * Import contentTypes from melodi provider
     *
     * @return bool
     */
    public function importContent(): bool
    {
        try {
            $types = $this->client->contentTypes();

            $index = 0;
            foreach ($types as $type) {
                if (! isset($type['value'])) {
                    continue;
                }
                $contentType = ContentType::firstOrNew(['remote_id' => $type['ContentTypeID']]);
                $contentType->label = $type['value'] ?? '';
                $contentType->provider = 'melodimedia';

                $contentType->save();
                if (in_array($contentType->remote_id, [64])) {
                    $this->importCategories($contentType);
                }
                $index++;
            }
        } catch (\Exception $e) {
            var_dump('Failed to request contenttypes: '.$e->getMessage());
        }

        return true;
    }

    /**
     * Import all categories for a given contenttype
     *
     * @param \App\Models\ContentType $contentType
     */
    private function importCategories(ContentType $contentType)
    {
        try {
            $normalCategories = $this->client->categoriesForContentType($contentType->remote_id);
            $adultCategories = $this->client->categoriesForContentType($contentType->remote_id, 2, true);
            $categories = array_merge($normalCategories, $adultCategories);

            foreach ($categories as $remoteCategory) {
                $category = Category::firstOrNew(['remote_id' => $remoteCategory['categoryID']]);
                $category->content_type_id = $contentType->id;
                $category->label = $remoteCategory['value'];
                $category->adult = in_array($remoteCategory, $adultCategories);

                $category->save();

                $this->importItems($category);
            }
        } catch (\Exception $e) {
            var_dump('Failed to request categories: '.$e->getMessage());
        }
    }

    /**
     * Import all content items for a given category.
     *
     * @param \App\Models\Category $category
     */
    private function importItems(Category $category)
    {
        try {
            $items = $this->client->contentForCategory($category->remote_id);

            foreach ($items as $item)  {
                $contentItem = ContentItem::firstOrNew(['remote_id' => $item['ContentID']]);
                $contentItem->category_id = $category->id;
                $contentItem->title = ['en' => $item['ContentTitle']];
                $contentItem->preview = $item['Web_Preview'];
                $contentItem->provider = 'melodimedia';

                $contentItem->save();

                var_dump("Importing for `{$contentItem->title}`");
                $this->importItemDetails($contentItem);
            }
        } catch (\Exception $e) {
            var_dump('Failed to request items for category ('.$category->remote_id.'): '.$e->getMessage());
        }
    }

    /**
     * Import the details for content item
     *
     * @param \App\Models\ContentItem $item
     */
    private function importItemDetails(ContentItem $item)
    {
        $details = $this->client->contentDetailsExtended($item->remote_id, true)['content'][0];
        // var_dump($details);
        $item->description = ['en' => $details['comments']];
        if (is_array($details['translations'])) {
            $translations = $details['translations'];
            if (isset($translations[0])) {
                $translations = $translations[0];
            }

            foreach ($translations['translation'] as $translation) {
                if ($translation['AcceptLanguage'] != 'en') {
                    $item->setTranslation('title', $translation['AcceptLanguage'], $translation['ContentTitle']);
                }
                $item->setTranslation('description', $translation['AcceptLanguage'], $translation['comments']);
            }
        }

        $operatingSystems = $details['compatibility'][0]['MobileOperatingSystem'] ?? $details['compatibility']['MobileOperatingSystem'];
        $osInfo = [];
        foreach ($operatingSystems as $operatingSystem) {
            $osInfo[] = [
                'os' => $operatingSystem['OS'],
                'minVersion' => $operatingSystem['MinOSVersion'],
            ];
        }

        $item->compatibility = $osInfo;
        $item->save();

        // exit();
    }
}
