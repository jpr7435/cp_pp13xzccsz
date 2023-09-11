<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Vista extends CI_Model {

    private $key;

    public function __construct() {
        $this->key = $this->config->item('encript');
    }

    public function getKey() {
        return $this->key;
    }

    public function getMesInfo($id, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from meses where idMes = '$id'");
        $datos = $query->result_array();
        return $datos;
    }

    public function getProyectData($id) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select * from proyecto where idProyecto = '$id'");
        $data = $query->result_array();

        return $data;
    }

    public function getRegistrosCampanaSMS($id) {
        $this->db = $this->load->database('sms', TRUE);

        $query = $this->db->query("select count(idEnvio) as total from basedeenvio where idCampana = '$id' group by idCampana;");
        $data = $query->result_array();

        return $data;
    }

    public function getPausasList() {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select * from pausas order by idPausa asc");
        $data = $query->result_array();

        return $data;
    }

    public function getplazos($linea, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 31_codigocreditos where linea = '$linea';");
        $data = $query->result_array();

        return $data;
    }

    public function getCobranzasEvent($id, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("SELECT * FROM 16_logEventos WHERE idLog = '$id';");
        $data = $query->result_array();

        return $data;
    }

    public function getPerfilName($id) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select * from perfiles where idPerfil = '$id'");
        $data = $query->result_array();

        return $data;
    }
    public function getLastevent($id, $hoy, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("SELECT max(idLog) as evento FROM 16_logEventos WHERE idUser = '$id' and date(fecha) = '$hoy';");
        $data = $query->result_array();

        return $data;
    }

    public function getDeslogeo($id, $hoy) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("SELECT max(idEvento) as evento FROM log_eventos WHERE idUsuario = '$id' and date(fecha) = '$hoy'");
        $data = $query->result_array();

        return $data;
    }

    public function getusuario($id) {

        $this->db = $this->load->database('users', TRUE);

        if ($id == 0) {
            return $data = array("0" => array("usuario" => "Sin Asesor"));
        } else {
            $query = $this->db->query("select * from usuarios where idUsuario = '$id'");
            return $query->result_array();
        }
    }
    public function getEventoLogeo($id, $hoy) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("SELECT min(idEvento) as evento FROM log_eventos WHERE idUsuario = '$id' and date(fecha) = '$hoy';");
        $data = $query->result_array();

        return $data;
    }

    public function getEvento($id) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("SELECT * FROM log_eventos WHERE idEvento = '$id';");
        $data = $query->result_array();

        return $data;
    }

    public function getAccion($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        if ($id == 0) {
            return $data = array("0" => array("descripcion" => "Sin Accion", "homologacion", "0000"));
        } else {
            $query = $this->db->query("select * from 1_acciones where idAccion = '$id'");
            return $query->result_array();
        }
    }

    public function getContacto($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        if ($id == 0) {
            return $data = array("0" => array("descripcion" => "Sin Contacto", "homologacion", "0000"));
        } else {
            $query = $this->db->query("select * from 2_contacto where idContacto = '$id'");
            return $query->result_array();
        }
    }

    public function getAcelerado($oh, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select date_defined6, number_defined5, char_defined6 from marcasObligacion where obligacion = AES_ENCRYPT('$oh',  '$this->key')");
        return $query->result_array();
    }

    public function getResultado($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        if ($id == 0) {
            return $data = array("0" => array("descripcion" => "Sin Resultado", "homologacion", "0000"));
        } else {
            $query = $this->db->query("select * from 4_resultado where idCodres = '$id'");
            return $query->result_array();
        }
    }

    public function getMotivo($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        if ($id == 0) {
            return $data = array("0" => array("descripcion" => "Sin Motivo", "homologacion", "0000"));
        } else {
            $query = $this->db->query("select * from 3_motivos_no_pago where idMotivo = '$id'");
            return $query->result_array();
        }
    }

    public function getGruposContacto($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 2_grupos_contacto");
        return $query->result_array();
    }

    public function getObligaciones($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select AES_DECRYPT(obligacion,  '$this->key') as obligacion, centrogestor, gestor, ciudad from 9_creditos where documento = AES_ENCRYPT('$doc',  '" . $this->key . "')");

        return $query->result_array();
    }

    public function getGruposContactoUno($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 2_grupos_contacto where idGrupo = '$id'");
        return $query->result_array();
    }

    public function getTareasActivasFaltan($tarea, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("select count(documento) as faltan from 15_tareas where tarea = '$tarea' and idResultado = '0' group by tarea");
        return $query->result_array();
    }

    public function getExtracto($doc, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("select * from 30_extractos where documento = '$doc' order by idExtracto desc");
        return $query->result_array();
    }

    public function getCallCedula($documento, $fechaini, $fechafin, $data) {
        $this->db = $this->load->database($data, TRUE);

        $fechaini = $fechaini . " 01:00:00";
        $fechafin = $fechafin . " 24:00:00";

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 7_callhist where fechaGestion > '$fechaini' and fechaGestion < '$fechafin' and documento = AES_ENCRYPT('$documento',  '$this->key') and idContacto <> '11' order by fechaGestion desc;", TRUE);
        return $query->result_array();
    }

    public function getCallId($id, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 7_callhist where  idCallhist = '$id'", TRUE);
        return $query->result_array();
    }

    public function getTotalClientes($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select AES_DECRYPT(documento,  '$this->key') as documento, nombre, saldoPareto, idAsesor, mejorGestion, ultimaGestion, FecUltimaGestion, AES_DECRYPT(documento,  '$this->key') as documento2, mejorGestion as mej2, mejorGestion as mej3, mejorGestion as mej4   from 10_clientes where activo = '1'");
        return $query->result_array();
    }

    public function getTotalCalls($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select count(idCallhist) as total from 7_callhist where documento = AES_ENCRYPT('$doc',  '$this->key') group by documento");
        return $query->result_array();
    }

    public function getEfectividad($usuario, $hoy, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select count(documento) as efectividad from 7_callhist where date(fechaGestion) = '$hoy' and idAsesor = '$usuario' and idContacto < '4'");
        return $query->result_array();
    }

    public function getUltimaPromesa($doc, $res, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select max(idCallhist) as id from 7_callhist where idResultado = '$res' and documento = AES_ENCRYPT('$doc',  '$this->key');");
        return $query->result_array();
    }

    public function getProduchora($hora, $hoy, $asesor, $data) {

        $this->db = $this->load->database($data, TRUE);
        if ($asesor == 0) {
            $query = $this->db->query("select count(documento) as productividad from 7_callhist where date(fechaGestion) = '$hoy' and hora = '$hora'");
        } else {
            $query = $this->db->query("select count(documento) as productividad from 7_callhist where date(fechaGestion) = '$hoy' and hora = '$hora' and idAsesor ='$asesor'");
        }

        return $query->result_array();
    }
    public function getMetas($id) {

        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select metaproductividad, metaClientes, metaContactos, metaAcuerdos from usuarios where idUsuario = '$id'");
        return $query->result_array();
    }

    public function getEfectividadhora($hora, $hoy, $asesor, $data) {

        $this->db = $this->load->database($data, TRUE);

        if ($asesor == 0) {
            $query = $this->db->query("select count(documento) as efectividad from 7_callhist where date(fechaGestion) = '$hoy' and hora = '$hora' and idContacto < '4'");
        } else {
            $query = $this->db->query("select count(documento) as efectividad from 7_callhist where date(fechaGestion) = '$hoy' and hora = '$hora' and idAsesor ='$asesor' and idContacto < '4'");
        }

        return $query->result_array();
    }

    public function getFocalizacion($fo, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("select descripcion from nemotecnia where nemotecnico = '$fo'");
        return $query->result_array();
    }
    public function getMorosidad($oh, $data) {

        $this->db = $this->load->database($data, TRUE);
        //echo "select *, AES_DECRYPT(obligacion,  '$this->key') as obligacion from morosidad_edades where obligacion = AES_ENCRYPT('$oh',  '$this->key') order by edadMora asc";//

        $query = $this->db->query("select *, AES_DECRYPT(obligacion,  '$this->key') as obligacion from morosidad_edades where obligacion = AES_ENCRYPT('$oh',  '$this->key') order by edadMora asc");

        return $query->result_array();
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

}
