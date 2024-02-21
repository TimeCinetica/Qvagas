<?php

namespace App\Http\Controllers\Payslip;

use App\Http\middleware\HasPaycheckAccess;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\PaycheckService;
use Illuminate\Http\Request;
use App\Http\Requests\Collaborator\StoreCollaboratorRequest;
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

        $policies = $this->getPolicies();
        $paycheckArmazem = $this->PaycheckService->index($request);
        $admin_responsed = $paycheckArmazem[0]->name;
        $admins_list = $this->PaycheckService->indexAdminResponsed($request);
        $users = User::where('admin_responsed', $admin_responsed)->get();

        foreach ($users as $user) {
            $user->paychecks = Paycheck::where('nameUser', $user->name)->get();
        }

        return view('paycheck.details', [
            'policies' => $policies,
            'paycheckArmazem' => $paycheckArmazem,
            'users' => $users,
            'admins_list' => $admins_list,
        ]);
    }


    public function renderNewPaycheck(Request $request){

        $paycheckArmazem = $this->PaycheckService->index($request);
        $admin_responsed = $paycheckArmazem[0]->name;

        return view('paycheck.newUser', [
            'paycheckArmazem' => $admin_responsed,
        ]);
    }

    public function newCollaborator(StoreCollaboratorRequest $request) {
        $collaborator = $this->PaycheckService->newCollaborator($request);
        return response()->json($collaborator, 201);
    }


    public function renderPaycheckCollaborator(Request $request, $id){
        //$id = $this->PaycheckService->index($request)[0]->id;
        $user= User::find($id);
        $paycheck= DB::table('paycheck')->where('nameUser', $user->name)->get();
        
        // Organize seus contracheques por ano
        $paychecksByYear = $paycheck->groupBy('year');

        foreach ($paychecksByYear as $year => $paychecks) {
            $paychecksByYear[$year] = $paychecks->sortBy(function ($paycheck) {
                return substr($paycheck->month_year, 0, 2); // Extrai o número do mês de month_year
            });
        }
        
        return view('paycheck.User', [
            'user' => $user,
            'paycheck' => $paycheck,
            'paychecksByYear' => $paychecksByYear,
        ]);
    }
    
    

    public function store(Request $request) {

        $nameUser = $request->get('nameUser');
        $date = $request->month_year;
    
        // Cria um objeto DateTime a partir da data fornecida
        $dateObject = \DateTime::createFromFormat('m/Y', $date);
    
        if ($dateObject instanceof \DateTime) {
            // Extrai o nome do mês e o ano da data
            $monthName = strftime('%B', $dateObject->getTimestamp());
            $year = $dateObject->format('Y');
        } else {
            // Manipula o erro como achar melhor
            $monthName = 'Data inválida';
            $year = 'Data inválida';
        }
    
        if($request->hasFile('paycheckpdf')){
            $file = $request->file('paycheckpdf');
            $path = Storage::putFile('public/paychecks', $file);
            Paycheck::create([
                'nameUser' => $nameUser, 
                'paycheckpdf' => $path, 
                'month_year' => $date,
                'month_name' => $monthName,  // Adiciona o nome do mês
                'year' => $year  // Adiciona o ano
            ]);
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

    private function getPolicies()
    {
        return (object) [
            'details' => false,
            'edit'    => false,
            'delete'  => true,
        ];
    }
}
