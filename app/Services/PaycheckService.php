<?php

namespace App\Services;

use App\Models\Paycheck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PaycheckService
{
    protected $user;
    protected $paycheck;
    protected $utilsService;



    public function __construct(User $user, Paycheck $paycheck, UtilsService $utilsService){
        $this->utilsService = $utilsService;
        $this->user = $user;
        $this->paycheck = $paycheck;
    }

    public function index($request = null, $returnAll = false)
    {
        // Realize a consulta ao banco de dados
        $results = User::where('id', $request->user()->id)->get();

        // Retorne os resultados
        return $results;
    }
    private function userQueryFilter($request)
    {
        $query = $this->paycheck->query();

        if (isset($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if (isset($request->orderby)) {
            $orderParams = explode("-", $request->orderby);
            $query->orderBy($orderParams[0], $orderParams[1]);
        }

        return $query;
    }

    /**
     * Cria novo colaborador
     * 
     * @param StoreCollaboratorRequest $request
     * @return User $admin
     */
    public function newCollaborator($request) {
        $cpf = preg_replace('/[^0-9]/', '', $request->cpf);
        $this->utilsService->validateCpf($cpf);

        // Fill required fields for users table
        $request->merge([
            'cpf'           => $cpf,
            'created_at'    => now(),
            'updated_at'    => now(),
            'birthDate'     => empty($request->date) ? now() : $request->date,
            'cellphone'     => empty($request->tel) ? $cpf : $request->tel,
            'schooling'     => 'sadmin',
            'cep'           => '29111111',
            'address'       => 'admin',
            'number'        => '123',
            'district'      => 'sadmin',
            'city'          => 'sadmin',
            'sex'           => 3,
            'rg'            => 'sadmin',
            'mother'        => 'sadmin',
            'civil'         => 0,
            'volunteerWork' => 1,
            'hasChildren'   => 0,
            'availableTravel' => 1,
            'admin_responsed' => $request->admin_responsed,
            'job'           => $request->job,
        ]);

        $collaborator = null;
        DB::transaction(function () use ($request, &$collaborator) {
            $collaborator = $this->user->create($request->all());
            //aqui está a linha para descomentar futuramente (aqui manda a mensagem de email)
            //$this->notificationService->sendResetPassordEmail($admin);
        });

        return $collaborator;
    }
}
