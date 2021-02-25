<?php


namespace App\Http\Controllers\Seguridad; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\User;
use App\Maestro;

class UsuarioController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
	{
		
        $middleRpta = $this->valida_url(6);

        if($middleRpta["status"] != "ok"){

            return $this->redireccion_404();
        }


        $estados = Maestro::get_combo(1);

		return View('usuario.index',compact('roles','estados'));
		
	}	
	

	protected function get_list_user(Request $request){

		$list = User::get_list_user($request);

		return response()->json($list);
	} 

	
    protected function get_user_detalle(Request $request){

        $roles = Maestro::get_list_roles(1);

        $estados = Maestro::get_combo(1);

        $query = User::get_user_detalle($request);

        $list = $this->setJson($query);

        return View('usuario.modals.create',compact('list','roles','estados'))->render();
    }


	protected function delete_user(Request $request){


		DB::beginTransaction();

        try {

            $rpta = User::delete_user($request);

            if($rpta == 1){

            	DB::commit();
                
            	return $this->setRpta("ok","Se desactivó el registro");

            }
            
            DB::rollback();

            return $this->setRpta("error","Ocurrió un error");

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }
	}


    protected function reset_contrasena_usuario(Request $request){

        DB::beginTransaction();

        try {
            
            $rpta = User::reset_contrasena_usuario($request);
        
            if($rpta){
                
                DB::commit();
                return $this->setRpta("ok","Se generó la contraseña correctamente");
        
            }

                DB::rollback();
                return $this->setRpta("error","Ocurrió un error");

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());

        }
        

    }


    protected function valida_usuario($request){
         
        $messages = [

            'unique' => 'El :attribute ya se encuentra registrado.',
        ];

        $rules = [
            
           'email'=> 'unique:users,email,'.$request->user_id,
           'email_contacto'=> 'unique:users,EmailContacto,'.$request->user_id
        ];

         $validate = \Validator::make($request->all(),$rules,$messages);

         if ($validate->fails())
         {   
            return $this->setRpta("error",$this->msgValidator($validate));

         }
        
        return $this->setRpta("ok","valido");


    }
	public function save_user(Request $request){

        
		DB::beginTransaction();

        try {

           $middleRpta = $this->valida_usuario($request);

           if($middleRpta["status"] == "ok"){

                $rpta = User::save_user($request);
            
                if($rpta["status"] == 1){

                    DB::commit();

                    return $this->setRpta("ok",$rpta["description"]);
                }
          
                DB::rollback();

                return $this->setRpta("error",$rpta["description"]);


           }
           
           return $this->setRpta("error",$middleRpta["description"]);


        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }


	}
   
}

