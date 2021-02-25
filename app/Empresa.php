<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Empresa extends Model
{   
    protected $table='empresa';

    protected $primaryKey='IdEmpresa';
     
    protected static function actualiza_empresa($request){

        $id_empresa  =       $request->id_empresa;
        $ruc         =       $request->ruc_compania;
        $empresa     =       $request->emp_compania;
        $abrv        =       $request->abrv_emp_compania;
        $direccion   =       $request->direccion_compania;
        $telf1       =       $request->telf1_compania;
        $telf2       =       $request->telf2_compania;
        $mov1        =       $request->mov1_compania;
        $mov2        =       $request->mov2_compania;
        $fax         =       $request->fax_compania;
        $email       =       $request->email_compania;
        $url         =       $request->url_compania;
        $activo      =       $request->estado_compania;
        $user        =       Auth::user()->id;

        $response = DB::update('call Empresa_Update (?,?,?,?,?,?,?,?,?,?,?,?,?,?)',array(
        $id_empresa,$ruc,$empresa,$abrv,$direccion,$telf1,$telf2,$mov1,$mov2,$fax,$email,$url,$activo,$user));

        return $response;
    
    }


    

}
