<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prueba_model extends CI_Model {

    //////////////////////////////MODELOS DE PERMISOS DE ROLES

    public function prueba() {
//        $sql_string = "SELECT * FROM PRUE_PRUEBA";
        $sql_query = $this->db->get('PRUE_PRUEBA');
        return $sql_query->result();
    }

}
