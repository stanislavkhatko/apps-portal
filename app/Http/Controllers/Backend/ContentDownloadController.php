<?php

namespace App\Http\Controllers\Backend;;

use Illuminate\Http\Request;
use App\Models\ContentDownload;
use App\Http\Controllers\Controller;

class ContentDownloadController extends Controller
{
    public function index(Request $request)
    {
        $items = ContentDownload::orderBy('created_at', 'DESC');

        // Filter on search
        if ($request->search) {
            $items = $items->whereRaw('LOWER(item) LIKE ?', '%'.$request->search.'%')->orWhere('msisdn', 'LIKE', '%'.$request->search.'%')->orWhere('subscription_id', 'LIKE', '%'.$request->search.'%');
        }

        $items = $items->with('contentItem')->paginate(20);
        return view('backend.contentdownloads.index', compact('items'));
    }


    public function show($id)
    {

    }


    public function destroy($id)
    {

    }
}
