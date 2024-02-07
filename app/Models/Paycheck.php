<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Paycheck extends Model
{
   use HasFactory;

   protected $table = 'paycheck';
   protected $fillable = ['nameUser', 'paycheckpdf'];

}
