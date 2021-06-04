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

                tbody += '<tr> <td>' + value['icd_BU'] + '</td>';
                tbody += '<td>' + value['icd_Area'] + '</td>';
                tbody += '<td>' + value['icd_Line'] + '</td>';
                tbody += '<td>' + value['icd_Equipment'] + '</td>';
                tbody += '<td>' + value['icd_System'] + '</td>';
                tbody += '<td>' + value['icd_Component'] + '</td>';
                tbody += '<td>' + value['icd_ControlPanel'] + '</td>';
                tbody += '<td>' + value['icd_ProblemDescription'] + '</td>';
                tbody += '<td>' + value['icd_IssueType'] + '</td>';
                tbody += '<td>' + value['icd_Priority'] + '</td>';
                tbody += '<td>' + value['icd_ActionRequired'] + '</td>';
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
                tbody += '<td>' + value['icd_Comments'] + '</td> </tr>';
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
                    text: 'Reporte de fallas',
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
            var legendArr = dataToShow[0];
            legendArr.shift();

            var x = 0;
            $.each(dataToShow, function(index, value) {

                if (x > 0) {

                    var nameEle = value[0];
                    value.shift()

                    seriesArr.push({
                        name: nameEle,
                        type: 'line',
                        stack: 'Total',
                        data: value
                    });
                }

                x++
            });

            option = {
                title: {
                    text: 'Reporte de fallas'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: legendArr
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                toolbox: {
                    feature: {
                        saveAsImage: {}
                    }
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
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

function exportTableToExcel(tableID, filename = 'excel_data') {

    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    var tbody = $('#' + tableID + " tbody tr").length;

    if (tbody == 0)
        return false;

    // Specify file name
    filename = filename ? filename + '.xlsx' : 'excel_data.xlsx';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;

        //triggering the function
        downloadLink.click();
    }

    return true;
}

$('#downloadExcel').click(function() {

    let date = new Date();
    let today = date.getDate() + "-" + date.getMonth() + "-" + date.getFullYear();

    exportTableToExcel('dataTableReport', 'dac_troubleshooting_' + today);

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
