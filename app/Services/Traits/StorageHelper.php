<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 4/4/2018
 * Time: 3:08 PM
 */

namespace App\Services\Traits;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;


trait StorageHelper
{

    protected function moveItemToCloud($tempInputLink, $newFileName, $storage)
    {
        $tempFile = basename($tempInputLink);
        $fileExtension = pathinfo($tempFile, PATHINFO_EXTENSION);
        $newFile = $newFileName . '.' . $fileExtension;

        $fullFilePath = Storage::disk('temp')->getDriver()->getAdapter()->getPathPrefix() . "/" . $tempFile;
        $file = new File($fullFilePath);
        Storage::disk('spaces')->putFileAs($storage, $file, $newFile, 'public');
        Storage::disk('temp')->delete($tempFile);
        return $storage . '/' . $newFile;
    }

    protected function removeItemFromCloud($fileName)
    {
        return Storage::disk('spaces')->delete($fileName);
    }

    protected function moveItemToStorage($tempInputLink, $newFileName, $storage)
    {
        $tempFile = basename($tempInputLink);
        $fileExtension = pathinfo($tempFile, PATHINFO_EXTENSION);
        $newFile = $newFileName . '.' . $fileExtension;

        $fullFilePath = Storage::disk('temp')->getDriver()->getAdapter()->getPathPrefix() . "/" . $tempFile;
        Storage::putFileAs($storage, new File($fullFilePath), $newFile);
        Storage::disk('temp')->delete($tempFile);
        return $storage . '/' . $newFile;
    }
}