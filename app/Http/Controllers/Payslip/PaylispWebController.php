<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaylispWebController extends Controller
{
    public function index(){    
        if (! $this->user->can('AcessPaycheck')){

        } else {
        
        }
    }
}
