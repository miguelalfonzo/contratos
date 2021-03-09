$(document).ready(function() {

    list_obras(0,0,0,0,'','');

});


function list_obras(proceso,condicion,id_cliente,id_obra,inicio,fin) {

    destroy_data_table('table_obra');

    $("#buscador_general").val('');

    var dataTable = $('#table_obra').DataTable({
        ajax: {
            url: server + 'get_obras_list',
            type: 'GET',
            data: {

                proceso: proceso,
                condicion:condicion,
                id_cliente:id_cliente,
                id_obra:id_obra,
                inicio:inicio,
                fin:fin

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
        }, "order": [
            [0, "desc"]
        ],
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
        },{
            data: 'MontoMoneda'
        }, {
            data: 'Condicion'
        }, {
            data: null,
            "render": function(data, type, full, meta) {

                return set_botones_tabla_obras(data);

            }
        }]
        ,
        rowCallback: function(row, data) {

            if (data.CondicionBit == 'P') {

                $($(row).find("td")[7]).html('<div class="resize-margin-top"><span class="cursor-pointer text-primary" data-toggle="tooltip" data-placement="bottom" title="' + data.Condicion + ' "><strong>' + data.CondicionBit + '</strong></span></div>');

            } else {

                $($(row).find("td")[7]).html('<div class="resize-margin-top"><span class="cursor-pointer text-danger" data-toggle="tooltip" data-placement="bottom" title="' + data.Condicion + ' "><strong>' + data.CondicionBit + '</strong></span></div>');
            }
        },
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

    

    const btn_documentos = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_documentos_obras(\'' + data.IdObra + '\')" style="cursor:pointer" title="Documentos"><span style="font-size:80%;" class="text-success glyphicon glyphicon-book"></span></a>';

    let btn_rechazar ='';


    let btn_solicitud = '';

    //propio = 1 , historico = 2

    if (data.IdCondicion == 1) {

        let text_color = '';
        let text_tittle = '';

        //este flag es el codigo de la solicitud

        if (data.FlagSolPendiente == 0) {

            text_color = 'text-danger';
            text_tittle = 'Solicitud pendiente';

            //se mostrara el boton rechazar solo para lo pendiente

            if(data.FlagRechazado == 0){

                btn_rechazar = '<a data-toggle="tooltip" data-placement="bottom" style="cursor:pointer" onclick="get_modal_rechazar_solicitud(\'' + data.IdObra + '\',\'' + data.CodigoObra + '\',\'' + data.Descripcion + '\')" class="btn btn-default btn_resize"   title="Rechazar"><span style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"></span></a>';

            }
            
        } else {

            text_color = 'text-primary';
            text_tittle = 'Solicitud Generada';

        }

        // se mostrara el boton solicitud solo para lo que no esta rechazado

        if(data.FlagRechazado == 0){

            btn_solicitud = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize"  href="../public/solicitud/' + data.IdObra + '" title="' + text_tittle + '"><span style="font-size:80%;" class="' + text_color + ' glyphicon glyphicon-file"></span></a>';

        }else{

            //boton informativo

            btn_solicitud = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize"  style="cursor:pointer" title="Solicitud Rechazada"><span style="font-size:80%;" class="text-danger glyphicon glyphicon-info-sign"></span></a>';

        }

    }else if(data.IdCondicion == 2){

        //boton informativo

        btn_solicitud = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize"  style="cursor:pointer" title="Solicitud Histórica"><span style="font-size:80%;" class="text-dark glyphicon glyphicon-info-sign"></span></a>';

    }



    return '<div class="btn-group"> ' + btn_edit  + btn_documentos + btn_solicitud + btn_rechazar + '</div>';

}


$('#btn_exportar_obras').on('click', function() {

 const proceso =  $('#filter_obra_proceso').val();
 const condicion =  $('#filter_obra_condicion').val();
 const id_cliente =  $('#filter_obra_id_cliente').val();
 const id_obra =  $('#filter_obra_idobra').val();
 const inicio = $('#fecha_inicio_filter_obra').val();
 const fin = $('#fecha_fin_filter_obra').val();

 window.location.href = server + "export_obras?proceso="+proceso+'&&condicion='+condicion+'&&id_cliente='+id_cliente+'&&id_obra='+id_obra+'&&inicio='+inicio+'&&fin='+fin;

})



//modal de filtro
$('#btn_filtrar_obra').on('click', function() {

 $("#modal-filtrar-obras").modal("show");

})


//todos los clientes

$('#filter_obra_cliente').keyup(function() {

    let query = $(this).val();

    $('#filter_obra_id_cliente').val(0);

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

        $('#filter_obra_cliente').val(string);
        $('#clientes_list').fadeOut();

        const id_cliente = $(this).attr('data-id');

        $('#filter_obra_id_cliente').val(id_cliente);


    }


});


//filtrar obras

$('#filter_obra_obra').keyup(function() {

    let query = $(this).val();

    $('#filter_obra_idobra').val(0);

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

        $('#filter_obra_obra').val(string);
        $('#obras_list').fadeOut();

        const id_obra = $(this).attr('data-id');

        $('#filter_obra_idobra').val(id_obra);


    }


});



