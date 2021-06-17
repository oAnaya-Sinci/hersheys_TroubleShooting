@extends('mainStructure.mainStructure')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

<div class="row">

    <div class="col-lg-12">

        <!-- Default Card Example -->
        <div class="card mb-4">
            <div class="card-header">
                Registro de Incidencias
            </div>
            <div class="card-body">

            <form id="incidencias">

                <div class="row">
                    <div class="col-lg-4">
                        <label class="mb-0">BU - Business Unit</label>
                        <select id="jrq-bussn" name="jrq-bussn" class="form-control bc-choco mb-1">
                            <option value=''>Seleccionar Elemento</option>
                            @foreach($BU AS $b)

                                <option value="{{ $b['ctg_id'] }}"> {{ $b['ctg_name'] }} </option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">Area / Linea </label>
                        <select id="jrq-area-line" name="jrq-area-line" class="form-control bc-choco mb-1">
                            <option value=''>Seleccionar Elemento</option>
                            @foreach($areaLinea AS $al)

                                <option value="{{ $al['ctg_id'] }}"> {{ $al['ctg_name'] }} </option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">Proceso</label>
                        <select id="jrq-proceso" name="jrq-proceso" class="form-control bc-choco mb-1">
                            <option value=''>Seleccionar Elemento</option>
                        </select>
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-4">
                        <label class="mb-0">Equipment / System</label>
                        <select id="jrq-equipmnet-system" name="jrq-equipment-system" class="form-control bc-choco mb-1">
                            <option value=''>Seleccionar Elemento</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">Componet</label>
                        <select id="jrq-component" name="jrq-component" class="form-control bc-choco mb-1">
                            <option value=''>Seleccionar Elemento</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">Sub Sistema</label>
                        <input type="text" id="jrq-subsystem" name="jrq-subsystem" class="form-control bc-choco mb-1" placeholder="Sub Sistema" />
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-4">
                        <label class="mb-0">Control Panel</label>
                        <input type="text" id="jrq-ctrlPanl" name="jrq-ctrlPanl" class="form-control bc-choco mb-1" placeholder="Control Panel" />
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">Issue Type</label>
                        <select id="jrq-issue" name="jrq-issue" class="form-control bc-choco mb-1">
                            <option value=''>Seleccionar Issue</option>
                            @foreach($Issues AS $is)

                                <option value="{{ $is['ctg_id'] }}"> {{ $is['ctg_name'] }} </option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">Action Required</label>
                        <select id="jrq-action" name="jrq-action" class="form-control bc-choco mb-1">
                        <option value=''>Seleccionar Elemento</option>
                        @foreach($ActionReq AS $ac)

                            <option value="{{ $ac['ctg_id'] }}"> {{ $ac['ctg_name'] }} </option>

                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-4">
                        <label class="mb-0">Priority</label>
                        <input type="text" name="priority" class="form-control bc-choco mb-1" placeholder="priority" />
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">Responsible</label>
                        <input type="text" name="responsible" class="form-control bc-choco mb-1" placeholder="responsible" value="{{$loggin_User}}"/>
                    </div>

                    <div class="col-lg-4">
                        <label class="mb-0">Turno</label>
                        <select name="Shift" class="form-control bc-choco mb-1">
                            <option value=''>Seleccionar Turno</option>
                            <option value='1'>Matutino</option>
                            <option value='2'>Vespertino</option>
                            <option value='2'>Nocturno</option>
                        </select>
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-4">
                        <label class="mb-0">Reporting Date</label>
                        <input type="text" id="ReportingDate" name="ReportingDate" class="form-control bc-choco mb-1 datetimepicker" placeholder="Reporting Date" />
                    </div>

                    <div class="col-lg-4">
                        <label class="mb-0">Closing Date</label>
                        <input type="text" id="ClosingDate" name="ClosingDate" class="form-control bc-choco mb-1 datetimepicker" placeholder="Closing Date" />
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">Response Time en Minutos</label>
                        <input type="text" id="ResponseTime" name="ResponseTime" class="form-control bc-choco mb-1" placeholder="response time" maxlength="4"/>
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-4">
                        <label class="mb-0">Start Time</label>
                        <input type="text" id="startTime" name="StartTime" class="form-control bc-choco mb-1 datetimepicker-hour" placeholder="00:00" />
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">End Time</label>
                        <input type="text" id="endTime" name="EndTime" class="form-control bc-choco mb-1 datetimepicker-hour" placeholder="00:00" />
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">Total Time</label>
                        <input type="text" id="totalTime" name="TotalTime" class="form-control bc-choco mb-1" placeholder="total time" />
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-4">
                        <label class="mb-0">Diagrama Procedimiento Manual</label>
                        <input type="text" name="Diagrama" class="form-control bc-choco mb-1" placeholder="Diagrama" />
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">Respaldo</label>
                        <input type="text" name="Respaldo" class="form-control bc-choco mb-1" placeholder="Respaldo" />
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">Refaccion</label>
                        <input type="text" name="Refaccion" class="form-control bc-choco mb-1" placeholder="refaccion" />
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-4">
                        <label class="mb-0">Tiempo en Diagnosticar en Minutos</label>
                        <input type="text" id="TiempoDiagnos" name="TiempoDiagnos" class="form-control bc-choco mb-1" placeholder="Tiempo en Diagnosticar" maxlength="4"/>
                    </div>
                    <div class="col-lg-4">
                        <label class="mb-0">Reported By</label>
                        <input type="text" name="ReportedBy" class="form-control bc-choco mb-1" placeholder="Reported By" value="{{$loggin_User}}"/>
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-6">
                        <label class="mb-0">Problem Description</label>
                        <textarea name="ProblemDescription" class="form-control bc-choco mb-1" rows="5"></textarea>
                    </div>

                    <div class="col-lg-6">
                        <label class="mb-0">Comments</label>
                        <textarea name="Comments" class="form-control bc-choco mb-1" rows="5"></textarea>
                    </div>
                </div>

                <div class="my-2"></div>
                <hr class="sidebar-divider d-none d-md-block">

                <div class="row">
                    <div class="col-lg-12" style="text-align: right;">
                        <a href="#" id="storeIncidencias" class="btn btn-success btn-icon-split">
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

    $('#saveIncidents').click(function(){

        $('#successModal').modal('show');
    });

    $('a[href *= "/TroubleShooting/registros"]').addClass('active');
    var parent = $('a[href *= "/TroubleShooting/registros"]').parents('div .collapse').addClass('show');

</script>
@endsection
