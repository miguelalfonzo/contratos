<?php


namespace App\Http\Controllers\Reporte; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Reporte;
use DB;
use App\Obra;
use App\Cliente;

class ReporteController extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function reporte_historial($codigo_obra)
	{
		

		$middleRpta = $this->valida_codigo_obra($codigo_obra);

		if($middleRpta["status"]!="ok"){

			return $this->redireccion_404();

		}
		

		$obra = Obra::where('CodigoObra',$codigo_obra)->first();


		$obra_name = $codigo_obra.' - '.$obra->Descripcion;

		$cliente = Cliente::where('IdCliente',$obra->IdCliente)->first();

		$cliente_name = $cliente->Identificacion.' - '.$cliente->Nombre;

		$financiera = Cliente::where('IdCliente',$obra->IdFinanciera)->first();

		$financiera_name = $financiera->Identificacion.' - '.$financiera->Nombre;

		$array_cartas = Reporte::get_list_fianzas_relacionadas($obra->IdObra);

		$array_garantias = Reporte::get_list_garantias_relacionadas($obra->IdObra);

		

		$pdf = \App::make('dompdf.wrapper');
    	
    	

        $pdf->setPaper('A4');
        $pdf->loadView('reports.reporte_historial',compact('array_cartas','array_garantias','obra_name','cliente_name','financiera_name'));
   
         return $pdf->stream();

	}	
	

	public function reporte_cumpleanos_representantes($id_empresa){

		$array_final = '';

		$pdf = \App::make('dompdf.wrapper');
    
        $pdf->setPaper('A4');
        $pdf->loadView('reports.reporte_cumpleanos_representantes',compact('array_final'));
   
         return $pdf->stream();

	}


	public function reporte_estado_cuenta($IdCliente){


		$middleRpta = $this->valida_id_cliente($IdCliente);

		if($middleRpta["status"]!="ok"){

			return $this->redireccion_404();

		}


		$query_1  = DB::select("SELECT * FROM consorcio");

		$array_asoc = array();

		

		foreach ($query_1 as $value) {
			
			$id_cliente_cons = $value->IdCliente;

			$vector = $value->clientes_asociados;

			$sin_corchetes = str_replace("]","",str_replace("[","",$vector));

			if(in_array($IdCliente,explode(",", $sin_corchetes))){

				$array_asoc[] = $id_cliente_cons;
			}
			

		}

		if(count($array_asoc)==0){

			$clientes_string = '0';

		}else{

			$clientes_string = implode(",", $array_asoc);
		}

		
		
		

		$obras = DB::select("SELECT o.IdObra,
		 o.CodigoObra,
		 o.Descripcion,
		 cfd.TipoCarta,

		 (SELECT Descripcion FROM tabla_maestra WHERE IdTabla=85 AND valor=cfd.TipoCarta) AS DescripcionTipoCarta,
		 cfd.CodigoMoneda,
		 cfd.Monto AS MontoActual,
		 IFNULL((SELECT Monto FROM carta_fianza_detalle where IdCartaFianzaDetalle=cfd.CartaAnterior),cfd.Monto) AS MontoOriginal,
		 cfd.EstadoCF,
		 (SELECT nombre FROM cliente WHERE IdCliente = cfd.IdCliente) AS fullNameCliente,
		  (SELECT nombre FROM cliente WHERE IdCliente = cfd.IdFinanciera) AS fullNameFinanciera,
		  cfd.IdFinanciera,
		   cfd.CodigoCarta,
		   cfd.CartaAnterior,
		   cfd.FechaVence
FROM carta_fianza_detalle cfd 
INNER JOIN carta_fianza cf ON cf.IdCartaFianza = cfd.IdSolicitud
INNER JOIN  obra o ON o.IdObra = cf.IdObra
WHERE o.IdCliente IN($clientes_string) AND cfd.EstadoCF NOT IN('PRO') order BY cfd.IdFinanciera DESC , o.CodigoObra desc ,cfd.TipoCarta asc;
");

		

		$cliente = Cliente::where('IdCliente',$IdCliente)->first();

		$empresa = $cliente->Nombre;

		$identificacion = $cliente->Identificacion;

		$pdf = \App::make('dompdf.wrapper');
    
        $pdf->setPaper('A4');
        $pdf->loadView('reports.reporte_estado_cuenta',compact('obras','empresa','identificacion'));
   
         return $pdf->stream();

	}

}

