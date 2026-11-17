<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards every /admin/* route: only a logged-in Admin gets through.
 *
 *  - Not logged in (never signed in, or the session expired): pages redirect to the login page and come
 *    back to the same URL after signing in; background requests (fetch / AJAX) get a JSON 401.
 *  - Logged in as another role: 403, as JSON for background requests.
 */
class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($this->wantsJson($request)) {
                return response()->json([
                    'message'   => 'Your session has expired. Reload this page and log in again.',
                    'login_url' => route('login'),
                ], 401);
            }
            return redirect()->guest(route('login'));
        }

        if (Auth::user()->role !== 'Admin') {
            if ($this->wantsJson($request)) {
                return response()->json(['message' => 'This area is for Admin accounts only.'], 403);
            }
            abort(403, 'This area is for Admin accounts only.');
        }

        return $next($request);
    }

    private function wantsJson(Request $request): bool
    {
        return $request->expectsJson() || $request->ajax();
    }
}
