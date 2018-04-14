<?php

namespace App\Http\Middleware;

use Closure;

class Subscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::user()) {
            return $next($request);
        }

        if (!session()->has('subscription')) {
            return redirect('/authenticate');
        }
        return $next($request);
    }
}
