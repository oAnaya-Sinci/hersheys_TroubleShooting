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
    }).done(function(respuesta) {
        $('#successModal').modal('show');
        $('#element_parent').val('');
        $('#element_update  ').val('');
        $('#nombre_elemento').val('');
    });
});