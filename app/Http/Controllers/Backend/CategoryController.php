<?php

namespace App\Http\Controllers\Backend;;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ContentType;
use App\Models\ContentItem;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index(Request $request)
    {

        $providers = ContentType::select('provider')->get()->unique('provider');
        $contenttypes = ContentType::orderBy('label');
        $items = Category::orderBy('label');

        // Filter on provider
        if ($request->provider) {
            $provider = $request->provider;

            $contenttypes = $contenttypes->where('provider', $provider);

            $items = $items->whereHas('contentType', function ($q) use($provider) {
                $q->where('provider', $provider);
            });   
        }

        // Filter on contenttype
        if ($request->contenttype) {
            $items = $items->where('content_type_id', $request->contenttype);
        }

        // Filter on search
        if ($request->search) {
            $items = $items->whereRaw('LOWER(label) LIKE ?', '%' . $request->search . '%');
        }

        $contenttypes = $contenttypes->get();
        $items = $items->paginate(10);

        return view('backend.categories.index', compact('items', 'providers', 'contenttypes'));
    }


    public function create()
    {
        return view('backend.categories.create');
    }


    public function edit($category)
    {
        $category = Category::where('id', $category->id)->with('contentType', 'contentItems')->first();
        return view('backend.categories.edit', compact('category'));
    }


    public function destroy($category)
    {
        // remove linked local categories + linked content items for this category
        if ($category->localCategory) {
            $category->localCategory->contentItems()->detach();
            $category->localCategory()->delete();
        }

        // unlink linked content items for this category
        ContentItem::where('category_id', $category->id)->update(['category_id' => 0]);

        // remove the category
        $category->delete();

        return back();
    }


}
