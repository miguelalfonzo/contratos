<?php


namespace App\Http\Controllers\Maestro; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Maestro;

class MaestroController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
	{   
        $middleRpta = $this->valida_url(3);

        if($middleRpta["status"] != "ok"){

            return $this->redireccion_404();
        }


		$estados = Maestro::get_combo(1);

		return View('maestro.index',compact('estados'));
		
	}	
	

	protected function get_list_maestro(Request $request){

		$list = Maestro::get_list_maestro($request);

		return response()->json($list);
	} 

	
	protected function delete_table_maestro(Request $request){


		DB::beginTransaction();

        try {

            $rpta = Maestro::delete_table_maestro($request);

            if($rpta == 1){

            	DB::commit();
                
            	return $this->setRpta("ok","Se desactivo el registro");

            }
            
            DB::rollback();

            return $this->setRpta("error","Ocurrió un error");

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }
	}


	protected function save_maestro(Request $request){

		DB::beginTransaction();

        try {

           $rpta = Maestro::save_maestro($request);
            
            if($rpta == 1){

            	 $accion=($request->id_tabla==0)?'creo':'actualizó';

            	 DB::commit();

		 		 return $this->setRpta("ok","Se $accion correctamente");

            }

            
            if($rpta == 2){

                $mensaje = 'El valor ya se encuentra registrado';

            }else if($rpta == 3){

                $mensaje = 'El valor pasa la longitud máxima';
                
            }else{

                $mensaje ='Ocurrió un error';
            }
          
            DB::rollback();

            return $this->setRpta("error",$mensaje);

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }


	}


    public function parametros()
    {   

        $middleRpta = $this->valida_url(14);

        if($middleRpta["status"] != "ok"){

            return $this->redireccion_404();
        }

        
        $query = Maestro::parametros();

        $parametros = $this->setJson($query);

        return View('maestro.modals.parametros',compact('parametros'));
        
    }


    protected function actualiza_parametros(Request $request){

     
        $rules = [
                'parametro_fc' => 'required',
                'parametro_ad' => 'required',
                'parametro_am' => 'required',
                'parametro_gc' => 'required',
                'parametro_dias_cc' => 'required'

        ];

        $messages = [

                'parametro_fc.required' => 'El % del Fiel Cumplimiento es obligatorio.',
                'parametro_ad.required' => 'El % del Adelanto Directo es obligatorio.',
                'parametro_am.required' => 'El % del Adelanto Materiales es obligatorio.',
                'parametro_gc.required' => 'El % del Cheque Garantía es obligatorio.',
                'parametro_dias_cc.required' => 'El Número de dias para el cobro del cheque es obligatorio.'
        ];

       $this->validate($request, $rules,$messages);

        $middleRpta = Maestro::actualiza_parametros($request);
        
        if($middleRpta == 1){

            return redirect("/parametros")->with("success","Parámetros actualizados sastisfactoriamente");
        }

        return redirect("/parametros")->with("error","Ocurrió un error");
        
    }   
   
}

