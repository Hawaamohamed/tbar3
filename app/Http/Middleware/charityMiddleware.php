<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class charityMiddleware
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
        if( auth()->guard("charity" )->check() )
        {
            return $next( $request ) ;
        }
        else
        {
            return redirect( "/login" ) ;
        }

    }
}
