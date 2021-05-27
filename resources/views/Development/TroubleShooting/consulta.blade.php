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

                            @foreach($Incidencias AS $Inci)

                                <tr>
                                    <td>{{$Inci['bssnu']}}</td>
                                    <td>{{$Inci['area']}}</td>
                                    <td>{{$Inci['line']}}</td>
                                    <td>{{$Inci['equipment']}}</td>
                                    <td>{{$Inci['system']}}</td>
                                    <td>{{$Inci['component']}}</td>
                                    <td>{{$Inci['control']}}</td>
                                    <td>{{$Inci['icd_ProblemDescription']}}</td>
                                    <td>{{$Inci['issue']}}</td>
                                    <td>{{$Inci['icd_Priority']}}</td>
                                    <td>{{$Inci['action']}}</td>
                                    <td>{{$Inci['icd_Responsible']}}</td>
                                    <td>{{$Inci['icd_reportedBy']}}</td>
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
                                    <td>{{$Inci['icd_tiempoDiagnosticar']}}</td>
                                    <td>{{$Inci['icd_Comments']}}</td>
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
