<?php

namespace App\Http\Controllers;

use App\Models\Catalogos;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class testing extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        die( var_dump( "Omar Anaya" ) );
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
        $Catalogo = new catalogos;
        $Catalogo->ctg_id = $request['data'][0]['value'] . "-" . $request['data'][1]['value'];
        $Catalogo->ctg_tipo = $request['data'][0]['value'];
        $Catalogo->ctg_name = $request['data'][1]['value'];
        $Catalogo->ctg_padre = $request['data'][2]['value'];
        $Catalogo->save();

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
        DB::table('catalogos')
        ->where('ctg_padre', $request['data'][1]['value'])
        ->update([
            'ctg_padre' => $request['data'][0]['value'] . "-" . $request['data'][2]['value']
        ]);

        DB::table('catalogos')
        ->where('ctg_id', $request['data'][1]['value'])
        ->update([
            'ctg_id' => $request['data'][0]['value'] . "-" . $request['data'][2]['value'],
            'ctg_name' => $request['data'][2]['value']
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

    public function getElements(Request $element){

        die( var_dump( $element ) );

        $elemento = DB::table('jerarquia_catalogos')->where('jrq_id', '=', $_GET['element'])->value('jrq_padre');

        $catalogos = DB::table('catalogos')
        ->where('ctg_tipo', '=', $elemento)
        ->get();

        return json_encode( $catalogos );
 }
}
