<?php


namespace App\Http\Controllers\Seguridad; 

use App\Http\Controllers\Controller;
use App\Http\Controllers\Seguridad\UsuarioController;
use Illuminate\Http\Request;
use DB;
use App\User;
use App\Maestro;

class ProfileController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($id)
	{
		
        $roles = Maestro::get_list_roles(1);

        $usuario = User::find($id);

        if(is_null($usuario)){

            return $this->redireccion_404();
        }
        
		return View('perfil.index',compact('roles','usuario'));
		
	}	


	protected function salvar_perfil(Request $request){

        $rules = [
            'user_nombre' => 'required',
            'ape_pat' => 'required',
            'ape_mat' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->user_id
        ];

        $messages = [

            'user_nombre.required' => 'El nombre es obligatorio.',
            'ape_pat.required' => 'El apellido paterno es obligatorio.',
            'ape_mat.required' => 'El apellido materno es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'required' => 'El :attribute es obligatorio.',
            'unique' => 'El :attribute ya se encuentra registrado.',
            'email' => 'El :attribute debe ser un correo válido.'
        ];

       
        $this->validate($request, $rules,$messages);

        $usuario_controller = new UsuarioController;

        $middleRpta = $usuario_controller->save_user($request);


        if($middleRpta["status"]=="ok"){

            return redirect("/home")->with("success","Perfil actualizado sastisfactoriamente");


        }

        return redirect("/home")->with("error",$middleRpta["description"]);


	}
   
}

