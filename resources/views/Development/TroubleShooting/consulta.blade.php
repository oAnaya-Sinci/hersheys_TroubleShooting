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
                                <th>Componet</th>
                                <th>Control Panel</th>
                                <!-- <th>Problem Description</th> -->
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
                                <th>Problem Description</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($Incidencias AS $Inci)

                                <tr>
                                    <td>{{$Inci['id']}}</td>
                                    <td>{{$Inci['BU']}}</td>
                                    <td>{{$Inci['area_linea']}}</td>
                                    <td>{{$Inci['proceso']}}</td>
                                    <td>{{$Inci['equip_system']}}</td>
                                    <td>{{$Inci['SubSistema']}}</td>
                                    <td>{{$Inci['component']}}</td>
                                    <td>{{$Inci['Control_Panel']}}</td>
                                    <!-- <td>{{$Inci['icd_ProblemDescription']}}</td> -->
                                    <td>{{$Inci['issue_type']}}</td>
                                    <td>{{$Inci['Prioridad']}}</td>
                                    <td>{{$Inci['action_required']}}</td>
                                    <td>{{$Inci['Responsable']}}</td>
                                    <td>{{$Inci['Reportado_Por']}}</td>
                                    <td>{{$Inci['Fecha_Reporte']}}</td>
                                    <td>{{$Inci['Fecha_Cierre']}}</td>
                                    <td>{{$Inci['Turno']}}</td>
                                    <td>{{$Inci['Tiempo_Respuesta']}}</td>
                                    <td>{{$Inci['Hora_Inicio']}}</td>
                                    <td>{{$Inci['Hora_Termino']}}</td>
                                    <td>{{$Inci['Tiempo_Total']}}</td>
                                    <td>{{$Inci['Diagrama_procedimiento_manual']}}</td>
                                    <td>{{$Inci['Respaldo']}}</td>
                                    <td>{{$Inci['Refaccion']}}</td>
                                    <td>{{$Inci['Tiempo_Diagnosticar']}}</td>
                                    <!-- <td>{{$Inci['icd_Comments']}}</td> -->
                                    <td style="text-align: center;">
                                        <button id="showComment" class="btn btn-info btn-sm"><i class="fas fa-external-link-alt" aria-hidden="true"></i></button>
                                    </td>
                                    <td style="text-align: center;">
                                        <button id="showProblemDescription" class="btn btn-info btn-sm"><i class="fas fa-external-link-alt" aria-hidden="true"></i></button>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
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
