$(document).ready(function() {

    const state_filter = $('#filtro_roles').val();

    load_list_roles(state_filter);



});

function load_list_roles(state) {

    var dataTable = $('#tabla-rol').DataTable({
        ajax: {
            url: server + 'get_list_roles',
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
            data: 'IdRol'
        }, {
            data: 'Rol'
        }, {
            data: 'FlagActivo'
        }, {
            data: 'FechaCreacion'
        }, {
            data: 'UsuarioCreacion'
        }, {
            data: null,
            "render": function(data, type, full, meta) {

                const btn_edit = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Editar"' +
                    'onclick="prepare_update_rol(\'' + data.IdRol + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-success glyphicon glyphicon-edit"></span></a>';

                let btn_eliminar = '';

                if (data.Estado == "Activo") {

                    btn_eliminar = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Eliminar"' +
                        'onclick="prepare_delete_rol(\'' + data.IdRol + '\')" style="cursor:pointer">' +
                        '<span style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"></span></a> ';
                }
                return '<div class="btn-group"> ' + btn_edit + btn_eliminar + '</div>';
            }
        }],

        rowCallback: function(row, data) {

            if (data.FlagActivo == 1) {

                $($(row).find("td")[2]).html('<span style="text-align:right; font-size:135%;" class="btn btn-default btn_resize text-success glyphicon glyphicon-ok-sign"></span>');

            } else if (data.FlagActivo == 0) {

                $($(row).find("td")[2]).html('<span style="text-align:right; font-size:135%;" class="btn btn-default btn_resize text-danger glyphicon glyphicon-remove-sign"></span>');
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


$("#filtro_roles").on('change', function() {

    destroy_data_table('tabla-rol');
    const value = $(this).val();
    load_list_roles(value);
    $("#buscador_general").val("");

});

$("#btn_modal_rol").on('click', function() {

    prepare_update_rol(0);
});



function prepare_update_rol(rol) {


    $.ajax({
        url: server + 'get_rol_detalle',
        type: "get",

        data: {
            _token: '{{ csrf_token() }}',
            rol: rol
        },
        before: function() {

        },
        success: function(response) {

            $("#modal-rol-create").modal("show");
            $("#container_ajax_modal").html(response);



        },
        error: function(jqXHR, textStatus, errorThrown) {

            ajaxError(jqXHR, textStatus, errorThrown);
            console.log(jqXHR);
        }

    });

}

function prepare_delete_rol(rol) {

    alertify.confirm("Confirmar eliminación", "Desea eliminar el registro ?.",
        function() {

            delete_rol(rol);

        },
        function() {
            alertify.error(set_error_message_alertify('Cancelado'));
        });
}

function delete_rol(rol) {

    $.ajax({
        url: server + 'delete_rol',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            rol: rol,

        },
        before: function() {

        },
        success: function(response) {

            console.log(response);

            if (response.status == "ok") {

                $('#tabla-rol').DataTable().ajax.reload();
                alertify.success(set_sucess_message_alertify(response.description));

            } else {

                alertify.error(set_error_message_alertify(response.description));
            }


            $.unblockUI();

        },
        error: function(jqXHR, textStatus, errorThrown) {

            ajaxError(jqXHR, textStatus, errorThrown);
            console.log(jqXHR);

            $.unblockUI();
        }

    });


}