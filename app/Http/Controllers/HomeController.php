<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\LocalContentType;
use App\Models\LocalCategory;
use App\Models\ContentType;
use App\Models\Category;
use App\Models\Page;
use App\Services\Facades\CloudUploader;
use Illuminate\Http\Request;
use Config;
use Clients\Mobibase\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (session()->has('subscription')) {
        return redirect()->route('view.portal');
        //}
        $portal = Config::get('currentPortal');
        return view('frontend.page', ['page' => $portal->pages->first()]);
    }

    public function viewPortal()
    {
        return view('frontend.index', ['portal' => Config::get('currentPortal')]);
    }

    public function showContentType(LocalContentType $localContentType)
    {
        $contentItems = $localContentType->contentItems;
        //$contentItems = $contentType->contentItems()->paginate(20);

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
        $video = [];
        if ($item->provider == 'mobibase') {
            $client = new Client(config('services.mobibase.api_key'));

            $client->setUserAgent("Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25");
            $service = $client->getVideo($item->remote_id, env('MOBIBASE_TICKET'), 'wifi');

            $video['info'] = $service->response->video; // video object
            $video['stream'] = $service->response->stream; // stream object
        }

        return view('frontend.detail.index', compact('item', 'video'));
    }

    public function showItem2(LocalContentType $localContentType, LocalCategory $localCategory, ContentItem $item)
    {
        $video = $this->returnVideoInfo($item);

        return view('frontend.detail.index', compact('localContentType', 'localCategory', 'item', 'video'));
    }

    public function downloadItem(ContentItem $item)
    {
        if ($item->provider == 'melodimedia') {
            $melodi = app(\DevIT\MelodiMedia\ApiClient::class);

            try {
                $download = $melodi->getDownloadUrlForContentId($item->remote_id, rand(2222222222, 8888888888), '31');
            } catch (\Exception $e) {
                return redirect()->route('view.contentitem', $item)->with('downloaderror', trans('portal.download_error'));
            }

            if ($download['status'] == '200') {
                $item->downloadedBy(session('subscription'));
                return redirect()->to($download['content']);
            } else {
                return redirect()->route('view.contentitem', $item)->with('downloaderror', trans('portal.download_error'));
            }
        } else {
            if ($item->type == 'upload') {
                try {
                    return Storage::disk('spaces')->download($item->download['link']);
                } catch (\Exception $e) {
                    return redirect()->route('view.contentitem', $item)->with('downloaderror', trans('portal.download_error'));
                }
            } else {

                try {
                    return redirect()->away($item->download['link']);
                } catch (\Exception $e) {
                    return redirect()->route('view.contentitem', $item)->with('downloaderror', trans('portal.download_error'));
                }
            }
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

    private function returnVideoInfo(ContentItem $item)
    {
        $video = [];
        if ($item->provider == 'mobibase') {
            $client = new Client(config('services.mobibase.api_key'));
            $client->setUserAgent("Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25");
            $service = $client->getVideo($item->remote_id, env('MOBIBASE_TICKET'), 'wifi');

            $video['info'] = $service->response->video; // video object
            $video['stream'] = $service->response->stream; // stream object
        }

        return $video;
    }
}
