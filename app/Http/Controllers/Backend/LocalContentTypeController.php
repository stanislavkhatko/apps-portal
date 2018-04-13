<?php

namespace App\Http\Controllers\Backend;;

use Illuminate\Http\Request;
use App\Models\LocalContentType;
use App\Models\LocalCategory;
use App\Models\ContentPortal;
use App\Http\Controllers\Controller;

class LocalContentTypeController extends Controller
{

    public function index(Request $request)
    {
        $items = LocalContentType::orderBy('name');
        $portals = ContentPortal::all();

        // Filter on portal
        if ($request->portal) {
            $ids = ContentPortal::find($request->portal)->localContentTypes->pluck('id');
            $items = $items->whereIn('id', $ids);
        }

        // Filter on search
        if ($request->search) {
            $items = $items->whereRaw('LOWER(name) LIKE ?', '%' . $request->search . '%');
        }

        $items = $items->paginate(10);

        return view('backend.localcontenttypes.index', compact('items', 'portals'));
    }

    public function create()
    {
        return view('backend.localcontenttypes.create');
    }

    public function edit($id)
    {
        $localContentType = LocalContentType::find($id);

        $localCategories = [];
        foreach ($localContentType->localCategories as $localCategory) {

            $localCategory['content_type'] = $localCategory->contentType;
            $localCategory['content_items_count'] = $localCategory->contentItems()->count();
            $localCategory['provider_category_label'] = $localCategory->category->label;
            $localCategory['provider_content_items_count'] = $localCategory->category->contentItems()->count();
            $localCategory['provider_category_adult'] = $localCategory->category->adult;

            array_push($localCategories, $localCategory);
        }
        
        $localContentType['local_categories'] = $localCategories;

        return view('backend.localcontenttypes.edit', compact('localContentType'));
    }

    public function destroy($id)
    {   
        $localContentType = LocalContentType::find($id);

        foreach ($localContentType->localCategories as $localCategory) {
            $localCategory->contentItems()->detach();
            $localCategory->delete();
        }

        $localContentType->delete();

        return back();
    }
}
