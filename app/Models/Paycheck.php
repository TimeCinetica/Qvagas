<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paycheck extends Model
{
   use HasFactory;

    public function paycheckJoin()
    {
        $paychecks = DB::table('paychecks')
        ->join('users', 'paychecking.user_id', '=', 'users.id');
    }

}
