<?php

namespace App\Http\Middleware;

use App\Support\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Checks the Sanctum token and returns our JSON 401 shape (instead of a redirect to /login).
 */
class EnsureApiAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('sanctum')->check()) {
            return ApiResponse::error('Unauthenticated.', 401);
        }

        // Make Sanctum the default guard for this request so $request->user() and Gate use the token user.
        Auth::shouldUse('sanctum');

        return $next($request);
    }
}
