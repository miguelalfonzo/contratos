$(document).ready(function() {


    const id_solicitud = $("#solicitud_id").val();


    get_list_documentos_solicitud(id_solicitud);


})


function get_list_documentos_solicitud(id_solicitud) {

    destroy_data_table('table-solicitud-documentos');

    var dataTable = $('#table-solicitud-documentos').DataTable({
        ajax: {
            url: server + 'get_solicitud_documentos',
            type: 'GET',
            data: {
                id_solicitud: id_solicitud

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
        columnDefs: [{
            "targets": [0, 1, 2],
            "className": "text-center"
        }],
        columns: [{
            data: 'descripcion'
        }, {
            data: 'FechaModificacion'
        }, {
            data: null,
            "render": function(data, type, full, meta) {

                if (id_solicitud != 0) {

                    const btn_subida = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Subir"' +
                    'onclick="prepare_subida_file(\'' + data.valor + '\',\'' + data.descripcion + '\',\'' + data.IdSolicitudDocumento + '\',\'' + id_solicitud + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-primary glyphicon glyphicon-cloud"></span></a>';


                    let btn_ver = '';
                    let btn_eliminar = '';

                    if (data.ValorFile != null) {

                        btn_ver = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Ver"' +
                        'onclick="ver_file(\'' + data.ValorFile + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-success glyphicon glyphicon-eye-open"></span></a>';


                        btn_eliminar = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Eliminar"' +
                        'onclick="prepare_delete_file(\'' + data.IdSolicitudDocumento + '\',\'' + data.ValorFile + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"></span></a>';
                    }




                    return '<div class="btn-group"> ' + btn_subida + btn_ver + btn_eliminar + '</div>';

                } else {

                    const btn_subida = '<a data-desdoc="' + data.descripcion + '" data-coddoc="' + data.valor + '" data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Subir"' +
                    'onclick="prepare_subida_file_memoria(\'' + data.valor + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-primary glyphicon glyphicon-cloud"></span></a>';
                    const btn_ver = '<a data-file="" style="display:none" data-toggle="tooltip" data-placement="bottom" class="ver_file_memoria btn btn-default btn_resize" title="Ver"' +
                    'onclick="" style="cursor:pointer"><span style="font-size:80%;" class="text-success glyphicon glyphicon-eye-open"></span></a>';

                    const btn_eliminar = '<a data-coddoc="' + data.valor + '" data-file="" style="display:none" data-toggle="tooltip" data-placement="bottom" class="elimina_file_memoria btn btn-default btn_resize" title="Eliminar"' +
                    'onclick="" style="cursor:pointer"><span style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"></span></a>';

                    return '<div class="btn-group"> ' + btn_subida + btn_ver + btn_eliminar + '</div>';
                }


            }
        }],

        "drawCallback": function(settings) {

            $('[data-toggle="tooltip"]').tooltip();


        }

    });


}

//solicitudes nuevas


function prepare_subida_file_memoria(valor) {

    $("#modal-file-upload-memoria").modal("show");

    $("#tipo_doc_memoria").val(valor);
}


var dropzoneSolicitudDocMemoria = new Dropzone('#dropzoneSolicitudDocMemoria', {
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
            this.options.url = server + 'load_file_solicitud_documento_memoria';
        });
    },

    success: function(file, response) {
        console.log(response);

        if (response.status == "ok") {


            const tipo_doc = $("#tipo_doc_memoria").val();

            reload_tabla_documentos_memoria(tipo_doc, response.data);

            alertify.success(set_sucess_message_alertify(response.description));

            dropzoneSolicitudDocMemoria.removeAllFiles();

            $("#modal-file-upload-memoria").modal("hide");

        } else {

            alertify.error(set_error_message_alertify(response.description));
        }

        $.unblockUI();

    },
    error: function(file, response) {

        alertify.error(response);


        dropzoneSolicitudDocMemoria.removeAllFiles();

        $.unblockUI();
    }
})


$('#btn_subir_file_cdocumento_memoria').on('click', function() {

    let cantidad_files = dropzoneSolicitudDocMemoria.getQueuedFiles().length;

    if (cantidad_files > 0) {

        dropzoneSolicitudDocMemoria.processQueue();

    } else {

        alertify.error('Seleccione algun archivo');
    }

})

