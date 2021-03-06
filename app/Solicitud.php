<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Carbon\Carbon;
class Solicitud extends Model
{   
    
	protected $table="carta_fianza";


	protected static function get_solicitud_documentos($request){

      $id_solicitud = $request->id_solicitud;

      $list  = DB::select('call Solicitud_Documento_List (?)', array($id_solicitud));

      return $list;
    
   }

   protected static function get_item($id){

    
      $list  = DB::select('call Solicitud_GetItem (?)', array($id));

      return $list;
    
   }

  
   protected static function load_file_solicitud_documento($request){

      

      if ($request->file('file')) {

            $dir      = 'files_documentos_solicitud/';
            $ext      = strtolower($request->file('file')->getClientOriginalExtension()); 
            $fileName = str_random() . '.' . $ext;
            $request->file('file')->move($dir, $fileName);
            $file     = $fileName;
        }
       

        $id_solicitud_documento   = $request->IdSolicitudDocumento_documento;
        $id_solicitud     = $request->IdSolicitud_documento;
        $valor       = $request->Valor_documento;
        $descripcion = $request->Descripcion_documento;
        $id_user       = Auth::user()->id;


      
        if($id_solicitud_documento=="null"){

          $rpta  = DB::insert('call Solicitud_Documento_Insert (?,?,?,?,?)', array($id_solicitud,$valor,$descripcion,$file,$id_user));

        }else{

          self::elimina_antiguo_documento($id_solicitud_documento);

          $rpta  = DB::update('call Solicitud_Documento_Update (?,?,?)', array($file,$id_user,$id_solicitud_documento));
        }
       
        return $rpta;

   }


   protected static function elimina_documento_solicitud($request){

    $file_path = public_path().'/files_documentos_solicitud/'.$request->file;
        

        if (file_exists($file_path)) {

            unlink($file_path);

            $id_user = Auth::user()->id;

            $rpta = DB::update("call Solicitud_Documento_Delete (?,?)", array($request->IdSolicitudDocumento,$id_user));

            $description=($rpta==0)?'Ocurrió un error':'Se eliminó correctamente';

            return array("status"=>$rpta,"description"=>$description);

                

        } else {
                
            return array("status"=>0,"description"=>"El archivo no se encuentra o ya fue eliminado");
                
        }
   }

   protected static function elimina_antiguo_documento($id_solicitud_documento){

    $query  = DB::select('SELECT Valor FROM carta_fianza_documento WHERE IdSolicitudDocumento=?', array($id_solicitud_documento));

    $query_json  = json_decode(json_encode($query),true);

    $old_valor = $query_json[0]['Valor'];

    if(!is_null($old_valor)){

        $file_path = public_path().'/files_documentos_solicitud/'.$old_valor;

        if (file_exists($file_path)) {

            unlink($file_path);

          }

    }


   }

   protected static function genera_codigo_solicitud(){

      DB::select('call Calcula_CodigoSolicitud (@res)');

      $results = DB::select('select @res as res');

      $rpta = json_decode(json_encode($results), true);

      return $rpta[0]["res"];


   }

  
  protected static function rechazar_solicitud($request){

      $id_obra    = $request->rechaza_solicitud_id;
      $comentario = $request->rechaza_solicitud_form_coment;
      $fecha      = Carbon::now()->format('Y-m-d H:m:s');
      $user       = Auth::user()->id;
      
     $rpta = DB::insert("INSERT INTO solicitudes_rechazadas(IdObra,Comentario,FechaCreacion,IdUsuarioCreacion) VALUES(?,?,?,?)",array($id_obra,$comentario,$fecha,$user));

     return $rpta ;


   }

   protected static function save_solicitud($request){

      $id_solicitud   = $request->solicitud_id;
      $id_obra        = $request->solicitud_id_obra;
      //$estado         = $request->solicitud_estado;
      
      $estado         ="GEN";

      $solicitud_fecha = Carbon::parse($request->solicitud_fecha)->format('Y-m-d H:m:s');


      $cumplimiento   = $request->solicitud_cumplimiento;
      $directo        = $request->solicitud_directo;
      $materiales     = $request->solicitud_materiales;

      $garantias  = array(array("CODIGO"=>"FC","MONTO"=>$cumplimiento),
                          array("CODIGO"=>"AD","MONTO"=>$directo),
                          array("CODIGO"=>"AM","MONTO"=>$materiales));


      $user_creacion  = Auth::user()->id;

      $codigo_solicitud = (empty($request->solicitud_solicitud_key))?self::genera_codigo_solicitud():$request->solicitud_solicitud_key;
      
      $documentos_temporales = $request->documentos;

      if($id_solicitud == 0){

         DB::select('call Solicitud_Insert (?,?,?,?,?,@res)', array($id_obra,$codigo_solicitud,$estado,$solicitud_fecha,$user_creacion));

        $results = DB::select('select @res as res');

        $rpta_cabecera = json_decode(json_encode($results), true);

        $next_id = $rpta_cabecera[0]["res"];
          
        if(!is_null($next_id)){

          $rpta = self::set_sql_detalle_garantias($garantias,$next_id,$request);

        }else{

          $rpta = 0;

        }
        
        
        if($documentos_temporales!="[]"){

            self::inserta_documentos_temporales($documentos_temporales,$next_id);

        }

      }else{

        $rpta = self::set_sql_detalle_garantias($garantias,$id_solicitud,$request);
      }

      return $rpta ;
   }

 
   protected static function set_sql_detalle_garantias($garantias,$nextId,$request){

      $row =' ';

      foreach ($garantias as $list) {
          
          if(!empty($list['MONTO'])){

              $moneda  = $request->solicitud_moneda;
              $estado  = "PRO";
              $user    = Auth::user()->id;
              $hoy     = Carbon::now()->format('Y-m-d H:m:s');
              $cliente     = $request->solicitud_id_cliente;
              $contratante = $request->solicitud_id_beneficiario;
              $financiera  = $request->solicitud_id_financia;
              $solicitud_fecha = Carbon::parse($request->solicitud_fecha)->format('Y-m-d H:m:s');

              $row.="('".$list['CODIGO']."','".$solicitud_fecha."','".$moneda."','".$list['MONTO']."','".$estado."',$nextId,$user,'".$hoy."',$cliente,$contratante,$financiera,0),";

          }
          

      }

      $row = rtrim($row, ',');

      $subquery ="INSERT INTO carta_fianza_detalle(TipoCarta,FechaCreacion,CodigoMoneda,Monto,EstadoCF,IdSolicitud,IdUsuarioCreacion,FechaCreacionSistema,IdCliente,IdBeneficiario,IdFinanciera,FlagGestionCarta) VALUES ".$row;

      $rpta = DB::insert('call Solicitud_Detalle_InsertMasivo (?)', array($subquery));

      return $rpta;
   }


   protected static function inserta_documentos_temporales($list,$nextId){

      $matriz = json_decode($list,true);

      foreach ($matriz as $value) {
          
          $codigo      = $value["codigo"];
          $descripcion = $value["descripcion"];
          $file        = $value["file"];
          $id_user     = Auth::user()->id;


          DB::insert('call Solicitud_Documento_Insert (?,?,?,?,?)', array($nextId,$codigo,$descripcion,$file,$id_user));

      }

   }


   
}
