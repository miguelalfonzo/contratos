$(document).ready(function() {
    $(".chosen").chosen();
});

function changeProfile() {

    $('#setImage').click();
}

$('#setImage').change(function() {

    var imgPath = $(this)[0].value;
    var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg") {
        readURL(this);
    } else {
        alertify.error(set_error_message_alertify("Selecciona una imagen de tipo (jpg, jpeg, png)."))
    }
});


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.onload = function(e) {

            $('#preview').attr('src', e.target.result);
            $('#remove').val(0);
        }
    }
}

function removeImage() {

    $('#preview').attr('src', "img/noimage.png");
    $('#remove').val(1);
}


function validate_inputs() {

    let msj = '';

    let regex_email = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    let regex_password = /^.{8,}$/;

    if ($("#user_nombre").val().trim() == "") {

        msj = "ingrese un nombre.";

        return msj;
    }

    if ($("#ape_pat").val().trim() == "") {

        msj = "ingrese un apellido paterno.";

        return msj;
    }

    if ($("#ape_mat").val().trim() == "") {

        msj = "ingrese un apellido materno.";

        return msj;
    }


    if ($('#email_contacto').val().trim() != "") {

        if (!regex_email.test($('#email_contacto').val().trim())) {

            msj = "ingrese un correo de contacto válido.";

            return msj;

        }
    }


    if ($("#email").val().trim() == "") {

        msj = "ingrese un email.";

        return msj;

    } else if (!regex_email.test($('#email').val().trim())) {

        msj = "ingrese un email válido.";

        return msj;

    }



    if ($("#user_roles").val() == "") {

        msj = "seleccione un rol.";

        return msj;
    }

    return msj;

}


$("#form_user").submit(function(event) {

    event.preventDefault();

    const rpta = validate_inputs();

    if (rpta == '') {

        const formData = new FormData(document.getElementById("form_user"));

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: server + 'save_user',
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

                    $("#modal-usuario-create").modal("hide");
                    $('#tabla-usuario').DataTable().ajax.reload();
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


    } else {

        alertify.error(set_error_message_alertify(rpta));
    }


});