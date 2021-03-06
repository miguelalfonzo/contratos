$(document).ready(function() {



});

function reset_inputs_renovacion() {



    $("#mdr_fianza").val("");
    $("#mdr_monto").val("");

    $("#mdr_fecha").val(resetea_fechas());
    $("#mdr_fecha_inicio").val("");
    $("#mdr_dias").val("");
    $("#mdr_vencimiento").val("");



}



function set_datos_renovacion_carta_fianza(idCartaFianza) {

    
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


                $("#mdr_hidden_cliente").val(response[0].IdCliente);
                $("#mdr_hidden_beneficiario").val(response[0].IdBeneficiario);
                $("#mdr_hidden_financiera").val(response[0].IdFinanciera);
                $("#mdr_hidden_idSolicitud").val(response[0].IdSolicitud);
                $("#mdr_hidden_idCartaFianza").val(idCartaFianza);


                $("#mdr_cliente").val(response[0].ClienteName);
                $("#mdr_beneficiario").val(response[0].BeneficiarioName);
                $("#mdr_entidad_financiera").val(response[0].FinancieraName);
                $("#mdr_tipo_mon_cf_old").val(response[0].CodigoMoneda);
                $("#mdr_moneda_cf_old").val(numero_a_formato_numerico(response[0].Monto));


                $("#mdr_cmbtipo_fianza option[value=" + response[0].TipoCarta + "]").prop("selected", true);

                $('#mdr_cmbtipo_fianza').trigger("chosen:updated");

                $("#mdr_solicitud").val(response[0].CodigoSolicitud);


                $("#mdr_estado option[value=" + response[0].EstadoCF + "]").prop("selected", true);

                $('#mdr_estado').trigger("chosen:updated");


                $("#mdr_cmb_moneda option[value=" + response[0].CodigoMoneda + "]").prop("selected", true);

                $('#mdr_cmb_moneda').trigger("chosen:updated");


                $("#mdr_interno").val(response[0].CodigoObra);

                $("#mdr_renovacion").val(response[0].NumeroRenovacion);


                $('#table-renovacion-carta tbody tr').find("td").next("td").find("a").attr("data-file", "");

                $('#table-renovacion-carta tbody tr').find("td").next("td").find("a").css("display", "none");


                get_list_garantias_relacionadas(response[0].IdSolicitud, response[0].TipoCarta);

                get_list_fianzas_relacionadas(response[0].IdSolicitud, response[0].TipoCarta);

            }


        },
        error: function(jqXHR, textStatus, errorThrown) {

            $.unblockUI();

            ajaxError(jqXHR, textStatus, errorThrown);



        }

    });

}

