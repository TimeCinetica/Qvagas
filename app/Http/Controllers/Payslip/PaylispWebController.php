<?php

namespace App\Http\Controllers\Payslip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaylispWebController extends Controller
{
    public function index()
    {

        return view('paycheck.teste');
    }
}
