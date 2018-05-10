<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentPortal;
use App\Services\Traits\StorageHelper;
use Storage;

class ContentPortalThemeController extends Controller
{
    use StorageHelper;

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

    public function uploadHeaderImage(Request $request, $id)
    {
        if($request->hasFile('file'))
            return Storage::url($this->moveItemToStorage($request->file('file')->store('public/temp'), $request->file('file')->getClientOriginalName(), 'public/header-images/' . $id));
    }

    public function uploadNavbarImage(Request $request, $id)
    {
//        if ($request->hasFile('file')) {
//            $path = $request->file('file')->store('public/temp');
//            return Storage::disk('spaces')->url($this->moveItemToCloud($path, $id, 'navbar-images'));
//        }

        if($request->hasFile('file'))
            return Storage::url($this->moveItemToStorage(
                $request->file('file')->store('public/temp'),
                $request->file('file')->getClientOriginalName(),
                'public/navbar-images/' . $id));
    }

    public function uploadContentTypeHeaderImage(Request $request)
    {
        $path = Storage::put('public/content-type/headers', $request->file('file'));
        return response()->json(['success' => true, 'id' => $request->id, 'image' => substr($path, 7)]);
    }

    public function uploadFooterImage(Request $request, $id)
    {
//        if ($request->hasFile('file')) {
//            $path = $request->file('file')->store('public/temp');
//            return Storage::disk('spaces')->url($this->moveItemToCloud($path, $id, 'footer-images'));
//        }
        if($request->hasFile('file'))
            return Storage::url($this->moveItemToStorage(
                $request->file('file')->store('public/temp'),
                $request->file('file')->getClientOriginalName(),
                'public/footer-images/' . $id));
    }
}
