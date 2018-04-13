<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\TranslationLoader\LanguageLine;

class TranslationController extends Controller
{
	public function store(Request $request)
	{   

		// delete removed translations
		$translationIDs = array_pluck($request->translations, 'id');
		LanguageLine::whereNotIn('id', $translationIDs)->delete();

		// update or create translations
		foreach ($request->translations as $translation) {
		    LanguageLine::updateOrCreate(['id' => $translation['id']], $translation);
		}

		return response()->json(['success' => true]);
	}    
}
