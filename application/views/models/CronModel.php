<?php

/*
 * AES_DECRYPT(documento, 'S1cc0l2017!!')
 *
 * $this -> config -> item('empresa')
 *
 *
 * AES_ENCRYPT('$doc', 'S1cc0l2017!!')
 */

class CronModel extends CI_Model {

    private $key;

    public function __construct() {
        $this->key = $this->config->item('encript');
    }

    public function getKey() {
        return $this->key;
    }


    public function getClientesEnvio() {

        $this->db = $this->load->database('bbva_especial', TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '" . $this->key . "') as documento from 10_clientes where mejorGestion != '1' and mejorGestion != '2';");
        return $query->result_array();
    }

    public function getObligaciones($doc) {

        $this->db = $this->load->database('bbva_especial', TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(obligacion,  '" . $this->key . "') as obligacion from 9_creditos where documento = AES_ENCRYPT('$doc',  '" . $this->key . "');");
        return $query->result_array();
    }

    public function getClientesAprobacion($hoy) {

        $this->db = $this->load->database('bbva_especial', TRUE);

        $query = $this->db->query("select AES_DECRYPT(documento,  '" . $this->key . "') as documento from 7_callhist where idResultado = '1' and date(fechaGestion) = '$hoy' and fechaAcuerdo != '-0-' and vlAcuerdo != '0' group by documento;");
        return $query->result_array();
    }

    public function getMails($doc) {

        $this->db = $this->load->database('bbva_especial', TRUE);

        $query = $this->db->query("select * from mails where documento = AES_ENCRYPT('$doc',  '" . $this->key . "');");
        return $query->result_array();
    }

    public function saveGestion($documento, $fecha, $hora, $tele, $accion, $contac, $motiv, $resultado, $fecacu, $valor, $txt, $txtgest, $id, $time) {

        $this->db = $this->load->database('bbva_especial', TRUE);

        $this->db->query("insert into 7_callhist (documento, fechaGestion, hora, telefono, idAccion, idContacto, idMotivo, idResultado, fechaAcuerdo, vlAcuerdo, complemento, textoGestion, idAsesor, tiempo)"
                . "values (AES_ENCRYPT('$documento',  '$this->key'), '$fecha', '$hora', '$tele', '$accion', '$contac', '$motiv', '$resultado', '$fecacu', '$valor', '$txt', '$txtgest', '$id', '$time')");
    }

}

?>
