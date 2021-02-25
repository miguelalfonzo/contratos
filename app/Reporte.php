<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Carbon\Carbon;

class Reporte extends Model
{
   


    protected static function get_list_fianzas_relacionadas($obra){


    	$list  = DB::select('call Reporte_Historial_Obra (?)', array($obra));

    	return $list;
      
    
    }




}
