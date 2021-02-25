$(document).ready(function() {



});


function prepare_modal_ver_historial(IdCartaFianzaDetalle){

	$('#modal_ver_historial_carta').modal("show");

	set_datos_detalle_historial_carta(IdCartaFianzaDetalle);

}

function set_datos_detalle_historial_carta(IdCartaFianzaDetalle){

	$.ajax({
		url: server + 'get_detalle_carta_fianza',
		type: "get",
		dataType: 'json',
		data: {
			_token: '{{ csrf_token() }}',
			idCartaFianza: IdCartaFianzaDetalle
		},
		before: function() {

		},
		success: function(response) {

			$.unblockUI();

			if (response.length > 0) {


				console.log(response)

				
				$("#hist_idcliente").val(response[0].IdCliente);
				$("#hist_cliente").val(response[0].ClienteName);
				$("#hist_beneficiario").val(response[0].BeneficiarioName);
				$("#hist_financiera").val(response[0].FinancieraName);


				$("#hist_tipo_fianza").val(response[0].DescTipoCarta);
				$("#hist_estado").val(response[0].DescEstadoCF);
				$("#hist_moneda").val(response[0].DescMoneda);


				$("#hist_solicitud").val(response[0].CodigoSolicitud);








				$("#hist_num_interno").val(response[0].CodigoObra);

				$("#hist_n_renovacion").val(response[0].NumeroRenovacion);


				$("#hist_fe_creacion").val(response[0].FechaCreacion);
				$("#hist_fe_inicio").val(response[0].FechaInicio);
				$("#hist_fe_vencimiento").val(response[0].FechaVence);


				$("#hist_dias").val(response[0].Dias);
				$("#hist_n_renovacion").val(response[0].NumeroRenovacion);
				$("#hist_observacion").val(response[0].Comentario);

				$("#hist_numero_carta").val(response[0].CodigoCarta);

				$("#hist_monto").val(numero_a_formato_numerico(response[0].Monto));


				if(response[0].AvanceObra==null){


					$("#hist_avance_obra").css("pointer-events","none");


				}

				if(response[0].DocumentoElectronico==null){

					$("#hist_doc_electronico").css("pointer-events","none");

				}

				$("#hist_avance_obra").attr("data-file",response[0].AvanceObra);
				$("#hist_doc_electronico").attr("data-file",response[0].DocumentoElectronico);


				get_list_garantias_relacionadas_historial(response[0].IdSolicitud, response[0].TipoCarta);

				get_list_fianzas_relacionadas_historial(response[0].IdSolicitud, response[0].TipoCarta);

			}


		},
		error: function(jqXHR, textStatus, errorThrown) {

			$.unblockUI();

			ajaxError(jqXHR, textStatus, errorThrown);



		}

	});
}

function ver_file_historial(tipo_enlace){

	if(tipo_enlace =='A'){

		var file = $("#hist_avance_obra").attr("data-file");

		var tipo = 'obra';

	}else if(tipo_enlace =='D'){

		var file = $("#hist_doc_electronico").attr("data-file");

		var tipo = 'documento';

	}

	ver_file(file, tipo)

}


function get_list_garantias_relacionadas_historial(codigoSolicitud, TipoFianza){

	$('#table-historial-grel tbody tr').empty();


	$.ajax({
		url: server + 'get_list_garantias_relacionadas',
		type: "get",
		dataType: 'json',
		data: {
			_token: '{{ csrf_token() }}',
			codigoSolicitud: codigoSolicitud,
			TipoFianza: TipoFianza
		},
		before: function() {

		},
		success: function(response) {

			$.unblockUI();

			if (response.length > 0) {

				for(let i=0;i<response.length;i++){

					const fecha_cobro = (response[i].FechaCobro==null)?'':response[i].FechaCobro;
					const disponible = (response[i].Disponible==null)?'':response[i].Disponible; 

					$('#table-historial-grel tbody').append("<tr><td>"+response[i].FechaSistemaCreacion+"</td><td>"+response[i].GarantiaDescripcion+"</td><td>"+response[i].NumeroDocumento+"</td><td>"+response[i].MontoCarta+"</td><td>"+response[i].Porcentaje+"</td><td>"+response[i].Monto+"</td><td>"+response[i].FechaEmision+"</td><td>"+response[i].FechaVencimiento+"</td><td>"+fecha_cobro+"</td><td>"+disponible+"</td><td>"+response[i].Estado+"</td></tr>");

				}


			}


		},
		error: function(jqXHR, textStatus, errorThrown) {

			$.unblockUI();

			ajaxError(jqXHR, textStatus, errorThrown);



		}

	});


}


function get_list_fianzas_relacionadas_historial(codigoSolicitud, TipoFianza){

	$('#table-historial-frel tbody tr').empty();


	$.ajax({
		url: server + 'get_list_fianzas_relacionadas',
		type: "get",
		dataType: 'json',
		data: {
			_token: '{{ csrf_token() }}',
			codigoSolicitud: codigoSolicitud,
			TipoFianza: TipoFianza
		},
		before: function() {

		},
		success: function(response) {

			$.unblockUI();

			if (response.length > 0) {

				for(let i=0;i<response.length;i++){


					const renovacion = (response[i].FechaRenovacion==null)?'':response[i].FechaRenovacion;

					const codigo_carta = (response[i].CodigoCarta==null)?'':response[i].CodigoCarta;

					const cf_anterior = (response[i].CFAnterior==null)?'':response[i].CFAnterior;


					$('#table-historial-frel tbody').append("<tr><td>"+codigo_carta+"</td><td>"+response[i].TipoCarta+"</td><td>"+response[i].CodigoMoneda+"</td><td>"+response[i].Monto+"</td><td>"+cf_anterior+"</td><td>"+response[i].FechaInicio+"</td><td>"+response[i].FechaVence+"</td><td>"+renovacion+"</td><td>"+response[i].EstadoCF+"</td></tr>");

				}


			}


		},
		error: function(jqXHR, textStatus, errorThrown) {

			$.unblockUI();

			ajaxError(jqXHR, textStatus, errorThrown);



		}

	});


}





