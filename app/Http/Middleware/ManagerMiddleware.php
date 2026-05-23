<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()){
            abort(403, 'Unauthorized');
        }

        if (auth()->user()->role !== 'manager') {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
