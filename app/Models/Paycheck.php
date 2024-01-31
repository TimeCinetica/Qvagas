<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paycheck extends Model
{
   use HasFactory;

   protected $table = 'paycheck';

    public function paycheckJoin()
    {
        $paycheck = DB::table('paycheck')
        ->join('users', 'paycheck.user_id', '=', 'users.id')
        ->get();
    }

}
