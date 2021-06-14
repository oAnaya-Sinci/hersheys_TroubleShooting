@if(!$adminUser)

    <script type="text/javascript"> window.location.href = "{{ config('app.url', '') }}" </script>

@endif

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
                    <table class="table table-bordered catalogos" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Elemento</th>
                                <th>Nombre</th>
                                <th>Abuelo / Padre</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($Elementos AS $Ele)

                            <tr>
                                <td>{{$Ele['cata_id']}}</td>
                                <td>{{$Ele['tipo']}}</td>
                                <td>{{$Ele['nombre']}}</td>
                                <td>{{$Ele['padre']}}</td>
                                <td style="text-align: center;"><button id="deleteCatalog" class="btn btn-danger"><i class="fas fa-fw far fa-trash"></i></button></td>
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

        $('a[href *= "/Catalogos/consultas"]').addClass('active');
        var parent = $('a[href *= "/Catalogos/consultas"]').parents('div .collapse').addClass('show');

    </script>

@endsection
