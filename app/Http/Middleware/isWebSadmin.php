<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;

class isWebSadmin
{
    protected $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $validatePasswordReseted = null, $redirect = null)
    {
        $authorized = $this->auth->isSadmin();

        if (!$authorized) {
            $url = isset($redirect) ? $redirect : ' login';
            return redirect($url);
        }

        $hasPasswordReseted = $this->auth->hasPasswordReseted();

        $skipValidation = isset($validatePasswordReseted) && !empty($validatePasswordReseted);
        if (!$hasPasswordReseted && !$skipValidation) {
            return redirect('admin/set-password');
        }

        return $next($request);
    }
}
