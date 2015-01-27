<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aspirantes_model extends CI_Model {

    function prueba() {
        $query = $this->db->select('*');
        $query = $this->db->get('RMAA_USUARIO');
        return $query->result();
    }

    public function get_aspirantes2($GET) {
        return json_encode('okokokko');
    }

    public function get_aspirantes($GET,$userdata) {
        /* Campo Indice */
        $sIndexColumn = "IDINSCRIPCION_INS";

        /* DB tabla */
        if ($userdata['ID_TIPO_USU'] == 6) {
            $sTable2 = "VW_CARPETA_ANALISTA ";
            $join = "join RMAA_ASIGNACION on RMAA_ASIGNACION.idinscripcion_asg=VW_CARPETA_ANALISTA.IDINSCRIPCION_INS AND RMAA_ASIGNACION.idestadocar_asg IN (3,8)";
        } else if ($userdata['ID_TIPO_USU'] == 9) {
            $sTable2 = "VW_CARPETA_SUPERVISOR_RM ";
            $join = "join RMAA_ASIGNACION on RMAA_ASIGNACION.idinscripcion_asg=VW_CARPETA_SUPERVISOR_RM.IDINSCRIPCION_INS AND RMAA_ASIGNACION.idestadocar_asg IN (6)";
        }
        $sTable = $sTable2;//. $join;
        /*
         * Columnas
         */
        $aColumns = array('IDINSCRIPCION_INS', $sTable2.'.idestadocar_asg', 'DOCUMENTO_PER', 'PIN', 'NOMBRE_INS', 'APELLIDO_INS');
        /*         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP server-side, there is
         * no need to edit below this line
         */

        /*
         * ODBC connection
         */
        //$connectionInfo = array("UID" => $gaSql['user'], "PWD" => $gaSql['password'], "Database" => $gaSql['db'], "ReturnDatesAsStrings" => true);
        //$gaSql['link'] = sqlsrv_connect($gaSql['server'], $connectionInfo);
        //$params = array();
        //$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);


        /* Ordenar */
        $sOrder = "";
        if (isset($GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($GET['iSortingCols']); $i++) {
                if ($GET['bSortable_' . intval($GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[intval($GET['iSortCol_' . $i])] . "
                    " . addslashes($GET['sSortDir_' . $i]) . ", ";
                }
            }
            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }

        /* INICIO Filtrar */
        $sWhere = "";
        //if (isset($GET['sSearch']) && $GET['sSearch'] != "") {
        //$sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($GET['bSearchable2_' . $i]) && $GET['bSearchable2_' . $i] != "") {
                $sWhere .= $aColumns[$i] . " LIKE '%" . addslashes($GET['bSearchable2_' . $i]) . "%' AND ";
            }
        }
        $sWhere = substr_replace($sWhere, "", -4);
        //$sWhere .= ')';
        //}
        $sWhere = ($sWhere != "") ? 'WHERE ( ' . $sWhere . ' )' : '';
        /* FIN Filtrar */


        /* INICIO Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($GET['bSearchable_' . $i]) && $GET['bSearchable_' . $i] == "true" && $GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= $aColumns[$i] . " LIKE '%" . addslashes($GET['sSearch_' . $i]) . "%' ";
            }
        }
        /* FIN Individual column filtering */

        /* AGREGAR ID DEL USUARIO ACTUAL */
        if ($userdata['ID_TIPO_USU'] == 6)
        $sWhere .= ($sWhere == "") ? 'WHERE  VW_CARPETA_ANALISTA.idestadocar_asg<> 5 AND idusuario_usu = ' . $this->session->userdata('USUARIO_ID') : ' AND  idusuario_usu = ' . $this->session->userdata('USUARIO_ID');


        /* VARIABLES PARA PAGINAR */
        $top = (isset($GET['iDisplayStart'])) ? ((int) $GET['iDisplayStart']) : 0;
        $limit = (isset($GET['iDisplayLength'])) ? ((int) $GET['iDisplayLength'] ) : 10;


        /* Campo extra para estado de RM */
        $campo_e = ",(SELECT DISTINCT 
                    RM.estadoReqEstudio_Req + ', ' + 
                    RM.estadoReqExperiencia_Req
                    FROM REQ_MINIMOS RM
                    WHERE IDINSCRIPCION_INS = RM.idInscripcion_Req
                    ) EVALUA ";


        $uno = (str_replace(" ", "", $sOrder));
        $uno = (str_replace("\r", "", $uno));
        $uno = (str_replace("\n", "", $uno));

        if ($uno == 'ORDERBYIDINSCRIPCION_INSasc') {
            $uno = 'ORDER BY '.$sTable2.'.idasignacion_asg';
        } else {
            $uno = $sOrder;
        }

        $sQuery = "SELECT TOP $limit " . implode(",", $aColumns) . $campo_e . "
        FROM $sTable
        $sWhere " . (($sWhere == "") ? " WHERE " : " AND ") . " $sIndexColumn NOT IN
        (
            SELECT $sIndexColumn FROM
            (
                SELECT TOP $top " . implode(",", $aColumns) . "
                FROM $sTable
                $sWhere
                $uno
            )
            as [virtTable]
        )
        $uno";

        ////****CONSULTA DE REGISTROS
        //$rResult = sqlsrv_query($gaSql['link'], $sQuery) or die("$sQuery: " . sqlsrv_errors());
//        echo $sQuery;
        $rResult = $this->db->query($sQuery);


        ////****CONSULTA DE TOTAL DE REGISTROS TOTALES CON WHERE
        $sQueryCnt = "SELECT COUNT(*) iFilteredTotal FROM $sTable $sWhere";
        //$rResultCnt = sqlsrv_query($gaSql['link'], $sQueryCnt, $params, $options) or die(" $sQueryCnt: " . sqlsrv_errors());
        //echo $sQueryCnt;exit();
        $rResultCnt = $this->db->query($sQueryCnt);
        //$iFilteredTotal = sqlsrv_num_rows($rResultCnt);
        $iFilteredTotal_r = $rResultCnt->result();
        $iFilteredTotal = $iFilteredTotal_r[0]->iFilteredTotal;


        ////****CONSULTA DE REGISTROS TOTALES EN TABLA
        $sQuery = " SELECT COUNT(*) iTotal FROM $sTable WHERE idusuario_usu = " . $this->session->userdata('USUARIO_ID');
        //$rResultTotal = sqlsrv_query($gaSql['link'], $sQuery, $params, $options) or die(sqlsrv_errors());
        $rResultTotal = $this->db->query($sQuery);
        //$iTotal = sqlsrv_num_rows($rResultTotal);
        $iTotal_r = $rResultTotal->result();
        $iTotal = $iTotal_r[0]->iTotal;

        $output = array(
            "sEcho" => @intval($GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        //while ($aRow = sqlsrv_fetch_array($rResult)) {
        //while ($aRow = $rResult->result_array()) {
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            for ($i = 0; $i < count($aColumns) - 1; $i++) {
                $aColumns[$i] = str_replace($sTable2.'.', "", $aColumns[$i]);
                switch ($aColumns[$i]) {
                    case 'idestadocar_asg':
                        $v = $aRow[$aColumns[$i]];
                        $v = mb_check_encoding($v, 'UTF-8') ? $v : utf8_encode($v);
                        $row[] = get_state_folder($v);
                        break;
                    case 'NOMBRE_INS':
                        $v = $aRow[$aColumns[$i]] . ' ' . $aRow[$aColumns[5]];
                        $v = mb_check_encoding($v, 'UTF-8') ? $v : utf8_encode($v);
                        $row[] = $v;
                        break;
                    case $aColumns[$i] != ' ':
                        $v = $aRow[$aColumns[$i]];
                        $v = mb_check_encoding($v, 'UTF-8') ? $v : utf8_encode($v);
                        $row[] = $v;
                        break;
                }
            }
            $evalua = ($aRow['EVALUA'] != '') ? explode(',', $aRow['EVALUA']) : array('Sin Calificar', 'Sin Calificar');
            $row[] = get_color_state_folder(trim($evalua[0]));
            $row[] = get_color_state_folder(trim($evalua[1]));
            $row[] = '<a href="' . base_url('index.php/evaluacion?id=' . $aRow['PIN']) . '" class="btn btn-xs blue"><i class="fa fa-folder-open"></i> Ver</a>';
            if (!empty($row)) {
                $output['aaData'][] = $row;
            }
        }
        return json_encode($output);
    }

}
