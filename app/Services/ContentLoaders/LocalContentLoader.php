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



}