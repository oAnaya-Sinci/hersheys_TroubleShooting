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

    // var data = {
    //     _token: $('meta[name="csrf-token"]').attr('content')
    // }

    // $('.table-bordered.usuarios').DataTable({
    //     ajax: {
    //         url: '/usuarios/consultarTable',
    //         type: 'POST',
    //         data: data
    //     },
    //     columns: [ //or different depending on the structure of the object
    //         { "data": "user.id" },
    //         { "data": "user.name" },
    //         { "data": "user.email" },
    //         { "data": "user.admin_user" },
    //         { "data": "user.created_at" }
    //     ]
    // });

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

    let ReportD = $('#ReportingDate').val();
    let ClosingD = $('#ClosingDate').val();

    var rd = 0;
    var cd = 0;
    var dd = 1;

    ReportD = ReportD.split("-");
    rd = ReportD[0];
    ReportD = ReportD[2] + "-" + ReportD[1] + "-" + ReportD[0];
    ReportD = new Date(ReportD);
    ReportD.setDate(ReportD.getDate() + 1);

    ClosingD = ClosingD.split("-");
    cd = ClosingD[0];
    ClosingD = ClosingD[2] + "-" + ClosingD[1] + "-" + ClosingD[0];
    ClosingD = new Date(ClosingD);
    ClosingD.setDate(ClosingD.getDate() + 1);

    dd = ((parseInt(cd) - parseInt(rd)) * 24);

    ReportD = Date.parse(ReportD) / 1000;
    ClosingD = Date.parse(ClosingD) / 1000;

    st = st.split(':');
    et = et.split(':');

    if (ReportD < ClosingD)
        et[0] = parseInt(et[0]) + parseInt(dd);

    var tt_h = parseInt(et[0]) - parseInt(st[0]);
    var tt_m = 0;

    if (tt_h < 0) {

        $('#startTime').val('');
        $('#endTime').val('');

        $('#ErrorModal .modal-body').empty();
        $('#ErrorModal .modal-body').append('El campo "Start Time" no puede ser mayor al campo "EndTime"');

        $('#ErrorModal').modal('show');

        return false;
    }

    if (parseInt(et[1]) < parseInt(st[1]) && tt_h > 0) {

        tt_h -= 1;
        tt_m = (parseInt(et[1]) + 60) - parseInt(st[1]);

    } else if (parseInt(et[1]) < parseInt(st[1]) && tt_h == 0) {

        $('#startTime').val('');
        $('#endTime').val('');

        $('#ErrorModal .modal-body').empty();
        $('#ErrorModal .modal-body').append('El campo "Start Time" no puede ser mayor al campo "EndTime"');
        $('#ErrorModal').modal('show');

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
        url: '/Catalogos/getDataElement',
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
        },
        error: function(Message) {
            showError(Message);
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

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "/Catalogos/storeCatalogos",
        data: data,
        error: function(Message) {
            showError(Message);
        }
    }).done(function(respuesta) {
        $('#successModal').modal('show');
        $('#element_type').val('');
        $('#nombre_elemento').val('');
        $('#element_parent').val('');
    });
});

$('#jrq-bussn').change(function() {

    var Element = "jrq-area-line";
    getDataSelcts(Element, $('#jrq-bussn').val());

    $("#jrq-proceso").empty();
    $("#jrq-proceso").append("<option value=''>Seleccionar Elemento</option>");

    $("#jrq-equipmnet-system").empty();
    $("#jrq-equipmnet-system").append("<option value=''>Seleccionar Elemento</option>");
});

$('#jrq-area-line').change(function() {

    var Element = "jrq-proceso";
    getDataSelcts(Element, $('#jrq-area-line').val());

    $("#jrq-equipmnet-system").empty();
    $("#jrq-equipmnet-system").append("<option value=''>Seleccionar Elemento</option>");
});

$('#jrq-proceso').change(function() {

    var Element = "jrq-equipmnet-system";
    getDataSelcts(Element, $('#jrq-proceso').val());
});

function getDataSelcts(element, select) {


    var data = [element, select];

    var data = {
        data: data,
        _token: $('meta[name="csrf-token"]').attr('content')
    }

    $.ajax({
        type: 'POST',
        url: '/TroubleShooting/getDataSelects',
        data: data,
        success: function(data) {

            data = JSON.parse(data);

            $("#" + element).empty();
            $("#" + element).append("<option value=''>Seleccionar Elemento</option>");

            $.each(data, function(index, value) {

                $("#" + element).append("<option value='" + value.ctg_id + "'>" + value.ctg_name + "</option>");
            });
        },
        error: function(Message) {
            showError(Message);
        }
    });
}

