jQuery(document).ready(function($) {

    if (window.jQuery().datetimepicker) {
        $('.datetimepickerChart').datetimepicker({
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
    }

    $('#fechaInicio').data("DateTimePicker").date(new Date());
    $('#fechaFin').data("DateTimePicker").date(new Date());
});

var myChart = null;

function showGraph() {

    if (myChart != null && myChart != "" && myChart != undefined)
        myChart.dispose();

    // based on prepared DOM, initialize echarts instance
    myChart = echarts.init(document.getElementById('showReporteGrafico'));

    var typeChar = $('#typeChart').val();

    var option = getTypeChart(typeChar);

    // use configuration item and data specified to show chart
    myChart.setOption(option);
}

$('#typeChart').change(function() {
    getDataIncidencias();
});

$('#showReportButton').click(function() {

    getDataIncidencias();
    get_dataTable();

    $('#downloadExcel').prop("disabled", false);
});

let dataReport;

function getDataIncidencias() {

    var dataSlcts = [];
    var val;

    $('.slctReporte').each(function() {

        val = $(this).val();

        if (val != '')
            dataSlcts.push({ val });
    });

    var data = {
        data: dataSlcts,
        _token: $('meta[name="csrf-token"]').attr('content')
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '../Reporte/getDataReport',
        data: data,
        success: function(data) {

            dataReport = data;
            showGraph();
        },
        error: function(Message) {
            showError(Message)
        }
    });
}

function get_dataTable() {

    var dataSlcts = [];
    var val;

    $('.slctReporte').each(function() {

        val = $(this).val();

        if (val != '')
            dataSlcts.push({ val });
    });

    var data = {
        data: dataSlcts,
        _token: $('meta[name="csrf-token"]').attr('content')
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '../Reporte/getDataTable',
        data: data,
        success: function(data) {

            var tbody = '';

            $.each(data, function(index, value) {

                tbody += '<tr>'
                    // tbody += '<td>' + value['id'] + '</td>';
                tbody += '<td>' + value['bssnu'] + '</td>';
                tbody += '<td>' + value['area_linea'] + '</td>';
                tbody += '<td>' + value['proceso'] + '</td>';
                tbody += '<td>' + value['equipment_system'] + '</td>';
                tbody += '<td>' + value['icd_Subsystem'] + '</td>';
                tbody += '<td>' + value['component'] + '</td>';
                tbody += '<td>' + value['icd_ControlPanel'] + '</td>';
                tbody += '<td>' + value['icd_ProblemDescription'] + '</td>';
                tbody += '<td>' + value['issue'] + '</td>';
                tbody += '<td>' + value['icd_Priority'] + '</td>';
                tbody += '<td>' + value['action_r'] + '</td>';
                tbody += '<td>' + value['icd_Responsible'] + '</td>';
                tbody += '<td>' + value['icd_reportedBy'] + '</td>';
                tbody += '<td>' + value['icd_ReportingDate'] + '</td>';
                tbody += '<td>' + value['icd_ClosingDate'] + '</td>';
                tbody += '<td>' + value['icd_Shift'] + '</td>';
                tbody += '<td>' + value['icd_ResponseTime'] + '</td>';
                tbody += '<td>' + value['icd_StartTime'] + '</td>';
                tbody += '<td>' + value['icd_EndTime'] + '</td>';
                tbody += '<td>' + value['icd_TotalTime'] + '</td>';
                tbody += '<td>' + value['icd_DiagramaProcManual'] + '</td>';
                tbody += '<td>' + value['icd_Respaldo'] + '</td>';
                tbody += '<td>' + value['icd_Refaccion'] + '</td>';
                tbody += '<td>' + value['icd_tiempoDiagnosticar'] + '</td>';
                tbody += '<td>' + value['icd_Comments'] + '</td>';
                tbody += '</tr>';
            });

            $('#dataTableReport.incidencias tbody').html(tbody);
        },
        error: function(Message) {
            showError(Message)
        }
    });
}

