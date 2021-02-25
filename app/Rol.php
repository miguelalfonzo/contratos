<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Rol extends Model
{   
    protected $table='rol';

    

    protected static function get_list_roles($request){

        $estado = $request->state;

    	$list  = DB::select('call Rol_List (?,?,?,?)', array(1,0,'',$estado));

    	return $list;
    
    }

    

    protected static function get_list_menu(){

        $list  = DB::select('call  Menu_List');

        return $list;
    
    }


    protected static function get_rol_detalle($request){

        $rol = $request->rol;

        $list  = DB::select('call RolMenu_List (?,?)', array(1,$rol));

        return $list;
    
    }


    protected static function delete_rol($request){

    	$rol = $request->rol;

        $id_user = Auth::user()->id;

    	$rpta  = DB::update('call  Rol_Delete(?,?,?)', array(1,$rol,$id_user));

    	return $rpta;
    
    }


    protected static function get_icons_menu(){

        $icons = array("fa fa-cog","fa fa-lock","fa fa-edit","fa fa-sort-amount-asc");

        return $icons;
    
    }

  

    protected static function salvar_rol($request){

        $id_user   = Auth::user()->id;
             
        if($request->id_rol==0){

            $rpta  = DB::insert('call Rol_Insert (?,?,?,?,?,?)', array(1,$request->id_rol,$request->descripcion,$request->cobertura,$request->estado,$id_user));

        }else{

            $rpta  = DB::update('call Rol_Update (?,?,?,?,?,?)', array(1,$request->id_rol,$request->descripcion,$request->cobertura,$request->estado,$id_user ));
        }
        

        if(!is_null($request->opciones)){

            if( $rpta == 1 ){

                $rol = new Rol ;

                $last_id = Rol::get()->last()->IdRol;

                $id_rol = ($request->id_rol==0)?$last_id:$request->id_rol;

                $subquery = $rol->set_values_options($request->opciones,$id_rol);

                if($request->id_rol!=0){

                       
                    $rpta  = DB::delete('call RolMenu_Delete (?,?)', array(1,$id_rol)); 
                }
                    

                $rpta =  DB::insert('call RolMenu_InsertMasivo (?)', array($subquery));
            }

        }

        return $rpta ;

    }


    protected function set_values_options($matriz,$rol){

        $row =' ';

        foreach ($matriz as $list) {
            
            $row.="(1,$rol,".$list['value']."),";

        }
        $row = rtrim($row, ',');

        $subquery ="INSERT INTO Rol_Menu VALUES ".$row;

        return $subquery ;
    }


    public static function get_permisos_opciones(){

        $id_user= Auth::user()->id;

        $list = DB::select("SELECT rm.IdMenu FROM users us INNER JOIN Rol_Menu rm ON rm.IdRol=us.IdRol WHERE us.Id=?",array($id_user));

        $opciones =array();
        
        $list=json_decode(json_encode($list),true);
        
        foreach ($list as  $value) {
            
            $opciones[] =$value['IdMenu'];
        }
        
        return implode(",",$opciones);
    }

}
