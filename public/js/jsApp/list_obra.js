$(document).ready(function() {


    list_obras(1);

});


function list_obras(id_estado) {

    destroy_data_table('table_obra');

    var dataTable = $('#table_obra').DataTable({
        ajax: {
            url: server + 'get_obras_list',
            type: 'GET',
            data: {

                id_estado: id_estado
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
            data: 'CodigoObra'
        }, {
            data: 'Descripcion'
        }, {
            data: 'FullNameCliente'
        }, {
            data: 'FullNameBeneficiario'
        }, {
            data: 'FullNameFinanciera'
        }, {
            data: 'Localidad'
        }, {
            data: 'Condicion'
        }, {
            data: null,
            "render": function(data, type, full, meta) {

                return set_botones_tabla_obras(data);

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


function set_botones_tabla_obras(data) {

    const btn_edit = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize"  href="../public/obra/' + data.IdObra + '" title="Editar"><span style="font-size:80%;" class="text-success glyphicon glyphicon-edit"></span></a>';

    let btn_eliminar = '';


    const btn_documentos = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_documentos_obras(\'' + data.IdObra + '\')" style="cursor:pointer" title="Documentos"><span style="font-size:80%;" class="text-success glyphicon glyphicon-book"></span></a>';



    let btn_solicitud = '';


    if (data.FlagSolicitud == 1) {

        let text_color = '';
        let text_tittle = '';

        if (data.FlagSolPendiente == 0) {

            text_color = 'text-danger';
            text_tittle = 'Solicitud pendiente';

        } else {

            text_color = 'text-primary';
            text_tittle = 'Solicitud Generada';

        }


        btn_solicitud = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize"  href="../public/solicitud/' + data.IdObra + '" title="' + text_tittle + '"><span style="font-size:80%;" class="' + text_color + ' glyphicon glyphicon-file"></span></a>';
    }



    return '<div class="btn-group"> ' + btn_edit + btn_eliminar + btn_documentos + btn_solicitud + '</div>';

}

//documentos obras


function prepare_modal_documentos_obras(IdObra) {

    $("#modal-edit-documentos-obras").modal("show");

    list_obras_documento(IdObra);

}

function list_obras_documento(IdObra) {

    destroy_data_table('table-obras-documentos');

    var dataTable = $('#table-obras-documentos').DataTable({
        ajax: {
            url: server + 'get_obra_documentos',
            type: 'GET',
            data: {
                IdObra: IdObra

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

                const btn_subida = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Subir"' +
                    'onclick="prepare_subida_file(\'' + data.valor + '\',\'' + data.descripcion + '\',\'' + data.IdObraDocumento + '\',\'' + IdObra + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-primary glyphicon glyphicon-cloud"></span></a>';


                let btn_ver = '';
                let btn_eliminar = '';

                if (data.ValorFile != null) {

                    btn_ver = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Ver"' +
                        'onclick="ver_file(\'' + data.ValorFile + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-success glyphicon glyphicon-eye-open"></span></a>';


                    btn_eliminar = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Eliminar"' +
                        'onclick="prepare_delete_file(\'' + data.IdObraDocumento + '\',\'' + data.ValorFile + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"></span></a>';
                }




                return '<div class="btn-group"> ' + btn_subida + btn_ver + btn_eliminar + '</div>';
            }
        }],

        "drawCallback": function(settings) {

            $('[data-toggle="tooltip"]').tooltip();


        }

    });


}


function prepare_subida_file(valor, descripcion, idObraDocumento, id_obra) {

    $("#modal-file-upload").modal("show");
    $("#IdObra_documento").val(id_obra);
    $("#IdObraDocumento_documento").val(idObraDocumento);
    $("#Descripcion_documento_obra").val(descripcion);
    $("#Valor_documento_obra").val(valor);

}

$('#btn_subir_file_cdocumento').on('click', function() {

    let cantidad_files = dropzoneObraDoc.getQueuedFiles().length;

    if (cantidad_files > 0) {

        dropzoneObraDoc.processQueue();

    } else {

        alertify.error('Seleccione algun archivo');
    }

})


Dropzone.autoDiscover = false;

var dropzoneObraDoc = new Dropzone('#dropzoneObraDoc', {
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
            this.options.url = server + 'load_file_obra_documento';
        });
    },

    success: function(file, response) {
        console.log(response);

        if (response.status == "ok") {

            $('#table-obras-documentos').DataTable().ajax.reload();

            alertify.success(set_sucess_message_alertify(response.description));

            dropzoneObraDoc.removeAllFiles();

            $("#modal-file-upload").modal("hide");

        } else {

            alertify.error(set_error_message_alertify(response.description));
        }

        $.unblockUI();

    },
    error: function(file, response) {

        alertify.error(response);


        dropzoneObraDoc.removeAllFiles();

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


        $('#ObjPdf3').attr('src', server + '/files_documentos_obra/' + PdfFile);
        $('#divPdf').show();
        $('#divImagen').hide();

    } else {

        $("#tituloTipoArchivo").html('<i class="fa fa-photo"></i> Ver archivo adjunto - Tipo <i class="far fa-hand-point-right"></i> ' + extension);

        $("#ModalVerAdjuntos").modal('show');
        var ImgFile = file;
        $('#divPdf').hide();
        $('#divImagen').show();

        $('#imgAdjunta').attr('src', server + '/files_documentos_obra/' + ImgFile);

    }


}

function prepare_delete_file(IdObraDocumento, file) {

    $.ajax({
        url: server + 'elimina_documento_obra',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            IdObraDocumento: IdObraDocumento,
            file: file


        },
        before: function() {

        },
        success: function(response) {


            if (response.status == "ok") {

                $('#table-obras-documentos').DataTable().ajax.reload();

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
// fin funciones documentos