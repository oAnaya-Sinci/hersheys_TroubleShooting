jQuery(document).ready(function($) {

    // $('#dataTableReport').DataTable({ searching: false, pageLength: 50 });

    /* var data = {
        data: [],
        _token: $('meta[name="csrf-token"]').attr('content')
    }

    reloadDataTable = $('#dataTableReport').DataTable({
        'ajax': {
            "type": "POST",
            "url": '../Reporte/getDataTable',
            "data": function(d) {
                data
            },
            "dataSrc": ""
        },
        'columns': [
            { "data": "BU" },
            { "data": "Area" },
            { "data": "Line" },
            { "data": "Equipment" },
            { "data": "System" },
            { "data": "Component" },
            { "data": "ControlPanel" },
            { "data": "ProblemDescription" },
            { "data": "IssueType" },
            { "data": "Priority" },
            { "data": "ActionRequired" },
            { "data": "Responsible" },
            { "data": "ReportedBy" },
            { "data": "ReportingDate" },
            { "data": "ClosingDate" },
            { "data": "Shift" },
            { "data": "ResponseTime" },
            { "data": "StartTime" },
            { "data": "EndTime" },
            { "data": "TotalTime" },
            { "data": "DiagramaProcManual" },
            { "data": "Respaldo" },
            { "data": "Refaccion" },
            { "data": "TiempoDiagnosticar" },
            { "data": "Comments" }
        ],
        searching: false,
        pageLength: 50
    }); */

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
        }
    })
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
        }
    }).done(function() {
        $('#dataTableReport').DataTable({ searching: false, pageLength: 50 });
    });

    /* $('#dataTable.incidencias').DataTable({
        "ajax": {
            "url": "../Reporte/getDataTable",
            "type": "POST",
            "data": data,
            "dataSrc": "my_data"
        },
        'columns': [
            { "data": "name" },
            { "data": "type" },
            { "data": "time" },
            { "data": "durat" }
        ]
    }); */
}

function getTypeChart(type) {

    let dataToShow = dataReport;
    var option = null;

    switch (type) {

        /* case 'line2':
            option = {
                xAxis: {
                    type: 'category',
                    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    data: [150, 230, 224, 218, 135, 147, 260],
                    type: 'line'
                }]
            };
            break; */

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

            /* case 'pie2':
                option = {
                    dataset: [{
                        source: [
                            ['Product', 'Sales', 'Price', 'Year'],
                            ['Electricos', 123, 32, 2011],
                            ['Control', 231, 14, 2011],
                            ['Operativos', 235, 5, 2011],
                            ['Otros Valores', 341, 25, 2011],
                            ['Electricos', 122, 29, 2011],
                            ['Control', 143, 30, 2012],
                            ['Operativos', 201, 19, 2012],
                            ['Otros Valores', 255, 7, 2012],
                            ['Electricos', 241, 27, 2012],
                            ['Control', 102, 34, 2012],
                            ['Operativos', 153, 28, 2013],
                            ['Otros Valores', 181, 21, 2013],
                            ['Electricos', 395, 4, 2013],
                            ['Control', 281, 31, 2013],
                            ['Operativos', 92, 39, 2013],
                            ['Otros Valores', 223, 29, 2014],
                            ['Electricos', 211, 17, 2014],
                            ['Control', 345, 3, 2014],
                            ['Operativos', 211, 35, 2014],
                            ['Otros Valores', 72, 24, 2014],
                        ],
                    }, {
                        transform: {
                            type: 'filter',
                            config: { dimension: 'Year', value: 2011 }
                        },
                    }, {
                        transform: {
                            type: 'filter',
                            config: { dimension: 'Year', value: 2012 }
                        }
                    }, {
                        transform: {
                            type: 'filter',
                            config: { dimension: 'Year', value: 2013 }
                        }
                    }],
                    series: [{
                        type: 'pie',
                        radius: 50,
                        center: ['50%', '25%'],
                        datasetIndex: 1
                    }, {
                        type: 'pie',
                        radius: 50,
                        center: ['50%', '50%'],
                        datasetIndex: 2
                    }, {
                        type: 'pie',
                        radius: 50,
                        center: ['50%', '75%'],
                        datasetIndex: 3
                    }],


                    // Optional. Only for responsive layout:
                    media: [{
                        query: { minAspectRatio: 1 },
                        option: {
                            series: [
                                { center: ['25%', '50%'] },
                                { center: ['50%', '50%'] },
                                { center: ['75%', '50%'] }
                            ]
                        }
                    }, {
                        option: {
                            series: [
                                { center: ['50%', '25%'] },
                                { center: ['50%', '50%'] },
                                { center: ['50%', '75%'] }
                            ]
                        }
                    }]
                };
                break;

            case 'pie3':
                var option = {
                    legend: {},
                    tooltip: {},
                    dataset: {
                        source: [
                            ['product', '2012', '2013', '2014', '2015', '2016', '2017'],
                            ['Electricas', 86.5, 92.1, 85.7, 83.1, 73.4, 55.1],
                            ['Control', 41.1, 30.4, 65.1, 53.3, 83.8, 98.7],
                            ['Operativos', 24.1, 67.2, 79.5, 86.4, 65.2, 82.5],
                            ['Otros', 55.2, 67.1, 69.2, 72.4, 53.9, 39.1]
                        ]
                    },
                    series: [{
                        type: 'pie',
                        radius: '20%',
                        center: ['25%', '30%']
                            // No encode specified, by default, it is '2012'.
                    }, {
                        type: 'pie',
                        radius: '20%',
                        center: ['75%', '30%'],
                        encode: {
                            itemName: 'product',
                            value: '2013'
                        }
                    }, {
                        type: 'pie',
                        radius: '20%',
                        center: ['25%', '75%'],
                        encode: {
                            itemName: 'product',
                            value: '2014'
                        }
                    }, {
                        type: 'pie',
                        radius: '20%',
                        center: ['75%', '75%'],
                        encode: {
                            itemName: 'product',
                            value: '2015'
                        }
                    }]
                };
                break; */

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