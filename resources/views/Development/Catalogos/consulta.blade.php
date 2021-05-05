@extends('mainStructure.mainStructure')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

<div class="row">

    <div class="col-lg-12">

        <!-- Default Card Example -->
        <div class="card mb-4">
            <div class="card-header">
                Consulta de Catalogos
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Elemento</th>
                                <th>Nombre</th>
                                <th>padre</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($Elementos AS $Ele)

                            <tr>
                                <td>{{$Ele['id']}}</td>
                                <td>{{$Ele['jrq_nombre']}}</td>
                                <td>{{$Ele['ctg_name']}}</td>
                                <td>{{$Ele['ctg_padre']}}</td>
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
    <link href="{{ config('app.url', '') }}/resources/css/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

@endsection

@section('jsScripts')

    <!-- Page level plugins -->
    <script src="{{ config('app.url', '') }}/resources/js/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ config('app.url', '') }}/resources/js/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ config('app.url', '') }}/resources/js/demo/datatables-demo.js"></script>

    <script>

        $('a[href *= "/Catalogos/consultas"]').addClass('active');
        var parent = $('a[href *= "/Catalogos/consultas"]').parents('div .collapse').addClass('show');

    </script>

@endsection
