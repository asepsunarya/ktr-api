<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if ($response->status() === 401 && $request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $response;
    }
}
