<?php


namespace App\Http\Controllers\Maestro; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Maestro;
use App\Cliente;
use App\Ubigeo;

class ClienteController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
	{      

        $middleRpta = $this->valida_url(4);

        if($middleRpta["status"] != "ok"){

            return $this->redireccion_404();
        }

		$estados = Maestro::get_combo(1);

        $cargos = Maestro::get_combo(1009);

        

		return View('cliente.index',compact('estados','cargos'));
		
	}	
	

	protected function get_list_clientes(Request $request){

		$list = Cliente::get_list_clientes($request);

		return response()->json($list);
	} 


    protected function get_cliente_representantes(Request $request){

        $list = Cliente::get_cliente_representantes($request);

        return response()->json($list);
    } 


     protected function get_cliente_accionistas(Request $request){

        $list = Cliente::get_cliente_accionistas($request);

        return response()->json($list);
    } 
    

     protected function get_cliente_empresas(Request $request){

        $list = Cliente::get_cliente_empresas($request);

        return response()->json($list);
    } 

    
    
     protected function get_combo_empresas(Request $request){

        if($request->get('query'))
        {

          $query = $request->get('query');
          
          if($request->get('tipo') == 'T'){

            $data  = Cliente::get_combo_empresas($query);

          }elseif($request->get('tipo') == 'F'){

            $data  = Cliente::get_combo_empresas_financieras($query);

          }elseif($request->get('tipo') == 'B'){

            $data  = Cliente::get_combo_empresas_beneficiarias($query);

          }else{

            $data  = Cliente::get_combo_empresas($query);
          }
          

          $output = '<ul class="dropdown-menu">';
          
          if(count($data)==0){

            $output .= '<li style="list-style:none">no se encontraron resultados</li>';
            
          }else{

            foreach($data as $row)
            {   

                $output .= '<li data-id="'.$row->IdCliente.'" data-numdoc="'.$row->Identificacion.'">'.$row->Identificacion.' - '.$row->Nombre.'</li>';

            }

          }

          $output .= '</ul>';
          
          echo $output;
        }
    }

    protected function elimina_documento_cliente(Request $request){

        $rpta = Cliente::elimina_documento_cliente($request);

         if($rpta["status"] == 1){

               
            return $this->setRpta("ok",$rpta["description"]);

        }
        
        return $this->setRpta("error",$rpta["description"]);
    } 


    
     protected function get_cliente_documentos(Request $request){

        $list = Cliente::get_cliente_documentos($request);

        return response()->json($list);
    } 

    protected function new_cliente(){

        $cliente = Cliente::get_cliente(0);
       
        $estados = Maestro::get_combo(1);

        $monedas = Maestro::get_combo(58);

        $documentos = Maestro::get_combo(17);

        $tipo_cliente = Maestro::get_combo(80);

        $cliente_contactos = Cliente::get_cliente_contactos(0);

       
        return View('cliente.modals.create',compact('cliente','estados','monedas','documentos','tipo_cliente','cliente_contactos'));
    } 


	protected function cliente($id){


        //para la validacion url

        $existe_cliente = Cliente::where('IdCliente',$id)->first();

        if(is_null($existe_cliente)){

            return $this->redireccion_404();

        }

        //fin validacion


        $cliente = Cliente::get_cliente($id);
       
        $estados = Maestro::get_combo(1);

        $monedas = Maestro::get_combo(58);

        $documentos = Maestro::get_combo(17);

        $tipo_cliente = Maestro::get_combo(80);

        $cliente_contactos = Cliente::get_cliente_contactos($id);

       
        return View('cliente.modals.create',compact('cliente','estados','monedas','documentos','tipo_cliente','cliente_contactos'));
    } 


	protected function delete_cliente(Request $request){


		DB::beginTransaction();

        try {

            $rpta = Cliente::delete_cliente($request);

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


	protected function save_cliente(Request $request){

		DB::beginTransaction();

        try {

           $valida_cliente = $this->valida_cliente($request);
           
           if($valida_cliente["status"] == "ok"){

                $rpta = Cliente::save_cliente($request);
            
                if($rpta == 1){

                    $accion=($request->cliente_id_empresa==0)?'creo':'actualizó';

                    DB::commit();

                    return $this->setRpta("ok","Se $accion correctamente");

                }
          
                DB::rollback();

                return $this->setRpta("error","Ocurrió un error");

           }

           return $valida_cliente;
           

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }


	}
 
    protected function valida_cliente(Request $request){

        $id_cliente = $request->cliente_id_empresa;
        
        $identificacion = $request->cliente_identificacion;

        $num_rows = Cliente::where('Identificacion',trim($identificacion))->get();

        if( $id_cliente == 0 && $num_rows->count()>0){

            return $this->setRpta("error","El número de documento ya existe");

        }else if($id_cliente!=0 && $num_rows->count()>0){

            $cliente = Cliente::where('IdCliente',$id_cliente)->first();
            
            $identificacion_original = $cliente->Identificacion;

            if(trim($identificacion_original) == trim($identificacion)){

                return $this->setRpta("ok","valido número de documento");

            }else{

                return $this->setRpta("error","El número de documento ya existe");
            }

        }

        return $this->setRpta("ok","valido número de documento");
    }  





    protected function salvar_representante(Request $request){

        DB::beginTransaction();

        try {

           $rpta = Cliente::salvar_representante($request);
            
                if($rpta == 1){

                    $accion=($request->id_representante_cliente==0)?'creo':'actualizó';

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

    protected function salvar_accionista(Request $request){

        DB::beginTransaction();

        try {

           $rpta = Cliente::salvar_accionista($request);
            
                if($rpta == 1){

                    $accion=($request->id_accionista_cliente==0)?'creo':'actualizó';

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


     protected function load_file_cliente_documento(Request $request){

    
        DB::beginTransaction();

        try {

           $rpta = Cliente::load_file_cliente_documento($request);
            
                if($rpta == 1){

                    DB::commit();

                    return $this->setRpta("ok","Se subió correctamente el archivo");

                }
          
                DB::rollback();

                return $this->setRpta("error","Ocurrió un error");
           

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }
    } 


    protected function guardar_asociados_empresas(Request $request){

        
       DB::beginTransaction();

        try {

            $asociados  = $request->asociados;
            $cliente_id_consorcio = $request->cliente_id_consorcio;
            $id_cliente = $request->id_cliente;


           if($cliente_id_consorcio!=0){

              Cliente::delete_empresas_consorcio($cliente_id_consorcio);
          
            }


           
            $rpta = Cliente::inserta_nuevas_empresas_consorcio($id_cliente,$asociados);
            
                if($rpta == 1){

                    DB::commit();

                    return $this->setRpta("ok","Se modificó correctamente");

                }
          
                DB::rollback();

                return $this->setRpta("error","Ocurrió un error");
           

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }

    }
}

