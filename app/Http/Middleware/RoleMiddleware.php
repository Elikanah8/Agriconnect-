<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        // Check if the user's role matches the required role
        if (auth()->user()->role !== $role) {
            // AVOID REDIRECTING TO A ROUTE THAT USES THIS SAME MIDDLEWARE
            // This abort(403) breaks the infinite loop immediately
            abort(403, 'Unauthorized. Your role is: ' . auth()->user()->role);
        }

        return $next($request);
    }
}