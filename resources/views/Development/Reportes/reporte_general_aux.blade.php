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
                                <table class="table table-bordered incidencias" id="dataTable" width="100%" cellspacing="0">
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
                                            <!-- <th>Report By</th> -->
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
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($Incidencias AS $Inci)

                                            <tr>
                                                <td>{{$Inci['icd_BU']}}</td>
                                                <td>{{$Inci['icd_Area']}}</td>
                                                <td>{{$Inci['icd_Line']}}</td>
                                                <td>{{$Inci['icd_Equipment']}}</td>
                                                <td>{{$Inci['icd_System']}}</td>
                                                <td>{{$Inci['icd_Component']}}</td>
                                                <td>{{$Inci['icd_ControlPanel']}}</td>
                                                <td>{{$Inci['icd_ProblemDescription']}}</td>
                                                <td>{{$Inci['icd_IssueType']}}</td>
                                                <td>{{$Inci['icd_Priority']}}</td>
                                                <td>{{$Inci['icd_ActionRequired']}}</td>
                                                <td>{{$Inci['icd_Responsible']}}</td>
                                                <td>{{$Inci['icd_ReportingDate']}}</td>
                                                <td>{{$Inci['icd_ClosingDate']}}</td>
                                                <td>{{$Inci['icd_Shift']}}</td>
                                                <td>{{$Inci['icd_ResponseTime']}}</td>
                                                <td>{{$Inci['icd_StartTime']}}</td>
                                                <td>{{$Inci['icd_EndTime']}}</td>
                                                <td>{{$Inci['icd_TotalTime']}}</td>
                                                <td>{{$Inci['icd_DiagramaProcManual']}}</td>
                                                <td>{{$Inci['icd_Respaldo']}}</td>
                                                <td>{{$Inci['icd_Refaccion']}}</td>
                                                <td>{{$Inci['icd_Comments']}}</td>
                                                <!-- <td></td> -->
                                            </tr>

                                        @endforeach
                                        <!-- <tr>
                                                    <td>York</td>
                                                    <td>Mogul</td>
                                                    <td>10</td>
                                                    <td>Mogul</td>
                                                    <td>Stacker</td>
                                                    <td>Sensor</td>
                                                    <td>CP-60-001</td>
                                                    <td>No detecta sensor de palet</td>
                                                    <td>Electrico</td>
                                                    <td></td>
                                                    <td>Cambio</td> -->
                                                    <!-- <td></td> -->
                                                    <!-- <td>Juan Perez</td>
                                                    <td>10/02/2021</td>
                                                    <td>10/02/2021</td>
                                                    <td>1</td>
                                                    <td>10</td>
                                                    <td>10:00:00</td>
                                                    <td>10:45:00</td>
                                                    <td>0:45:00</td>
                                                    <td>1</td>
                                                    <td>1</td>
                                                    <td>0</td>
                                                    <td>Se realiza cambio</td>
                                                </tr>

                                                <tr>
                                                    <td>York</td>
                                                    <td>Mogul</td>
                                                    <td>10</td>
                                                    <td>Mogul</td>
                                                    <td>Stacker</td>
                                                    <td>Sensor</td>
                                                    <td>CP-60-001</td>
                                                    <td>No detecta sensor de palet</td>
                                                    <td>Electrico</td> -->
                                                    <!-- <td></td> -->
                                                    <!-- <td>Cambio</td>
                                                    <td></td>
                                                    <td>Juan Perez</td>
                                                    <td>10/02/2021</td>
                                                    <td>10/02/2021</td>
                                                    <td>1</td>
                                                    <td>10</td>
                                                    <td>10:00:00</td>
                                                    <td>10:45:00</td>
                                                    <td>0:45:00</td>
                                                    <td>1</td>
                                                    <td>1</td>
                                                    <td>0</td>
                                                    <td>Se realiza cambio</td>
                                                </tr>

                                                <tr>
                                                    <td>York</td>
                                                    <td>Mogul</td>
                                                    <td>10</td>
                                                    <td>Mogul</td>
                                                    <td>Stacker</td>
                                                    <td>Sensor</td>
                                                    <td>CP-60-001</td>
                                                    <td>No detecta sensor de palet</td>
                                                    <td>Electrico</td> -->
                                                    <!-- <td></td> -->
                                                    <!-- <td>Cambio</td>
                                                    <td></td>
                                                    <td>Juan Perez</td>
                                                    <td>10/02/2021</td>
                                                    <td>10/02/2021</td>
                                                    <td>1</td>
                                                    <td>10</td>
                                                    <td>10:00:00</td>
                                                    <td>10:45:00</td>
                                                    <td>0:45:00</td>
                                                    <td>1</td>
                                                    <td>1</td>
                                                    <td>0</td>
                                                    <td>Se realiza cambio</td>
                                                </tr>

                                                <tr>
                                                    <td>York</td>
                                                    <td>Mogul</td>
                                                    <td>10</td>
                                                    <td>Mogul</td>
                                                    <td>Stacker</td>
                                                    <td>Sensor</td>
                                                    <td>CP-60-001</td>
                                                    <td>No detecta sensor de palet</td>
                                                    <td>Electrico</td> -->
                                                    <!-- <td></td> -->
                                                    <!-- <td>Cambio</td>
                                                    <td></td>
                                                    <td>Juan Perez</td>
                                                    <td>10/02/2021</td>
                                                    <td>10/02/2021</td>
                                                    <td>1</td>
                                                    <td>10</td>
                                                    <td>10:00:00</td>
                                                    <td>10:45:00</td>
                                                    <td>0:45:00</td>
                                                    <td>1</td>
                                                    <td>1</td>
                                                    <td>0</td>
                                                    <td>Se realiza cambio</td>
                                                </tr> -->
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
                                <option value='line'>Grafica de linea</option>
                                <option value='pie'>Grafica de pastel</option>
                                <option value='pie2'>Grafica de pastel 2</option>
                                <option value='pie3'>Grafica de pastel 3</option>
                                <option value='combo'>Grafica Combinada</option>
                                <!-- <option value="line2">Grafica de linea 2</option> -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="text" id="fecha" class="form-control bc-choco datetimepickerChart" />
                        </div>

                        <div class="form-group">
                            <label>BU - Business Unit</label>
                            <select id="jrq-bussn" name="jrq-bussn" class="form-control bc-choco">
                                <option value=''>Seleccionar Elemento</option>
                                @foreach($BU AS $Val)
                                    <option value="{{$Val['ctg_name']}}">{{$Val['ctg_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Area</label>
                            <select id="jrq-area" name="jrq-area" class="form-control bc-choco">
                                <option value=''>Seleccionar Elemento</option>
                                @foreach($Areas AS $Val)
                                    <option value="{{$Val['ctg_name']}}">{{$Val['ctg_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Line</label>
                            <select id="jrq-line" name="jrq-line" class="form-control bc-choco">
                                <option value=''>Seleccionar Elemento</option>
                                @foreach($Line AS $Val)
                                    <option value="{{$Val['ctg_name']}}">{{$Val['ctg_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Equipment</label>
                            <select id="jrq-equipmnet" name="jrq-equipment" class="form-control bc-choco">
                                <option value=''>Seleccionar Elemento</option>
                                @foreach($Equipt AS $Val)
                                    <option value="{{$Val['ctg_name']}}">{{$Val['ctg_name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>System</label>
                            <select id="jrq-system" name="jrq-system" class="form-control bc-choco">
                                <option value=''>Seleccionar Elemento</option>
                                @foreach($System AS $Val)
                                    <option value="{{$Val['ctg_name']}}">{{$Val['ctg_name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Componet</label>
                            <select id="jrq-component" name="jrq-component" class="form-control bc-choco">
                                <option value=''>Seleccionar Elemento</option>
                                @foreach($Component AS $Val)
                                    <option value="{{$Val['ctg_name']}}">{{$Val['ctg_name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Control Panel</label>
                            <select id="jrq-ctrlPanl" name="jrq-ctrlPanl" class="form-control bc-choco">
                                <option value=''>Seleccionar Elemento</option>
                                @foreach($CtrlPanel AS $Val)
                                    <option value="{{$Val['ctg_name']}}">{{$Val['ctg_name']}}</option>
                                @endforeach
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

        $('a[href *= "/Reporte/reporte_fallas"]').addClass('active');
        var parent = $('a[href *= "/Reporte/reporte_fallas"]').parents('div .collapse').addClass('show');

    </script>

@endsection
