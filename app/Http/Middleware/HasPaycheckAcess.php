<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;

class HasPaycheckAcess
{
     protected $authService;

     public function __construct(AuthService $authService)
     {
         $this->authService = $authService;
     }



    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */




    public function handle(Request $request, Closure $next){
        $authorized = $this->authService->hasPaycheckAcess($request->route('userId'));
        if (!$authorized) {
        return redirect('');
    }

        return $next($request);
    }

}
