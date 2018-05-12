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
    }



}