function get_list_garantias_relacionadas(codigoSolicitud, TipoFianza) {

    destroy_data_table('tabla-renovacion-garantia-relacionada');

    var dataTable = $('#tabla-renovacion-garantia-relacionada').DataTable({
        ajax: {
            url: server + 'get_list_garantias_relacionadas',
            type: 'GET',
            data: {
                codigoSolicitud: codigoSolicitud,
                TipoFianza: TipoFianza
            },
            dataSrc: '',
            beforeSend: function() {
                // loadingUI('cargando');
            },
            error: function(jqXHR, textStatus, errorThrown) {

                ajaxError(jqXHR, textStatus, errorThrown);
                console.log(jqXHR);
                // $.unblockUI();
            }
        },
        "initComplete": function(settings, json) {
            // $.unblockUI();
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
        "sort":false,
        columns: [{
            data: 'FechaSistemaCreacion'
        }, {
            data: 'GarantiaDescripcion'
        }, {
            data: 'NumeroDocumento'
        }, {
            data: 'MontoCarta',
            render: $.fn.dataTable.render.number(',', '.', 2, '')
        }, {
            data: 'Porcentaje'
        }, {
            data: 'Monto',
            render: $.fn.dataTable.render.number(',', '.', 2, '')
        }, {
            data: 'FechaEmision'
        }, {
            data: 'FechaVencimiento'
        }, {
            data: 'FechaCobro'
        }, {
            data: 'Disponible'
        }, {
            data: 'Estado'
        }]


    });



}


function get_list_fianzas_relacionadas(codigoSolicitud, TipoFianza) {

    destroy_data_table('tabla-renovacion-fianzas-relacionada');

    var dataTable = $('#tabla-renovacion-fianzas-relacionada').DataTable({
        ajax: {
            url: server + 'get_list_fianzas_relacionadas',
            type: 'GET',
            data: {
                codigoSolicitud: codigoSolicitud,
                TipoFianza: TipoFianza
            },
            dataSrc: '',
            beforeSend: function() {
                // loadingUI('cargando');
            },
            error: function(jqXHR, textStatus, errorThrown) {

                ajaxError(jqXHR, textStatus, errorThrown);
                console.log(jqXHR);
                // $.unblockUI();
            }
        }, "sort": false,
        "initComplete": function(settings, json) {
            // $.unblockUI();
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
        columns: [{
            data: 'CodigoCarta'
        }, {
            data: 'TipoCarta'
        }, {
            data: 'CodigoMoneda'
        }, {
            data: 'Monto',
            render: $.fn.dataTable.render.number(',', '.', 2, '')
        }, {
            data: 'CFAnterior'
        }, {
            data: 'FechaInicio'
        }, {
            data: 'FechaVence'
        }, {
            data: 'FechaRenovacion'
        }, {
            data: 'EstadoCF'
        }]


    });



}

function ver_documento_avance_obra() {


    const file = $('#table-renovacion-carta tbody tr').find("td").next("td").find("a").attr("data-file");

    const tipo = 'obra';

    ver_file(file, tipo);


}


function upload_documento_avance_obra() {



    $("#modal-file-upload-avance").modal("show");


}

$('#btn_subir_file_avance_obra').on('click', function() {

    let cantidad_files = dropzoneAvanceObra.getQueuedFiles().length;

    if (cantidad_files > 0) {

        dropzoneAvanceObra.processQueue();

    } else {

        alertify.error('Seleccione algun archivo');
    }

})



var dropzoneAvanceObra = new Dropzone('#dropzoneAvanceObra', {
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
            this.options.url = server + 'subir_documento_avance_obra';
        });
    },

    success: function(file, response) {
        console.log(response);

        if (response.status == "ok") {

            actualiza_tabla_documentos_avance_obra(response.data);

            alertify.success(set_sucess_message_alertify(response.description));

            dropzoneAvanceObra.removeAllFiles();

            $("#modal-file-upload-avance").modal("hide");

        } else {

            alertify.error(set_error_message_alertify(response.description));
        }

        $.unblockUI();

    },
    error: function(file, response) {

        alertify.error(response);


        dropzoneAvanceObra.removeAllFiles();

        $.unblockUI();
    }
})


function actualiza_tabla_documentos_avance_obra(file) {

    $('#table-renovacion-carta tbody tr').find("td").next("td").find("a").attr("data-file", file);

    $('#table-renovacion-carta tbody tr').find("td").next("td").find("a").css("display", "block");
}


function elimina_documento_avance_obra() {

    const file = $('#table-renovacion-carta tbody tr').find("td").next("td").find("a").attr("data-file");

    elimina_file_avance_obra(file);



}

