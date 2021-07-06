<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incidencias;
use App\Models\Catalogos;
use App\Models\jerarquia_catalogos;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class reportesHershey extends Controller
{
    public function reporte_incidencias(){

        $BU = Catalogos::where('ctg_tipo', '=', 'jrq-bussn')->orderby('ctg_name')->get();
        $areaLinea = Catalogos::where('ctg_tipo', '=', 'jrq-area-line')->orderby('ctg_name')->get();
        $loggin_User = Auth()->User()->name;
        $adminUser = Auth()->User()->admin_user;
        $seeReports = Auth()->User()->see_reports;

        return view('Development/Reportes/reporte_general', compact('BU', 'areaLinea', 'loggin_User', 'adminUser', 'seeReports'));
    }

    public function get_data_reporte(Request $data){

        $rqst = $data['data'];
        $pos = sizeof($rqst)-1;

        $arrayReport = [];
        $elements = $this->get_elements($rqst);

        array_push($arrayReport, $elements[1]);
        $data = $this->get_dataReport($rqst, sizeof($elements[0]), $elements[2], $elements[0], $rqst[$pos]['val']);

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

        $Columns = array('icd_bu', 'icd_area_linea', 'icd_proceso', 'icd_equipment_system', 'icd_component');

        $query = 'SELECT DISTINCT ctg.ctg_id, ctg.ctg_name AS Nombre FROM incidencias icd INNER JOIN catalogos ctg ON ctg.ctg_id = icd.' . $Columns[$lastCol];
        $query .= ' LEFT JOIN catalogos iss ON iss.ctg_id = icd.icd_IssueType WHERE UNIX_TIMESTAMP(DATE_FORMAT(icd.created_at, "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP("' . $startDate .'") AND UNIX_TIMESTAMP("' . $endDate . '")';

        $x=0;
        foreach($rqst AS $r){

            if($r['val'] != NULL)
                $query .= " AND icd." . $Columns[$x] . " = '" . $r['val'] . "'";

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

    public function get_dataReport($rqst, $sizeOf, $Column, $elements, $nextEle){

        $startDate = explode("-", $rqst[0]['val']);
        $startDate = $startDate[2] . "-" . $startDate[1] . "-" . $startDate[0];

        $endDate = explode("-", $rqst[1]['val']);
        $endDate = $endDate[2] . "-" . $endDate[1] . "-" . $endDate[0];

        $query = "SELECT ctg_id, ctg_name FROM catalogos ctg WHERE ctg.ctg_tipo = 'jrq-issue' ORDER BY ctg_name";
        $issues = DB::select($query);

        $query = "SELECT ctg_id FROM catalogos ctg WHERE ctg.ctg_padre = '$nextEle' ORDER BY ctg_name";
        $nextElementos = DB::select($query);

        $concatNE = '';
        $x = 1;
        foreach($nextElementos AS $ne){

            if( sizeof($nextElementos) > $x )
                $concatNE .= "'" . $ne->ctg_id . "',";

            else
                $concatNE .= "'" . $ne->ctg_id . "'";

            $x++;
        }

        $arrayDataIssues = [];
        foreach($issues AS $is){

            $query = 'SELECT DISTINCT ctg.ctg_id, ctg.ctg_name AS Nombre, iss.ctg_name AS Issue, COUNT( ctg.ctg_id ) AS tot FROM incidencias icd INNER JOIN catalogos ctg ON ctg.ctg_id = icd.' . $Column;
            $query .= ' LEFT JOIN catalogos iss ON iss.ctg_id = icd.icd_IssueType WHERE UNIX_TIMESTAMP(DATE_FORMAT(icd.created_at, "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP("' . $startDate .'") AND UNIX_TIMESTAMP("' . $endDate . '")';

            $query .= " AND icd.icd_IssueType = '" . $is->ctg_id .  "'";

            $concatNE == '' ? '' : $query .= " AND icd.". $Column ." IN (" . $concatNE .  ")";

            $query .= " GROUP BY ctg.ctg_id, ctg.ctg_name, iss.ctg_name ORDER BY ctg.ctg_name, iss.ctg_name";

            $reportData = DB::select($query);

            $rqst = [];
            array_push($rqst, trim($is->ctg_name));

            foreach($reportData AS $rp){

                for($i=0; $i<sizeof($elements); $i++){

                    if( $rp->ctg_id == $elements[$i] ){
                        array_push($rqst, $rp->tot);
                        $i = 1000;
                    }

                    else{
                        $aux = sizeof($rqst) - 1;

                        if(sizeof($rqst) == 1 || $rqst[$aux] == 0)
                            array_push($rqst, 0);
                    }
                }
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

        $ColumnsIncidencias = array('BU', 'area_linea', 'proceso', 'equip_system', 'TipoCtrl', 'component', 'SubSistema', 'Control_Panel','issue_type', 'action_required', 'Prioridad', 'Estatus', 'Diagrama_procedimiento_manual', 'Respaldo', 'Reportado_Por', 'Refaccion');

        $data = $arrayData['data'];
        $pos = (sizeof($data)-1);

        $startDate = explode("-", $data[0]['val']);
        $startDate = $startDate[2] . "-" . $startDate[1] . "-" . $startDate[0];

        $endDate = explode("-", $data[1]['val']);
        $endDate = $endDate[2] . "-" . $endDate[1] . "-" . $endDate[0];

        unset( $data[0], $data[1] );

        $lastCol = sizeof($data);

        if($lastCol != 0){

            $nextEle = $data[$pos]['val'];

            $query = "SELECT ctg_id FROM catalogos ctg WHERE ctg.ctg_padre = '$nextEle' ORDER BY ctg_name";
            $nextElementos = DB::select($query);
        }

        $Columns = array('icd_bu', 'icd_area_linea', 'icd_proceso', 'icd_equipment_system', 'icd_component');

        $query = 'SELECT DISTINCT
                        BU.ctg_name AS BU, AL.ctg_name AS area_linea, PC.ctg_name AS proceso,
                        ES.ctg_name AS equip_system, TC.ctg_name AS TipoCtrl, CP.ctg_name AS component,
                        IT.ctg_name AS issue_type, AR.ctg_name AS action_required,
                        DT.ctg_name AS Diagrama_procedimiento_manual, users.name AS Reportado_Por,
                        RP.ctg_name AS Respaldo, RF.ctg_name AS Refaccion, ST.ctg_name AS Estatus,
                        incidencias.id,
                        incidencias.created_at AS Fecha_Registro, incidencias.icd_subsystem AS SubSistema,
                        incidencias.icd_controlpanel AS Control_Panel,
                        incidencias.icd_priority AS Prioridad, incidencias.icd_shift AS Turno,
                        incidencias.icd_ReportingDate AS Fecha_Reporte,
                        incidencias.icd_ClosingDate AS Fecha_Cierre, incidencias.icd_ResponseTime AS Tiempo_Respuesta,
                        incidencias.icd_StartTime AS Hora_Inicio, incidencias.icd_EndTime AS Hora_Termino,
                        incidencias.icd_TotalTime AS Tiempo_Total,
                        incidencias.icd_tiempoDiagnosticar AS Tiempo_Diagnosticar

                    FROM incidencias INNER JOIN catalogos ctg ON ctg.ctg_id = incidencias.' . $Columns[$lastCol];

        $query .= ' INNER JOIN catalogos iss ON iss.ctg_id = incidencias.icd_IssueType ';

        $query .= ' LEFT JOIN catalogos AS BU ON incidencias.icd_bu = BU.ctg_id';
        $query .= ' LEFT JOIN catalogos AS AL ON incidencias.icd_area_linea = AL.ctg_id';
        $query .= ' LEFT JOIN catalogos AS PC ON incidencias.icd_proceso = PC.ctg_id';
        $query .= ' LEFT JOIN catalogos AS ES ON incidencias.icd_equipment_system = ES.ctg_id';
        $query .= ' LEFT JOIN catalogos AS TC ON incidencias.icd_Tipo_Controlador = TC.ctg_id';
        $query .= ' LEFT JOIN catalogos AS CP ON incidencias.icd_component = CP.ctg_id';
        $query .= ' LEFT JOIN catalogos AS IT ON incidencias.icd_issuetype = IT.ctg_id';
        $query .= ' LEFT JOIN catalogos AS AR ON incidencias.icd_actionrequired = AR.ctg_id';
        $query .= ' LEFT JOIN catalogos AS ST ON incidencias.icd_Estatus = ST.ctg_id';
        $query .= ' LEFT JOIN catalogos AS DT ON incidencias.icd_DiagramaProcManual = DT.ctg_id';
        $query .= ' LEFT JOIN catalogos AS RP ON incidencias.icd_Respaldo = RP.ctg_id';
        $query .= ' LEFT JOIN catalogos AS RF ON incidencias.icd_Refaccion = RF.ctg_id';
        $query .= ' LEFT JOIN users ON incidencias.user_id = users.id';

        $query .= ' WHERE UNIX_TIMESTAMP(DATE_FORMAT(incidencias.created_at, "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP("' . $startDate .'") AND UNIX_TIMESTAMP("' . $endDate . '")';

        if($lastCol != 0){

            $concatNE = '';
            $x = 1;
            foreach($nextElementos AS $ne){

                if( sizeof($nextElementos) > $x )
                    $concatNE .= "'" . $ne->ctg_id . "',";

                else
                    $concatNE .= "'" . $ne->ctg_id . "'";

                $x++;
            }

            $concatNE == '' ? '' : $query .= " AND incidencias.". $Columns[$lastCol] ." IN (" . $concatNE .  ")";
        }

        $query .= " ORDER BY BU, area_linea, proceso, equip_system, component";

        $reportData = DB::select($query);

        foreach($reportData AS $rd){

            foreach($ColumnsIncidencias AS $ci){

                $rd->$ci = $this->changueEspecialCaracters($rd->$ci);
            }
        }

        return json_encode($reportData);
    }

    /**
     * Funciones para mostrar los reportes de usuarios
     */

     public function reporte_usuarios(Request $request){

        $loggin_User = Auth()->User()->name;
        $adminUser = Auth()->User()->admin_user;
        $seeReports = Auth()->User()->see_reports;
        $filtrarPor = jerarquia_catalogos::whereIn('jrq_id', ['jrq-tipo-controlador', 'jrq-component'])->get();

        return view('Development/Reportes/reporte_usuarios', compact('loggin_User', 'adminUser', 'seeReports', 'filtrarPor'));
     }

     public function get_data_usuarios(Request $data){

        $rqst = $data['data'];

        $Elementos = $this->getElemetos($rqst[3]['val']);
        $users = $this->getUsers();

        $data = $this->get_PromUsersData($rqst, $Elementos[0], $users[0]);

        $dataReportReturn = [ $Elementos[1], $users[1], $data ];

        return json_encode( $dataReportReturn );
     }

     public function getUsers(){

        $query = "SELECT id, name FROM users WHERE id <> 1 ORDER BY id";
        $users = DB::select($query);

        $userId = [];
        $userName = [];
        $userWhereIn = '';

        $i = 1;
        foreach($users AS $usr){

            array_push($userId, $usr->id);
            array_push($userName, $usr->name);

            if($i < sizeof($users))
                $userWhereIn .= $usr->id . ',';

            else
                $userWhereIn .= $usr->id;

            $i++;
        }

        return [$userId, $userName, $userWhereIn];
     }

     public function getElemetos($ctgTipo){

        $query = "SELECT id, ctg_id, ctg_name FROM catalogos WHERE ctg_tipo = '$ctgTipo' ORDER BY ctg_name";
        $TipoElemento = DB::select($query);

        $elementoId = [];
        $elementoName = [];
        $elementoWhereIn = '';

        $i = 1;
        foreach($TipoElemento AS $te){

            array_push($elementoId, $te->ctg_id);
            array_push($elementoName, $te->ctg_name);

            if($i < sizeof($TipoElemento))
                $elementoWhereIn .= "'" . $te->ctg_id . "',";

            else
                $elementoWhereIn .= "'" . $te->ctg_id . "'";

            $i++;
        }

        return [$elementoId, $elementoName, $elementoWhereIn];
     }

     public function get_PromUsersData($rqst, $Elementos, $users){

        $ctgTipo = $rqst[3]['val'];

        $startDate = explode("-", $rqst[0]['val']);
        $startDate = $startDate[2] . "-" . $startDate[1] . "-" . $startDate[0];

        $endDate = explode("-", $rqst[1]['val']);
        $endDate = $endDate[2] . "-" . $endDate[1] . "-" . $endDate[0];

        $fieldSelect = '';
        if($rqst[2]['val'] == 'TT'){

            $fieldSelect = ",SUM(LEFT( incd.icd_TotalTime, INSTR( incd.icd_TotalTime, ':') -1) * 60 + RIGHT(incd.icd_TotalTime, INSTR( incd.icd_TotalTime, ':') -1)) AS SUM_TIEMPO";
            $fieldSelect .= ",AVG((LEFT( incd.icd_TotalTime, INSTR( incd.icd_TotalTime, ':') -1) * 60) + RIGHT(incd.icd_TotalTime, INSTR( incd.icd_TotalTime, ':') -1)) AS PROM_TIEMPO";
        }

        else
            $fieldSelect = ( $rqst[2]['val'] == 'TD' ? ",SUM( incd.icd_tiempoDiagnosticar ) AS SUM_TIEMPO, AVG( incd.icd_tiempoDiagnosticar ) AS PROM_TIEMPO" : ",SUM( incd.icd_ResponseTime ) AS SUM_TIEMPO, AVG( incd.icd_ResponseTime ) AS PROM_TIEMPO");

        $Join = ($rqst[3]['val'] == "jrq-component" ? " INNER JOIN catalogos ctg ON incd.icd_Component = ctg.ctg_id AND incd.icd_Component <> 'jrq-component-N/A' " : " INNER JOIN catalogos ctg ON incd.icd_Tipo_Controlador = ctg.ctg_id AND incd.icd_Tipo_Controlador <> 'jrq-component-N/A' ");

        $valuesToReturn = [];

        foreach($users AS $user){

            $valuesChart = [];

            $query = "SELECT
                        ctg.ctg_id,
                        ctg.ctg_name AS TipoControladorComponente
                        $fieldSelect

                    FROM incidencias incd
                    $Join

                    WHERE UNIX_TIMESTAMP(DATE_FORMAT(incd.created_at, '%Y-%m-%d')) BETWEEN UNIX_TIMESTAMP('" . $startDate . "') AND UNIX_TIMESTAMP('" . $endDate . "')
                    AND incd.user_id = $user

                    GROUP BY ctg.ctg_id, ctg.ctg_name

                    ORDER BY ctg.ctg_name";

            $reportData = DB::select($query);

            foreach($Elementos AS $el){

                $banNotFound = true;
                foreach($reportData AS $rd){

                    if($el == $rd->ctg_id){
                        array_push($valuesChart, $rd->PROM_TIEMPO);
                        $banNotFound = false;
                        break;
                    }
                }

                if($banNotFound)
                    array_push($valuesChart, 0);
            }

            array_push($valuesToReturn, $valuesChart);
        }

        return $valuesToReturn;
     }

     public function get_DataTableUsuarios(Request $arrayData){

        $data = $arrayData['data'];

        $startDate = explode("-", $data[0]['val']);
        $startDate = $startDate[2] . "-" . $startDate[1] . "-" . $startDate[0];

        $endDate = explode("-", $data[1]['val']);
        $endDate = $endDate[2] . "-" . $endDate[1] . "-" . $endDate[0];

        $Join = ($data[3]['val'] == "jrq-component" ? " INNER JOIN catalogos CtrlComp ON icd.icd_Component = CtrlComp.ctg_id " : " INNER JOIN catalogos CtrlComp ON icd.icd_Tipo_Controlador = CtrlComp.ctg_id ");

        $query = 'SELECT DISTINCT
                BU.ctg_name AS BU, AL.ctg_name AS area_linea, PC.ctg_name AS proceso,
                ES.ctg_name AS equip_system, TC.ctg_name AS TipoCtrl, CP.ctg_name AS component,
                IT.ctg_name AS issue_type, AR.ctg_name AS action_required,
                DT.ctg_name AS Diagrama_procedimiento_manual, users.name AS Reportado_Por,
                RP.ctg_name AS Respaldo, RF.ctg_name AS Refaccion, ST.ctg_name AS Estatus,
                incidencias.id,
                incidencias.created_at AS Fecha_Registro, incidencias.icd_subsystem AS SubSistema,
                incidencias.icd_controlpanel AS Control_Panel,
                incidencias.icd_priority AS Prioridad, incidencias.icd_shift AS Turno,
                incidencias.icd_ReportingDate AS Fecha_Reporte,
                incidencias.icd_ClosingDate AS Fecha_Cierre, incidencias.icd_ResponseTime AS Tiempo_Respuesta,
                incidencias.icd_StartTime AS Hora_Inicio, incidencias.icd_EndTime AS Hora_Termino,
                incidencias.icd_TotalTime AS Tiempo_Total,
                incidencias.icd_tiempoDiagnosticar AS Tiempo_Diagnosticar

            FROM incidencias INNER JOIN catalogos ctg ON ctg.ctg_id = incidencias.icd_bu';

        $query .= ' INNER JOIN catalogos iss ON iss.ctg_id = incidencias.icd_IssueType ';

        $query .= ' LEFT JOIN catalogos AS BU ON incidencias.icd_bu = BU.ctg_id';
        $query .= ' LEFT JOIN catalogos AS AL ON incidencias.icd_area_linea = AL.ctg_id';
        $query .= ' LEFT JOIN catalogos AS PC ON incidencias.icd_proceso = PC.ctg_id';
        $query .= ' LEFT JOIN catalogos AS ES ON incidencias.icd_equipment_system = ES.ctg_id';
        $query .= ' LEFT JOIN catalogos AS TC ON incidencias.icd_Tipo_Controlador = TC.ctg_id AND incidencias.icd_Tipo_Controlador <> "jrq-component-N/A"';
        $query .= ' LEFT JOIN catalogos AS CP ON incidencias.icd_component = CP.ctg_id AND incidencias.icd_component <> "jrq-component-N/A"';
        $query .= ' LEFT JOIN catalogos AS IT ON incidencias.icd_issuetype = IT.ctg_id';
        $query .= ' LEFT JOIN catalogos AS AR ON incidencias.icd_actionrequired = AR.ctg_id';
        $query .= ' LEFT JOIN catalogos AS ST ON incidencias.icd_Estatus = ST.ctg_id';
        $query .= ' LEFT JOIN catalogos AS DT ON incidencias.icd_DiagramaProcManual = DT.ctg_id';
        $query .= ' LEFT JOIN catalogos AS RP ON incidencias.icd_Respaldo = RP.ctg_id';
        $query .= ' LEFT JOIN catalogos AS RF ON incidencias.icd_Refaccion = RF.ctg_id';
        $query .= ' LEFT JOIN users ON incidencias.user_id = users.id';

        $query .= ' WHERE UNIX_TIMESTAMP(DATE_FORMAT(incidencias.created_at, "%Y-%m-%d")) BETWEEN UNIX_TIMESTAMP("' . $startDate .'") AND UNIX_TIMESTAMP("' . $endDate . '")';

        $query .= " ORDER BY TipoCtrl, component";

        $reportData = DB::select($query);

        return json_encode($reportData);
    }

    /**
     * Funciones para quitar cararctees a cadena
     */

    public function changueEspecialCaracters($valueStr){

        $especialC = array("á", "é", "í", "ó", "ú", "ñ", "Á", "É", "Í", "Ó", "Ú", 'Ñ');
        $newEspecialC = array("a", "e", "i", "o", "u", "n", "A", "E", "I", "O", "U", "N");

        $replaceStr = str_replace($especialC, $newEspecialC, $valueStr);

        return $replaceStr;
     }
}
