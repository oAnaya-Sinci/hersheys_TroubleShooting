<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incidencias;
use App\Models\Catalogos;
use Illuminate\Support\Facades\DB;

class reportesHershey extends Controller
{
    public function reporte_general(){

        $BU = Catalogos::where('ctg_tipo', '=', 'jrq-bussn')->get();
        return view('Development/Reportes/reporte_general', compact('BU'));
    }

    /* public function reporte_general_2(){

        $Incidencias = Incidencias::all();
        $BU = Catalogos::where('ctg_tipo', '=', 'jrq-bussn')->get();
        $Areas = Catalogos::where('ctg_tipo', '=', 'jrq-area')->get();
        $Line = Catalogos::where('ctg_tipo', '=', 'jrq-line')->get();
        $Equipt = Catalogos::where('ctg_tipo', '=', 'jrq-equipment')->get();
        $System = Catalogos::where('ctg_tipo', '=', 'jrq-system')->get();
        $Component = Catalogos::where('ctg_tipo', '=', 'jrq-component')->get();
        $CtrlPanel = Catalogos::where('ctg_tipo', '=', 'jrq-ctrlPanl')->get();

        return view('Development/Reportes/reporte_general_aux', compact('BU', 'Incidencias', 'Areas', 'Line', 'Equipt', 'System', 'Component', 'CtrlPanel'));
    } */

    /* public function get_data_reporte(Request $data){

        $arrayData = $data['data'];
        $startDate = $arrayData[0]['val'];
        $endDate = $arrayData[1]['val'];

        unset( $arrayData[0], $arrayData[1] );

        $lastCol = count($arrayData);

        $Columns = array('icd_bu', 'icd_area', 'icd_line', 'icd_equipment', 'icd_system', 'icd_component', 'icd_controlpanel');

        $query = 'SELECT ctg.ctg_id, ctg.ctg_name AS Nombre, iss.ctg_name AS Issue, COUNT( ctg.ctg_id ) AS TOTAL_INCIDENCIAS FROM incidencias icd INNER JOIN catalogos ctg ON ctg.ctg_id = icd.' . $Columns[$lastCol];
        $query .= ' LEFT JOIN catalogos iss ON iss.ctg_id = icd.icd_IssueType WHERE DATE_FORMAT(icd.created_at, "%d-%m-%Y") BETWEEN "' . $startDate .'" AND "' . $endDate . '"';

        $x=0;
        foreach($arrayData AS $d){

            if($d['val'] != NULL)
                $query .= " AND icd." . $Columns[$x] . " = '" . $d['val'] . "'";

            else
                break;

            $x++;
        }

        $query .= " GROUP BY ctg.ctg_id, ctg.ctg_name, iss.ctg_name ORDER BY ctg.ctg_name, iss.ctg_name";

        $reportData = DB::select($query);
        $returned = array($Columns[$x], $reportData);

        return json_encode($returned);
    } */

    public function get_data_reporte(Request $data){

        $rqst = $data['data'];

        $arrayReport = [];
        $elements = $this->get_elements($rqst);

        array_push($arrayReport, $elements[1]);
        $data = $this->get_dataReport($rqst, sizeof($elements[0]), $elements[2]);

        foreach($data AS $d){
            array_push($arrayReport, $d);
        }

        return json_encode( $arrayReport );
    }

