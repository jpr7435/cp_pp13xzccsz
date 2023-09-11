<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Vistasms extends CI_Model {

    private $key;

    public function __construct() {
        $this->key = $this->config->item('encript');
    }

    public function getKey() {
        return $this->key;
    }
    public function getBaseCamposUno($numero, $id) {
        $this->db = $this->load->database('sms', TRUE);

        $query = $this->db->query("select * from basedeenvio where numero = '$numero' and idCampana = '$id';");
        return $query->result_array();
    }
    public function setMensaje($numero,$campana, $msj) {

        $data = $this->getBaseCamposUno($numero, $campana);

        if(isset($data[0]['opcion1'])){
          if($data[0]['opcion1'] != ""){
            $msj = str_replace("<<opcion1>>", $data[0]['opcion1'], $msj);
          }
        }
        if(isset($data[0]['opcion2'])){
          if($data[0]['opcion1'] != ""){
            $msj = str_replace("<<opcion2>>", $data[0]['opcion2'], $msj);
          }
        }
        if(isset($data[0]['opcion3'])){
          if($data[0]['opcion3'] != ""){
            $msj = str_replace("<<opcion3>>", $data[0]['opcion3'], $msj);
          }
        }
        if(isset($data[0]['opcion4'])){
          if($data[0]['opcion4'] != ""){
            $msj = str_replace("<<opcion4>>", $data[0]['opcion4'], $msj);
          }
        }

        return $msj;
    }

    public function getMesInfo($id, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from meses where idMes = '$id'");
        $datos = $query->result_array();
        return $datos;
    }

    public function saveSmsHist($num, $msj) {
        $this->db = $this->load->database('sms', TRUE);

        $this->db->query("insert into sms_hist (numero, mensaje, tipo) values('$num', '$msj', 'Salida');");
    }
}
