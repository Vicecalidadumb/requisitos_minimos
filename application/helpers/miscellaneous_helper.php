<?php

function print_y($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function get_dropdown($array_objects, $value, $name) {
    $array_return = array();
    foreach ($array_objects as $array) {
        $array_return[$array->$value] = $array->$name;
    }
    return $array_return;
}

function get_dropdown_select($array_objects, $value, $name, $select_value, $select_name = 'Seleccionar...') {
    $array_return = array($select_value => $select_name);
    foreach ($array_objects as $array) {
        $array_return[$array->$value] = $array->$name;
    }
    return $array_return;
}

function encrypt_id($id) {
    return base64_encode(rand(111111, 999999) . $id . rand(11111, 99999));
}

function deencrypt_id($id) {
    $id = base64_decode($id);
    $id = substr($id, 6, strlen($id));
    $id = substr($id, 0, strlen($id) - 5);
    return $id;
}

function dias_transcurridos($fecha_i, $fecha_f) {
    $dias = (strtotime($fecha_i) - strtotime($fecha_f)) / 86400;
    $dias = abs($dias);
    $dias = floor($dias);
    return $dias;
}

function get_cut_day() {
    $CI = & get_instance();
    $CI->load->model('cut_model');

    $cuts = $CI->cut_model->get_all_cuts();
    $array_cuts = array();
    foreach ($cuts as $cut) {
        if ($cut->CORTE_DIAINICIO > $cut->CORTE_DIAFIN) {
            for ($a = $cut->CORTE_DIAINICIO; $a <= 31; $a++) {
                $array_cuts[$a] = $cut->CORTE_ID;
            }
            for ($a = 1; $a <= $cut->CORTE_DIAFIN; $a++) {
                $array_cuts[$a] = $cut->CORTE_ID;
            }
        } else {
            for ($a = $cut->CORTE_DIAINICIO; $a <= $cut->CORTE_DIAFIN; $a++) {
                $array_cuts[$a] = $cut->CORTE_ID;
            }
        }
    }
    return $array_cuts;
}

function get_cutday_id($id) {
    $CI = & get_instance();
    $CI->load->model('cut_model');
    $cuts = $CI->cut_model->get_cut_id($id);
    return $cuts[0]->CORTE_DIAPAGO;
}

function check_in_range($start_date, $end_date, $evaluame) {
    $start_ts = strtotime($start_date);
    $end_ts = strtotime($end_date);
    $user_ts = strtotime($evaluame);
    return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}

function getUltimoDiaMes($elAnio, $elMes) {
    return date("d", (mktime(0, 0, 0, $elMes + 1, 1, $elAnio) - 1));
}

function get_state_folder($id) {
    switch ($id) {
        case 1: return 'Proceso Aspirante';
            break;
        case 2: return 'No asignada';
            break;
        case 3: return 'Asignada Analista';
            break;
        case 4: return 'Proceso Analista';
            break;
        case 5: return 'Calificada';
            break;
        case 6: return 'Asignada Supervisor';
            break;
        case 7: return 'Proceso Supervisor';
            break;
        case 8: return 'Devuelta';
            break;
        case 9: return 'Cerrada';
            break;
        case 10: return 'Recalificar Analista';
            break;
        default: return '';
            break;
    }
}

function get_color_state_folder($state_name){
    switch ($state_name) {
        case 'Admitido': return '<span class="badge badge-success">'.$state_name.'</span>';
            break;
        case 'No Admitido': return '<span class="badge badge-danger">'.$state_name.'</span>';
            break;
        default: return '<span class="badge badge-default">'.$state_name.'</span>';
            break;
    }    
}

function state_folder() {
    return array(
        '' => '--Todos los Estados--',
        '1' => 'Proceso Aspirante',
        '2' => 'No asignada',
        '3' => 'Asignada Analista',
        '4' => 'Proceso Analista',
        '5' => 'Calificada',
        '6' => 'Asignada Supervisor',
        '7' => 'Proceso Supervisor',
        '8' => 'Devuelta',
        '9' => 'Cerrada',
        '10' => 'Recalificar Analista',
    );
}
function max_folio($id){
    $CI = & get_instance();
    $SQL="select (Maximo+1) consecutivo 
  from VW_FOLIO_MAYOR
  where id=".$id;
    $datos=$CI->db->query($SQL);
    $datos=$datos->result();
    return $datos[0]->consecutivo;
}
