<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incidencias;

class consultaIncidencias extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggin_User = Auth()->User()->name;
        $adminUser = Auth()->User()->admin_user;

        return view('Development/TroubleShooting/consulta', compact('loggin_User', 'adminUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     *
     */

     public function getIncidencias(){

        $columnsIncidenc = "BU.ctg_name AS BU, AL.ctg_name AS area_linea, PC.ctg_name AS proceso,
                            ES.ctg_name AS equip_system, TC.ctg_name AS TipoCtrl, CP.ctg_name AS component,
                            IT.ctg_name AS issue_type, AR.ctg_name AS action_required,
                            DT.ctg_name AS Diagrama_procedimiento_manual,
                            RP.ctg_name AS Respaldo, RF.ctg_name AS Refaccion, ST.ctg_name AS Estatus,
                            users.name AS Reportado_Por,
                            incidencias.id,
                            incidencias.created_at AS Fecha_Registro, incidencias.icd_subsystem AS SubSistema,
                            incidencias.icd_controlpanel AS Control_Panel,
                            incidencias.icd_priority AS Prioridad, incidencias.icd_shift AS Turno,
                            incidencias.icd_ReportingDate AS Fecha_Reporte,
                            incidencias.icd_ClosingDate AS Fecha_Cierre, incidencias.icd_ResponseTime AS Tiempo_Respuesta,
                            incidencias.icd_StartTime AS Hora_Inicio, incidencias.icd_EndTime AS Hora_Termino,
                            incidencias.icd_TotalTime AS Tiempo_Total,
                            incidencias.icd_tiempoDiagnosticar AS Tiempo_Diagnosticar";

        $Incidencias = Incidencias::select(Incidencias::raw($columnsIncidenc))
                        ->leftjoin('catalogos AS BU', 'incidencias.icd_bu', 'BU.ctg_id')
                        ->leftjoin('catalogos AS AL', 'incidencias.icd_area_linea', 'AL.ctg_id')
                        ->leftjoin('catalogos AS PC', 'incidencias.icd_proceso', 'PC.ctg_id')
                        ->leftjoin('catalogos AS ES', 'incidencias.icd_equipment_system', 'ES.ctg_id')
                        ->leftjoin('catalogos AS TC', 'incidencias.icd_Tipo_Controlador', 'TC.ctg_id')
                        ->leftjoin('catalogos AS CP', 'incidencias.icd_component', 'CP.ctg_id')
                        ->leftjoin('catalogos AS IT', 'incidencias.icd_issuetype', 'IT.ctg_id')
                        ->leftjoin('catalogos AS AR', 'incidencias.icd_actionrequired', 'AR.ctg_id')
                        ->leftjoin('catalogos AS ST', 'incidencias.icd_Estatus', 'ST.ctg_id')
                        ->leftjoin('catalogos AS DT', 'incidencias.icd_DiagramaProcManual', 'DT.ctg_id')
                        ->leftjoin('catalogos AS RP', 'incidencias.icd_Respaldo', 'RP.ctg_id')
                        ->leftjoin('catalogos AS RF', 'incidencias.icd_Refaccion', 'RF.ctg_id')
                        ->join('users', 'users.id', 'incidencias.user_id')
                        // ->distinct()
                        ->get();

        return json_encode($Incidencias);
     }

     public function getData_Comments_Problem(Request $request){

        $values = $request['data'];
        $response = Incidencias::select($values['column'])->where('id', $values['id'])->get();

        return nl2br($response[0][$values['column']]);
     }
}