function reload_tabla_documentos_memoria(tipo, fileName) {

    $('#table-solicitud-documentos tbody tr').each(function() {

        if ($(this).find("td").eq(2).find("a").attr("data-coddoc") == tipo) {

            //opcion ver
            $(this).find("td").eq(2).find("a").next("a").css("display", "block");
            $(this).find("td").eq(2).find("a").next("a").attr("data-file", fileName);

            //opcion eliminar
            $(this).find("td").eq(2).find("a").next("a").next("a").css("display", "block");
            $(this).find("td").eq(2).find("a").next("a").next("a").attr("data-file", fileName);
        }

    });


}

$(document).on('click', '.ver_file_memoria', function(e) {

    e.preventDefault();

    const file = $(this).attr("data-file");

    ver_file(file);

});

$(document).on('click', '.elimina_file_memoria', function(e) {

    e.preventDefault();

    const file = $(this).attr("data-file");

    const tipo_file = $(this).attr("data-coddoc");

    delete_file_memoria(file, tipo_file);

});

function delete_file_memoria(file, tipo_file) {

    $.ajax({
        url: server + 'elimina_documento_solicitud_memoria',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            file: file

        },
        before: function() {

        },
        success: function(response) {


            if (response.status == "ok") {

                oculta_botones_tabla_memoria_documentos(tipo_file);

                alertify.success(set_sucess_message_alertify(response.description));


            } else {

                alertify.error(set_error_message_alertify(response.description));
            }


            $.unblockUI();

        },
        error: function(jqXHR, textStatus, errorThrown) {

            ajaxError(jqXHR, textStatus, errorThrown);


            $.unblockUI();
        }

    });

}

function oculta_botones_tabla_memoria_documentos(tipo_file) {

    $('#table-solicitud-documentos tbody tr').each(function() {

        if ($(this).find("td").eq(2).find("a").attr("data-coddoc") == tipo_file) {

            //opcion ver
            $(this).find("td").eq(2).find("a").next("a").css("display", "none");
            $(this).find("td").eq(2).find("a").next("a").attr("data-file", "");

            //opcion eliminar
            $(this).find("td").eq(2).find("a").next("a").next("a").css("display", "none");
            $(this).find("td").eq(2).find("a").next("a").next("a").attr("data-file", "");
        }

    });

}
//solicitudes existentes

function prepare_subida_file(valor, descripcion, idSolicitudDocumento, id_solicitud) {

    $("#modal-file-upload").modal("show");
    $("#IdSolicitud_documento").val(id_solicitud);
    $("#IdSolicitudDocumento_documento").val(idSolicitudDocumento);
    $("#Descripcion_documento").val(descripcion);
    $("#Valor_documento").val(valor);

}

$('#btn_subir_file_cdocumento').on('click', function() {

    let cantidad_files = dropzoneSolicitudDoc.getQueuedFiles().length;

    if (cantidad_files > 0) {

        dropzoneSolicitudDoc.processQueue();

    } else {

        alertify.error('Seleccione algun archivo');
    }

})



Dropzone.autoDiscover = false;

var dropzoneSolicitudDoc = new Dropzone('#dropzoneSolicitudDoc', {
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
            this.options.url = server + 'load_file_solicitud_documento';
        });
    },

    success: function(file, response) {
        console.log(response);

        if (response.status == "ok") {

            $('#table-solicitud-documentos').DataTable().ajax.reload();

            alertify.success(set_sucess_message_alertify(response.description));

            dropzoneSolicitudDoc.removeAllFiles();

            $("#modal-file-upload").modal("hide");

        } else {

            alertify.error(set_error_message_alertify(response.description));
        }

        $.unblockUI();

    },
    error: function(file, response) {

        alertify.error(response);


        dropzoneSolicitudDoc.removeAllFiles();

        $.unblockUI();
    }
})

function ver_file(file) {

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


        $('#ObjPdf3').attr('src', server + '/files_documentos_solicitud/' + PdfFile);
        $('#divPdf').show();
        $('#divImagen').hide();

    } else {

        $("#tituloTipoArchivo").html('<i class="fa fa-photo"></i> Ver archivo adjunto - Tipo <i class="far fa-hand-point-right"></i> ' + extension);

        $("#ModalVerAdjuntos").modal('show');
        var ImgFile = file;
        $('#divPdf').hide();
        $('#divImagen').show();

        $('#imgAdjunta').attr('src', server + '/files_documentos_solicitud/' + ImgFile);

    }


}

