<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile_model extends CI_Model {

    public function get_all_applicants($state = 1) {
        $Where = '';
        if ($state != 'ALL') {
            $Where = "AND USUARIO_ESTADO=$state";
        }
        $SQL_string = "SELECT *
                      FROM {$this->db->dbprefix('usuarios')}
                      WHERE 1=1 $Where
                      ORDER BY USUARIO_NOMBRES";
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();
    }
    
    public function get_users($USUARIO_ID) {
        $Where = '';
        if ($USUARIO_ID != 'ALL') {
            $Where = "AND a.USUARIO_ID=$USUARIO_ID";
        }
        $SQL_string = "SELECT *
                      FROM {$this->db->dbprefix('usuarios')} u,
                      {$this->db->dbprefix('inscripcion_pin')} i,
                      {$this->db->dbprefix('asignacion_per')} a
                      WHERE 
                      i.USUARIO_NUMERODOCUMENTO = u.USUARIO_NUMERODOCUMENTO
                      AND a.INSCRIPCION_PIN = i.INSCRIPCION_PIN
                      $Where
                      ORDER BY u.USUARIO_NOMBRES";
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();
    }    

    public function get_applicantsdocuments_iduser($statedocument, $USUARIO_ID, $INSCRIPCION_PIN) {
        $Where = '';
        if ($statedocument != 'ALL') {
            $Where = "AND u.USUARIO_ESTADO=$statedocument AND d.DOCUMENTO_ESTADO=$statedocument ";
        }
        $SQL_string = "SELECT u.*,i.*,a.*,d.*,m.*
                        FROM 
                            {$this->db->dbprefix('usuarios')} u, 
                            {$this->db->dbprefix('inscripcion_pin')} i, 
                            {$this->db->dbprefix('asignacion_per')} a, 
                            {$this->db->dbprefix('usuarios_sistema')} us,
                            {$this->db->dbprefix('documento')} d,
                            {$this->db->dbprefix('departamentos')} de,
                            {$this->db->dbprefix('municipios')} m
                        WHERE
                        i.USUARIO_NUMERODOCUMENTO = u.USUARIO_NUMERODOCUMENTO
                        AND a.USUARIO_ID = us.USUARIO_ID 
                        AND a.INSCRIPCION_PIN = i.INSCRIPCION_PIN
                        AND d.INSCRIPCION_PIN = i.INSCRIPCION_PIN
                        AND de.DEPARTAMENTO_ID = m.DEPARTAMENTO_ID 
                        AND CONCAT(de.DEPARTAMENTO_ID,m.MUNICIPIO_ID)= u.USUARIO_LUGARDERESIDENCIA
                        AND us.USUARIO_ID = $USUARIO_ID
                        AND i.INSCRIPCION_PIN = $INSCRIPCION_PIN";
        //echo $SQL_string;
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();
    }

    public function get_document_user($INSCRIPCION_PIN, $DOCUMENTO_ID) {
        $SQL_string = "SELECT *
                      FROM {$this->db->dbprefix('documento')}
                      WHERE INSCRIPCION_PIN = '{$INSCRIPCION_PIN}' AND DOCUMENTO_ID = '{$DOCUMENTO_ID}'";
        //echo $SQL_string;
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();
    }

    public function get_modalities() {
        $SQL_string = "SELECT *
                      FROM {$this->db->dbprefix('modalidades')}";
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();
    }
    
    public function get_score($ASIGNACION_ID){
        $SQL_string = "SELECT *
                      FROM {$this->db->dbprefix('evaluacion')} e, {$this->db->dbprefix('tipo_evaluacion')} t
                      WHERE t.TIPOEVALUACION_ID = e.TIPOEVALUACION_ID AND ASIGNACION_ID = '{$ASIGNACION_ID}' AND e.EVALUACION_ESTADO=1";
        //echo $SQL_string;
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();
    }

    public function get_user_offers($INSCRIPCION_PIN) {
        $SQL_string = "SELECT o.*,r.*, GROUP_CONCAT(r.REGIONAL_NOMBRE SEPARATOR '-') REGIONES_
                      FROM {$this->db->dbprefix('oferta_ins')} o, {$this->db->dbprefix('regional')} r "
                    . "WHERE r.REGIONAL_ID = o.REGIONAL_ID AND INSCRIPCION_PIN = '$INSCRIPCION_PIN' AND o.ESTADO=1 "
                    . " GROUP BY o.EMPLEO_ID";
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();
    }

    public function get_offer_id($EMPLEO_ID) {
        $sql_string = "SELECT e.*,a.*,"
                . "( "
                . "SELECT GROUP_CONCAT(p.PERFIL_NOMBRE SEPARATOR ',') "
                . "FROM {$this->db->dbprefix('perfil')} p WHERE e.EMPLEO_ID = p.PERFIL_EMPLEO_ID "
                . ") PERFIL, "
                . "( "
                . "SELECT GROUP_CONCAT(r.REGIONAL_NOMBRE SEPARATOR '-') "
                . "FROM {$this->db->dbprefix('regional')} r,{$this->db->dbprefix('empleo_dep')} ed "
                . " WHERE r.REGIONAL_ID = ed.ID_REGIONAL AND ed.ID_EMPLEO = e.EMPLEO_ID "
                . ") REGIONES, "
                . "( "
                . "SELECT GROUP_CONCAT(CONCAT(r.REGIONAL_ID,',',r.REGIONAL_NOMBRE) SEPARATOR '-') "
                . "FROM {$this->db->dbprefix('regional')} r,{$this->db->dbprefix('empleo_dep')} ed "
                . " WHERE r.REGIONAL_ID = ed.ID_REGIONAL AND ed.ID_EMPLEO = e.EMPLEO_ID "
                . ") REGIONES_ID "
                . " FROM {$this->db->dbprefix('empleo')} e,"
                . "{$this->db->dbprefix('actividad')} a"
                . " WHERE e.EMPLEO_ESTADO=1 AND e.EMPLEO_ID = a.ACTIVIDAD_EMPLEO_ID"
                . " AND e.EMPLEO_ID = $EMPLEO_ID";
        //echo $SQL_string;
        $SQL_string_query = $this->db->query($sql_string);
        return $SQL_string_query->result();
    }
    
    public function get_assess(){
        $SQL_string = "SELECT *
                      FROM {$this->db->dbprefix('tipo_evaluacion')}";
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();        
    }

    public function get_table() {
        //CAMPOS
        $aColumns = array(
            'USUARIO_ID',
            'USUARIO_NOMBRES',
            'USUARIO_APELLIDOS',
            'USUARIO_NUMERODOCUMENTO',
            'INSCRIPCION_PIN',
            'USUARIO_FECHAINGRESO',
            'USUARIO_ESTADO',
            'IP',
            'USUARIO_LUGARDERESIDENCIA'
        );
        //LLAVE PRIMARIA
        $sIndexColumn = "USUARIO_ID";
        //TABLA
        $sTable = "cargue_usuarios";
        $rWhere = "";

        $aColumns2 = array();
        foreach ($aColumns as $aColumn) {
            $aColumns2[] = ($aColumn == 'INSCRIPCION_PIN') ? 'cargue_inscripcion_pin.' . $aColumn : 'cargue_usuarios.' . $aColumn;
        }

        //CONTRADOR DE PAGINACION
        $sLimit = "";
        if (isset($_GET['start']) && $_GET['length'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['start']) . ", " .
                    intval($_GET['length']);
        }

        //ORDENAR
        $sOrder = "";
        if (isset($_GET['order'])) {
            $sOrder = "ORDER BY  ";
            $sOrder .= $aColumns2[$_GET['order'][0]['column']] . "
                    " . ($_GET['order'][0]['dir'] === 'asc' ? 'asc' : 'desc') . ", ";
            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }

        //FILTRO
        $sWhere = '';
        if (isset($_GET['search']['value']) && $_GET['search']['value'] != "") {
            $data = $_GET['search']['value'];
            $sWhere = " AND (";
            for ($i = 0; $i < count($aColumns2); $i++) {
                $sWhere .= $aColumns2[$i] . " LIKE '" . '%' . mysql_real_escape_string($data) . '%' . "' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

        //CONSULTA DE REGISTROS
        $sQuery = " SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns2)) . "
                    ,
                    (
                    SELECT GROUP_CONCAT(DISTINCT  o.EMPLEO_ID SEPARATOR '-')
                    FROM {$this->db->dbprefix('oferta_ins')} o, {$this->db->dbprefix('regional')} r
                    WHERE r.REGIONAL_ID = o.REGIONAL_ID AND o.INSCRIPCION_PIN = cargue_inscripcion_pin.INSCRIPCION_PIN AND o.ESTADO=1
                    ) OFERTAS, 
                    (
                    SELECT COUNT(e.EMPLEO_ID)
                    FROM {$this->db->dbprefix('evaluacion')} e
                    WHERE e.ASIGNACION_ID = cargue_asignacion_per.ASIGNACION_ID
                    AND e.EVALUACION_ESTADO=1
                    ) EVALUACION,
                    ASIGNACION_ID,
                    (
                    SELECT MUNICIPIO_NOMBRE
                    FROM {$this->db->dbprefix('municipios')} m
                    WHERE CONCAT(m.DEPARTAMENTO_ID,MUNICIPIO_ID) = cargue_usuarios.USUARIO_LUGARDERESIDENCIA LIMIT 1
                    ) CIUDAD
                    FROM  $sTable , cargue_inscripcion_pin, cargue_asignacion_per, cargue_usuarios_sistema
                    WHERE
                    cargue_asignacion_per.ASIGNACION_ESTADO=1
                    AND cargue_inscripcion_pin.USUARIO_NUMERODOCUMENTO = cargue_usuarios.USUARIO_NUMERODOCUMENTO
                    AND cargue_asignacion_per.USUARIO_ID = cargue_usuarios_sistema.USUARIO_ID 
                    AND cargue_asignacion_per.INSCRIPCION_PIN = cargue_inscripcion_pin.INSCRIPCION_PIN
                    AND cargue_usuarios_sistema.USUARIO_ID = " . $this->session->userdata('USUARIO_ID') . "
                    $rWhere
                    $sWhere
                    $sOrder 
                    $sLimit
                    ";
        $sQueryprueba = $sQuery;
        //echo $sQuery;
        //mail("yeison@tellocor.com",'consulta',$sQuery);
        $rResult = $this->db->query($sQuery);

        //CONSULTA DE GRAN TOTAL
        $sQuery = "SELECT FOUND_ROWS() AS total";

        $rResultFilterTotal = $this->db->query($sQuery);
        $aResultFilterTotal = $rResultFilterTotal->result();
        $iFilteredTotal = $aResultFilterTotal[0]->total;

        //CONSULTA TOTAL DE REGISTROS (SIN FILTRO)
        $sQuery = " SELECT COUNT(" . $sIndexColumn . ") AS total FROM   $sTable ";
        $rResultTotal = $this->db->query($sQuery);
        $aResultTotal = $rResultTotal->result();
        $iTotal = $aResultTotal[0]->total;

        //GENERAR ARRAY DE RESPUESTA
        $output = array(
            "sEcho" => 0,
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        $fetch_array = $rResult->result_array();

        $contador = 1;
        foreach ($fetch_array as $aRow) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == "USUARIO_ID") {
                    $row[] = $contador;
                } elseif ($aColumns[$i] == "IP") {
                    $row[] = ($aRow['EVALUACION']>0)?'<spam class="label label-success">SI</spam>':'<spam class="label label-default">NO</spam>';
                    $row[] = '<a href="' . base_url('index.php/profile/assess/' . $aRow[$aColumns[4]].'/'.$aRow['ASIGNACION_ID']) . '" class="btn default btn-xs blue-stripe">Evaluar</a>';
                } elseif ($aColumns[$i] == "USUARIO_APELLIDOS") {
                    $row[] = $aRow['CIUDAD'];
                } elseif ($aColumns[$i] == "USUARIO_ESTADO") {
                    $row[] = ($aRow['OFERTAS']>0)?'<spam class="label label-success">'.$aRow['OFERTAS'].'</spam>':'<spam class="label label-default">NO</spam>';
                }elseif ($aColumns[$i] == "movement_state_confirmation") {
                    switch ($aRow[$aColumns[$i]]) {
                        case 0: $row[] = '<center><div class="icon-thumbs-down" style="color: rgb(214, 56, 56);cursor: pointer;" title="Sin Confirmar"></div></center>';
                            break;
                        case 1:
                            $invoices = explode(',', $aRow[$aColumns[12]]);
                            $text_invoices = '';
                            for ($a = 0; $a < count($invoices); $a++) {
                                if ($invoices[$a] != '')
                                    $text_invoices.='<span class="label" style="padding: 0px 2px 0 2px;margin-bottom: 3px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;">' . $invoices[$a] . '</span><br>';
                            }
                            $row[] = '<div style="text-align: center;"><div class="icon-thumbs-up" style="color: rgb(16, 168, 22); cursor: pointer;" title="Confirmado"></div>' . $text_invoices . '</div>';
                            break;
                        case 3:
                            $payment_id = '<span class="label icon-attachment" style="padding: 0px 2px 0 2px;margin-bottom: 3px;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;">' . $aRow[$aColumns[14]] . '</span><br>';
                            $row[] = '<div style="text-align: center;"><div class="icon-thumbs-up" style="color: rgb(16, 168, 22); cursor: pointer;" title="Adjunto al Pago "></div>' . $payment_id . '</div>';
                            break;
                    }
                } elseif ($aColumns[$i] != ' ') {
                    /* General output */
                    //$row[] = print_r($this->input->get());
                    //$row[] = $sQueryprueba;
                    $row[] = $aRow[$aColumns[$i]];
                }
            }
            $output['aaData'][] = $row;
            $contador++;
        }

        return json_encode($output);
    }
    
    public function insert_assess($data) {
        $this->db->query("UPDATE {$this->db->dbprefix('evaluacion')} "
                . "SET EVALUACION_ESTADO=0 "
                . "WHERE "
                . "ASIGNACION_ID='{$data['ASIGNACION_ID']}'"
                . "AND EMPLEO_ID='{$data['EMPLEO_ID']}' AND EVALUACION_FECHA!='{$data['EVALUACION_FECHA']}' ");
        
        $SQL_string = "INSERT INTO {$this->db->dbprefix('evaluacion')}
                      (
                        TIPOEVALUACION_ID,
                        ASIGNACION_ID,
                        EMPLEO_ID,
                        EVALUACION_CUMPLE,
                        EVALUACION_PUNTAJE,
                        EVALUACION_PVALOR,
                        EVALUACION_OBSERVACION,
                        CUMPLE_PUNTAJE,
                        EVALUACION_FECHA
                       )
                      VALUES
                       (
                        '{$data['TIPOEVALUACION_ID']}',
                        '{$data['ASIGNACION_ID']}',
                        '{$data['EMPLEO_ID']}',
                        '{$data['EVALUACION_CUMPLE']}',
                        '{$data['EVALUACION_PUNTAJE']}',
                        '{$data['EVALUACION_PVALOR']}',
                        '{$data['EVALUACION_OBSERVACION']}',
                        '{$data['CUMPLE_PUNTAJE']}',
                        '{$data['EVALUACION_FECHA']}'    
                       )
                       ";
        return $this->db->query($SQL_string);
    }    
    
    

    /*     * ************************************************************************ */

    public function get_user_documento($username) {
        $sql_string = "SELECT *
                      FROM {$this->db->dbprefix('usuarios_sistema')}
                      WHERE HV_NUMERODOCUMENTO = '{$username}'
                      AND HV_ESTADO=1";

        $sql_query = $this->db->query($sql_string);
        return $sql_query->result();
    }

    public function get_professions() {
        $sql_string = "SELECT *
                      FROM {$this->db->dbprefix('profesiones')}";

        $sql_query = $this->db->query($sql_string);
        return $sql_query->result();
    }

    public function get_cv_id_cv($id_cv) {
        $SQL_string = "SELECT *
                      FROM {$this->db->dbprefix('hojasdevida')} h, {$this->db->dbprefix('municipios')} m
                      WHERE HV_ID = $id_cv AND CONCAT(m.DEPARTAMENTO_ID,m.MUNICIPIO_ID) = h.HV_LUGARDERESIDENCIA";
        //echo $SQL_string;
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();
    }

    public function get_cvdocuments_id_cv($id_cv) {
        $SQL_string = "SELECT *
                      FROM {$this->db->dbprefix('hojasdevida')} h, "
                . "{$this->db->dbprefix('municipios')} m, "
                . "{$this->db->dbprefix('documento_hv')} d, "
                . "{$this->db->dbprefix('tipo_documento')} t
                      WHERE h.HV_ID = $id_cv "
                . "AND CONCAT(m.DEPARTAMENTO_ID,m.MUNICIPIO_ID) = h.HV_LUGARDERESIDENCIA "
                . "AND d.HV_ID = h.HV_ID AND t.TIPODOCUMENTO_ID = d.TIPODOCUMENTO_ID";
        //echo $SQL_string;
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();
    }

    public function get_document_cv($id_document) {
        $SQL_string = "SELECT *
                      FROM {$this->db->dbprefix('hojasdevida')} h, "
                . "{$this->db->dbprefix('municipios')} m, "
                . "{$this->db->dbprefix('documento_hv')} d, "
                . "{$this->db->dbprefix('tipo_documento')} t
                      WHERE d.DOCUMENTOHV_ID = $id_document "
                . "AND CONCAT(m.DEPARTAMENTO_ID,m.MUNICIPIO_ID) = h.HV_LUGARDERESIDENCIA "
                . "AND d.HV_ID = h.HV_ID AND t.TIPODOCUMENTO_ID = d.TIPODOCUMENTO_ID";
        //echo $SQL_string;
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();
    }

    public function get_type_user() {
        $SQL_string = "SELECT *
                      FROM {$this->db->dbprefix('tipos_usuario')}
                      WHERE ACT_TIPO_USU = '1'";
        //echo $SQL_string;
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();
    }

    public function update_obser($data) {
        $SQL_string = "UPDATE {$this->db->dbprefix('asignacion_per')} SET
                       EVA_OBSERVACION = '{$data['EVA_OBSERVACION']}'
                       WHERE
                       ASIGNACION_ID = {$data['ASIGNACION_ID']}
                       ";
        //echo $SQL_string;
        $this->db->query($SQL_string);
    }

    public function update_user_password($user_password, $id_user) {
        $SQL_string = "UPDATE {$this->db->dbprefix('usuarios_sistema')} SET
                       HV_PASSWORD = '{$user_password}'
                       WHERE
                       HV_ID = $id_user
                       ";
        return $SQL_string_query = $this->db->query($SQL_string);
    }

    public function get_typedocuments() {
        $SQL_string = "SELECT *
                      FROM {$this->db->dbprefix('tipo_documento')}";
        //echo $SQL_string;
        $SQL_string_query = $this->db->query($SQL_string);
        return $SQL_string_query->result();
    }

    public function insert_document($data) {
        $SQL_string = "INSERT INTO {$this->db->dbprefix('documento_hv')}
                      (
                        HV_ID,
                        TIPODOCUMENTO_ID,
                        DOCUMENTOHV_OBSERVACION,
                        DOCUMENTOHV_IDCREADOR,
                        DOCUMENTOHV_NOMBRE
                       )
                      VALUES
                       (
                        '{$data['HV_ID']}',
                        '{$data['TIPODOCUMENTO_ID']}',
                        '{$data['DOCUMENTOHV_OBSERVACION']}',
                        '{$data['DOCUMENTOHV_IDCREADOR']}',
                        '{$data['DOCUMENTOHV_NOMBRE']}'
                       )
                       ";
        return $this->db->query($SQL_string);
    }

}
