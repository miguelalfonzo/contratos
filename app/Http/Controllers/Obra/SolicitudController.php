<?php

namespace App\Http\Controllers\Obra;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Obra;
use App\Maestro;
use App\Solicitud;
use DB;

class SolicitudController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function solicitud($id){

        //para la validacion url

        $codigo_obra = Obra::where('IdObra',$id)->first();

        if(is_null($codigo_obra)){

            return $this->redireccion_404();

        }

        //fin validacion


    	$obra_sp = Obra::get_obra($id);

        $obra = $this->setJson($obra_sp);

        $estados = Maestro::get_combo(87);

        $solicitud_sp = Solicitud::get_item($id);

        $solicitud = $this->setJson($solicitud_sp);
      
    	return view('solicitud.create',compact('obra','solicitud','estados'));

    }



    protected function get_solicitud_documentos(Request $request){

        $list = Solicitud::get_solicitud_documentos($request);

        return response()->json($list);
    } 

    

    protected function load_file_solicitud_documento_memoria(Request $request){

      if ($request->file('file')) {

            $dir      = 'files_documentos_solicitud/';
            $ext      = strtolower($request->file('file')->getClientOriginalExtension()); 
            $fileName = str_random() . '.' . $ext;

            if($request->file('file')->move($dir, $fileName)){

                return $this->setRpta("ok","Se cargó temporalmente el archivo",$fileName);

            }

            return $this->setRpta("error","No se movió el archivo");
            
        }

        return $this->setRpta("error","No se movió el archivo");

    } 

    protected function rechazar_solicitud(Request $request){

    
        $rpta = Solicitud::rechazar_solicitud($request);
            
        if($rpta == 1){

            return $this->setRpta("ok","Se rechazó correctamente");

        }
        
        return $this->setRpta("error","Ocurrió un error");
    } 


    protected function load_file_solicitud_documento(Request $request){

    
        DB::beginTransaction();

        try {

           $rpta = Solicitud::load_file_solicitud_documento($request);
            
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

     protected function elimina_documento_solicitud(Request $request){

        $rpta = Solicitud::elimina_documento_solicitud($request);

         if($rpta["status"] == 1){

               
            return $this->setRpta("ok",$rpta["description"]);

        }
        
        return $this->setRpta("error",$rpta["description"]);
    }


    protected function elimina_documento_solicitud_memoria(Request $request){

         $file_path = public_path().'/files_documentos_solicitud/'.$request->file;
        

        if (file_exists($file_path)) {

            unlink($file_path);

            return $this->setRpta("ok","Se eliminó el archivo");
                

        } else {
            
            return $this->setRpta("error","El archivo no se encuentra o ya fue eliminado");
                  
        }
    }


    protected function save_solicitud(Request $request){

    
        DB::beginTransaction();

        try {
           
           $middleRpta = $this->valida_carta_fianza_solicitud($request);

           if($middleRpta["status"]=="ok"){

                $rpta = Solicitud::save_solicitud($request);
            
                if($rpta == 1){

                    DB::commit();

                    $tipo=($request->solicitud_id == 0)?'Creó':'Actualizó';

                    return $this->setRpta("ok","Se $tipo correctamente la solicitud");

                }
          
                DB::rollback();

                return $this->setRpta("error","Ocurrió un error");
           }

           return $this->setRpta("error",$middleRpta["description"]);   
           

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }
    }


    protected function valida_carta_fianza_solicitud($request){

        $solicitud = $request->solicitud_id;

        if($solicitud == 0){

            return $this->setRpta("ok","");

        }else{

            $cumplimiento   = $request->solicitud_cumplimiento;
            $directo        = $request->solicitud_directo;
            $materiales     = $request->solicitud_materiales;

            $garantias  = array(

                          array("CODIGO"=>"FC","DESCRIPTION"=>"Fiel Cumplimiento","MONTO"=>$cumplimiento),
                          array("CODIGO"=>"AD","DESCRIPTION"=>"Adelanto Directo","MONTO"=>$directo),
                          array("CODIGO"=>"AM","DESCRIPTION"=>"Adelanto Materiales","MONTO"=>$materiales)

                          );

            

            

            



            //validacion normal

            $result  = DB::select("SELECT TipoCarta FROM carta_fianza_detalle WHERE IdSolicitud=?",array($solicitud));

        

            $resultArray = json_decode(json_encode($result), true);

            $valores_unicos = array();

            foreach ($resultArray as $key) {
                
                $valores_unicos[]=$key["TipoCarta"];
            }

            $array_unico = array_unique($valores_unicos);



            foreach ($garantias as $list) {
          
                if(!empty($list['MONTO'])){

                    if(in_array($list['CODIGO'], $array_unico)){


                        //verifico si hay cartas anuladas o cerradas de ese tipo

                        $result_anulado  = DB::select("SELECT count(*) as TOTAL FROM carta_fianza_detalle WHERE IdSolicitud=? AND TipoCarta=? AND EstadoCF IN('CER','ANL')",array($solicitud,$list['CODIGO']));

                        $result_anulado_rpta = json_decode(json_encode($result_anulado), true);

                        //en caso exista anulados o cerradas valido las anteriores cartas

                        if($result_anulado_rpta[0]['TOTAL'] > 0){

                            //se quito estado vencido y renovada

                            // en caso existan cartas en proceso o vigentes del mismo tipo
                        
                            $sub_result_anulado  = DB::select("SELECT count(*) as TOTAL2 FROM carta_fianza_detalle WHERE IdSolicitud=? AND TipoCarta=? AND EstadoCF IN('PRO','VIG')",array($solicitud,$list['CODIGO']));


                            $sub_result_anulado_json = json_decode(json_encode($sub_result_anulado), true);

                           if($sub_result_anulado_json[0]['TOTAL2'] > 0){

                                return $this->setRpta("error","La carta ".$list["DESCRIPTION"]." ya se encuentra en proceso  o vigente, finalice la carta para poder registrar nuevamente.");

                           }else{

                                return $this->setRpta("ok","");
                           }
                            
                        }else{

                            return $this->setRpta("error","La carta ".$list["DESCRIPTION"]." ya se encuentra habilitada , finalice la carta para poder registrar nuevamente.");

                        }

                        

                    }
              

                }
          

            }

            return $this->setRpta("ok","");

        }

    }
}