function getTypeChart(type) {

    let dataToShow = dataReport;
    var option = null;

    switch (type) {

        case 'pie':

            var seriesArr = [];

            var x = 0;
            $.each(dataToShow, function(index, value) {

                var totElement = 0;

                if (x > 0) {

                    var nameEle = value[0];
                    value.shift()

                    $.each(value, function(ind, val) {

                        totElement += val;
                    });

                    seriesArr.push({
                        value: totElement,
                        name: nameEle
                    });
                }

                x++
            });

            option = {
                title: {
                    text: 'Reporte de Fallos',
                    // subtext: 'Pie Chart',
                    left: 'center'
                },
                tooltip: {
                    trigger: 'item'
                },
                toolbox: {
                    feature: {
                        saveAsImage: {}
                    }
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                },
                series: [{
                    name: 'Hershey',
                    type: 'pie',
                    radius: '50%',
                    data: seriesArr,
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }]
            };
            break;

        case 'line':

            var seriesArr = [];
            labelIncidencia = [];

            var legendArr = dataToShow[0];
            legendArr.shift();

            var x = 0;
            $.each(dataToShow, function(index, value) {

                if (x > 0) {

                    var nameEle = value[0];
                    labelIncidencia.push(nameEle);
                    value.shift()

                    seriesArr.push({
                        name: nameEle,
                        type: 'line',
                        data: value
                    });
                }

                x++
            });
            console.log(labelIncidencia);
            option = {
                title: {
                    text: 'Reporte de Fallos'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: labelIncidencia
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: false
                },
                toolbox: {
                    feature: {
                        saveAsImage: {}
                    }
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: true,
                    data: legendArr
                },
                yAxis: {
                    type: 'value'
                },
                series: seriesArr
            };

            break;

        case 'combo':

            var seriesArr = [];

            var x = 0;
            $.each(dataToShow, function() {

                if (x > 0)
                    seriesArr.push({ type: 'line', smooth: true, seriesLayoutBy: 'row', emphasis: { focus: 'series' } });

                x++;
            });

            seriesArr.push({
                type: 'pie',
                id: 'pie',
                radius: '30%',
                center: ['50%', '25%'],
                emphasis: { focus: 'data' },
                label: {
                    formatter: '{b}: {@' + dataToShow[0][1] + '} ({d}%)'
                },
                encode: {
                    itemName: dataToShow[0][0],
                    value: dataToShow[0][1],
                    tooltip: dataToShow[0][1]
                }
            });

            option = {
                legend: {},
                tooltip: {
                    trigger: 'axis',
                    showContent: false
                },
                dataset: {
                    source: dataToShow
                },
                toolbox: {
                    feature: {
                        saveAsImage: {}
                    }
                },
                xAxis: { type: 'category' },
                yAxis: { gridIndex: 0 },
                grid: { top: '55%' },
                series: seriesArr
            };

            myChart.on('updateAxisPointer', function(event) {
                var xAxisInfo = event.axesInfo[0];
                if (xAxisInfo) {
                    var dimension = xAxisInfo.value + 1;
                    myChart.setOption({
                        series: {
                            id: 'pie',
                            label: {
                                formatter: '{b}: {@[' + dimension + ']} ({d}%)'
                            },
                            encode: {
                                value: dimension,
                                tooltip: dimension
                            }
                        }
                    });
                }
            });

            break;
    }

    return option;
}

/**
 *
 */

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], { type: "text/csv" });

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}

function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [],
            cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText);

        csv.push(row.join(","));
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}

$('#downloadExcel').click(function() {

    let date = new Date();
    let today = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();

    // exportTableToExcel('dataTableReport', 'dac_troubleshooting_' + today);
    // exportData('dataTableReport', 'dac_troubleshooting_' + today);
    exportTableToCSV('dac_troubleshooting_' + today);

    $('#downloadExcel').prop("disabled", true);
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