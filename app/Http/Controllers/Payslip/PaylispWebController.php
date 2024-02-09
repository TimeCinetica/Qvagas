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
use Illuminate\Support\Facades\Storage;

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

        foreach ($users as $user) {
            $user->paychecks = Paycheck::where('nameUser', $user->name)->get();
        }

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


    public function CrenderPaychecks(Request $request){
        $id = $this->PaycheckService->index($request)[0]->id;
        $user= User::find($id);
        $paycheckes= DB::table('paycheck')->where('nameUser', $user->name)->get();

        return view('paycheck.User', [
            'user' => $user,
            'paycheckes' => $paycheckes,
        ]);
    }

    public function store(Request $request) {

        $nameUser = $request->get('nameUser');
        $date = $request->month_year;

        if($request->hasFile('paycheckpdf')){
            $file = $request->file('paycheckpdf');
            $path = Storage::putFile('public/paychecks', $file);
            Paycheck::create(['nameUser' => $nameUser, 'paycheckpdf' => $path, 'month_year' => $date]);

        }
    }

    public function serve ($filename) {
        $path = storage_path('app/public/' . $filename);

        if (!Storage::exists($path)) {
            abort(404);
        }

        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        return (new Response($file, 200))
              ->header("Content-Type", $type);
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        $nameUser = $request->get('nameUser');
        $month_year = $request->get('month_year');

        if ($request->hasFile('paycheckpdf')) {
            $file = $request->file('paycheckpdf');
            $path = Storage::putFile('public/paychecks', $file);

            $paycheck = Paycheck::find($id);

            if (!$paycheck) {
                return response()->json(['error' => 'Contracheque não encontrado'], 404);
            }

            $paycheck->update(['nameUser' => $nameUser, 'paycheckpdf' => $path, 'month_year' => $month_year]);

            return response()->json(['message' => 'Contracheque atualizado com sucesso']);
        } else {
            return response()->json(['error' => 'Nenhum arquivo PDF fornecido'], 400);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        $paycheck = Paycheck::find($id);

        $paycheck->delete();

        return response()->json(['message' => 'Contracheque excluído com sucesso']);
    }
}
