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
        $Incidencias = $this->getIncidencias();
        $loggin_User = Auth()->User()->name;
        $adminUser = Auth()->User()->admin_user;

        return view('Development/TroubleShooting/consulta', compact('Incidencias', 'loggin_User', 'adminUser'));
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

        $Incidencias = Incidencias::
                        select('incidencias.*', 'bu.ctg_name AS bssnu', 'area.ctg_name AS area', 'line.ctg_name AS line', 'equip.ctg_name AS equipment', 'system.ctg_name AS system', 'component.ctg_name AS component', 'cntrlp.ctg_name AS control', 'issue.ctg_name AS issue', 'actionr.ctg_name AS action')

                        ->join('catalogos AS bu', 'incidencias.icd_bu', 'bu.ctg_id')
                        ->join('catalogos AS area', 'incidencias.icd_area', 'area.ctg_id')
                        ->join('catalogos AS line', 'incidencias.icd_line', 'line.ctg_id')
                        ->join('catalogos AS equip', 'incidencias.icd_equipment', 'equip.ctg_id')
                        ->join('catalogos AS system', 'incidencias.icd_system', 'system.ctg_id')
                        ->join('catalogos AS component', 'incidencias.icd_component', 'component.ctg_id')
                        ->join('catalogos AS cntrlp', 'incidencias.icd_controlpanel', 'cntrlp.ctg_id')
                        ->join('catalogos AS issue', 'incidencias.icd_issuetype', 'issue.ctg_id')
                        ->join('catalogos AS actionr', 'incidencias.icd_actionrequired', 'actionr.ctg_id')

                        ->get();

        return $Incidencias;
     }
}
