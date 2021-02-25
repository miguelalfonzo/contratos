<?php


namespace App\Http\Controllers\Reporte; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Alerta;
use DB;
use App\Exports\ExportGeneral;
use Maatwebsite\Excel\Facades\Excel;

class AlertaController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function get_alertas_fianzas(Request $request)
	{
		$list = Alerta::get_alertas_fianzas($request);
		
		return response()->json($list);
		
	}	
	

	public function get_alertas_garantias(Request $request)
	{
		$list = Alerta::get_alertas_garantias($request);
		
		return response()->json($list);
		
	}
	


	public function get_alertas_cumpleanos(Request $request)
	{
		$list = Alerta::get_alertas_cumpleanos($request);
		
		return response()->json($list);
		
	}
	
	//exportar 

	public function export_todos_cumpleanos(){

		$request = new \Illuminate\Http\Request();

		$request->tipo = 'todos';

        $list = Alerta::get_alertas_cumpleanos($request);

        $excel = $this->set_filas_excel_detalle($list);

        $export = new ExportGeneral([
            
            $excel

         ]); 

      
        return Excel::download($export, 'Todos_Cumpleanos'.date('Y-m').'.xlsx');
    }

    public function set_filas_excel_detalle($list){

        $sub_array =array();

        $i=1;

        $sub_array[0]=array("EMPRESA","REPRESENTANTE","TELEFONO","EMAIL","FECHA_CUMPLEAÑOS");

        foreach ($list as $value) {
            
            $empresa          = $value->NameEmpresa;
            $representante    = $value->Representante;
            $telefono         = $value->TelefonoRepresentante;
            $email 		      = $value->EmailRepresentante;
            $cumpleaños       = $value->FechaCumpleanos;
        
            $sub_array[$i]=array($empresa,$representante,$telefono,$email,$cumpleaños);
            $i++;
        }

        return $sub_array;

    }

}

