<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Ubigeo extends Model
{   
    protected $table ="ubigeo";
    
    protected static function get_departamentos(){

        $list  = DB::select('call Ubigeo_ComboDepartamento');

        return $list;
    
    }

    protected static function get_provincias($idDepartamento){

        $list  = DB::select('call Ubigeo_ComboProvincia (?)', array($idDepartamento));

        return $list;
    
    }


      protected static function get_ubigeo($query){

        $list  = DB::select('call Ubigeo_FiltroCmb (?)', array($query));

        return $list;
    
    }


    protected static function get_distritos($provincia){

    	$list  = DB::select("call Ubigeo_ComboDistrito (?)",array($provincia));
    	
        $result = array();

        foreach ($list as $value) {

            if($value->DIST != ""){

                $result[]=$value;
            }
        }
         return $result;
    }

    protected static function save_Ubigeo($request){

        $Id_Ubigeo      =   (!is_null($request->id_ubigeo))?$request->id_ubigeo:0;
        $Dpto_Ubigeo    =   (!is_null($request->desc_dpto))?$request->desc_dpto:0;
        $Prov_Ubigeo    =   (!is_null($request->desc_prov))?$request->desc_prov:0;
        $Dist_Ubigeo    =   (!is_null($request->desc_dist))?$request->desc_dist:0;
        $modo           =   $request->modo;
        $tipo           =   $request->tipo;

            if($tipo == 'Insert'){

                $response = DB::insert('call Ubigeo_Insert (?,?,?,?,?)', 
                array($Id_Ubigeo,$Dpto_Ubigeo,$Prov_Ubigeo,$Dist_Ubigeo,$modo));
            }
            else if ($tipo == 'Update'){

                
                $response = DB::update('call Ubigeo_Update (?,?,?,?)', 
                array($Id_Ubigeo,$Prov_Ubigeo,$Dist_Ubigeo,$modo));
            } 

        return $response; 
    }


    public static function get_ubigeo_ws($list){

        $departamento = $list["departamento"];
        $provincia    = $list["provincia"];
        $distrito     = $list["distrito"];
        
       
        if(is_null($departamento) && is_null($provincia) && is_null($distrito) ){

            return array("id_ubigeo"=>"","ubigeo"=>"");

        }else{


            $model = Ubigeo::where([
                    ['DPTO', $departamento],
                    ['PROV', $provincia],
                    ['DIST', $distrito]
                    ])->first();

            
            if(!is_null($model)){

                $ubigeo = $model->DPTO.' '.$model->PROV.' '.$model->DIST;

                $cod_ubigeo = $model->IdUbigeo;

                return array("id_ubigeo"=>$cod_ubigeo,"ubigeo"=>$ubigeo);
            }
            
            return array("id_ubigeo"=>"","ubigeo"=>""); 

        }

       
    }
}
