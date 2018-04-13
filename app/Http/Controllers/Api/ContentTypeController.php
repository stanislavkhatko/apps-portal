<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentType;
use App\Models\Category;

class ContentTypeController extends Controller
{

	public function update(Request $request, $id)
	{
	    $contentType = ContentType::find($id);
	    $contentType->fill($request->contentType);
	    $contentType->save();

	    // $categories = [];
	    // foreach ($request->contentType['categories'] as $category) {
	    //     array_push($categories, new Category($category));
	    // }
	    // $contentType->categories()->delete(); //remove old categories
	    // $contentType->categories()->saveMany($categories); // save new ones

	    return response()->json(['success' => true, 'contentType' => $contentType]);
	}

	public function store(Request $request)
	{   
		$contentType = new ContentType();
	    $contentType->label = $request->contentType['label'];
	    $contentType->provider = 'system';
	    $contentType->remote_id = 0;
	    $contentType->save();

	    // $contentType->save();

	    // $contentType = new ContentType();
	    // $contentType->fill($request->contentType);
	    // $contentType->save();

	    // $categories = [];
	    // foreach ($request->contentType['categories'] as $category) {
	    //     array_push($categories, new Category($category));
	    // }
	    // $contentType->categories()->delete(); //remove old categories
	    // $contentType->categories()->saveMany($categories); // save new ones

	    return response()->json(['success' => true, 'contentType' => $contentType]);
	}
	
    public function searchCategories(Request $request)
    {
        $items = Category::whereRaw('LOWER(label) LIKE ?', '%' . $request->search . '%')->withCount('contentItems')->with('contentType')->limit(14)->get();
        return $items;
    }
}
