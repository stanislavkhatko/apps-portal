<?php

namespace App\Http\Controllers\Api;

use App\Models\ContentItem;
use App\Services\Traits\StorageHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ContentItemController extends Controller
{
    use StorageHelper;

    #region MAIN METHODS
    public function update(Request $request, $id)
    {
        $contentItem = ContentItem::find($id);
        $contentItem->fill($request->all());

        // Upload content item
        $download = isset($request->download) ? $request->input('download') : '';
        if (!empty($download['link']) && $request->type !== 'reference' && Storage::disk('temp')->exists(basename($download['link']))) {
            $contentItem->download = ['link' => $this->moveItemToCloud(
                $download['link'],
                $contentItem->id,
                'content-items')];
        }

        // Upload preview image
        if ($request->preview && Storage::disk('temp')->exists(basename($request->preview))) {
            $contentItem->preview = $this->moveItemToCloud(
                $request->preview,
                $contentItem->id,
                'content-item-images');
        }

        $contentItem->save();
        return $contentItem;
    }

    public function store(Request $request)
    {
        $contentItem = new ContentItem();
        $contentItem->fill($request->all());
        $contentItem->save();

        // Upload content item
        $download = isset($request->download) ? $request->input('download') : '';
        if (!empty($download['link']) && $request->type !== 'reference' && Storage::disk('temp')->exists(basename($download['link']))) {
            $contentItem->download = ['link' => $this->moveItemToCloud(
                $download['link'],
                $contentItem->id,
                'content-items')];
        }

        // Upload preview image
        if ($request->preview && Storage::disk('temp')->exists(basename($request->preview))) {
            $contentItem->preview = $this->moveItemToCloud(
                $request->preview,
                $contentItem->id,
                'content-item-images');
        }

        $contentItem->save();
        return $contentItem;
    }

    public function getCategories(Request $request)
    {
        $categories = Category::where('content_type_id', $request->id)->get();
        return $categories;
    }

    public function uploadContentItemImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->hashName('public/temp');
            $image = Image::make($file)->fit(290);
            Storage::put($path, (string)$image->encode());
            return Storage::url($path);
        }
    }

    public function uploadContentItemFile(Request $request)
    {
        if ($request->hasFile('file')) {
            return $request->file('file')->storeAs('public/temp', $request->file('file')->getClientOriginalName());
        }
    }
    #endregion
}
