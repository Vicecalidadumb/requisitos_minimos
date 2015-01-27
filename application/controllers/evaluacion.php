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
        $data['userdata'] = $this->session->userdata();
    }

    public function index() {
        $data['userdata'] = $this->session->userdata();
//        $infor['ID_TIPO_USU'];
        //FUNCION PRINCIPAL PARA EL LOGIN - CARGA LA VISTA LOGIN/INDEX.PHP           
        $data['title'] = 'Evaluación de Requisitos Minimos';
        $data['get'] = $this->input->get();
        if (isset($data['get']['id'])) {
            //$data['get']['id'] = deencrypt_id($data['get']['id']);
            $data['get']['id'] = $this->evaluacion_model->optener_id($data['get']['id']);

            if (!is_numeric($data['get']['id'])) {
                $this->session->set_flashdata(array('message' => 'Error al Consultar el Documento... ', 'message_type' => 'error'));
                redirect('index.php/aspirantes', 'location');
            }

            $data['datos'] = $this->evaluacion_model->datos_personales($data['get']['id']);
            if (empty($data['datos'])) {
                $this->session->set_flashdata(array('message' => 'Error al Consultar el Documento ', 'message_type' => 'error'));
                redirect('index.php/aspirantes', 'location');
            }
            //DATOS USUARIO
            $data['documentos'] = $this->evaluacion_model->documentos($data['get']['id']);
            $data['educacion_formal'] = $this->evaluacion_model->educacion_formal($data['get']['id']);
            $data['experiencia'] = $this->evaluacion_model->experiencia($data['get']['id']);
            $data['obtener_titulo'] = $this->evaluacion_model->requisitos_estudio($data['get']['id']);
            $data['educacion_no_formal'] = $this->evaluacion_model->educacion_para_el_trabajo($data['get']['id']);
            $data['RM'] = explode('||', $data['datos'][0]->REQUISITOS_MINIMOS);
            //VISTAS DOCUMENTOS
            $data['doc_espeficifos'] = $this->load->view('evaluacion/documentos/especificos', $data, true);
            $data['doc_educacion'] = $this->load->view('evaluacion/documentos/educacion', $data, true);
            $data['educacion_no_formal'] = $this->load->view('evaluacion/documentos/educacion_no_formal', $data, true);
            $data['doc_experiencia'] = $this->load->view('evaluacion/documentos/experiencia', $data, true);
            $data['cumple'] = $this->load->view('evaluacion/documentos/cumple', $data, true);
            $data['obtener_titulo'] = $this->load->view('evaluacion/documentos/obtener_titulo', $data, true);
            $data['obtener_experiencia'] = $this->load->view('evaluacion/documentos/obtener_experiencia', $data, true);
            //VISTA GENERAL
            $data['content'] = 'evaluacion/educacion_formal';
            $this->load->view('template/template', $data);
        } else {
            $this->session->set_flashdata(array('message' => 'Error al Consultar el Documento!', 'message_type' => 'error'));
            redirect('index.php/login', 'location');
        }
    }

    public function consultar_opec() {
        $data['post'] = $this->input->post();
        $data['datos'] = $this->evaluacion_model->datos_personales($data['post']['id']);
        $data['funciones'] = $this->evaluacion_model->datos_funciones($data['post']['idperfil']);
        $this->load->view('evaluacion/consultar_opec', $data);
    }

    public function calificar_modalidad() {
        $data['post'] = $this->input->post();
        $data['userdata'] = $this->session->userdata();
        $data['datos'] = $this->evaluacion_model->obtener_titulo($data['post']['idcal']);
        $data['modalidad'] = get_dropdown_select($this->evaluacion_model->modalidad(), 'IDMODALIDAD_MOD', 'MODALIDAD_MOD', '-1');
        $this->load->view('evaluacion/calificar_modalidad', $data);
    }

    public function universidad() {
        $data['post'] = $this->input->post('universidad');
        $dat = $this->evaluacion_model->universidad($data['post']);
        $valu = "<option value='-1'>Seleccione</option>";
        foreach ($dat as $value) {
            $valu.="<option value='" . $value->IDUNIVERSIDAD_UNIV . "'>" . $value->UNIVERSIDAD_UNIV . "</option>";
        }
        echo $valu;
//        echo $data['universidad']= $this->evaluacion_model->universidad($data['post']);
    }

    public function titulo() {
        $data['post'] = $this->input->post('titulo');
        $dat = $this->evaluacion_model->titulo($data['post']);
        $valu = "<option value='-1'>Seleccione</option>";
        foreach ($dat as $value) {
            $valu.="<option value='" . $value->IDTITULO_TIT . "'>" . $value->TITULO_TIT . "</option>";
        }
        $valu.= "<option value=''>OTRO</option>";
        echo $valu;
//        echo $data['universidad']= $this->evaluacion_model->universidad($data['post']);
    }

    function guardar_universidad() {
        $data['post'] = $this->input->post();
        if ($data['post']['idcal'] == "") {
            $this->evaluacion_model->guardar_universidad_new_folio($data['post']);
        } else {
            $this->evaluacion_model->guardar_universidad($data['post']);
        }
        $data['get']['id'] = $data['post']['id_glo'];
        $data['educacion_formal'] = $this->evaluacion_model->educacion_formal($data['post']['id_glo']);
        $data['obtener_titulo'] = $this->evaluacion_model->requisitos_estudio($data['post']['id_glo']);
        $educacion = $this->load->view('evaluacion/documentos/educacion', $data, true);
        $obtener_titulo = $this->load->view('evaluacion/documentos/obtener_titulo', $data, true);
        echo json_encode($data = array('dato1' => $educacion, 'dato2' => $obtener_titulo));
    }

    function nueva_universidad() {
        $data['post'] = $this->input->post();
        $this->evaluacion_model->nueva_universidad($data['post']);
        $this->universidad();
    }

    function nuevo_titulo() {
        $data['post'] = $this->input->post();
        $this->evaluacion_model->nuevo_titulo($data['post']);
        $this->titulo();
    }

    public function calificar_experiencia() {
        $data['post'] = $this->input->post();
        $data['userdata'] = $this->session->userdata();
        $data['tipoexperiencia'] = array(
            '8' => 'Certificacion Experiencia Laboral',
            '17' => 'Certificación Experiencia Relacionada',
            '19' => 'Certificación Experiencia Profesional',
        );
        $data['experiencia'] = $this->evaluacion_model->experiencia_idcalificacion($data['post']['idcal']);
        $this->load->view('evaluacion/calificar_experiencia', $data);
    }

    function guardar_experiencia() {
        $post = $this->input->post();
        $modificar = ($post['id'] == '') ? $this->evaluacion_model->agregar_experiencia($post) : $this->evaluacion_model->guardar_experiencia($post);
        $data['experiencia'] = $this->evaluacion_model->experiencia($post['id_glo']);
        $data['get']['id'] = $post['id_glo'];
        $doc_experiencia = $this->load->view('evaluacion/documentos/experiencia', $data, true);
        $obtener_experiencia = $this->load->view('evaluacion/documentos/obtener_experiencia', $data, true);
        echo json_encode(array('result' => $modificar, 'doc_experiencia' => $doc_experiencia, 'obtener_experiencia' => $obtener_experiencia));
    }

    function guardar_form_final() {
        $post = $this->input->post();
        $paso=$this->evaluacion_model->guardar_rm($post);
        echo $paso;
//        print_y($post);
    }

    function guardar_calificacion() {
        $post = $this->input->post();
        $id_glo = $this->input->post('id_glo');
        //en caso de que solo traiga uno
        $cantidad = $this->evaluacion_model->contar_calificaciones($id_glo);
        $userdata = $this->session->userdata();
        if ($cantidad == 1) {
            //
            $consultor = $this->evaluacion_model->buscar_consultor($id_glo);
            //crear
            $this->evaluacion_model->insert_calificaciones($id_glo, $consultor);
        } else {
            //actualizar
            $this->evaluacion_model->update_calificaciones($id_glo, $userdata, $post);
        }
    }

}
