<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->isAdmin() || Auth::user()->isSadmin()) {
            return $next($request);
        }

        return redirect('login');
    }
}
