<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
            'role'  => \App\Http\Middleware\EnsureRole::class,
        ]);

        $middleware->redirectUsersTo(function (Request $request) {
            return match ($request->user()?->role) {
                'Admin'         => '/admin/dashboard',
                'Staff'         => '/staff/dashboard',
                'Health Worker' => '/healthworker/dashboard',
                'BHW'           => '/bhw/dashboard',
                'IT'            => '/it/dashboard',
                default         => '/',
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // A stale page (a phone tab left open or restored from the browser's back/forward cache) carries an old
        // security token or a session that has already ended. Pressing Log Out there must simply log the person
        // out, not show a "419 Page Expired" error.
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, Request $request) {
            // A page opened with the wrong account (another role's page from a bookmark, the Back button or a second
            // tab signed in as someone else) used to end on a bare "403 Unauthorized access." Send the person to the
            // login page instead, with a short reason, so they can sign in with the right account.
            // Background (fetch / AJAX / JSON) requests keep their own JSON answer.
            if ($e->getStatusCode() === 403 && !$request->expectsJson() && !$request->ajax()) {
                if (\Illuminate\Support\Facades\Auth::check()) {
                    \Illuminate\Support\Facades\Auth::logout();
                    if ($request->hasSession()) {
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();
                    }
                    return redirect()->route('login')->withErrors([
                        'username' => 'That page is not available for your account. Please sign in with the correct account.',
                    ]);
                }
                return redirect()->route('login');
            }

            // Laravel turns an invalid security token into an HTTP 419 before it reaches this callback
            if ($e->getStatusCode() !== 419 || !$request->routeIs('logout')) {
                return null;   // every other form keeps the normal behaviour
            }
            \Illuminate\Support\Facades\Auth::logout();
            if ($request->hasSession()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
            return redirect()->route('login');
        });

        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*') || ($request->is('admin/*') && $request->expectsJson()),
        );
    })->create();