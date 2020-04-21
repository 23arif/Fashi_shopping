<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
//use Session;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->get('locale')) {
            $lang = session()->get('locale');
            App::setLocale($lang);
        }
        return $next($request);
    }
}
