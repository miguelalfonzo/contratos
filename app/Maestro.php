<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Carbon\Carbon;
class Maestro extends Model
{   
    protected $table="tabla_maestra";


     protected static function parametros(){

        $list  = DB::select('SELECT * FROM parametros WHERE IdParametro=?', array(1));

        return $list;
    
    }


    protected static function get_combo($idTabla){

    	$list  = DB::select('call TablaMaestra_Combo (?)', array($idTabla));

    	return $list;
    
    }

    protected static function get_list_roles($estado){

        $list  = DB::select('call Rol_List (?,?,?,?)', array(1,0,'',$estado));

        return $list;
    
    }

    protected static function get_parametros(){

        $list  = DB::select('call Get_Parametros_Generales (?)', array(1));

        return $list;
    
    }

    protected static function get_list_maestro($request){

    	$estado = $request->state;
    	
        $tabla = $request->id_tabla;

    	$list  = DB::select('call TablaMaestra_List (?,?,?,?)', array($tabla,0,'',$estado));

    	return $list;
    
    }


    protected static function delete_table_maestro($request){

        $id_tabla  = $request->idTabla;

        $id_columna = $request->columna;

        $id_user = Auth::user()->id;

        $rpta  = DB::update('call TablaMaestra_Delete (?,?,?)', array($id_tabla,$id_columna,$id_user));

        return $rpta;
    
    }

    protected static function save_maestro($request){

        $id_user         = Auth::user()->id;
        $det_valor       = (is_null($request->det_valor))?' ':$request->det_valor;
        $det_id_columna  = $request->det_id_columna;
        
        $id_tabla        = $request->id_tabla;
        $descripcion     = $request->descripcion;
        $activo          = $request->flag_activo;
        $modo            = $request->modo;

        $valor_cadena    = $request->valor_cadena;
        
        $valor_numerico  = 0;
        $banco_origen    = 0;
        $banco_list      = null;
        
       
        if($det_id_columna==0 && $modo=='C'){
            //Mantenimiento General
            if($id_tabla==0){


                $response = DB::insert('call TablaMaestra_Insert (?,?,?,?,?,?,?,?,?,?,?)', array($id_tabla,$det_id_columna,$det_valor,$descripcion,$activo,$id_user,$valor_cadena,$valor_numerico,0,'',$descripcion));

            }else{

                $response = DB::update('call TablaMaestra_Update (?,?,?,?,?,?,?,?,?,?,?)', array($id_tabla,$det_id_columna,$det_valor,$descripcion,$activo,$id_user,$valor_cadena,null,$valor_numerico,0,''));
            }
            //Mantenimiento Detalle
        }else if($det_id_columna==0 && $modo=='D'){

            $middleRpta = self::valida_valor_maestro($det_id_columna,$id_tabla,$det_valor);

            if($middleRpta==0){

                

                $response = DB::insert('call TablaMaestra_Insert (?,?,?,?,?,?,?,?,?,?,?)', array($id_tabla,$det_id_columna,$det_valor,$descripcion,$activo,$id_user,$valor_cadena,$valor_numerico,$banco_origen,$banco_list,null));
            }else{

              $response = $middleRpta;
                
            }

            

        }else if($det_id_columna!=0  && $modo=='D'){
            
            $middleRpta = self::valida_valor_maestro($det_id_columna,$id_tabla,$det_valor);

            if($middleRpta == 0){

                $response = DB::update('call TablaMaestra_Update (?,?,?,?,?,?,?,?,?,?,?)', array($id_tabla,$det_id_columna,$det_valor,$descripcion,$activo,$id_user,$valor_cadena,null,$valor_numerico,$banco_origen,$banco_list));

            }else{

                $response = $middleRpta;
            }

            
        }
        
        return $response;
        
        
    }



    protected static function valida_valor_maestro($det_id_columna,$tabla,$valor_det){

        $valida_longitud = self::valida_longitud_valor($tabla,$valor_det);

        if($valida_longitud == 0){

            $valor = '%'.trim($valor_det).'%';

            $query = DB::select("SELECT Valor FROM tabla_maestra WHERE IdTabla=? AND Valor LIKE ?",array($tabla,$valor));
        
            if($det_id_columna==0 && count($query)>0){

                return 2;

            }elseif($det_id_columna!=0 && count($query)>0){

                $valor_json=json_decode(json_encode($query),true);
            
                $query_original = DB::select("SELECT Valor FROM tabla_maestra WHERE IdTabla=? AND IdColumna = ?",array($tabla,$det_id_columna));

                $valor_original =json_decode(json_encode($query_original),true); 

                if(trim($valor_original[0]['Valor'])== trim($valor_json[0]['Valor'])){
                
                    return 0;

                }else{

                    return 2;
                }
            
            }

            return 0;

        }else{

            return $valida_longitud;

        }
        

    }


    protected static function valida_longitud_valor($tabla,$valor_det){

        if($tabla == 58 || $tabla == 1009){

            //moneda
            
            if(strlen($valor_det)>3){

                return 3;

            }else{

                return 0;
            }

        }else if($tabla==17 || $tabla==80){

            //documento - tipo cliente
            
            if(strlen($valor_det)>2){

                return 3;
                
            }else{

                return 0;
            }
            

        }else{

            //otros
            return 0;
            
        }

    }


    
     protected static function actualiza_parametros($request){

        $fiel_cumplimiento   = $request->parametro_fc;
        $adelanto_directo    = $request->parametro_ad;
        $adelanto_materiales = $request->parametro_am;
        $garantia_cheque     = $request->parametro_gc;
        $dias_cobro_cheque   = $request->parametro_dias_cc;
        $id_usuario          = Auth::user()->id;
        $fecha_modificacion  = Carbon::now()->format('Y-m-d H:m:s');

        $rpta  = DB::update('UPDATE parametros SET FielCumplimiento=?,AdelantoDirecto=?,AdelantoMateriales=?,GarantiaCheque=?,DiasCobroCheque=?,IdUsuarioModificacion=?,FechaModificacion=?', array($fiel_cumplimiento,$adelanto_directo,$adelanto_materiales,$garantia_cheque,$dias_cobro_cheque,$id_usuario,$fecha_modificacion));

        return $rpta;
    
    }

}
