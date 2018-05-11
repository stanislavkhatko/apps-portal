<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentItem;
use App\Models\ContentType;
use App\Models\Category;
use App\Services\Traits\StorageHelper;
use Illuminate\Support\Facades\Storage;


class ContentItemController extends Controller
{
    use StorageHelper;

    public function index(Request $request)
    {




//        $contentItems = ContentItem::where('type', 'upload')->pluck('download', 'id')->toArray();
        $contentItems = ContentItem::all();

        foreach ($contentItems as $item) {
            if($item->preview && Storage::disk('spaces')->exists($item->preview)) {
                $path = explode('/', $item->preview);
                $image = Storage::disk('spaces')->get($item->preview);
                Storage::put('public/' . $path[0] . '/' . $item->id . '/' . $path[1], $image);
                $item->preview = '/storage/'  . $path[0] . '/' . $item->id . '/' . $path[1];
                $item->save();
            }
        }






        return 1;







        DB::connection()->enableQueryLog();

        $providers = ContentItem::select('provider')->get()->unique('provider');
        $contenttypes = ContentType::orderBy('label');
        $categories = Category::orderBy('label');
        $items = ContentItem::with('category');

        // Filter on provider
        if ($request->provider) {
            $provider = $request->provider;

            $contenttypes = $contenttypes->where('provider', $provider);

            $categories = $categories->whereHas('contentType', function ($q) use ($provider) {
                $q->where('provider', $provider);
            });

            $items = $items->whereHas('category', function ($q) use ($provider) {
                $q->whereHas('contentType', function ($q2) use ($provider) {
                    $q2->where('provider', $provider);
                });
            });
        }

        // Filter on contenttype
        if ($request->contenttype) {
            $contentType = $request->contenttype;

            $categories = $categories->whereHas('contentType', function ($q) use ($contentType) {
                $q->where('content_type_id', $contentType);
            });

            $items = $items->whereHas('category', function ($q) use ($contentType) {
                $q->whereHas('contentType', function ($q2) use ($contentType) {
                    $q2->where('id', $contentType);
                });
            });
        }

        // Filter on category
        if ($request->category) {
            $items = $items->where('category_id', $request->category);
        }

        if ($request->category_group) {
            $items = $items->whereIn('category_id', $categories->where('label', $request->category_group)->pluck('id'));
        }

        // Filter on search
        if ($request->search) {
            $items = $items->whereRaw('LOWER(title->"$.en") LIKE \'?\'', '%' . strtolower($request->search) . '%')->orWhere('remote_id', 'LIKE', '%' . $request->search . '%');
        }

        // Set items pagination to 20
        $items = $items->paginate(20);
//        dd(DB::getQueryLog());
        $contenttypes = $contenttypes->get();
        $categories = $categories->get();

        return view('backend.contentitems.index', compact("items", "providers", "contenttypes", "categories"));
    }

    public function create()
    {
        return view('backend.contentitems.create');
    }

    public function edit($id)
    {
        $item = ContentItem::with('category')->find($id);
        return view('backend.contentitems.edit', compact('item'));
    }

    public function destroy($id)
    {
        $contentItem = ContentItem::find($id);

        if ($contentItem->preview) {
            $this->removeItemFromCloud($contentItem->preview);
        }
        if (isset($contentItem->download['link']) && !empty($contentItem->download['link'])) {
            $this->removeItemFromCloud($contentItem->download['link']);
        }

        // if contentItem belongs to a local cat, delete it
        if ($contentItem->localCategory()->first()) {
            $contentItem->localCategory()->first()->contentItems()->detach([$id]);
        }

        $contentItem->delete();
        return back();
    }
}
