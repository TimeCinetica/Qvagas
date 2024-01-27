<?php

namespace App\Http\Controllers\Payslip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaylispWebController extends Controller
{
    public function index()
    {
        $paychecks = DB::table('paychecks')
        ->join('users', 'paychecking.user_id', '=', 'users.id');
       
        return view('paycheck.teste');
    }
}