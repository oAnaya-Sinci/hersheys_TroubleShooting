let dataTableIncidencias;

jQuery(document).ready(function($) {

    iniciateRowsCommentsProblems();

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

    $('#dataTable.nonIncidencias').DataTable({ searching: true, pageLength: 25 });

    var data = {
        _token: $('meta[name="csrf-token"]').attr('content')
    }

    dataTableIncidencias = $('#dataTable.incidencias').DataTable({
        searching: true,
        pageLength: 25,
        dom: "Bfrtip",
        ajax: {
            url: "/TroubleShooting/getIncidenciasData",
            type: 'POST',
            data: data,
            "dataSrc": ""
        },
        columns: [
            { data: "id" },
            { data: "BU" },
            { data: "area_linea" },
            { data: "proceso" },
            { data: "equip_system" },
            { data: "SubSistema" },
            { data: "TipoCtrl" },
            { data: "component" },
            { data: "Control_Panel" },
            { data: "issue_type" },
            { data: "Prioridad" },
            { data: "action_required" },
            { data: "Reportado_Por" },
            { data: "Fecha_Reporte" },
            { data: "Fecha_Cierre" },
            { data: "Turno" },
            { data: "Tiempo_Respuesta" },
            { data: "Hora_Inicio" },
            { data: "Hora_Termino" },
            { data: "Tiempo_Total" },
            { data: "Diagrama_procedimiento_manual" },
            { data: "Respaldo" },
            { data: "Refaccion" },
            { data: "Tiempo_Diagnosticar" },
            { data: "Estatus" },
            {
                data: "",
                render: function(row) {
                    return '<button id="showComment" class="btn btn-info btn-sm"><i class="fas fa-external-link-alt" aria-hidden="true"></i></button>'
                }
            },
            {
                data: "",
                render: function(row) {
                    return '<button id="showProblemDescription" class="btn btn-info btn-sm"><i class="fas fa-external-link-alt" aria-hidden="true"></i></button>'
                }
            }
        ],
        "initComplete": function() {
            iniciateRowsCommentsProblems();
        },
        "columnDefs": [
            { className: "btnCommtsProblm", "targets": [25, 26] }
        ]
    });
});

/**Reload table incidencais By date */

// dataTableIncidencias.ajax.reload();

/* End */

$('#startTime').blur(function() { calculeTotalTime(); });
$('#endTime').blur(function() { calculeTotalTime(); });
$('#ReportingDate').blur(function() { calculeTotalTime(); });
$('#ClosingDate').blur(function() { calculeTotalTime(); });
$('#totalTime').blur(function() { calculeTotalTime(); });

function calculeTotalTime() {

    var st = $('#startTime').val();
    var et = $('#endTime').val();

    $('#totalTime').attr('disabled', 'disabled');

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

        $("#elementForm")[0].reset();
        $('#successModal').modal('show');
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

    $('#totalTime').removeAttr('disabled');

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
            $('#totalTime').attr('disabled', 'disabled');
            showError(Message);
        }
    }).done(function(respuesta) {

        $('#totalTime').attr('disabled', 'disabled');
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

$totCaractersArea = 1500;

$('#ProblemDescription').on('keyup', function() {

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

/**
 * get Comments or Probelm description from database
 */

function iniciateRowsCommentsProblems() {

    $('.table.table-bordered.incidencias tbody tr td #showComment').each(function() {

        $(this).click(function() {

            let id = $(this).parents('tr').children(0)[0].innerText;
            getCommentsProblems(id, 'icd_Comments');
        })
    });

    $('.table.table-bordered.incidencias tbody tr td #showProblemDescription').each(function() {

        $(this).click(function() {

            let id = $(this).parents('tr').children(0)[0].innerText;
            getCommentsProblems(id, 'icd_ProblemDescription');
        })
    });
}


function getCommentsProblems(id, column) {

    Header = (column == 'icd_Comments' ? '<h5>Comentarios:</h5>' : '<h5>Descripcion del Problema:</h5>');

    let values = { id: id, column: column };

    var data = {
        data: values,
        _token: $('meta[name="csrf-token"]').attr('content')
    }

    $.ajax({
        type: 'POST',
        url: '/TroubleShooting/getCommentsProblems',
        data: data,
        error: function(Message) {
            showError(Message);
        }
    }).done(function(Message) {

        // Message = JSON.parse(Message);

        $('#MessageModal .modal-body').empty();

        $('#MessageModal .modal-body').append(Header);
        $('#MessageModal .modal-body').append('<hr class="sidebar-divider d-none d-md-block">');
        $('#MessageModal .modal-body').append("<p class='commentsProblems'>" + Message + "</p>");

        $('#MessageModal').modal('show');
    });
}