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
	
	//exportar todos cumpleaños

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


    //exportar alertas fianzas


    public function export_alertas_fianzas($tipo){

		
		$request = new \Illuminate\Http\Request();

		$request->tipo = $tipo;

        $list = Alerta::get_alertas_fianzas($request);

        $excel = $this->set_filas_excel_detalle_fianzas($list);

        $export = new ExportGeneral([
            
            $excel

         ]); 

      
        return Excel::download($export, 'Alertas_Fianzas_'.$tipo.'_'.date('Y-m').'.xlsx');
    }

    public function set_filas_excel_detalle_fianzas($list){

        $sub_array =array();

        $i=1;

        $sub_array[0]=array("CLIENTE","BENEFICIARIO","FINANCIERA","CARTA","NUMERO","MONTO","VENCE");

        foreach ($list as $value) {
            
            $cliente      = $value->NameCliente;
            $beneficiario = $value->NameBeneficiario;
            $financiera   = $value->NameFinanciera;
            $carta 		  = $value->CartaFianza;
            $numero       = $value->CodigoCarta;
        	$monto        = $value->Monto;
        	$vence        = $value->FechaVence;

            $sub_array[$i]=array($cliente,$beneficiario,$financiera,$carta,$numero,$monto,$vence );
            $i++;
        }

        return $sub_array;

    }

    //exportas garantias alertas



    public function export_alertas_garantias($tipo){

        
        $request = new \Illuminate\Http\Request();

        $request->tipo = $tipo;

        $list = Alerta::get_alertas_garantias($request);

        $excel = $this->set_filas_excel_detalle_garantias($list);

        $export = new ExportGeneral([
            
            $excel

         ]); 

      
        return Excel::download($export, 'Alertas_Garantias_'.$tipo.'_'.date('Y-m').'.xlsx');
    }

    public function set_filas_excel_detalle_garantias($list){

        $sub_array =array();

        $i=1;

        $sub_array[0]=array("GARANTIA","NUMERO","MONEDA","MONTO_FIANZA","PORCENTAJE","MONTO_GARANTIA","EMISION","VENCE","COBRO","ESTADO");

        foreach ($list as $value) {
            
            $garantia      = $value->Garantia;
            $numero        = $value->NumeroDocumento;
            $moneda        = $value->Moneda;
            $monto_fianza  = $value->MontoCarta;
            $porcentaje    = $value->Porcentaje;
            $monto_garantia = $value->Monto;
            $emision        = $value->FechaEmision;
            $vence          = $value->FechaVencimiento;
            $cobro          = $value->FechaCobro;
            $estado         = $value->Estado;

            $sub_array[$i]=array($garantia,$numero,$moneda,$monto_fianza,$porcentaje,$monto_garantia,$emision,$vence,$cobro,$estado);
            
            $i++;
        }

        return $sub_array;

    }
}

