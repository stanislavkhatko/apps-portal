<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 4/2/2018
 * Time: 10:44 PM
 */

namespace App\Services\ContentLoaders;

use App\Services\Traits\StorageHelper;
use Illuminate\Support\Facades\Storage;
use App\Services\Facades\LogRec;
use Illuminate\Http\Request;
use App\Models\ContentItem;
use App\Services\Facades\ContentLoader;
use Illuminate\Http\File;

final class LocalContentLoader extends ContentLoader
{
    use StorageHelper;

    #region MAIN METHODS

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $contentItem = ContentItem::find($id);
        $contentItem->fill($request->get('contentItem'));

        // Upload content item
        if ($request->input('contentItem')['download']['link'] && $request->input('contentItem')['type'] !== 'reference' && Storage::disk('temp')->exists(basename($request->input('contentItem')['download']['link']))) {
            // If type is set to cloud upload
            if($request->input('contentItem')['type'] === 'cloud') {
                $contentItem->download = $this->moveItemToCloud(
                    $request->input('contentItem')['download']['link'],
                    'content-item_' . $contentItem->id . '_' . time(),
                    'content-items');
            } else {
                // Upload file locally
                $this->deleteOldContentFile(basename($contentItem->download['link']));
                $contentItem->download = $this->moveToContentFolder($request, $contentItem->id);
            }
        }

        // Upload preview image
        if ($request->input('contentItem')['preview']) {
            if (Storage::disk('temp')->exists(basename($request->input('contentItem')['preview']))) {
                $this->deleteOldImageFile(basename($contentItem->preview));
                $contentItem->preview = $this->moveToImagesFolder($request, $contentItem->id);
            }
        }

        $contentItem->save();
        return $contentItem;
    }

    public function store(Request $request)
    {
        $contentItem = new ContentItem();
        $contentItem->fill($request->get('contentItem'));
        $contentItem->save();

        // Upload content item
        if ($request->input('contentItem')['download']['link'] && $request->input('contentItem')['type'] !== 'reference') {
            if (Storage::disk('temp')->exists(basename($request->input('contentItem')['download']['link']))) {
                $this->deleteOldContentFile(basename($contentItem->download['link']));
                $contentItem->download = $this->moveToContentFolder($request, $contentItem->id);
            }
        }

        // Upload preview image
        if ($request->input('contentItem')['preview']) {
            if (Storage::disk('temp')->exists(basename($request->input('contentItem')['preview']))) {
                $this->deleteOldImageFile(basename($contentItem->preview));
                $contentItem->preview = $this->moveToImagesFolder($request, $contentItem->id);
            }
        }

        $contentItem->save();
        return $contentItem;
    }

    public function delete(ContentItem $contentItem)
    {
        $imageFiles = Storage::disk('images')->files();
        if (count($imageFiles) > 0) {
            $image = $this->findFile($imageFiles, $contentItem->id);
            if ($image !== false) {
                Storage::disk('images')->delete($image);
            }
        }

        $contentFiles = Storage::disk('content')->files();
        if (count($contentFiles) > 0) {
            $content = $this->findFile($contentFiles, $contentItem->id);
            if ($content !== false) {
                Storage::disk('content')->delete($content);
            }
        }
    }
    #endregion

    #region SERVICE METHODS
    private function moveToImagesFolder($request, $id)
    {
        $newFileName = 'content-item-image_' . $id . '_' . time();
        $DS = DIRECTORY_SEPARATOR;
        $file = basename($request->input('contentItem')['preview']);
        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

        $path = 'temp' . $DS . $file;
        Storage::disk('public')->move($path, 'images' . $DS . $newFileName . '.' . $fileExtension);
        return Storage::disk('images')->url($newFileName . '.' . $fileExtension);
    }

    private function moveToContentFolder($request, $id)
    {
        $newFileName = 'content-item_' . $id . '_' . time();
        $DS = DIRECTORY_SEPARATOR;
        $file = basename($request->input('contentItem')['download']['link']);

        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

        $path = 'temp' . $DS . $file;

        Storage::disk('public')->move($path, 'content' . $DS . $newFileName . '.' . $fileExtension);

        $storageDirectory = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $fullPath = $storageDirectory . 'public' . $DS . 'content' . $DS . $newFileName . '.' . $fileExtension;
        return [
            'link' => $fullPath
        ];
    }

    private function deleteOldImageFile($imageFile)
    {
        Storage::disk('images')->delete($imageFile);
    }

    private function deleteOldContentFile($contentFile)
    {
        Storage::disk('content')->delete($contentFile);
    }

    private function moveItemToCloud($tempInputLink, $newFileName, $storage)
    {
        $tempFile = basename($tempInputLink);
        $fileExtension = pathinfo($tempFile, PATHINFO_EXTENSION);
        $newFile = $newFileName . '.' . $fileExtension;

        $fullFilePath = Storage::disk('temp')->getDriver()->getAdapter()->getPathPrefix() . "/" . $tempFile;
        $file = new File($fullFilePath);
        Storage::disk('spaces')->putFileAs($storage, $file, $newFile);
        return ['link' => $storage . '/' . $newFile];
    }
    #endregion
}