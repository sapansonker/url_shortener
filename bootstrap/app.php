<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // If not logged in
        $middleware->redirectGuestsTo('/login');

        // If already logged in and opens /login
        $middleware->redirectUsersTo(function (Request $request) {

            $user = $request->user();

            return match ($user->role) {
                'super_admin' => route('superadmin.dashboard'),
                'admin' => route('admin.dashboard'),
                'member' => route('member.dashboard'),
                default => '/',
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
