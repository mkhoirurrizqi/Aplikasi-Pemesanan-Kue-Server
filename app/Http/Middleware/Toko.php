<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Toko
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth()->user();
        if ($user && $user->tokenCan('Toko'))
            return $next($request);
        else
            return response('', 401);
    }
}