    public function get_elements($arrayData){

        $startDate = $arrayData[0]['val'];
        $endDate = $arrayData[1]['val'];

        unset( $arrayData[0], $arrayData[1] );

        $lastCol = count($arrayData);

        $Columns = array('icd_bu', 'icd_area', 'icd_line', 'icd_equipment', 'icd_system', 'icd_component', 'icd_controlpanel');

        $query = 'SELECT DISTINCT ctg.ctg_id, ctg.ctg_name AS Nombre FROM incidencias icd INNER JOIN catalogos ctg ON ctg.ctg_id = icd.' . $Columns[$lastCol];
        $query .= ' LEFT JOIN catalogos iss ON iss.ctg_id = icd.icd_IssueType WHERE DATE_FORMAT(icd.created_at, "%d-%m-%Y") BETWEEN "' . $startDate .'" AND "' . $endDate . '"';

        $x=0;
        foreach($arrayData AS $d){

            if($d['val'] != NULL)
                $query .= " AND icd." . $Columns[$x] . " = '" . $d['val'] . "'";

            else
                break;

            $x++;
        }

        $query .= " GROUP BY ctg.ctg_id, ctg.ctg_name, iss.ctg_name ORDER BY ctg.ctg_name, iss.ctg_name";

        $reportData = DB::select($query);

        $arrayElement = [];
        $arrayIdElem = [];

        array_push($arrayElement, 'Elemento');

        foreach($reportData AS $rp){

            array_push($arrayIdElem, $rp->ctg_id);
            array_push($arrayElement, $rp->Nombre);
        }

        return array($arrayIdElem, $arrayElement, $Columns[$lastCol]);
    }

    public function get_dataReport($arrayData, $sizeOf, $Column){

        $startDate = $arrayData[0]['val'];
        $endDate = $arrayData[1]['val'];

        $query = "SELECT ctg_id, ctg_name FROM catalogos ctg WHERE ctg.ctg_tipo = 'jrq-issue' ORDER BY ctg_name";
        $issues = DB::select($query);

        $arrayDataIssues = [];
        foreach($issues AS $is){

            $query = 'SELECT ctg.ctg_id, ctg.ctg_name AS Nombre, iss.ctg_name AS Issue, COUNT( ctg.ctg_id ) AS tot FROM incidencias icd INNER JOIN catalogos ctg ON ctg.ctg_id = icd.' . $Column;
            $query .= ' LEFT JOIN catalogos iss ON iss.ctg_id = icd.icd_IssueType WHERE DATE_FORMAT(icd.created_at, "%d-%m-%Y") BETWEEN "' . $startDate .'" AND "' . $endDate . '"';

            $query .= " AND icd.icd_IssueType = '" . $is->ctg_id .  "'";

            $query .= " GROUP BY ctg.ctg_id, ctg.ctg_name, iss.ctg_name ORDER BY ctg.ctg_name, iss.ctg_name";

            $reportData = DB::select($query);

            $arrayData = [];
            array_push($arrayData, $is->ctg_name);

            foreach($reportData AS $rp){

                array_push($arrayData, $rp->tot);
            }

            if(sizeof($reportData) < $sizeOf){

                $x = $sizeOf - sizeof($reportData);

                for($i=0; $i<$x; $i++){

                    array_push($arrayData, 0);
                }
            }

            array_push($arrayDataIssues, $arrayData);
        }

        return $arrayDataIssues;
    }

    public function get_DataTable(Request $arrayData){

        $data = $arrayData['data'];

        $startDate = $data[0]['val'];
        $endDate = $data[1]['val'];

        unset( $data[0], $data[1] );

        $lastCol = count($data);

        $Columns = array('icd_bu', 'icd_area', 'icd_line', 'icd_equipment', 'icd_system', 'icd_component', 'icd_controlpanel');

        $query = 'SELECT DISTINCT icd.* FROM incidencias icd INNER JOIN catalogos ctg ON ctg.ctg_id = icd.' . $Columns[$lastCol];
        $query .= ' INNER JOIN catalogos iss ON iss.ctg_id = icd.icd_IssueType WHERE DATE_FORMAT(icd.created_at, "%d-%m-%Y") BETWEEN "' . $startDate .'" AND "' . $endDate . '"';

        $x=0;
        foreach($data AS $d){

            if($d['val'] != NULL)
                $query .= " AND icd." . $Columns[$x] . " = '" . $d['val'] . "'";

            else
                break;

            $x++;
        }
 
        $query .= " ORDER BY ctg.ctg_name, iss.ctg_name";

        $reportData = DB::select($query);

        return json_encode($reportData);
    }
}
