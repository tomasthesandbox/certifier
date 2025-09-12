<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockHttpMethods
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowed = ['GET', 'POST', 'PUT', 'DELETE'];

        if (!in_array($request->method(), $allowed))
            return response()->json(['response' => false, 'message'  => 'HTTP method not allowed', 'result'   => null], 405);

        return $next($request);
    }
}
