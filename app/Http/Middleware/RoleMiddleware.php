<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::guard('sanctum')->user();
        
        // return response()->json(['message' => $role], 403);


        if ($user && $user->role === $role) {
            return $next($request);
        }

        return response()->json(['message' => 'Access Denied'], 403);
    }
}
