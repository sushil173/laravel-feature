<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd(Auth::user());
        if (Auth::user()) {
            $isAdmin = Auth::user()->isAdmin;
            
            switch ($isAdmin) {
              case 'admin':
                 return redirect('/admin_dashboard');
                 break;
              case 'seller':
                 return redirect('/seller_dashboard');
                 break; 
        
              default:
                 return redirect('/home'); 
                 break;
            }
        }
          return $next($request);

    }
}
