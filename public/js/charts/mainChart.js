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

                tbody += '<tr> <td>' + value['id'] + '</td>';
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

function exportData(tableID, filename = 'excel_data') {
    /* Get the HTML data using Element by Id */
    var table = document.getElementById(tableID);

    /* Declaring array variable */
    var rows = [];

    //iterate through rows of table
    for (var i = 0, row; row = table.rows[i]; i++) {
        //rows would be accessed using the "row" variable assigned in the for loop
        //Get each cell value/column from the row
        column1 = row.cells[0].innerText;
        column2 = row.cells[1].innerText;
        column3 = row.cells[2].innerText;
        column4 = row.cells[3].innerText;
        column5 = row.cells[4].innerText;
        column6 = row.cells[5].innerText;
        column7 = row.cells[6].innerText;
        column8 = row.cells[7].innerText;
        column9 = row.cells[8].innerText;
        column10 = row.cells[9].innerText;
        column11 = row.cells[10].innerText;
        column12 = row.cells[11].innerText;
        column13 = row.cells[12].innerText;
        column14 = row.cells[13].innerText;
        column15 = row.cells[14].innerText;
        column16 = row.cells[15].innerText;
        column17 = row.cells[16].innerText;
        column18 = row.cells[17].innerText;
        column19 = row.cells[18].innerText;
        column20 = row.cells[19].innerText;
        column21 = row.cells[20].innerText;
        column22 = row.cells[1].innerText;
        column23 = row.cells[22].innerText;
        column24 = row.cells[23].innerText;
        column25 = row.cells[24].innerText;
        column26 = row.cells[25].innerText;

        /* add a new records in the array */
        rows.push(
            [
                column1,
                column2,
                column3,
                column4,
                column5,
                column6,
                column7,
                column8,
                column9,
                column10,
                column11,
                column12,
                column13,
                column14,
                column15,
                column16,
                column17,
                column18,
                column19,
                column20,
                column21,
                column22,
                column23,
                column24,
                column25,
                column26
            ]
        );

    }
    csvContent = "charset=utf-8;data:text/csv;";
    /* add the column delimiter as comma(,) and each row splitted by new line character (\n) */
    rows.forEach(function(rowArray) {
        row = rowArray.join(",");
        csvContent += row + "\r\n";
    });

    /* create a hidden <a> DOM node and set its download attribute */
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", filename + ".csv");
    document.body.appendChild(link);
    /* download the data file named "Stock_Price_Report.csv" */
    link.click();
}

$('#downloadExcel').click(function() {

    let date = new Date();
    let today = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();

    // exportTableToExcel('dataTableReport', 'dac_troubleshooting_' + today);
    exportData('dataTableReport', 'dac_troubleshooting_' + today);

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