function elimina_file_avance_obra(file) {

    $.ajax({
        url: server + 'elimina_file_avance_obra',
        type: "post",

        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            file: file
        },
        before: function() {

        },
        success: function(response) {


            if (response.status == "ok") {


                $('#table-renovacion-carta tbody tr').find("td").next("td").find("a").attr("data-file", "");

                $('#table-renovacion-carta tbody tr').find("td").next("td").find("a").css("display", "none");

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

function valida_inputs_renovar_carta() {

    let msj = '';

    if ($('#mdr_fianza').val().trim() == "") {

        return 'Ingrese un número de carta';

    }

    if ($('#mdr_monto').val().trim() == "" || $('#mdr_monto').val() == 0) {

        return 'Ingrese un monto para la renovación';

    }

    if ($('#mdr_fecha_inicio').val() == "") {

        return 'Ingrese una fecha de inicio para la carta';

    }

    if ($('#mdr_dias').val().trim() == "") {

        return 'Ingrese un número de dias';

    }

    if ($('#mdr_vencimiento').val().trim() == "") {

        return 'Fecha de vencimiento inválida';

    }

    return msj;

}






$("#form_renovar_carta").submit(function(event) {

    event.preventDefault();

    const rpta = valida_inputs_renovar_carta();

    if (rpta == '') {

        let formData = new FormData(document.getElementById("form_renovar_carta"));

        const file_avance_obra = $('#table-renovacion-carta tbody tr').find("td").next("td").find("a").attr("data-file");

        formData.append('file_avance_obra', file_avance_obra);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: server + 'renovar_carta_fianza',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function() {

                $("#mdr_guardar_renovar_cf").attr("disabled",true);

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

                $("#mdr_guardar_renovar_cf").attr("disabled",false);
            }

        });


    } else {

        alertify.error(set_error_message_alertify(rpta));
    }


});




$('#mdr_dias').on('keyup', function() {

    const fecha_inicio = $('#mdr_fecha_inicio').val();

    if (fecha_inicio.length == 0) {

        alertify.error("Seleccione una fecha de inicio");

        $('#mdr_dias').val('');

    } else {

        const dias_adicionar = $('#mdr_dias').val();

        const fecha_fin = (dias_adicionar.length != 0) ? sumar_dias_fecha(fecha_inicio, dias_adicionar) : '';

        $('#mdr_vencimiento').val(fecha_fin);
    }


})


function set_datos_renovacion_garantia(IdCartaFianza) {

    destroy_data_table('table-modificar-montos-garantias');

    var dataTable = $('#table-modificar-montos-garantias').DataTable({
        ajax: {
            url: server + 'set_datos_renovacion_garantia',
            type: 'GET',
            data: {
                IdCartaFianza: IdCartaFianza
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
        "sort": false, 
        columns: [{
            data: 'FechaSistemaCreacion'
        }, {
            data: 'GarantiaDescripcion'
        }, {
            data: 'NumeroDocumento'
        }, {
            data: 'MontoCarta',
            render: $.fn.dataTable.render.number(',', '.', 2, '')
        }, {
            data: 'Porcentaje'
        }, {
            data: 'Monto',
            render: $.fn.dataTable.render.number(',', '.', 2, '')
        }, {
            data: 'FechaEmision'
        }, {
            data: 'FechaVencimiento'
        }, {
            data: 'FechaCobro'
        }, {
            data: 'Disponible'
        }, {
            data: 'Estado'
        }, {
            data: null,
            "render": function(data, type, full, meta) {

                const btn_edit = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize"  href="" onclick="set_inputs_datos_renovacion('+data.IdCartaFianzaGarantia+');return false"title="Seleccionar"><span style="font-size:80%;" class="text-success glyphicon glyphicon-edit"></span></a>';


                return '<div class="btn-group"> ' + btn_edit + '</div>';

            }
        },{
            data: null,
            "render": function(data, type, full, meta) {

                
                return '<div class="btn-group"> ' +  + '</div>';

            }
        }], columnDefs: [{
            
        }], rowCallback: function(row, data) {

            const id = data.IdCartaFianzaGarantia;

            $($(row).find("td")[12]).html('<span id="span_render_check_'+id+'" style="text-align:center; font-size:135%;" class="btn btn-default btn_resize text-success span-check"></span>');

        },"drawCallback": function(settings) {

            $('[data-toggle="tooltip"]').tooltip();


        }


    });


}

function cierra_modal_renovar_garantias(){

 $("#modal_renovar_garantias_garantias").modal('hide');

}


function delete_icon_check_table_garantias(){

    $(".span-check").removeClass("glyphicon glyphicon-ok-sign");
}

function set_inputs_datos_renovacion(IdCartaFianzaGarantia){

     loadingUI('cargando');

     delete_icon_check_table_garantias();
     
     $("#span_render_check_"+IdCartaFianzaGarantia).addClass("glyphicon glyphicon-ok-sign");
     
    $.ajax({
        url: server + 'set_inputs_datos_renovacion',
        type: "get",

        data: {
            _token: '{{ csrf_token() }}',
            IdCartaFianzaGarantia: IdCartaFianzaGarantia
        },
        before: function() {

        },
        success: function(response) {

            $.unblockUI();
            
            if (response.length>0) {

                console.log(response)
                
                $("#ren_car_gar_idgarantia").val(IdCartaFianzaGarantia);
                $("#ren_car_gar_fecha").val(response[0]["FechaSistemaCreacion"]);
                $("#ren_car_gar_monto_fianza").val(response[0]["MontoCarta"]);
                $("#ren_car_gar_emision").val(response[0]["FechaEmision"]);

                

                $("#ren_car_gar_tipo_pago option[value=" + response[0].TipoGarantia + "]").prop("selected", true);
                $('#ren_car_gar_tipo_pago').trigger("chosen:updated");

                $("#ren_car_gar_numero").val(response[0]["NumeroDocumento"]);
                $("#ren_car_gar_porcentaje").val(response[0]["Porcentaje"]);

                

                $("#ren_car_gar_moneda option[value=" + response[0].Moneda + "]").prop("selected", true);
                $('#ren_car_gar_moneda').trigger("chosen:updated");


                $("#ren_car_gar_vencimiento").val(response[0]["FechaVencimiento"]);


                $("#ren_car_gar_bancos option[value=" + response[0].CodigoBanco + "]").prop("selected", true);
                $('#ren_car_gar_bancos').trigger("chosen:updated");


                $("#ren_car_gar_monto").val(response[0]["Monto"]);
                $("#ren_car_gar_cobro").val(response[0]["FechaCobro"]);


                $("#ren_car_gar_estados_gar option[value=" + response[0].Estado + "]").prop("selected", true);
                $('#ren_car_gar_estados_gar').trigger("chosen:updated");



                $("#ren_car_gar_disponible").val(response[0]["Disponible"]);
                $("#ren_car_gar_liberar").val("");

                $("#ren_car_gar_obs").val(response[0]["Observaciones"]);
                
                

                $("#ren_car_gar_disponible").attr("data-disponible",response[0]["Disponible"]);
                $("#ren_car_gar_monto").attr("data-monto",response[0]["Monto"]);
                $("#ren_car_gar_monto_fianza").attr("data-mofianza",response[0]["MontoCarta"]);
                $("#ren_car_gar_porcentaje").attr("data-porcentaje",response[0]["Porcentaje"]);
               

            } 


        },
        error: function(jqXHR, textStatus, errorThrown) {
             $.unblockUI();
            ajaxError(jqXHR, textStatus, errorThrown);

        }

    });


}





function valida_inputs_renovar_garantia(){

let msj='';


    

if($("#ren_car_gar_idgarantia").val()==0){

    return 'Seleccione una garantía';
 }


 if($("#ren_car_gar_fecha").val()==""){

    return 'Ingrese una fecha';
 }

 if($("#ren_car_gar_monto_fianza").val().trim()==""){

    return 'Ingrese un monto de fianza';
 }

 if($("#ren_car_gar_emision").val()==""){

    return 'Ingrese una fecha de emisión';
 }

 if($("#ren_car_gar_numero").val().trim()==""){

    return 'Ingrese un número para la garantía';
 }

 if($("#ren_car_gar_porcentaje").val().trim()==""  || $("#ren_car_gar_porcentaje").val()==0){

    return 'Ingrese un porcentaje ';
 }
 if($("#ren_car_gar_vencimiento").val()==""){

    return 'Ingrese una fecha de vencimiento';
 }

 if($("#ren_car_gar_monto").val().trim()=="" || $("#ren_car_gar_monto").val()==0){

    return 'Ingrese un monto para la garantía';
 }


 if($("#ren_car_gar_cobro").val()==""){

    return 'Ingrese una fecha de cobro';
 }

 // if($("#ren_car_gar_disponible").val().trim()==""){

 //    return 'Ingrese un monto disponible';
 // }
return msj;

}



$("#form_renovar_garantia").submit(function(event) {

    event.preventDefault();

    const rpta = valida_inputs_renovar_garantia();

    if (rpta == '') {

        let formData = new FormData(document.getElementById("form_renovar_garantia"));

        

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: server + 'save_renovacion_garantia',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function() {

                $("#btn_save_renovar_garantia").attr("disabled",true);
                
            },
            success: function(response) {


               

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

                $("#btn_save_renovar_garantia").attr("disabled",false);
            }

        });


    } else {

        alertify.error(set_error_message_alertify(rpta));
    }


});


function recalcula_montos_renovar_garantia(){


    const monto_fianza = $("#ren_car_gar_monto_fianza").val();
    const porcentaje   = $("#ren_car_gar_porcentaje").val();
    const valor_final = parseFloat(monto_fianza*porcentaje/100).toFixed(2);
    $("#ren_car_gar_monto").val(valor_final);
}


function reseta_inputs_renovacion_garantias(){


    $("#ren_car_gar_idgarantia").val(0);
    $("#ren_car_gar_fecha").val("");
    $("#ren_car_gar_monto_fianza").val("");
    $("#ren_car_gar_emision").val("");


    $("#ren_car_gar_tipo_pago option[value='CD']").prop("selected", true);
    $('#ren_car_gar_tipo_pago').trigger("chosen:updated");

    $("#ren_car_gar_numero").val("");
    $("#ren_car_gar_porcentaje").val("");

                
    $("#ren_car_gar_moneda option[value='SOL']").prop("selected", true);
    $('#ren_car_gar_moneda').trigger("chosen:updated");


    $("#ren_car_gar_vencimiento").val("");


    $("#ren_car_gar_bancos option[value='01']").prop("selected", true);
    $('#ren_car_gar_bancos').trigger("chosen:updated");


    $("#ren_car_gar_monto").val("");
    $("#ren_car_gar_cobro").val("");


    $("#ren_car_gar_estados_gar option[value='PRO']").prop("selected", true);
    $('#ren_car_gar_estados_gar').trigger("chosen:updated");

    $("#ren_car_gar_disponible").attr("data-disponible","");
    $("#ren_car_gar_monto").attr("data-monto","");
    
    $("#ren_car_gar_monto_fianza").attr("data-mofianza","");
    $("#ren_car_gar_porcentaje").attr("data-porcentaje","");

    $("#ren_car_gar_disponible").val("");
    $("#ren_car_gar_liberar").val("");

    $("#ren_car_gar_obs").val("");


}



$('#ren_car_gar_estados_gar').on('change', function() {

    const value = $(this).val();

    if(value=='LIP'){

        const disponible = $("#ren_car_gar_disponible").val();

        $("#ren_car_gar_liberar").val(disponible);

        $("#ren_car_gar_disponible").val("");
        
        
        const restante =   parseFloat($("#ren_car_gar_monto").val()-disponible).toFixed(2);
        
        $("#ren_car_gar_monto").val(restante);

        $("#ren_car_gar_obs").val("Se liberó parcialmente");
        

    }else {

        const old_disponible =$("#ren_car_gar_disponible").attr("data-disponible");
        const old_monto =$("#ren_car_gar_monto").attr("data-monto");


        const old_mofianza =$("#ren_car_gar_monto_fianza").attr("data-mofianza");
        const old_porcentaje =$("#ren_car_gar_porcentaje").attr("data-porcentaje");


        $("#ren_car_gar_disponible").val(old_disponible);
        $("#ren_car_gar_monto").val(old_monto);
        $("#ren_car_gar_monto_fianza").val(old_mofianza);
        $("#ren_car_gar_porcentaje").val(old_porcentaje);


        $("#ren_car_gar_liberar").val("");
        $("#ren_car_gar_obs").val("");
    }


})

function prepare_modal_cerrar_fianza(IdCartaFianza,cliente,financiera,beneficiaria,moneda,monto){

    $("#modal_cerrar_carta").modal("show");


    $("#cerrar_cf_idcarta").val(IdCartaFianza);
    $("#cerrar_cf_cliente").val(cliente);
    $("#cerrar_cf_contratante").val(beneficiaria);
    $("#cerrar_cf_financiera").val(financiera);
    
    $("#cerrar_cf_moneda").val(moneda);
    $("#cerrar_cf_monto").val(numero_a_formato_numerico(monto));
    
    $("#cerrar_cf_comentario").val('');
    

}



$("#cerrar_fianza_form").submit(function(event) {

    event.preventDefault();

    const comentario = $("#cerrar_cf_comentario").val().trim();

    if (comentario != '') {

        let formData = new FormData(document.getElementById("cerrar_fianza_form"));

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: server + 'cerrar_carta_fianza',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function() {

                $("#btn_cerrar_carta_fianza").attr("disabled",true);
                
            },
            success: function(response) {


               
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


            },complete :function(){

                $("#btn_cerrar_carta_fianza").attr("disabled",false);

            }

        });


    } else {

        alertify.error(set_error_message_alertify('Ingrese un comentario'));
    }


});