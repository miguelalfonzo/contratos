$(document).ready(function() {
    id_ubigeo = '';
    desc_dist = '';
    desc_prov = '';
    desc_dpto = '';
    var dt = $('#table_ubigeo').DataTable({

        ajax: {
            url: server + 'get_departamentos',
            type: 'GET',
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
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Pronvicias",
            "infoEmpty": "Mostrando 0 to 0 of 0 Pronvicias",
            "infoFiltered": "(Filtrado de _MAX_ total Pronvicias)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Pronvicias",
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
        deferRender: true,
        //processing: true,
        scrollY: 420,
        scrollCollapse: true,
        scroller: false,
        columns: [{
            "class": "details-control",
            "orderable": false,
            "data": null,
            "defaultContent": ""
        }, {
            "data": "IdUbigeo"
        }, {
            "data": "DPTO"
        }, {
            data: null,
            "render": function(data, type, d, meta) {
                return '<span title ="Editar Departamento">' +
                    '<button onclick="prepare_departamento(1,\'' + data.DPTO + '\',\'' + data.IdUbigeo + '\')" type="button" class="btn btn-default btn-sm" >' +
                    '<span class="text-success glyphicon glyphicon-edit" aria-hidden="true"></span>' +
                    '</button>' +
                    '</span>' +

                    '<span title ="Agregar Provincia">' +
                    '<button onclick="prepare_departamento(0,\'' + data.DPTO + '\',\'' + data.IdUbigeo + '\')" type="button" class="btn btn-default btn-sm" >' +
                    '<span class="glyphicon glyphicon-plus text-primary" aria-hidden="true"></span>' +
                    '</button>' +
                    '</span>';
            }
        }],
        rowCallback: function(row, data) {
            $($(row).find("td")[1]).html(data.IdUbigeo + '0000');
        },
        "order": [
            [1, 'asc']
        ]

    });


    var detailRows = [];

    $('#table_ubigeo tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = dt.row(tr);
        var idx = $.inArray(tr.attr('id'), detailRows);

        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();

            detailRows.splice(idx, 1);
        } else {
            tr.addClass('details');
            row.child(format(row.data())).show();

            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }
        }

    });

    dt.on('draw', function() {
        $.each(detailRows, function(i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        });

    });

    function format(d) {

        var departamento = d.IdUbigeo;
        return listarProvincias(departamento);
    }
});





