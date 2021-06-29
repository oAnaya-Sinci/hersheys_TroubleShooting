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
                Modificar Catalogos
            </div>
            <div class="card-body">

            <form id="elementForm" >

                <div class="row">
                    <div class="col-lg-6">
                        <label class="mb-0">Elemento</label>
                        <select id="element_parent" name="elemento_padre" class="form-control bc-choco mb-1">
                            <option value="">Seleccionar Elemento</option>
                            @foreach($Elementos AS $Ele)

                                <option value="{{ $Ele['jrq_id'] }}"> {{ $Ele['jrq_nombre'] }} </option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="mb-0">Elemento a Modificar</label>
                        <select id="element_update" name="elemento" class="form-control bc-choco mb-1">
                            <option value="">Seleccionar Elemento</option>
                        </select>
                    </div>
                </div>
                <div class="my-2"></div>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="mb-0">Nuevo Nombre</label>
                        <input type="text" id="nombre_elemento" name="nombre_elemento" class="form-control bc-choco mb-1" placeholder="Nuevo nombre elemento">
                    </div>
                    <div class="col-lg-6">
                        <label class="mb-0">Nuevo elemento padre</label>
                        <select id="elemento_padre" name="elemento_padre" class="form-control bc-choco">
                            <option value="">Elemento padre</option>
                        </select>
                    </div>
                </div>
                <div class="my-2"></div>
                <hr class="sidebar-divider d-none d-md-block">
                <div class="row">
                    <div class="col-lg-12" style="text-align: right;">
                        <a id="updateCatalogos" href="#" class="btn btn-success btn-icon-split">
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

<!-- Page level plugins -->
<script src="{{ config('app.url', '') }}/js/update.js"></script>

<script>

    $('a[href *= "/Catalogos/modificar"]').addClass('active');
    var parent = $('a[href *= "/Catalogos/modificar"]').parents('div .collapse').addClass('show');

</script>

@endsection
