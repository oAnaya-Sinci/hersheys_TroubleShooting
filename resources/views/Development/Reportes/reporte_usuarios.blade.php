@if(!$adminUser)

    <script type="text/javascript"> window.location.href = "{{ config('app.url', '') }}" </script>

@endif

@extends('mainStructure.mainStructure')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">

        <div class="col-lg-9" style="max-width: 78% !important;">

            <!-- Default Card Example -->
            <div class="card mb-4">
                <div class="card-header">
                    Reportes
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div id="showReporteGrafico"></div>
                        </div>
                    </div>

                    <!-- <h5>Data Reported</h5> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableReport" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <th>Id</th>
                                        <th>BU</th>
                                        <th>Area / Line</th>
                                        <th>Proceso</th>
                                        <th>Equipment / System</th>
                                        <th>SubSystem</th>
                                        <th>Tipo Controlador</th>
                                        <th>Componet</th>
                                        <th>Control Panel</th>
                                        <th>Issue Type</th>
                                        <th>Priority</th>
                                        <th>Action Require</th>
                                        <th>Report By</th>
                                        <th>Reporting Date</th>
                                        <th>Closing Date</th>
                                        <th>Shift</th>
                                        <th>Response Time</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Total Time</th>
                                        <th>Detractores</th>
                                        <th>Respaldo</th>
                                        <th>Refaccion</th>
                                        <th>Tiempo Diagnosticar</th>
                                        <th>Estatus</th>
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

        <div class="col-lg-3" style="max-width: 22% !important;">

            <!-- Default Card Example -->
            <div class="card mb-4">
                <div class="card-header">
                    Controles
                </div>
                <div class="card-body">

                        <!-- <div class="form-group">
                            <label>Tipo Grafica</label>
                            <select id="typeChart" name="typeChart" class="form-control bc-choco">
                                <option value='combo'>Grafica Combinada</option>
                                <option value='line'>Grafica de linea</option>
                                <option value='pie'>Grafica de pastel</option>
                            </select>
                        </div> -->

                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="text" id="fechaInicio" class="form-control bc-choco datetimepickerChart slctReporte" />
                        </div>

                        <div class="form-group">
                            <label>Fecha 2</label>
                            <input type="text" id="fechaFin" class="form-control bc-choco datetimepickerChart slctReporte" />
                        </div>

                        <div class="form-group">
                            <label>Promediar por...</label>
                            <select id="TipoPromedio" name="TipoPromedio" class="form-control bc-choco slctReporte">
                                <option value='TR'>Tiempo de Respuesta</option>
                                <option value='TD'>Tiempo en Diagnosticar</option>
                                <option value='TT'>Tiempo Total</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Filtar Por...</label>
                            <select id="TipoFiltro" name="TipoFiltro" class="form-control bc-choco slctReporte">
                                <!-- <option value=''>Seleccionar Elemento</option> -->
                                @foreach($filtrarPor AS $fp)

                                    <option value="{{ $fp['jrq_id'] }}"> {{ $fp['jrq_nombre'] }}</option>

                                @endforeach
                            </select>
                        </div>

                        <div class="showReport">
                            <button id="showReportButton_Users" class="btn btn-primary"> Mostrar <i class="fas fa-chart-line" aria-hidden="true"> </i></button>
                            <button id="downloadExcel_Users" class="btn btn-secondary">CSV <i class="fas fa-cloud-download-alt" aria-hidden="true"> </i></button>
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
    <link href="{{ config('app.url', '') }}/css/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

@endsection

@section('jsScripts')

    <!-- Page level custom scripts -->
    <script src="{{ config('app.url', '') }}/js/charts/echart.js"></script>
    <script src="{{ config('app.url', '') }}/js/charts/mainChart.js"></script>

    <script>

        $('a[href *= "/Reporte/reporte_usuarios"]').addClass('active');
        var parent = $('a[href *= "/Reporte/reporte_usuarios"]').parents('div .collapse').addClass('show');

    </script>

@endsection
