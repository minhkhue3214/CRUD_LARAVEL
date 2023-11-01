<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenrole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$userType): Response
    {
        $guard = ($userType === 'admin') ? 'admin' : 'web';

        if (Auth::guard($guard)->check()) {
            return $next($request);
        }
        
        Session::flush();
        Auth::logout();
        $errorMessage = 'Bạn không có quyền truy cập trang này';
        
        if ($userType === 'admin') {
            return redirect()->route('user.login')->withErrors(['error' => $errorMessage]);
        } else {
            return redirect()->route('admin.login')->withErrors(['error' => $errorMessage]);
        }
    }
}
