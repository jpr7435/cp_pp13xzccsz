<?php

/*
 * AES_DECRYPT(documento, 'S1cc0l2017!!')
 *
 * $this -> config -> item('empresa')
 *
 *
 * AES_ENCRYPT('$doc', 'S1cc0l2017!!')
 */

class MisModel extends CI_Model {

    private $key;

    public function __construct() {
        $this->key = $this->config->item('encript');
    }

     public function cleanText($text) {

     		$uno = str_replace("DROP", "", $text);
     		$dos = str_replace("SELECT", "", $uno);
     		$tres = str_replace("UPDATE", "", $dos);
     		$cuatro = str_replace("INSERT", "", $tres);
     		$cinco = str_replace("drop", "", $cuatro);
     		$seis = str_replace("select", "", $cinco);
     		$siete = str_replace("update", "", $seis);
     		$ocho = str_replace("insert", "", $siete);
     		$nueve = str_replace("'", "", $ocho);
     		$diez = str_replace(";", "", $nueve);
     		$once = str_replace("ñ", "ñ", $diez);
     		$doce = str_replace("Ñ", "N", $once);
     		$trece = str_replace("Á", "A", $doce);
     		$catorce = str_replace("É", "E", $trece);
     		$quince = str_replace("Í", "I", $catorce);
     		$dieciseis = str_replace("Ó", "O", $quince);
     		$diecisiete = str_replace("Ú", "U", $dieciseis);
     		$dieciocho = str_replace("á", "a", $diecisiete);
     		$diecinueve = str_replace("é", "e", $dieciocho);
     		$venite = str_replace("í", "i", $diecinueve);
     		$veintiunio = str_replace("ó", "o", $venite);
     		$veintidos = str_replace("ú", "u", $veintiunio);
        //$veintitres = str_replace("\\", "", $veintidos);


     		$valor = $veintidos;

     		$final2 = trim($valor);
        $final = preg_replace("[\n|\r|\n\r]", ' ', $final2);

     		return $final;

 	}

    public function savequery($consulta, $event, $data) {

        $this->db = $this->load->database($data, TRUE);

        $consulta = str_replace("'", "", $consulta);

        $query = $this->db->query("update 16_logEventos set query = '$consulta' where idLog = '$event'");
    }

    public function getAllIp() {
        $query = $this->db->query("select * from autorizacion");
        return $query->result_array();
    }

    public function getLastEvent($data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select max(idLog) as ultimo from 16_logEventos");
        return $query->result_array();
    }

    public function saveEvents($event, $user, $fecha, $hora, $ip, $data, $documento = NULL, $dato = NULL, $query = NULL) {
        $this->db = $this->load->database($data, TRUE);

        $this->db->query("insert into 16_logEventos (evento, idUser, fecha, hora, ip, documento, datoanterior, query) values ('$event', '$user', '$fecha', '$hora', '$ip', '$documento', '$dato', '$query')");
    }

    public function bloqueaCliente($doc, $action, $data) {
        $this->db = $this->load->database($data, TRUE);

        $this->db->query("update 10_clientes set idBloqueo = '$action' where documento = AES_ENCRYPT('$doc',  '$this->key');");
    }

    public function activaCuenta($oh, $action, $data) {
        $this->db = $this->load->database($data, TRUE);

        $this->db->query("update 9_creditos set activo = '$action' where obligacion = AES_ENCRYPT('$oh',  '$this->key');");
    }

    public function activaCliente($doc, $data) {
        $this->db = $this->load->database($data, TRUE);

        $this->db->query("update 10_clientes set activo = '1' where documento = AES_ENCRYPT('$doc',  '$this->key');");
    }

    public function getCamposAdici($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 26_camposDinamicos order by idCampos asc ");
        return $query->result_array();
    }

     public function getTotalCalls($ini, $fin, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documentodos from 7_callhist where DATE(fechaGestion) >= '$ini' and DATE(fechaGestion) <= '$fin' order by fechaGestion asc");
        return $query->result_array();
    }

    public function getConfirmacionCodigo($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 2_contacto where idPredictiva = '2';");
        return $query->result_array();
    }

    public function getPromesaCodigo($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 2_contacto where idPredictiva = '1';");
        return $query->result_array();
    }

    public function getMailsPr($pr) {

        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select * from proyecto where descripcion = '$pr';");
        return $query->result_array();
    }

    public function getConfirmacionPagos($contacto, $ini, $fin, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 7_callhist where idContacto in ($contacto) and fechaAcuerdo >= '$ini' and fechaAcuerdo <= '$fin' order by fechaAcuerdo asc");
        return $query->result_array();
    }

    public function getCliente($doc, $data) {

        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 10_clientes where documento = AES_ENCRYPT('$doc',  '$this->key');");
        return $query->result_array();
    }

    public function getObligacionesOh($oh, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from 9_creditos where obligacion = AES_ENCRYPT('$oh',  '$this->key');");
        return $query->result_array();
    }

     public function getObligaciones($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from 9_creditos where documento = AES_ENCRYPT('$doc',  '$this->key');");
        return $query->result_array();
    }

    public function getPagos($fechaIni, $fechaFin, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(identificacion,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from pagos where fecha >= '$fechaIni' and fecha <= '$fechaFin';");
        return $query->result_array();
    }

    public function getPagosFechas($ini, $fin, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(identificacion,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from pagos where fecha >= '$ini' and fecha <= '$fin';");

        return $query->result_array();
    }

    public function getPromesasGeneradas($fecha, $fechafin, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from 6_promesas where fechaCreacion >= '$fecha' and fechaCreacion <= '$fechafin'");
        return $query->result_array();
    }

    public function getPromesasDia($incodigo, $fecha, $fechafin, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from 6_promesas where fechaPromesa >= '$fecha' and fechaPromesa <= '$fechafin' and idCumplido != '3';");
        return $query->result_array();
    }

    public function getTotalClientesCreditos($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select a.*, b.*, AES_DECRYPT(a.documento,  '$this->key') as documentodos, AES_DECRYPT(b.obligacion,  '$this->key') as obligaciondos from 10_clientes a, 9_creditos b where a.documento = b.documento and a.activo = '1' and b.activo = '1';");
        return $query->result_array();
    }

    public function getGrilla($data) {

        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("select * from 25_grilla");
        return $query->result_array();
    }
}

?>
