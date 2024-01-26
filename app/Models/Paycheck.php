<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paycheck extends Model
{
   use HasFactory;

    public function printUserNames()
    {
        $paycheck = new Paycheck();
        $paychecks = $paycheck->join('users', 'paychecks.user_id', '=', 'users.id');
        foreach ($paychecks as $paycheck) {
            echo $paycheck->user->name; 
        }
    }

}
