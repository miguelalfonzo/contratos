<?php

namespace App\Http\Controllers\Maestro; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Ubigeo;

class UbigeoController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    
     public function index(){

        $middleRpta = $this->valida_url(8);

        if($middleRpta["status"] != "ok"){

            return $this->redireccion_404();
        }
        
        return View('ubigeo.index');
    } 


    protected function get_departamentos(){

       $departamento = Ubigeo::get_departamentos();

        return response()->json($departamento);
    }


    protected function get_provincias(Request $request){

    	$provincias = Ubigeo::get_provincias($request->departamento);

    	 return response()->json($provincias);
    	

    }

    protected function get_distritos(Request $request){

       $distritos = Ubigeo::get_distritos($request->provincia);

        return response()->json($distritos);
    }
    
     protected function get_ubigeo(Request $request){

       
        if($request->get('query'))
        {

          $query = $request->get('query');
          
          $data  = Ubigeo::get_ubigeo($query);

          $output = '<ul class="dropdown-menu">';
          
          if(count($data)==0){

            $output .= '<li style="list-style:none">no se encontraron resultados</li>';
            
          }else{

            foreach($data as $row)
            {   

                $output .= '<li data-ubigeo="'.$row->IdUbigeo.'">'.$row->fullUbigeo.'</li>';

            }

          }

          $output .= '</ul>';
          
          echo $output;
        }
    }

    
    protected function save_Ubigeo(Request $request){

        $rpta = Ubigeo::save_Ubigeo($request);


        if($rpta){

            $type=($request->tipo=='Insert')?'Creado':'Actualizado';

            return $this->setRpta("ok","$type correctamente.");

        }else{

            return $this->setRpta("error","Ocurrió un error.");
        }
    }

    
}
