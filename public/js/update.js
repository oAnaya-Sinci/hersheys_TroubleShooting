/**
 * Codigo para obtener los elementos
 */

$('#element_parent').change(function() {

    var Element = $(this).val();

    /* var data = {
        data: formulario,
        _token: $('meta[name="csrf-token"]').attr('content')
    } */

    $.ajax({
        type: 'GET',
        url: '../Catalogos/modificar/getData?element=' + Element,
        // data: data,
        success: function(data) {

            data = JSON.parse(data);

            $("#element_update").empty();
            $("#element_update").append("<option value=''>Seleccionar Elemento</option>");

            /* if (Element != 'jrq-bussn')
                $("#element_update").append("<option value='NA'>No Aplica</option>"); */

            $.each(data, function(index, value) {

                $("#element_update").append("<option value='" + value.ctg_id + "'>" + value.ctg_name + "</option>");
            });
        },
        error: function(Message) {
            showError(Message);
        }
    });
});

/**
 * Codigo para guardar la informacion del elememto a modificar
 */

$('#updateCatalogos').click(function() {

    var formulario = $("#elementForm").serializeArray();

    var data = {
        data: formulario,
        _token: $('meta[name="csrf-token"]').attr('content')
    }

    console.log(data);

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "../TroubleShooting/upadateCatalogos",
        data: data,
        success: function() {

            $("#element_update").empty();
            $("#element_update").append("<option value=''>Seleccionar Elemento</option>");
        },
        error: function(Message) {
            showError(Message);
        }
    }).done(function(respuesta) {
        $('#successModal').modal('show');
        $('#element_parent').val('');
        $('#element_update  ').val('');
        $('#nombre_elemento').val('');
    });
});

function showError(Message) {

    if (Message.status == 419) {
        location.reload();
        return false;
    }

    console.log(Message.responseJSON);

    let htmlError = "<h5> Error " + Message.status + ": " + Message.statusText + "</h5>";
    htmlError += "<p>" + Message.responseJSON['message'] + "</p>";

    $('#ErrorModal .modal-header').addClass('modal-Error');

    $('#ErrorModal .modal-body').empty();
    $('#ErrorModal .modal-body').append(htmlError);


    $('#ErrorModal').modal('show');
}