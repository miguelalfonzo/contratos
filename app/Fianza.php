<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Auth;
class Fianza extends Model
{   
    
    
    protected static function get_list_fianzas($request){

        $documento  = (!empty($request->documento))?$request->documento:'';

        $cliente  = (!empty($request->cliente))?$request->cliente:0;

        $obra  = (!empty($request->obra))?$request->obra:0;

        $vencimiento = $request->fianza_vencimiento;

     

        $list  = DB::select('call Fianza_Get_List (?,?,?,?)',array($documento,$cliente,$obra,$vencimiento));

        return $list;
    
    }


    protected static function get_detalle_carta_fianza($request){

        $id_fianza_detalle  = $request->idCartaFianza;

        $list  = DB::select('call Carta_Fianza_GetItem (?)',array($id_fianza_detalle));

        return $list;
    
    }

    protected static function get_list_fianzas_relacionadas($request){

        $solicitud   = $request->codigoSolicitud;
        $tipo_carta  = $request->TipoFianza;

        $list  = DB::select('call Get_Fianzas_Renovacion_List (?,?)',array($solicitud,$tipo_carta));

        return $list;
    
    }


    protected static function set_datos_renovacion_garantia($request){

       $id_carta = $request->IdCartaFianza;

       $query =  DB::select("SELECT IdSolicitud,TipoCarta FROM carta_fianza_detalle WHERE IdCartaFianzaDetalle = ? ",array($id_carta));

       $json = json_decode(json_encode($query), true); 

       $IdSolicitud = $json[0]["IdSolicitud"];

       $carta = $json[0]["TipoCarta"];

       $request = new \Illuminate\Http\Request();

       $request->IdSolicitud = $IdSolicitud ;

       $request->TipoFianza = $carta;

       return self::get_list_garantias_relacionadas($request);
    
    }



    protected static function get_list_garantias_relacionadas($request){

        $IdSolicitud   = $request->IdSolicitud;
        $tipo_carta  = $request->TipoFianza;

        $list  = DB::select('call Get_Garantias_Renovacion_List (?,?)',array($IdSolicitud,$tipo_carta));

        return $list;
    
    }


    protected static function set_inputs_datos_renovacion($request){

        $id_fianza_garantia  = $request->IdCartaFianzaGarantia;

        $list  = DB::select('call GetItem_Garantia (?)',array($id_fianza_garantia));

        return $list;
    
    }


     protected static function get_detalle_carta_fianza_garantia($request){

        $carta  = $request->numCarta;

        $list  = DB::select('call Carta_Fianza_Garantia_GetItem (?)',array($carta));

        return $list;
    
    }

    protected static function save_carta_fianza($request){

      

        $moneda  		 = $request->mcf_moneda;
        $estado  		 = $request->mcf_estado;
        $monto   		 = $request->mcf_monto;
        $fecha_creacion  = Carbon::parse($request->mfc_fecha)->format('Y-m-d H:i:s');
        $fecha_inicio 	 = (!empty($request->mfc_fecha_inicio))?Carbon::parse($request->mfc_fecha_inicio)->format('Y-m-d H:i:s'):null;


        $dias  				= $request->mfc_dias;


        $fecha_vencimiento  =  (!empty($request->mfc_vencimiento))?Carbon::createFromFormat('d/m/Y', $request->mfc_vencimiento)->format('Y-m-d H:i:s'):null;
        
        $id_carta           = $request->id_mcf_hidden;

        $id_user            = Auth::user()->id;

        $financiera         = $request->hidden_carta_idfinanciero;

        $comentario         = $request->mfc_observacion;


        $carta_manual      = $request->mfc_carta_manual;

        $num_carta_sql = DB::select("SELECT NumeroCarta FROM carta_fianza_detalle where IdCartaFianzaDetalle=?" ,array($id_carta));

        $numero_carta_json = json_decode(json_encode($num_carta_sql), true); 

        if(!empty($numero_carta_json[0]["NumeroCarta"])){

            $numero_carta = $numero_carta_json[0]["NumeroCarta"];

            //self::update_garantia($request);
            //ya no actualizara ultima garantia
            $new_estado = $estado;


        }else{

            $numero_carta = self::genera_numero_carta();

            $new_estado = ($estado == 'PRO')?'VIG':$estado;

            if($new_estado!='ANL'){
              
              self::inserta_garantia($request,$numero_carta);
            }
             

             

           
        }

        //$new_estado = ($estado == 'PRO')?'VIG':$estado;
        
        
        $rpta  = DB::update('call Carta_Fianza_Update(?,?,?,?,?,?,?,?,?,?,?,?,?)',array($moneda,$new_estado,$monto,$fecha_creacion,$fecha_inicio,$dias,$fecha_vencimiento,$numero_carta,$id_carta,$id_user,$financiera,$comentario,$carta_manual));

        return $rpta;
    
    }



