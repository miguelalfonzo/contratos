<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Carbon\Carbon;
class Obra extends Model
{   
    protected $table='obra';

   
    protected static function get_obra($id){


    	$list  = DB::select('call Obra_GetItem (?)', array($id));

    	return $list;
    }

    
    protected static function get_obras_list($request){

      $proceso    = $request->proceso ;
      $condicion  = $request->condicion ;
      $id_cliente = (!empty($request->id_cliente))?$request->id_cliente:0 ;
      $id_obra    = (!empty($request->id_obra))?$request->id_obra:0 ;
      
      $inicio = (!empty($request->inicio))?Carbon::parse($request->inicio)->format('Y-m-d'):date('Y-01-01') ;

      $fin = (!empty($request->fin))?Carbon::parse($request->fin)->format('Y-m-d'):date('Y-m-d') ;

      
    	$list  = DB::select('call Obra_List (?,?,?,?,?,?)', array($proceso,$condicion,$id_cliente,$id_obra,$inicio,$fin));

    	return $list;
    }

    protected static function get_obras_combo_autocompletar($query){


      $list  = DB::select('call Obra_Combo_Autocompletar (?)', array($query));

      return $list;
    }

    protected static function get_obra_documentos($request){

      $IdObra = $request->IdObra;

      $list  = DB::select('call Obra_Documento_List (?)', array($IdObra));

      return $list;
    
   }


   protected static function load_file_obra_documento($request){

      

      if ($request->file('file')) {

            $dir      = 'files_documentos_obra/';
            $ext      = strtolower($request->file('file')->getClientOriginalExtension()); 
            $fileName = str_random() . '.' . $ext;
            $request->file('file')->move($dir, $fileName);
            $file     = $fileName;
        }
       

        $id_obra_documento   = $request->IdObraDocumento_documento;
        $id_obra     = $request->IdObra_documento;
        $valor       = $request->Valor_documento_obra;
        $descripcion = $request->Descripcion_documento_obra;
        $id_user       = Auth::user()->id;

        $comentario = $request->Comentario_documento_obra;

      
        if($id_obra_documento=="null"){

          $rpta  = DB::insert('call Obra_Documento_Insert (?,?,?,?,?,?)', array($id_obra,$valor,$descripcion,$file,$id_user,$comentario));

        }else{

          self::elimina_antiguo_documento($id_obra_documento);

          $rpta  = DB::update('call Obra_Documento_Update (?,?,?,?)', array($file,$id_user,$id_obra_documento,$comentario));
        }
       
        return $rpta;

   }


   protected static function elimina_documento_obra($request){

    $file_path = public_path().'/files_documentos_obra/'.$request->file;
        

        if (file_exists($file_path)) {

            unlink($file_path);

            $id_user = Auth::user()->id;

            $rpta = DB::update("call Obra_Documento_Delete (?,?)", array($request->IdObraDocumento,$id_user));

            $description=($rpta==0)?'Ocurrió un error':'Se eliminó correctamente';

            return array("status"=>$rpta,"description"=>$description);

                

        } else {
                
            return array("status"=>0,"description"=>"El archivo no se encuentra o ya fue eliminado");
                
        }
   }

   protected static function elimina_antiguo_documento($id_obra_documento){

    $query  = DB::select('SELECT Valor FROM obra_documento WHERE IdObraDocumento=?', array($id_obra_documento));

    $query_json  = json_decode(json_encode($query),true);

    $old_valor = $query_json[0]['Valor'];

    if(!is_null($old_valor)){

        $file_path = public_path().'/files_documentos_obra/'.$old_valor;

        if (file_exists($file_path)) {

            unlink($file_path);

          }

    }


   }

   



    protected static function salvar_obra($request){

      $id_obra     = $request->hidden_id_obra;
      $obra_codigo = $request->obra_codigo;
      $obra_nombre = $request->obra_nombre;
      $hidden_obra_idubigeo  = $request->hidden_obra_idubigeo;
      $hidden_obra_idcliente = $request->hidden_obra_idcliente;
      $hidden_obra_idcontratante = $request->hidden_obra_idcontratante;
      $hidden_obra_idfinanciero  = $request->hidden_obra_idfinanciero;
      $obra_descripcion          = $request->obra_descripcion;

      $obra_ingreso  = Carbon::parse($request->obra_ingreso)->format('Y-m-d H:i:s');
      $obra_moneda   = $request->obra_moneda;
      $obra_monto    = $request->obra_monto;
      $obra_inicio   = Carbon::parse($request->obra_inicio)->format('Y-m-d H:i:s');
      $obra_dias     = $request->obra_dias;
      $obra_fin      = Carbon::createFromFormat('d/m/Y', $request->obra_fin)->format('Y-m-d H:i:s');
      $obra_condicion = $request->obra_condicion;
      $user_creacion  = Auth::user()->id;

      $localidad = '';



      if(!empty($hidden_obra_idubigeo)){

          $full_ubigeo  = $request->obra_ubigeo;

          $ubigeo_array = explode(" ", $full_ubigeo);

          $localidad = $ubigeo_array[0];

      }

      if($id_obra == 0){

        $rpta  = DB::insert('call Obra_Insert (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array($obra_nombre,$obra_descripcion,$hidden_obra_idcliente,$hidden_obra_idubigeo,$obra_monto,$hidden_obra_idcontratante,$obra_ingreso,$obra_inicio,$obra_dias,$obra_fin,$obra_moneda,$localidad,$hidden_obra_idfinanciero,$obra_condicion,$user_creacion));

      }else{

      	$rpta  = DB::update('call Obra_Update (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array($obra_nombre,$obra_descripcion,$hidden_obra_idcliente,$hidden_obra_idubigeo,$obra_monto,$hidden_obra_idcontratante,$hidden_obra_idfinanciero,$obra_ingreso,$obra_inicio,$obra_dias,$obra_fin,$obra_moneda,$localidad,$obra_condicion,$user_creacion,$id_obra));
        
      }

      return $rpta ;

    	
    }


}
