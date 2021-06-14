<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\jerarquia_catalogos;
use App\Models\Catalogos AS storeCatalogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class catalogos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggin_User = Auth()->User()->name;
        $Elementos = jerarquia_catalogos::all();
        $adminUser = Auth()->User()->admin_user;

        return view('Development/Catalogos/registro', compact('Elementos', 'loggin_User', 'adminUser'));
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
        $dataName = explode(',', $request['data'][1]['value']);

        foreach($dataName AS $name){

            $tot_cata = storeCatalogo::where('ctg_name', $name)->count();

            $nameId = str_replace(' ', '', $name);
            $nameId = $this->changueEspecialCaracters($nameId);

            $Catalogo = new StoreCatalogo();
            $Catalogo->ctg_id = $request['data'][0]['value'] . "-" . ($tot_cata == 0 ? $nameId : $nameId . "-" . (string)$tot_cata);
            $Catalogo->ctg_tipo = $request['data'][0]['value'];
            $Catalogo->ctg_name = trim($name);
            $Catalogo->ctg_padre = $request['data'][2]['value'];
            $Catalogo->ctg_eliminado = 0;
            $Catalogo->save();
        }

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
    public function update(Request $request)
    {
        $columnsInci = ['icd_BU', 'icd_Area_linea', 'icd_Proceso', 'icd_Equipment_System', 'icd_Component', 'icd_Subsystem', 'icd_ControlPanel', 'icd_IssueType', 'icd_ActionRequired'];

        $name = $request['data'][2]['value'];

        $tot_cata = storeCatalogo::where('ctg_name', $name)->count();

        $nameId = str_replace(' ', '', $name);
        $nameId = $this->changueEspecialCaracters($nameId);

        foreach($columnsInci AS $ci){

            DB::table('incidencias')
            ->where($ci, '=', $request['data'][1]['value'])
            ->update( [ $ci => $request['data'][0]['value'] . "-" . ($tot_cata == 0 ? $nameId : $nameId . "-" . (string)$tot_cata) ] );
        }

        DB::table('catalogos')
        ->where('ctg_padre', $request['data'][1]['value'])
        ->update([
            'ctg_padre' => $request['data'][0]['value'] . "-" . ($tot_cata == 0 ? $nameId : $nameId . "-" . (string)$tot_cata)
        ]);

        DB::table('catalogos')
        ->where('ctg_id', $request['data'][1]['value'])
        ->update([
            'ctg_id' => $request['data'][0]['value'] . "-" . ($tot_cata == 0 ? $nameId : $nameId . "-" . (string)$tot_cata),
            'ctg_name' => $name
        ]);

        return true;
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

    public function getElements(Request $data){

        $type = $data['data'];

        $elemento = DB::table('jerarquia_catalogos')->where('jrq_id', '=', $type)->value('jrq_padre');
        
        if($elemento != 'jrq-bussn'){

            $catalogos = DB::table('catalogos')
            ->select(DB::raw("catalogos.ctg_id, IF( grand_parent.ctg_name <> '', CONCAT(grand_parent.ctg_name, ' / ', parent.ctg_name, ' / ', catalogos.ctg_name), CONCAT(parent.ctg_name, ' / ', catalogos.ctg_name) ) AS ctg_name"))
            ->leftjoin('catalogos AS parent', 'catalogos.ctg_padre', 'parent.ctg_id')
            ->leftJoin('catalogos AS grand_parent', 'parent.ctg_padre', '=', 'grand_parent.ctg_id')
            ->where('catalogos.ctg_tipo', '=', $elemento)
            ->where('catalogos.ctg_eliminado', 0)
            ->orderby('ctg_name')
            ->get();
        }

        else{

            $catalogos = DB::table('catalogos')
            ->select(DB::raw("catalogos.ctg_id, IF( parent.ctg_name <> '', CONCAT(parent.ctg_name, ' / ', catalogos.ctg_name), catalogos.ctg_name ) AS ctg_name"))
            ->leftjoin('catalogos AS parent', 'catalogos.ctg_padre', 'parent.ctg_id')
            ->where('catalogos.ctg_tipo', '=', $elemento)
            ->where('catalogos.ctg_eliminado', 0)
            ->orderby('ctg_name')
            ->get();
        }

        return json_encode( $catalogos );
    }

    /**
     * Funciones para modificar los elmentos registrados en los catalogos
     */

     public function modificar(){

        $Elementos = jerarquia_catalogos::all();
        $loggin_User = Auth()->User()->name;
        $adminUser = Auth()->User()->admin_user;

        return view('Development/Catalogos/modificar', compact('Elementos', 'loggin_User', 'adminUser'));
     }

     public function get_elements_modificar(){

        if($_GET['element'] == 'jrq-component'){

            $catalogos = DB::table('catalogos')
            ->select(DB::raw("catalogos.ctg_id, IF( grand_grand_parent.ctg_name <> '', CONCAT(grand_grand_parent.ctg_name, ' / ', grand_parent.ctg_name, ' / ', parent.ctg_name, ' / ', catalogos.ctg_name), CONCAT(grand_parent.ctg_name, ' / ', parent.ctg_name, ' / ', catalogos.ctg_name) ) AS ctg_name"))
            ->leftjoin('catalogos AS parent', 'catalogos.ctg_padre', 'parent.ctg_id')
            ->leftJoin('catalogos AS grand_parent', 'parent.ctg_padre', '=', 'grand_parent.ctg_id')
            ->leftJoin('catalogos AS grand_grand_parent', 'grand_parent.ctg_padre', '=', 'grand_grand_parent.ctg_id')
            ->where('catalogos.ctg_tipo', '=', $_GET['element'])
            ->where('catalogos.ctg_eliminado', 0)
            ->orderby('ctg_name')
            ->get();
        }

        else if($_GET['element'] == 'jrq-bussn' || $_GET['element'] == 'jrq-issue'|| $_GET['element'] == 'jrq-action'){

            $catalogos = DB::table('catalogos')
            ->select(DB::raw("catalogos.ctg_id, catalogos.ctg_name"))
            ->where('catalogos.ctg_tipo', '=', $_GET['element'])
            ->where('catalogos.ctg_eliminado', 0)
            ->orderby('ctg_name')
            ->get();
        }

        else{

            $catalogos = DB::table('catalogos')
            ->select(DB::raw("catalogos.ctg_id, IF( grand_parent.ctg_name <> '', CONCAT(grand_parent.ctg_name, ' / ', parent.ctg_name, ' / ', catalogos.ctg_name), CONCAT(parent.ctg_name, ' / ', catalogos.ctg_name) ) AS ctg_name"))
            ->leftjoin('catalogos AS parent', 'catalogos.ctg_padre', 'parent.ctg_id')
            ->leftJoin('catalogos AS grand_parent', 'parent.ctg_padre', '=', 'grand_parent.ctg_id')
            ->where('catalogos.ctg_tipo', '=', $_GET['element'])
            ->where('catalogos.ctg_eliminado', 0)
            ->orderby('ctg_name')
            ->get();
        }

        return json_encode( $catalogos );
     }

     /**
     * Funciones para quitar cararctees a cadena
     */

    public function changueEspecialCaracters($valueStr){

        $especialC = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú");
        $newEspecialC = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U");

        $replaceStr = str_replace($especialC, $newEspecialC, $valueStr);

        return $replaceStr;
     }
}
