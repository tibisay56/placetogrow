<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

/**
 * Determine if a custom error page should be rendered.
 *
 * @return bool
 */
if (! function_exists('shouldRenderCustomErrorPage')) {
    function shouldRenderCustomErrorPage()
    {
        if (app()->environment(['local', 'testing'])) {
            return true;
        }

        if (config('app.custom_error_pages_enabled')) {
            return true;
        }

        return false;
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            App\Http\Middleware\TranslationsMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response) {
            if (shouldRenderCustomErrorPage() && in_array($response->getStatusCode(), [403, 404, 500])) {
                return Inertia::render('Error', [
                    'status' => $response->getStatusCode(),
                ]);
            }

            return $response;
        });
    })
    ->create();
