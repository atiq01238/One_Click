<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Get the user's roles
        $userRoles = auth()->user()->getRoleNames();

        // Check if user has necessary roles or permissions
        if (!$userRoles->contains('super-admin')) {
            // Redirect or abort if the user doesn't have the required role or permission
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
