@extends('mainStructure.mainStructure')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">

        <div class="col-lg-9">

            <!-- Default Card Example -->
            <div class="card mb-4">
                <div class="card-header">
                    Reportes
                </div>
                <div class="card-body">

                    <div id="showReporteGrafico"></div>

                    <!-- <h5>Data Reported</h5> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered incidencias" id="dataTableReport" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>BU</th>
                                            <th>Area</th>
                                            <th>Line</th>
                                            <th>Equipment</th>
                                            <th>System</th>
                                            <th>Componet</th>
                                            <th>Control Panel</th>
                                            <th>Problem Description</th>
                                            <th>Issue Type</th>
                                            <th>Priority</th>
                                            <th>Action Require</th>
                                            <th>Responsible</th>
                                            <th>Report By</th>
                                            <th>Reporting Date</th>
                                            <th>Closing Date</th>
                                            <th>Shift</th>
                                            <th>Response Time</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Total Time</th>
                                            <th>Diagrama Procedimiento Manual</th>
                                            <th>Respaldo</th>
                                            <th>Refaccion</th>
                                            <th>Tiempo Diagnosticar</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </diV>

        <div class="col-lg-3">

            <!-- Default Card Example -->
            <div class="card mb-4">
                <div class="card-header">
                    Controles
                </div>
                <div class="card-body">

                        <div class="form-group">
                            <label>Tipo Grafica</label>
                            <select id="typeChart" name="typeChart" class="form-control bc-choco">
                                <option value='combo'>Grafica Combinada</option>
                                <option value='line'>Grafica de linea</option>
                                <option value='pie'>Grafica de pastel</option>
                                <!-- <option value='pie2'>Grafica de pastel 2</option>
                                <option value='pie3'>Grafica de pastel 3</option> -->
                                <!-- <option value="line2">Grafica de linea 2</option> -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="text" id="fechaInicio" class="form-control bc-choco datetimepickerChart slctReporte" />
                        </div>

                        <div class="form-group">
                            <label>Fecha 2</label>
                            <input type="text" id="fechaFin" class="form-control bc-choco datetimepickerChart slctReporte" />
                        </div>

                        <div class="form-group">
                            <label>BU - Business Unit</label>
                            <select id="jrq-bussn" name="jrq-bussn" class="form-control bc-choco slctReporte">
                                <option value=''>Seleccionar Elemento</option>
                                @foreach($BU AS $b)

                                    <option value="{{ $b['ctg_id'] }}"> {{ $b['ctg_name'] }} </option>

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Area</label>
                            <select id="jrq-area" name="jrq-area" class="form-control bc-choco slctReporte">
                                <option value=''>Seleccionar Elemento</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Line</label>
                            <select id="jrq-line" name="jrq-line" class="form-control bc-choco slctReporte">
                                <option value=''>Seleccionar Elemento</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Equipment</label>
                            <select id="jrq-equipmnet" name="jrq-equipment" class="form-control bc-choco slctReporte">
                                <option value=''>Seleccionar Elemento</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>System</label>
                            <select id="jrq-system" name="jrq-system" class="form-control bc-choco slctReporte">
                                <option value=''>Seleccionar Elemento</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Componet</label>
                            <select id="jrq-component" name="jrq-component" class="form-control bc-choco slctReporte">
                                <option value=''>Seleccionar Elemento</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Control Panel</label>
                            <select id="jrq-ctrlPanl" name="jrq-ctrlPanl" class="form-control bc-choco slctReporte">
                                <option value=''>Seleccionar Elemento</option>
                            </select>
                        </div>

                        <div class="showReport">
                            <button id="showReportButton" class="btn btn-primary">Mostrar Reporte</button>
                        </div>
                </div>
            </div>

        </div>

    </div>

</div>
<!-- /.container-fluid -->

@endsection

@section('cssLinks')

    <!-- Custom styles for this page -->
    <link href="{{ config('app.url', '') }}/resources/css/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

@endsection

@section('jsScripts')

    <!-- Page level plugins -->
    <script src="{{ config('app.url', '') }}/resources/js/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ config('app.url', '') }}/resources/js/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ config('app.url', '') }}/resources/js/demo/datatables-demo.js"></script>
    <script src="{{ config('app.url', '') }}/resources/js/charts/echart.js"></script>
    <script src="{{ config('app.url', '') }}/resources/js/charts/mainChart.js"></script>

    <script>

        $('a[href *= "/Reporte/reporte_general"]').addClass('active');
        var parent = $('a[href *= "/Reporte/reporte_general"]').parents('div .collapse').addClass('show');

    </script>

@endsection
