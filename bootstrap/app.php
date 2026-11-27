<?php

if (!function_exists('mb_split')) {
    function mb_split(string $pattern, string $string, int $limit = -1): array|false {
        return @preg_split('/' . str_replace('/', '\/', $pattern) . '/u', $string, $limit);
    }
}

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\DomainLockMiddleware::class,
        ]);
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'super_admin.auth' => \App\Http\Middleware\SuperAdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
