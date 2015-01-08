<?php

function recalculate_uploaded_documents() {
    $TIPO_DOCUMENTO_ID_1 = 0;
    $TIPO_DOCUMENTO_ID_2 = 0;
    $TIPO_DOCUMENTO_ID_3 = 0;
    $TIPO_DOCUMENTO_ID_4 = 0;
    $TIPO_DOCUMENTO_ID_TOTAL = 0;

    $CI = & get_instance();
    $CI->load->model('particles_model');
    $documents = $CI->particles_model->get_documents_user($CI->session->userdata("INSCRIPCION_PIN"));
    //echo '<pre>' . print_y($documents, true) . '</pre>';

    foreach ($documents as $document) {
        //echo $document->TIPO_DOCUMENTO_ID.'<br>';
        switch ($document->TIPO_DOCUMENTO_ID) {
            case 1:
                $TIPO_DOCUMENTO_ID_1++;
                $TIPO_DOCUMENTO_ID_TOTAL++;
                break;
            case 2:
                $TIPO_DOCUMENTO_ID_1++;
                $TIPO_DOCUMENTO_ID_TOTAL++;
                break;
            case 3:
                $TIPO_DOCUMENTO_ID_1++;
                $TIPO_DOCUMENTO_ID_TOTAL++;
                break;
            case 4:
                $TIPO_DOCUMENTO_ID_1++;
                $TIPO_DOCUMENTO_ID_TOTAL++;
                break;
        }
    }

    $CI->session->set_userdata('TIPO_DOCUMENTO_ID_1', $TIPO_DOCUMENTO_ID_1);
    $CI->session->set_userdata('TIPO_DOCUMENTO_ID_2', $TIPO_DOCUMENTO_ID_2);
    $CI->session->set_userdata('TIPO_DOCUMENTO_ID_3', $TIPO_DOCUMENTO_ID_3);
    $CI->session->set_userdata('TIPO_DOCUMENTO_ID_4', $TIPO_DOCUMENTO_ID_4);
    $CI->session->set_userdata('TIPO_DOCUMENTO_ID_TOTAL', $TIPO_DOCUMENTO_ID_TOTAL);
}

function print_y($array) {
    return '<pre>' . print_r($array, true) . '</pre>';
}

function get_array_states($type = 0) {
    if ($type == 0)
        $states = array(
            1 => 'Activo',
            0 => 'Inactivo',
        );
    elseif ($type == 1)
        $states = array(
            1 => 'SI',
            0 => 'NO',
        );
    return $states;
}

