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
                Registro de Catalogos
            </div>
            <div class="card-body">

                <form id="elementForm" >

                    <div class="row">
                        <div class="col-lg-6">
                            <label class="mb-0">Elemento</label>
                            <select id="element_type" name="element_type" class="form-control bc-choco mb-1">
                                <option value="">Seleccionar Catalogo</option>
                                @foreach($Elementos AS $Ele)

                                    <option value="{{ $Ele['jrq_id'] }}"> {{ $Ele['jrq_nombre'] }} </option>

                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="mb-0">Nombre</label>
                            <input type="text" id="nombre_elemento" name="nombre_elemento" class="form-control bc-choco mb-1" placeholder="nombre elemento">
                        </div>
                    </div>
                    <div class="my-2"></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="mb-0">Elemento Padre</label>
                            <select id="element_parent" name="elemento_padre" class="form-control bc-choco mb-1">
                                <option value="">Seleccionar Elemento</option>
                            </select>
                        </div>
                    </div>
                    <div class="my-2"></div>
                    <hr class="sidebar-divider d-none d-md-block">
                    <div class="row">
                        <div class="col-lg-12" style="text-align: right;">
                            <a id="storeCatalogos" href="#" class="btn btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Guardar Elemento</span>
                            </a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>

</div>
<!-- /.container-fluid -->

@endsection

@section('jsScripts')
<script>

    $('a[href *= "/Catalogos/registros"]').addClass('active');
    var parent = $('a[href *= "/Catalogos/registros"]').parents('div .collapse').addClass('show');

</script>
@endsection
