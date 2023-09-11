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

    public function getAllIp() {
        $query = $this->db->query("select * from autorizacion");
        return $query->result_array();
    }

    public function getTelefonos($doc) {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 14_telefonos where documento = AES_ENCRYPT('$doc',  '$this->key') and idActivo = '1' order by agregado, nivelContacto");
        return $query->result_array();
    }

    public function markSingestion() {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("update 10_clientes set mejorGestion = '0'");

    }

    public function markMejorGestion($doc, $id) {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("update 10_clientes set mejorGestion = '$id' where documento = AES_ENCRYPT('$doc',  '$this->key')");

    }

    public function markSingestion60() {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("update 10_clientes set mejorGestion60 = '0'");

    }

    public function markMejorGestion60($doc, $id) {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("update 10_clientes set mejorGestion60 = '$id' where documento = AES_ENCRYPT('$doc',  '$this->key')");

    }

    public function resetIntensidad() {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("update 10_clientes set intensidad = '0';");

    }

    public function setIntesidadDoc($doc, $nueva) {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("update 10_clientes set intensidad = '$nueva' where documento = AES_ENCRYPT('$doc',  '$this->key');");

    }

    public function dropCampanaDos() {

        $this->db = $this->load->database('sms', TRUE);

        $query = $this->db->query("delete from basedeenvio where idCampana ='2';");

    }

    public function insertCampanaDos($doc, $tel, $fecha) {

        $this->db = $this->load->database('sms', TRUE);

        $query = $this->db->query("insert into basedeenvio (numero, idCampana, fechacargue, fechaenvio, enviado, idAsesorCargue, opcion1, opcion2, opcion3, opcion4, documento)
                                                    values ('$tel', '2', '$fecha', '0', '0', '0', NULL, NULL, NULL, NULL, '$doc') on duplicate key update fechacargue = '$fecha';");

    }

    public function getCampanaDos($fecha) {

        $this->db = $this->load->database('sms', TRUE);

        $query = $this->db->query("select * from basedeenvio where fechacargue = '$fecha' and idCampana = '2' and enviado = '0';");
        return $query->result_array();
    }

    public function getIntesidadDoc($doc) {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("select intensidad from 10_clientes where documento = AES_ENCRYPT('$doc',  '$this->key');");
        return $query->result_array();
    }

    public function saveGestion($documento, $fecha, $hora, $tele, $accion, $contac, $motiv, $resultado, $fecacu, $valor, $txt, $txtgest, $id, $time, $data, $casa) {

        $this->db = $this->load->database($data, TRUE);

        $this->db->query("insert into 7_callhist (documento, fechaGestion, hora, telefono, idAccion, idContacto, idMotivo, idResultado, fechaAcuerdo, vlAcuerdo, complemento, textoGestion, idAsesor, tiempo, proyecto, idcasa)"
                . "values (AES_ENCRYPT('$documento',  '$this->key'), '$fecha', '$hora', '$tele', '$accion', '$contac', '$motiv', '$resultado', '$fecacu', '$valor', '$txt', '$txtgest', '$id', '$time', '$data', '$casa')");
    }

    public function getDesembolsoCreditos($fecha) {

        $this->db = $this->load->database('cobranzas', TRUE);
        //echo "select  AES_DECRYPT(documento,  '$this->key') as documento from 9_cobranzas where date(fechadesembolso) = '$fecha' and numero_novaciones = '0' and estadocredito = 'Desembolsado';";

        $query = $this->db->query("select  AES_DECRYPT(documento,  '$this->key') as documento from 9_cobranzas where date(fechadesembolso) = '$fecha' and numero_novaciones = '0' and estadocredito = 'Desembolsado';");
        return $query->result_array();
    }

    public function getMejorCl($doc) {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("select mejorGestion from 10_clientes where documento = AES_ENCRYPT('$doc',  '$this->key')");
        return $query->result_array();
    }

    public function getMejorCl60($doc) {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("select mejorGestion60 from 10_clientes where documento = AES_ENCRYPT('$doc',  '$this->key')");
        return $query->result_array();
    }

    public function getGestionMes($hoy, $inicial) {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documentodos from 7_callhist where date(fechaGestion) >= '$inicial' and date(fechaGestion) <= '$hoy';");
        return $query->result_array();
    }

    public function getNivel($id) {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("select nivel from 4_resultado where idCodres = '$id'");
        return $query->result_array();
    }

    public function getGestionTotal($hoy, $anterior) {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("select  AES_DECRYPT(documento,  '$this->key') as documento, idResultado from 7_callhist where date(fechaGestion) >= '$anterior' and date(fechaGestion) <= '$hoy';");
        return $query->result_array();
    }

    public function getPromesasPendientes() {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("select  * from 6_promesas where idCumplido = '1';");
        return $query->result_array();
    }

    public function markIncumplida($id) {

        $this->db = $this->load->database('cobranzas', TRUE);

        $query = $this->db->query("update 6_promesas set idCumplido = '4' where idPromesa = '$id';");

    }

    public function buscarxdoc($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 10_clientes where documento = AES_ENCRYPT('$doc', '$this->key')");
        return $query->result_array();
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

    public function saveSmsHist($num, $msj) {
        $this->db = $this->load->database('sms', TRUE);

        $this->db->query("insert into sms_hist (numero, mensaje, tipo) values('$num', '$msj', 'Salida');");
    }

    public function getCampanaUno($id) {
        $this->db = $this->load->database('sms', TRUE);

        $query = $this->db->query("select * from campanas where idCampana = '$id';");
        return $query->result_array();
    }


}

?>
