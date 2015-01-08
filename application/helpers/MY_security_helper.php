<?php

function validate_login($logged_in) {
    $CI = & get_instance();
    if ($logged_in == FALSE) {
        $CI->session->set_flashdata(array('message' => '<strong>Error</strong> Debe Iniciar una Sesion.', 'message_type' => 'danger'));
        redirect('', 'refresh');
    }
}
