$(document).ready(function() {

    valida_parametros_get();


});

function valida_parametros_get(){

   const cliente = obten_parametro_get_url('cliente');
   const obra = obten_parametro_get_url('obra');
   const carta = obten_parametro_get_url('carta');
   const fianza = obten_parametro_get_url('fianza');

   if(cliente!=""&&obra!=""&&carta!=""&&fianza!=""){

        //mostrara listado al cargar pagina
        load_list_fianzas(carta,cliente,obra,fianza);

    }

}

function obten_parametro_get_url(name) {


    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));


}



$("#btn_filtro_especial_fianzas").on('click', function() {


    $("#modal_filtrar_cartas").modal('show');

    limpia_modal_filtro_fianza();

});

function limpia_modal_filtro_fianza(){

    $('#filtrar_modal_id_cliente').val(0);
    $('#filtrar_modal_cliente').val('');

    $('#filtrar_modal_id_obra').val(0);
    $('#filtrar_modal_obra').val('');
}

//todos los clientes

$('#filtrar_modal_cliente').keyup(function() {

    let query = $(this).val();

    $('#filtrar_modal_id_cliente').val(0);

    if (query != '') {

        $.ajax({
            url: server + "get_combo_empresas",
            method: "get",
            data: {
                _token: '{{ csrf_token() }}',
                query: query,
                tipo: 'T'
            },
            success: function(data) {

                console.log(data);

                $('#clientes_list').fadeIn();
                $('#clientes_list').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                ajaxError(jqXHR, textStatus, errorThrown);

            }
        });
    }
});

$(document).on('click', '#clientes_list ul li', function() {

    let string = $(this).text();

    if (string != "no se encontraron resultados") {

        $('#filtrar_modal_cliente').val(string);
        $('#clientes_list').fadeOut();

        const id_cliente = $(this).attr('data-id');

        $('#filtrar_modal_id_cliente').val(id_cliente);


    }


});


//filtrar obras

$('#filtrar_modal_obra').keyup(function() {

    let query = $(this).val();

    $('#filtrar_modal_id_obra').val(0);

    if (query != '') {

        $.ajax({
            url: server + "get_obras_combo_autocompletar",
            method: "get",
            data: {
                _token: '{{ csrf_token() }}',
                query: query
            },
            success: function(data) {

                console.log(data);
                
                $('#obras_list').fadeIn();
                $('#obras_list').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                ajaxError(jqXHR, textStatus, errorThrown);

            }
        });
    }
});

$(document).on('click', '#obras_list ul li', function() {

    let string = $(this).text();

    if (string != "no se encontraron resultados") {

        $('#filtrar_modal_obra').val(string);
        $('#obras_list').fadeOut();

        const id_obra = $(this).attr('data-id');

        $('#filtrar_modal_id_obra').val(id_obra);


    }


});





$("#buscar_fianzas_filtro").on('click', function() {

    const documento = $('#filtrar_modal_carta').val();

    const cliente = $('#filtrar_modal_id_cliente').val();
    
    const obra = $('#filtrar_modal_id_obra').val();
    
    const fianza_vencimiento = $('#filtrar_modal_vence').val();

    load_list_fianzas(documento,cliente,obra,fianza_vencimiento);

    $("#modal_filtrar_cartas").modal('hide');

    //setea cabecera de filtros


    const label_cliente = (cliente == 0)?' ':$("#filtrar_modal_cliente").val();

    const label_obra = (obra == 0)?' ':$("#filtrar_modal_obra").val();

    const label_carta = $("#filtrar_modal_carta option:selected").text();

    const label_vence = $("#filtrar_modal_vence option:selected").text();

    $('#filtro_cabecera_cliente').text(label_cliente.trim());

    $('#filtro_cabecera_obra').text(label_obra.trim());
    
    $('#filtro_cabecera_fianza').text(label_carta.trim());

    $('#filtro_cabecera_vence').text(label_vence.trim());


});

function load_list_fianzas(documento,cliente,obra,fianza_vencimiento) {

    destroy_data_table('tabla-fianza');

    $("#buscador_general").val('');

    var dataTable = $('#tabla-fianza').DataTable({
        ajax: {
            url: server + 'get_list_fianzas',
            type: 'GET',
            data: {
                documento: documento,
                cliente:cliente,
                obra:obra,
                fianza_vencimiento:fianza_vencimiento

            },
            dataSrc: '',
            beforeSend: function() {
                loadingUI('cargando');
            },
            error: function(jqXHR, textStatus, errorThrown) {

                ajaxError(jqXHR, textStatus, errorThrown);
                console.log(jqXHR);
                $.unblockUI();
            }
        },
        "initComplete": function(settings, json) {
            $.unblockUI();
        },
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ filas",
            "infoEmpty": "Mostrando 0 to 0 of 0 filas",
            "infoFiltered": "(Filtrado de _MAX_ total filas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ filas",
            "loadingRecords": "Cargando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        columns: [ {
            data: 'FileName'
        }, {
            data: 'Carta'
        }, {
            data: 'NombreCliente'
        }, {
            data: 'fullnameobra'
        }, {
            data: 'MontoMoneda'
        }, {
            data: 'Estado'
        }, {
            data: null,
            "render": function(data, type, full, meta) {

                return set_botones_tabla_fianza(data);

            }
        }],


        "drawCallback": function(settings) {

            $('[data-toggle="tooltip"]').tooltip();


        },

    });

    $("#buscador_general").keyup(function() {
        dataTable.search(this.value).draw();

    });
}






