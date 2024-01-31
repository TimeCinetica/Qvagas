<?php

namespace App\Http\Controllers\Payslip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\AuthService;
use Illuminate\Support\Facades\DB;

class PaylispWebController extends Controller
{

    public function __construct(
        UserService $userService,
        AuthService $authService
    ) {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    protected $userService;
    public function index()
    {
        return view('paycheck.teste');
    }
    public function show(){
        $user = $this->auth->user();

        if ($user->hasRole('admin')) {
            return view('admin.home', compact('user'));
        } else {
            return view('paycheck.teste', compact('user'));
        };
    }
}
