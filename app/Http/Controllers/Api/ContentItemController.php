<?php

namespace App\Http\Controllers\Api;

use App\Models\ContentItem;
use App\Services\Facades\CloudUploader;
use App\Services\Facades\ContentLoader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ContentItemController extends Controller
{
    #region MAIN METHODS
    public function update(Request $request, $id)
    {
        $contentItem = ContentItem::find($request->input('contentItem')['id']);
        if($contentItem->type === 'upload'){
            return ContentLoader::update($request, $id);
        }elseif ($contentItem->type === 'cloud'){
            return CloudUploader::update($request, $id);
        }
    }

    public function store(Request $request)
    {
        return ContentLoader::store($request);
    }

    public function getCategories(Request $request)
    {
        $categories = Category::where('content_type_id', $request->id)->get();
        return $categories;
    }

    public function uploadContentItemImage(Request $request)
    {
        if($request->hasFile('file')){
            $file = $request->file('file');

            $path = $file->hashName('public/temp');

            $image = Image::make($file)->fit(240);

            Storage::put($path, (string) $image->encode());

            $url = Storage::url($path);

            return $url;
        }

    }

    public function uploadContentItemFile(Request $request) 
    {
        if($request->hasFile('file')){
            $file = $request->file('file')->store('','temp');
            $ds = DIRECTORY_SEPARATOR;
            return storage_path('app'.$ds.'public'.$ds.'temp'.$ds.$file);
        }
    }
    #endregion
}
