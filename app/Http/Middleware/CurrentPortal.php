<?php

namespace App\Http\Middleware;

use App\Models\ContentPortal;
use Closure;
use Config;
use Theme;

class CurrentPortal
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
        if (config('app.env') == 'local') {
            $portal = ContentPortal::find(2);
        } else {
            $portal = ContentPortal::where('domain', $request->getHost())->first();
            if (! $portal) {
                $portal = ContentPortal::where('host', $request->getHost())->firstOrFail();
            }
        }

        Theme::set($portal->theme->theme_name);
        Config::set('currentPortal', $portal);

        return $next($request);
    }
}
