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
                        <label>Elemento</label>
                        <select id="element_parent" name="elemento_padre" class="form-control bc-choco">
                            <option value="">Seleccionar Elemento</option>
                            @foreach($Elementos AS $Ele)

                                <option value="{{ $Ele['jrq_id'] }}"> {{ $Ele['jrq_nombre'] }} </option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label>Nombre</label>
                        <select id="element_update" name="elemento" class="form-control bc-choco">
                            <option value="">Seleccionar Elemento</option>
                        </select>
                    </div>
                </div>
                <div class="my-2"></div>
                <div class="row">
                    <div class="col-lg-6">
                        <label>Nuevo Nombre</label>
                        <input type="text" id="nombre_elemento" name="nombre_elemento" class="form-control bc-choco" placeholder="nuevo nombre elemento">
                    </div>
                </div>
                <div class="my-2"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <textarea class="form-control bc-choco" rows="5" id="description"> Describir elemento</textarea>
                    </div>
                </div>
                <div class="my-2"></div>
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
