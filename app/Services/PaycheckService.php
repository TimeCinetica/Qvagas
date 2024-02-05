<?php

namespace App\Services;

use App\Models\Paycheck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PaycheckService
{
    protected $users;
    protected $paycheck;
    public function __construct(User $users, Paycheck $paycheck){
        $this->users = $users;
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
}
