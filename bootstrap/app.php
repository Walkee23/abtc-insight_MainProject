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
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*') || ($request->is('admin/*') && $request->expectsJson()),
        );
    })->create();