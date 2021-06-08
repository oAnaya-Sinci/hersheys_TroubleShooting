<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos;
use Illuminate\Support\Facades\DB;

class consultaCatalogos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Elementos = $this->getElementos();
        $loggin_User = Auth()->User()->name;
        $adminUser = Auth()->User()->admin_user;

        return view('Development/Catalogos/consulta', compact('Elementos', 'loggin_User','adminUser'));
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

    function getElementos(){

        $Elementos = catalogos::select('catalogos.id AS cata_id', 'jc.jrq_nombre AS tipo', 'catalogos.ctg_name AS nombre', 'parent.ctg_name AS padre')
                        ->leftJoin('catalogos AS parent', 'catalogos.ctg_padre', '=', 'parent.ctg_id')
                        ->join('jerarquia_catalogos AS jc', 'catalogos.ctg_tipo', '=', 'jc.jrq_id')
                        ->where('catalogos.ctg_eliminado', 0)
                        ->distinct()->get();

        return $Elementos;
    }
}
