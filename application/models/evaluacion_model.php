<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evaluacion_model extends CI_Model {

    function datos_personales($id) {
        $this->db->select('PRIMERNOMBRE_PER,SEGUNDONOMBRE_PER,PRIMERAPELLIDO_PER,SEGUNDOAPELLIDO_PER,DOCUMENTO_PER as cedula
            ,PIN,IDGENERO_PER,FECHANACIMIENTO_PER,TELEFONOFIJO_PER,TELEFONOCEL_PER,CORREO_PER,DIRECCION_PER,
            (SELECT nombre_dep
            FROM CNSC_DEPARTAMENTO AS CNSC_DEPARTAMENTO_1
		WHERE        (iddeparta_dep = CNSC_PERSONA.DEPARTRES_PER)) 
		AS DEPARTAMENTO_RESIDENCIA,
		(SELECT        nombre_mun
		FROM            CNSC_MUNICIPIO AS CNSC_MUNICIPIO_1
		WHERE        (iddeparta_mun = dbo.CNSC_PERSONA.DEPARTRES_PER) 
		AND (idmunicipio_mun = dbo.CNSC_PERSONA.MUNICIPIORES_PER)) 
		AS MUNICIPIO_RESIDENCIA,
                (SELECT nombre_nivel FROM OPEC_PERFIL AS OPEC_PERFIL_1
                WHERE idperfil_per = INSC_REGISTRO.IDPERFIL_REG) AS NOMBRE_NIVEL,idperfil_emp,
                contextualizacion_0_req,contextualizacion_1_req,experiencia_req,IDINSCRIPCION_INS', false);

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
//        $this->db->where('PIN',$id);
        $this->db->where('IDINSCRIPCION_INS', $id);
        $datos = $this->db->get('CNSC_PERSONA');
//        echo $this->db->last_query();
//        print_y($datos->result());
//        die();
        return $datos->result();
    }

    function documentos($id) {
        $this->db->select('DETALLEPARAMETRO_PAR,RUTAADJUNTO_DOC', false);

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
        $this->db->select('INSC_CALIFICACION_RM_AA.IDCALIFICACION_RM_AA_CRA,INSC_CALIFICACION_RM_AA.CONSECUTIVO_CRA,MODALIDAD_MOD,RUTAADJUNTO_CRA,REQUISITOMINIMO,IDINSCRIPCION_INS', false);

        $this->db->join('INSC_CALIFICACION_RM_AA', 'INSC_CALIFICACION_RM_AA.IDTIPOADJUNTO_CRA=CNSC_PARAMETROS.CONSECUTIVOPARAMETRO_PAR');
        $this->db->join('INSC_INSCRIPCION', 'INSC_CALIFICACION_RM_AA.IDINSCRIPCION_CRA = INSC_INSCRIPCION.IDINSCRIPCION_INS ');
        $this->db->join('INSC_MODALIDAD', 'INSC_MODALIDAD.IDMODALIDAD_MOD=INSC_CALIFICACION_RM_AA.CONSECUTIVO_CRA');
        $this->db->where('NOMBREPARAMETRO_PAR', 'TIPO_ADJUNTO');
        $this->db->where('ESTADO', 1);
        $this->db->where('IDINSCRIPCION_INS', $id);
        $this->db->where('CONSECUTIVOPARAMETRO_PAR', 3);
        $datos = $this->db->get('CNSC_PARAMETROS');
//                echo $this->db->last_query();
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

}
