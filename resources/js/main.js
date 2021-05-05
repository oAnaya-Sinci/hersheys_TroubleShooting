jQuery(document).ready(function($) {
    if (window.jQuery().datetimepicker) {
        $('.datetimepicker').datetimepicker({
            // Formats
            // follow MomentJS docs: https://momentjs.com/docs/#/displaying/format/
            format: 'DD-MM-YYYY',

            // Your Icons
            // as Bootstrap 4 is not using Glyphicons anymore
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-check',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            }
        });

        $('.datetimepicker-hour').datetimepicker({
            // Formats
            // follow MomentJS docs: https://momentjs.com/docs/#/displaying/format/

            // format: 'hh:mm A',
            format: 'HH:mm',

            // Your Icons
            // as Bootstrap 4 is not using Glyphicons anymore
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-check',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            }
        });
    }

    // var elementsSlct = ["jrq-bussn", "jrq-area", "jrq-line", "jrq-equipmnet", "jrq-system", "jrq-component", "jrq-ctrlPanl", "jrq-issue", "jrq-action"];

    /* var elementsSlct = ["jrq-bussn"];

    $.each(elementsSlct, function(index, value) {

        getDataSelcts(value, null);

    }); */

    /* console.log(Cookies.get('XSRF-TOKEN'));
    console.log(Cookies.get('hersheys_session'));

    Cookies.set('XSRF-TOKEN', '12345678', { expires: 1, path: '/' });

    console.log(Cookies.get('XSRF-TOKEN')); */

});

$('#startTime').blur(function() {

    var st = $(this).val();
    var et = $('#endTime').val();

    calculeTotalTime(st, et);
});

$('#endTime').blur(function() {

    var st = $('#startTime').val();
    var et = $(this).val();

    calculeTotalTime(st, et);
});

function calculeTotalTime(st, et) {

    st = st.split(':');
    et = et.split(':');

    var tt_h = parseInt(et[0]) - parseInt(st[0]);
    var tt_m = 0;

    if (tt_h < 0) {

        $('#startTime').val('');
        $('#endTime').val('');

        $('#MessageModal .modal-body').empty();
        $('#MessageModal .modal-body').append('El campo "Start Time" no puede ser mayor al campo "EndTime"');
        $('#MessageModal').modal('show');

        return false;
    }

    if (parseInt(et[1]) < parseInt(st[1]) && tt_h > 0) {

        tt_h -= 1;
        tt_m = (parseInt(et[1]) + 60) - parseInt(st[1]);

    } else if (parseInt(et[1]) < parseInt(st[1]) && tt_h == 0) {

        $('#startTime').val('');
        $('#endTime').val('');

        $('#MessageModal .modal-body').empty();
        $('#MessageModal .modal-body').append('El campo "Start Time" no puede ser mayor al campo "EndTime"');
        $('#MessageModal').modal('show');

        return false;

    } else {

        tt_m = parseInt(et[1]) - parseInt(st[1])
    }

    var tt = (tt_h < 10 ? "0" + tt_h : tt_h) + ":" + (tt_m < 10 ? "0" + tt_m : tt_m);

    $('#totalTime').val(tt);
}

/**
 * Codigo para obtener los elementos
 */

$('#element_type').change(function() {

    var Element = $(this).val();

    var data = {
        data: Element,
        _token: $('meta[name="csrf-token"]').attr('content')
    }

    $.ajax({
        type: 'POST',
        url: '../Catalogos/getDataElement',
        data: data,
        success: function(data) {

            data = JSON.parse(data);

            $("#element_parent").empty();
            $("#element_parent").append("<option value=''>Seleccionar Elemento</option>");

            // if (Element != 'jrq-bussn')
            //     $("#element_parent").append("<option value='NA'>No Aplica</option>");

            $.each(data, function(index, value) {

                $("#element_parent").append("<option value='" + value.ctg_id + "'>" + value.ctg_name + "</option>");
            });
        }
    });
});

/**
 * Codigo para guardar los catalogos
 */

$('#storeCatalogos').click(function() {

    var formulario = $("#elementForm").serializeArray();

    var data = {
        data: formulario,
        _token: $('meta[name="csrf-token"]').attr('content')
    }

    console.log(data);

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "../Catalogos/storeCatalogos",
        data: data,
    }).done(function(respuesta) {
        $('#successModal').modal('show');
        $('#element_type').val('');
        $('#nombre_elemento').val('');
        $('#element_parent').val('');
    });
});

/**
 * Funciones para el registro de las incidencias
 */

$('#jrq-bussn').change(function() {

    var Element = "jrq-area";
    getDataSelcts(Element, $('#jrq-bussn').val());
});

$('#jrq-area').change(function() {

    var Element = "jrq-line";
    getDataSelcts(Element, $('#jrq-area').val());
});

$('#jrq-line').change(function() {

    var Element = "jrq-equipmnet";
    getDataSelcts(Element, $('#jrq-line').val());
});

$('#jrq-equipmnet').change(function() {

    var Element = "jrq-system";
    getDataSelcts(Element, $('#jrq-equipmnet').val());
});

$('#jrq-system').change(function() {

    var Element = "jrq-component";
    getDataSelcts(Element, $('#jrq-system').val());

    Element = "jrq-ctrlPanl";
    getDataSelcts(Element, $('#jrq-system').val());
});

function getDataSelcts(element, select) {


    var data = [element, select];

    var data = {
        data: data,
        _token: $('meta[name="csrf-token"]').attr('content')
    }

    $.ajax({
        type: 'POST',
        url: '../TroubleShooting/getDataSelects',
        data: data,
        success: function(data) {

            data = JSON.parse(data);

            $("#" + element).empty();
            $("#" + element).append("<option value=''>Seleccionar Elemento</option>");

            $.each(data, function(index, value) {

                $("#" + element).append("<option value='" + value.ctg_id + "'>" + value.ctg_name + "</option>");
            });
        }
    });
}

/**
 * Codigo para guardar las incidencias
 */

$('#storeIncidencias').click(function() {

    var formulario = $("#incidencias").serializeArray();

    var data = {
        data: formulario,
        _token: $('meta[name="csrf-token"]').attr('content')
    }

    console.log(data);

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "../TroubleShooting/storeIncidencias",
        data: data,
    }).done(function(respuesta) {
        $('#successModal').modal('show');
    });
});

/*
    Funcion para eliminar las cookies de el registro de inicio de sesion
*/
/* $('#logoutBtn').click(function() {


    Cookies.remove();
}); */