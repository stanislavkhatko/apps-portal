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
                'content-items/' . $contentItem->id)];
        }

        $contentItem->save();
        return $contentItem;
    }

    public function store(Request $request)
    {
        $contentItem = new ContentItem();
        $contentItem->fill($request->all());
        $contentItem->save();

        $contentItem->save();
        return $contentItem;
    }

    public function getCategories(Request $request)
    {
        $categories = Category::where('content_type_id', $request->id)->get();
        return $categories;
    }

    public function uploadContentItemImage(Request $request, $id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->hashName('public/temp');
            $image = Image::make($file)->fit(290);
            Storage::put($path, (string)$image->encode());

            return Storage::url($this->moveItemToStorage(
                Storage::url($path),
                $request->file('file')->getClientOriginalName(),
                'public/content-item-images/' . $id));
        }
    }

    public function uploadContentItemFile(Request $request, $id)
    {
            return $request->file('file')->storeAs('public/temp', $request->file('file')->getClientOriginalName());
//        if ($request->hasFile('file'))
//            return Storage::url($this->moveItemToStorage(
//                $request->file('file')->store('public/temp'),
//                $request->file('file')->getClientOriginalName(),
//                'public/content-items/' . $id));
    }
    #endregion
}
