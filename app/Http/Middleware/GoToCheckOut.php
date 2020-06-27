<?php

namespace App\Http\Middleware;

use App\Basket;
use Closure;
use Illuminate\Support\Facades\Auth;

class GoToCheckOut
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
        $checkBasket = Basket::where('user_id', Auth::id())->get();
        if (count($checkBasket)== 0) {
            return redirect(route('shopPage'));
        }
        return $next($request);

    }
}
