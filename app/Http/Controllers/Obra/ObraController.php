<?php

namespace App\Http\Controllers\Obra;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maestro;
use App\Obra;
use DB;
use App\Exports\ExportGeneral;
use Maatwebsite\Excel\Facades\Excel;

class ObraController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function index(){

        $middleRpta = $this->valida_url(10);

        if($middleRpta["status"] != "ok"){

            return $this->redireccion_404();
        }

        $condicion = Maestro::get_combo(82);

    	return view('obra.index',compact('condicion'));
    }

    protected function new_obra(){
    	
    	$monedas = Maestro::get_combo(58);

        $condicion = Maestro::get_combo(82);

        $obra_sp = Obra::get_obra(0);

        $obra = $this->setJson($obra_sp);

    	return view('obra.modals.create',compact('monedas','condicion','obra'));

    }


    protected function edit_obra($id){


        //para la validacion url

        $codigo_obra = Obra::where('IdObra',$id)->first();

        if(is_null($codigo_obra)){

            return $this->redireccion_404();

        }

        //fin validacion

        
    	$monedas = Maestro::get_combo(58);

        $condicion = Maestro::get_combo(82);

        $obra_sp = Obra::get_obra($id);

        $obra = $this->setJson($obra_sp);

    	return view('obra.modals.create',compact('monedas','condicion','obra'));

    }

    protected function salvar_obra(Request $request){

    	
    	DB::beginTransaction();

        try {

            $rpta = Obra::salvar_obra($request);

            if($rpta == 1){

            	DB::commit();
                
                $tipo = ($request->hidden_id_obra ==0 )?'creó':'actualizó';

            	return $this->setRpta("ok","Se $tipo la obra");

            }
            
            DB::rollback();

            return $this->setRpta("error","Ocurrió un error");

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }

    }

    

    protected function get_obras_list(Request $request){

    	$list = Obra::get_obras_list($request);

		return response()->json($list);

    }



    protected function get_obra_documentos(Request $request){

        $list = Obra::get_obra_documentos($request);

        return response()->json($list);
    } 


    protected function load_file_obra_documento(Request $request){

    
        DB::beginTransaction();

        try {

           $rpta = Obra::load_file_obra_documento($request);
            
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

     protected function elimina_documento_obra(Request $request){

        $rpta = Obra::elimina_documento_obra($request);

         if($rpta["status"] == 1){

               
            return $this->setRpta("ok",$rpta["description"]);

        }
        
        return $this->setRpta("error",$rpta["description"]);
    }



    protected function get_obras_combo_autocompletar(Request $request){

        if($request->get('query'))
        {

          $query = $request->get('query');
          
          $data  = Obra::get_obras_combo_autocompletar($query);
          
          $output = '<ul class="dropdown-menu">';
          
          if(count($data)==0){

            $output .= '<li style="list-style:none">no se encontraron resultados</li>';
            
          }else{

            foreach($data as $row)
            {   

                $output .= '<li data-id="'.$row->IdObra.'" data-codobra="'.$row->CodigoObra.'">'.$row->CodigoObra.' - '.$row->Descripcion.'</li>';

            }

          }

          $output .= '</ul>';
          
          echo $output;
        }
    }




    public function export_obras(Request $request){

    
        $list = Obra::get_obras_list($request);

        $excel = $this->set_filas_excel_detalle($list);

        $export = new ExportGeneral([
            
            $excel

         ]); 

      
        return Excel::download($export, 'Todas_Obras_'.date('Y-m').'.xlsx');
    }

    public function set_filas_excel_detalle($list){

        $sub_array =array();

        $i=1;

        $sub_array[0]=array("CODIGO","DESCRIPCION","CLIENTE","BENEFICIARIO","FINANCIERA","LOCALIDAD","MONEDA","MONTO","CONDICION");

        foreach ($list as $value) {
            
            $codigo           = $value->CodigoObra;
            $descripcion      = $value->Descripcion;
            $cliente          = $value->FullNameCliente;
            $beneficiario     = $value->FullNameBeneficiario;
            $financiera       = $value->FullNameFinanciera;
            $localidad        = $value->Localidad;
            $moneda           = $value->CodigoMoneda;
            $monto            = $value->Monto;
            $condicion        = $value->Condicion;


            $sub_array[$i]=array($codigo,$descripcion,$cliente,$beneficiario,$financiera,$localidad,$moneda,$monto,$condicion);

            $i++;
        }

        return $sub_array;

    }
 
}
