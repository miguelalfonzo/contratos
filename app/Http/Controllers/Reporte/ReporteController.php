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
	

	
	//estado de cuenta con garantias


	public function reporte_estado_cuenta_garantia($IdCliente){

		$middleRpta = $this->valida_id_cliente($IdCliente);

		if($middleRpta["status"]!="ok"){

			return $this->redireccion_404();

		}


		$query_1  = DB::select("SELECT * FROM consorcio");

		$array_asoc = array();

		$array_porc = array();
		

		foreach ($query_1 as $value) {
			
			$id_cliente_cons = $value->IdCliente;

			$clientes_asoc = $value->clientes_asociados;

			$clientes = str_replace("]","",str_replace("[","",$clientes_asoc));

			$array_clientes  = explode(",", $clientes);

			

			$porcentajes_asoc = $value->porcentajes_asociados;

			$porcentajes = str_replace("]","",str_replace("[","",$porcentajes_asoc));
			
			$array_porcentajes = explode(",", $porcentajes);

			
			

			if(in_array($IdCliente,$array_clientes)){

				$array_asoc[] = $id_cliente_cons;

				$key = array_search($IdCliente,$array_clientes);
				
				//buscamos el porcentaje en el arreglo respectivamente

				$array_porc[$id_cliente_cons] = $array_porcentajes[$key];

			}
			

		}

		

		if(count($array_asoc)==0){

			

			$clientes_string = $IdCliente;

			$array_porc[$IdCliente] = '100';

		}else{
			
			$clientes_string = implode(",", $array_asoc);

			//se mostraran porcentajes
		}

		

		
		$cartas = DB::select("SELECT o.IdObra,
		 o.CodigoObra,
		 o.Descripcion,
		 cfd.TipoCarta,
		 cfd.IdCliente,
		 (SELECT Descripcion FROM tabla_maestra WHERE IdTabla=85 AND valor=cfd.TipoCarta) AS DescripcionTipoCarta,
		 cfd.CodigoMoneda,
		 cfd.Monto AS MontoActual,

		 (SELECT Monto FROM carta_fianza_detalle WHERE TipoCarta=cfd.TipoCarta AND NumeroCarta=cfd.NumeroCarta ORDER BY FechaCreacionSistema ASC LIMIT 1) AS MontoOriginal,

		 
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
WHERE o.IdCliente IN($clientes_string) AND cfd.EstadoCF IN('VIG') order BY cfd.IdFinanciera DESC , o.CodigoObra desc ,cfd.TipoCarta asc,cfd.FechaCreacionSistema desc;
");

		

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
					WHERE o.IdCliente IN($clientes_string) AND cfd.EstadoCF IN('VIG') AND  cfd.IdFinanciera =? AND o.CodigoObra=?;",array($fu,$ou));

				$count = json_decode(json_encode($count), true);

				if($count[0]['num_row']>0){

					$query = DB::select("SELECT sum(cfd.Monto) as Totalizado_Actual,
					sum((SELECT Monto FROM carta_fianza_detalle WHERE TipoCarta=cfd.TipoCarta AND NumeroCarta=cfd.NumeroCarta ORDER BY FechaCreacionSistema ASC LIMIT 1)) as Totalizado_Original
					FROM carta_fianza_detalle cfd 
					INNER JOIN carta_fianza cf ON cf.IdCartaFianza = cfd.IdSolicitud
					INNER JOIN  obra o ON o.IdObra = cf.IdObra
					WHERE o.IdCliente IN($clientes_string) AND cfd.EstadoCF IN('VIG') AND  cfd.IdFinanciera =? AND o.CodigoObra=?;",array($fu,$ou));

					$query = json_decode(json_encode($query), true); 

					$obra = Obra::where('CodigoObra',$ou)->first();

					$obra_name = $obra->Descripcion;

					//detale de las cartas fianzas y lo asociamos a la ultima garantia


					$cartasx = DB::select("SELECT 

		 			(SELECT Descripcion FROM tabla_maestra WHERE IdTabla=85 AND valor=cfd.TipoCarta) AS DescripcionTipoCarta,
		 			cfd.Monto AS MontoActual,
		 			(SELECT Monto FROM carta_fianza_detalle WHERE TipoCarta=cfd.TipoCarta AND NumeroCarta=cfd.NumeroCarta ORDER BY FechaCreacionSistema ASC LIMIT 1) AS MontoOriginal,
		 			(SELECT nombre FROM cliente WHERE IdCliente = cfd.IdCliente) AS fullNameCliente,
		   			cfd.CodigoCarta,
		   			cfd.IdCliente,
		   			DATE_FORMAT(cfd.FechaVence, '%d/%m/%Y') as FechaVence,
		   			(SELECT DATE_FORMAT(FechaSistemaCreacion, '%d/%m/%Y') FROM carta_fianza_garantia WHERE NumeroCarta=cfd.NumeroCarta order by FechaSistemaCreacion desc LIMIT 1) AS GarFechaCreacion,
		   			(SELECT DATE_FORMAT(FechaEmision, '%d/%m/%Y') FROM carta_fianza_garantia WHERE NumeroCarta=cfd.NumeroCarta order by FechaSistemaCreacion desc LIMIT 1) AS GarFechaEmision,
		   			(SELECT NumeroDocumento FROM carta_fianza_garantia WHERE NumeroCarta=cfd.NumeroCarta order by FechaSistemaCreacion desc LIMIT 1) AS GarDocumento,
		   			(SELECT Moneda FROM carta_fianza_garantia WHERE NumeroCarta=cfd.NumeroCarta order by FechaSistemaCreacion desc LIMIT 1) AS GarMoneda,
		   			(SELECT Monto FROM carta_fianza_garantia WHERE NumeroCarta=cfd.NumeroCarta order by FechaSistemaCreacion desc LIMIT 1) AS GarMonto,
		   			(SELECT Disponible FROM carta_fianza_garantia WHERE NumeroCarta=cfd.NumeroCarta order by FechaSistemaCreacion desc LIMIT 1) AS GarDisponible,
		   			(SELECT Descripcion FROM tabla_maestra WHERE IdTabla=84 AND valor=(SELECT Estado FROM carta_fianza_garantia WHERE NumeroCarta=cfd.NumeroCarta order by FechaSistemaCreacion desc LIMIT 1)) AS GarEstado

					FROM carta_fianza_detalle cfd 
					INNER JOIN carta_fianza cf ON cf.IdCartaFianza = cfd.IdSolicitud
					INNER JOIN  obra o ON o.IdObra = cf.IdObra
					WHERE o.IdCliente IN($clientes_string)  AND cfd.EstadoCF IN('VIG')  AND  cfd.IdFinanciera =? AND o.CodigoObra=? order BY cfd.TipoCarta asc,cfd.FechaCreacionSistema desc;",array($fu,$ou));

				

					//fin del detalle de cartas
					$sum_obras[] = array("obra"=>$obra_name,"suma_actual"=>$query[0]['Totalizado_Actual'],"suma_original"=>$query[0]['Totalizado_Original'],"sub_detalle"=>$cartasx);
				}


				
			
			}

			//totalizado para financieras 

			 $sql_financieras = DB::select("SELECT sum(cfd.Monto) as Totalizado_Actual,
			 	sum((SELECT Monto FROM carta_fianza_detalle WHERE TipoCarta=cfd.TipoCarta AND NumeroCarta=cfd.NumeroCarta ORDER BY FechaCreacionSistema ASC LIMIT 1)) as Totalizado_Original
					FROM carta_fianza_detalle cfd 
		 			INNER JOIN carta_fianza cf ON cf.IdCartaFianza = cfd.IdSolicitud
		 			INNER JOIN  obra o ON o.IdObra = cf.IdObra
		 			WHERE o.IdCliente IN($clientes_string) AND cfd.EstadoCF IN('VIG') AND  cfd.IdFinanciera =? ;",array($fu));

		 	$sql_financieras = json_decode(json_encode($sql_financieras), true); 

			$financiera = Cliente::where('IdCliente',$fu)->first();

			$final[] =  array("financiera"=>$financiera->Nombre,"detalle"=>$sum_obras,"totalizado_financieras_actual"=>$sql_financieras[0]["Totalizado_Actual"],"totalizado_financieras_original"=>$sql_financieras[0]["Totalizado_Original"]);
		}
		
		

		$cliente = Cliente::where('IdCliente',$IdCliente)->first();

		$empresa = $cliente->Nombre;

		$identificacion = $cliente->Identificacion;

		$pdf = \App::make('dompdf.wrapper');
    
        $pdf->setPaper('A4');
        $pdf->loadView('reports.reporte_estado_cuenta_garantia',compact('cartas','empresa','identificacion','final','array_porc'));
   
         return $pdf->stream();
		

	}









	//estado de cuenta solo

	public function reporte_estado_cuenta($IdCliente){


		$middleRpta = $this->valida_id_cliente($IdCliente);

		if($middleRpta["status"]!="ok"){

			return $this->redireccion_404();

		}


		$query_1  = DB::select("SELECT * FROM consorcio");

		$array_asoc = array();

		$array_porc = array();
		

		foreach ($query_1 as $value) {
			
			$id_cliente_cons = $value->IdCliente;

			$clientes_asoc = $value->clientes_asociados;

			$clientes = str_replace("]","",str_replace("[","",$clientes_asoc));

			$array_clientes  = explode(",", $clientes);

			

			$porcentajes_asoc = $value->porcentajes_asociados;

			$porcentajes = str_replace("]","",str_replace("[","",$porcentajes_asoc));
			
			$array_porcentajes = explode(",", $porcentajes);

			
			

			if(in_array($IdCliente,$array_clientes)){

				$array_asoc[] = $id_cliente_cons;

				$key = array_search($IdCliente,$array_clientes);
				
				//buscamos el porcentaje en el arreglo respectivamente

				$array_porc[$id_cliente_cons] = $array_porcentajes[$key];

			}
			

		}

		

		if(count($array_asoc)==0){

			//$clientes_string = '0';
			//no pertenece a ningun consorcio

			$clientes_string = $IdCliente;

			$array_porc[$IdCliente] = '100';

		}else{
			//esta incluido en al menos 1 consorcio
			$clientes_string = implode(",", $array_asoc);

			//se mostraran porcentajes
		}

		

		
		$cartas = DB::select("SELECT o.IdObra,
		 o.CodigoObra,
		 o.Descripcion,
		 cfd.TipoCarta,
		 cfd.IdCliente,
		 (SELECT Descripcion FROM tabla_maestra WHERE IdTabla=85 AND valor=cfd.TipoCarta) AS DescripcionTipoCarta,
		 cfd.CodigoMoneda,
		 cfd.Monto AS MontoActual,

		 (SELECT Monto FROM carta_fianza_detalle WHERE TipoCarta=cfd.TipoCarta AND NumeroCarta=cfd.NumeroCarta ORDER BY FechaCreacionSistema ASC LIMIT 1) AS MontoOriginal,

		 
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
WHERE o.IdCliente IN($clientes_string) AND cfd.EstadoCF IN('VIG') order BY cfd.IdFinanciera DESC , o.CodigoObra desc ,cfd.TipoCarta asc,cfd.FechaCreacionSistema desc;
");

		//AND cfd.EstadoCF NOT IN('PRO') condicion para discriminar cartas en proceso
		
		//solo se mostraran las cartas vigentes y el monto original es el primero de todas las cartas

		// se quitara el if null 

		//IFNULL((SELECT Monto FROM carta_fianza_detalle where IdCartaFianzaDetalle=cfd.CartaAnterior),cfd.Monto) AS MontoOriginal

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
					WHERE o.IdCliente IN($clientes_string) AND cfd.EstadoCF IN('VIG') AND  cfd.IdFinanciera =? AND o.CodigoObra=?;",array($fu,$ou));

				$count = json_decode(json_encode($count), true);

				if($count[0]['num_row']>0){

					$query = DB::select("SELECT sum(cfd.Monto) as Totalizado_Actual,
					sum((SELECT Monto FROM carta_fianza_detalle WHERE TipoCarta=cfd.TipoCarta AND NumeroCarta=cfd.NumeroCarta ORDER BY FechaCreacionSistema ASC LIMIT 1)) as Totalizado_Original
					FROM carta_fianza_detalle cfd 
					INNER JOIN carta_fianza cf ON cf.IdCartaFianza = cfd.IdSolicitud
					INNER JOIN  obra o ON o.IdObra = cf.IdObra
					WHERE o.IdCliente IN($clientes_string) AND cfd.EstadoCF IN('VIG') AND  cfd.IdFinanciera =? AND o.CodigoObra=?;",array($fu,$ou));

					$query = json_decode(json_encode($query), true); 

					$obra = Obra::where('CodigoObra',$ou)->first();

					$obra_name = $obra->Descripcion;

					//detale de las cartas fianzas


					$cartasx = DB::select("SELECT 

		 			(SELECT Descripcion FROM tabla_maestra WHERE IdTabla=85 AND valor=cfd.TipoCarta) AS DescripcionTipoCarta,
		 			cfd.Monto AS MontoActual,
		 			(SELECT Monto FROM carta_fianza_detalle WHERE TipoCarta=cfd.TipoCarta AND NumeroCarta=cfd.NumeroCarta ORDER BY FechaCreacionSistema ASC LIMIT 1) AS MontoOriginal,
		 			(SELECT nombre FROM cliente WHERE IdCliente = cfd.IdCliente) AS fullNameCliente,
		   			cfd.CodigoCarta,
		   			cfd.IdCliente,
		   			DATE_FORMAT(cfd.FechaVence, '%d/%m/%Y') as FechaVence
					FROM carta_fianza_detalle cfd 
					INNER JOIN carta_fianza cf ON cf.IdCartaFianza = cfd.IdSolicitud
					INNER JOIN  obra o ON o.IdObra = cf.IdObra
					WHERE o.IdCliente IN($clientes_string)  AND cfd.EstadoCF IN('VIG')  AND  cfd.IdFinanciera =? AND o.CodigoObra=? order BY cfd.TipoCarta asc,cfd.FechaCreacionSistema desc;",array($fu,$ou));

				

					//fin del detalle de cartas
					$sum_obras[] = array("obra"=>$obra_name,"suma_actual"=>$query[0]['Totalizado_Actual'],"suma_original"=>$query[0]['Totalizado_Original'],"sub_detalle"=>$cartasx);
				}


				
			
			}

			//totalizado para financieras 

			 $sql_financieras = DB::select("SELECT sum(cfd.Monto) as Totalizado_Actual,
			 	sum((SELECT Monto FROM carta_fianza_detalle WHERE TipoCarta=cfd.TipoCarta AND NumeroCarta=cfd.NumeroCarta ORDER BY FechaCreacionSistema ASC LIMIT 1)) as Totalizado_Original
					FROM carta_fianza_detalle cfd 
		 			INNER JOIN carta_fianza cf ON cf.IdCartaFianza = cfd.IdSolicitud
		 			INNER JOIN  obra o ON o.IdObra = cf.IdObra
		 			WHERE o.IdCliente IN($clientes_string) AND cfd.EstadoCF IN('VIG') AND  cfd.IdFinanciera =? ;",array($fu));

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
        $pdf->loadView('reports.reporte_estado_cuenta',compact('cartas','empresa','identificacion','final','array_porc'));
   
         return $pdf->stream();

	}

}

