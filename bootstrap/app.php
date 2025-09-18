<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CourierMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use App\Http\Middleware\CompanyMiddleware;
use App\Http\Middleware\MemberMiddleware;
use App\Http\Middleware\CorsMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => App\Http\Middleware\AdminMiddleware::class,
            'courier' => App\Http\Middleware\CourierMiddleware::class,
            'manager' => App\Http\Middleware\ManagerMiddleware::class,
            'company' => App\Http\Middleware\CompanyMiddleware::class,
            'member' => App\Http\Middleware\MemberMiddleware::class,
            'cors' => App\Http\Middleware\CorsMiddleware::class,
        ]);
        
        // Add CORS middleware globally to API routes
        $middleware->api(prepend: [
            \App\Http\Middleware\CorsMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
