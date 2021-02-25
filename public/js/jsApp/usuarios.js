$(document).ready(function() {

    const state_filter = $('#filtro_usuario').val();

    load_list_users(state_filter);



});

function load_list_users(state) {

    var dataTable = $('#tabla-usuario').DataTable({
        ajax: {
            url: server + 'get_list_user',
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
            data: 'id'
        }, {
            data: 'PersonaUsuario'
        }, {
            data: 'email'
        }, {
            data: 'DescripcionRol'
        }, {
            data: 'Estado'
        }, {
            data: null,
            "render": function(data, type, full, meta) {

                const btn_edit = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Editar"' +
                    'onclick="prepare_update_user(\'' + data.id + '\')" style="cursor:pointer"><span style="font-size:80%;" class="text-success glyphicon glyphicon-edit"></span></a>';

                let btn_eliminar = '';

                let btn_reseteo = '';

                if (data.Estado == "Activo") {

                    btn_eliminar = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Eliminar"' +
                        'onclick="prepare_delete_user(\'' + data.id + '\')" style="cursor:pointer">' +
                        '<span style="font-size:80%;" class="text-danger glyphicon glyphicon-remove"></span></a> ';

                    btn_reseteo = '<a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn_resize" title="Restablecer Contraseña"' +
                        'onclick="prepare_reset_contrasena(\'' + data.id + '\')" style="cursor:pointer">' +
                        '<span style="font-size:80%;" class="text-warning glyphicon glyphicon-envelope"></span></a> ';
                }
                return '<div class="btn-group"> ' + btn_edit + btn_eliminar + btn_reseteo + '</div>';
            }
        }],

        rowCallback: function(row, data) {

            if (data.Estado == "Activo") {

                $($(row).find("td")[4]).html('<span style="text-align:right; font-size:135%;" class="btn btn-default btn_resize text-success glyphicon glyphicon-ok-sign"></span>');

            } else if (data.Estado == "Inactivo") {

                $($(row).find("td")[4]).html('<span style="text-align:right; font-size:135%;" class="btn btn-default btn_resize text-danger glyphicon glyphicon-remove-sign"></span>');
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


$("#filtro_usuario").on('change', function() {

    destroy_data_table('tabla-usuario');
    const value = $(this).val();
    load_list_users(value);
    $("#buscador_general").val("");

});

$("#btn_modal_usuario").on('click', function() {

    prepare_update_user(0);
});

function prepare_reset_contrasena(usuario) {

    alertify.confirm("Confirmar reseteo", "Desea resetear la contraseña del usuario ?.",
        function() {

            reset_contrasena(usuario);

        },
        function() {
            alertify.error(set_error_message_alertify('Cancelado'));
        });

}

function reset_contrasena(usuario) {

    $.ajax({
        url: server + 'reset_contrasena_usuario',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            usuario: usuario

        },
        before: function() {

        },
        success: function(response) {

            console.log(response);
            if (response.status == "ok") {


                $('#tabla-usuario').DataTable().ajax.reload();
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



function prepare_update_user(usuario) {


    $.ajax({
        url: server + 'get_user_detalle',
        type: "get",

        data: {
            _token: '{{ csrf_token() }}',
            usuario: usuario
        },
        before: function() {

        },
        success: function(response) {

            $("#modal-usuario-create").modal("show");
            $("#container_ajax_modal").html(response);



        },
        error: function(jqXHR, textStatus, errorThrown) {

            ajaxError(jqXHR, textStatus, errorThrown);
            console.log(jqXHR);
        }

    });

}







function prepare_delete_user(usuario) {

    alertify.confirm("Confirmar eliminación", "Desea eliminar el registro ?.",
        function() {

            delete_usuario(usuario);

        },
        function() {
            alertify.error(set_error_message_alertify('Cancelado'));
        });
}

function delete_usuario(usuario) {

    $.ajax({
        url: server + 'delete_user',
        type: "post",
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            usuario: usuario,

        },
        before: function() {

        },
        success: function(response) {

            console.log(response);

            if (response.status == "ok") {

                $('#tabla-usuario').DataTable().ajax.reload();
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