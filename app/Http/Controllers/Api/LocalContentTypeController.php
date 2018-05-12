<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentType;
use App\Models\LocalContentType;
use App\Models\Category;
use App\Models\LocalCategory;
use Image;
use App\Services\Traits\StorageHelper;
use Illuminate\Support\Facades\Storage;

class LocalContentTypeController extends Controller
{
    use StorageHelper;

    public function update(Request $request, $id)
    {
        // save local content type
        $localContentType = LocalContentType::find($id);
        $localContentType->fill($request->all());

        $localContentType->save();

        // get local cats which were marked for deletion
        $localCatIDs = array_pluck($request->local_categories, 'id');
        $deletedLocalCats = LocalCategory::where('local_content_type_id', $id)->whereNotIn('id', $localCatIDs)->get();

        // delete local cats and detach their items
        foreach ($deletedLocalCats as $deletedLocalCat) {
            $deletedLocalCat->contentItems()->detach();
            $deletedLocalCat->delete();
        }

        foreach ($request->local_categories as $local_category) {

            // update/create the local categories
            $localCategory = $localContentType->localCategories()->updateOrCreate(['id' => $local_category['id']], $local_category);

            // sync contenitems if new category is added
            if ($local_category['id'] == 0) {
                // get contentitems of the provider categories and sync them to the local categories        
                $contentItemsIDs = Category::find($local_category['provider_category_id'])->contentItems->pluck('id');

                // syncie_wyncie
                $localCategory->contentItems()->sync($contentItemsIDs);
            }
        }

        return $localContentType;
    }


    public function store(Request $request)
    {
        // save local content type
        $localContentType = new LocalContentType();
        $localContentType->fill($request->all());

        $localContentType->save();

        foreach ($request->local_categories as $local_category) {

            // update/create the local categories
            $localCategory = $localContentType->localCategories()->updateOrCreate(['id' => $local_category['id']], $local_category);
            // get contentitems of the provider categories and sync them to the local categories        
            $contentItemsIDs = Category::find($local_category['provider_category_id'])->contentItems->pluck('id');
            // syncie_wyncie
            $localCategory->contentItems()->sync($contentItemsIDs);
        }

        return $localContentType;
    }


    public function syncContentItems(Request $request)
    {
        LocalCategory::find($request->categoryId)->contentItems()->sync($request->contentItems);

        return response()->json(['success' => true]);
    }


    public function searchCategories(Request $request)
    {
        $provider = strtolower($request->provider);

        if ($provider == 'system') {
            $items = Category::where('remote_id', 0);
        } else {
            $items = Category::where('remote_id', '>', 0);
        }

        $items = $items->whereRaw('LOWER(label) LIKE ?', '%' . $request->search . '%')->withCount('contentItems')->with('contentType')->limit(14)->get();

        return $items;
    }


    public function searchContentTypes(Request $request)
    {
        $provider = strtolower($request->provider);

        $items = ContentType::where('provider', $provider)->whereRaw('LOWER(label) LIKE ?', '%' . $request->search . '%')
            ->with([
                'categories' => function ($query) {
                    $query->with('contentType')->withCount('contentItems');
                },

            ])->limit(14)->get();

        return $items;
    }


    public function getContentItemsFromLocalCategoryAndCategory(Request $request)
    {
        $localCategoryItems = LocalCategory::find($request->localID)->contentItems;

        // get all items which are not in use by local cateogry items
        $categoryItems = Category::find($request->providerID)->contentItems()->whereNotIn('id', $localCategoryItems->pluck('id'))->get();

        return response()->json(['success' => true, 'localCategoryItems' => $localCategoryItems, 'categoryItems' => $categoryItems]);
    }

    public function uploadIcon(Request $request, $id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->hashName('public/temp');
            $image = Image::make($file)->fit(40);
            Storage::put($path, (string)$image->encode());

            return Storage::url($this->moveItemToStorage(
                Storage::url($path),
                $request->file('file')->getClientOriginalName(),
                'public/local-content-type-images/' . $id));
        }
    }
}
