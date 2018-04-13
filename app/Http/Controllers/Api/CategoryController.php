<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentType;
use App\Models\Category;

class CategoryController extends Controller
{

	public function update(Request $request, $id)
	{
	    $category = Category::find($id);
	    $category->fill($request->category);
	    $category->save();

	    return response()->json(['success' => true, 'category' => $category]);
	}

	public function store(Request $request)
	{   
		$category = new Category();
	    $category->fill($request->category);
	    $category->save();

	    return response()->json(['success' => true, 'category' => $category]);
	}
    
}