$('#aplica_filtro_obras').on('click', function() {

 const proceso =  $('#filter_obra_proceso').val();
 const condicion =  $('#filter_obra_condicion').val();
 const id_cliente =  $('#filter_obra_id_cliente').val();
 const id_obra =  $('#filter_obra_idobra').val();
 const fe_inicio = $('#fecha_inicio_filter_obra').val();
 const fe_fin = $('#fecha_fin_filter_obra').val();

 list_obras(proceso,condicion,id_cliente,id_obra,fe_inicio,fe_fin);

   //labels

   const proceso_label  = $("#filter_obra_proceso option:selected").text();
   const condicion_label  = $("#filter_obra_condicion option:selected").text();
   const cliente_label = (id_cliente == 0 )?'TODOS':$('#filter_obra_cliente').val();
   const obra_label = (id_obra == 0 )?'TODOS':$('#filter_obra_obra').val();

   $('#lblProcesoFilter').text(proceso_label);
   $('#lblCondicionFilter').text(condicion_label);
   $('#lblClienteFilter').text(cliente_label);
   $('#lblObraFilter').text(obra_label);
   $('#lblInicioFilter').text(fe_inicio);
   $('#lblFinFilter').text(fe_fin);

   $('#modal-filtrar-obras').modal('hide');

})

//fin de la modal de filtro



//documentos obras

function get_modal_rechazar_solicitud(IdObra,CodObra,Descripcion){


    $("#modal-rechazar-solicitud").modal("show");

    $("#rechaza_solicitud_form_coment").val('');
    $("#rechaza_solicitud_id").val(IdObra);
    $("#rechaza_solicitud_form_cod").val(CodObra);
    $("#rechaza_solicitud_form_name").val(Descripcion);

}


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
            "targets": [0, 1, 2, 3],
            "className": "text-center"
        }],
        columns: [{
            data: 'descripcion'
        }, {
            data: 'FechaModificacion'
        }, {
            data: 'Comentario'
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
    $("#comentario_documento").val('');
}

$('#btn_subir_file_cdocumento').on('click', function() {

    let cantidad_files = dropzoneObraDoc.getQueuedFiles().length;

    if (cantidad_files > 0) {

        const comentario_externo = $("#comentario_documento").val();
        
        $("#Comentario_documento_obra").val(comentario_externo);

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
    sending:function(){

        $('#btn_subir_file_cdocumento').attr("disabled",true);
    },
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

        $('#btn_subir_file_cdocumento').attr("disabled",false);

    },
    error: function(file, response) {

        alertify.error(response);


        dropzoneObraDoc.removeAllFiles();

        $.unblockUI();

        $('#btn_subir_file_cdocumento').attr("disabled",false);
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


$("#rechaza_solicitud_form").submit(function(event) {

    event.preventDefault();

    const comentario = $("#rechaza_solicitud_form_coment").val().trim();

    if (comentario != '') {

        let formData = new FormData(document.getElementById("rechaza_solicitud_form"));

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: server + 'rechazar_solicitud',
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function() {

                loadingUI('rechazando...');

            },
            success: function(response) {

                console.log(response);

                if (response.status == "ok") {

                    alertify.success(set_sucess_message_alertify(response.description));

                    $('#table_obra').DataTable().ajax.reload();

                    $('#modal-rechazar-solicitud').modal("hide");


                } else {

                    alertify.error(set_error_message_alertify(response.description));
                }

                $.unblockUI();
            },
            error: function(jqXHR, textStatus, errorThrown) {

                $.unblockUI();
                ajaxError(jqXHR, textStatus, errorThrown);


            }

        });


    } else {

        alertify.error(set_error_message_alertify('Ingrese un comentario'));
    }


});