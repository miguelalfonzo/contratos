<?php


namespace App\Http\Controllers\Maestro; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Peru\Sunat\RucFactory;
use App\Ubigeo;

class RucController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    
   
   public function search_ruc(Request $request) 
   {	

   		$ruc = $request->ruc;

   		require '../vendor/autoload.php';

	
		$factory = new RucFactory();
		$cs = $factory->create();

		$company = $cs->get($ruc);

		if (!$company) {

    		return $this->setRpta("error","Error al conectar");
		}

			$company_decode = json_decode(json_encode($company), true);

			$ubigeo = Ubigeo::get_ubigeo_ws($company_decode);

			$company_final = array_merge($company_decode,$ubigeo);

			return $this->setRpta("ok","Consulta Exitosa",$company_final);
			

        
    }


 
    
}