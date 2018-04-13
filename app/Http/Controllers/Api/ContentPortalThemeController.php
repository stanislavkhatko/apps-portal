<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentPortal;
//use App\Models\ContentItem;
//use Image;
use Storage;

class ContentPortalThemeController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ContentPortal $portal)
    {
        return $portal;
    }

    public function update(Request $request, $id)
    {
        $contentPortal = ContentPortal::find($id);
        $contentPortal->content_portal_theme_id = $request->selectedThemeId;
        $contentPortal->config = json_encode($request->config);
        $contentPortal->custom_css = $request->custom_css;
        $contentPortal->save();

        return response()->json([
            'success' => true,
            'portal' => $contentPortal,
        ]);
    }

    public function uploadHeaderImage(Request $request)
    {
        $path = Storage::put('public/headers', $request->file('file'));
        return substr($path, 7); 
    }

    public function uploadNavbarImage(Request $request)
    {
        $path = Storage::put('public/navbar', $request->file('file'));
        return substr($path, 7); 
    }

    public function uploadContentTypeHeaderImage(Request $request)
    {
        $path = Storage::put('public/content-type/headers', $request->file('file'));
        return response()->json(['success' => true, 'id' => $request->id, 'image' => substr($path, 7)]);
    }

    public function uploadFooterImage(Request $request)
    {
        $path = Storage::put('public/footer', $request->file('file'));
        return substr($path, 7); 
    }
}