function listarProvincias(departamento) {

    $.ajax({
        url: server + 'get_provincias',
        type: "get",
        dataType: 'json',
        data: {
            _token: '{{ csrf_token() }}',
            departamento: departamento
        },
        before: function() {},
        success: function(response) {

            console.log(response);

            $("#dpto_" + departamento + " ul").empty();

            for (var i = 0; i < response.length; i++) {

                $("#dpto_" + departamento + " ul").append(
                    "<li class='list-group-item' style='margin-top:5px;'>" +
                    "<span style='cursor:pointer' class='glyphicon glyphicon-chevron-up' id='btn_ocultar" + response[i].IdUbigeo + "' onclick='ocultar_distrito(\"" + response[i].IdUbigeo + "\")' aria-hidden='true'></span>" +
                    "<span style='cursor:pointer' class='glyphicon glyphicon-chevron-down' id='btn_desplegar_dist" + response[i].IdUbigeo + "' onclick='lista_distritos(\"" + response[i].IdUbigeo + "\")' aria-hidden='true'></span>" +

                    "&nbsp;&nbsp;&nbsp;&nbsp;" + response[i].IdUbigeo + "00" + "&nbsp;&nbsp;" + response[i].PROV +

                    "<span onclick='prepare_provincia(1,\"" + response[i].PROV + "\",\"" + response[i].IdUbigeo + "\")' class='text-success glyphicon glyphicon-edit' title ='Editar Provincia'  style='float:right; cursor:pointer; margin-left:15px;'>" +
                    "</span>" +

                    "<span onclick='prepare_provincia(0,\"" + response[i].PROV + "\",\"" + response[i].DPTO + "\",\"" + response[i].IdUbigeo + "\")' id='spam_create_dist" + response[i].IdUbigeo + "' class='glyphicon glyphicon-plus text-primary' title ='Nuevo Distrito'  style='float:right; cursor:pointer'>" +
                    "</span>" +

                    '<table style="margin-top:10px;" id="table_dis' + response[i].IdUbigeo + '" class="table tbl_out_margin" >' +

                    '<thead>' +
                    '<tr>' +
                    '<th>Código</th>' +
                    '<th>Distrito</th>' +
                    '<th>Acción</th>' +
                    '</tr>' +
                    '</thead>' +
                    '</table>' +
                    "</li>");

                $("#table_dis" + response[i].IdUbigeo).hide();
                $("#btn_ocultar" + response[i].IdUbigeo).hide();
                $("#spam_create_dist" + response[i].IdUbigeo).hide();
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {

            ajaxError(jqXHR, textStatus, errorThrown);
            console.log(jqXHR);
        }
    });

    return '<div class="container-fluid">' +
        '<div class="row">' +
        '<div class="col-12 col-md-6 col-md-offset-3">' +
        '<div class="panel panel-info">' +
        '<div class="panel-heading"><h4>Provincia : </h4></div>' +
        '<div class="panel-body">' +
        '<div id="dpto_' + departamento + '">' +
        '<ul class="list-group"></ul>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div><br>';
}

function prepare_distrito(id, distrito) { //Funciona
    //EDITAR DISTRITO
    limpia_inputs();
    $("#modal-create-dist").modal('show');
    $("#ubigeo_id").val(id);
    $("#ubigeo_distrito").val(distrito);
    modo = 'S';
    tipo = 'Update';
    $("#title_ubigeo").text('Actualizar Distrito');
    $("#div_dpto_ubigeo").hide();
    $("#div_prov_ubigeo").hide();
    $("#lbl_dist").text('Distrito');
}


function prepare_provincia(estado, provincia, departamento, id) { //funciona

    limpia_inputs();
    $("#modal-create-dist").modal('show');

    if (estado == 0) {
        //Nuevo Distrito
        $("#ubigeo_id").val(id);
        $("#ubigeo_departamento").val(departamento);
        $("#ubigeo_provincia").val(provincia);
        $("#title_ubigeo").text('Nuevo Distrito');

        modo = 'S';
        tipo = 'Insert';
        id_tabla_update = id; //agregado al id_tabla para reload

        $("#lbl_dpto").text('Departamento');
        $("#lbl_prov").text('Provincia');
        $("#lbl_dist").text('Distrito');

        $("#ubigeo_departamento").prop("readonly", true);
        $("#ubigeo_provincia").prop("readonly", true);

    } else {
        //Actualizar Provincia
        prov_update = provincia; //funciona como nombre provincia original para el update
        $("#ubigeo_id").val(departamento + '00');
        $("#ubigeo_distrito").val(provincia);
        $("#title_ubigeo").text('Actualizar Provincia');
        modo = 'P';
        tipo = 'Update';
        $("#lbl_btn_save").text('Actualizar');
        $("#div_dpto_ubigeo").hide();
        $("#div_prov_ubigeo").hide();

        $("#lbl_dist").text('Provincia');
    }
}

function prepare_departamento(estado, departamento, id) { //FUNCIONA

    limpia_inputs();
    $("#modal-create-dist").modal('show');

    if (estado == 1) {
        //Actualizar Departamento  
        $("#ubigeo_id").val(id + '0000');
        $("#ubigeo_distrito").val(departamento);
        $("#title_ubigeo").text('Actualizar Departamento');
        $("#lbl_btn_save").text('Actualizar');

        $("#div_dpto_ubigeo").hide();
        $("#div_prov_ubigeo").hide();

        $("#lbl_dist").text('Departamento');
        $("#lbl_btn_save").text('Actualizar');

        dpto_update = departamento; //nombre orginal del departamente para el update
        modo = 'D';
        tipo = 'Update';

    } else if (estado == 0) {
        //Nueva Provincia
        $("#title_ubigeo").text('Nueva Provincia');

        $("#div_dist_ubigeo").hide();
        $("#lbl_prov").text('Provincia');
        $("#lbl_dpto").text('Departamento');
        $("#ubigeo_id").val(id);
        $("#ubigeo_departamento").val(departamento);
        $("#ubigeo_departamento").prop("readonly", true);
        modo = 'P';
        tipo = 'Insert';
    }
}

function limpia_inputs() {
    $("#ubigeo_id").val('');
    $("#ubigeo_departamento").val('');
    $("#ubigeo_provincia").val('');
    $("#ubigeo_distrito").val('');

    $("#div_id_ubigeo").show();
    $("#div_dpto_ubigeo").show();
    $("#div_prov_ubigeo").show();
    $("#div_dist_ubigeo").show();
    $("#lbl_btn_save").text('Guardar');

    $("#ubigeo_departamento").prop("readonly", false);
    $("#ubigeo_provincia").prop("readonly", false);
}

function ocultar_distrito(provincia) {

    destroy_data_table('table_dis' + provincia);
    $("#table_dis" + provincia).hide();
    $("#btn_ocultar" + provincia).hide();
    $("#btn_desplegar_dist" + provincia).show();
    $("#spam_create_dist" + provincia).hide();
}

function lista_distritos(provincia) {

    destroy_data_table('table_dis' + provincia);
    load_ubigeo_Distritos(provincia);
    $("#table_dis" + provincia).show();
    $("#btn_ocultar" + provincia).show();
    $("#spam_create_dist" + provincia).show();
    $("#btn_desplegar_dist" + provincia).hide();
}

function destroy_data_table(selector) {
    $('#' + selector).dataTable().fnClearTable();
    $('#' + selector).dataTable().fnDestroy();
}


// funciones antiguas
function valida_inputs() {

    let msj = ' ';


    if ($('#title_ubigeo').text() == 'Nueva Provincia') {
        if ($("#ubigeo_provincia").val().trim() == "") {
            msj = 'El campo no puede estar vacío.';
        }

    } else {
        if ($("#ubigeo_distrito").val().trim() == "") {
            msj = 'El campo no puede estar vacío.';
        }
    }

    return msj;
}

$("#save_dist").on('click', function() {

    rpta = valida_inputs();

    if (rpta == ' ') {
        save_Ubigeo();
    } else {
        alertify.error(rpta);
    }
});

function save_Ubigeo() {

    id_ubigeo = $("#ubigeo_id").val();
    desc_dpto = $("#ubigeo_departamento").val();
    desc_dist = $("#ubigeo_distrito").val();

    if (modo == 'S') {
        desc_prov = $("#ubigeo_provincia").val();
    } else if (modo == 'P') {

        if (tipo == 'Insert') {
            desc_prov = $("#ubigeo_provincia").val();
        } else {
            desc_prov = prov_update;
        }
    } else if (modo == 'D') {

        if (tipo == 'Update') {
            desc_prov = dpto_update;
        }
    }


    $.ajax({
        url: server + 'save_Ubigeo',
        type: 'post',
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            id_ubigeo: id_ubigeo,
            desc_dpto: desc_dpto,
            desc_prov: desc_prov,
            desc_dist: desc_dist,
            modo: modo,
            tipo: tipo
        },
        beforeSend: function() {

            loadingUI('guardando...');
        },
        success: function(response) {

            console.log(response);
            if (response.status == "ok") {
                $("#modal-create-dist").modal("hide");

                if (modo == 'S') {
                    //$("#table_dis" + id_tabla_update).DataTable().ajax.reload();

                    $("#table_ubigeo").DataTable().ajax.reload();
                    //$.unblockUI();
                } else {
                    $("#table_ubigeo").DataTable().ajax.reload();
                    //$.unblockUI();
                }

                alertify.success(response.description);
            } else {
                alertify.error(response.description);
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


function load_ubigeo_Distritos(provincia) {

    $('#table_dis' + provincia).DataTable({
        ajax: {
            url: server + 'get_distritos',
            type: 'GET',
            dataSrc: '',
            data: {
                provincia: provincia
            },
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
            data: 'IdUbigeo'
        }, {
            data: 'DIST'
        }, {
            data: null,
            "render": function(data, type, full, meta) {
                return '<div class="btn-group"> ' +
                    '<a class="" title="Editar"' +
                    'style="cursor:pointer">' +

                    '<span onclick="prepare_distrito(\'' + data.IdUbigeo + '\',\'' + data.DIST + '\')" class="text-success glyphicon glyphicon-edit" style="align-content: center; margin-top:8px; margin-right: 8px; margin-left:8px; font-size:120%"></span></a> ' +
                    '</div>';
            }
        }]
    })
}