$(document).ready(function() {



});

$('#obra_inicio').on('change', function() {


    const fecha_inicio = $(this).val();

    const dias_adicionar = $('#obra_dias').val();

    const fecha_fin = (dias_adicionar.length != 0) ? sumar_dias_fecha(fecha_inicio, dias_adicionar) : '';

    $('#obra_fin').val(fecha_fin);
})


$('#obra_dias').on('keyup', function() {

    const fecha_inicio = $('#obra_inicio').val();

    if (fecha_inicio.length == 0) {

        alertify.error("Seleccione fecha de inicio");

        $('#obra_dias').val('');

    } else {

        const dias_adicionar = $('#obra_dias').val();

        const fecha_fin = (dias_adicionar.length != 0) ? sumar_dias_fecha(fecha_inicio, dias_adicionar) : '';

        $('#obra_fin').val(fecha_fin);
    }


})

function valida_inputs_obra() {

    let msj = '';

    if ($("#obra_nombre").val().trim() == "") {

        return 'Ingrese un nombre para la obra';
    }

    if ($("#hidden_obra_idcliente").val().trim() == 0) {

        return 'Ingrese un cliente para la obra';
    }

    if ($("#hidden_obra_idcontratante").val().trim() == 0) {

        return 'Ingrese un beneficiario para la obra';
    }

    if ($("#hidden_obra_idfinanciero").val().trim() == 0) {

        return 'Ingrese un financiante para la obra';
    }

    if ($("#obra_monto").val().trim() == "") {

        return 'Ingrese un monto para la obra';
    }

    if ($("#obra_dias").val().trim() == "") {

        return 'Ingrese un número de dias para la obra';
    }
    return msj;
}

//ubigeo

$('#obra_ubigeo').keyup(function() {

    let query = $(this).val();

    $('#hidden_obra_idubigeo').val('');

    if (query != '') {

        $.ajax({
            url: server + "get_ubigeo",
            method: "get",
            data: {
                _token: '{{ csrf_token() }}',
                query: query
            },
            success: function(data) {

                $('#ubigeo_list').fadeIn();
                $('#ubigeo_list').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                ajaxError(jqXHR, textStatus, errorThrown);

            }
        });
    }
});

$(document).on('click', '#ubigeo_list ul li', function() {

    let string = $(this).text();

    if (string != "no se encontraron resultados") {

        $('#obra_ubigeo').val(string);
        $('#ubigeo_list').fadeOut();

        const id_ubigeo = $(this).attr('data-ubigeo');

        $('#hidden_obra_idubigeo').val(id_ubigeo);


    }


});



//todos los clientes

$('#obra_cliente').keyup(function() {

    let query = $(this).val();

    $('#hidden_obra_idcliente').val(0);

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

        $('#obra_cliente').val(string);
        $('#clientes_list').fadeOut();

        const id_cliente = $(this).attr('data-id');

        $('#hidden_obra_idcliente').val(id_cliente);


    }


});

//financieras

$('#obra_financia').keyup(function() {

    let query = $(this).val();

    $('#hidden_obra_idfinanciero').val(0);

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

        $('#obra_financia').val(string);
        $('#financiera_list').fadeOut();

        const id_cliente = $(this).attr('data-id');

        $('#hidden_obra_idfinanciero').val(id_cliente);


    }


});

//beneficiarias


$('#obra_beneficiario').keyup(function() {

    let query = $(this).val();

    $('#hidden_obra_idcontratante').val(0);

    if (query != '') {

        $.ajax({
            url: server + "get_combo_empresas",
            method: "get",
            data: {
                _token: '{{ csrf_token() }}',
                query: query,
                tipo: 'B'
            },
            success: function(data) {

                $('#beneficiario_list').fadeIn();
                $('#beneficiario_list').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                ajaxError(jqXHR, textStatus, errorThrown);

            }
        });
    }
});

$(document).on('click', '#beneficiario_list ul li', function() {

    let string = $(this).text();

    if (string != "no se encontraron resultados") {

        $('#obra_beneficiario').val(string);
        $('#beneficiario_list').fadeOut();

        const id_cliente = $(this).attr('data-id');

        $('#hidden_obra_idcontratante').val(id_cliente);


    }


});

$("#form_obra").submit(function(event) {

    event.preventDefault();

    const rpta = valida_inputs_obra();

    if (rpta == '') {


        let formData = new FormData(document.getElementById("form_obra"));

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: server + 'salvar_obra',
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


    } else {

        alertify.error(set_error_message_alertify(rpta));
    }


});