    protected static function genera_numero_carta(){

      DB::select('call Calcula_NumeroCarta (@res)');

      $results = DB::select('select @res as res');

      $rpta = json_decode(json_encode($results), true);

      return $rpta[0]["res"];


   }


   protected static function update_garantia($request){

    $monto_fianza   = $request->mdg_monto_fianza;
    $tipo_garantia  = $request->mdg_tipo_garantia;
    $monto_garantia = $request->mdg_monto_garantia;


    $numero_doc_garantia = $request->mdg_n_tipo_garantia;
    $banco       = $request->mdg_banco;
    $porcentaje  = $request->mdg_porcentaje;
    $moneda      = $request->mdg_moneda;
    $fecha_emision       = Carbon::parse($request->mdg_fecha_emision)->format('Y-m-d H:i:s');

    $fecha_vencimiento   = Carbon::createFromFormat('d/m/Y', $request->mdg_vencimiento)->format('Y-m-d H:i:s');

    $estado          = $request->mdg_estado;
    $observaciones   = $request->mdg_obs;
    $id_user         = Auth::user()->id;
    

    $pre_calculo     = round(($monto_fianza*$porcentaje/100), 2);

    if($pre_calculo == round($monto_garantia, 2)){

      $disponible = null;

    }else{

      $disponible = round($monto_garantia, 2) - $pre_calculo;

    }

    $num_carta = $request->mdg_id_registro_garantia; //el numero de carta se cambio por el id de la ultimna garantia


    $rpta = DB::update("call Carta_Fianza_Garantia_Update (?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($monto_fianza,$tipo_garantia,$monto_garantia,$numero_doc_garantia,$banco,$porcentaje,$moneda,$fecha_emision,$fecha_vencimiento,$estado,$observaciones,$id_user,$num_carta,$disponible));
    

    return $rpta ;


   }



   protected static function inserta_garantia($request,$num_carta){


        $codigo_solicitud  = $request->mcf_solicitud;
        $tipo_carta        = $request->tipo_carta_mcf_hidden;
        $numero_carta      = $num_carta;

        $monto_carta      = $request->mdg_monto_fianza;
        $tipo_garantia    = $request->mdg_tipo_garantia;
        $numero_documento = $request->mdg_n_tipo_garantia;

        $banco           = $request->mdg_banco;
        $porcentaje      = $request->mdg_porcentaje;

        $moneda          = $request->mdg_moneda;
        $monto           = $request->mdg_monto_garantia;

        $fecha_emision       = Carbon::parse($request->mdg_fecha_emision)->format('Y-m-d H:i:s');

        $fecha_vencimiento   = Carbon::createFromFormat('d/m/Y', $request->mdg_vencimiento)->format('Y-m-d H:i:s');
        
        $estado          = $request->mdg_estado;
        $observaciones   = $request->mdg_obs;
        $id_user         = Auth::user()->id;
        

        if(isset($request->disponible)){


          $pre_calculo = round(($monto_carta*$porcentaje/100),2);

          if($pre_calculo == $monto){

              $disponible = null;

          }else{

              $disponible = round($monto,2) - $pre_calculo;
          }

        }else{

          $disponible = null;

        }


        $rpta  = DB::insert('call Carta_Fianza_Garantia_Insert(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',array($codigo_solicitud,$tipo_carta,$numero_carta,$monto_carta,$tipo_garantia,$numero_documento,$banco,$porcentaje,$moneda,$monto,$fecha_emision,$fecha_vencimiento,$estado,$observaciones,$id_user,$disponible));


        return $rpta;

   }

   protected static function elimina_documento_anterior($id_carta){


    $query  = DB::select('SELECT DocumentoElectronico FROM carta_fianza_detalle WHERE IdCartaFianzaDetalle=?', array($id_carta));

    $query_json  = json_decode(json_encode($query),true);

    $old_valor = $query_json[0]['DocumentoElectronico'];

    if(!is_null($old_valor)){

        $file_path = public_path().'/documentos_carta_fianza/'.$old_valor;

        if (file_exists($file_path)) {

            unlink($file_path);

          }

    }

   }
    
   protected static function subir_documento_gestion_carta_fianza($request){

      
      $rpta ='';
      $file ='';


      if ($request->file('file')) {

            $dir      = 'documentos_carta_fianza/';
            $ext      = strtolower($request->file('file')->getClientOriginalExtension()); 
            $fileName = str_random() . '.' . $ext;
            $request->file('file')->move($dir, $fileName);
            $file     = $fileName;

            $id_carta   = $request->id_carta_fianza_documento;
            $id_user    = Auth::user()->id;

            self::elimina_documento_anterior($id_carta);

            $rpta  = DB::update('call Actualiza_Documento_CartaFianza (?,?,?)', array($file,$id_user,$id_carta));

        }
       
        return array($rpta,$file);
        
       
        

   }


   protected static function elimina_file_gestion_carta_fianza($request){

    $file_path = public_path().'/documentos_carta_fianza/'.$request->file;
        

        if (file_exists($file_path)) {

            unlink($file_path);

            $id_user = Auth::user()->id;

            $rpta = DB::update("call DocumentoElectronico_Delete (?,?)", array($request->id_carta,$id_user));

            $description=($rpta==0)?'Ocurrió un error':'Se eliminó correctamente el documento';

            return array("status"=>$rpta,"description"=>$description);

                

        } else {
                
            return array("status"=>0,"description"=>"El archivo no se encuentra o ya fue eliminado");
                
        }
   }

   
   protected static function actualiza_estado_carta($idCarta){

    

    DB::statement("UPDATE carta_fianza_detalle SET EstadoCF='REN',FechaRenovacion=now() WHERE IdCartaFianzaDetalle=?",array($idCarta));


   }

   protected static function get_documento_electronico($idCarta){


    $query  = DB::select("SELECT DocumentoElectronico FROM carta_fianza_detalle WHERE IdCartaFianzaDetalle=?",array($idCarta));

    $json  = json_decode(json_encode($query), true); 

    return $json[0]["DocumentoElectronico"];

   }

   protected static function setea_nuevo_request_garantia($idcarta,$monto){

    $query = DB::select("SELECT * from carta_fianza_garantia WHERE NumeroCarta =(
                         SELECT NumeroCarta FROM carta_fianza_detalle WHERE IdCartaFianzaDetalle=?);",array($idcarta));

    $json  = json_decode(json_encode($query), true);

    $request = new \Illuminate\Http\Request();

    $request->mcf_solicitud = $json[0]["CodigoSolicitud"];

    $request->tipo_carta_mcf_hidden = $json[0]["TipoCarta"];

    $request->mdg_monto_fianza = $monto;

    //$request->mdg_monto_fianza = $json[0]["MontoCarta"];

    $request->mdg_tipo_garantia = $json[0]["TipoGarantia"];

    $request->mdg_n_tipo_garantia = $json[0]["NumeroDocumento"];

    $request->mdg_banco = $json[0]["CodigoBanco"];

    $request->mdg_porcentaje = $json[0]["Porcentaje"];

    $request->mdg_moneda = $json[0]["Moneda"];

    //$request->mdg_monto_garantia = round($monto*$json[0]["Porcentaje"]/100,2);

    $request->mdg_monto_garantia = $json[0]["Monto"];

    $request->mdg_fecha_emision = Carbon::parse($json[0]["FechaEmision"])->format('Y-m-d');


    $request->mdg_vencimiento =Carbon::parse($json[0]["FechaVencimiento"])->format('d/m/Y');


    //$request->mdg_estado  ='REN';

    $request->mdg_estado  ='PND';

    $request->mdg_obs  = 'SE RENOVÓ GARANTIA**';

    $request->disponible ='';

    //actualizamos la garantia anterior
  
    DB::update("UPDATE carta_fianza_garantia  SET Estado ='REN' WHERE NumeroCarta =(
                         SELECT NumeroCarta FROM carta_fianza_detalle WHERE IdCartaFianzaDetalle=?);",array($idcarta));

    return $request;


   }


   protected static function renovar_carta_fianza($request){

     

        $cliente         = $request->mdr_hidden_cliente;
        $benficiario     = $request->mdr_hidden_beneficiario;
        $financiera      = $request->mdr_hidden_financiera;

        $tipo_fianza      = $request->mdr_cmbtipo_fianza;
        $numero_carta_fianza    = $request->mdr_fianza;
        //$codigo_solicitud       = $request->mdr_solicitud;

        $id_solicitud       = $request->mdr_hidden_idSolicitud;

        $moneda     = $request->mdr_cmb_moneda;
        $monto      = $request->mdr_monto;

        $IdCartaFianza      = $request->mdr_hidden_idCartaFianza;

        self::actualiza_estado_carta($IdCartaFianza);

        //$estado          = $request->mdr_estado;
        $estado          = "VIG";
        $fecha           = Carbon::parse($request->mdr_fecha)->format('Y-m-d H:i:s');
        $fecha_incio     = Carbon::parse($request->mdr_fecha_inicio)->format('Y-m-d H:i:s');

        $dias = $request->mdr_dias;

        $fecha_vencimiento   = Carbon::createFromFormat('d/m/Y', $request->mdr_vencimiento)->format('Y-m-d H:i:s');
        
        $renovacion      = $request->mdr_renovacion;
        
        $id_user         = Auth::user()->id;
        
        $comentario      = $request->mdr_observacion;

        $file_avance_obra = $request->file_avance_obra;

        $file_documento   = self::get_documento_electronico($IdCartaFianza);

        //$new_num_carta    = self::genera_numero_carta(); //el numerocarta sera el mismo que el anterior

        $new_num_carta    = $request->mdr_numero_carta;

        $rpta  = DB::insert('call Carta_Fianza_Insert(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',array($tipo_fianza,$fecha,$fecha_incio,$fecha_vencimiento,$moneda,$monto,$estado,$dias,$id_solicitud,$cliente,$financiera,$benficiario,$id_user,$numero_carta_fianza,$comentario,$file_avance_obra,$file_documento,$new_num_carta,$IdCartaFianza));

        //$new_request = self::setea_nuevo_request_garantia($IdCartaFianza,$monto);

        //self::inserta_garantia($new_request,$new_num_carta);

        //al renovar la carta ya no se renueva garantia en automatico
        return $rpta;
   }





    //  protected static function save_renovacion_garantia($request){

        
    //   $id_carta_fianza_garantia = $request->ren_car_gar_idgarantia;
    //   $fecha_garantia      = Carbon::parse($request->ren_car_gar_fecha)->format('Y-m-d H:m:s');
    //   $monto_fianza        = $request->ren_car_gar_monto_fianza;
    //   $fecha_emision       = Carbon::parse($request->ren_car_gar_emision)->format('Y-m-d H:m:s');
    //   $tipo_garantia       = $request->ren_car_gar_tipo_pago;
    //   $numero_documento    = $request->ren_car_gar_numero;
    //   $porcentaje          = $request->ren_car_gar_porcentaje; 
    //   $moneda              = $request->ren_car_gar_moneda;
    //   $fecha_vencimiento   = Carbon::parse($request->ren_car_gar_vencimiento)->format('Y-m-d H:m:s');
    //   $banco               = $request->ren_car_gar_bancos ;
    //   $monto_garantia      = $request->ren_car_gar_monto;
    //   $fecha_cobro         = Carbon::parse($request->ren_car_gar_cobro)->format('Y-m-d');
    //   $estado_garantia     = $request->ren_car_gar_estados_gar;
    //   $disponible          = $request->ren_car_gar_disponible;
      
    //   $liberar             = $request->ren_car_gar_liberar;
      
    //   $observacion         = $request->ren_car_gar_obs;
    //   $id_user             = Auth::user()->id;
      

    //   // if(!empty($liberar)){

    //   //   $monto_garantia = round($monto_garantia-$liberar,2);

    //   // }

      
    //   $rpta = DB::update('call Renovar_Garantia(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',array($id_carta_fianza_garantia,$fecha_garantia,$monto_fianza,$fecha_emision,$tipo_garantia,$numero_documento,$porcentaje,$moneda,$fecha_vencimiento,$banco,$monto_garantia,$fecha_cobro,$estado_garantia,$disponible,$observacion,$id_user));
       
    //    return $rpta ;
    // }


    protected static function save_renovacion_garantia($request){

        $codigo_solicitud = $request->ren_car_gar_codigo_sol;
        $tipo_carta = $request->ren_car_gar_tipo_carta;
        $numero_carta = $request->ren_car_gar_num_ca;
        $fecha = Carbon::now()->format('Y-m-d H:i:s');
        $monto_fianza = $request->ren_car_gar_monto_fianza;
        $tipo_garantia = $request->ren_car_gar_tipo_pago;
        $numero_manual_garantia = $request->ren_car_gar_numero;
        $banco = $request->ren_car_gar_bancos;
        $porcentaje = $request->ren_car_gar_porcentaje;
        $moneda = $request->ren_car_gar_moneda;

        $monto_garantia = $request->ren_car_monto_inicial;//agregado , es el monto inicial

        $monto_requerido = $request->ren_car_gar_monto; // porcentaje*monto_fianza;

        $disponible = $request->ren_car_gar_disponible;

        $emision = (!empty($request->ren_car_gar_emision))?Carbon::parse($request->ren_car_gar_emision)->format('Y-m-d'):null;

        $vencimiento = (!empty($request->ren_car_gar_vencimiento))?Carbon::parse($request->ren_car_gar_vencimiento)->format('Y-m-d'):null;


        $cobro = (!empty($request->ren_car_gar_cobro))?Carbon::parse($request->ren_car_gar_cobro)->format('Y-m-d'):null;
      

        $estado = $request->ren_car_gar_estados_gar;

        $observacion = $request->ren_car_gar_obs;

        if($estado=='LIP'){

          $monto_garantia_final  = $monto_requerido ;

        }else if($estado=='LIT'){

          $monto_garantia_final = 0;

          $disponible = null;

        }else{

          $monto_garantia_final  = $monto_garantia;

        }
        
        $id_user = Auth::user()->id;

        $rpta = DB::insert("INSERT INTO carta_fianza_garantia(CodigoSolicitud,TipoCarta,NumeroCarta,Fecha,MontoCarta,TipoGarantia,NumeroDocumento,CodigoBanco,Porcentaje,Moneda,Monto,Disponible,FechaEmision,FechaVencimiento,FechaCobro,Estado,Observaciones,IdUsuarioCreacion,FechaSistemaCreacion) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now()) ",array($codigo_solicitud,$tipo_carta,$numero_carta,$fecha,$monto_fianza,$tipo_garantia,$numero_manual_garantia,$banco,$porcentaje,$moneda,$monto_garantia_final,$disponible,$emision,$vencimiento,$cobro,$estado,$observacion,$id_user));


        return $rpta ;

      
    }













    protected static function cerrar_carta_fianza($request){

      $id_carta_fianza  = $request->cerrar_cf_idcarta;
      $comentario       = $request->cerrar_cf_comentario;

      //$estado = 'CER';

      $estado = $request->cerrar_estado_carta_fianza;

      
      $id_user = Auth::user()->id;

      $monto = 0;


      $carta_anterior = DB::select("SELECT * FROM carta_fianza_detalle WHERE IdCartaFianzaDetalle=?",array($id_carta_fianza));

      $carta_anterior_json = json_decode(json_encode($carta_anterior), true); 

     $tipo_fianza       = $carta_anterior_json[0]["TipoCarta"] ;
     $fecha             = $carta_anterior_json[0]["FechaCreacion"];
     //$fecha_incio       = $carta_anterior_json[0]["FechaInicio"];
     //$fecha_vencimiento = $carta_anterior_json[0]["FechaVence"];


     $fecha_incio       = null;
     $fecha_vencimiento = null;


     $moneda            = $carta_anterior_json[0]["CodigoMoneda"];
     //$dias              = $carta_anterior_json[0]["Dias"];

     $dias              = null;

     $id_solicitud      = $carta_anterior_json[0]["IdSolicitud"];
     $cliente           = $carta_anterior_json[0]["IdCliente"];
     $financiera        = $carta_anterior_json[0]["IdFinanciera"];
     $benficiario       = $carta_anterior_json[0]["IdBeneficiario"];

     $numero_carta_fianza   = $carta_anterior_json[0]["CodigoCarta"].'-'.$estado;


     $file_avance_obra      = $carta_anterior_json[0]["AvanceObra"];
     $file_documento        = $carta_anterior_json[0]["DocumentoElectronico"];
     
     self::actualiza_estado_carta($id_carta_fianza);

     //$new_num_carta    = self::genera_numero_carta();

     $new_num_carta    = $carta_anterior_json[0]["NumeroCarta"];

      $rpta  = DB::insert('call Carta_Fianza_Insert(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',array($tipo_fianza,$fecha,$fecha_incio,$fecha_vencimiento,$moneda,$monto,$estado,$dias,$id_solicitud,$cliente,$financiera,$benficiario,$id_user,$numero_carta_fianza,$comentario,$file_avance_obra,$file_documento,$new_num_carta,$id_carta_fianza));

      //$new_request = self::setea_nuevo_request_garantia($id_carta_fianza,$monto);

      //self::inserta_garantia($new_request,$new_num_carta);


      return $rpta;

    }


}
