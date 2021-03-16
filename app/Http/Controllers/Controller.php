<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Obra;
use App\Cliente;
use App\Rol;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function setRpta($status,$description,$data=NULL){

        return array("status"=>$status,"description"=>$description,"data"=>$data);

    }


    public function msgValidator( $validator )
    {
        $rpta = '';
        foreach( $validator->messages()->all() as $msg )
        {
            $rpta .= $msg." ";
        }
        return substr( $rpta , 0 , -1 );
    }

    public function redireccion_404(){

        return redirect('/pagina_no_encontrada');

    }

     public function setJson($query){

        return json_decode(json_encode($query), true); 

    }

    public function valida_codigo_obra($codigo_obra){

        $obra = Obra::where('CodigoObra',$codigo_obra)->first();

        if(is_null($obra)){

            return $this->setRpta('error','pagina no encontrada');
        }

        return $this->setRpta('ok','existe codigo');
    }

    public function valida_id_cliente($id_cliente){


        $cliente = Cliente::where('IdCliente',$id_cliente)->first();

        if(is_null($cliente)){

            return $this->setRpta('error','pagina no encontrada');
        }

        return $this->setRpta('ok','existe codigo');


    }


    public function valida_url($opcion){

        $permisos = new Rol;

        $string_opciones = $permisos->get_permisos_opciones();
      
        $opciones_permitidas = explode(",",$string_opciones);


        if(!in_array($opcion, $opciones_permitidas)){

           return $this->setRpta('error','pagina no encontrada');
        }

        return $this->setRpta('ok','valido permiso');
        
    }
}
