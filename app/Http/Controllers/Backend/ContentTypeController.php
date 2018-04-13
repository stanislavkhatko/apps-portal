<?php

namespace App\Http\Controllers\Backend;;

use Illuminate\Http\Request;
use App\Models\ContentType;
use App\Models\Category;
use App\Http\Controllers\Controller;

class ContentTypeController extends Controller
{
    public function index(Request $request)
    {

        $providers = ContentType::select('provider')->get()->unique('provider');
        $items = ContentType::orderBy('label');

        // Filter on provider
        if ($request->provider) {
            $items = $items->where('provider', $request->provider);
        }

        // Filter on search
        if ($request->search) {
            $items = $items->whereRaw('LOWER(label) LIKE ?', '%' . $request->search . '%');
        }

        $items = $items->withCount(['categories', 'contentItems'])->paginate(10);
        
        return view('backend.contenttypes.index', compact('items', 'providers'));
    }

    public function create()
    {
        return view('backend.contenttypes.create');
    }

    public function edit($id)
    {
        // $contentType = ContentType::where('id', $id)
        // ->with([
        //     'categories' => function ($query) {
        //         $query->with('contentType')->withCount('contentItems');
        //     }]
        // )->first();
        $contentType = ContentType::find($id);
        return view('backend.contenttypes.edit', compact('contentType'));
    }
    
    public function destroy($id)
    {   
        // unlink linked content items for this category
        Category::where('content_type_id', $id)->update(['content_type_id' => 0]);

        // remove the content type
        ContentType::find($id)->delete();

        return back();
    }
}
