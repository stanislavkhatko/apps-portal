<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 4/3/2018
 * Time: 10:32 AM
 */

namespace App\Services\CloudUploaders;


use App\Models\ContentItem;
use App\Services\Traits\StorageHelper;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class DigitalOceanCloudUploader extends CloudUploader
{
    use StorageHelper;

    private $localImages;
    private $localContent;

    private $cloudContentFolder = 'content';
    private $cloudImageFolder = 'images';

    public function __construct()
    {
        $this->localImages = Storage::disk('images')->files('');
        $this->localContent = Storage::disk('content')->files('');
    }

    #region MAIN METHODS
    public function upload()
    {
        $cleanImageNames = $this->getCleanContentItemNames($this->localImages);
        $cleanContentNames = $this->getCleanContentItemNames($this->localContent);

        if ($cleanImageNames) {
            foreach ($cleanImageNames as $key => $imageFile) {
                //saving image file to cloud
                $storageFolder = Storage::disk('images')->getDriver()->getAdapter()->getPathPrefix();
                $fullImagePath = $storageFolder . $imageFile;
                $handle = fopen($fullImagePath, 'r');
                Storage::disk('spaces')->put($this->cloudImageFolder . '/' . $imageFile, $handle, 'public');
                fclose($handle);
            }
        }

        if ($cleanContentNames) {
            foreach ($cleanContentNames as $key => $contentFile) {
                //saving content file to cloud
                $storageFolder = Storage::disk('content')->getDriver()->getAdapter()->getPathPrefix();
                $fullImagePath = $storageFolder . $contentFile;
                $handle = fopen($fullImagePath, 'r');
                Storage::disk('spaces')->put($this->cloudContentFolder . '/' . $contentFile, $handle);
                fclose($handle);
            }
        }

        if ($filesArray) {
//            $this->removeOldFilesFromCloud($imageFile);
//            $this->copyNewFilesToCloud($imageFile, $contentFile);
            $this->recordCloudPathsToDB($imageFile, $contentFile);
            $this->deleteLocalFiles($imageFile, $contentFile);
        }
    }

    public function update(Request $request, $id)
    {
        $contentItem = ContentItem::find($id);
        $contentItem->fill($request->get('contentItem'));

        // Update contentItem file
        if ($request->input('contentItem')['download']['link']) {
            if (Storage::disk('temp')->exists(basename($request->input('contentItem')['download']['link']))) {
                Storage::disk('spaces')->delete('content/' . basename($contentItem->download['link']));
                $contentItem->download = $this->moveToCloudFolderAndReturnPath(
                    $request->input('contentItem')['download']['link'],
                    'content-item_' . $contentItem->id . '_' . time(),
                    $this->cloudContentFolder);
                $contentItem->type = 'cloud';
            }
        }

        // Upload preview image
        if ($request->input('contentItem')['preview']) {
            if (Storage::disk('temp')->exists(basename($request->input('contentItem')['preview']))) {
                Storage::disk('spaces')->delete('images/' . basename($contentItem->preview));
                $contentItem->preview = $this->moveToCloudFolderAndReturnPath(
                    $request->input('contentItem')['preview'],
                    'content-item-image_' . $contentItem->id . '_' . time(),
                    $this->cloudImageFolder
                );
            }
        }

        $contentItem->save();
        return $contentItem;
    }

    public function download(ContentItem $item)
    {
        try {
            $file = $item->download['link'];
            $fs = Storage::disk('spaces')->getDriver();
            $stream = $fs->readStream($file);

            return Response::stream(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                "Content-Type" => $fs->getMimetype($file),
                "Content-Length" => $fs->getSize($file),
                "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
            ]);
        } catch (\Exception $e) {
            return redirect()->route('view.contentitem', $item)->with('downloaderror', trans('portal.download_error'));
        }
    }

    public function delete(ContentItem $contentItem)
    {
        $imageFiles = Storage::disk('spaces')->files('images');
        if (count($imageFiles) > 0) {
            $image = $this->findContentItemFile($imageFiles, $contentItem->id);
            if ($image !== false) {
                Storage::disk('spaces')->delete($image);
            }
        }

        $contentFiles = Storage::disk('spaces')->files('content');
        if (count($contentFiles) > 0) {
            $content = $this->findContentItemFile($contentFiles, $contentItem->id);
            if ($content !== false) {
                Storage::disk('spaces')->delete($content);
            }
        }
    }
    #endregion

    #region SERVICE METHODS

    private function moveToCloudFolderAndReturnPath($tempInputLink, $newFileName, $storage)
    {
        $tempFile = basename($tempInputLink);
        $fileExtension = pathinfo($tempFile, PATHINFO_EXTENSION);
        $newFile = $newFileName . '.' . $fileExtension;

        $fullFilePath = Storage::disk('temp')->
            getDriver()->
            getAdapter()->
            getPathPrefix() . "\\" . $tempFile;

        $file = new File($fullFilePath);

        if ($storage === $this->cloudImageFolder) {
            Storage::disk('spaces')->putFileAs($storage, $file, $newFile, 'public');
            return Storage::disk('spaces')->url($storage . '/' . $newFile);
        } elseif ($storage === $this->cloudContentFolder) {
            Storage::disk('spaces')->putFileAs($storage, $file, $newFile);
            return ['link' => $storage . '/' . $newFile];
        }
    }

    private function removeOldFilesFromCloud($imageFile)
    {
        $contentItemID = pathinfo($imageFile, PATHINFO_FILENAME);

        $contentObject = ContentItem::find($contentItemID);

        if ($contentObject) {
            //removing content files
            $contentFiles = Storage::disk('spaces')->files('content');
            if (count($contentFiles) > 0) {
                $contentFileNames = $this->getCleanNames($contentFiles);
                $foundFileKey = array_search($contentItemID, $contentFileNames);
                if ($foundFileKey !== false) {
                    Storage::disk('spaces')
                        ->delete('/' . $contentFiles[$foundFileKey]);
                }
            }

            //removing image file
            $imageFiles = Storage::disk('spaces')->files('images');
            if (count($imageFiles) > 0) {
                $imageFileNames = $this->getCleanNames($imageFiles);
                $foundFileKey = array_search($contentItemID, $imageFileNames);
                if ($foundFileKey !== false) {
                    Storage::disk('spaces')
                        ->delete($this->cloudImageFolder . '/' . $imageFiles[$foundFileKey]);
                }
            }

        }
    }

    private function recordCloudPathsToDB($imageFile, $contentFile)
    {
        $contentItemID = pathinfo($imageFile, PATHINFO_FILENAME);

        $contentObject = ContentItem::find($contentItemID);

        if ($contentObject) {
            $imageUrl = Storage::disk('spaces')->url('images/' . $imageFile);

            $contentDownloadUrl = 'content/' . $contentFile;

            $contentObject->update([
                'type' => 'cloud',
                'preview' => $imageUrl,
                'download' => ['link' => $contentDownloadUrl]
            ]);
        }
    }

    private function deleteLocalFiles($imageFile, $contentFile)
    {
        Storage::disk('content')->delete($contentFile);
        Storage::disk('images')->delete($imageFile);
    }
    #endregion
}