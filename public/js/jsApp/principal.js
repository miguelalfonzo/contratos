$(document).ready(function() {

    $(".chosen").chosen();

    $(".chosen-select").chosen();

    $('.validanumeros').keypress(function(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;

            if (charCode != 46 && charCode > 31

                &&
                (charCode < 48 || charCode > 57))

                return false;



            return true;
        })
        .on("cut copy paste", function(e) {
            e.preventDefault();
        });

    $('.numerosenteros').on('input', function() {

        this.value = this.value.replace(/[^0-9]/g, '');

    }).on("cut copy paste", function(e) {

        e.preventDefault();
    });


});

const host = "localhost";

const server = "http://" + host + "/contratos/public/";



function loadingUI(message, color) {
    $.blockUI({
        baseZ: 2000,
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: color,
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            //opacity                  : 0.5,
            color: '#003465',
            //width                    : '40em'

        },
        message: '<h2><img style="margin-right: 30px" src="' + server + 'img/ajax-loader.gif" >' + message + '</h2>'
    });
}

function responseUI(message, color) {
    $.blockUI({
        baseZ: 2000,
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: color,
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: 0.5,
            color: '#fff'
        },
        message: '<h2 class="blockUIMensaje">' + message + '</h2>'
    });

    setTimeout(function() {
        $.unblockUI();
    }, 2000);
}

function changeSwitchery(element, checked) {
    if ((element.is(':checked') && checked == false) || (!element.is(':checked') && checked == true)) {
        element.parent().find('.switchery').trigger('click');
    }
}



function limitDecimalPlaces(e, count) {
    if (e.target.value.indexOf('.') == -1) {
        return;
    }
    if ((e.target.value.length - e.target.value.indexOf('.')) > count) {
        e.target.value = parseFloat(e.target.value).toFixed(count);
    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function validateNumber(evt) {

    var regex = new RegExp("^[0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
}

function validateAlfaNumerico(evt) {

    var regex = new RegExp("^[a-zA-Z0-9? ]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
}

function resetea_fechas() {

    var fecha_js = new Date();

    var anio_js = fecha_js.getFullYear();
    var dia_js = fecha_js.getDate()
    var mes_js = fecha_js.getMonth() + 1;

    if (dia_js < 10)
        dia_js = '0' + dia_js;
    if (mes_js < 10)
        mes_js = '0' + mes_js;

    var new_format = anio_js + "-" + mes_js + "-" + dia_js;

    return new_format;

}

function set_error_message_alertify(message) {


    return '<span><i class="fa fa-exclamation-triangle mr-2"></i>' + message + '</span>';
}

function set_sucess_message_alertify(message) {


    return '<span><i class="fa fa-check-circle-o mr-2"></i>' + message + '</span>';
}


function retorna_pagina_404() {

    $(location).attr('href', server + 'pagina_no_encontrada');

}

function solo_letras(evt) {

    let regex = new RegExp("^[a-zA-Z0-9]+$");
    let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
}


function sumar_dias_fecha(fecha_incial, dias_adicionar) {

    let dias = parseInt(dias_adicionar, 10) + 1;

    dias = dias * 24 * 60 * 60 * 1000;

    let fecha = new Date(fecha_incial);

    let fecha_final = fecha.getTime() + dias;

    fecha_final = new Date(fecha_final);

    let dia = fecha_final.getDate();
    if (dia < 10) {
        dia = '0' + dia;
    }
    let mes = fecha_final.getMonth() + 1;
    if (mes < 10) {
        mes = '0' + mes;
    }
    let año = fecha_final.getFullYear();

    fecha_final = dia + '/' + mes + '/' + año;

    return fecha_final;

}


function numero_a_formato_numerico(nStr) {


    nStr += '';
    let x = nStr.split('.');
    let x1 = x[0];
    let x2 = x.length > 1 ? '.' + x[1] : '';
    let rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;


}


function fecha_hoy() {

    let fecha_js = new Date();
    let anio_js = fecha_js.getFullYear();
    let dia_js = fecha_js.getDate()
    let mes_js = fecha_js.getMonth() + 1;

    if (dia_js < 10)
        dia_js = '0' + dia_js;
    if (mes_js < 10)
        mes_js = '0' + mes_js;

    let new_format = dia_js + "/" + mes_js + "/" + anio_js;

    return new_format;

}

function get_periodo_actual() {

    let fecha_js = new Date();
    let anio_js = fecha_js.getFullYear();
    let mes_js = fecha_js.getMonth() + 1;

    if (mes_js < 10)
        mes_js = '0' + mes_js;

    let new_format = anio_js + "-" + mes_js;

    return new_format;
}

function formato_numerico_a_numero(str_number) {

    let str_numero = str_number.replace(",", "");

    return Number(parseFloat(str_numero).toFixed(2));
}

function destroy_data_table(selector) {

    $('#' + selector).dataTable().fnClearTable();
    $('#' + selector).dataTable().fnDestroy();
}


function calcula_edad(birthday) {

    let birthday_arr = birthday.split("/");
    let birthday_date = new Date(birthday_arr[2], birthday_arr[1] - 1, birthday_arr[0]);
    let ageDifMs = Date.now() - birthday_date.getTime();
    let ageDate = new Date(ageDifMs);

    return Math.abs(ageDate.getUTCFullYear() - 1970);

}

$('body').click(function() {

    $('.list-autocompletar').fadeOut('fast');

});


function ajaxError(jqXHR, textStatus, errorThrown) {

    if (jqXHR.status === 0) {

        alert('Not connect: Verify Network.');

    } else if (jqXHR.status == 404) {

        alert('Requested page not found [404]');

    } else if (jqXHR.status == 500) {

        alert('Internal Server Error [500].');

    } else if (textStatus === 'parsererror') {

        alert('Requested JSON parse failed.');

    } else if (textStatus === 'timeout') {

        alert('Time out error.');

    } else if (textStatus === 'abort') {

        alert('Ajax request aborted.');

    } else {

        alert('Uncaught Error: ' + jqXHR.responseText);

    }

}