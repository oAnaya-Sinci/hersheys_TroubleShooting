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
                        <label>BU - Business Unit</label>
                        <select id="jrq-bussn" name="jrq-bussn" class="form-control bc-choco">
                            <option value=''>Seleccionar Elemento</option>
                            @foreach($BU AS $b)

                                <option value="{{ $b['ctg_id'] }}"> {{ $b['ctg_name'] }} </option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Area</label>
                        <select id="jrq-area" name="jrq-area" class="form-control bc-choco">
                            <option value=''>Seleccionar Elemento</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Line</label>
                        <select id="jrq-line" name="jrq-line" class="form-control bc-choco">
                            <option value=''>Seleccionar Elemento</option>
                        </select>
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-4">
                        <label>Equipment</label>
                        <select id="jrq-equipmnet" name="jrq-equipment" class="form-control bc-choco">
                            <option value=''>Seleccionar Elemento</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>System</label>
                        <select id="jrq-system" name="jrq-system" class="form-control bc-choco">
                            <option value=''>Seleccionar Elemento</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Componet</label>
                        <select id="jrq-component" name="jrq-component" class="form-control bc-choco">
                            <option value=''>Seleccionar Elemento</option>
                        </select>
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-4">
                        <label>Control Panel</label>
                        <select id="jrq-ctrlPanl" name="jrq-ctrlPanl" class="form-control bc-choco">
                            <option value=''>Seleccionar Elemento</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Issue Type</label>
                        <select id="jrq-issue" name="jrq-issue" class="form-control bc-choco">
                            <option value=''>Seleccionar Issue</option>
                            @foreach($Issues AS $is)

                                <option value="{{ $is['ctg_id'] }}"> {{ $is['ctg_name'] }} </option>

                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Action Required</label>
                        <select id="jrq-action" name="jrq-action" class="form-control bc-choco">
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
                        <label>Priority</label>
                        <input type="text" name="priority" class="form-control bc-choco" placeholder="priority" />
                    </div>
                    <div class="col-lg-4">
                        <label>Responsible</label>
                        <input type="text" name="responsible" class="form-control bc-choco" placeholder="responsible" />
                    </div>

                    <div class="col-lg-4">
                        <label>Shift</label>
                        <!-- <input type="text" class="form-control bc-choco" placeholder="shift" /> -->
                        <select name="Shift" class="form-control bc-choco">
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
                        <label>Reporting Date</label>
                        <input type="text" name="ReportingDate" class="form-control bc-choco datetimepicker" placeholder="responsible" />
                        <!-- <div class="input-group-append">
                            <input type="text" class="form-control bc-choco datetimepicker"></input>
                            <i class="fas fa-calendar"></i>
                        </div> -->
                    </div>

                    <div class="col-lg-4">
                        <label>Closing Date</label>
                        <input type="text" name="ClosisngDate" class="form-control bc-choco datetimepicker" placeholder="shift" />
                    </div>
                    <div class="col-lg-4">
                        <label>Response Time</label>
                        <input type="text" name="ResponseTime" class="form-control bc-choco" placeholder="response time" />
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-4">
                        <label>Start Time</label>
                        <input type="text" id="startTime" name="StartTime" class="form-control bc-choco datetimepicker-hour" placeholder="00:00" />
                    </div>
                    <div class="col-lg-4">
                        <label>End Time</label>
                        <input type="text" id="endTime" name="EndTime" class="form-control bc-choco datetimepicker-hour" placeholder="00:00" />
                    </div>
                    <div class="col-lg-4">
                        <label>Total Time</label>
                        <input type="text" id="totalTime" name="TotalTime" class="form-control bc-choco" placeholder="total time" />
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-4">
                        <label>Diagrama Procedimiento Manual</label>
                        <input type="text" name="Diagrama" class="form-control bc-choco" placeholder="Diagrama" />
                    </div>
                    <div class="col-lg-4">
                        <label>Respaldo</label>
                        <input type="text" name="Respaldo" class="form-control bc-choco" placeholder="Respaldo" />
                    </div>
                    <div class="col-lg-4">
                        <label>Refaccion</label>
                        <input type="text" name="Refaccion" class="form-control bc-choco" placeholder="refaccion" />
                    </div>
                </div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-4">
                        <label>Tiempo en Diagnosticar</label>
                        <input type="text" name="Diagrama" class="form-control bc-choco datetimepicker-hour" placeholder="Tiempo en Diagnosticar" />
                    </div>
                    <div class="col-lg-4">
                        <label>Reported By</label>
                        <input type="text" name="Respaldo" class="form-control bc-choco" placeholder="Reported By" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <label>Problem Description</label>
                        <textarea name="ProblemDescription" class="form-control bc-choco" rows="5"></textarea>
                    </div>

                    <div class="col-lg-6">
                        <label>Comments</label>
                        <textarea name="Comments" class="form-control bc-choco" rows="5"></textarea>
                    </div>
                </div>

                <div class="my-2"></div>
                <div class="my-2"></div>

                <div class="row">
                    <div class="col-lg-12" style="text-align: right;">
                        <a href="#" id="storeIncidencias" class="btn btn-success btn-icon-split" id="saveIncidents">
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
