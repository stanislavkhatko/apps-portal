<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\LocalContentType;
use App\Models\LocalCategory;
use App\Models\Page;
use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\Storage;


class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('view.portal');
//        return Config::get('currentPortal');
    }

    public function viewPortal()
    {
//        return Config::get('currentPortal')->activeFeaturedItems;
        return view('frontend.index', ['portal' => Config::get('currentPortal')]);
    }

    public function showContentType(LocalContentType $localContentType)
    {
        $contentItems = $localContentType->contentItems;

        $contentItems = $this->paginateCollection($contentItems, 20);

        return view('frontend.contentType.index', compact('localContentType', 'contentItems'));
    }

    public function showCategories(LocalContentType $localContentType)
    {
        return view('frontend.categories.index', compact('localContentType'));
    }

    public function showCategory($id, LocalCategory $localCategory)
    {
        return view('frontend.category.index', compact('localCategory'));
    }

    public function showItem(ContentItem $item)
    {
        $itemUrl = Storage::disk('spaces')->temporaryUrl(
            $item->download['link'], now()->addMinutes(5)
        );

        return view('frontend.detail.index', compact('item', 'itemUrl'));
    }

    public function playTrial(ContentItem $item)
    {
        return view('frontend.content-page', compact('item'));
    }

    public function playOnline(ContentItem $item)
    {
        return view('frontend.content-page', compact('item'));
    }

    public function downloadItem(ContentItem $item)
    {
        if (session('subscription')) $item->downloadedBy(session('subscription'));

        if ($item->type == 'upload') {
            try {
                return Storage::disk('spaces')->download($item->download['link']);
            } catch (\Exception $e) {
                return redirect()->route('view.contentitem', $item)->with('downloaderror', trans('portal.download_error'));
            }
        } else {
            return $this->showItem($item);
        }
    }

    public function loadContentType(LocalContentType $contentType)
    {
        return $contentType->contentItems()->paginate(15);
    }

    public function viewPage(Page $page)
    {
        // if static route is fetched directly and language is different, change it
        if ($page->lang_code !== \App::getLocale()) {
            \Session::put('locale', $page->lang_code);
            \App::setLocale($page->lang_code);
        }

        return view('frontend.page', compact('page'));
    }

    public function changeLocale(Request $request)
    {
        \Session::put('locale', $request->input('locale'));

        // if route is a static page, show homepage
        $url = redirect()->back()->getTargetUrl();
        $url_segments = explode('/', $url);
        if ($url_segments[3] == 'page') return redirect()->route('view.portal');

        return redirect()->back();
    }

    public function exit(Request $request)
    {
        $clickid = subscription('remote_tracking_id');
        $exit = 'portal';
        $redirect = 'exit';

        return redirect()->to($redirect);
    }

    public function search(Request $request)
    {
        $search = trim($request->input('search'));

        $items = Config::get('currentPortal')->contentItems->where('title', $search);

        return view('frontend.search.index', compact('items', 'search'));
    }

    private function paginateCollection($items, $per_page)
    {
        $page = \Request::get('page', 1);
        $offset = ($page * $per_page) - $per_page;

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items->forPage($page, $per_page)->values(),
            $items->count(),
            $per_page,
            \Illuminate\Pagination\Paginator::resolveCurrentPage(),
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
    }
}