function prepare_delete_file(IdSolicitudDocumento, file) {

    $.ajax({
        url: server + 'elimina_documento_solicitud',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            IdSolicitudDocumento: IdSolicitudDocumento,
            file: file


        },
        before: function() {

        },
        success: function(response) {


            if (response.status == "ok") {

                $('#table-solicitud-documentos').DataTable().ajax.reload();

                alertify.success(set_sucess_message_alertify(response.description));


            } else {

                alertify.error(set_error_message_alertify(response.description));
            }


            $.unblockUI();

        },
        error: function(jqXHR, textStatus, errorThrown) {

            ajaxError(jqXHR, textStatus, errorThrown);


            $.unblockUI();
        }

    });
}


$("#switch_cumplimiento").on('click', function() {

    if ($("#switch_cumplimiento").prop('checked')) {

        $("#solicitud_cumplimiento").prop('readonly', false);

        const valor_oculto = $("#solicitud_cumplimiento").attr('data-valor');

        $("#solicitud_cumplimiento").val(valor_oculto);

        //para el porcentaje

        $("#input_por_solicitud_cumplimiento").prop('readonly', false);

        const porcentaje_oculto = $("#input_por_solicitud_cumplimiento").attr('data-valor');

        $("#input_por_solicitud_cumplimiento").val(porcentaje_oculto);




    } else {

        $("#solicitud_cumplimiento").prop('readonly', true);

        $("#solicitud_cumplimiento").val('');

        //para el porcentaje

        $("#input_por_solicitud_cumplimiento").prop('readonly', true);

        $("#input_por_solicitud_cumplimiento").val('');
        
    }

    recalcula_fianza();
})

$("#switch_directo").on('click', function() {

    if ($("#switch_directo").prop('checked')) {

        $("#solicitud_directo").prop('readonly', false);

        const valor_oculto = $("#solicitud_directo").attr('data-valor');

        $("#solicitud_directo").val(valor_oculto);

        //para el porcentaje

        $("#input_por_solicitud_directo").prop('readonly', false);

        const porcentaje_oculto = $("#input_por_solicitud_directo").attr('data-valor');

        $("#input_por_solicitud_directo").val(porcentaje_oculto);


    } else {

        $("#solicitud_directo").prop('readonly', true);

        $("#solicitud_directo").val('');

        //para el porcentaje

        $("#input_por_solicitud_directo").prop('readonly', true);

        $("#input_por_solicitud_directo").val('');
    }

    recalcula_fianza();
})

$("#switch_materiales").on('click', function() {

    if ($("#switch_materiales").prop('checked')) {

        $("#solicitud_materiales").prop('readonly', false);

        const valor_oculto = $("#solicitud_materiales").attr('data-valor');

        $("#solicitud_materiales").val(valor_oculto);

        //para el porcentaje

        $("#input_por_solicitud_materiales").prop('readonly', false);

        const porcentaje_oculto = $("#input_por_solicitud_materiales").attr('data-valor');

        $("#input_por_solicitud_materiales").val(porcentaje_oculto);


    } else {

        $("#solicitud_materiales").prop('readonly', true);

        $("#solicitud_materiales").val('');

        //para el porcentaje

        $("#input_por_solicitud_materiales").prop('readonly', true);

        $("#input_por_solicitud_materiales").val('');
    }

    recalcula_fianza();

})


function recalcula_fianza() {

    const cumplimiento = ($("#solicitud_cumplimiento").val() != "") ? $("#solicitud_cumplimiento").val() : 0;

    const directo = ($("#solicitud_directo").val() != "") ? $("#solicitud_directo").val() : 0;

    const materiales = ($("#solicitud_materiales").val() != "") ? $("#solicitud_materiales").val() : 0;

    const suma_total = parseFloat(cumplimiento) + parseFloat(directo) + parseFloat(materiales);

    $("#total_solicitud").val(numero_a_formato_numerico(suma_total.toFixed(2)));

}


$("#input_por_solicitud_materiales").keyup(function(){
  

  const value = $(this).val();

  const valor_obra = $("#solicitud_monto").val();

  const valor_obra_numero = formato_numerico_a_numero(valor_obra);

  const nuevo_valor = parseFloat(valor_obra_numero*value/100).toFixed(2);

  $("#solicitud_materiales").val(nuevo_valor);
  
  recalcula_fianza();

});

