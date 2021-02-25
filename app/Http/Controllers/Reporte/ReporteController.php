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
		

		$obras = DB::select("SELECT IdObra,IdCliente FROM obra WHERE CodigoObra=?",array($codigo_obra));
		
		
		$cliente_cabecera = '';

		$array_final = array();


		//fianzas


		$adelanto_materiales = array();

		$adelanto_directo = array();

		$fiel_cumplimiento = array();

		//garantias


		$garantias = array();



		foreach($obras as $list){

			$cliente_cab =Cliente::where('IdCliente',$list->IdCliente)->first();

			$query = Reporte::get_list_fianzas_relacionadas($list->IdObra);

			
			$obra = Obra::where('IdObra',$list->IdObra)->first();
			
			$financiera = Cliente::where('IdCliente',$obra->IdFinanciera)->first();


			foreach ($query as $list2) {
				
				if(!is_null($list2->NumeroCarta)){

			 		if($list2->TipoCarta=='AM'){

			 			$adelanto_materiales[]=array("tipo"=>"ADELANTO MATERIALES",
			 								   "codigo_carta"=>$list2->CodigoCarta,
			 									"inicio"=>$list2->FechaInicio,
			 									"vence"=>$list2->FechaVence,
			 									"renovada"=>$list2->FechaRenovacion,
			 									"monto_original"=>$list2->MontoOriginal,
			 									"monto_actual"=>$list2->MontoActual,
			 									"estado"=>$list2->Estado
			 								);
	
			 		}

			 		if($list2->TipoCarta=='AD'){

			 			$adelanto_directo[]=array("tipo"=>"ADELANTO DIRECTO",
			 								   "codigo_carta"=>$list2->CodigoCarta,
			 									"inicio"=>$list2->FechaInicio,
			 									"vence"=>$list2->FechaVence,
			 									"renovada"=>$list2->FechaRenovacion,
			 									"monto_original"=>$list2->MontoOriginal,
			 									"monto_actual"=>$list2->MontoActual,
			 									"estado"=>$list2->Estado
			 								);

			 			
			 		}

			 		if($list2->TipoCarta=='FC'){

			 			$fiel_cumplimiento[]=array("tipo"=>"FIEL CUMPLIMIENTO",
			 								   "codigo_carta"=>$list2->CodigoCarta,
			 									"inicio"=>$list2->FechaInicio,
			 									"vence"=>$list2->FechaVence,
			 									"renovada"=>$list2->FechaRenovacion,
			 									"monto_original"=>$list2->MontoOriginal,
			 									"monto_actual"=>$list2->MontoActual,
			 									"estado"=>$list2->Estado
			 								);

			 			

			 		}


			 		$garantias[]= array("carta"=>$list2->TipoCarta,
			 								   "garantia"=>$list2->TipoPago,
			 									"emision"=>$list2->FechaEmisionGarantia,
			 									"documento"=>$list2->NumeroDocumento,
			 									"moneda"=>$list2->Moneda,
			 									"monto"=>$list2->Monto,
			 									"cobro"=>$list2->FechaCobroGarantia,
			 									"disponible"=>$list2->Disponible,
			 									"estado"=>$list2->EstadoGarantia
			 								);


				 }

			}


			$agrupa_cartas = array_merge($adelanto_materiales,$adelanto_directo,$fiel_cumplimiento);
			

			$array_final[] = array("Obra"=>$obra->CodigoObra.' - '.$obra->Descripcion,
									"Financiera"=>$financiera->Identificacion.' - '.$financiera->Nombre,
									"cartas"=> $agrupa_cartas
									);


			//dd($array_final);
			$cliente_cabecera = $cliente_cab->Nombre;
			
		}	
		

		
		//ordenando todas las garantias
		$adelanto_materiales_garantia = array();
		$adelanto_directo_garantia = array();
		$fiel_cumplimiento_garantia = array();

		
		foreach($garantias as $values){

			if($values["garantia"]=="CHEQUE DIFERIDO"){

				if($values["carta"]=="AM"){

					$adelanto_materiales_garantia[]=$values;
				}
				if($values["carta"]=="AD"){

					$adelanto_directo_garantia[]=$values;
				}

				if($values["carta"]=="FC"){
					$fiel_cumplimiento_garantia[]=$values;
				}
			}

			if($values["garantia"]=="CHEQUE"){

				if($values["carta"]=="AM"){

					$adelanto_materiales_garantia[]=$values;
				}
				if($values["carta"]=="AD"){
					
					$adelanto_directo_garantia[]=$values;
				}

				if($values["carta"]=="FC"){
					$fiel_cumplimiento_garantia[]=$values;
				}
			}

			if($values["garantia"]=="DEPOSITO"){

				if($values["carta"]=="AM"){

					$adelanto_materiales_garantia[]=$values;
				}
				if($values["carta"]=="AD"){
					
					$adelanto_directo_garantia[]=$values;
				}

				if($values["carta"]=="FC"){
					$fiel_cumplimiento_garantia[]=$values;
				}
			}

		}

		$agrupa_cartas_garantias = array_merge($adelanto_materiales_garantia,$adelanto_directo_garantia,$fiel_cumplimiento_garantia);


		$pdf = \App::make('dompdf.wrapper');
    
        $pdf->setPaper('A4');
        $pdf->loadView('reports.reporte_historial',compact('array_final','cliente_cabecera','agrupa_cartas_garantias'));
   
         return $pdf->stream();

	}	
	

	public function reporte_cumpleanos_representantes($id_empresa){

		$array_final = '';

		$pdf = \App::make('dompdf.wrapper');
    
        $pdf->setPaper('A4');
        $pdf->loadView('reports.reporte_cumpleanos_representantes',compact('array_final'));
   
         return $pdf->stream();

	}

}

