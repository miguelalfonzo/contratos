$(document).ready(function() {

    //const documento = $('#gestion_tipo_doc').val();

    const documento = '';

    //load_list_fianzas(documento);



});



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
    
    load_list_fianzas(documento,cliente,obra);

    $("#modal_filtrar_cartas").modal('hide');

    //setea cabecera de filtros

     
     const label_cliente = (cliente == 0)?' ':$("#filtrar_modal_cliente").val();

     const label_obra = (obra == 0)?' ':$("#filtrar_modal_obra").val();

     const label_carta = $("#filtrar_modal_carta option:selected").text();

     $('#filtro_cabecera_cliente').text(label_cliente.trim());

     $('#filtro_cabecera_obra').text(label_obra.trim());
    
     $('#filtro_cabecera_fianza').text(label_carta.trim());

});

function load_list_fianzas(documento,cliente,obra) {

    destroy_data_table('tabla-fianza');

    $("#buscador_general").val('');

    var dataTable = $('#tabla-fianza').DataTable({
        ajax: {
            url: server + 'get_list_fianzas',
            type: 'GET',
            data: {
                documento: documento,
                cliente:cliente,
                obra:obra

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
        columns: [{
            data: 'CodigoSolicitud'
        }, {
            data: 'FileName'
        }, {
            data: 'Carta'
        }, {
            data: 'NombreCliente'
        }, {
            data: 'CodigoObra'
        }, {
            data: 'NombreObra'
        }, {
            data: 'Moneda'
        }, {
            data: 'MontoCarta',
            render: $.fn.dataTable.render.number(',', '.', 2, '')
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




// $("#gestion_tipo_doc").on('change', function() {

//     destroy_data_table('tabla-fianza');
//     const value = $(this).val();
//     load_list_fianzas(value);
//     $("#buscador_general").val("");

// });

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

    let btn_historial;


    if (data.FlagGestionCarta == 0) {

        btn_renovar_cf = '';

        btn_renovar_garantia = '';

        btn_cerrar_carta = '';

        btn_historial='';

    } else {

        //const estados_renovar = ["VIGENTE", "PROCESO"];

        const estados_renovar = ["VIGENTE"];

        if (estados_renovar.includes(data.Estado)) {

            btn_renovar_cf = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_renovar_cf(\'' + data.IdCartaFianzaDetalle + '\')" style="cursor:pointer" title="Renovar Carta Fianza"><span style="font-size:80%;" class="text-success  glyphicon glyphicon-repeat"></span></a>';

            btn_renovar_garantia = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_renovar_garantia_det(\'' + data.IdCartaFianzaDetalle + '\')" style="cursor:pointer" title="Renovar Garantia"><span style="font-size:80%;" class="text-primary  glyphicon glyphicon-retweet"></span></a>';

            btn_cerrar_carta = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_cerrar_fianza(\'' + data.IdCartaFianzaDetalle + '\',\'' + data.NombreCliente + '\',\'' + data.NombreFinanciera + '\',\'' + data.NombreBeneficiario + '\',\'' + data.Moneda + '\',\'' + data.MontoCarta + '\')" style="cursor:pointer" title="Cerrar Carta Fianza"><span style="font-size:80%;" class="text-danger  glyphicon glyphicon-folder-close"></span></a>';

            btn_historial = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_ver_historial(\'' + data.IdCartaFianzaDetalle + '\')" style="cursor:pointer" title="Historial"><span style="font-size:80%;" class="text-warning  glyphicon glyphicon-eye-open"></span></a>';

        } else {

            btn_renovar_cf = '';

            btn_renovar_garantia = '';

            btn_cerrar_carta = '';

            btn_historial ='';

        }

        if(data.Estado == "CERRADA"){

            btn_historial = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_ver_historial(\'' + data.IdCartaFianzaDetalle + '\')" style="cursor:pointer" title="Historial"><span style="font-size:80%;" class="text-warning  glyphicon glyphicon-eye-open"></span></a>';

            btn_gestionar = '';
        }

    }





    return '<div class="btn-group"> ' + btn_gestionar + btn_renovar_cf + btn_renovar_garantia + btn_cerrar_carta+btn_historial+'</div>';
}



function prepare_modal_gestionar(idCartaFianza) {

    $("#tab-gestion-cf").click();
    $("#modal_gestionar_carta").modal("show");
    get_detalle_carta_fianza(idCartaFianza);



    loadingUI('cargando');
}





function get_detalle_carta_fianza_garantia(numCarta) {


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


            if (response.length > 0) {

                $("#mdg_porcentaje").val(response[0].Porcentaje);
                $("#mdg_monto_fianza").val(response[0].MontoCarta);
                $("#mdg_monto_garantia").val(response[0].Monto);

                $("#mdg_n_tipo_garantia").val(response[0].NumeroDocumento);

                $("#mdg_fecha_emision").val(response[0].FechaEmision);
                $("#mdg_vencimiento").val(response[0].FechaVencimiento);

                $("#mdg_obs").val(response[0].Observaciones);

                $("#mdg_tipo_garantia option[value=" + response[0].TipoGarantia + "]").prop("selected", true);

                $('#mdg_tipo_garantia').trigger("chosen:updated");


                $("#mdg_moneda option[value=" + response[0].Moneda + "]").prop("selected", true);

                $('#mdg_moneda').trigger("chosen:updated");

                $("#mdg_banco option[value=" + response[0].CodigoBanco + "]").prop("selected", true);
                $('#mdg_banco').trigger("chosen:updated");




                $("#mdg_estado option[value=" + response[0].Estado + "]").prop("selected", true);
                $('#mdg_estado').trigger("chosen:updated");




            } else {

                $("#mdg_porcentaje").val("");
                $("#mdg_monto_fianza").val("");
                $("#mdg_monto_garantia").val("");
                $("#mdg_n_tipo_garantia").val("");
                $("#mdg_fecha_emision").val("");
                $("#mdg_vencimiento").val("");
                $("#mdg_obs").val("");

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
                $("#mfc_renovacion").val(response[0].NumeroRenovacion);

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


                $("#mcf_estado option[value=" + response[0].EstadoCF + "]").prop("selected", true);

                $('#mcf_estado').trigger("chosen:updated");


                if (response[0].NumeroCarta != null) {

                    get_detalle_carta_fianza_garantia(response[0].NumeroCarta);

                } else {

                    $("#mdg_porcentaje").val(response[0].GarantiaCheque);
                    $("#mdg_monto_fianza").val(response[0].Monto);
                    $("#mdg_monto_garantia").val(response[0].GarantiaMonto);


                    $("#mdg_n_tipo_garantia").val("");
                    $("#mdg_fecha_emision").val("");
                    $("#mdg_vencimiento").val("");
                    $("#mdg_obs").val("");


                    $("#mdg_estado option[value='PND']").prop("selected", true);
                    $('#mdg_estado').trigger("chosen:updated");

                    $("#mdg_tipo_garantia option[value='CD']").prop("selected", true);
                    $('#mdg_tipo_garantia').trigger("chosen:updated");

                    $("#mdg_banco option[value='01']").prop("selected", true);
                    $('#mdg_banco').trigger("chosen:updated");

                    $("#mdg_moneda option[value='SOL']").prop("selected", true);
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

    $('#mdg_monto_fianza').val(parseFloat(value).toFixed(2));

    const porcentaje = $('#mdg_porcentaje').val();

    const monto_garantia = (porcentaje / 100) * value;

    $('#mdg_monto_garantia').val(parseFloat(monto_garantia).toFixed(2));


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

})

function valida_formulario_gestion_carta() {


    let msj = '';

    if ($('#hidden_carta_idfinanciero').val() == 0) {

        return 'Ingrese una financiera';

    }

    if ($('#mcf_monto').val().trim() == "" || $('#mcf_monto').val().trim() == 0) {

        return 'Ingrese un monto';

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

            before: function() {

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
}