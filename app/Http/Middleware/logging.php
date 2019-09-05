<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;
use Closure;

class logging
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
        Log::debug($request->method()); // log the http method for the request.
        return $next($request);
    }
    public function terminate($request, $response)
    {
        Log::debug($response->status()); // log the http method for the request.
        
    }
}
