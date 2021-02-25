<?php


namespace App\Http\Controllers\Seguridad; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\User;
use App\Empresa;
use App\Maestro;
class EmpresaController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
	{

        $middleRpta = $this->valida_url(13);

        if($middleRpta["status"] != "ok"){

            return $this->redireccion_404();
        }

        $empresa = Empresa::where('IdEmpresa',1)->first();

        $estados = Maestro::get_combo(1);


		return View('empresa.index',compact('empresa','estados'));
		
	}	


	protected function actualiza_empresa(Request $request){

     
        $rules = [
                'ruc_compania' => 'required',
                'emp_compania' => 'required',
                'direccion_compania' => 'required',
                'email_compania' => 'email|required'
        ];

        $messages = [

                'ruc_compania.required' => 'El RUC es obligatorio.',
                'emp_compania.required' => 'El nombre de la empresa es obligatoria.',
                'direccion_compania.required' => 'La direccion es obligatoria.',
                'email_compania.required' => 'El correo es obligatorio.',
                'email' => 'El :attribute debe ser un correo válido.'
        ];

       $this->validate($request, $rules,$messages);

        $middleRpta = Empresa::actualiza_empresa($request);
        
        if($middleRpta == 1){

            return redirect("/empresa")->with("success","Empresa actualizada sastisfactoriamente");
        }

        return redirect("/empresa")->with("error","Ocurrió un error");
        
	}
   
}

