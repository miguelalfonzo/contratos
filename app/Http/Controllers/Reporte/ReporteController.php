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
	

	

	public function reporte_estado_cuenta_garantia($IdCliente){


		$middleRpta = $this->valida_id_cliente($IdCliente);

		if($middleRpta["status"]!="ok"){

			return $this->redireccion_404();

		}

		$cliente = Cliente::where('IdCliente',$IdCliente)->first();

		$empresa = $cliente->Nombre;

		$identificacion = $cliente->Identificacion;


		$cartas_garantias = array();

		$pdf = \App::make('dompdf.wrapper');
    
        $pdf->setPaper('A4');
        $pdf->loadView('reports.reporte_estado_cuenta_garantia',compact('cartas_garantias','empresa','identificacion'));
   
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

			//$clientes_string = '0';
			//no pertenece a ningun consorcio

			$clientes_string = $IdCliente;

		}else{
			//esta incluido en al menos 1 consorcio
			$clientes_string = implode(",", $array_asoc);
		}

		
		
		

		$cartas = DB::select("SELECT o.IdObra,
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
		   DATE_FORMAT(cfd.FechaVence, '%d/%m/%Y') as FechaVence
FROM carta_fianza_detalle cfd 
INNER JOIN carta_fianza cf ON cf.IdCartaFianza = cfd.IdSolicitud
INNER JOIN  obra o ON o.IdObra = cf.IdObra
WHERE o.IdCliente IN($clientes_string)  order BY cfd.IdFinanciera DESC , o.CodigoObra desc ,cfd.TipoCarta asc,cfd.FechaCreacionSistema desc;
");

		//AND cfd.EstadoCF NOT IN('PRO') condicion para discriminar cartas en proceso
		

		if(count($cartas)==0){

			return $this->redireccion_404();

		}


		//financieras unicas - obras unicas

		$financieras_unicas=array();
		$obras_unicas=array();

		foreach ($cartas as $value) {

			$financieras_unicas[] = $value->IdFinanciera;
			$obras_unicas[]       = $value->CodigoObra;

		}

		$financieras_unicas = array_unique($financieras_unicas);
		$obras_unicas = array_unique($obras_unicas);
		
		$final = array();

		foreach ($financieras_unicas as $fu) {
			
			$sum_obras = array();

			//
			//$detalle_cartas=array();

			foreach ($obras_unicas as $ou) {
				//valida contador

				$count = DB::select("SELECT count(*) as num_row
					FROM carta_fianza_detalle cfd 
					INNER JOIN carta_fianza cf ON cf.IdCartaFianza = cfd.IdSolicitud
					INNER JOIN  obra o ON o.IdObra = cf.IdObra
					WHERE o.IdCliente IN($clientes_string) AND  cfd.IdFinanciera =? AND o.CodigoObra=?;",array($fu,$ou));

				$count = json_decode(json_encode($count), true);

				if($count[0]['num_row']>0){

					$query = DB::select("SELECT sum(cfd.Monto) as Totalizado_Actual,
					sum(IFNULL((SELECT Monto FROM carta_fianza_detalle where IdCartaFianzaDetalle=cfd.CartaAnterior),cfd.Monto)) as Totalizado_Original
					FROM carta_fianza_detalle cfd 
					INNER JOIN carta_fianza cf ON cf.IdCartaFianza = cfd.IdSolicitud
					INNER JOIN  obra o ON o.IdObra = cf.IdObra
					WHERE o.IdCliente IN($clientes_string) AND  cfd.IdFinanciera =? AND o.CodigoObra=?;",array($fu,$ou));

					$query = json_decode(json_encode($query), true); 

					$obra = Obra::where('CodigoObra',$ou)->first();

					$obra_name = $obra->Descripcion;

					//detale de las cartas fianzas


					$cartasx = DB::select("SELECT 

		 			(SELECT Descripcion FROM tabla_maestra WHERE IdTabla=85 AND valor=cfd.TipoCarta) AS DescripcionTipoCarta,
		 			cfd.Monto AS MontoActual,
		 			IFNULL((SELECT Monto FROM carta_fianza_detalle where IdCartaFianzaDetalle=cfd.CartaAnterior),cfd.Monto) AS MontoOriginal,
		 			(SELECT nombre FROM cliente WHERE IdCliente = cfd.IdCliente) AS fullNameCliente,
		   			cfd.CodigoCarta,
		   			DATE_FORMAT(cfd.FechaVence, '%d/%m/%Y') as FechaVence
					FROM carta_fianza_detalle cfd 
					INNER JOIN carta_fianza cf ON cf.IdCartaFianza = cfd.IdSolicitud
					INNER JOIN  obra o ON o.IdObra = cf.IdObra
					WHERE o.IdCliente IN($clientes_string)   AND  cfd.IdFinanciera =? AND o.CodigoObra=? order BY cfd.TipoCarta asc,cfd.FechaCreacionSistema desc;",array($fu,$ou));

				

					//fin del detalle de cartas
					$sum_obras[] = array("obra"=>$obra_name,"suma_actual"=>$query[0]['Totalizado_Actual'],"suma_original"=>$query[0]['Totalizado_Original'],"sub_detalle"=>$cartasx);
				}


				
			
			}

			//totalizado para financieras 

			 $sql_financieras = DB::select("SELECT sum(cfd.Monto) as Totalizado_Actual,
			 	sum(IFNULL((SELECT Monto FROM carta_fianza_detalle where IdCartaFianzaDetalle=cfd.CartaAnterior),cfd.Monto)) as Totalizado_Original
					FROM carta_fianza_detalle cfd 
		 			INNER JOIN carta_fianza cf ON cf.IdCartaFianza = cfd.IdSolicitud
		 			INNER JOIN  obra o ON o.IdObra = cf.IdObra
		 			WHERE o.IdCliente IN($clientes_string) AND  cfd.IdFinanciera =? ;",array($fu));

		 	$sql_financieras = json_decode(json_encode($sql_financieras), true); 

			$financiera = Cliente::where('IdCliente',$fu)->first();

			$final[] =  array("financiera"=>$financiera->Nombre,"detalle"=>$sum_obras,"totalizado_financieras_actual"=>$sql_financieras[0]["Totalizado_Actual"],"totalizado_financieras_original"=>$sql_financieras[0]["Totalizado_Original"]);
		}
		
		//dd($final);
		//die();

		$cliente = Cliente::where('IdCliente',$IdCliente)->first();

		$empresa = $cliente->Nombre;

		$identificacion = $cliente->Identificacion;

		$pdf = \App::make('dompdf.wrapper');
    
        $pdf->setPaper('A4');
        $pdf->loadView('reports.reporte_estado_cuenta',compact('cartas','empresa','identificacion','final'));
   
         return $pdf->stream();

	}

}

