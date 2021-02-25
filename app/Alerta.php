<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Obra;
class Alerta extends Model
{   
   

    
    protected static function get_alertas_fianzas($request){

        $tipo = $request->tipo;

        $list = DB::select("call Alertas_Fianzas (?)",array($tipo));

        return $list;
    
    }


    protected static function get_alertas_garantias($request){

        $tipo = $request->tipo;

        $list = DB::select("call Alertas_Garantias (?)",array($tipo));

        return $list;
    
    }


    public function get_indicadores_fianzas(){


    	$tipos = array('vence-hoy','vencidas','por-vencer');

    	$contadores_fianzas = array();

    	foreach($tipos as $values ){

    		$query = DB::select("call Alertas_Fianzas (?)",array($values));

    		$contadores_fianzas[]=array('tipo'=>$values,'cantidad'=>count($query));
    	}

    	return $contadores_fianzas;
    }
    

    public function get_indicadores_garantias(){


    	$tipos = array('vence-hoy','vencidas','por-vencer');

    	$contadores_garantias = array();

    	foreach($tipos as $values ){

    		$query = DB::select("call Alertas_Garantias (?)",array($values));

    		$contadores_garantias[]=array('tipo'=>$values,'cantidad'=>count($query));
    	}

    	return $contadores_garantias;
    }


    public function get_indicadores_obra(){


    	$obras = Obra::count();

    	$totalizado =  Obra::all()->sum('Monto');

    	return array('cantidad'=>$obras,'totalizado'=>number_format($totalizado, 2, '.', ','));


    }


    
    protected static function get_alertas_cumpleanos($request){

        $tipo = $request->tipo;

        $list = DB::select("call Alertas_Cumpleanos (?)",array($tipo));

        return $list;
    
    }


    public function get_indicadores_cumpleanos(){


        $tipos = array('cumpleanos-hoy','proximos-cumpleanos','todos');

        $contadores_cumpleanos = array();

        foreach($tipos as $values ){

            $query = DB::select("call Alertas_Cumpleanos (?)",array($values));

            $contadores_cumpleanos[]=array('tipo'=>$values,'cantidad'=>count($query));
        }

        return $contadores_cumpleanos;
    }

}
