<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ReaderRouteValidate
{
    public function handle($request, Closure $next)
    {
        if (auth::user()->role_id == 1){
            return redirect('/admin/dashboard');
        }
        return $next($request);
    }
}
