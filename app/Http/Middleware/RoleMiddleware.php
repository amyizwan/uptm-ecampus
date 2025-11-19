<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect('/login');
        }

        // Debug: Check what's happening
        \Log::info("User role: {$user->role}, Allowed roles: " . implode(',', $roles));

        
        
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }
}