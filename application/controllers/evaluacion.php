<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evaluacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('evaluacion_model');
        $this->load->helper('security');
        $this->load->helper('miscellaneous');
        validate_login($this->session->userdata('logged_in'));
    }

    public function index() {
        //FUNCION PRINCIPAL PARA EL LOGIN - CARGA LA VISTA LOGIN/INDEX.PHP           
        $data['title'] = '';
        $data['get']=  $this->input->get();
        if($data['get']['id']){
        $data['get']['id']=deencrypt_id($data['get']['id']);
        $data['datos']= $this->evaluacion_model->datos_personales($data['get']['id']);
        if(empty($data['datos'])){
            redirect('index.php/login', 'location');
        }
        $data['documentos']= $this->evaluacion_model->documentos($data['get']['id']);
        $data['educacion_formal']= $this->evaluacion_model->educacion_formal($data['get']['id']);
        $data['content'] = 'evaluacion/educacion_formal';
        $this->load->view('template/template', $data);
//        $this->load->view('evaluacion/educacion_formal', $data);
        }else{
            redirect('index.php/login', 'location');
        }
    }

    public function calificar_modalidad() {
        $data['post'] = $this->input->post();
        $this->load->view('evaluacion/calificar_modalidad', $data);
    }
    public function consultar_opec() {
        $data['post'] = $this->input->post();
        $data['datos']= $this->evaluacion_model->datos_personales($data['post']['id']);
        $this->load->view('evaluacion/consultar_opec', $data);
    }

}
