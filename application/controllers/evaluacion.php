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
        $data['get'] = $this->input->get();
        if ($data['get']['id']) {
            $data['get']['id'] = deencrypt_id($data['get']['id']);
            $data['datos'] = $this->evaluacion_model->datos_personales($data['get']['id']);
            if (empty($data['datos']))
                redirect('index.php/login', 'location');
            //DATOS USUARIO
            $datos['documentos'] = $this->evaluacion_model->documentos($data['get']['id']);
            $datos['educacion_formal'] = $this->evaluacion_model->educacion_formal($data['get']['id']);
            $datos['experiencia'] = $this->evaluacion_model->educacion_formal($data['get']['id']);
            //VISTAS DOCUMENTOS
            $data['doc_espeficifos'] = $this->load->view('evaluacion/documentos/especificos', $datos, true);
            $data['doc_educacion'] = $this->load->view('evaluacion/documentos/educacion', $datos, true);
            $data['doc_experiencia'] = $this->load->view('evaluacion/documentos/experiencia', $datos, true);
            $data['cumple'] = $this->load->view('evaluacion/documentos/cumple', $datos, true);
            //VISTA GENERAL
            $data['content'] = 'evaluacion/educacion_formal';
            $this->load->view('template/template', $data);
        } else {
            redirect('index.php/login', 'location');
        }
    }

    public function calificar_modalidad() {
        $data['post'] = $this->input->post();
        $data['modalidad'] = get_dropdown($this->evaluacion_model->modalidad(), 'IDMODALIDAD_MOD', 'MODALIDAD_MOD');
        $this->load->view('evaluacion/calificar_modalidad', $data);
    }

    public function universidad() {
        $data['post'] = $this->input->post('universidad');
        $dat = $this->evaluacion_model->universidad($data['post']);
        $valu = "<option value='0'>Seleccione</option>";
        foreach ($dat as $value) {
            $valu.="<option value='" . $value->IDUNIVERSIDAD_UNIV . "'>" . $value->UNIVERSIDAD_UNIV . "</option>";
        }
        echo $valu;
//        echo $data['universidad']= $this->evaluacion_model->universidad($data['post']);
    }

    public function titulo() {
        $data['post'] = $this->input->post('titulo');
        $dat = $this->evaluacion_model->titulo($data['post']);
        $valu = "<option value='0'>Seleccione</option>";
        foreach ($dat as $value) {
            $valu.="<option value='" . $value->IDTITULO_TIT . "'>" . $value->TITULO_TIT . "</option>";
        }
        echo $valu;
//        echo $data['universidad']= $this->evaluacion_model->universidad($data['post']);
    }

    public function consultar_opec() {
        $data['post'] = $this->input->post();
        $data['datos'] = $this->evaluacion_model->datos_personales($data['post']['id']);
        $this->load->view('evaluacion/consultar_opec', $data);
    }

}
