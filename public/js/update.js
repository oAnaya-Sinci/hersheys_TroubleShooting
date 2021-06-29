/**
 * Codigo para obtener los elementos
 */

$('#element_parent').change(function() {

    var Element = $(this).val();

    $.ajax({
        type: 'GET',
        url: '../Catalogos/modificar/getData?element=' + Element,
        // data: data,
        success: function(data) {

            data = JSON.parse(data);

            dataEle = data[0];
            parent = data[1];

            $("#element_update").empty();
            $("#element_update").append("<option value=''>Seleccionar Elemento</option>");

            $.each(dataEle, function(index, value) {

                $("#element_update").append("<option value='" + value.ctg_id + "'>" + value.ctg_name + "</option>");
            });

            $("#elemento_padre").empty();
            $("#elemento_padre").append("<option value=''>Elemento padre</option>");

            $.each(parent, function(index, value) {

                $("#elemento_padre").append("<option value='" + value.ctg_id + "'>" + value.ctg_name + "</option>");
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

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "/TroubleShooting/upadateCatalogos",
        data: data,
        success: function() {

            $("#element_update").empty();
            $("#element_update").append("<option value=''>Seleccionar Elemento</option>");

            $("#elemento_padre").empty();
            $("#elemento_padre").append("<option value=''>Seleccionar Elemento</option>");
        },
        error: function(Message) {
            showError(Message);
        }
    }).done(function(respuesta) {

        $("#elementForm")[0].reset();
        $('#successModal').modal('show');
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

/**
 *
 */
$('#element_update').change(function() {

    var data = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        data: $(this).val()
    }

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "/Catalogos/modificar/getParent",
        data: data,
        success: function(parent) {
            console.log(parent);
            $('#elemento_padre').val(parent);
        },
        error: function(Message) {
            showError(Message);
        }
    })
});
