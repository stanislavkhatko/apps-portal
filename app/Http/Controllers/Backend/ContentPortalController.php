<?php

namespace App\Http\Controllers\Backend;

use App\Models\ContentPortal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentPortalController extends Controller
{

    public function index()
    {
        $portals = ContentPortal::all();
        
        return view('backend.contentportal.index', compact('portals'));
    }


    public function create()
    {
        return view('backend.contentportal.create');
    }


    public function edit(ContentPortal $contentPortal)
    {
        return view('backend.contentportal.edit', compact('contentPortal'));
    }


    public function destroy(ContentPortal $contentPortal)
    {
        // remove local content types
        if ($contentPortal->localContentTypes()->first()) {
            $contentPortal->localContentTypes()->detach();
        }

        // remove featured items
        if ($contentPortal->featuredItems()->first()) {
            $contentPortal->featuredItems()->detach();
        }

        // remove pages
        if ($contentPortal->pages()->first()) {
            $contentPortal->pages()->delete();
        }

        // remove portal
        $contentPortal->delete();

        return back();
    }
}
