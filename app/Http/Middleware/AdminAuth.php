<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    const GUARD_ADMIN = 'admin';
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard(self::GUARD_ADMIN)->check()) {
            return $next($request);
        }
    
        return abort(401);
    }
}