$("#input_por_solicitud_directo").keyup(function(){
  

  const value = $(this).val();

  const valor_obra = $("#solicitud_monto").val();

  const valor_obra_numero = formato_numerico_a_numero(valor_obra);

  const nuevo_valor = parseFloat(valor_obra_numero*value/100).toFixed(2);

  $("#solicitud_directo").val(nuevo_valor);
  
  recalcula_fianza();

});

$("#input_por_solicitud_cumplimiento").keyup(function(){
  

  const value = $(this).val();

  const valor_obra = $("#solicitud_monto").val();

  const valor_obra_numero = formato_numerico_a_numero(valor_obra);

  

  const nuevo_valor = parseFloat(valor_obra_numero*value/100).toFixed(2);

  $("#solicitud_cumplimiento").val(nuevo_valor);
  
  recalcula_fianza();

});


$("#solicitud_materiales").keyup(function(){
  

  const value = $(this).val();

  const valor_solicitud = formato_numerico_a_numero($("#solicitud_monto").val());

  const nuevo_porcentaje = parseFloat(value*100/valor_solicitud).toFixed(2);

  $("#input_por_solicitud_materiales").val(nuevo_porcentaje);
  

});

$("#solicitud_cumplimiento").keyup(function(){
  

  const value = $(this).val();

  const valor_solicitud = formato_numerico_a_numero($("#solicitud_monto").val());

  const nuevo_porcentaje = parseFloat(value*100/valor_solicitud).toFixed(2);

  $("#input_por_solicitud_cumplimiento").val(nuevo_porcentaje);
  

});

$("#solicitud_directo").keyup(function(){
  

  const value = $(this).val();

  const valor_solicitud = formato_numerico_a_numero($("#solicitud_monto").val());

  const nuevo_porcentaje = parseFloat(value*100/valor_solicitud).toFixed(2);

  $("#input_por_solicitud_directo").val(nuevo_porcentaje);
  

});


function get_list_documentos_temporales() {

    let array_documentos = [];


    $('#table-solicitud-documentos tbody tr').each(function() {


        if ($(this).find("td").eq(2).find("a").next("a").attr("data-file") != "") {

            row = {

                codigo: $(this).find("td").eq(2).find("a").attr("data-coddoc"),
                descripcion: $(this).find("td").eq(2).find("a").attr("data-desdoc"),
                file: $(this).find("td").eq(2).find("a").next("a").attr("data-file")
            }

            array_documentos.push(row);
        }

    });


    return array_documentos;
}



function valida_inptus_solicitud() {

    let msj = '';

    if ($("#solicitud_cumplimiento").val().trim() == "" && $("#solicitud_directo").val().trim() == "" && $("#solicitud_materiales").val().trim() == "") {

        return 'Ingrese al menos 1 tipo de fianza';

    }


    if ($("#total_solicitud").val() == "0.00" || $("#total_solicitud").val() == 0 || $("#total_solicitud").val() == "") {

        return 'Ingrese al menos 1 tipo de fianza';

    }

    return msj;
}

$("#form_solicitud").submit(function(event) {

    event.preventDefault();

    const rpta = valida_inptus_solicitud();

    if (rpta == '') {


        alertify.confirm("Confirmar Solicitud", "¿Está seguro de tramitar la solicitud ? ",
            function() {

                let formData = new FormData(document.getElementById("form_solicitud"));


                const id_solicitud = $("#solicitud_id").val();

                if (id_solicitud == 0) {

                    const documentos = get_list_documentos_temporales();

                    formData.append('documentos', JSON.stringify(documentos));


                }

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: server + 'save_solicitud',
                    type: "post",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,

                    before: function() {

                    },
                    success: function(response) {


                        if (response.status == "ok") {

                            alertify.success(set_sucess_message_alertify(response.description));

                            const url = server + "obras";

                            setTimeout($(location).attr('href', url), 10000);

                        } else {


                            alertify.error(set_error_message_alertify(response.description));
                        }

                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                        ajaxError(jqXHR, textStatus, errorThrown);


                    }

                });

            },
            function() {

                alertify.error(set_error_message_alertify('Cancelado'));

            });


    } else {

        alertify.error(set_error_message_alertify(rpta));
    }


});



$('.EliminaFianzaBtn').on('click', function() {

    const tipo = $(this).attr("data-type");

    if (tipo == "fc") {

        $("#solicitud_cumplimiento").val("");

    } else if (tipo == "ad") {

        $("#solicitud_directo").val("");

    } else if (tipo == "am") {

        $("#solicitud_materiales").val("");
    }

    recalcula_fianza();
})