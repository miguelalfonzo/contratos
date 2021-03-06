<?php


namespace App\Http\Controllers\Maestro; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Peru\Sunat\RucFactory;
use App\Ubigeo;
use App\Cliente;

class RucController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    
   
   public function search_ruc(Request $request) 
   {	

   		$ruc = $request->ruc;

   		$cliente = Cliente::where('Identificacion',$ruc)->first();

   		

   		if(!is_null($cliente)){

   			$full_ubigeo = '';

   			if(!empty($cliente->Ubigeo)){

   				$ubigeo = Ubigeo::where('IdUbigeo',$cliente->Ubigeo)->first();

   				$full_ubigeo = $ubigeo->DPTO.' '.$ubigeo->PROV.' '.$ubigeo->DIST;
   			}

   			$company_final = array( "razonSocial"=>$cliente->RazonSocial,
   									"nombreComercial"=>$cliente->Nombre,
   									"actEconomicas"=>array("bd-bd-".$cliente->Ocupacion),
   									"direccion"=>$cliente->Direccion,
   								    "ubigeo"=>$full_ubigeo,
   									"id_ubigeo"=>$cliente->Ubigeo);

   			return $this->setRpta("ok","Consulta Exitosa desde la BD",$company_final);

   		}else{

   			

   			require '../vendor/autoload.php';

	
			$factory = new RucFactory();
			$cs = $factory->create();

			$company = $cs->get($ruc);

			if (!$company) {

    			return $this->setRpta("error","No se encontraron registros");
			}

			$company_decode = json_decode(json_encode($company), true);

			$ubigeo = Ubigeo::get_ubigeo_ws($company_decode);

			$company_final = array_merge($company_decode,$ubigeo);

			return $this->setRpta("ok","Consulta Exitosa",$company_final);

   		}
   		
        
    }


 
    
}