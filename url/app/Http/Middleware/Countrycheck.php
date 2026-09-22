<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Countrycheck
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    if($request->country != 'pakistan'){
        die('webiste can be use access only in pakistan');
    }
    echo "fuck from country";
    return $next($request);
    }
}
