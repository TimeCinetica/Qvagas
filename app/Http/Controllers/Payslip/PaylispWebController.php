<?php

namespace App\Http\Controllers\Payslip;

use App\Http\middleware\HasPaycheckAccess;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\PaycheckService;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\AuthService;
use App\Models\User;
use App\Models\Paycheck;

class PaylispWebController extends Controller
{
    protected $PaycheckService;
    protected $userService;


    public function __construct( PaycheckService $PaycheckService ) {
        $this->PaycheckService = $PaycheckService;
    }


    public function index(Request $request){
        $paycheckArmazem = $this->PaycheckService->index($request);
       
        return response()->json($paycheckArmazem, 200);
    }


    public function renderPaycheck(Request $request){

        $paycheckArmazem = $this->PaycheckService->index($request);
        $admin_responsed = $paycheckArmazem[0]->name;
        $users = User::where('admin_responsed', $admin_responsed)->get();

        return view('paycheck.details', [
            'paycheckArmazem' => $paycheckArmazem,
            'users' => $users,
        ]);
    }


    public function renderNewPaycheck(Request $request){

        $paycheckArmazem = $this->PaycheckService->index($request);

        return view('paycheck.newUser', [
            'paycheckArmazem' => $paycheckArmazem,
        ]);
    }


    public function CrenderPaychecks(Request $request, $id){
        $user= User::find($id);
        $paycheckes= DB::table('paycheck')->where('user_id', $id)->get();

        return view('paycheck.User', [
            'user' => $user,
            'paycheckes' => $paycheckes,
        ]);
    }

    public function store(Request $request) {
        $nameUser = $request->get('nameUser');
        Paycheck::create(['nameUser' => $nameUser]);

    }

}