$(".filter-label-vencimiento").on('click', function() {

 const fianza_vencimiento = $(this).attr('data-tipo');

 load_list_fianzas('',0,0,fianza_vencimiento);

 let label_vencimiento = '' ;

 if( fianza_vencimiento == 'VH'){

    label_vencimiento = 'Vencen Hoy';

}else if( fianza_vencimiento == 'VE'){

    label_vencimiento = 'Vencidas';

}else if( fianza_vencimiento == 'PV'){

    label_vencimiento = 'Por Vencer';

}else if( fianza_vencimiento == 'PE'){

    label_vencimiento = 'Pendientes';
}

$('#filtro_cabecera_cliente').text('TODOS');

$('#filtro_cabecera_obra').text('TODOS');

$('#filtro_cabecera_fianza').text('TODOS');

$('#filtro_cabecera_vence').text(label_vencimiento);

});


function set_botones_tabla_fianza(data) {

    let text_color;

    let tittle;

    if (data.FlagGestionCarta == 0) {

        text_color = 'text-danger';

        tittle = 'Gestión Pendiente';

    } else {

        text_color = 'text-success';

        tittle = 'Carta Gestionada';

    }

    let btn_gestionar = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_gestionar(\'' + data.IdCartaFianzaDetalle + '\')" style="cursor:pointer" title="' + tittle + '"><span style="font-size:80%;" class="' + text_color + '  glyphicon glyphicon-cog"></span></a>';

    let btn_renovar_cf;

    let btn_renovar_garantia;

    let btn_cerrar_carta;

    let btn_anular_carta;

    let btn_historial;

    let btn_post_ver_garantias = '';

    if (data.FlagGestionCarta == 0) {

        btn_renovar_cf = '';

        btn_renovar_garantia = '';

        btn_cerrar_carta = '';

        btn_anular_carta = '';

        btn_historial='';

    } else {

        //const estados_renovar = ["VIGENTE", "PROCESO"];

        const estados_renovar = ["VIGENTE"];

        if (estados_renovar.includes(data.Estado)) {

            btn_renovar_cf = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_renovar_cf(\'' + data.IdCartaFianzaDetalle + '\')" style="cursor:pointer" title="Renovar Carta Fianza"><span style="font-size:80%;" class="text-success  glyphicon glyphicon-repeat"></span></a>';

            btn_renovar_garantia = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_renovar_garantia_det(\'' + data.IdCartaFianzaDetalle + '\')" style="cursor:pointer" title="Renovar Garantia"><span style="font-size:80%;" class="text-primary  glyphicon glyphicon-retweet"></span></a>';

            btn_cerrar_carta = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_cerrar_fianza(\'' + data.IdCartaFianzaDetalle + '\',\'' + data.NombreCliente + '\',\'' + data.NombreFinanciera + '\',\'' + data.NombreBeneficiario + '\',\'' + data.Moneda + '\',\'' + data.MontoCarta + '\')" style="cursor:pointer" title="Cerrar Carta Fianza"><span style="font-size:80%;" class="text-danger  glyphicon glyphicon-folder-close"></span></a>';

            btn_historial = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_ver_historial(\'' + data.IdCartaFianzaDetalle + '\')" style="cursor:pointer" title="Historial"><span style="font-size:80%;" class="text-warning  glyphicon glyphicon-eye-open"></span></a>';

            btn_anular_carta = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_anular_fianza(\'' + data.IdCartaFianzaDetalle + '\',\'' + data.NombreCliente + '\',\'' + data.NombreFinanciera + '\',\'' + data.NombreBeneficiario + '\',\'' + data.Moneda + '\',\'' + data.MontoCarta + '\')" style="cursor:pointer" title="Anular Carta Fianza"><span style="font-size:80%;" class="text-danger  glyphicon glyphicon-remove"></span></a>';


        } else {

            btn_renovar_cf = '';

            btn_renovar_garantia = '';

            btn_cerrar_carta = '';

            btn_anular_carta = '';

            btn_historial ='';

        }

        // if(data.Estado == "ANULADA"){

        //     btn_gestionar = '';
        // }

        if(data.Estado == "CERRADA" || data.Estado == "ANULADA"){

            btn_historial = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_ver_historial(\'' + data.IdCartaFianzaDetalle + '\')" style="cursor:pointer" title="Historial"><span style="font-size:80%;" class="text-warning  glyphicon glyphicon-eye-open"></span></a>';

            btn_gestionar = '';

            //si es mayor a cero entonces ya existe una vigente y NO mostraremos el boton postgarantia
            //si NO traer resultados entoces mostraremos el boton postgarantia
            if(data.flagRenuevaPostGarantia == 0){

                btn_post_ver_garantias = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_renovar_garantia_det(\'' + data.IdCartaFianzaDetalle + '\')" style="cursor:pointer" title="Renovar Garantia"><span style="font-size:80%;" class="text-warning  glyphicon glyphicon-retweet"></span></a>';

            }
            
        }

    }





    return '<div class="btn-group"> ' + btn_gestionar + btn_renovar_cf + btn_renovar_garantia + btn_cerrar_carta+btn_historial+btn_anular_carta+btn_post_ver_garantias+'</div>';
}

function prepare_modal_anular_fianza(IdCartaFianza,p2,p3,p4,p5,p6){


    alertify.confirm("Confirmar Consulta", "¿Está seguro de anular la carta?  " ,
        function() {

          confirma_anulacion_carta_fianza(IdCartaFianza);

      },
      function() {

        alertify.error(set_error_message_alertify('Cancelado'));

    });

}

function confirma_anulacion_carta_fianza(IdCartaFianza){


    $.ajax({
        url: server + 'cerrar_carta_fianza',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            cerrar_cf_idcarta: IdCartaFianza,
            cerrar_cf_comentario: 'Carta Fianza Anulada',
            cerrar_estado_carta_fianza: 'ANL'
        },
        success: function(response) {

            if (response.status == "ok") {

                alertify.success(set_sucess_message_alertify(response.description));

                const url = server + "gestion_carta_fianza";

                setTimeout($(location).attr('href', url), 10000);

            } else {

                alertify.error(set_error_message_alertify(response.description));

            }
            
            $.unblockUI();
        },
        error: function(jqXHR, textStatus, errorThrown) {

            ajaxError(jqXHR, textStatus, errorThrown);
            
            $.unblockUI();
        }

    })

}


function prepare_modal_gestionar(idCartaFianza) {

    $("#tab-gestion-cf").click();
    $("#modal_gestionar_carta").modal("show");
    get_detalle_carta_fianza(idCartaFianza);



    loadingUI('cargando');
}





function get_detalle_carta_fianza_garantia(numCarta,gestionada) {


    $.ajax({
        url: server + 'get_detalle_carta_fianza_garantia',
        type: "get",
        dataType: 'json',
        data: {
            _token: '{{ csrf_token() }}',
            numCarta: numCarta


        },
        before: function() {

        },
        success: function(response) {

            $.unblockUI();

            console.log(response);

            if (response.length > 0) {

                //se agregaran lineas para deshabilitar algunos inputssi ya fue gestionada

                if(gestionada == 1){

                    console.log('gestionada y con garantia');

                    $("#hidden_id_garantia_last").val(response[0].IdCartaFianzaGarantia);
                    $("#mdg_porcentaje").val(response[0].Porcentaje);
                    // se desahilitara
                    $("#mdg_porcentaje").attr("readonly",true);
                    $("#mdg_monto_fianza").val(response[0].MontoCarta);
                    $("#mdg_monto_garantia").val(response[0].Monto);

                    $("#mdg_n_tipo_garantia").val(response[0].NumeroDocumento);
                    // se desahilitara
                    $("#mdg_n_tipo_garantia").attr("readonly",true);

                    $("#mdg_fecha_emision").val(response[0].FechaEmision);
                    // se desahilitara
                    $("#mdg_fecha_emision").attr("readonly",true);
                    $("#mdg_vencimiento").val(response[0].FechaVencimiento);

                    $("#mdg_obs").val(response[0].Observaciones);
                    // se desahilitara
                    $("#mdg_obs").attr("readonly",true);
                    //
                    $("#mdg_tipo_garantia option[value=" + response[0].TipoGarantia + "]").prop("selected", true);

                    //se deshabilitara el tipo de pago garantia

                    $('#mdg_tipo_garantia').prop("disabled",true);
                    //
                    $('#mdg_tipo_garantia').trigger("chosen:updated");


                    $("#mdg_moneda option[value=" + response[0].Moneda + "]").prop("selected", true);

                    //se desjanilitara
                    $('#mdg_moneda').prop("disabled",true);
                    $('#mdg_moneda').trigger("chosen:updated");

                    $("#mdg_banco option[value=" + response[0].CodigoBanco + "]").prop("selected", true);
                    //se desjanilitara
                    $('#mdg_banco').prop("disabled",true);
                    $('#mdg_banco').trigger("chosen:updated");



                    let sub_arreglo = ["PRO","PND","LIT","LIP","COB","REN","POS"];


                    for(let j=0;j<sub_arreglo.length;j++){

                        $('#mdg_estado option[value="'+sub_arreglo[j]+'"]').attr("disabled", false); 

                    }

                    const estado_seleccionado_garantia = response[0].Estado;


                    $("#mdg_estado option[value=" + response[0].Estado + "]").prop("selected", true);
                
                    for(let i=0;i<sub_arreglo.length;i++){

                        if(sub_arreglo[i]!=estado_seleccionado_garantia){

                        $('#mdg_estado option[value="'+sub_arreglo[i]+'"]').attr("disabled", true); 
                        }
                    

                    }
                    //se deshabilitar
                    $('#mdg_estado').prop("disabled",true);
                    $('#mdg_estado').trigger("chosen:updated");

                }else{


                    console.log('sin gestionar pero con garantia');

                    //tiene numero de carta pero no fue gestionada entonces podra habilitarse la edicion
                    $("#hidden_id_garantia_last").val(response[0].IdCartaFianzaGarantia);
                    $("#mdg_porcentaje").val(response[0].Porcentaje);
                    // se hailitara
                    $("#mdg_porcentaje").attr("readonly",false);
                    $("#mdg_monto_fianza").val(response[0].MontoCarta);
                    $("#mdg_monto_garantia").val(response[0].Monto);

                    $("#mdg_n_tipo_garantia").val(response[0].NumeroDocumento);
                    // se hailitara
                    $("#mdg_n_tipo_garantia").attr("readonly",false);

                    $("#mdg_fecha_emision").val(response[0].FechaEmision);
                    // se hailitara
                    $("#mdg_fecha_emision").attr("readonly",false);
                    $("#mdg_vencimiento").val(response[0].FechaVencimiento);

                    $("#mdg_obs").val(response[0].Observaciones);
                    // se hailitara
                    $("#mdg_obs").attr("readonly",false);
                    //
                    $("#mdg_tipo_garantia option[value=" + response[0].TipoGarantia + "]").prop("selected", true);

                    // se hailitara

                    $('#mdg_tipo_garantia').prop("disabled",false);
                    //
                    $('#mdg_tipo_garantia').trigger("chosen:updated");


                    $("#mdg_moneda option[value=" + response[0].Moneda + "]").prop("selected", true);

                    // se hailitara
                    $('#mdg_moneda').prop("disabled",false);
                    $('#mdg_moneda').trigger("chosen:updated");

                    $("#mdg_banco option[value=" + response[0].CodigoBanco + "]").prop("selected", true);
                    // se hailitara
                    $('#mdg_banco').prop("disabled",false);
                    $('#mdg_banco').trigger("chosen:updated");



                    let sub_arreglo = ["PRO","PND","LIT","LIP","COB","REN","POS"];


                    for(let j=0;j<sub_arreglo.length;j++){

                        $('#mdg_estado option[value="'+sub_arreglo[j]+'"]').attr("disabled", false); 

                    }

                    const estado_seleccionado_garantia = response[0].Estado;


                    $("#mdg_estado option[value=" + response[0].Estado + "]").prop("selected", true);
                
                    // for(let i=0;i<sub_arreglo.length;i++){

                    //     if(sub_arreglo[i]!=estado_seleccionado_garantia){

                    //         $('#mdg_estado option[value="'+sub_arreglo[i]+'"]').attr("disabled", true); 
                    //     }
                    

                    // }
                    // //se habilitar
                    $('#mdg_estado').prop("disabled",false);
                    $('#mdg_estado').trigger("chosen:updated");

                }

                




            } else {

                //si no encuentra garantia 0 resultados
                console.log('sin datos garantia')
                let porcentaje_aux = $("#mcf_monto").attr("data-porcentaje");
                let monto_fianza_aux = $("#mcf_monto").val();

                let monto_gar_aux = parseFloat(porcentaje_aux*monto_fianza_aux/100).toFixed(2);


                $("#hidden_id_garantia_last").val(0);

                $("#mdg_porcentaje").val(porcentaje_aux);
                $("#mdg_porcentaje").attr("readonly",false);

                $("#mdg_monto_fianza").val(monto_fianza_aux);
                

                $("#mdg_monto_garantia").val(monto_gar_aux);
                

                $("#mdg_n_tipo_garantia").val("");
                $("#mdg_n_tipo_garantia").attr("readonly",false);

                $("#mdg_fecha_emision").val("");
                $("#mdg_fecha_emision").attr("readonly",false);

                $("#mdg_vencimiento").val("");
                

                $("#mdg_obs").val("");
                $("#mdg_obs").attr("readonly",false);

                //habilitamos
                    //$('#mdg_estado').prop("disabled",false);
                    //$('#mdg_estado').trigger("chosen:updated");

                    $("#mdg_tipo_garantia option[value='CD']").prop("selected", true);
                    //habilitamos
                    $('#mdg_tipo_garantia').prop("disabled",false);
                    $('#mdg_tipo_garantia').trigger("chosen:updated");

                    $("#mdg_banco option[value='01']").prop("selected", true);
                    //habilitamos
                    $('#mdg_banco').prop("disabled",false);
                    $('#mdg_banco').trigger("chosen:updated");

                    $("#mdg_moneda option[value='SOL']").prop("selected", true);
                    //habilitamos
                    $('#mdg_moneda').prop("disabled",false);
                    $('#mdg_moneda').trigger("chosen:updated");

                    let est_garantias = ["PRO","PND","LIT","LIP","COB","REN","POS"];


                    for(let j=0;j<est_garantias.length;j++){

                        $('#mdg_estado option[value="'+est_garantias[j]+'"]').attr("disabled", false); 
                        
                    }

                    $("#mdg_estado option[value='PND']").prop("selected", true);


                    for(let i=0;i<est_garantias.length;i++){

                        if(est_garantias[i]!='PND'){

                            $('#mdg_estado option[value="'+est_garantias[i]+'"]').attr("disabled", true);
                        }

                        
                    }
                    $('#mdg_estado').prop("disabled",false);
                    $('#mdg_estado').trigger("chosen:updated");

            }


        },
        error: function(jqXHR, textStatus, errorThrown) {

            $.unblockUI();

            ajaxError(jqXHR, textStatus, errorThrown);



        }

    });

}


function get_detalle_carta_fianza(idCartaFianza) {


    $.ajax({
        url: server + 'get_detalle_carta_fianza',
        type: "get",
        dataType: 'json',
        data: {
            _token: '{{ csrf_token() }}',
            idCartaFianza: idCartaFianza


        },
        before: function() {

        },
        success: function(response) {

            $.unblockUI();

            if (response.length > 0) {

                console.log(response);

                
                $("#mcf_name_obra").val(response[0].ObraFullName);
                $("#mcf_tipo_carta").val(response[0].DescTipoCarta);
                $("#tipo_carta_mcf_hidden").val(response[0].TipoCarta);
                $("#id_mcf_id_solicitud").val(response[0].IdSolicitud);
                $("#id_mcf_hidden").val(idCartaFianza);
                $("#mcf_cliente").val(response[0].ClienteName);
                $("#mcf_contratante").val(response[0].BeneficiarioName);
                $("#mcf_entidad_financiera").val(response[0].FinancieraName);
                $("#mcf_solicitud").val(response[0].CodigoSolicitud);



                $("#hidden_carta_idfinanciero").val(response[0].IdFinanciera);

                $("#mcf_file").val(response[0].CodigoObra);

                $("#mcf_fianza").val(response[0].IdCartaFianzaDetalle);

                $("#mcf_monto").val(response[0].Monto);
                $("#mfc_fecha").val(response[0].FechaCreacion);
                $("#mfc_fecha_inicio").val(response[0].FechaInicio);
                $("#mfc_vencimiento").val(response[0].FechaVence);
                $("#mfc_dias").val(response[0].Dias);
                $("#mfc_renovacion").val(response[0].CartaAnterior);

                $("#mfc_observacion").val(response[0].Comentario);
                $("#mfc_carta_manual").val(response[0].CodigoCarta);

                $("#mcf_moneda option[value=" + response[0].CodigoMoneda + "]").prop("selected", true);

                $('#mcf_moneda').trigger("chosen:updated");

                if (response[0].DocumentoElectronico != null) {

                    $('#table-documentos-gestion-documentos tbody tr').find("td").next("td").find("a").attr("data-file", response[0].DocumentoElectronico);

                    $('#table-documentos-gestion-documentos tbody tr').find("td").next("td").find("a").css("display", "block");

                } else {

                    $('#table-documentos-gestion-documentos tbody tr').find("td").next("td").find("a").attr("data-file", "");

                    $('#table-documentos-gestion-documentos tbody tr').find("td").next("td").find("a").css("display", "none");
                }

                const carta_gestionada = response[0].FlagGestionCarta;

                if(carta_gestionada == 1){

                    $("#mcf_monto").attr("data-gestion",1);

                }else{

                    $("#mcf_monto").attr("data-gestion",0);
                }

                $("#mcf_monto").attr("data-porcentaje",response[0].GarantiaCheque);


                let sub_arreglo = ["PRO","VIG","VEN","ANL","REN","CER"];


                for(let j=0;j<sub_arreglo.length;j++){

                    $('#mcf_estado option[value="'+sub_arreglo[j]+'"]').attr("disabled", false); 

                }

                $("#mcf_estado option[value=" + response[0].EstadoCF + "]").prop("selected", true);

                let estado_seleccionado_carta = response[0].EstadoCF;

                if(carta_gestionada == 1){

                    for(let i=0;i<sub_arreglo.length;i++){

                       if(sub_arreglo[i] != estado_seleccionado_carta){

                            $('#mcf_estado option[value="'+sub_arreglo[i]+'"]').attr("disabled", true);
                        }

                    }

                }

                $('#mcf_estado').trigger("chosen:updated");

                //response[0].NumeroCarta != null

                //console.log(response[0].NumeroCarta.length)
                

                if (response[0].NumeroCarta != null ) {
                    //si tiene numero de carta

                    const gestionada = carta_gestionada;

                    get_detalle_carta_fianza_garantia(response[0].NumeroCarta,gestionada);

                } else {
                    console.log('sin gestionar y sin garantia')
                    //sin gestionar y no tiene garantia
                    $("#mdg_porcentaje").val(response[0].GarantiaCheque);
                    //habilitamos
                    $("#mdg_porcentaje").attr("readonly",false);
                    $("#mdg_monto_fianza").val(response[0].Monto);
                    $("#mdg_monto_garantia").val(response[0].GarantiaMonto);

                    $("#hidden_id_garantia_last").val(0);
                    $("#mdg_n_tipo_garantia").val("");
                    //habilitamos
                    $("#mdg_n_tipo_garantia").attr("readonly",false);
                    $("#mdg_fecha_emision").val("");
                    //habilitamos
                    $("#mdg_fecha_emision").attr("readonly",false);
                    $("#mdg_vencimiento").val("");
                    $("#mdg_obs").val("");
                    //habilitamos
                    $("#mdg_obs").attr("readonly",false);



                    let est_garantias = ["PRO","PND","LIT","LIP","COB","REN","POS"];


                    for(let j=0;j<est_garantias.length;j++){

                        $('#mdg_estado option[value="'+est_garantias[j]+'"]').attr("disabled", false); 
                        
                    }

                    $("#mdg_estado option[value='PND']").prop("selected", true);


                    for(let i=0;i<est_garantias.length;i++){

                        if(est_garantias[i]!='PND'){

                            $('#mdg_estado option[value="'+est_garantias[i]+'"]').attr("disabled", true);
                        }

                        
                    }


                    //habilitamos
                    $('#mdg_estado').prop("disabled",false);
                    $('#mdg_estado').trigger("chosen:updated");

                    $("#mdg_tipo_garantia option[value='CD']").prop("selected", true);
                    //habilitamos
                    $('#mdg_tipo_garantia').prop("disabled",false);
                    $('#mdg_tipo_garantia').trigger("chosen:updated");

                    $("#mdg_banco option[value='01']").prop("selected", true);
                    //habilitamos
                    $('#mdg_banco').prop("disabled",false);
                    $('#mdg_banco').trigger("chosen:updated");

                    $("#mdg_moneda option[value='SOL']").prop("selected", true);
                    //habilitamos
                    $('#mdg_moneda').prop("disabled",false);
                    $('#mdg_moneda').trigger("chosen:updated");
                }
            }


        },
        error: function(jqXHR, textStatus, errorThrown) {

            $.unblockUI();

            ajaxError(jqXHR, textStatus, errorThrown);



        }

    });

}


$('#mcf_entidad_financiera').keyup(function() {

    let query = $(this).val();

    $('#hidden_carta_idfinanciero').val(0);

    if (query != '') {

        $.ajax({
            url: server + "get_combo_empresas",
            method: "get",
            data: {
                _token: '{{ csrf_token() }}',
                query: query,
                tipo: 'F'
            },
            success: function(data) {

                $('#financiera_list').fadeIn();
                $('#financiera_list').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                ajaxError(jqXHR, textStatus, errorThrown);

            }
        });
    }
});

$(document).on('click', '#financiera_list ul li', function() {

    let string = $(this).text();

    if (string != "no se encontraron resultados") {

        $('#mcf_entidad_financiera').val(string);
        $('#financiera_list').fadeOut();

        const id_cliente = $(this).attr('data-id');

        $('#hidden_carta_idfinanciero').val(id_cliente);


    }


});


function ver_documento_gestion_carta_fianza() {

    const file = $('#table-documentos-gestion-documentos tbody tr').find("td").next("td").find("a").attr("data-file");

    const tipo = 'documento';

    ver_file(file, tipo);
}

function ver_file(file, tipo) {

    let directorio = '';

    if (tipo == 'documento') {

        directorio = '/documentos_carta_fianza/';

    } else if (tipo == 'obra') {

        directorio = '/file_avance_obra/';

    }

    let file_array = file.split(".");

    let extension = file_array[1];

    if (extension == 'pdf' || extension == 'docx' || extension == 'xlsx') {

        var PdfFile = file;

        $("#tituloTipoArchivo").html('<i class="fa file-pdf-o"></i> Ver archivo adjunto - Tipo <i class="far fa-hand-point-right"></i> ' + extension);

        if (extension == 'pdf') {

            $("#ModalVerAdjuntos").modal('show');

        } else {

            $("#ModalVerAdjuntos").modal('hide');
        }


        $('#ObjPdf3').attr('src', server + directorio + PdfFile);
        $('#divPdf').show();
        $('#divImagen').hide();

    } else {

        $("#tituloTipoArchivo").html('<i class="fa fa-photo"></i> Ver archivo adjunto - Tipo <i class="far fa-hand-point-right"></i> ' + extension);

        $("#ModalVerAdjuntos").modal('show');
        var ImgFile = file;
        $('#divPdf').hide();
        $('#divImagen').show();

        $('#imgAdjunta').attr('src', server + directorio + ImgFile);

    }
}

$('#mfc_fecha_inicio').on('change', function() {


    const fecha_inicio = $(this).val();

    const dias_adicionar = $('#mfc_dias').val();

    const fecha_fin = (dias_adicionar.length != 0) ? sumar_dias_fecha(fecha_inicio, dias_adicionar) : '';

    $('#mfc_vencimiento').val(fecha_fin);
})


$('#mfc_dias').on('keyup', function() {

    const fecha_inicio = $('#mfc_fecha_inicio').val();

    if (fecha_inicio.length == 0) {

        alertify.error("Seleccione una fecha de inicio");

        $('#mfc_dias').val('');

    } else {

        const dias_adicionar = $('#mfc_dias').val();

        const fecha_fin = (dias_adicionar.length != 0) ? sumar_dias_fecha(fecha_inicio, dias_adicionar) : '';

        $('#mfc_vencimiento').val(fecha_fin);
    }


})




$('#mcf_monto').on('keyup', function() {

    const value = $(this).val();

    const data_gestion = $(this).attr("data-gestion");

    if(data_gestion == 0){

        $('#mdg_monto_fianza').val(parseFloat(value).toFixed(2));

        const porcentaje = $('#mdg_porcentaje').val();

        const monto_garantia = (porcentaje / 100) * value;

        $('#mdg_monto_garantia').val(parseFloat(monto_garantia).toFixed(2));

    }

    


})

function recalcula_monto_garantia() {

    const value = $('#mdg_monto_fianza').val();

    const porcentaje = $('#mdg_porcentaje').val();

    const monto_garantia = (porcentaje / 100) * value;

    $('#mdg_monto_garantia').val(parseFloat(monto_garantia).toFixed(2));

}


$('#mdg_fecha_emision').on('change', function() {


    const fecha_inicio = $(this).val();

    const tipo_garantia = $("#mdg_tipo_garantia").val();

    let dias_adicionar = 1;

    if (tipo_garantia == "CD" || tipo_garantia == "CH") {

        dias_adicionar = $('#DiasCobroChequeParamGral').val();

    } else if (tipo_garantia == "DE") {

        dias_adicionar = 0;

    }


    const fecha_fin = (dias_adicionar.length != 0) ? sumar_dias_fecha(fecha_inicio, dias_adicionar) : '';

    $('#mdg_vencimiento').val(fecha_fin);
})



$('#mdg_tipo_garantia').on('change', function() {

    const tipo_garantia = $(this).val();

    if ($('#mdg_fecha_emision').val() != "") {

        let dias_adicionar = 1;

        if (tipo_garantia == "CD" || tipo_garantia == "CH") {

            dias_adicionar = $('#DiasCobroChequeParamGral').val();

        } else if (tipo_garantia == "DE") {

            dias_adicionar = 0;

        }

        const fecha_inicio = $('#mdg_fecha_emision').val();

        const fecha_fin = (dias_adicionar.length != 0) ? sumar_dias_fecha(fecha_inicio, dias_adicionar) : '';

        $('#mdg_vencimiento').val(fecha_fin);

    }

    //al ser deposito el estado cobrado cia se activará

    if(tipo_garantia == "DE"){

        $('#mdg_estado option[value="COB"]').attr("disabled", false);
        $('#mdg_estado').trigger("chosen:updated");

    }else{

        $('#mdg_estado option[value="COB"]').attr("disabled", true);
        $('#mdg_estado').trigger("chosen:updated");
    }
    



})

function valida_formulario_gestion_carta() {


    let msj = '';

    const gestionada = $('#mcf_monto').attr('data-gestion');

    const estado = $('#mcf_estado').val();

    if(gestionada == 0 && estado =='ANL'){

        //solo valida monto y numero de carta

        if ($('#mcf_monto').val().trim() == "") {

            return 'Ingrese un monto';

        }


        if ($('#mfc_carta_manual').val().trim() == "") {

            return 'Ingrese número para la carta';

        }

        return msj;


    }else{


        if ($('#hidden_carta_idfinanciero').val() == 0) {

            return 'Ingrese una financiera';

        }

        if ($('#mcf_monto').val().trim() == "") {

            return 'Ingrese un monto';

        }

        if ($('#mfc_carta_manual').val().trim() == "") {

            return 'Ingrese número para la carta';

        }
        
        if ($('#mfc_fecha_inicio').val().trim() == "") {

            return 'Ingrese una fecha de inicio';

        }

        if ($('#mfc_dias').val().trim() == "") {

            return 'Ingrese número de dias';

        }

        //validacion para garantia

        if ($('#mdg_n_tipo_garantia').val().trim() == "") {

            return 'Ingrese número para la garantía';

        }

        if ($('#mdg_porcentaje').val().trim() == "" || $('#mdg_porcentaje').val() == 0) {

            return 'Ingrese un % válido para la garantía';

        }

        if ($('#mdg_fecha_emision').val().trim() == "") {

            return 'Ingrese una fecha de emisión para la garantía';

        }

        return msj;




    }

}


$("#form_gestion_carta_fianza").submit(function(event) {

    event.preventDefault();

    const rpta = valida_formulario_gestion_carta();

    if (rpta == '') {

        let formData = new FormData(document.getElementById("form_gestion_carta_fianza"));

        const mdg_monto_fianza = $('#mdg_monto_fianza').val();

        const mdg_monto_garantia = $('#mdg_monto_garantia').val();

        const mdg_tipo_garantia = $('#mdg_tipo_garantia').val();

        const mdg_porcentaje = $('#mdg_porcentaje').val();

        const mdg_n_tipo_garantia = $('#mdg_n_tipo_garantia').val();

        const mdg_banco = $('#mdg_banco').val();

        const mdg_moneda = $('#mdg_moneda').val();

        const mdg_fecha_emision = $('#mdg_fecha_emision').val();

        const mdg_vencimiento = $('#mdg_vencimiento').val();

        const mdg_estado = $('#mdg_estado').val();

        const mdg_obs = $('#mdg_obs').val();

        const mdg_id_registro_garantia = $("#hidden_id_garantia_last").val();

        formData.append('mdg_monto_fianza', mdg_monto_fianza);

        formData.append('mdg_monto_garantia', mdg_monto_garantia);

        formData.append('mdg_tipo_garantia', mdg_tipo_garantia);

        formData.append('mdg_porcentaje', mdg_porcentaje);

        formData.append('mdg_n_tipo_garantia', mdg_n_tipo_garantia);

        formData.append('mdg_banco', mdg_banco);

        formData.append('mdg_moneda', mdg_moneda);

        formData.append('mdg_fecha_emision', mdg_fecha_emision);

        formData.append('mdg_vencimiento', mdg_vencimiento);

        formData.append('mdg_estado', mdg_estado);

        formData.append('mdg_obs', mdg_obs);

        formData.append('mdg_id_registro_garantia', mdg_id_registro_garantia);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: server + 'save_carta_fianza',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function() {

                $("#btn_save_modal_cf").attr("disabled",true);
                
            },
            success: function(response) {

                console.log(response);

                if (response.status == "ok") {

                    alertify.success(set_sucess_message_alertify(response.description));

                    const url = server + "gestion_carta_fianza";

                    setTimeout($(location).attr('href', url), 10000);

                } else {


                    alertify.error(set_error_message_alertify(response.description));
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {

                ajaxError(jqXHR, textStatus, errorThrown);


            },complete:function(){

                $("#btn_save_modal_cf").attr("disabled",false);
            }

        });


    } else {

        alertify.error(set_error_message_alertify(rpta));
    }


});





$("#btn_close_modal_cf").on('click', function(e) {

    e.preventDefault();

    $("#modal_gestionar_carta").modal("hide");

});

function upload_documento_gestion_carta_fianza() {


    $("#modal-file-upload").modal("show");

    const id_carta = $("#id_mcf_hidden").val();

    $("#id_carta_fianza_documento").val(id_carta);

}

$('#btn_subir_file_gestion_documento').on('click', function() {

    let cantidad_files = dropzoneGestionDoc.getQueuedFiles().length;

    if (cantidad_files > 0) {

        dropzoneGestionDoc.processQueue();

    } else {

        alertify.error('Seleccione algun archivo');
    }

})



Dropzone.autoDiscover = false;

var dropzoneGestionDoc = new Dropzone('#dropzoneGestionDoc', {
    maxFiles: 1,
    maxFilesize: 12,
    autoProcessQueue: false,
    acceptedFiles: ".jpeg,.jpg,.png,.pdf,.docx,.xlsx",

    dictFallbackMessage: "Su navegador no admite la función de arrastrar y soltar.",
    dictFileTooBig: "El archivo es demasiado grande, Máx: 12 MB.",
    dictInvalidFileType: "No puedes subir este tipo de archivo (solo extensiones:.jpeg,.jpg,.png,.pdf,.docx,.xlsx).",
    dictResponseError: "Server responded with {{statusCode}} code.",
    dictCancelUpload: "Cancelar carga",
    dictRemoveFile: "Remover archivo",
    dictMaxFilesExceeded: "Solo puede subir un archivo.",
    timeout: 5000,

    init: function() {
        this.on("processing", function(file) {
            this.options.url = server + 'subir_documento_gestion_carta_fianza';
        });
    },

    success: function(file, response) {
        console.log(response);

        if (response.status == "ok") {

            actualiza_tabla_documentos_fianza(response.data);

            alertify.success(set_sucess_message_alertify(response.description));

            dropzoneGestionDoc.removeAllFiles();

            $("#modal-file-upload").modal("hide");

        } else {

            alertify.error(set_error_message_alertify(response.description));
        }

        $.unblockUI();

    },
    error: function(file, response) {

        alertify.error(response);


        dropzoneGestionDoc.removeAllFiles();

        $.unblockUI();
    }
})

function actualiza_tabla_documentos_fianza(file) {

    $('#table-documentos-gestion-documentos tbody tr').find("td").next("td").find("a").attr("data-file", file);

    $('#table-documentos-gestion-documentos tbody tr').find("td").next("td").find("a").css("display", "block");
}

function elimina_documento_gestion_carta_fianza() {

    const file = $('#table-documentos-gestion-documentos tbody tr').find("td").next("td").find("a").attr("data-file");

    elimina_file_gestion_carta_fianza(file);


}

function elimina_file_gestion_carta_fianza(file) {

    $.ajax({
        url: server + 'elimina_file_gestion_carta_fianza',
        type: "post",

        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            file: file,
            id_carta: $("#id_mcf_hidden").val()
        },
        before: function() {

        },
        success: function(response) {


            if (response.status == "ok") {


                $('#table-documentos-gestion-documentos tbody tr').find("td").next("td").find("a").attr("data-file", "");

                $('#table-documentos-gestion-documentos tbody tr').find("td").next("td").find("a").css("display", "none");

                alertify.success(set_sucess_message_alertify(response.description));

            } else {

                alertify.error(set_error_message_alertify(response.description));
            }


        },
        error: function(jqXHR, textStatus, errorThrown) {

            ajaxError(jqXHR, textStatus, errorThrown);

        }

    });
}


function prepare_modal_renovar_cf(idCartaFianza) {

    $("#tab-datos-renovacion-cf").click();
    $("#modal_renovar_carta").modal("show");
    reset_inputs_renovacion();
    set_datos_renovacion_carta_fianza(idCartaFianza);

}


function prepare_modal_renovar_garantia_det(idCartaFianza) {

    $("#modal_renovar_garantias_garantias").modal("show");

    set_datos_renovacion_garantia(idCartaFianza);

    reseta_inputs_renovacion_garantias();

    bloquea_inputs_renovar_garantia();
}