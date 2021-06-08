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
                    <table class="table table-bordered usuarios" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Admin User</th>
                                <th>Registrado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($users AS $user)

                                <tr>
                                    <td>{{$user['id']}}</td>
                                    <td>{{$user['name']}}</td>
                                    <td>{{$user['email']}}</td>
                                    <td value="{{$user['admin_user']}}">{{$user['admin_user_text']}}</td>
                                    <td>{{$user['created_at']}}</td>
                                    <td style="text-align: center;">
                                    <button id="editUser" class="btn btn-success"><i class="fas fa-fw far fa-edit"></i></button>
                                    <button id="deleteUser" class="btn btn-danger"><i class="fas fa-fw far fa-trash"></i></button>
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

        $('a[href *= "/Usuarios/consultar"]').addClass('active');
        var parent = $('a[href *= "/Usuarios/consultar"]').parents('div .collapse').addClass('show');

    </script>

@endsection
