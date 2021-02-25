<?php

namespace App\Http\Controllers\Obra;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maestro;
use App\Obra;
use App\Fianza;
use DB;

class FianzaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function gestion_carta_fianza(){

        $middleRpta = $this->valida_url(12);

        if($middleRpta["status"] != "ok"){

            return $this->redireccion_404();
        }


    	$estados = Maestro::get_combo(86);

        $monedas = Maestro::get_combo(58);

        $estados_garantias = Maestro::get_combo(84);

        $bancos  = Maestro::get_combo(89);

        $parametros_generales = Maestro::get_parametros();

        $tipo_cartas = Maestro::get_combo(85);

        $tipo_pagos = Maestro::get_combo(90);

    	return view('fianza.gestion_carta_fianza',compact('estados','monedas','estados_garantias','bancos','parametros_generales','tipo_cartas','tipo_pagos'));
    }

   	
   	protected function get_list_fianzas(Request $request){

    	$list = Fianza::get_list_fianzas($request);

		return response()->json($list);

    }

    protected function get_detalle_carta_fianza_garantia(Request $request){

        $list = Fianza::get_detalle_carta_fianza_garantia($request);

        return response()->json($list);

    }


    protected function get_detalle_carta_fianza(Request $request){

    	$list = Fianza::get_detalle_carta_fianza($request);

		return response()->json($list);

    }

    protected function get_list_garantias_relacionadas(Request $request){

        $list = Fianza::get_list_garantias_relacionadas($request);

        return response()->json($list);

    }
    
     protected function set_datos_renovacion_garantia(Request $request){

        $list = Fianza::set_datos_renovacion_garantia($request);

        return response()->json($list);

    }
    

    protected function get_list_fianzas_relacionadas(Request $request){

        $list = Fianza::get_list_fianzas_relacionadas($request);

        return response()->json($list);

    }
    

     protected function subir_documento_avance_obra(Request $request){

       if ($request->file('file')) {

            $dir      = 'file_avance_obra/';
            $ext      = strtolower($request->file('file')->getClientOriginalExtension()); 
            $fileName = str_random() . '.' . $ext;

            if($request->file('file')->move($dir, $fileName)){

                return $this->setRpta("ok","Se cargó temporalmente el archivo",$fileName);

            }

            return $this->setRpta("error","No se movió el archivo");
            
        }

        return $this->setRpta("error","No se movió el archivo");

    }


    protected function elimina_file_avance_obra(Request $request){

      $file_path = public_path().'/file_avance_obra/'.$request->file;
        

        if (file_exists($file_path)) {

            unlink($file_path);


            return $this->setRpta("ok","Se eliminó el archivo");

                

        } else {
                
            return $this->setRpta("error","El archivo no se encuentra o ya fue eliminado");
                
        }

    }

    protected function subir_documento_gestion_carta_fianza(Request $request){

         DB::beginTransaction();

        try {

           $rpta = Fianza::subir_documento_gestion_carta_fianza($request);
            
                if($rpta[0] == 1){

                    DB::commit();

                    return $this->setRpta("ok","Se subió correctamente el archivo",$rpta[1]);

                }
          
                DB::rollback();

                return $this->setRpta("error","Ocurrió un error");
           

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }

    }

    protected function valida_actualizacion_estado($request){

        if($request->mcf_estado=="VIG"){

            $solicitud = $request->id_mcf_id_solicitud;
            $carta  = $request->tipo_carta_mcf_hidden;
            $id  = $request->id_mcf_hidden;

               
            $query =  DB::select("SELECT COUNT(*) AS TOTAL FROM carta_fianza_detalle WHERE IdSolicitud=? AND TipoCarta=? AND EstadoCF='VIG' ",array($solicitud,$carta));

            $json = json_decode(json_encode($query), true); 

            $total = $json[0]["TOTAL"];

            if($total>0){

        
                $sub_query =  DB::select("SELECT IdCartaFianzaDetalle FROM carta_fianza_detalle WHERE IdSolicitud=? AND TipoCarta=? AND EstadoCF='VIG' ",array($solicitud,$carta));

                $json2 = json_decode(json_encode($sub_query), true); 

                $id_sql = $json2[0]["IdCartaFianzaDetalle"];


                if($id == $id_sql ){

                    return $this->setRpta("ok","valido correctamente");

                }else{

                    return $this->setRpta("error","Para esta Carta ya existe una en estado VIGENTE ");
                }

            }

            return $this->setRpta("ok","valido correctamente");


        }elseif($request->mcf_estado=="CER"){

            return $this->setRpta("error","En esta etapa no se puede cerrar la carta ");

        }else{

            return $this->setRpta("ok","valido correctamente");

        }
       

    }


    protected function save_carta_fianza(Request $request){

    
    	DB::beginTransaction();

        try {

           $middleRpta = $this->valida_actualizacion_estado($request);

           if($middleRpta["status"] == "ok"){

                $rpta = Fianza::save_carta_fianza($request);
            
                if($rpta == 1){

                    DB::commit();

                    return $this->setRpta("ok","Se guardó la carta fianza ");

                }
          
                DB::rollback();

                return $this->setRpta("error","Ocurrió un error");


           }
           
           return $middleRpta;

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }


    }



    protected function elimina_file_gestion_carta_fianza(Request $request){

        DB::beginTransaction();

        try {

           $rpta = Fianza::elimina_file_gestion_carta_fianza($request);
            
                if($rpta["status"] == 1){

                    DB::commit();

                    return $this->setRpta("ok",$rpta["description"]);

                }
          
                DB::rollback();

                return $this->setRpta("error",$rpta["description"]);
           

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }


    }


    protected function renovar_carta_fianza(Request $request){


        DB::beginTransaction();

        try {

           $rpta = Fianza::renovar_carta_fianza($request);
            
                if($rpta == 1){

                    DB::commit();

                    return $this->setRpta("ok","Se renovó la carta fianza");

                }
          
                DB::rollback();

                return $this->setRpta("error","Ocurrió un error");
           

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }
    } 


    
    protected function set_inputs_datos_renovacion(Request $request){

        $list = Fianza::set_inputs_datos_renovacion($request);

        return response()->json($list);

    }

     protected function save_renovacion_garantia(Request $request){


        
        DB::beginTransaction();

        try {

           $rpta = Fianza::save_renovacion_garantia($request);
            
                if($rpta == 1){

                    DB::commit();

                    return $this->setRpta("ok","Se renovó la garantía");

                }
          
                DB::rollback();

                return $this->setRpta("error","Ocurrió un error");
           

        } catch (\Exception $e) {
            
            DB::rollback();

            return $this->setRpta("error",$e->getMessage());
        }
    }



    protected function cerrar_carta_fianza(Request $request){

        $rpta = Fianza::cerrar_carta_fianza($request);

        if($rpta == 1){

            return $this->setRpta("ok","Se cerró la carta fianza");

        }

        return $this->setRpta("error","Ocurrió un error");

    }   

}
