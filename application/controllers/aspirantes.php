<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aspirantes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('miscellaneous');
        $this->load->helper('security');
        validate_login($this->session->userdata('logged_in'));
    }

    public function index() {
        $data['title'] = 'Aplicativo de Requisitos Minimos';
        $data['content'] = 'aspirantes/index';
        $this->load->view('template/template', $data);
    }

}