function get_tipos_documentos() {
    $data = array(
        'CC' => 'C&eacute;dula de Ciudadan&iacute;a',
        /* 'TI' => 'Tarjeta de Identidad',
          'RC' => 'Registro Civil', */
        'CE' => 'C&eacute;dula de Extranjer&iacute;a'
    );
    return $data;
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

function get_array_rubrics() {
    $array = array(
        'RESOLUTIVO' => 'RESOLUTIVO',
        'AUTONOMO' => 'AUTONOMO',
        'ESTRATEGICO' => 'ESTRATEGICO'
    );
    return $array;
}

function get_array_item_types() {
    $array = array(
        'SMUR' => 'SMUR'
    );
    return $array;
}

function get_array_difficulty_level() {
    $array = array(
        '1' => 'BAJO',
        '2' => 'MEDIO',
        '3' => 'ALTO'
    );
    return $array;
}

function get_difficulty_level($id) {
    switch ($id) {
        case 1:return "BAJO";
            break;
        case 2:return "MEDIO";
            break;
        case 3:return "ALTO";
            break;
    }
}

function get_array_number_questions() {
    $array = array(
        '' => '--Selecciona la Respuesta Correcta--',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4'
    );
    return $array;
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

function get_component_name($sigla) {
    $CI = & get_instance();
    $CI->load->model('component_model');
    $component = $CI->component_model->get_components_value($sigla);
    return $component[0]->COMPONENTE_NOMBRE;
}

function get_validation_id($id_user, $PREGUNTA_ID) {
    $CI = & get_instance();
    $CI->load->model('validation_model');
    $validation = $CI->validation_model->get_validation($PREGUNTA_ID, $id_user);
    if (count($validation) > 0) {
        return 1;
    } else {
        return 0;
    }
}

function get_modify_item($PREGUNTA_ID) {
    $CI = & get_instance();
    $CI->load->model('question_model');
    $validation = $CI->question_model->get_modify_item($PREGUNTA_ID, $CI->session->userdata("KEY_AES"));
    return $validation;
}

function get_modify_resp($RESPUESTA_ID) {
    $CI = & get_instance();
    $CI->load->model('question_model');
    $validation = $CI->question_model->get_modify_resp($RESPUESTA_ID, $CI->session->userdata("KEY_AES"));
    return $validation;
}

function get_niveldificultadname($value) {
    switch ($value) {
        case 1: return 'Bajo';
            break;
        case 2: return 'Medio';
            break;
        case 3: return 'Alto';
            break;
        default: return 'Nivel';
            break;
    }
}

function permits_validation() {
    $VPE = (know_permission_role('VPE', 'permission_add') == 1) ? 'PERTINENCIA, ' : '';
    $VCO = (know_permission_role('VCO', 'permission_add') == 1) ? 'COHERENCIA, ' : '';
    $VRE = (know_permission_role('VRE', 'permission_add') == 1) ? 'RELEVANCIA, ' : '';
    $VSI = (know_permission_role('VSI', 'permission_add') == 1) ? 'SINTÃ�CTICA, ' : '';
    $VSE = (know_permission_role('VSE', 'permission_add') == 1) ? 'SEMÃ�NTICA, ' : '';
    return $VPE . $VCO . $VRE . $VSI . $VSE;
}

function get_validation_type($id) {

    switch ($id) {
        case '1': return "PERTINENCIA";
            break;
        case '2': return "COHERENCIA";
            break;
        case '3': return "RELEVANCIA";
            break;
        case '4': return "SINTÃ�CTICA";
            break;
        case '5': return "SEMÃ�NTICA";
            break;
        default :return "N/A";
            break;
    }
}

function get_score() {
    $array_score = array('' => '-- SELECCIONA UN PUNTAJE --');
    for ($a = 0.0; $a <= 5.0; $a = $a + 0.1) {
        $array_score["$a"] = $a;
    }
    return $array_score;
}

function get_avg_validation($v1, $v2, $v3, $v4, $v5) {
    $result = 0;
    $eva = '';
    //return "$v1+$v2+$v3+$v4+$v5 - ".($v1+$v2+$v3+$v4+$v5);
    $result = round(($v1 + $v2 + $v3 + $v4 + $v5) / 5, 2);
    return $result;
}

function standard_deviation($aValues) {
    $fMean = array_sum($aValues) / count($aValues);
    //print_r($fMean);
    $fVariance = 0.0;
    foreach ($aValues as $i) {
        $fVariance += pow($i - $fMean, 2);
    }
    $size = count($aValues) - 1;
    return (float) sqrt($fVariance) / sqrt($size);
}

function average($arr) {
    if (!count($arr))
        return 0;
    $sum = 0;
    for ($i = 0; $i < count($arr); $i++) {
        $sum += $arr[$i];
    }
    return $sum / count($arr);
}

function variance($arr) {
    if (!count($arr))
        return 0;
    $mean = average($arr);
    $sos = 0;    // Sum of squares
    for ($i = 0; $i < count($arr); $i++) {
        $sos += ($arr[$i] - $mean) * ($arr[$i] - $mean);
    }
    return $sos / (count($arr) - 1);
}

function EXCEL_LETTER($var1) {
    switch ($var1) {
        case 1: return 'A';
        case 2: return 'B';
        case 3: return 'C';
        case 4: return 'D';
        case 5: return 'E';
        case 6: return 'F';
        case 7: return 'G';
        case 8: return 'H';
        case 9: return 'I';
        case 10: return 'J';
        case 11: return 'K';
        case 12: return 'L';
        case 13: return 'M';
        case 14: return 'N';
        case 15: return 'O';
        case 16: return 'P';
        case 17: return 'Q';
        case 18: return 'R';
        case 19: return 'S';
        case 20: return 'T';
        case 21: return 'U';
        case 22: return 'V';
        case 23: return 'W';
        case 24: return 'X';
        case 25: return 'Y';
        case 26: return 'Z';
        case 27: return 'AA';
        case 28: return 'AB';
        case 29: return 'AC';
        case 30: return 'AD';
        case 31: return 'AE';
        case 32: return 'AF';
        case 33: return 'AG';
        case 34: return 'AH';
        case 35: return 'AI';
        case 36: return 'AJ';
        case 37: return 'AK';
        case 38: return 'AL';
        case 39: return 'AM';
        case 40: return 'AN';
        case 41: return 'AO';
        case 42: return 'AP';
        case 43: return 'AQ';
        case 44: return 'AR';
        case 45: return 'AS';
        case 46: return 'AT';
        case 47: return 'AU';
        case 48: return 'AV';
        case 49: return 'AW';
        case 50: return 'AX';
        case 51: return 'AY';
        case 52: return 'AZ';
        case 53: return 'BA';
        case 54: return 'BB';
        case 55: return 'BC';
        case 56: return 'BD';
        case 57: return 'BE';
        case 58: return 'BF';
        case 59: return 'BG';
        case 60: return 'BH';
        case 61: return 'BI';
        case 62: return 'BJ';
        case 63: return 'BK';
        case 64: return 'BL';
        case 65: return 'BM';
        case 66: return 'BN';
        case 67: return 'BO';
        case 68: return 'BP';
        case 69: return 'BQ';
        case 70: return 'BR';
        case 71: return 'BS';
        case 72: return 'BT';
        case 73: return 'BU';
        case 74: return 'BV';
        case 75: return 'BW';
        case 76: return 'BX';
        case 77: return 'BY';
        case 78: return 'BZ';
        case 79: return 'CA';
        case 80: return 'CB';
        case 81: return 'CC';
        case 82: return 'CD';
        case 83: return 'CE';
        case 84: return 'CF';
        case 85: return 'CG';
        case 86: return 'CH';
        case 87: return 'CI';
        case 88: return 'CJ';
        case 89: return 'CK';
        case 90: return 'CL';
        case 91: return 'CM';
        case 92: return 'CN';
        case 93: return 'CO';
        case 94: return 'CP';
        case 95: return 'CQ';
        case 96: return 'CR';
        case 97: return 'CS';
        case 98: return 'CT';
        case 99: return 'CU';
        case 100: return 'CV';
        case 101: return 'CW';
        case 102: return 'CX';
        case 103: return 'CY';
        case 104: return 'CZ';
        case 105: return 'DA';
        case 106: return 'DB';
        case 107: return 'DC';
        case 108: return 'DD';
        case 109: return 'DE';
        case 110: return 'DF';
        case 111: return 'DG';
        case 112: return 'DH';
        case 113: return 'DI';
        case 114: return 'DJ';
        case 115: return 'DK';
        case 116: return 'DL';
        case 117: return 'DM';
        case 118: return 'DN';
        case 119: return 'DO';
        case 120: return 'DP';
        case 121: return 'DQ';
        case 122: return 'DR';
        case 123: return 'DS';
        case 124: return 'DT';
        case 125: return 'DU';
        case 126: return 'DV';
        case 127: return 'DW';
        case 128: return 'DX';
        case 129: return 'DY';
        case 130: return 'DZ';
    }
}

function send_mail($mails_destinations, $subject, $message, $path_attachment = array(), $mail_hostdime = 'correo@umb.edu.co') {
    $CI = & get_instance();
    $CI->load->library('My_PHPMailer');

    //$result = $sql_query->result();
//CUERPO DEL MENSAJE
    //$message = str_replace(array('[PARA]', '[MENSAJE]', '[EXTRA]'), $message, $result[0]->config_phpmailer_template);


    $response = '';
    foreach ($mails_destinations as $mail_destination => $name_destination) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        /* // establecemos que utilizaremos SMTP
          if ($result[0]->config_phpmailer_smtpauth == 1) {
          $mail->SMTPAuth = true;                                                                     // habilitamos la autenticaciÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³n SMTP
          } else {
          $mail->SMTPAuth = false;                                                                    // habilitamos la autenticaciÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³n SMTP
          } */
        $mail->SMTPAuth = true;
        $mail->Mailer = "smtp";
        //$mail->SMTPSecure = "{$result[0]->config_phpmailer_smtpsecure}";                              // establecemos el prefijo del protocolo seguro de comunicaciÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³n con el servidor
        $mail->SMTPSecure = "tls";                                                                      // establecemos el prefijo del protocolo seguro de comunicaciÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³n con el servidor
        $mail->Host = 'smtp.office365.com';                                                                      // establecemos GMail como nuestro servidor SMTP
        $mail->Port = '587';                                                                             // establecemos el puerto SMTP en el servidor de GMail
        $mail->Username = 'yeison.arias@umb.edu.co';                                                          // la cuenta de correo GMail
        $mail->Password = 'HErnandpar554';                                                            // password de la cuenta GMail
        $mail->SetFrom('yeison.arias@umb.edu.co', 'Universidad Manuela Beltran');                                            //Quien envÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­a el correo
        $mail->AddReplyTo($mail_destination, $name_destination);                                        //A quien debe ir dirigida la respuesta
        $mail->Subject = $subject;                                                                      //Asunto del mensaje
        $mail->Body = $message;
        $mail->AltBody = $message;

        //$mail->AddAttachment($path_attachment);
        if (count($path_attachment) > 0) {
            for ($a = 0; $a < count($path_attachment); $a++) {
                $mail->AddAttachment($path_attachment[$a]);
            }
        }

        $destino = $mail_destination;
        $mail->AddAddress($destino, $name_destination);
        if (!$mail->Send()) {
            $response.= 0;
        } else {
            $response.= 1;
        }
    }
    return $response;
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

function get_date_selectcut() {
    $return = array();

    $year1 = date("Y", strtotime(date("Y-m-d") . " -1 year"));
    $year2 = date("Y");
    $year3 = date("Y", strtotime(date("Y-m-d") . " +1 year"));

    for ($a = 1; $a <= 12; $a++) {
        $return[$year1 . '/' . $a] = $year1 . '/' . $a;
    }
    for ($a = 1; $a <= 12; $a++) {
        $return[$year2 . '/' . $a] = $year2 . '/' . $a;
    }
    for ($a = 1; $a <= 12; $a++) {
        $return[$year3 . '/' . $a] = $year3 . '/' . $a;
    }

    return $return;
}

function get_assess_option($option) {
    switch ($option) {
        case 1:
            return array(1 => 'Cumple', 0 => 'No Cumple', 2 => 'No Aplica');
            break;
        case 2:
            return array(1 => 'Cumple (10 Puntos)', 0 => 'No Cumple');
            break;
        case 4:
            return array(1 => 'Cumple (10 Puntos)', 0 => 'No Cumple');
            break;
        default:
            return array(1 => 'Cumple (10 Puntos)', 0 => 'No Cumple');
            break;
    }
}

function name_assess2_option($option, $id) {
    switch ($option) {
        case 2:
            return $id . '_evafor';
            break;
        case 3:
            return $id . '_evanofor';
            break;
        case 4:
            return $id . '_evaexp';
            break;
    }
}

function score_assess1_option($option, $id, $post) {
    switch ($option) {
        case 2:
            return ($post == 1) ? 10 : 0;
            break;
        case 4:
            return ($post == 1) ? 10 : 0;
            break;
        default:
            return 0;
            break;
    }
}

function score_assess2_option($option, $id, $post) {
    switch ($option) {
        case 2:
            $count = 0;
            if (is_array($post)) {
                foreach ($post as $value) {
                    switch ($value) {
                        case 1: $count+=6;
                            break;
                        case 2: $count+=7;
                            break;
                        case 3: $count+=8;
                            break;
                        case 4: $count+=2;
                            break;
                        case 5: $count+=3;
                            break;
                        case 6: $count+=4;
                            break;
                    }
                }
            }
            return $count;
            break;
        case 3:
            switch ($post) {
                case 1: return 10;
                    break;
                case 2: return 8;
                    break;
                case 3: return 7;
                    break;
                case 4: return 6;
                    break;
                case 5: return 4;
                    break;
                case 6: return 3;
                    break;
                case 7: return 2;
                    break;
                default: return 0;
                    break;
            }
            break;
        case 4:
            switch ($post) {
                case 1: return 30;
                    break;
                case 2: return 25;
                    break;
                case 3: return 20;
                    break;
                case 4: return 15;
                    break;
                case 5: return 12;
                    break;
                case 6: return 5;
                    break;
                default: return 0;
                    break;
            }
            break;
    }
}

function scorevalue_assess2_option($option, $id, $post) {
    switch ($option) {
        case 2:
            if (is_array($post)) {
                return implode('|', $post);
            } else {
                return '';
            }
            break;
        case 3:
            switch ($post) {
                case 1: return 1;
                    break;
                case 2: return 2;
                    break;
                case 3: return 3;
                    break;
                case 4: return 4;
                    break;
                case 5: return 5;
                    break;
                case 6: return 6;
                    break;
                case 7: return 7;
                    break;
                default: return '';
                    break;
            }
            break;
        case 4:
            switch ($post) {
                case 1: return 1;
                    break;
                case 2: return 2;
                    break;
                case 3: return 3;
                    break;
                case 4: return 4;
                    break;
                case 5: return 5;
                    break;
                case 6: return 6;
                    break;
                default: return '';
                    break;
            }
            break;
        default: return '';
            break;
    }
}

function get_assess2_option($option, $id, $value_1, $value_2) {
    $var = '';
    $array_value = explode('|', $value_2);
    //echo print_r($array_value,true);
    $checked1 = (in_array(1, $array_value)) ? 'checked' : '';
    $checked2 = (in_array(2, $array_value)) ? 'checked' : '';
    $checked3 = (in_array(3, $array_value)) ? 'checked' : '';
    $checked4 = (in_array(4, $array_value)) ? 'checked' : '';
    $checked5 = (in_array(5, $array_value)) ? 'checked' : '';
    $checked6 = (in_array(6, $array_value)) ? 'checked' : '';
    switch ($option) {
        case 2:
            $var.= '<div class="checkbox-list">
                        <div>
                            <span>
                                <input type="checkbox" name="' . $id . '_evafor[]" id="' . $id . '_evafor_1" value="1" ' . $checked1 . '>
                                <label for="' . $id . '_evafor_1" style="font-size: 10px !important;">
                                    (6 ptos.) ESPECIALIZACI&Oacute;N ADICIONAL RELACIONADA CON LAS FUNCIONES
                                </label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input type="checkbox" name="' . $id . '_evafor[]" id="' . $id . '_evafor_2" value="2" ' . $checked2 . '>
                                <label for="' . $id . '_evafor_2" style="font-size: 10px !important;">
                                    (7 ptos.) MAESTRIA RELACIONADA CON LAS FUNCIONES
                                </label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input type="checkbox" name="' . $id . '_evafor[]" id="' . $id . '_evafor_3" value="3" ' . $checked3 . '>
                                <label for="' . $id . '_evafor_3" style="font-size: 10px !important;">
                                    (8 ptos.) DOCTORADO RELACIONADO CON LAS FUNCIONES
                                </label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input type="checkbox" name="' . $id . '_evafor[]" id="' . $id . '_evafor_4" value="4" ' . $checked4 . '>
                                <label for="' . $id . '_evafor_4" style="font-size: 10px !important;">
                                    (2 ptos.) MAESTRIA RELACIONADA CON LA CARRERA
                                </label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input type="checkbox" name="' . $id . '_evafor[]" id="' . $id . '_evafor_5" value="5" ' . $checked5 . '>
                                <label for="' . $id . '_evafor_5" style="font-size: 10px !important;">
                                    (3 ptos.) ESPECIALIZACIÓN ADICIONAL RELACIONADA CON LA CARRERA
                                </label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input type="checkbox" name="' . $id . '_evafor[]" id="' . $id . '_evafor_6" value="6" ' . $checked6 . '>
                                <label for="' . $id . '_evafor_6" style="font-size: 10px !important;">
                                    (4 ptos.) DOCTORADO RELACIONADO CON LA CARRERA
                                </label>
                            </span>
                        </div>                        
                    </div>';
            return $var;
            break;
        case 3:
            $value = $value_2;
            $array_value = array(
                '' => '--Sin Puntaje Extra--',
                '1' => '(10 ptos.) 500 O MAS',
                '2' => '(8 ptos.) ENTRE 300 y 499',
                '3' => '(7 ptos.) ENTRE 100 y 299',
                '4' => '(6 ptos.) ENTRE 50 y 99',
                '5' => '(4 ptos.) ENTRE 9 y 49',
                '6' => '(3 ptos.) MENOS DE 8',
                '7' => '(2 ptos.) CURSOS EN LOS QUE LA ESPECIALIZACIÓN NO ESTABLEZCA INTENSIDAD HORARIA',
            );
            $var.= form_dropdown($id . '_evanofor', $array_value, $value, 'class="form-control" style="font-size: 11px !important;"');
            return $var;
            break;
        case 4:
            $value = $value_2;
            $array_value = array(
                '' => '--Sin Puntaje Extra--',
                '1' => '(30 ptos.) 10 a&ntilde;os o mas',
                '2' => '(25 ptos.) 5 a&ntilde;os mas que  lo exigido por el perfil',
                '3' => '(20 ptos.) 4 a&ntilde;os mas que  lo exigido por el perfil',
                '4' => '(15 ptos.) 3 a&ntilde;os mas que  lo exigido por el perfil',
                '5' => '(12 ptos.) 2 a&ntilde;os mas que  lo exigido por el perfil',
                '6' => '(5 ptos.)  1 a&ntilde;os mas que  lo exigido por el perfil',
            );
            $var.= form_dropdown($id . '_evaexp', $array_value, $value, 'class="form-control" style="font-size: 11px !important;"');
            return $var;
            break;
    }
}

function get_pin_select($pin, $link = 1) {
    $return = '';
    switch ($pin) {
        case '1163546': $return = '21';
            break;
        case '1163146': $return = '21';
            break;
        case '1166814': $return = '21';
            break;
        case '1159880': $return = '23';
            break;
        case '1160252': $return = '23';
            break;
        case '1160096': $return = '23';
            break;
        case '1161432': $return = '23';
            break;
        case '1162086': $return = '23';
            break;
        case '1165568': $return = '23';
            break;
        case '1165174': $return = '23';
            break;
        case '1160140': $return = '18';
            break;
        case '1160845': $return = '18';
            break;
        case '1167961': $return = '18';
            break;
        case '1161017': $return = '18';
            break;
        case '1163726': $return = '32';
            break;
        case '1164693': $return = '32';
            break;
        case '1164724': $return = '32';
            break;
        case '1167993': $return = '32';
            break;
        default: return '';
            break;
    }
    if ($link == 1) {
        return '<a target="_blank" href="http://convocatorias.umb.edu.co/ofertas/informacion/UMB2014' . $return . '">UMB2014' . $return . '</a>';
    } else {
        return $return;
    }
}

function get_reg_select($pin, $empleo) {
    $consulta = $pin . '_' . $empleo;
    $return = '';
    switch ($consulta) {
        case '1163546_21': $return = 'BOGOTA D.C';
            break;
        case '1163146_21': $return = 'ANTIOQUIA';
            break;
        case '1166814_21': $return = 'ATLANTICO';
            break;
        case '1159880_23': $return = 'HUILA';
            break;
        case '1160252_23': $return = 'CAQUETA';
            break;
        case '1160096_23': $return = 'CESAR';
            break;
        case '1161432_23': $return = 'CHOC&Oacute;';
            break;
        case '1162086_23': $return = 'HUILA';
            break;
        case '1165568_23': $return = 'OCA&Ntilde;A';
            break;
        case '1165174_23': $return = 'ARAUCA';
            break;
        case '1160140_18': $return = 'ATLANTICO';
            break;
        case '1160845_18': $return = 'ANTIOQUIA';
            break;
        case '1167961_18': $return = 'ATLANTICO';
            break;
        case '1161017_18': $return = 'VALLE DEL CAUCA';
            break;
        case '1163726_32': $return = 'META';
            break;
        case '1164693_32': $return = 'LA GUAJIRA';
            break;
        case '1164724_32': $return = 'URABA';
            break;
        case '1167993_32': $return = 'META';
            break;
        default: return '';
            break;
    }
    return $return;
}

function get_puesto_select($pin, $empleo) {
    $consulta = $pin . '_' . $empleo;
    $return = '';
    switch ($consulta) {
        case '1160140_18': $return = '4';
            break;
        case '1161017_18': $return = '3';
            break;
        case '1167961_18': $return = '2';
            break;
        case '1160845_18': $return = '1';
            break;
        case '1166814_21': $return = '3';
            break;
        case '1163146_21': $return = '2';
            break;
        case '1163546_21': $return = '1';
            break;
        case '1165174_23': $return = '7';
            break;
        case '1161432_23': $return = '6';
            break;
        case '1159880_23': $return = '5';
            break;
        case '1160252_23': $return = '4';
            break;
        case '1162086_23': $return = '3';
            break;
        case '1160096_23': $return = '2';
            break;
        case '1165568_23': $return = '1';
            break;
        case '1164724_32': $return = '4';
            break;
        case '1167993_32': $return = '3';
            break;
        case '1163726_32': $return = '2';
            break;
        case '1164693_32': $return = '1';
            break;
    }
    return $return;
}

function get_select() {
    return 18;
}
