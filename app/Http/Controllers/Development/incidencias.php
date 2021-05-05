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
        $BU = Catalogos::where('ctg_tipo', '=', 'jrq-bussn')->get();
        $Issues = Catalogos::where('ctg_tipo', '=', 'jrq-issue')->get();
        $ActionReq = Catalogos::where('ctg_tipo', '=', 'jrq-action')->get();

        return view('Development/TroubleShooting/registro', compact('BU', 'Issues', 'ActionReq'));
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
        $incidencia = new storeIncidencias;
        $incidencia->icd_BU =  $request['data'][0]['value'];
        $incidencia->icd_Area =  $request['data'][1]['value'];
        $incidencia->icd_Line =  $request['data'][2]['value'];
        $incidencia->icd_Equipment =  $request['data'][3]['value'];
        $incidencia->icd_System =  $request['data'][4]['value'];
        $incidencia->icd_Component =  $request['data'][5]['value'];
        $incidencia->icd_ControlPanel =  $request['data'][6]['value'];
        $incidencia->icd_IssueType =  $request['data'][7]['value'];
        $incidencia->icd_ActionRequired =  $request['data'][8]['value'];
        $incidencia->icd_Priority =  $request['data'][9]['value'];
        $incidencia->icd_Responsible =  $request['data'][10]['value'];
        $incidencia->icd_Shift =  $request['data'][11]['value'];
        $incidencia->icd_ReportingDate =  $request['data'][12]['value'];
        $incidencia->icd_ClosingDate =  $request['data'][13]['value'];
        $incidencia->icd_ResponseTime =  $request['data'][14]['value'];
        $incidencia->icd_StartTime =  $request['data'][15]['value'];
        $incidencia->icd_EndTime =  $request['data'][16]['value'];
        $incidencia->icd_TotalTime =  $request['data'][17]['value'];
        $incidencia->icd_DiagramaProcManual =  $request['data'][18]['value'];
        $incidencia->icd_Respaldo =  $request['data'][19]['value'];
        $incidencia->icd_Refaccion =  $request['data'][20]['value'];
        $incidencia->icd_tiempoDiagnosticar =  $request['data'][21]['value'];
        $incidencia->icd_reportedBy =  $request['data'][22]['value'];
        $incidencia->icd_ProblemDescription =  $request['data'][23]['value'];
        $incidencia->icd_Comments =  $request['data'][24]['value'];
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
        ->get();

        return json_encode( $catalogos );
    }
}
