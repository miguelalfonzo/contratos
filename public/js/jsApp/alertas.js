

$(".alerta-cartas-fianzas").on("click",function(event){

    event.preventDefault(); 

    const tipo = $(this).attr('data-type');

    const label = retorna_label_alerta(tipo);

    $('#span_alerta_fianza_label').text('Fianzas '+label);

    set_table_alertas_fianzas(tipo);

    $('#modal-alertas-fianzas').modal('show');


    $('#btn_exportar_fianzas_alertas').attr('data-exp',tipo);

});

$('#btn_exportar_fianzas_alertas').on('click',function(){


    const tipo = $(this).attr('data-exp');

    window.location.href = server + "export_alertas_fianzas/"+tipo;

})


$(".alerta-garantias").on("click",function(event){

    event.preventDefault(); 

    const tipo = $(this).attr('data-type');

    const label = retorna_label_alerta(tipo);

    $('#span_alerta_garantia_label').text('Garantias '+label);

    set_table_alertas_garantias(tipo);

    $('#modal-alertas-garantias').modal('show');


});

function retorna_label_alerta(tipo){

   let descripcion = '';

   if(tipo == 'vence-hoy'){

    descripcion='Que Vencen Hoy';

}else if(tipo == 'vencidas'){

    descripcion='Vencidas';

}else if(tipo == 'por-vencer'){

    descripcion='Por Vencer';
}

return descripcion;
}


function set_table_alertas_fianzas(tipo){

    destroy_data_table('tabla-alertas-fianzas');

    $("#buscador_alertas_fianzas").val('');

    var dataTable = $('#tabla-alertas-fianzas').DataTable({
        ajax: {
            url: server + 'get_alertas_fianzas',
            type: 'GET',
            data: {

                tipo: tipo
            },
            dataSrc: '',
            beforeSend: function() {
                loadingUI('filtrando');
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
            data: 'NameCliente'
        }, {
            data: 'NameBeneficiario'
        }, {
            data: 'NameFinanciera'
        }, {
            data: 'CartaFianza'
        },{
            data: 'CodigoCarta'
        }, {
            data: 'MontoMoneda'
        }, {
            data: 'FechaVence'
        }]

    });

    $("#buscador_alertas_fianzas").keyup(function() {
        dataTable.search(this.value).draw();

    });


}




function set_table_alertas_garantias(tipo){

    destroy_data_table('tabla-alertas-garantias');

    $("#buscador_alertas_garantias").val('');

    var dataTable = $('#tabla-alertas-garantias').DataTable({
        ajax: {
            url: server + 'get_alertas_garantias',
            type: 'GET',
            data: {

                tipo: tipo
            },
            dataSrc: '',
            beforeSend: function() {
                loadingUI('filtrando');
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
            data: 'Garantia'
        }, {
            data: 'NumeroDocumento'
        }, {
            data: 'Moneda'
        }, {
            data: 'MontoCarta', 
            render: $.fn.dataTable.render.number(',', '.', 2, '')
        }, {
            data: 'Porcentaje', 
            render: $.fn.dataTable.render.number(',', '.', 2, '')
        }, {
            data: 'Monto', 
            render: $.fn.dataTable.render.number(',', '.', 2, '')
        }, {
            data: 'FechaEmision'
        },{
            data: 'FechaVencimiento'
        },{
            data: 'FechaCobro'
        },{
            data: 'Estado'
        }]

    });

    $("#buscador_alertas_garantias").keyup(function() {
        dataTable.search(this.value).draw();

    });


}



$(".alerta-cumpleanos").on("click",function(event){

    event.preventDefault(); 

    const tipo = $(this).attr('data-type');

    $('#btn_exportar_todos_cumpleanos').hide();

    let descripcion = '';

    if(tipo == 'cumpleanos-hoy'){

        descripcion='Hoy';

    }else if(tipo == 'proximos-cumpleanos'){

        descripcion='Próximos';

    }else if(tipo == 'todos'){

        $('#btn_exportar_todos_cumpleanos').show();

        descripcion='Todos';

    }

    $('#span_alerta_cumpleanos_label').text('Cumpleaños '+descripcion);

    set_table_alertas_cumpleanos(tipo);

    $('#modal-alertas-cumpleanos').modal('show');


});



function set_table_alertas_cumpleanos(tipo){

    destroy_data_table('tabla-alertas-cumpleanos');

    $("#buscador_alertas_cumpleanos").val('');

    var dataTable = $('#tabla-alertas-cumpleanos').DataTable({
        ajax: {
            url: server + 'get_alertas_cumpleanos',
            type: 'GET',
            data: {

                tipo: tipo
            },
            dataSrc: '',
            beforeSend: function() {
                loadingUI('filtrando');
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
            data: 'NameEmpresa'
        }, {
            data: 'Representante'
        },{
            data: 'TelefonoRepresentante'
        },{
            data: 'EmailRepresentante'
        }, {
            data: 'FechaCumpleanos'
        }]

    });

    $("#buscador_alertas_cumpleanos").keyup(function() {
        dataTable.search(this.value).draw();

    });


}

function exportar_todos_cumpleanos(){

   
    window.location.href = server + "export_todos_cumpleanos";

}

