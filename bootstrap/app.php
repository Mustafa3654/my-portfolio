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
        /*
        | Trust the tunnel/proxy in front of the app.
        |
        | Behind ngrok (or any HTTPS reverse proxy) the request reaches PHP over
        | plain HTTP, so without this Laravel builds every asset and form URL
        | with an http:// scheme. On an HTTPS page the browser then blocks them
        | as mixed content and the site loads unstyled, with Livewire and the
        | Filament panel failing outright.
        |
        | Trusting all proxies is right for a tunnel whose address changes on
        | every restart. Behind a fixed load balancer, list its addresses
        | instead so the forwarded headers cannot be spoofed by a client.
        */
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
