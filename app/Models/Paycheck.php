<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paycheck extends Model
{
   $paycheck = new Paycheck();
   
   $paychecks = $payhceck->join('users', 'paychecks.user_id', '=', 'users.id');

   // Exibe os resultados do join
   foreach ($paychecks as $paycheck) {
    echo $paycheck->user->name; 
   }

}
