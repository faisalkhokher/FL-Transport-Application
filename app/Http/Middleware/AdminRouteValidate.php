<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminRouteValidate
{
    public function handle($request, Closure $next)
    {
      if (auth::user()->role_id == 2){
          return redirect('/reader/dashboard');
      }
      return $next($request);
    }
}
