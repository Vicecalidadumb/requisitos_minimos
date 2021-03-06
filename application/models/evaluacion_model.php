<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evaluacion_model extends CI_Model {

    function optener_id($pin) {
        $this->db->select('INSC_INSCRIPCION.IDINSCRIPCION_INS');
        $this->db->where('INSC_PIN.PIN', $pin);
        $this->db->where('INSC_INSCRIPCION.IDPERSONA_INS', 'INSC_PIN.IDPERSONA_PIN', false);
        $datos = $this->db->get('INSC_PIN,INSC_INSCRIPCION');
        $datos = $datos->result();
        return $datos[0]->IDINSCRIPCION_INS;
    }

    function datos_personales($id) {
        //$this->db->select('PRIMERNOMBRE_PER,SEGUNDONOMBRE_PER,PRIMERAPELLIDO_PER,SEGUNDOAPELLIDO_PER,DOCUMENTO_PER as cedula');
        //$this->db->select('PIN,IDGENERO_PER,FECHANACIMIENTO_PER,TELEFONOFIJO_PER,TELEFONOCEL_PER,CORREO_PER,DIRECCION_PER');
        $this->db->select('INSC_PIN.*,OPEC_CONVOCATORIA.*,OPEC_PERFIL.*,INSC_REGISTRO.*,OPEC_CODIGO_EMPLEO.*');
        $this->db->select('OPEC_NIVEL.*,OPEC_EMPLEO.*,INSC_INSCRIPCION.*,CNSC_PERSONA.*,OPEC_REQ_EQUIV.*,OPEC_ENTIDAD.*,OPEC_DEPENDENCIA.*');
        $this->db->select("(
                            SELECT DETALLEPARAMETRO_PAR
                            FROM CNSC_PARAMETROS p2
                            WHERE p2.NOMBREPARAMETRO_PAR='TIPO_DOCUMENTO'
                            AND p2.CONSECUTIVOPARAMETRO_PAR = CNSC_PERSONA.IDTIPODOCUMENTO_PER
                            ) AS TIPO_DOCUMENTO", false);
        $this->db->select("(
                            SELECT (
                                    ISNULL(estadoReqEstudio_Req,'') + '||' + 
                                    ISNULL(estadoReqExperiencia_Req,'')  + '||' +      
                                    ISNULL(obsReqEstudio_Req,'')  + '||' + 
                                    ISNULL(obsReqExperiencia_Req,'')  + '||' + 
                                    ISNULL(cumpleRequisitos,'')  + '||' +
                                    ISNULL(obssuperv_req,'')
                                    )
                            FROM REQ_MINIMOS RM
                            WHERE INSC_REGISTRO.IDINSCRIPCION_REG = RM.idInscripcion_Req
                            ) AS REQUISITOS_MINIMOS", false);
        $this->db->select('
                            (
                            SELECT nombre_dep
                            FROM CNSC_DEPARTAMENTO AS CNSC_DEPARTAMENTO_1
                            WHERE 
                            (iddeparta_dep = CNSC_PERSONA.DEPARTRES_PER)) 
                            AS DEPARTAMENTO_RESIDENCIA,
                                (
                                SELECT nombre_mun
                                FROM CNSC_MUNICIPIO AS CNSC_MUNICIPIO_1
                                WHERE (iddeparta_mun = dbo.CNSC_PERSONA.DEPARTRES_PER) 
                                AND (idmunicipio_mun = dbo.CNSC_PERSONA.MUNICIPIORES_PER)
                                ) 
                                AS MUNICIPIO_RESIDENCIA,
                                (
                                SELECT nombre_nivel 
                                FROM OPEC_PERFIL AS OPEC_PERFIL_1
                                WHERE idperfil_per = INSC_REGISTRO.IDPERFIL_REG
                                ) 
                                AS NOMBRE_NIVEL
                            ', false);
        $this->db->select('idperfil_emp,contextualizacion_0_req,contextualizacion_1_req,experiencia_req,IDINSCRIPCION_INS');

        $this->db->join('INSC_PIN', 'CNSC_PERSONA.IDPERSONA_PER=INSC_PIN.IDPERSONA_PIN');
        $this->db->join('OPEC_CONVOCATORIA', 'INSC_PIN.IDCONVOCATORIA_PIN = OPEC_CONVOCATORIA.idconvoc_con');
        $this->db->join('OPEC_PERFIL', 'OPEC_CONVOCATORIA.idconvoc_con = OPEC_PERFIL.idconvoc_per');
        $this->db->join('INSC_REGISTRO', 'OPEC_PERFIL.idperfil_per = INSC_REGISTRO.IDPERFIL_REG');
        $this->db->join('OPEC_CODIGO_EMPLEO', 'OPEC_PERFIL.idcodempleo_per = dbo.OPEC_CODIGO_EMPLEO.idcodempleo_coe');
        $this->db->join('OPEC_NIVEL', 'OPEC_PERFIL.nivel_per = OPEC_NIVEL.nivel');
        $this->db->join('OPEC_EMPLEO', 'OPEC_EMPLEO.idperfil_emp = dbo.INSC_REGISTRO.IDPERFIL_REG ');
        $this->db->join('INSC_INSCRIPCION', 'INSC_PIN.IDPIN_PIN = dbo.INSC_INSCRIPCION.IDPIN_INS 
            AND dbo.CNSC_PERSONA.IDPERSONA_PER = dbo.INSC_INSCRIPCION.IDPERSONA_INS 
            AND dbo.OPEC_CONVOCATORIA.idconvoc_con = dbo.INSC_INSCRIPCION.IDCONVOCATORIA_INS 
            AND dbo.INSC_REGISTRO.IDINSCRIPCION_REG = dbo.INSC_INSCRIPCION.IDINSCRIPCION_INS', false);
        $this->db->join('OPEC_REQ_EQUIV', 'OPEC_EMPLEO.idperfil_emp = OPEC_REQ_EQUIV.idperfil_req ');
        $this->db->join('OPEC_ENTIDAD', 'OPEC_PERFIL.identidad_per = OPEC_ENTIDAD.identidad_ent ');
        $this->db->join('OPEC_DEPENDENCIA', 'OPEC_EMPLEO.dependencia_emp = OPEC_DEPENDENCIA.iddependencia_dep ');
//        $this->db->where('PIN',$id);
        $this->db->where('IDINSCRIPCION_INS', $id);
        $datos = $this->db->get('CNSC_PERSONA');
//        echo $this->db->last_query();
//        print_y($datos->result());
//        die();
        return $datos->result();
    }

    function documentos($id) {
        $this->db->select('DETALLEPARAMETRO_PAR,RUTAADJUNTO_DOC,INSC_DOCUMENTO_OBLIGATORIO.FOLIO_DOC', false);

        $this->db->join('INSC_DOCUMENTO_OBLIGATORIO', 'INSC_DOCUMENTO_OBLIGATORIO.IDTIPOADJUNTO_DOC=CNSC_PARAMETROS.CONSECUTIVOPARAMETRO_PAR');
        $this->db->join('INSC_INSCRIPCION', 'INSC_DOCUMENTO_OBLIGATORIO.IDINSCRIPCION_DOC = INSC_INSCRIPCION.IDINSCRIPCION_INS');
        $this->db->where('NOMBREPARAMETRO_PAR', 'TIPO_ADJUNTO');
        $this->db->where('ESTADO', 1);
        $this->db->where('IDINSCRIPCION_INS', $id);
        $datos = $this->db->get('CNSC_PARAMETROS');
//                echo $this->db->last_query();
        return $datos->result();
    }

    function modalidad() {
        $this->db->select('IDMODALIDAD_MOD,MODALIDAD_MOD', false);
        $datos = $this->db->get('INSC_MODALIDAD');
//                echo $this->db->last_query();
        return $datos->result();
    }

    function universidad($universidad) {
        $this->db->select('IDUNIVERSIDAD_UNIV,UNIVERSIDAD_UNIV', false);
        $this->db->where('IDMODALIDAD_UNIV', $universidad);
        $this->db->order_by('UNIVERSIDAD_UNIV');
        $datos = $this->db->get('INSC_UNIVERSIDAD');
//                        echo $this->db->last_query();
        return $datos->result();
    }

    function titulo($titulo) {
        $this->db->select('[IDTITULO_TIT],[TITULO_TIT]', false);
        $this->db->where('[IDUNIVERSIDAD_TIT]', $titulo, false);
        $datos = $this->db->get('INSC_TITULO');
//                        echo $this->db->last_query();
        return $datos->result();
    }

    function educacion_formal($id) {
        $this->db->select('INSC_CALIFICACION_RM_AA.IDTIPOADJUNTO_CRA,INSC_CALIFICACION_RM_AA.IDCALIFICACION_RM_AA_CRA,INSC_CALIFICACION_RM_AA.CONSECUTIVO_CRA,MODALIDAD_MOD,RUTAADJUNTO_CRA,REQUISITOMINIMO,IDINSCRIPCION_INS', false);

        $this->db->join('INSC_CALIFICACION_RM_AA', 'INSC_CALIFICACION_RM_AA.IDTIPOADJUNTO_CRA=CNSC_PARAMETROS.CONSECUTIVOPARAMETRO_PAR');
        $this->db->join('INSC_INSCRIPCION', 'INSC_CALIFICACION_RM_AA.IDINSCRIPCION_CRA = INSC_INSCRIPCION.IDINSCRIPCION_INS ');
//        $this->db->join('INSC_MODALIDAD', 'INSC_MODALIDAD.IDMODALIDAD_MOD=INSC_CALIFICACION_RM_AA.CONSECUTIVO_CRA');
        $this->db->join('INSC_EDUCACIONFORMAL', 'INSC_EDUCACIONFORMAL.IDCALIFICACION_EDF=INSC_CALIFICACION_RM_AA.IDCALIFICACION_RM_AA_CRA', 'left');
        $this->db->join("INSC_TITULO", 'INSC_TITULO.IDTITULO_TIT=INSC_EDUCACIONFORMAL.IDTITULO_EDF', 'left');
        $this->db->join("INSC_UNIVERSIDAD", 'INSC_UNIVERSIDAD.IDUNIVERSIDAD_UNIV=INSC_TITULO.IDUNIVERSIDAD_TIT', 'left');
        $this->db->join("INSC_MODALIDAD", 'INSC_MODALIDAD.IDMODALIDAD_MOD=INSC_UNIVERSIDAD.IDMODALIDAD_UNIV', 'left');
        $this->db->where('NOMBREPARAMETRO_PAR', 'TIPO_ADJUNTO');
        $this->db->where('INSC_CALIFICACION_RM_AA.ESTADO', 1);
        $this->db->where('IDINSCRIPCION_INS', $id);
        $this->db->where('CONSECUTIVOPARAMETRO_PAR', 3);
        $datos = $this->db->get('CNSC_PARAMETROS');
//        echo $this->db->last_query();
        return $datos->result();
    }

    function experiencia($id) {
        $this->db->select('INSC_EXPERIENCIA_LABORAL.*,INSC_CALIFICACION_RM_AA.*,CNSC_PARAMETROS.*');
        $this->db->join('INSC_CALIFICACION_RM_AA', 'INSC_CALIFICACION_RM_AA.IDTIPOADJUNTO_CRA=CNSC_PARAMETROS.CONSECUTIVOPARAMETRO_PAR');
        $this->db->join('INSC_INSCRIPCION', 'INSC_CALIFICACION_RM_AA.IDINSCRIPCION_CRA = INSC_INSCRIPCION.IDINSCRIPCION_INS ');
        $this->db->join('INSC_EXPERIENCIA_LABORAL', 'INSC_EXPERIENCIA_LABORAL.IDCALIFICACION_EXL=INSC_CALIFICACION_RM_AA.IDCALIFICACION_RM_AA_CRA');
        $this->db->where('NOMBREPARAMETRO_PAR', 'TIPO_ADJUNTO');
        $this->db->where('ESTADO', 1);
        $this->db->where('IDINSCRIPCION_INS', $id);
        //$this->db->where('CONSECUTIVOPARAMETRO_PAR', 8);
        $this->db->like('DETALLEPARAMETRO_PAR', 'experiencia');
        $this->db->order_by('CONSECUTIVO_CRA');
        $datos = $this->db->get('CNSC_PARAMETROS');
        return $datos->result();
    }

    function experiencia_idcalificacion($id) {
        $this->db->select('INSC_EXPERIENCIA_LABORAL.*,INSC_CALIFICACION_RM_AA.*,CNSC_PARAMETROS.*');
        $this->db->join('INSC_CALIFICACION_RM_AA', 'INSC_CALIFICACION_RM_AA.IDTIPOADJUNTO_CRA=CNSC_PARAMETROS.CONSECUTIVOPARAMETRO_PAR');
        $this->db->join('INSC_INSCRIPCION', 'INSC_CALIFICACION_RM_AA.IDINSCRIPCION_CRA = INSC_INSCRIPCION.IDINSCRIPCION_INS ');
        $this->db->join('INSC_EXPERIENCIA_LABORAL', 'INSC_EXPERIENCIA_LABORAL.IDCALIFICACION_EXL=INSC_CALIFICACION_RM_AA.IDCALIFICACION_RM_AA_CRA');
        $this->db->where('NOMBREPARAMETRO_PAR', 'TIPO_ADJUNTO');
        $this->db->where('ESTADO', 1);
        $this->db->where('IDCALIFICACION_EXL', $id);
        //$this->db->where('CONSECUTIVOPARAMETRO_PAR', 8);
        $this->db->like('DETALLEPARAMETRO_PAR', 'experiencia');
        $this->db->order_by('CONSECUTIVO_CRA');
        $datos = $this->db->get('CNSC_PARAMETROS');
        return $datos->result();
    }

    function nueva_universidad($post) {
        $this->db->set('UNIVERSIDAD_UNIV', strtoupper($post['universidad_otra']));
        $this->db->set('IDMODALIDAD_UNIV', $post['modalidad']);
        $this->db->insert('INSC_UNIVERSIDAD');
        $id = $this->db->insert_id();
        $this->db->set('IDUNIVERSIDAD_TIT', $id);
        $this->db->set('TITULO_TIT', 'OTRO');
        $this->db->insert('INSC_TITULO');
//                        echo $this->db->last_query();
    }

    function nuevo_titulo($post) {

        $this->db->set('IDUNIVERSIDAD_TIT', $post['universidad']);
        $this->db->set('TITULO_TIT', strtoupper($post['titulo_otra']));
        $this->db->insert('INSC_TITULO');
//                        echo $this->db->last_query();
    }

    function guardar_universidad($post) {

//        guarda doda la informacion de deducacion
        $this->db->select('IDCALIFICACION_EDF');
        $this->db->where('IDCALIFICACION_EDF', $post['idcal']);
        $this->db->from('INSC_EDUCACIONFORMAL', false);
        $datos = $this->db->get();
        $datos = $datos->result();

        $this->db->set('IDCALIFICACION_EDF', $post['idcal']);
        if (isset($post['graduado_ext'])) {
            if ($post['graduado_ext'] == 1)
                $this->db->set('TITULOEXTRANJERO_EDF', 1);
            else
                $this->db->set('TITULOEXTRANJERO_EDF', 0);
        } else
            $this->db->set('TITULOEXTRANJERO_EDF', 0);


        if (isset($post['graduado'])) {
            if ($post['graduado'] == 1) {
                $this->db->set('SEMESTRES_EDF', 20);
                $this->db->set('FECHA_EDF', $post['fecha_grado']);
                $this->db->set('GRADUADO_EDF', 1);
            } else {
                $this->db->set('GRADUADO_EDF', 0);
                $this->db->set('FECHA_EDF', 'NULL', false);
                $this->db->set('SEMESTRES_EDF', $post['sem']);
            }
        } else {
            $this->db->set('GRADUADO_EDF', 0);
            $this->db->set('FECHA_EDF', 'NULL', false);
            $this->db->set('SEMESTRES_EDF', $post['sem']);
        }

        $this->db->set('FECHATERMINACION_EDF', $post['fecha_terminacion']);

        $this->db->set('IDTITULO_EDF', $post['titulo']);
        // en caso que tenga registros se actualiza de lo contrario se crea
        if (count($datos) != 0) {
            $this->db->where('IDCALIFICACION_EDF', $post['idcal']);
            $info = $this->db->update('INSC_EDUCACIONFORMAL');
        } else {

            $info = $this->db->insert('INSC_EDUCACIONFORMAL');
        }
        if (isset($post['r_minimo'])) {
            if ($post['r_minimo'] == 1)
                $this->db->set('REQUISITOMINIMO', '1');
        }
        else {
            $this->db->set('REQUISITOMINIMO', 'NULL', false);
        }
//        echo $this->db->last_query();
        $this->db->set('OBSERVACION', $post['observaciones']);
        $this->db->where('IDCALIFICACION_RM_AA_CRA', $post['idcal']);
        $this->db->update('INSC_CALIFICACION_RM_AA');


//                        echo $this->db->last_query();
    }

    function obtener_titulo($id) { // obtiene el titulo de acuerdo a la universidad solicitada
        $this->db->select("INSC_MODALIDAD.IDMODALIDAD_MOD,INSC_MODALIDAD.MODALIDAD_MOD,SEMESTRES_EDF,TITULOEXTRANJERO_EDF,
INSC_UNIVERSIDAD.IDUNIVERSIDAD_UNIV,INSC_UNIVERSIDAD.UNIVERSIDAD_UNIV,
INSC_TITULO.IDTITULO_TIT,INSC_TITULO.TITULO_TIT,FECHATERMINACION_EDF,TITULOEXTRANJERO_EDF,
INSC_CALIFICACION_RM_AA.OBSERVACION,FECHA_EDF");
        $this->db->from("INSC_EDUCACIONFORMAL");
        $this->db->join("INSC_CALIFICACION_RM_AA", 'INSC_CALIFICACION_RM_AA.IDCALIFICACION_RM_AA_CRA=INSC_EDUCACIONFORMAL.IDCALIFICACION_EDF');
        $this->db->join("INSC_TITULO", 'INSC_TITULO.IDTITULO_TIT=INSC_EDUCACIONFORMAL.IDTITULO_EDF');
        $this->db->join("INSC_UNIVERSIDAD", 'INSC_UNIVERSIDAD.IDUNIVERSIDAD_UNIV=INSC_TITULO.IDUNIVERSIDAD_TIT');
        $this->db->join("INSC_MODALIDAD", 'INSC_MODALIDAD.IDMODALIDAD_MOD=INSC_UNIVERSIDAD.IDMODALIDAD_UNIV');
        $this->db->where("INSC_CALIFICACION_RM_AA.IDCALIFICACION_RM_AA_CRA", $id);
        $datos = $this->db->get();
//                                echo $this->db->last_query();
        return $datos->result();
    }

    function requisitos_estudio($id) {
        $this->db->select("INSC_CALIFICACION_RM_AA.IDCALIFICACION_RM_AA_CRA, INSC_CALIFICACION_RM_AA.CONSECUTIVO_CRA, MODALIDAD_MOD, 
RUTAADJUNTO_CRA, REQUISITOMINIMO, IDINSCRIPCION_INS,INSC_UNIVERSIDAD.IDUNIVERSIDAD_UNIV,INSC_UNIVERSIDAD.UNIVERSIDAD_UNIV,
INSC_TITULO.IDTITULO_TIT,INSC_TITULO.TITULO_TIT");
        $this->db->from("CNSC_PARAMETROS");
        $this->db->join("INSC_CALIFICACION_RM_AA", "INSC_CALIFICACION_RM_AA.IDTIPOADJUNTO_CRA=CNSC_PARAMETROS.CONSECUTIVOPARAMETRO_PAR");
        $this->db->join("INSC_INSCRIPCION", 'INSC_CALIFICACION_RM_AA.IDINSCRIPCION_CRA = INSC_INSCRIPCION.IDINSCRIPCION_INS ');
//        $this->db->join("INSC_MODALIDAD", "INSC_MODALIDAD.IDMODALIDAD_MOD=INSC_CALIFICACION_RM_AA.CONSECUTIVO_CRA ");
        $this->db->join("INSC_EDUCACIONFORMAL", 'INSC_CALIFICACION_RM_AA.IDCALIFICACION_RM_AA_CRA=INSC_EDUCACIONFORMAL.IDCALIFICACION_EDF');
        $this->db->join("INSC_TITULO", "INSC_TITULO.IDTITULO_TIT=INSC_EDUCACIONFORMAL.IDTITULO_EDF");
        $this->db->join("INSC_UNIVERSIDAD", 'INSC_UNIVERSIDAD.IDUNIVERSIDAD_UNIV=INSC_TITULO.IDUNIVERSIDAD_TIT');
        $this->db->join("INSC_MODALIDAD", 'INSC_MODALIDAD.IDMODALIDAD_MOD=INSC_UNIVERSIDAD.IDMODALIDAD_UNIV');
        $this->db->where("NOMBREPARAMETRO_PAR", 'TIPO_ADJUNTO');
        $this->db->where("INSC_CALIFICACION_RM_AA.ESTADO", 1);
        $this->db->where("IDINSCRIPCION_INS", $id);
        $this->db->where("CONSECUTIVOPARAMETRO_PAR", 3);
        $this->db->where("REQUISITOMINIMO", 1);
        $datos = $this->db->get();
//                                echo $this->db->last_query();
        return $datos->result();
    }

    function guardar_experiencia($post) {
        $this->db->set('IDTIPOADJUNTO_CRA', $post['IDTIPOADJUNTO_CRA']);
        //**ACTUALIZACION INSC_CALIFICACION_RM_AA
        $this->db->set('OBSERVACION', $post['OBSERVACION']);
        if (isset($post['REQUISITOMINIMO'])) {
            if ($post['REQUISITOMINIMO'] == 1)
                $this->db->set('REQUISITOMINIMO', '1');
        } else
            $this->db->set('REQUISITOMINIMO', 'NULL', false);
        $this->db->where('IDCALIFICACION_RM_AA_CRA', $post['idcal']);
        $result = $this->db->update('INSC_CALIFICACION_RM_AA');
        //**FIN ACTUALIZACION INSC_CALIFICACION_RM_AA
        //**ACTUALIZACION INSC_EXPERIENCIA_LABORAL
        if ($result) {
            $this->db->set('ENTIDAD_EL', strtoupper($post['ENTIDAD_EL']));
            $this->db->set('CARGO_EL', strtoupper($post['CARGO_EL']));
            $this->db->set('FECHAINICIAL', $post['FECHAINICIAL'] . ' 00:00:00.000');
            $this->db->set('FECHAFINAL', $post['FECHAFINAL'] . ' 00:00:00.000');
            if (isset($post['EMPACTUAL_EL'])) {
                if ($post['EMPACTUAL_EL'] == 1)
                    $this->db->set('EMPACTUAL_EL', '1');
            } else
                $this->db->set('EMPACTUAL_EL', 'NULL', false);
            if (isset($post['REQUISITOMINIMO'])) {
                if ($post['REQUISITOMINIMO'] == 1)
                    $this->db->set('REQUISITOMINIMO_EL', '1');
            } else
                $this->db->set('REQUISITOMINIMO_EL', 'NULL', false);
            $this->db->where('IDCALIFICACION_EXL', $post['idcal']);
            $result = $this->db->update('INSC_EXPERIENCIA_LABORAL');
            return $result;
        }else {
            return false;
        }
        //**FIN ACTUALIZACION INSC_EXPERIENCIA_LABORAL
    }

    function agregar_experiencia($post) {
        //**INGRESAR A  INSC_CALIFICACION_RM_AA
        $this->db->set('IDINSCRIPCION_CRA', $post['id_glo']);
        $this->db->set('CONSECUTIVO_CRA', max_folio($post['id_glo']));
        $this->db->set('IDTIPOADJUNTO_CRA', $post['IDTIPOADJUNTO_CRA']);
        $this->db->set('ESTADO', '1');
        $this->db->set('FECHAACTUALIZACION', date("Y-m-d H:i:s") . '.' . rand(111, 999));
        $this->db->set('OBSERVACION', $post['OBSERVACION']);
        if (isset($post['REQUISITOMINIMO'])) {
            if ($post['REQUISITOMINIMO'] == 1)
                $this->db->set('REQUISITOMINIMO', '1');
        } else
            $this->db->set('REQUISITOMINIMO', 'NULL', false);
        $result = $this->db->insert('INSC_CALIFICACION_RM_AA');
        //**FIN ACTUALIZACION INSC_CALIFICACION_RM_AA
        //**ACTUALIZACION INSC_EXPERIENCIA_LABORAL
        if ($result) {
            $this->db->set('IDCALIFICACION_EXL', $this->db->insert_id());
            $this->db->set('ENTIDAD_EL', strtoupper($post['ENTIDAD_EL']));
            $this->db->set('CARGO_EL', strtoupper($post['CARGO_EL']));
            $this->db->set('FECHAINICIAL', $post['FECHAINICIAL'] . ' 00:00:00.000');
            $this->db->set('FECHAFINAL', $post['FECHAFINAL'] . ' 00:00:00.000');
            if (isset($post['EMPACTUAL_EL'])) {
                if ($post['EMPACTUAL_EL'] == 1)
                    $this->db->set('EMPACTUAL_EL', '1');
            } else
                $this->db->set('EMPACTUAL_EL', 'NULL', false);
            if (isset($post['REQUISITOMINIMO'])) {
                if ($post['REQUISITOMINIMO'] == 1)
                    $this->db->set('REQUISITOMINIMO_EL', '1');
            } else
                $this->db->set('REQUISITOMINIMO_EL', 'NULL', false);
            $result = $this->db->insert('INSC_EXPERIENCIA_LABORAL');
            return $result;
        }else {
            return false;
        }
        //**FIN ACTUALIZACION INSC_EXPERIENCIA_LABORAL
    }

    function guardar_rm($post) {
        $this->db->select('idInscripcion_Req');
        $this->db->where('idInscripcion_Req', $post['id_inscripcion']);
        $datos = $this->db->get('REQ_MINIMOS');
        $datos = $datos->result();

        $this->db->set('idInscripcion_Req', $post['id_inscripcion']);
        $this->db->set('estadoReqEstudio_Req', $post['requisitos_minimo']);
        $this->db->set('estadoReqExperiencia_Req', $post['requisitos_experiencia']);
        $this->db->set('obsReqEstudio_Req', $post['tex_requisitos_minimo']);
        $this->db->set('obsReqExperiencia_Req', $post['tex_requisitos_experiencia']);

        if ($post['requisitos_minimo'] == 'Admitido' && $post['requisitos_experiencia'] == 'Admitido')
            $paso="Admitido";
        else
            $paso="No Admitido";
//        $this->db->set();

        $this->db->set('cumpleRequisitos', $paso);
        
        if (count($datos) > 0) {
            $this->db->where('idInscripcion_Req', $post['id_inscripcion']);
            $this->db->update('REQ_MINIMOS');
        } else {
            $this->db->insert('REQ_MINIMOS');
        }
        return $paso;
//        sleep(5);
    }

    function guardar_universidad_new_folio($post) {
        $this->db->set('IDINSCRIPCION_CRA', $post['id_glo']);
        $this->db->set('CONSECUTIVO_CRA', max_folio($post['id_glo']));
        $this->db->set('IDTIPOADJUNTO_CRA', $post['tipoadj']);
        $this->db->set('ESTADO', 1);
        $this->db->set('FECHAACTUALIZACION', date('Y-m-d'));
        $this->db->set('OBSERVACION', $post['observaciones']);
//        $this->db->set('OBSERVACION',$post['observaciones']);
        if (isset($post['r_minimo'])) {
            if ($post['r_minimo'] == 1)
                $this->db->set('REQUISITOMINIMO', '1');
        }
        else {
            $this->db->set('REQUISITOMINIMO', 'NULL', false);
        }
        $this->db->insert('INSC_CALIFICACION_RM_AA');
        $post['idcal'] = $this->db->insert_id();
        $this->guardar_universidad($post);
    }

    function educacion_para_el_trabajo($id) {
        $this->db->select('CONSECUTIVO_CRA,INSTITUCION_EDNF,TITULO_EDNF,HORAS_EDNF,FECHA_EDNF,RUTAADJUNTO_CRA');
        $this->db->from('INSC_EDUCACIONNOFORMAL');
        $this->db->join('INSC_CALIFICACION_RM_AA', 'INSC_EDUCACIONNOFORMAL.IDCALIFICACION_EDNF=INSC_CALIFICACION_RM_AA.IDCALIFICACION_RM_AA_CRA');
        $this->db->where('IDINSCRIPCION_CRA', $id);
        $this->db->where('ESTADO', 1);
        $datos = $this->db->get();
        return $datos->result();
    }

    function contar_calificaciones($id) {
        $datos = $this->db->query('SELECT count(*) contar
  FROM RMAA_ASIGNACION
  where idinscripcion_asg=' . $id);
        $datos = $datos->result();
        return $datos[0]->contar;
    }

    function insert_calificaciones($id, $consultor) {
        $this->db->set('idestadocar_asg', 5);
        $this->db->where('idinscripcion_asg', $id);
        $this->db->update('RMAA_ASIGNACION');

        $this->db->set('idinscripcion_asg', $id);
        $this->db->set('idestadocar_asg', 6);
        $this->db->set('idusuario_asg', $consultor[0]->idusuario_asg);
        $this->db->set('fecasigna_asg', date("Y-m-d H:i:s") . '.' . rand(111, 999));
        $this->db->set('feccalific_asg', date("Y-m-d H:i:s") . '.' . rand(111, 999));
        $this->db->set('vigente_asg', 1);
        $this->db->set('idrol_asg', 9);
        $this->db->insert('RMAA_ASIGNACION');
    }

    function update_calificaciones($id, $userdata, $post) {
        if ($userdata['ID_TIPO_USU'] == 6) {
            $this->db->set('idestadocar_asg', 5);
            $this->db->where('idestadocar_asg', 8);
            $this->db->where('idinscripcion_asg', $id);
            $this->db->update('RMAA_ASIGNACION');

            $this->db->set('idestadocar_asg', 6);
            $this->db->where('idestadocar_asg', 10);
            $this->db->where('idinscripcion_asg', $id);
            $this->db->update('RMAA_ASIGNACION');
        } else if ($userdata['ID_TIPO_USU'] == 9) {
            $this->db->set('idestadocar_asg', 8);
            $this->db->where('idestadocar_asg', 5);
            $this->db->where('idinscripcion_asg', $id);
            $this->db->update('RMAA_ASIGNACION');

            $this->db->set('idestadocar_asg', 10);
            $this->db->where('idestadocar_asg', 6);
            $this->db->where('idinscripcion_asg', $id);
            $this->db->update('RMAA_ASIGNACION');
        }
        //[obssuperv_req]
        if ($userdata['ID_TIPO_USU'] == 9) {
            $this->db->set('obssuperv_req', $post['tex_obs_super']);
            $this->db->where('idInscripcion_Req', $id);
            $this->db->update('REQ_MINIMOS');
        }
    }

    function buscar_consultor() {
        $datos = $this->db->query('SELECT idusuario_asg,count(*) TOTAL_MENOR
  FROM RMAA_ASIGNACION
  where idrol_asg=9
  GROUP BY idusuario_asg
  order by TOTAL_MENOR asc');
        return $datos = $datos->result();
    }

    function datos_funciones($perfil) {
        $datos = $this->db->query('SELECT texto_fun
            FROM [OPEC_FUNCION]
            where [idperfil_fun]=' . $perfil);
        return $datos = $datos->result();
    }

}
