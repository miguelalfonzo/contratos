$(document).ready(function() {

    const state_filter = $('#filtro_cliente').val();

    load_list_clientes(state_filter);

    $('#btn_salvar_modal_empresas').show();

});

function load_list_clientes(state) {

    var dataTable = $('#tabla-cliente').DataTable({
        ajax: {
            url: server + 'get_list_clientes',
            type: 'GET',
            data: {
                state: state

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
            data: 'Identificacion'
        }, {
            data: 'Nombre'
        }, {
            data: 'Localidad'
        }, {
            data: 'TipoCliente'
        }, {
            data: 'FlagActivo'
        }, {
            data: null,
            "render": function(data, type, full, meta) {

                return set_botones_tabla_cliente(data);

            }
        }],

        rowCallback: function(row, data) {

            if (data.FlagActivo == 1) {

                $($(row).find("td")[4]).html('<span style="text-align:center; font-size:135%;" class="btn btn-default btn_resize text-success glyphicon glyphicon-ok-sign"></span>');

            } else if (data.FlagActivo == 0) {

                $($(row).find("td")[4]).html('<span style="text-align:center; font-size:135%;" class="btn btn-default btn_resize text-danger glyphicon glyphicon-remove-sign"></span>');
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


$("#filtro_cliente").on('change', function() {

    destroy_data_table('tabla-cliente');
    const value = $(this).val();
    load_list_clientes(value);
    $("#buscador_general").val("");

});


function set_botones_tabla_cliente(data) {

    const btn_edit = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize"  href="../public/cliente/' + data.IdCliente + '" title="Editar"><span style="font-size:80%;" class="text-success glyphicon glyphicon-edit"></span></a>';

    const btn_representantes = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_representantes(\'' + data.IdCliente + '\')" style="cursor:pointer" title="Representantes"><span style="font-size:80%;" class="text-success glyphicon glyphicon-user"></span></a>';

    const btn_accionistas = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_accionistas(\'' + data.IdCliente + '\')" style="cursor:pointer" title="Accionistas"><i style="font-size:80%;" class="text-success fa fa-users"></i></a>';

    const btn_documentos = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" onclick="prepare_modal_documentos(\'' + data.IdCliente + '\')" style="cursor:pointer" title="Documentos"><span style="font-size:80%;" class="text-success glyphicon glyphicon-book"></span></a>';

    let btn_eliminar = '';

    let btn_clientes_asociados = '';

    let btn_multi_report = '';

    if (data.FlagActivo == 1) {

        btn_eliminar = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Eliminar"' +
        'onclick="prepare_delete_cliente(\'' + data.IdCliente + '\')" style="cursor:pointer">' +
        '<span style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"></span></a> ';
    

        btn_multi_report='<div class="btn-group"><button type="button" class="btn btn-info dropdown-toggle btn-sm resize-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-print"></i></button><div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -185px, 0px);"><a class="dropdown-item" href="" onclick="reporte_pdf_estado_cuenta(\'' + data.IdCliente + '\')">Estado Cuenta</a><a class="dropdown-item" href="#">Estado Cuenta - Garantías</a></div></div>';

    }


    if (data.IdTipoCliente == '05') {

        btn_clientes_asociados = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Ver empresas"' +
        'onclick="prepare_ver_empresas(\'' + data.IdConsorcio + '\',\'' + data.IdCliente + '\')" style="cursor:pointer">' +
        '<span style="font-size:80%;" class="text-primary glyphicon glyphicon-home"></span></a> ';


    }

        

    return '<div class="btn-group"> ' + btn_edit + btn_clientes_asociados + btn_representantes + btn_accionistas + btn_documentos + btn_eliminar + btn_multi_report+'</div>';

}



function reporte_pdf_estado_cuenta(codigo_cliente){

    const url= server+'reporte_estado_cuenta/'+codigo_cliente;
    
    window.open(url, '_blank');
    
    return false;
}



//funciones empresas - consorcio


function prepare_ver_empresas(cliente_id_consorcio, id_cliente) {

    $("#modal-ver-empresas").modal("show");

    if (cliente_id_consorcio == "null") {

        cliente_id_consorcio = 0;

    }

    $("#hidden_consorcio_id_modal").val(cliente_id_consorcio);

    $("#hidden_cliente_id_modal").val(id_cliente);

    get_empresas_asociadas(cliente_id_consorcio);
}

function get_empresas_asociadas(cliente_id_consorcio) {

    $("#table-cliente-empresas tbody").empty();

    $.ajax({
        url: server + "get_cliente_empresas",
        method: "get",
        dataType: "json",
        data: {
            _token: '{{ csrf_token() }}',
            cliente_id_consorcio: cliente_id_consorcio
        },
        success: function(response) {

            console.log(response);

            if (response.length > 0) {

                for (let i = 0; i < response.length; i++) {


                    let btn_eliminar = '<a data-toggle="tooltip" data-placement="bottom" class="deleteRow btn btn-default btn_resize" title="Eliminar" style="cursor:pointer"><span style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"></span></a>';


                    $("#table-cliente-empresas tbody").append("<tr id='row_cliente_asoc_" + response[i].IdCliente + "'><td style='display:none'>" + response[i].IdCliente + "</td><td>" + response[i].NumeroDocumento + "</td><td>" + response[i].RazonSocial + "</td><td><input type='number' class='form-control resize-input resize-font ' min='0' value='" + response[i].Porcentaje + "' oninput='limitDecimalPlaces(event, 2)' onkeypress='return isNumberKey(event)'/></td><td><div class='btn-group'> " + btn_eliminar + "</div></td></tr>");
                }


            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            ajaxError(jqXHR, textStatus, errorThrown);

        }
    });

}


$(document).on('click', '.deleteRow', function(e) {
    e.preventDefault();
    $(this).closest('tr').remove();
});


$('#empresa_nombre').keyup(function() {

    let query = $(this).val();

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

                $('#empresas_agregar_consorcio').fadeIn();
                $('#empresas_agregar_consorcio').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                ajaxError(jqXHR, textStatus, errorThrown);

            }
        });
    }
});

$(document).on('click', '#empresas_agregar_consorcio ul li', function() {

    let string = $(this).text();

    if (string != "no se encontraron resultados") {

        $('#empresa_nombre').val('');

        $('#empresas_agregar_consorcio').fadeOut();

        const identificacion = $(this).attr('data-numdoc');

        const idcliente = $(this).attr('data-id');

        agregar_nueva_empresa_consorcio(idcliente, identificacion, string);

    }


});

function agregar_nueva_empresa_consorcio(idcliente, identificacion, nombre) {

    if ($("#row_cliente_asoc_" + idcliente).length) {

        alertify.error(set_error_message_alertify('El cliente ya se encuentra agregado'));

    } else {

        let btn_eliminar = '<a data-toggle="tooltip" data-placement="bottom" class="deleteRow btn btn-default btn_resize" title="Eliminar" style="cursor:pointer"><span style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"></span></a>';

        $("#table-cliente-empresas tbody").append("<tr id='row_cliente_asoc_" + idcliente + "'><td style='display:none'>" + idcliente + "</td><td>" + identificacion + "</td><td>" + nombre + "</td><td><input type='number' class='form-control resize-input resize-font ' min='0' value='0' oninput='limitDecimalPlaces(event, 2)' onkeypress='return isNumberKey(event)'/></td><td><div class='btn-group'> " + btn_eliminar + "</div></td></tr>");

    }


}



function get_list_empresas_asociadas() {

    let empresas = [];

    $('#table-cliente-empresas tbody tr').each(function() {

        row = {
            id_cliente: $(this).find("td").eq(0).html(),
            identificacion: $(this).find("td").eq(1).html(),
            nombre: $(this).find("td").eq(2).html(),
            porcentaje: $(this).find("td").eq(3).find('input').val()
        };
        empresas.push(row);
    });

    return empresas;

}

$("#btn_salvar_modal_empresas").on('click', function() {

    const asociados = get_list_empresas_asociadas();

    if (asociados == "") {

        alertify.error(set_error_message_alertify('Seleccione al menos un cliente para el consorcio'));

    } else {

        const cliente_id_consorcio = $("#hidden_consorcio_id_modal").val();

        const id_cliente = $("#hidden_cliente_id_modal").val();



        guardar_asociados(JSON.stringify(asociados), cliente_id_consorcio, id_cliente);
    }

});

function guardar_asociados(asociados, cliente_id_consorcio, id_cliente) {

    $.ajax({
        url: server + 'guardar_asociados_empresas',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            asociados: asociados,
            cliente_id_consorcio: cliente_id_consorcio,
            id_cliente: id_cliente

        },
        beforeSend: function() {

            $("#btn_salvar_modal_empresas").attr("disabled",true);
        },
        success: function(response) {


            if (response.status == "ok") {


                $("#modal-ver-empresas").modal("hide");

                alertify.success(set_sucess_message_alertify(response.description));

                $('#tabla-cliente').DataTable().ajax.reload();

            } else {

                alertify.error(set_error_message_alertify(response.description));
            }


            $.unblockUI();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.unblockUI();
            ajaxError(jqXHR, textStatus, errorThrown);



        }, complete: function() {

            $("#btn_salvar_modal_empresas").attr("disabled",false);  
        }

    });

}

//funciones documentos


function prepare_modal_documentos(idCliente) {


    $("#modal-edit-documentos").modal("show");

    list_cliente_documento(idCliente);
}


function list_cliente_documento(id_cliente) {

    destroy_data_table('table-cliente-documentos');

    var dataTable = $('#table-cliente-documentos').DataTable({
        ajax: {
            url: server + 'get_cliente_documentos',
            type: 'GET',
            data: {
                id_cliente: id_cliente

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
                'onclick="prepare_subida_file(\'' + data.valor + '\',\'' + data.descripcion + '\',\'' + data.IdClienteDocumento + '\',\'' + id_cliente + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-primary glyphicon glyphicon-cloud"></span></a>';


                let btn_ver = '';
                let btn_eliminar = '';

                if (data.ValorFile != null) {

                    btn_ver = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Ver"' +
                    'onclick="ver_file(\'' + data.ValorFile + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-success glyphicon glyphicon-eye-open"></span></a>';


                    btn_eliminar = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Eliminar"' +
                    'onclick="prepare_delete_file(\'' + data.IdClienteDocumento + '\',\'' + data.ValorFile + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"></span></a>';
                }




                return '<div class="btn-group"> ' + btn_subida + btn_ver + btn_eliminar + '</div>';
            }
        }],

        "drawCallback": function(settings) {

            $('[data-toggle="tooltip"]').tooltip();


        }

    });


}


function prepare_subida_file(valor, descripcion, idClienteDocumento, id_cliente) {

    $("#modal-file-upload").modal("show");
    $("#IdCliente_documento").val(id_cliente);
    $("#IdClienteDocumento_documento").val(idClienteDocumento);
    $("#Descripcion_documento").val(descripcion);
    $("#Valor_documento").val(valor);

}

$('#btn_subir_file_cdocumento').on('click', function() {

    let cantidad_files = dropzoneClienteDoc.getQueuedFiles().length;

    if (cantidad_files > 0) {

        dropzoneClienteDoc.processQueue();

    } else {

        alertify.error('Seleccione algun archivo');
    }

})



Dropzone.autoDiscover = false;

var dropzoneClienteDoc = new Dropzone('#dropzoneClienteDoc', {
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
            this.options.url = server + 'load_file_cliente_documento';
        });
    },

    success: function(file, response) {
        console.log(response);

        if (response.status == "ok") {

            $('#table-cliente-documentos').DataTable().ajax.reload();

            alertify.success(set_sucess_message_alertify(response.description));

            dropzoneClienteDoc.removeAllFiles();

            $("#modal-file-upload").modal("hide");

        } else {

            alertify.error(set_error_message_alertify(response.description));
        }

        $.unblockUI();

        $('#btn_subir_file_cdocumento').attr("disabled",false);

    },
    error: function(file, response) {

        alertify.error(response);


        dropzoneClienteDoc.removeAllFiles();

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


        $('#ObjPdf3').attr('src', server + '/files_documentos_cliente/' + PdfFile);
        $('#divPdf').show();
        $('#divImagen').hide();

    } else {

        $("#tituloTipoArchivo").html('<i class="fa fa-photo"></i> Ver archivo adjunto - Tipo <i class="far fa-hand-point-right"></i> ' + extension);

        $("#ModalVerAdjuntos").modal('show');
        var ImgFile = file;
        $('#divPdf').hide();
        $('#divImagen').show();

        $('#imgAdjunta').attr('src', server + '/files_documentos_cliente/' + ImgFile);

    }


}

function prepare_delete_file(IdClienteDocumento, file) {

    $.ajax({
        url: server + 'elimina_documento_cliente',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            IdClienteDocumento: IdClienteDocumento,
            file: file


        },
        before: function() {

        },
        success: function(response) {


            if (response.status == "ok") {

                $('#table-cliente-documentos').DataTable().ajax.reload();

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


//funciones accionistas

function prepare_modal_accionistas(idCliente) {

    $("#modal-edit-accionista").modal("show");

    $("#id_cliente_mod_accionista").val(idCliente);

    list_cliente_accionista(idCliente);
}

function list_cliente_accionista(id_cliente) {

    destroy_data_table('table-cliente-accionistas');

    var dataTable = $('#table-cliente-accionistas').DataTable({
        ajax: {
            url: server + 'get_cliente_accionistas',
            type: 'GET',
            data: {
                id_cliente: id_cliente

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
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center"
        }],
        columns: [{
            data: 'NumDoc'
        }, {
            data: 'fullName'
        }, {
            data: 'DescripcionCargo'
        }, {
            data: 'Participacion'
        }, {
            data: null,
            "render": function(data, type, full, meta) {

                const btn_edit = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Editar"' +
                'onclick="prepare_update_accionista(\'' + data.IdClienteAccionista + '\',\'' + data.Nombre + '\',\'' + data.ApePat + '\',\'' + data.ApeMat + '\',\'' + data.Cargo + '\',\'' + data.Participacion + '\',\'' + data.NumDoc + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-success glyphicon glyphicon-edit"></span></a>';

                const btn_delete = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Eliminar"' +
                'onclick="elimina_accionista(\'' + data.IdClienteAccionista + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"></span></a>';

                return '<div class="btn-group"> ' + btn_edit + btn_delete +'</div>';
            }
        }],

        "drawCallback": function(settings) {

            $('[data-toggle="tooltip"]').tooltip();


        }

    });


}

function elimina_accionista(IdClienteAccionista){

    $.ajax({
        url: server + 'elimina_accionista',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id_accionista_cliente: IdClienteAccionista,
            

        },
        beforeSend: function() {

            loadingUI('eliminando...');
            
        },
        success: function(response) {


            if (response.status == "ok") {

                $('#table-cliente-accionistas').DataTable().ajax.reload();
                
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
function prepare_update_accionista(idClienteAccionista, nombre, apepat, apemat, cargo, participacion, dni) {


    $("#modal-edit-accionista").modal("show");

    $("#id_cliente_accionista_hidden").val(idClienteAccionista);
    $("#accionista_nombre").val(nombre);
    $("#accionista_pat").val(apepat);
    $("#accionista_mat").val(apemat);
    $("#porcentaje_accionista").val(participacion);
    $("#dni_accionista").val(dni);

    $("#cargos_accionista option[value=" + cargo + "]").prop("selected", true);

    $('#cargos_accionista').trigger("chosen:updated");


}


$("#btn_nuevo_accionista").on('click', function(e) {
    e.preventDefault();

    resetea_inputs_accionista();

});

function resetea_inputs_accionista() {

    $("#id_cliente_accionista_hidden").val(0);
    $("#accionista_nombre").val('');
    $("#accionista_pat").val('');
    $("#accionista_mat").val('');
    $("#porcentaje_accionista").val('');
    $("#dni_accionista").val('');

}


function valida_inputs_accionista() {

    let msj = '';

    if ($("#dni_accionista").val().trim() == "") {

        return 'Ingrese un número de dni';
    }

    if ($("#accionista_nombre").val().trim() == "") {

        return 'Ingrese un nombre';
    }

    return msj;

}

$("#salvar_accionista").on('click', function(e) {

    e.preventDefault();

    const rpta = valida_inputs_accionista();

    if (rpta == '') {

        save_accionista();

    } else {

        alertify.error(set_error_message_alertify(rpta));
    }


});

function save_accionista() {

    const id_accionista_cliente = $("#id_cliente_accionista_hidden").val();
    const nombres = $("#accionista_nombre").val();
    const apepat = $("#accionista_pat").val();
    const apemat = $("#accionista_mat").val();
    const dni = $("#dni_accionista").val();
    const porcentaje = $("#porcentaje_accionista").val();
    const cargo = $('#cargos_accionista').val();

    const id_cliente = $("#id_cliente_mod_accionista").val();


    $.ajax({
        url: server + 'salvar_accionista',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id_accionista_cliente: id_accionista_cliente,
            nombres: nombres,
            apepat: apepat,
            apemat: apemat,
            dni: dni,
            porcentaje: porcentaje,
            cargo: cargo,
            id_cliente: id_cliente

        },
        beforeSend: function() {

            $("#salvar_accionista").attr("disabled",true);
        },
        success: function(response) {


            if (response.status == "ok") {

                $('#table-cliente-accionistas').DataTable().ajax.reload();
                resetea_inputs_accionista();
                alertify.success(set_sucess_message_alertify(response.description));

            } else {

                alertify.error(set_error_message_alertify(response.description));
            }


            $.unblockUI();

        },
        error: function(jqXHR, textStatus, errorThrown) {

            ajaxError(jqXHR, textStatus, errorThrown);


            $.unblockUI();
        }, complete: function() {

            $("#salvar_accionista").attr("disabled",false);
        }

    });
}
//fin funciones accionistas


//funciones representantes

function prepare_modal_representantes(idCliente) {

    $("#modal-edit-representante").modal("show");

    $("#id_cliente_hidden").val(idCliente);

    list_cliente_representante(idCliente);

}


function list_cliente_representante(id_cliente) {

    destroy_data_table('table-cliente-representantes');

    var dataTable = $('#table-cliente-representantes').DataTable({
        ajax: {
            url: server + 'get_cliente_representantes',
            type: 'GET',
            data: {
                id_cliente: id_cliente

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
            "targets": [0, 1, 2, 3, 4],
            "className": "text-center"
        }],
        columns: [{
            data: 'NumDocRepresentante'
        }, {
            data: 'FullNombreRepresentante'
        }, {
            data: 'DescripcionCargo'
        }, {
            data: 'Periodo'
        }, {
            data: null,
            "render": function(data, type, full, meta) {

                const btn_edit = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Editar"' +
                'onclick="prepare_update_representante(\'' + data.FechaNacimiento + '\',\'' + data.NumDocRepresentante + '\',\'' + data.IdClienteRepresentante + '\',\'' + data.NombreRepresentante + '\',\'' + data.ApePatRepresentante + '\',\'' + data.ApeMatRepresentante + '\',\'' + data.Cargo + '\',\'' + data.FechaInicio + '\',\'' + data.FechaFin + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-success glyphicon glyphicon-edit"></span></a>';


                const btn_eliminar = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Eliminar"' +
                'onclick="elimina_representante(\'' + data.IdClienteRepresentante + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"></span></a>';

                return '<div class="btn-group"> ' + btn_edit + btn_eliminar +'</div>';
            }
        }],

        "drawCallback": function(settings) {

            $('[data-toggle="tooltip"]').tooltip();


        }

    });


}

function elimina_representante(IdClienteRepresentante){

    $.ajax({
        url: server + 'elimina_representante',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id_representante_cliente: IdClienteRepresentante,
            

        },
        beforeSend: function() {

            loadingUI('eliminando...');
            
        },
        success: function(response) {


            if (response.status == "ok") {

                $('#table-cliente-representantes').DataTable().ajax.reload();
                
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

function prepare_update_representante(feNacRepresentante,dniRepresentante,idClienteRepresentante, nombre, apepat, apemat, cargo, inicio, fin) {

    $("#modal-edit-representante").modal('show');
    $("#id_representante_cliente_hidden").val(idClienteRepresentante);
    $("#representante_nombre").val(nombre);
    $("#representante_pat").val(apepat);
    $("#representante_mat").val(apemat);
    $("#representante_feini").val(inicio);
    $("#representante_fefin").val(fin);
    
    $("#representante_fe_nac").val(feNacRepresentante);

    $("#representante_dni").val(dniRepresentante);
    $("#cargos_representante option[value=" + cargo + "]").prop("selected", true);

    $('#cargos_representante').trigger("chosen:updated");

}



$("#btn_nuevo_representante").on('click', function(e) {
    e.preventDefault();

    resetea_inputs_representante();

});

function resetea_inputs_representante() {

    $("#id_representante_cliente_hidden").val(0);
    $("#representante_nombre").val('');
    $("#representante_pat").val('');
    $("#representante_mat").val('');
    $("#representante_feini").val(resetea_fechas());
    $("#representante_fefin").val(resetea_fechas());
    $("#representante_fe_nac").val('');
    $("#representante_dni").val('');

}


function valida_inputs_representante() {

    let msj = '';

    if ($("#representante_dni").val().trim() == "") {

        return 'Ingrese un dni';
    }


    if ($("#representante_nombre").val().trim() == "") {

        return 'Ingrese un nombre';
    }

    if ($("#representante_pat").val().trim() == "") {

        return 'Ingrese un apellido paterno';
    }

    if ($("#representante_mat").val().trim() == "") {

        return 'Ingrese un apellido materno';
    }

    if ($("#representante_fe_nac").val().trim() == "") {

        return 'Ingrese una fecha de nacimiento';
    }

    return msj;

}
$("#salvar_representante").on('click', function(e) {

    e.preventDefault();

    const rpta = valida_inputs_representante();

    if (rpta == '') {

        save_representante();

    } else {

        alertify.error(set_error_message_alertify(rpta));
    }


});

function save_representante() {

    const id_representante_cliente = $("#id_representante_cliente_hidden").val();
    const nombres = $("#representante_nombre").val();
    const apepat = $("#representante_pat").val();
    const apemat = $("#representante_mat").val();
    const fe_inicio = $("#representante_feini").val();
    const fe_fin = $("#representante_fefin").val();
    const cargo = $('#cargos_representante').val();
    const fe_nacimiento = $('#representante_fe_nac').val();
    const dni = $('#representante_dni').val();
    const id_cliente = $("#id_cliente_hidden").val();


    $.ajax({
        url: server + 'salvar_representante',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id_representante_cliente: id_representante_cliente,
            nombres: nombres,
            apepat: apepat,
            apemat: apemat,
            fe_inicio: fe_inicio,
            fe_fin: fe_fin,
            cargo: cargo,
            id_cliente: id_cliente,
            dni:dni,
            fe_nacimiento:fe_nacimiento

        },
        beforeSend: function() {

            $("#salvar_representante").attr("disabled",true);
        },
        success: function(response) {


            if (response.status == "ok") {

                $('#table-cliente-representantes').DataTable().ajax.reload();
                resetea_inputs_representante();
                alertify.success(set_sucess_message_alertify(response.description));

            } else {

                alertify.error(set_error_message_alertify(response.description));
            }


            $.unblockUI();

        },
        error: function(jqXHR, textStatus, errorThrown) {

            ajaxError(jqXHR, textStatus, errorThrown);


            $.unblockUI();

        }, complete: function() {

            $("#salvar_representante").attr("disabled",false);
        }

    });
}
//fin funciones representante

function prepare_delete_cliente(identificador) {

    alertify.confirm("Confirmar eliminación", "Desea eliminar el registro ?.",
        function() {

            delete_cliente(identificador);

        },
        function() {
            alertify.error(set_error_message_alertify('Cancelado'));
        });
}

function delete_cliente(identificador) {

    $.ajax({
        url: server + 'delete_cliente',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            identificador: identificador

        },
        beforeSend: function() {

            loadingUI('eliminando...');
        },
        success: function(response) {


            if (response.status == "ok") {

                $('#tabla-cliente').DataTable().ajax.reload();
                alertify.success(set_sucess_message_alertify(response.description));

            } else {

                alertify.error(set_error_message_alertify(response.description));
            }


            $.unblockUI();

        },
        error: function(jqXHR, textStatus, errorThrown) {

            ajaxError(jqXHR, textStatus, errorThrown);


            $.unblockUI();
        },complete: function() {


        }

    });


}

$("#search_table_empresas").keyup(function() {

    _this = this;

    $.each($("#table-cliente-empresas tbody tr"), function() {

        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)

            $(this).hide();

        else

            $(this).show();

    });

});

//busqqueda ws por dni
$(".span_find_ruc_representante").on('click',function(){

    const tipo = $(this).attr("data-type");

    let dni ;

    if(tipo=="representante"){


        dni = $("#representante_dni").val().trim();

    }else if(tipo=="accionista"){

        dni = $("#dni_accionista").val().trim();
    }

    
    if(dni!=""){

        busca_datos_dni(dni,tipo);

    }else{

        alertify.error(set_error_message_alertify('Ingrese un dni'));
    }
})

function busca_datos_dni(dni,tipo){

    loadingUI('Buscando...');

    $.ajax({
        url: server + "buscar_dni",
        method: "get",
        data: {
            _token: '{{ csrf_token() }}',
            dni: dni
        },
        success: function(response) {

            console.log(response);

            if(response.status == "ok"){

                const nombres = response.data.nombres;
                const apepat = response.data.apellidoPaterno;
                const apemat = response.data.apellidoMaterno;

                if(tipo=="representante"){

                    $("#representante_nombre").val(nombres);
                    $("#representante_pat").val(apepat);
                    $("#representante_mat").val(apemat);


                }else if(tipo=="accionista"){

                    $("#accionista_nombre").val(nombres);
                    $("#accionista_pat").val(apepat);
                    $("#accionista_mat").val(apemat);

                }
                

            }else{

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