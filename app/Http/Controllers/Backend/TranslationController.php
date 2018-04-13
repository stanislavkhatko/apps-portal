<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\TranslationLoader\LanguageLine;

class TranslationController extends Controller
{

    public function index(Request $request)
    {
        $items = LanguageLine::all();
        
        return view('backend.translations.edit', compact('items'));
    }
}
