<?php

use App\Http\Middleware\BlockHttpMethods;
use App\Http\Middleware\SanitizeInput;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append([
            HandleCors::class,
            SanitizeInput::class,
            SecurityHeaders::class,
            BlockHttpMethods::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request) {
            Log::error("Error no controlado", [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->is('api/*'))
                return response()->json(['response' => false, 'message' => 'Ha ocurrido un error inesperado, por favor intente más tarde.', 'result' => null], 500);

            return response()->view('errors.generic', [
                'message' => 'Ha ocurrido un error inesperado, por favor intente más tarde.'
            ], 500);
        });
    })->create();
