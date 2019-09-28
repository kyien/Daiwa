<?php

namespace App\Http\Middleware;

use Closure;

class EnsurePhoneIsVerified
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

        if (!$request->user()->hasVerifiedPhone()) {
            
            return response()->json(['message' => 'phone number not verified'], 400);

        }
        return $next($request);
    }
}
