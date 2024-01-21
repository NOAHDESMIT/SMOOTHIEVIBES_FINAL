<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response) $next
     * @param string ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            // Check if the user has any of the specified roles
            $userRoles = auth()->user()->roles ? auth()->user()->roles->pluck('name')->toArray() : [];


            // Allow access if the user has any of the specified roles
            if (count(array_intersect($userRoles, $roles)) > 0) {
                return $next($request);
            }
        }

        // If not authenticated or doesn't have the required role, proceed without aborting
        return $next($request);
    }
}
