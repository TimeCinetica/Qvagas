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
    public function __construct( PaycheckService $PaycheckService ) {
        $this->PaycheckService = $PaycheckService;
    }
    public function index(Request $request)
    {
        $paycheckArmazem = $this->PaycheckService->index($request);
        return response()->json($paycheckArmazem, 200);
    }
    public function renderPaycheck(Request $request){

        $paycheckArmazem = $this->PaycheckService->index($request);
        return view('teste.blade', [
            'paycheckArmazem' -> $paycheckArmazem,
        ]);
    }


}
