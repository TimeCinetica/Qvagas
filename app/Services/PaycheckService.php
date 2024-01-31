<?php

namespace App\Services;

use App\Models\Paycheck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PaycheckService
{
    protected $users;
    protected $paychecks;
    public function __construct(User $users, Paycheck $paychecks){
        $this->users = $users;
        $this->paychecks = $paychecks;
    }


}
