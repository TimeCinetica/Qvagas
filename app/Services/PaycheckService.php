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
        $paycheck = [];

        if (isset($request) && !$returnAll) {
            $query = $this->userQueryFilter($request);
            $paycheck = $query->paginate(10);
        } else {
            $paycheck = $this->paycheck->all();
        }

        return $paycheck;
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
