$(document).ready(function() {

    const cliente_id_consorcio = $('#cliente_id_consorcio').val();

    get_empresas_asociadas(cliente_id_consorcio);

});


function set_parametros_contacto(idClienteContacto) {

    $("#modal-cliente-contactos").modal('show');
    set_inputs_modal_contacto(idClienteContacto);


}

function set_inputs_modal_contacto(idClienteContacto) {

    $('#tabla_cliente_contactos tbody tr').each(function() {

        if ($(this).find("td").eq(5).html() == idClienteContacto) {

            $("#contacto_cliente").val($(this).find("td").eq(0).html());
            $("#telefono_cliente").val($(this).find("td").eq(1).html());
            $("#celular_cliente").val($(this).find("td").eq(2).html());
            $("#email_cliente").val($(this).find("td").eq(3).html());
            $("#id_cliente_contacto").val(idClienteContacto);

        }

    });


}



function elimina_contacto(IdClienteContacto) {
    alertify.confirm("Confirmar eliminación", "Desea eliminar el registro ?.",
        function() {

            $('#tabla_cliente_contactos tbody tr').each(function() {

                if ($(this).find("td").eq(5).html() == IdClienteContacto) {


                    $(this).remove();

                }

            });

        },
        function() {
            alertify.error(set_error_message_alertify('Cancelado'));
        });
}



function valida_inputs_contacto() {

    let msj = '';

    if ($("#contacto_cliente").val().trim() == "") {

        return 'Ingrese un nombre de contacto';
    }

    if ($("#telefono_cliente").val().trim() == "") {

        return 'Ingrese un teléfono de contacto';
    }

    if ($("#email_cliente").val().trim() != "") {

        if ($("#email_cliente").val().indexOf('@', 0) == -1 || $("#email_cliente").val().indexOf('.', 0) == -1) {

            return 'Ingrese un email válido';
        }
    }
    return msj;
}

function insertar_contacto() {

    const contacto = $("#contacto_cliente").val();
    const telefono = $("#telefono_cliente").val();
    const celular = $("#celular_cliente").val();
    const email = $("#email_cliente").val();
    const id_cliente_contacto = $("#id_cliente_contacto").val();


    if (id_cliente_contacto == 0) {

        const max_id = get_maximo_id_tabla_contacto();

        const botonera = '<a class="text-success btn-icon" onclick="set_parametros_contacto(\'' + max_id + '\')"><i class="fa fa-edit mr-2"></i></a><a class="text-danger btn-icon " onclick="elimina_contacto(\'' + max_id + '\')"><i class="fa fa-close"></i></a>';

        $("#tabla_cliente_contactos tbody").append("<tr><td>" + contacto + "</td><td>" + telefono + "</td><td>" + celular + "</td><td>" + email + "</td><td>" + botonera + "</td><td style='display: none'>" + max_id + "</td></tr>");

    } else {

        actualiza_tabla_contactos(id_cliente_contacto, contacto, telefono, celular, email);
    }


    $("#contacto_cliente").val('');
    $("#telefono_cliente").val('');
    $("#celular_cliente").val('');
    $("#email_cliente").val('');
    $("#id_cliente_contacto").val(0);
    $("#modal-cliente-contactos").modal('hide');
}

function actualiza_tabla_contactos(id_cliente_contacto, contacto, telefono, celular, email) {


    $('#tabla_cliente_contactos tbody tr').each(function() {

        if ($(this).find("td").eq(5).html() == id_cliente_contacto) {


            $(this).find("td").eq(0).html(contacto);
            $(this).find("td").eq(1).html(telefono);
            $(this).find("td").eq(2).html(celular);
            $(this).find("td").eq(3).html(email);

        }


    });

}

function get_maximo_id_tabla_contacto() {

    let values = [];

    if ($('#tabla_cliente_contactos tbody tr').length == 0) {

        var max_valor = 1;

    } else {

        $('#tabla_cliente_contactos tbody tr').each(function() {

            values.push($(this).find("td").eq(5).html());
        });

        var max_valor = Math.max.apply(null, values) + 1;
    }


    return max_valor;


}

$("#btn_confirmar_contacto").on('click', function(e) {

    e.preventDefault();

    const rpta = valida_inputs_contacto();

    if (rpta == '') {

        insertar_contacto();

    } else {

        alertify.error(set_error_message_alertify(rpta));
    }

});


$("#btn_agregar_contacto").on('click', function(e) {
    e.preventDefault();
    $("#modal-cliente-contactos").modal('show');
    $("#contacto_cliente").val('');
    $("#telefono_cliente").val('');
    $("#celular_cliente").val('');
    $("#email_cliente").val('');
    $("#id_cliente_contacto").val(0);


});


function valida_inputs_cliente() {

    let msj = '';

    if ($("#cliente_identificacion").val().trim() == "") {

        return 'Ingrese un número de documento';
    }

    if ($("#cliente_documento").val() == "") {

        return 'Seleccione un tipo de documento';
    }

    

    let regex_nom_comercial = /[A-Za-z0-9]{5,100}/;
    

    if(!regex_nom_comercial.test($('#cliente_ncomercial').val().trim())){

        return 'Ingrese un nombre comercial válido';

    }

    if ($("#cliente_moneda").val() == "") {

        return 'Seleccione una moneda';
    }

    if ($("#tipo_cliente").val() == "") {

        return 'Seleccione un tipo de cliente';

    } else if ($("#tipo_cliente").val() == "05") {

        const asociados = get_list_empresas_asociadas();

        if (asociados == "") {

            return 'Seleccione al menos un cliente para el consorcio';
        }
    }




    return msj;

}

