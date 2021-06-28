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
        $seeReports = Auth()->User()->see_reports;

        return view('Development/Catalogos/consulta', compact('Elementos', 'loggin_User','adminUser', 'seeReports'));
    }

    /**
     *
    */

    function getElementos(){

        $Elementos = catalogos::select('catalogos.id AS cata_id', 'jc.jrq_nombre AS tipo', 'catalogos.ctg_name AS nombre', 'grand_grand_parent.ctg_name AS gg_parent', catalogos::raw('IF( grand_parent.ctg_name <> "", CONCAT(grand_parent.ctg_name, " / ", parent.ctg_name), parent.ctg_name ) AS padre'))
                        ->leftJoin('catalogos AS parent', 'catalogos.ctg_padre', '=', 'parent.ctg_id')
                        ->leftJoin('catalogos AS grand_parent', 'parent.ctg_padre', '=', 'grand_parent.ctg_id')
                        ->leftJoin('catalogos AS grand_grand_parent', 'grand_parent.ctg_padre', '=', 'grand_grand_parent.ctg_id')
                        ->join('jerarquia_catalogos AS jc', 'catalogos.ctg_tipo', '=', 'jc.jrq_id')
                        ->where('catalogos.ctg_eliminado', 0)
                        // ->where('parent.ctg_eliminado', 0)
                        // ->where('grand_parent.ctg_eliminado', 0)
                        // ->where('grand_grand_parent.ctg_eliminado', 0)
                        ->distinct()
                        ->get();

        return $Elementos;
    }

    public function deleteCatalog(Request $data){

        catalogos::where('id', $data['data'])->update(['ctg_eliminado' => '1']);

        // catalogos::where('id', $data['data'])->delete();

        return true;
    }
}
