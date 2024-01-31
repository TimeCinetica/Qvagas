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
    ) {

    }

    protected $userService;
    public function index()
    {
        return view('paycheck.teste');
    }

}
