<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller {

    private $module_sigla;

    public function __construct() {
        parent::__construct();
        //DEFINIMOS EL NOMBRE DEL MODULO
        $this->module_sigla = 'PER';

        $this->load->helper('miscellaneous');
        $this->load->model('profile_model');
        $this->load->model('user_model');
        $this->load->helper('security');
        validate_login($this->session->userdata('logged_in'));
    }

    public function index() {
        //VALIDAR PERMISO DEL ROL
        validation_permission_role($this->module_sigla, 'permission_view');
        
        if($this->session->userdata('ID_TIPO_USU')==3){
            $data['registros'] = $this->profile_model->get_users($this->session->userdata('USUARIO_ID'));
            $data['content'] = 'profile/index_c';
        }else{
           $data['content'] = 'profile/index'; 
        }

        $data['title'] = 'Universidad Manuela Beltran, Aplicativo de Cuentas - Hojas de Vida.';
        
        $this->load->view('template/template', $data);
    }

    public function assess($INSCRIPCION_PIN, $ASIGNACION_ID) {
        //VALIDAR PERMISO DEL ROL
        validation_permission_role($this->module_sigla, 'permission_add');

        $data['INSCRIPCION_PIN'] = $INSCRIPCION_PIN;
        $data['ASIGNACION_ID'] = $ASIGNACION_ID;

        $data['registro'] = $this->profile_model->get_applicantsdocuments_iduser('1', $this->session->userdata('USUARIO_ID'), $INSCRIPCION_PIN);
        $data['modalidades'] = $this->profile_model->get_modalities();
        $data['ofertas'] = $this->profile_model->get_user_offers($INSCRIPCION_PIN);
        $data['assess'] = $this->profile_model->get_assess();
        $data['scores'] = $this->profile_model->get_score($ASIGNACION_ID);

        $data['title'] = 'Universidad Manuela Beltran, Aplicativo de Cuentas - Nueva Hoja de Vida.';
        $data['content'] = 'profile/add';
        $this->load->view('template/template', $data);
    }

    public function info_offer($EMPLEO_ID) {
        //sleep(1);
        //VALIDAR PERMISO DEL ROL
        validation_permission_role($this->module_sigla, 'permission_view');

        $EMPLEO_ID = deencrypt_id($EMPLEO_ID);
        $data['oferta'] = $this->profile_model->get_offer_id($EMPLEO_ID);
        if (count($data['oferta']) > 0) {
            $data['title'] = 'Vista de Oferta Laboral';
            $this->load->view('profile/view_offer', $data);
        } else {
            $this->session->set_flashdata(array('message' => 'Error al Consultar el Registro', 'message_type' => 'warning'));
            //redirect('profile', 'refresh');
        }
    }

    public function view_document($INSCRIPCION_PIN, $DOCUMENTO_ID) {
        $document = $this->profile_model->get_document_user($INSCRIPCION_PIN, $DOCUMENTO_ID);
        //echo '<pre>'.print_r($document,true).'</pre>';
        $file = $document[0]->DOCUMENTO_NOMBRE . '.pdf';
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $document[0]->INSCRIPCION_PIN . '_' . $document[0]->DOCUMENTO_FOLIO . '.pdf"');
        readfile('../images/documentos/' . $file);
    }

    public function insert() {
        //VALIDAR PERMISO DEL ROL
        validation_permission_role($this->module_sigla, 'permission_add');
        
        $datetime = date("Y-m-d H:i:s");
        $assess = $this->profile_model->get_assess();
        $ofertas = $this->profile_model->get_user_offers($this->input->post('INSCRIPCION_PIN', TRUE));

        foreach ($ofertas as $oferta) {
            foreach ($assess as $asses) {
                if ($asses->TIPOEVALUACION_CUMPLE) {
                    $postname = $oferta->OFERTAINS_ID . '_cumple_' . $asses->TIPOEVALUACION_ID;
                    $puntaje = score_assess1_option($asses->TIPOEVALUACION_ID, $oferta->OFERTAINS_ID, $this->input->post($postname, TRUE));
                    $data = array(
                        'ASIGNACION_ID' => $this->input->post('ASIGNACION_ID', TRUE),
                        'TIPOEVALUACION_ID' => $asses->TIPOEVALUACION_ID,
                        'EMPLEO_ID' => $oferta->EMPLEO_ID,
                        'EVALUACION_CUMPLE' => $this->input->post($postname, TRUE),
                        'EVALUACION_PUNTAJE' => $puntaje,
                        'EVALUACION_PVALOR' => '',
                        'EVALUACION_OBSERVACION' => $this->input->post($oferta->EMPLEO_ID . '_obser', TRUE),
                        'CUMPLE_PUNTAJE' => '1',
                        'EVALUACION_FECHA' => $datetime
                    );
                    //echo '<pre>'.print_r($data, true).'</pre>';
                    $this->profile_model->insert_assess($data);
                }
                if ($asses->TIPOEVALUACION_PUNTAJE) {
                    $postname = name_assess2_option($asses->TIPOEVALUACION_ID, $oferta->OFERTAINS_ID);
                    $puntaje = score_assess2_option($asses->TIPOEVALUACION_ID, $oferta->OFERTAINS_ID, $this->input->post($postname, TRUE));
                    $puntaje_valor = scorevalue_assess2_option($asses->TIPOEVALUACION_ID, $oferta->OFERTAINS_ID, $this->input->post($postname, TRUE));

                    $data = array(
                        'ASIGNACION_ID' => $this->input->post('ASIGNACION_ID', TRUE),
                        'TIPOEVALUACION_ID' => $asses->TIPOEVALUACION_ID,
                        'EMPLEO_ID' => $oferta->EMPLEO_ID,
                        'EVALUACION_CUMPLE' => '0',
                        'EVALUACION_PUNTAJE' => $puntaje,
                        'EVALUACION_PVALOR' => $puntaje_valor,
                        'EVALUACION_OBSERVACION' => $this->input->post($oferta->EMPLEO_ID . '_obser', TRUE),
                        'CUMPLE_PUNTAJE' => '2',
                        'EVALUACION_FECHA' => $datetime
                    );
                    //echo '<pre>'.print_r($data, true).'</pre>';
                    $this->profile_model->insert_assess($data);
                }
            }
        }

        $this->session->set_flashdata(array('message' => 'Evaluacion Actualizada con Exito', 'message_type' => 'info'));
        redirect('index.php/profile/assess/' . $this->input->post('INSCRIPCION_PIN', TRUE) . '/' . $this->input->post('ASIGNACION_ID', TRUE), 'refresh');
    }

    public function edit($id_cv) {
        //VALIDAR PERMISO DEL ROL
        validation_permission_role($this->module_sigla, 'permission_edit');

        $id_cv = deencrypt_id($id_cv);
        $data['registro'] = $this->cv_model->get_cv_id_cv($id_cv);
        if (count($data['registro']) > 0) {
            $data['depar'] = get_dropdown($this->user_model->get_states(), 'DEPARTAMENTO_ID', 'DEPARTAMENTO_NOMBRE');
            $data['depar'][] = '-SELECCIONE UN DEPARTAMENTO-';
            asort($data['depar']);

            $data['citys'] = get_dropdown($this->user_model->get_citys('ALL'), 'MUNICIPIO_ID', 'MUNICIPIO_NOMBRE');

            $data['states'] = get_array_states();

            $data['title'] = 'Universidad Manuela Beltran, Aplicativo de Cuentas - Modificar Hojas de Vida.';
            $data['content'] = 'cv/edit';
            $this->load->view('template/template', $data);
        } else {
            $this->session->set_flashdata(array('message' => 'Error al Consultar el Registro', 'message_type' => 'warning'));
            redirect('index.php/cv', 'refresh');
        }
    }

    public function documents($id_cv) {
        //VALIDAR PERMISO DEL ROL
        validation_permission_role($this->module_sigla, 'permission_edit');

        $id_cv = deencrypt_id($id_cv);
        $data['registro'] = $this->cv_model->get_cv_id_cv($id_cv);
        if (count($data['registro']) > 0) {
            $data['documents'] = $this->cv_model->get_cvdocuments_id_cv($id_cv);
            $data['typedocuments'] = get_dropdown($this->cv_model->get_typedocuments(), 'TIPODOCUMENTO_ID', 'TIPODOCUMENTO_NOMBRE');
            $data['title'] = 'Universidad Manuela Beltran, Aplicativo de Cuentas - Documentos de Hojas de Vida.';
            $data['content'] = 'cv/documents/index';
            $this->load->view('template/template', $data);
        } else {
            $this->session->set_flashdata(array('message' => 'Error al Consultar el Registro', 'message_type' => 'warning'));
            redirect('index.php/cv', 'refresh');
        }
    }

    public function insert_document_cv($id_cv) {
        //VALIDAR PERMISO DEL ROL
        validation_permission_role($this->module_sigla, 'permission_edit');

        $id_cv = deencrypt_id($id_cv);
        $data['registro'] = $this->cv_model->get_cv_id_cv($id_cv);
        if (count($data['registro']) > 0) {
            $FECHA = date("Y_m_d_H_i_s");
            $TIPODOCUMENTO_ID = $this->input->post('TIPODOCUMENTO_ID', TRUE);

            $config['upload_path'] = 'images/documentos/';
            $config['allowed_types'] = 'pdf';
            $config['encrypt_name'] = FALSE;
            $config['max_size'] = '2000';
            $FINE_NAME = $id_cv . '_' . $TIPODOCUMENTO_ID . '_' . $FECHA;
            $config['file_name'] = $FINE_NAME;
            $this->load->library('upload', $config);


            $field_name = "userfile";
            if (!$this->upload->do_upload($field_name)) {
                $error = $this->upload->display_errors();
                //echo 'Error: ' . strip_tags($error);
                $this->session->set_flashdata(array('message' => strip_tags($error), 'message_type' => 'danger'));
                redirect('index.php/cv/documents/' . encrypt_id($id_cv), 'refresh');
            } else {

                $upload_data = $this->upload->data();
                $pdf_name = $upload_data['file_name'];

                //echo "Exito!!!" . date("Y_m_d_H_i_s");

                $data = array(
                    'HV_ID' => $id_cv,
                    'TIPODOCUMENTO_ID' => $TIPODOCUMENTO_ID,
                    'DOCUMENTOHV_OBSERVACION' => addslashes($this->input->post('DOCUMENTOHV_OBSERVACION', TRUE)),
                    'DOCUMENTOHV_IDCREADOR' => $this->session->userdata('USUARIO_ID'),
                    'DOCUMENTOHV_NOMBRE' => $FINE_NAME
                );
                $insert = $this->cv_model->insert_document($data);

                if ($insert) {
                    $this->session->set_flashdata(array('message' => 'Documento cargado con exito.', 'message_type' => 'info'));
                    redirect('index.php/cv/documents/' . encrypt_id($id_cv), 'refresh');
                } else {
                    $this->session->set_flashdata(array('message' => 'Error al insertar el documento', 'message_type' => 'error'));
                    redirect('index.php/cv/documents/' . encrypt_id($id_cv), 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata(array('message' => 'Error al Consultar el Registro', 'message_type' => 'warning'));
            redirect('index.php/cv', 'refresh');
        }
    }

    public function update($id_cv) {
        //VALIDAR PERMISO DEL ROL
        validation_permission_role($this->module_sigla, 'permission_edit');

        $id_cv = deencrypt_id($id_cv);

        //validation_permission_role($this->module_sigla, 'permission_edit');
        //CARGAMOS LA LIBRERIA DE VALIDACION DE CODEIGNITER
        $this->load->library('form_validation');
        //DEFINIMOS LOS DELIMITADORES DE LOS MENSAJES DE ERROR - EN FORMATO HTML
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        //DEFINIMOS LOS CAMPOS QUE VAMOS A VALIDAR, JUNTO CON EL TIPO DE VALIDACION:
        //(https://ellislab.com/codeigniter/user-guide/libraries/form_validation.html#rulereference)        


        $this->form_validation->set_rules('HV_NOMBRES', 'Nombres', 'required|trim');
        $this->form_validation->set_rules('HV_APELLIDOS', 'Apellidos', 'required|trim');
        $this->form_validation->set_rules('HV_NUMERODOCUMENTO', 'Numero de Documento', 'required|trim');
        $this->form_validation->set_rules('HV_LUGARDENACIMIENTO', 'Lugar de Nacimiento', 'required|trim');
        $this->form_validation->set_rules('HV_LUGARDERESIDENCIA', 'Lugar de Residencia', 'required|trim');

        //SI LA VALIDACION RETORNA UN FALSE, CARGAMOS NUEVAMENTE LA VISTA, SI RETORNA TRUE GUARDAMOS
        if ($this->form_validation->run() == FALSE) {
            $data['registro'] = $this->user_model->get_cv_id_cv($id_cv);
            if (count($data['registro']) > 0) {
                $data['depar'] = get_dropdown($this->user_model->get_states(), 'DEPARTAMENTO_ID', 'DEPARTAMENTO_NOMBRE');
                $data['depar'][] = '-SELECCIONE UN DEPARTAMENTO-';
                asort($data['depar']);

                $data['citys'] = get_dropdown($this->user_model->get_citys('ALL'), 'MUNICIPIO_ID', 'MUNICIPIO_NOMBRE');

                $data['states'] = get_array_states();

                $data['title'] = 'Universidad Manuela Beltran, Aplicativo de Cuentas - Modificar Hojas de Vida.';
                $data['content'] = 'cv/edit';
                $this->load->view('template/template', $data);
            } else {
                $this->session->set_flashdata(array('message' => 'Error al Consultar el Registro', 'message_type' => 'warning'));
                redirect('index.php/user', 'refresh');
            }
        } else {
            $data = array(
                'HV_NOMBRES' => $this->input->post('HV_NOMBRES', TRUE),
                'HV_APELLIDOS' => $this->input->post('HV_APELLIDOS', TRUE),
                'HV_TIPODOCUMENTO' => $this->input->post('HV_TIPODOCUMENTO', TRUE),
                'HV_NUMERODOCUMENTO' => $this->input->post('HV_NUMERODOCUMENTO', TRUE),
                'HV_CORREO' => $this->input->post('HV_CORREO', TRUE),
                'HV_GENERO' => $this->input->post('HV_GENERO', TRUE),
                'HV_FECHADENACIMIENTO' => $this->input->post('HV_FECHADENACIMIENTO', TRUE),
                'HV_LUGARDENACIMIENTO' => $this->input->post('HV_LUGARDENACIMIENTO', TRUE),
                'HV_DIRECCIONRESIDENCIA' => $this->input->post('HV_DIRECCIONRESIDENCIA', TRUE),
                'HV_LUGARDERESIDENCIA' => $this->input->post('HV_LUGARDERESIDENCIA', TRUE),
                'HV_TELEFONOFIJO' => $this->input->post('HV_TELEFONOFIJO', TRUE),
                'HV_CELULAR' => $this->input->post('HV_CELULAR', TRUE),
                'HV_ID' => $id_cv,
                'HV_ESTADO' => $this->input->post('HV_ESTADO', TRUE),
                'HV_PROFESION' => $this->input->post('HV_PROFESION', TRUE)
            );
            $update = $this->cv_model->update_cv($data);

            if ($update) {
                $this->session->set_flashdata(array('message' => 'Registro editado con exito', 'message_type' => 'info'));
                redirect('index.php/cv', 'refresh');
            } else {
                $this->session->set_flashdata(array('message' => 'Error al editar el Registro', 'message_type' => 'warning'));
                redirect('index.php/cv', 'refresh');
            }
        }
    }

    public function ajax_datatable() {
        if ($this->input->is_ajax_request()) {
            $data = $this->profile_model->get_table();
            echo $data;
        } else {
            echo 'Acceso no utorizado';
        }
    }

}
