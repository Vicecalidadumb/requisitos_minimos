<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aspirantes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('miscellaneous');
        $this->load->helper('security');
        $this->load->model('aspirantes_model');
        validate_login($this->session->userdata('logged_in'));
    }

    public function index() {
        $data['title'] = 'Listado de Aspirantes - Aplicativo de Requisitos Minimos';
        $data['content'] = 'aspirantes/index';
        $this->load->view('template/template', $data);
    }

    public function get_datatable() {
        if ($this->input->is_ajax_request()) {
            $data = $this->aspirantes_model->get_aspirantes($this->input->get());
            echo $data;
        } else {
            echo 'Acceso no utorizado';
        }
    }

}