function get_list_contactos_clientes() {

    let contactos = [];

    $('#tabla_cliente_contactos tbody tr').each(function() {

        row = {
            nombres: $(this).find("td").eq(0).html(),
            telefono: $(this).find("td").eq(1).html(),
            celular: $(this).find("td").eq(2).html(),
            email: $(this).find("td").eq(3).html()
        };
        contactos.push(row);
    });

    return contactos;

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

$("#form_cliente").submit(function(event) {

    event.preventDefault();

    const rpta = valida_inputs_cliente();

    if (rpta == '') {

        let formData = new FormData(document.getElementById("form_cliente"));

        const contactos = get_list_contactos_clientes();

        const empresas = get_list_empresas_asociadas();

        console.log(empresas);

        formData.append('contactos', JSON.stringify(contactos));

        formData.append('empresas', JSON.stringify(empresas));



        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: server + 'save_cliente',
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

                    const url = server + "clientes";

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



$('#cliente_ubigeo').keyup(function() {

    let query = $(this).val();

    $('#cliente_id_ubigeo').val('');

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

        $('#cliente_ubigeo').val(string);
        $('#ubigeo_list').fadeOut();

        const id_ubigeo = $(this).attr('data-ubigeo');

        $('#cliente_id_ubigeo').val(id_ubigeo);


    }


});



$("#tipo_cliente").on('change', function(e) {

    const value = $(this).val();

    $("#btn_empresas_consorcios").hide();

    if (value == "05") {

        $("#btn_empresas_consorcios").show();

    }



});


function prepara_modal_consorcio() {

    $("#modal-ver-empresas").modal('show');


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

        const full_string = string.split("-");

        const razon_social = full_string[1];
        
        agregar_nueva_empresa_consorcio(idcliente, identificacion, razon_social);

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

$("#search_table_empresas").keyup(function() {

    _this = this;

    $.each($("#table-cliente-empresas tbody tr"), function() {

        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)

            $(this).hide();

        else

            $(this).show();

    });

});


$("#search_table_contatos").keyup(function() {

    _this = this;

    $.each($("#tabla_cliente_contactos tbody tr"), function() {

        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)

            $(this).hide();

        else

            $(this).show();

    });

});



$("#cliente_documento").on('change',function(){

    const value = $(this).val();

    limpia_inputs_consulta();

    $("#cliente_identificacion").attr('maxlength','15');
    
    $("#span_find_ruc").hide();

    if(value == "CI"){

        const autogenerado = genera_codigo_interno(8);

        $("#cliente_identificacion").val(autogenerado);
        
    }else if(value == "RC"){

        $("#cliente_identificacion").attr('maxlength','11');
        $("#span_find_ruc").show();

    }else if(value == "DI"){

        $("#cliente_identificacion").attr('maxlength','8');
        $("#span_find_ruc").show();
    }


})

function genera_codigo_interno(length){

   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;


}

$("#span_find_ruc button").on("click",function(){

    const tipo_documento = $("#cliente_documento").val();

    if(tipo_documento == "RC"){

        const ruc = $("#cliente_identificacion").val().trim();

        const rpta = valida_ruc(ruc);

        if(rpta == ""){

            busca_datos_ruc(ruc);

        }else{

         alertify.error(set_error_message_alertify(rpta));

     }

 }else if(tipo_documento == "DI"){

    const dni = $("#cliente_identificacion").val().trim();

    const rpta = valida_dni(dni);

    if(rpta == ""){

        busca_datos_dni(dni);

    }else{

     alertify.error(set_error_message_alertify(rpta));

 }
}




})

function busca_datos_dni(dni){

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

                const full_name = nombres+' '+apepat+' '+apemat;

                $("#cliente_ncomercial").val(full_name);
                $("#cliente_rsocial").val(full_name);

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


function valida_dni(string){

    let msj = '';

    
    if(string.trim()==""){

        return 'Ingrese un dni';

    }

    if(string.length!="8"){

        return 'Ingrese un dni válido';

    }

    return msj;


}


function valida_ruc(string){

    let msj = '';

    
    if(string.trim()==""){

        return 'Ingrese un ruc';

    }

    if(string.length!="11"){

        return 'Ingrese un ruc válido';

    }

    return msj;
}


function busca_datos_ruc(ruc){

    loadingUI('Buscando...');

    $.ajax({
        url: server + "buscar_ruc",
        method: "get",
        data: {
            _token: '{{ csrf_token() }}',
            ruc: ruc
        },
        success: function(response) {

            console.log(response);

            if(response.status == "ok"){

                const razon_social = response.data.razonSocial;
                const nombre_comercial = response.data.nombreComercial;
                const act_eco = response.data.actEconomicas;
                const direccion = response.data.direccion;
                let actividad = '';

                if(act_eco!=""){

                    const string_act = act_eco[0].split("-");

                    if(string_act[2]!=""){

                        actividad = string_act[2];

                    }else{

                        actividad ='';
                    }

                }


                const ubigeo = response.data.ubigeo;
                const id_ubigeo = response.data.id_ubigeo;

                $("#cliente_rsocial").val(razon_social);
                $("#cliente_ncomercial").val(nombre_comercial);
                $("#cliente_actividad").val(actividad);
                $("#cliente_direccion").val(direccion);
                $("#cliente_ubigeo").val(ubigeo);
                $('#cliente_id_ubigeo').val(id_ubigeo);

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

function limpia_inputs_consulta(){

    $("#cliente_identificacion").val('');
    // $("#cliente_rsocial").val('');
    // $("#cliente_ncomercial").val('');
    // $("#cliente_actividad").val('');
    // $("#cliente_direccion").val('');
    // $("#cliente_ubigeo").val('');
    // $('#cliente_id_ubigeo').val('');


}