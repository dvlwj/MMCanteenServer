<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class isAdminWeb
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
        if(Auth::user()->role == 'admin'){
            return $next($request);
        }

        return redirect()->route('home');
    }
}
