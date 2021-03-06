@extends('mainStructure.mainStructure')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">


<div class="row">

    <div class="col-lg-12">

        <!-- Default Card Example -->
        <div class="card mb-4">
            <div class="card-header">
                Consulta de Incidencias
            </div>
            <div class="card-body">

                <div class="col-lg-4 slctTimeData">
                    <label class="lblTimeData" for="">Mostrar</label>
                    <select class="form-control" name="timeOfData" id="timeOfData">
                        <option value="D0">Registros del Dia</option>
                        <option value="D3">Ultimos tres días</option>
                        <option value="D7">Ultima semana</option>
                        <option value="D15">Ultimas dos semanas</option>
                        <option value="M1">Ultimo mes</option>
                        <option value="M3">Ultimos tres meses</option>
                        <option value="M6">Ultimos seis meses</option>
                        <option value="Y1">Ultimo año</option>
                        <option value="Y2">Ultimos dos años</option>
                        <option value="Y3">Ultimos tres años</option>
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered incidencias" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
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
                                <th>Diagrama Procedimiento Manual</th>
                                <th>Respaldo</th>
                                <th>Refaccion</th>
                                <th>Tiempo Diagnosticar</th>
                                <th>Estatus</th>
                                <th>Comments</th>
                                <th>Problem Description</th>
                            </tr>
                        </thead>
                    </table>
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

    <!-- Page level plugins -->
    <script src="{{ config('app.url', '') }}/js/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ config('app.url', '') }}/js/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ config('app.url', '') }}/js/demo/datatables-demo.js"></script>

    <script>

        $('a[href *= "/TroubleShooting/consultas"]').addClass('active');
        var parent = $('a[href *= "/TroubleShooting/consultas"]').parents('div .collapse').addClass('show');

    </script>

@endsection
