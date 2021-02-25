<?php


namespace App\Http\Controllers\Maestro; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Maestro;
use App\Cliente;
use App\Ubigeo;

class ConsorcioController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    
   
 
    
}

