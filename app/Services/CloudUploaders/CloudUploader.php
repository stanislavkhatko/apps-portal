<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 4/3/2018
 * Time: 10:32 AM
 */

namespace App\Services\CloudUploaders;


use App\Models\ContentItem;
use Illuminate\Http\Request;

abstract class CloudUploader
{
    abstract public function upload();

    abstract public function update(Request $request, $id);

    abstract public function download(ContentItem $contentItem);

    abstract public function delete(ContentItem $contentItem);
}