/**
 * Funcion solo numeros inputs time
 */

$('#ResponseTime').on('keypress', function(event) {

    return onlyNumberKey(event);
});

$('#TiempoDiagnos').on('keypress', function(event) {

    return onlyNumberKey(event);
});

function onlyNumberKey(evt) {

    // Only ASCII character in that range allowed
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode

    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;

    return true;
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

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "/TroubleShooting/storeIncidencias",
        data: data,
        error: function(Message) {
            showError(Message);
        }
    }).done(function(respuesta) {
        $('#successModal').modal('show');
        $("#incidencias")[0].reset();
    });
});

/*
    Funcion para eliminar las cookies de el registro de inicio de sesion
*/
$('#logoutBtn').click(function() {

    logoutFunction();
});

function logoutFunction() {

    var data = {
        _token: $('meta[name="csrf-token"]').attr('content')
    }

    $.ajax({
        type: 'POST',
        url: '/logout',
        data: data,
        success: function(data) {

            location.href = "/";
        },
        error: function(Message) {
            showError(Message);
        }
    });
}

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

/* Seccion Editar usuarios */

$('.table.table-bordered.usuarios tbody tr td #editUser').each(function() {

    $(this).click(function() {

        $('#userId').val($(this).parents('tr').children(0)[0].innerText);
        $('#nombreEdit').val($(this).parents('tr').children(0)[1].innerText);
        $('#emailEdit').val($(this).parents('tr').children(0)[2].innerText);
        $('#adminUserEdit').val($(this).parents('tr').children(0)[3].innerText);

        $('#ModificarUsuariosModal').modal('show');
    })
});

$('.table.table-bordered.usuarios tbody tr td #deleteUser').each(function() {

    $(this).click(function() {

        $('#userId').val($(this).parents('tr').children(0)[0].innerText);
        $('#deleteUserModal').modal('show');
    })
});

$('#updateInfoUser').click(function() {

    var data = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        data: {
            idUser: $('#userId').val(),
            nombreUser: $('#nombreEdit').val(),
            // emailUser: $('#emailEdit').val(),
            adminUser: $('#adminUserEdit').val(),
            newPassword: $('#newPassword').val()
        }
    };

    $.ajax({
        type: 'POST',
        url: '/usuarios/updateInfo',
        data: data,
        success: function(response) {

            if (response)
                logoutFunction();

            else
                location.reload();
        },
        error: function(Message) {
            showError(Message);
        }
    });
});

$('#deleteDataUser').click(function() {

    var data = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        data: {
            idUser: $('#userId').val(),
        }
    };

    $.ajax({
        type: 'POST',
        url: '/usuarios/deleteUser',
        data: data,
        success: function() {
            location.reload();
        },
        error: function(Message) {
            showError(Message);
        }
    });
});

/* Validaciones eliminar catalogo */

$('.table.table-bordered.catalogos tbody tr td #deleteCatalog').each(function() {

    $(this).click(function() {

        $('#catalogId').val($(this).parents('tr').children(0)[0].innerText);
        $('#deleteCatalogModal').modal('show');
    })
});

$('#delteDataCatalogo').click(function() {

    var data = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        data: {
            idUser: $('#catalogId').val(),
        }
    };

    $.ajax({
        type: 'POST',
        url: '/Catalogos/eliminar',
        data: data,
        success: function() {
            location.reload();
        },
        error: function(Message) {
            showError(Message);
        }
    });
});

/**
 * Caracteres restantes en Problem Description y Comentarios
 */

$totCaractersArea = 1000;

$('#ProblemDescription').on('keyup', function() {

    console.log($(this));
    console.log($(this).val().length);

    let totRest = $totCaractersArea - $(this).val().length;

    $('#lessProblem').text(totRest);

    if (totRest > 749)
        $('#lessProblem').css("color", "#08c708");

    else if (totRest < 750 && totRest > 249)
        $('#lessProblem').css("color", "#e8a805");

    else
        $('#lessProblem').css("color", "red ");
});

$('#Comments').on('keyup', function() {

    let totRest = $totCaractersArea - $(this).val().length;

    $('#lessComment').text(totRest);

    if (totRest > 749)
        $('#lessComment').css("color", "#08c708");

    else if (totRest < 750 && totRest > 249)
        $('#lessComment').css("color", "#e8a805");

    else
        $('#lessComment').css("color", "red ");
});