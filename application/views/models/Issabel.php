<?php

/*
 * AES_DECRYPT(documento, 'S1cc0l2017!!')
 *
 * $this -> config -> item('empresa')
 *
 *
 * AES_ENCRYPT('$doc', 'S1cc0l2017!!')
 */

class Issabel extends CI_Model {

    private $key;

    public function __construct() {
        $this->key = $this->config->item('encript');
    }

    public function getKey() {
        return $this->key;
    }

    public function getAllIp() {
        $query = $this->db->query("select * from autorizacion");
        return $query->result_array();
    }

    public function getCalls($tele) {
        $this->db = $this->load->database('asterisk', TRUE);
        $hoy = date("Y-m-d")." 01:00:00";
        $query = $this->db->query("select max(calldate) as maximo from cdr where dst like '%$tele%' and calldate > '$hoy'");
        return $query->result_array();
    }

    public function getCallId($id) {
        $this->db = $this->load->database('asterisk', TRUE);

        $query = $this->db->query("select * from cdr where calldate = '$id'");
        return $query->result_array();
    }

    public function getTotalInformeAbandonadas($fechaIni, $fechaFin) {
        $this->db = $this->load->database('asterisk', TRUE);

        $query = $this->db->query("select * from call_entry where status = 'abandonada' and date(datetime_entry_queue) >= '$fechaIni' and date(datetime_entry_queue) <= '$fechaFin'");
        return $query->result_array();
    }

}

?>
