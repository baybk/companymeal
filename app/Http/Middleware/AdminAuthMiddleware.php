<?php

namespace App\Http\Middleware;

use App\Http\Contract\UserBusiness;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    use UserBusiness;
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->isAdminUser()) {
            return $next($request);
        }
        return redirect('/');
    }
}
