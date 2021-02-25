<?php


namespace App\Http\Controllers\Seguridad; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Rol;
use App\Maestro;

class RolController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
	{
		
        $middleRpta = $this->valida_url(7);

        if($middleRpta["status"] != "ok"){

            return $this->redireccion_404();
        }

        $estados = Maestro::get_combo(1);

		return View('rol.index',compact('estados'));
		
	}	
	

	protected function get_list_roles(Request $request){

		$list = Rol::get_list_roles($request);

		return response()->json($list);
	} 

	
    protected function get_rol_detalle(Request $request){

        $query = Rol::get_rol_detalle($request);

        $options = $this->set_options_menu($query);
        
        $menu_list = Rol::get_list_menu();

        $estados = Maestro::get_combo(1);

        $rol = Rol::where('IdRol',$request->rol)->first();

        $icons = Rol::get_icons_menu();

        return View('rol.modals.create',compact('menu_list','options','estados','rol','icons'))->render();
    }

    protected function set_options_menu($query){

        $list = $this->setJson($query);

        $options = array();

        foreach ($list as $value) {
        
            $options[]=$value['IdMenu'];
        }

        return $options;

    }

	protected function delete_rol(Request $request){


		DB::beginTransaction();

        try {

            $rpta = Rol::delete_rol($request);

            if($rpta == 1){

            	DB::commit();
                
            	return $this->setRpta("ok","Se desactivó el rol");

            }
            
            DB::rollback();

            return $this->setRpta("error","Ocurrió un error");

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }
	}


   



	public function salvar_rol(Request $request){

        
		DB::beginTransaction();

        try {

            $rpta = Rol::salvar_rol($request);
            
                if($rpta == 1){

                    $accion=($request->id_rol == 0)?'creó':'actualizó';

                    DB::commit();

                    return $this->setRpta("ok","Se $accion correctamente");
                }
          
            DB::rollback();

            return $this->setRpta("error","Ocurrió un error");


        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }


	}
   
}

