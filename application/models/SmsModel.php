<?php

/*
* AES_DECRYPT(documento, 'S1cc0l2017!!')
*
* $this -> config -> item('empresa')
*
*
* AES_ENCRYPT('$doc', 'S1cc0l2017!!')
*/

class SmsModel extends CI_Model {

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

  public function getCampanas() {
    $this->db = $this->load->database('sms', TRUE);

    $query = $this->db->query("select * from campanas order by idCampana desc;");
    return $query->result_array();
  }

  public function getRespuestasCampana($id) {
    $this->db = $this->load->database('sms', TRUE);

    $query = $this->db->query("select * from respuestas where idCampana = '$id' order by idRespuestas asc;");
    return $query->result_array();
  }

  public function getBaseCamposUno($id) {
    $this->db = $this->load->database('sms', TRUE);
    $query = $this->db->query("select * from basedeenvio where idCampana = '$id' limit 0,1;");
    return $query->result_array();
  }

  public function setMensaje($msj,$campana) {

    $data = $this->SmsModel->getBaseCamposUno($campana);

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

  public function saveMsg($msg, $campa) {
    $this->db = $this->load->database('sms', TRUE);

    $query = $this->db->query("update campanas set mensaje = '$msg' where idCampana = '$campa';");
  }

  public function getCampanaUno($id) {
    $this->db = $this->load->database('sms', TRUE);

    $query = $this->db->query("select * from campanas where idCampana = '$id';");
    return $query->result_array();
  }

  public function getBaseEnvio($id) {
    $this->db = $this->load->database('sms', TRUE);

    $query = $this->db->query("select * from basedeenvio where idCampana = '$id' order by idCampana asc;");
    $data = $query->result_array();

    return $data;
  }

  public function insertConversacion($tele, $fecha, $data) {
    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("insert into conversaciones (idusuario, usuario, nombre, documento, telefono, fecha, idestado, actividad) values ('0', NULL, NULL, NULL, '$tele', '$fecha', '0', '0') on duplicate key update actividad = '1';");
  }

  public function insertMensaje($id, $origen, $tele, $txt, $iduser, $fecha, $data) {
    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("insert into mensajes (idconversacion, numero, mensaje, idenviado, idusuarioenvia, fechahora, media) values ('$id', '$origen', '$txt', '0', '$iduser', '$fecha', NULL);");
  }


  public function saveGestionDos($documento, $fecha, $hora, $tele, $accion, $contac, $motiv, $resultado, $fecacu, $valor, $txt, $txtgest, $id, $time, $data, $casa) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("insert into 7_callhist (documento, fechaGestion, hora, telefono, idAccion, idContacto, idMotivo, idResultado, fechaAcuerdo, vlAcuerdo, complemento, textoGestion, idAsesor, tiempo)"
    . "values (AES_ENCRYPT('$documento',  '$this->key'), '$fecha', '$hora', '$tele', '$accion', '$contac', '$motiv', '$resultado', '$fecacu', '$valor', '$txt', '$txtgest', '$id', '$time');");
  }

  public function getConversacion($tele, $data) {
    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from conversaciones where telefono = '$tele';");
    return $query->result_array();
  }

  public function getCallId($id) {
    $this->db = $this->load->database('sms', TRUE);

    $query = $this->db->query("select * from cdr where calldate = '$id'");
    return $query->result_array();
  }

  public function saveCampana($nombre, $desc, $id, $fecha) {
    $this->db = $this->load->database('sms', TRUE);

    $this->db->query("insert into campanas (campana, concepto, idUsuario, fechaCreacion)"
    . "value ('$nombre', '$desc', '$id', '$fecha');");
  }

  public function saveRespuesta($codigo, $mensaje, $campana) {
    $this->db = $this->load->database('sms', TRUE);

    $this->db->query("insert into respuestas (idCampana, codigo, mensaje)"
    . "value ('$campana', '$codigo', '$mensaje');");
  }

  public function uploadBase($numero, $documento, $opcion1, $opcion2, $opcion3, $opcion4, $fecha, $usuario, $campana) {
    $this->db = $this->load->database('sms', TRUE);

    $this->db->query("insert into basedeenvio (numero, idCampana, fechacargue, idAsesorCargue, opcion1, opcion2, opcion3, opcion4, documento)"
    . "value ('$numero', '$campana', '$fecha', '$usuario', '$opcion1', '$opcion2', '$opcion3', '$opcion4', $documento);");
  }

  public function getTotalInformeAbandonadas($fechaIni, $fechaFin) {
    $this->db = $this->load->database('sms', TRUE);

    $query = $this->db->query("select * from call_entry where status = 'abandonada' and date(datetime_entry_queue) >= '$fechaIni' and date(datetime_entry_queue) <= '$fechaFin'");
    return $query->result_array();
  }

}

?>
