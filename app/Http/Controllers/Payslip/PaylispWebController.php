<?php
//CONTROLLER DO PAYCHECK OU FOLHA DE PAGAMENTO

namespace App\Http\Controllers\Payslip;

use App\Http\middleware\HasPaycheckAccess;
use App\Http\Controllers\Controller;
use App\Services\PaycheckService;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\AuthService;

class PaylispWebController extends Controller
{
    protected $PaycheckService;
    protected $userService;
    public function __construct( UserService $userService, PaycheckService $PaycheckService ) {
        $this->userService = $userService;
        $this->PaycheckService = $PaycheckService;
    }
    public function index(Request $request)
    {
        $paycheckArmazem = $this->PaycheckService->index($request);
        return response()->json($paycheckArmazem, 200);
    }
    public function renderPaycheck(Request $request, $userId){

        $user = $this->userService->getById($userId);
        $paycheckArmazem = $this->PaycheckService->index($request);
        return view('paycheck.teste', [
            'paycheckArmazem' => $paycheckArmazem,
        ]);
    }

    public function renderPaychecks(Request $request){
        $policies = $this->getPaycheckPolicies();
        $paychecks = $this->PaycheckService->index($request);
        return view('admin.paycheck', ['paycheck' => $paychecks, 'policies' => $policies]);
    }

    private function getPaycheckPolicies()
    {
        $isSadmin = auth()->user()->isSadmin();
        return (object) [
            'details' => true,
            'edit'    => false,
            'delete'  => $isSadmin
        ];
    }


}
