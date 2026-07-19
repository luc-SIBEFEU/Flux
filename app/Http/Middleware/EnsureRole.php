<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Usage dans les routes : ->middleware('role:admin') ou ->middleware('role:admin,hotelier')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user() || ! in_array($request->user()->role, $roles, true)) {
            abort(403, "Vous n'avez pas accès à cette page.");
        }

        return $next($request);
    }
}
