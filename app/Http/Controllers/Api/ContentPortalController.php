<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentPortal;
use App\Models\ContentItem;
use App\Services\Traits\StorageHelper;
use App\models\Page;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ContentPortalController extends Controller
{
    use StorageHelper;

    public function show(ContentPortal $portal)
    {
        return $portal;
    }


    public function store(Request $request)
    {
        $form = $request->form;

        $form['languages'] = $form['languagesShort']; // e.g. ['en', 'pt']
        $form['domain'] = $form['subdomain'] ? $form['subdomain'] . '.' . $form['host'] : $form['host'];
        $form['localContentTypes'] = array_column($form['localContentTypes'], "value"); // get id's
        $form['default_language'] = $form['default_language']['value'];

        /*** portal ***/
        $cp = new ContentPortal();
        $cp->fill($form);
        $cp->save();


        /*** content types ***/
        $cp->localContentTypes()->sync($form['localContentTypes']);


        /*** featured apps ***/
        $featuredItems = collect();
        foreach ($request->form['featuredApps'] as $featuredItem) {
            $featuredItems->put(
                $featuredItem['content_item_id'],
                [
                    'banner' => $featuredItem['banner'],
                    'visible' => $featuredItem['visible']
                ]
            );
        }
        $cp->featuredItems()->sync($featuredItems);


        /*** content/static pages ***/
        foreach ($request->form['staticPages'] as $page) {
            $cp->pages()->updateOrCreate(['id' => $page['id']], $page);
        }


        /*** pages ***/
        foreach ($request->form['pages'] as $page) {
            $cp->pages()->updateOrCreate(['id' => $page['id']], $page);
        }


        return response()->json(['success' => true, 'portal' => $cp]);
    }


    public function update(Request $request, $id)
    {
        $form = $request->form;

        $form['languages'] = $form['languagesShort']; // e.g. ['en', 'pt']
        $form['domain'] = $form['subdomain'] ? $form['subdomain'] . '.' . $form['host'] : $form['host'];
        $form['localContentTypes'] = array_column($form['localContentTypes'], "value"); // get id's
        $form['default_language'] = $form['default_language']['value'];

        /*** portal ***/
        $cp = ContentPortal::find($id);
        $cp->fill($form);
        $cp->save();


        /*** content types ***/
        $cp->localContentTypes()->sync($form['localContentTypes']);


        /*** featured apps ***/
        $featuredItems = collect();
        foreach ($request->form['featuredApps'] as $featuredItem) {
            $featuredItems->put(
                $featuredItem['content_item_id'],
                [
                    'banner' => $featuredItem['banner'],
                    'visible' => $featuredItem['visible']
                ]
            );
        }
        $cp->featuredItems()->sync($featuredItems);


        /*** delete pages which are not being used anymore ***/
        $pagesIDs = array_merge(array_pluck($request->form['pages'], 'id'), array_pluck($request->form['staticPages'], 'id'));
        $pagesToBeDeleted = Page::where('content_portal_id', $id)->whereNotIn('id', $pagesIDs)->delete();


        /*** content/static pages ***/
        foreach ($request->form['staticPages'] as $page) {
            $cp->pages()->updateOrCreate(['id' => $page['id']], $page);
        }


        /*** pages ***/
        foreach ($request->form['pages'] as $page) {
            $cp->pages()->updateOrCreate(['id' => $page['id']], $page);
        }


        return response()->json(['success' => true, 'portal' => $pagesToBeDeleted]);
    }


    public function searchContentItems(Request $request)
    {
        $items = ContentItem::whereRaw('LOWER(title) LIKE ?', '%' . $request->search . '%')->limit(14)->get();
        return $items;
    }

    public function searchContentItemsFromPortal(Request $request)
    {
        $contentPortal = ContentPortal::find($request->id);
        //
    }


    public function fetchContentItem(Request $request)
    {
        $item = ContentItem::findOrFail($request->id);
        return $item;
    }


    public function uploadFeateredAppBanner(Request $request, $id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->hashName('public/temp');
            $image = Image::make($file)->fit(600, 338, function ($constraint) {
                $constraint->aspectRatio();
            });

            Storage::put($path, (string)$image->encode());

            return Storage::url($this->moveItemToStorage(
                Storage::url($path),
                $request->file('file')->getClientOriginalName(),
                'public/featured-app-banners/' . $id));
        }
    }

    public function fetchPortals()
    {
        return response()->json(['success' => true, 'portals' => ContentPortal::all()]);
    }


    public function fetchContentItems($id)
    {
        $contentPortal = ContentPortal::find($id);

        return response()->json(['success' => true, 'content_items' => $contentPortal->contentItems]);
    }
}
