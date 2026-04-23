<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsSubscribed
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth('api')->user()->is_subscribed) {
            return response()->json(['error' => 'Abonnement requis'], 403);
        }

        return $next($request);
    }
}
