$(document).ready(function() {

    const state_filter = $('#filtro_maestro').val();

    load_table_master(state_filter);

});


function load_table_master(state) {

    var dataTable = $('#tabla-maestra').DataTable({
        ajax: {
            url: server + 'get_list_maestro',
            type: 'GET',
            data: {
                state: state,
                id_tabla: 0
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
        "order": [
        [2, "desc"]
        ],
        columns: [{
            data: 'IdTabla'
        }, {
            data: 'Descripcion'
        }, {
            data: 'FechaCreacion'
        }, {
            data: 'FlagActivo'
        }, {
            data: null,
            "render": function(data, type, full, meta) {

                const btn_edicion = '<a class="btn btn-default btn_resize" data-toggle="tooltip" data-placement="bottom" title="Editar"' +
                'onclick="editar_tabla_cabecera(\'' + data.IdTabla + '\',\'' + data.Descripcion + '\',\'' + data.FlagActivo + '\')"style="cursor:pointer"> ' +
                '<span style="font-size:80%;" class=" text-success glyphicon glyphicon-edit"></span></a>' +

                '<a class="btn btn-default btn_resize" data-toggle="tooltip" data-placement="bottom" title="Ver Detalle"' +
                'onclick="ver_tabla_detalle(\'' + data.IdTabla + '\',\'' + data.Descripcion + '\')" ' +
                'style="cursor:pointer"><i style="font-size:80%;" class="text-primary fa fa-list"> ' +
                '</i></a>';

                let btn_delete = '';

                if (data.FlagActivo == 1) {

                    btn_delete = '<a class="btn btn-default btn_resize" data-toggle="tooltip" data-placement="bottom" title="Inactivar" ' +
                    'onclick="prepare_delete_tabla(\'' + data.IdTabla + '\',\'' + data.Descripcion + '\',0)" ' +
                    'style="cursor:pointer"><span  style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"> ' +
                    '</span></a>';
                }

                return '<div class="btn-group btn-group-icon-md"> ' + btn_edicion +
                btn_delete + '</div>';
            }
        }],
        columnDefs: [{
            targets: 2,
            render: $.fn.dataTable.render.moment('DD/MM/YYYY', 'DD/MM/YYYY')
        }],
        rowCallback: function(row, data) {

            if (data.FlagActivo == 1) {

                $($(row).find("td")[3]).html('<span style="text-align:center; font-size:135%;" class="btn btn-default btn_resize text-success glyphicon glyphicon-ok-sign"></span>');

            } else {
                $($(row).find("td")[3]).html('<span style="text-align:center; font-size:135%;" class="btn btn-default btn_resize text-danger glyphicon glyphicon-remove-sign"></span>');
            }
        },
        "drawCallback": function(settings) {

            $('[data-toggle="tooltip"]').tooltip();


        }
    })

    $("#buscador_general").keyup(function() {
        dataTable.search(this.value).draw();

    });
}


$("#filtro_maestro").on('change', function() {

    destroy_data_table('tabla-maestra');
    $("#buscador_general").val("");
    const value = $(this).val();
    load_table_master(value);


});


function prepare_delete_tabla(idTabla, descripcion, columna) {

    let titulo;

    let mensaje;

    if (columna == 0) {

        titulo = "Desactivar tabla.";
        mensaje = "¿Desea desactivar la tabla " + descripcion + "?";

    } else {

        titulo = "Desactivar registro.";
        mensaje = "¿Desea desactivar el registro " + descripcion + " de la tabla?";

    }

    alertify.confirm(titulo, mensaje,
        function() {

            eliminar_tabla(idTabla, columna);
        },
        function() {
            alertify.error(set_error_message_alertify('Cancelado'));
        });
}

function eliminar_tabla(idTabla, columna) {

    $.ajax({
        url: server + 'delete_table_maestro',
        type: "post",
        datatype: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            idTabla: idTabla,
            columna: columna
        },
        beforeSend: function() {

            loadingUI('eliminando...');
        },

        success: function(response) {

            if (response.status == "ok") {

                if (columna == 0) {

                    $('#tabla-maestra').DataTable().ajax.reload();


                } else {

                    $('#tabla-maestra-detalle').DataTable().ajax.reload();

                }

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

function limpia_inputs_modal_create() {

    $("#id_tabla").val(0);
    $("#descripcion").val('');
    $("#lbl_accion").text('Crear Nueva Tabla');
    $("#lbl_accion_maestro").text('Guardar');
    changeSwitchery($("#switch_estado"), true);
}




$('#modal-tabla-create').on('hide.bs.modal', function(e) {

    limpia_inputs_modal_create();
})

function editar_tabla_cabecera(idTabla, descripcion, state) {
    $("#modal-tabla-create").modal('show');
    $("#id_tabla").val(idTabla);
    $("#descripcion").val(descripcion);
    $("#lbl_accion").text('Editar Tabla - ' + descripcion);
    $("#lbl_accion_maestro").text('Actualizar');
    const boolean = (state == 1) ? true : false;

    if (!boolean) {
        changeSwitchery($("#switch_estado"), false);
    } else {
        changeSwitchery($("#switch_estado"), true);
    }


}


function limpia_inputs_modal_detalle() {

    $("#id_tabla_detalle").val(0);
    $("#id_columna_detalle").val(0);
    $("#descripcion_detalle").val('');
    $("#valor_maximo").text('(max 100 caracteres)');
    $("#valor").val('');
    $("#valor_cadena_detalle").val('');
    $("#DivFormDetalleTabla").hide();
    $("#DivTablaDetalle").show();
    $("#btnNuevoDetalleTabla").show();


    $("#buscador_general_detalle").val('');

    changeSwitchery($("#switch_estado_detalle"), true);
}



function ver_tabla_detalle(id_tabla, descripcion) {


    limpia_inputs_modal_detalle();
    $("#modal-detalle-master").modal("show");
    $("#descripcion_tabla").text(descripcion);
    destroy_data_table('tabla-maestra-detalle');
    get_detalle_tabla(id_tabla);
    $("#id_tabla_detalle").val(id_tabla);
}

function get_detalle_tabla(id_tabla) {



    var dataTable = $('#tabla-maestra-detalle').DataTable({
        ajax: {
            url: server + 'get_list_maestro',
            type: 'GET',
            data: {
                state: 2,
                id_tabla: id_tabla
            },
            dataSrc: ''
        },
        "initComplete": function(settings, json) {

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
            data: 'IdColumna'
        }, {
            data: 'Valor'
        }, {
            data: 'Descripcion'
        }, {
            data: 'FlagActivo'
        }, {
            data: 'FechaCreacion'
        }, {
            data: null,
            "render": function(data, type, full, meta) {

                const bnt_editar = '<a class="btn btn-default btn_resize" data-toggle="tooltip" data-placement="bottom" title="Editar"' +
                'onclick="get_inputs_details(\'' + data.IdTabla + '\',\'' + data.Valor + '\',\'' + data.IdColumna + '\',\'' + data.Descripcion + '\',\'' + data.FlagActivo + '\',\'' + data.ValorCadena + '\',\'' + data.ValorNumerico + '\',\'' + data.IdColumnaPadre + '\',\'' + data.ValorColumnaPadre + '\')"' +
                ' style="cursor:pointer"><span class="text-warning glyphicon glyphicon-pencil">' +
                '</span></a>';

                let btn_eliminar = '';

                if (data.FlagActivo == 1) {

                    btn_eliminar = '<a class="btn btn-default btn_resize" data-toggle="tooltip" data-placement="bottom" title="Inactivar"' +
                    ' onclick="prepare_delete_tabla(\'' + data.IdTabla + '\',\'' + data.Descripcion + '\',\'' + data.IdColumna + '\')"' +
                    'style="cursor:pointer"><span class="text-danger glyphicon glyphicon-remove"> ' +
                    '</span></a>';
                }

                return '<div class="btn-group btn-group-icon-md">' + bnt_editar +
                btn_eliminar + '</div>';


            }

        }],
        columnDefs: [],
        rowCallback: function(row, data) {

            if (data.FlagActivo == 1) {

                $($(row).find("td")[3]).html('<span style="text-align:center; font-size:115%;" class="btn btn-default btn_resize text-success glyphicon glyphicon-ok-sign"></span>');

            } else {
                $($(row).find("td")[3]).html('<span style="text-align:center; font-size:115%;" class="btn btn-default btn_resize text-danger glyphicon glyphicon-remove-sign"></span>');
            }
        },
        "drawCallback": function(settings) {

            $('[data-toggle="tooltip"]').tooltip();


        }
    });


    $("#buscador_general_detalle").keyup(function() {
        dataTable.search(this.value).draw();

    });
}

$("#btnNuevoDetalleTabla").on('click', function(e) {

    e.preventDefault();

    $("#id_columna_detalle").val(0);
    $("#descripcion_detalle").val('');

    const id_tabla_detalle = $("#id_tabla_detalle").val();
    set_valor_maximo_cadena(id_tabla_detalle);

    $("#valor").val('');
    $("#valor_cadena_detalle").val('');

    $("#DivFormDetalleTabla").show();
    $("#DivTablaDetalle").hide();
    changeSwitchery($("#switch_estado_detalle"), true);

});


$("#btnVolverDetalle").on('click', function(e) {

    e.preventDefault();
    $("#DivFormDetalleTabla").hide();
    $("#DivTablaDetalle").show();
    $("#btnNuevoDetalleTabla").show();

});

$("#salva_maestro").on('click', function() {

    const rpta = valida_inputs_modal_create();

    if (rpta == '') {

        save_master();

    } else {

        alertify.error(set_error_message_alertify(rpta));
    }
});


function valida_inputs_modal_create() {

    let msj = '';

    if ($("#descripcion").val().trim() == "") {

        msj = 'Ingrese una descripción.';
    }

    return msj;
}

function save_master() {

    const descripcion = $("#descripcion").val();
    const checked = $("input[name='switch_estado']").prop('checked');
    const flag_activo = (checked) ? 1 : 0;
    const id_tabla = $("#id_tabla").val();
    

    $.ajax({
        url: server + 'save_maestro',
        type: "post",
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            det_valor: '',
            det_id_columna: 0,
            id_tabla: id_tabla,
            descripcion: descripcion,
            flag_activo: flag_activo,
            valor_cadena: '',
            modo: 'C'
        },
        beforeSend: function() {$("#salva_maestro").attr("disabled", true);},
        success: function(response) {

            

            if (response.status == "ok") {

                $("#modal-tabla-create").modal("hide");
                $('#tabla-maestra').DataTable().ajax.reload();
                alertify.success(set_sucess_message_alertify(response.description));

            } else {

                alertify.error(set_error_message_alertify(response.description));
            }

            $.unblockUI();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            

            ajaxError(jqXHR, textStatus, errorThrown);

            $.unblockUI();

        }, complete : function(xhr, status) {

            $("#salva_maestro").attr("disabled", false);
        }
    });
}

function set_valor_maximo_cadena(idTabla) {

    if (idTabla == 58 || idTabla == 1009) {

        $("#valor_maximo").text('(max 3 caracteres)');

    } else if (idTabla == 17 || idTabla == 80) {

        $("#valor_maximo").text('(max 2 caracteres)');

    } else {

        $("#valor_maximo").text('(max 100 caracteres)');
    }
}

function get_inputs_details(idTabla, valor, idColumna, descripcion, flagActivo, valorCadena,
    valornumerico, idColPadre, valorColumnaPadre) {


    $("#DivFormDetalleTabla").show();
    $("#DivTablaDetalle").hide();
    $("#btnNuevoDetalleTabla").hide();
    $("#id_tabla_detalle").val(idTabla);
    $("#id_columna_detalle").val(idColumna);
    $("#descripcion_detalle").val(descripcion);
    $("#valor").val(valor);

    set_valor_maximo_cadena(idTabla);

    var valorCadena = (valorCadena == "null") ? '' : valorCadena;

    $("#valor_cadena_detalle").val(valorCadena);

    const boolean = (flagActivo == 1) ? true : false;

    if (!boolean) {
        changeSwitchery($("#switch_estado_detalle"), false);
    } else {
        changeSwitchery($("#switch_estado_detalle"), true);
    }

}



$("#btnSaveTablaDetalle").on('click', function() {

    const rpta = valida_inputs_detalle();

    if (rpta == '') {

        save_master_detalle();

    } else {

        alertify.error(set_error_message_alertify(rpta));
    }
});




function valida_inputs_detalle() {

    let msj = '';

    if ($("#descripcion_detalle").val().trim() == "") {

        msj = 'Ingrese una descripción.';
    }

    if ($("#valor").val().trim() == "") {

        msj = 'Ingrese un valor.';
    }

    return msj;
}




function save_master_detalle() {


    const id_tabla = $("#id_tabla_detalle").val();
    const det_id_columna = $("#id_columna_detalle").val();
    const descripcion = $("#descripcion_detalle").val();
    const valor_cadena = $("#valor_cadena_detalle").val();
    const checked = $("input[name='switch_estado_detalle']").prop('checked');
    const flag_activo = (checked) ? 1 : 0;
    const det_valor = $("#valor").val();

    $.ajax({
        url: server + 'save_maestro',
        type: "post",
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            det_valor: det_valor,
            det_id_columna: det_id_columna,
            id_tabla: id_tabla,
            descripcion: descripcion,
            flag_activo: flag_activo,
            valor_cadena: valor_cadena,
            modo: 'D'
        },
        beforeSend: function() {
            $("#btnSaveTablaDetalle").attr("disabled",true);
        },
        success: function(response) {


            if (response.status == "ok") {


                $('#tabla-maestra-detalle').DataTable().ajax.reload();


                $('#DivFormDetalleTabla').hide();
                $('#DivTablaDetalle').show();
                $('#btnNuevoDetalleTabla').show();

                //$('#modal-detalle-master').modal('hide');
                alertify.success(set_sucess_message_alertify(response.description));

            } else {

                alertify.error(set_error_message_alertify(response.description));
            }


        },
        error: function(jqXHR, textStatus, errorThrown) {
            ajaxError(jqXHR, textStatus, errorThrown);
            console.log(jqXHR);

        }, complete : function(xhr, status) {

            $("#btnSaveTablaDetalle").attr("disabled", false);
        }
    });
}