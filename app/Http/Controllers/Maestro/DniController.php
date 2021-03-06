<?php


namespace App\Http\Controllers\Maestro; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Peru\Jne\DniFactory;


class DniController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    
   
   public function search_dni(Request $request) 
   {	

   		$dni = $request->dni;

   		require '../vendor/autoload.php';
		
		  $factory = new DniFactory();

		  $cs = $factory->create();

		  $person = $cs->get($dni);

		  if (!$person) {
    		
    		  return $this->setRpta("error","No se encontraron registros");
		  }

		
			return $this->setRpta("ok","Consulta Exitosa",$person);	

        
    }


 
    
}