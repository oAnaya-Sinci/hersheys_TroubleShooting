<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos;
use App\Models\Incidencias AS storeIncidencias;
use Illuminate\Support\Facades\DB;

class incidencias extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $BU = Catalogos::where('ctg_tipo', '=', 'jrq-bussn')->where('catalogos.ctg_eliminado', 0)->orderby('ctg_name')->get();
        $areaLinea = Catalogos::where('ctg_tipo', '=', 'jrq-area-line')->where('catalogos.ctg_eliminado', 0)->orderby('ctg_name')->get();
        $Issues = Catalogos::where('ctg_tipo', '=', 'jrq-issue')->where('catalogos.ctg_eliminado', 0)->orderby('ctg_name')->get();
        $TipoCtrl = Catalogos::where('ctg_tipo', '=', 'jrq-tipo-controlador')->where('catalogos.ctg_eliminado', 0)->orderby('ctg_name')->get();
        $Componente = Catalogos::where('ctg_tipo', '=', 'jrq-component')->where('catalogos.ctg_eliminado', 0)->orderby('ctg_name')->get();
        $ActionReq = Catalogos::where('ctg_tipo', '=', 'jrq-action')->where('catalogos.ctg_eliminado', 0)->orderby('ctg_name')->get();
        $Detractor = Catalogos::where('ctg_tipo', '=', 'jrq-detractor')->where('catalogos.ctg_eliminado', 0)->orderby('ctg_name')->get();
        $Respaldo = Catalogos::where('ctg_tipo', '=', 'jrq-respaldo')->where('catalogos.ctg_eliminado', 0)->orderby('ctg_name')->get();
        $Refaccion = Catalogos::where('ctg_tipo', '=', 'jrq-refaccion')->where('catalogos.ctg_eliminado', 0)->orderby('ctg_name')->get();
        $Estatus = Catalogos::where('ctg_tipo', '=', 'jrq-estatus')->where('catalogos.ctg_eliminado', 0)->orderby('ctg_name')->get();

        $loggin_User = Auth()->User()->name;
        $adminUser = Auth()->User()->admin_user;

        return view('Development/TroubleShooting/registro', compact('BU', 'areaLinea', 'Issues', 'ActionReq', 'Detractor', 'Respaldo', 'Refaccion', 'Estatus', 'TipoCtrl', 'Componente', 'loggin_User', 'adminUser'));
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
        $data = $request['data'];

        $incidencia = new storeIncidencias;
        $incidencia->icd_BU = $data[0]['value'];
        $incidencia->icd_Area_linea = $data[1]['value'];
        $incidencia->icd_Proceso = $data[2]['value'];
        $incidencia->icd_Equipment_System = $data[3]['value'];
        $incidencia->icd_Tipo_Controlador = $data[4]['value'];
        $incidencia->icd_Component = $data[5]['value'];
        $incidencia->icd_Subsystem = $data[6]['value'];
        $incidencia->icd_ControlPanel = $data[7]['value'];
        $incidencia->icd_IssueType = $data[8]['value'];
        $incidencia->icd_ActionRequired = $data[9]['value'];
        $incidencia->icd_Shift = $data[10]['value'];
        $incidencia->icd_Priority = $data[11]['value'];
        $incidencia->icd_ReportingDate = $data[12]['value'];
        $incidencia->icd_ClosingDate = $data[13]['value'];
        $incidencia->icd_ResponseTime = $data[14]['value'];
        $incidencia->icd_StartTime = $data[15]['value'];
        $incidencia->icd_EndTime = $data[16]['value'];
        $incidencia->icd_TotalTime = $data[17]['value'];
        $incidencia->icd_DiagramaProcManual = $data[18]['value'];
        $incidencia->icd_Respaldo = $data[19]['value'];
        $incidencia->icd_Refaccion = $data[20]['value'];
        $incidencia->icd_tiempoDiagnosticar = $data[21]['value'];
        $incidencia->icd_Estatus = $data[22]['value'];
        // $incidencia->icd_reportedBy = $data[23]['value'];
        $incidencia->icd_ProblemDescription = $data[23]['value'];
        $incidencia->icd_Comments = $data[24]['value'];
        $incidencia->user_id = Auth()->User()->id;
        $incidencia->save();

        return true;
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
     * Funciones para obtener informacion relacionada con el registro de catalogos
     */

    public function getElements(Request $Data){

        $ctgTipo = $Data['data'][0];
        $ctgPadre = $Data['data'][1];

        $catalogos = DB::table('catalogos')
        ->where('ctg_tipo', '=', $ctgTipo)
        ->where('ctg_padre', '=', $ctgPadre == 'null' ? null : $ctgPadre)
        ->where('catalogos.ctg_eliminado', 0)
        ->orderby('ctg_name')
        ->get();

        return json_encode( $catalogos );
    }
}
