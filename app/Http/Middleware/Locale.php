<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Session;
use App;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $default_lang = Config::get('currentPortal')->default_language;

        // user has a locale saved, set it
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale', $default_lang));
        } 
        else {
            // check language of browser, if it's a language we have, set it
            $browser_lang = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            
            if (in_array($browser_lang, Config::get('currentPortal')->languages)) {
                App::setLocale($browser_lang);
            }
            // default
            else {
                App::setLocale($default_lang);
            }
        }

        return $next($request);
    }
}
