 $(document).ready(function() {

     $(".chosen").chosen();

     $('input').iCheck({
         checkboxClass: 'icheckbox_flat',
         radioClass: 'iradio_flat'
     });


     let max_opciones = 10;

     $("#RolChecksMultiple_01").on('change', function() {


         if ($('#RolChecksMultiple_01').prop('checked')) {


             for (var i = 0; i < max_opciones; i++) {


                 if (i < 9) {

                     zero = "0";

                 } else {

                     zero = "";
                 }

                 $("#RolChecksMultiple_01" + zero + i).iCheck('check');
             }


         } else {


             for (var i = 0; i < max_opciones; i++) {

                 if (i < 9) {

                     zero = "0";

                 } else {

                     zero = "";
                 }

                 $("#RolChecksMultiple_01" + zero + i).iCheck('uncheck');
             }


         }

     })


     $("#RolChecksMultiple_02").on('change', function() {


         if ($('#RolChecksMultiple_02').prop('checked')) {


             for (var i = 0; i < max_opciones; i++) {


                 if (i < 9) {

                     zero = "0";

                 } else {

                     zero = "";
                 }

                 $("#RolChecksMultiple_02" + zero + i).iCheck('check');
             }


         } else {


             for (var i = 0; i < max_opciones; i++) {

                 if (i < 9) {

                     zero = "0";

                 } else {

                     zero = "";
                 }

                 $("#RolChecksMultiple_02" + zero + i).iCheck('uncheck');
             }


         }

     })


     $("#RolChecksMultiple_03").on('change', function() {


         if ($('#RolChecksMultiple_03').prop('checked')) {


             for (var i = 0; i < max_opciones; i++) {


                 if (i < 9) {

                     zero = "0";

                 } else {

                     zero = "";
                 }

                 $("#RolChecksMultiple_03" + zero + i).iCheck('check');
             }


         } else {


             for (var i = 0; i < max_opciones; i++) {

                 if (i < 9) {

                     zero = "0";

                 } else {

                     zero = "";
                 }

                 $("#RolChecksMultiple_03" + zero + i).iCheck('uncheck');
             }


         }

     })

     $("#RolChecksMultiple_04").on('change', function() {


         if ($('#RolChecksMultiple_04').prop('checked')) {


             for (var i = 0; i < max_opciones; i++) {


                 if (i < 9) {

                     zero = "0";

                 } else {

                     zero = "";
                 }

                 $("#RolChecksMultiple_04" + zero + i).iCheck('check');
             }


         } else {


             for (var i = 0; i < max_opciones; i++) {

                 if (i < 9) {

                     zero = "0";

                 } else {

                     zero = "";
                 }

                 $("#RolChecksMultiple_04" + zero + i).iCheck('uncheck');
             }


         }

     })

 });



 function opciones_seleccionadas() {

     const list_checks = $("input[name='RolChecksMultiple[]']").serializeArray();

     return list_checks;
 }

 function valida_inputs() {

     let msj = '';

     if ($("#descripcion_rol").val().trim() == "") {

         return 'ingrese una descripcion';
     }

     return msj;
 }

 $("#salvar_rol").on('click', function(e) {

     e.preventDefault();

     const valida = valida_inputs();

     if (valida == '') {

         salvar_rol();

     } else {

         alertify.error(set_error_message_alertify(valida));
     }


 })

 function salvar_rol() {

     const descripcion = $("#descripcion_rol").val();
     const estado = $('#estados_rol').val();
     const id_rol = $('#id_rol').val();
     const opciones = opciones_seleccionadas();

     $.ajax({
         url: server + 'salvar_rol',
         type: "post",
         dataType: 'json',
         data: {
             _token: $('meta[name="csrf-token"]').attr('content'),
             descripcion: descripcion,
             cobertura: 1,
             estado: estado,
             id_rol: id_rol,
             opciones: opciones
         },
         beforeSend: function() {

            $("#salvar_rol").attr("disabled",true);
         },
         success: function(response) {

             if (response.status == "ok") {

                 $("#modal-rol-create").modal("hide");
                 $('#tabla-rol').DataTable().ajax.reload();
                 alertify.success(set_sucess_message_alertify(response.description));
                 setTimeout(location.reload(), 10000);

             } else {

                 alertify.error(set_error_message_alertify(response.description));
             }


             $.unblockUI();

         },
         error: function(jqXHR, textStatus, errorThrown) {

             ajaxError(jqXHR, textStatus, errorThrown);

             $.unblockUI();
             
         },complete: function() {

           $("#salvar_rol").attr("disabled",false);
         }

     });

 }