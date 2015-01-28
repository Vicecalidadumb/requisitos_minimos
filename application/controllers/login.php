<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('security');
        $this->load->helper('miscellaneous');
        //$this->load->library('My_PHPMailer');
    }

    public function index() {
        //FUNCION PRINCIPAL PARA EL LOGIN - CARGA LA VISTA LOGIN/INDEX.PHP
        if ($this->session->userdata('logged_in')) {
            redirect('index.php/aspirantes', 'refresh');
        } else {
            $this->load->view('login/index');
        }
    }

    public function make_hash($var = 1) {
        //FUNCION PARA GENERAR NUEVAS CONTRASE�AS
        echo make_hash($var);
    }

    public function verify() {
        //RECOLECTAMOS LOS DATOS DE LOS CAMPOS DE USUARIO Y CONTRASE�A
        $username = $this->input->post('username');
        $pass = $this->input->post('password');
        $username = intval($username);
        $pass = intval($pass);
        

        //CONSULTAMOS EL USUARIO CON BASE EN EL NUMERO DE DOCUMENTO
        $user = $this->user_model->get_user($username, $pass);

        //VERIFICAMOS SI EL USUARIO EXISTE
        if (sizeof($user) > 0) {
            //PREPARAMOS LAS VARIABLES QUE VAMOS A GUARDAR EN SESSION
            $newdata = array(
                'USUARIO_ID' => $user[0]->idusuario_usu,
                'USUARIO_NOMBRES' => $user[0]->nombre_usu,
                'USUARIO_APELLIDOS' => '',
                'USUARIO_TIPODOCUMENTO' => 'CC',
                'USUARIO_NUMERODOCUMENTO' => $user[0]->documento_usu,
                'USUARIO_CORREO' => '',
                'USUARIO_GENERO' => '',
                'USUARIO_FECHADENACIMIENTO' => '',
                'USUARIO_DIRECCIONRESIDENCIA' => '',
                'USUARIO_TELEFONOFIJO' => '',
                'USUARIO_CELULAR' => '',
                'USUARIO_ESTADO' => $user[0]->estado_usu,
                'USUARIO_FECHAINGRESO' => '',
                'ID_TIPO_USU' => $user[0]->idrol_usu,
                'rol_permissions' => '',
                'logged_in' => TRUE,
            );
            $this->session->set_userdata($newdata);

            redirect('index.php/aspirantes', 'location');
        } else {
            $this->session->set_flashdata(array('message' => 'Su n&uacute;mero de documento no se encuentra registrado en el sistema.', 'message_type' => 'warning'));
            redirect('', 'refresh');
        }
    }

    public function logout() {
        $this->session->set_userdata('logged_in', FALSE);
        $this->session->sess_destroy();
        //$this->load->view('login/index');
        redirect('index.php/login', 'location');
    }

}
