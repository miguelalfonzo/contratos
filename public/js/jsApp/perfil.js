function changeProfile() {

    $('#setImage').click();
}

$('#setImage').change(function() {

    var imgPath = $(this)[0].value;
    var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg")
        readURL(this);
    else
        alertify.error(set_error_message_alertify("Selecciona una imagen de tipo (jpg, jpeg, png)."));
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

    $('#preview').attr('src', server + '/img/noimage.png');
    $('#remove').val(1);
}