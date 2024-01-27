<?php

namespace App\Http\Controllers\Payslip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaylispWebController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->get();
         
        foreach ($users as $user) {
            echo $user->name;
        }
       
        return view('paycheck.teste');
    }
}