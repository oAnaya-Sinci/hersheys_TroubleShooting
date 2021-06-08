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
        $areaLinea = Catalogos::where('ctg_tipo', '=', 'jrq-area-line')->get();
        $subequip = Catalogos::where('ctg_tipo', '=', 'jrq-subequipt')->get();
        $controlPanel = Catalogos::where('ctg_tipo', '=', 'jrq-ctrlPanl')->get();
        $loggin_User = Auth()->User()->name;
        $adminUser = Auth()->User()->admin_user;

        return view('Development/Reportes/reporte_general', compact('BU', 'areaLinea', 'controlPanel', 'subequip', 'loggin_User', 'adminUser'));
    }

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

    public function get_elements($rqst){

        $startDate = explode("-", $rqst[0]['val']);
        $startDate = $startDate[2] . "-" . $startDate[1] . "-" . $startDate[0];

        $endDate = explode("-", $rqst[1]['val']);
        $endDate = $endDate[2] . "-" . $endDate[1] . "-" . $endDate[0];

        unset( $rqst[0], $rqst[1] );

        $lastCol = count($rqst);

        $Columns = array('icd_bu', 'icd_area_linea', 'icd_proceso', 'icd_equipment_system', 'icd_component', 'icd_subequipment', 'icd_controlpanel');

        $query = 'SELECT DISTINCT ctg.ctg_id, ctg.ctg_name AS Nombre FROM incidencias icd INNER JOIN catalogos ctg ON ctg.ctg_id = icd.' . $Columns[$lastCol];
        $query .= ' LEFT JOIN catalogos iss ON iss.ctg_id = icd.icd_IssueType WHERE UNIX_TIMESTAMP(icd.created_at) BETWEEN UNIX_TIMESTAMP("' . $startDate .'") AND UNIX_TIMESTAMP("' . $endDate . '")';

        $x=0;
        foreach($rqst AS $d){

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

    public function get_dataReport($rqst, $sizeOf, $Column){

        $startDate = explode("-", $rqst[0]['val']);
        $startDate = $startDate[2] . "-" . $startDate[1] . "-" . $startDate[0];

        $endDate = explode("-", $rqst[1]['val']);
        $endDate = $endDate[2] . "-" . $endDate[1] . "-" . $endDate[0];

        $query = "SELECT ctg_id, ctg_name FROM catalogos ctg WHERE ctg.ctg_tipo = 'jrq-issue' ORDER BY ctg_name";
        $issues = DB::select($query);

        $arrayDataIssues = [];
        foreach($issues AS $is){

            $query = 'SELECT ctg.ctg_id, ctg.ctg_name AS Nombre, iss.ctg_name AS Issue, COUNT( ctg.ctg_id ) AS tot FROM incidencias icd INNER JOIN catalogos ctg ON ctg.ctg_id = icd.' . $Column;
            $query .= ' LEFT JOIN catalogos iss ON iss.ctg_id = icd.icd_IssueType WHERE UNIX_TIMESTAMP(icd.created_at) BETWEEN UNIX_TIMESTAMP("' . $startDate .'") AND UNIX_TIMESTAMP("' . $endDate . '")';

            $query .= " AND icd.icd_IssueType = '" . $is->ctg_id .  "'";

            $query .= " GROUP BY ctg.ctg_id, ctg.ctg_name, iss.ctg_name ORDER BY ctg.ctg_name, iss.ctg_name";

            $reportData = DB::select($query);

            $rqst = [];
            array_push($rqst, $is->ctg_name);

            foreach($reportData AS $rp){

                array_push($rqst, $rp->tot);
            }

            if(sizeof($reportData) < $sizeOf){

                $x = $sizeOf - sizeof($reportData);

                for($i=0; $i<$x; $i++){

                    array_push($rqst, 0);
                }
            }

            array_push($arrayDataIssues, $rqst);
        }

        return $arrayDataIssues;
    }

    public function get_DataTable(Request $arrayData){

        $data = $arrayData['data'];

        $startDate = explode("-", $data[0]['val']);
        $startDate = $startDate[2] . "-" . $startDate[1] . "-" . $startDate[0];

        $endDate = explode("-", $data[1]['val']);
        $endDate = $endDate[2] . "-" . $endDate[1] . "-" . $endDate[0];

        unset( $data[0], $data[1] );

        $lastCol = count($data);

        $Columns = array('icd_bu', 'icd_area_linea', 'icd_proceso', 'icd_equipment_system', 'icd_component', 'icd_subequipment', 'icd_controlpanel');

        $query = 'SELECT DISTINCT icd.* FROM incidencias icd INNER JOIN catalogos ctg ON ctg.ctg_id = icd.' . $Columns[$lastCol];
        $query .= ' INNER JOIN catalogos iss ON iss.ctg_id = icd.icd_IssueType WHERE UNIX_TIMESTAMP(icd.created_at) BETWEEN UNIX_TIMESTAMP("' . $startDate .'") AND UNIX_TIMESTAMP("' . $endDate . '")';

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
