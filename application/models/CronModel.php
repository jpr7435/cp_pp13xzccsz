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

  public function getSmsAdmin($data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query("select * from 27_admin_sms where idEstado = '1' order by prioridad asc;");
      return $query->result_array();
  }

  public function getSmsDetalle($slug, $data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query("select * from 28_criterios_sms where idtarea = '$slug' order by idcriterio asc;");
      return $query->result_array();
  }

  public function getusuariosall() {

      $this->db = $this->load->database('users', TRUE);

      $query = $this->db->query("select * from usuarios;");
      return $query->result_array();
  }


  public function getProyectos() {

      $this->db = $this->load->database('users', TRUE);

      $query = $this->db->query("select * from proyecto where activo = '1';");
      return $query->result_array();
  }

  public function getSmsUno($slug, $data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query("select * from 27_admin_sms where idEstado = '1' and idtareas = '$slug';");
      return $query->result_array();
  }

  public function truncateCampana($id) {
      $this->db = $this->load->database('sms', TRUE);

      $query = $this->db->query("delete from basedeenvio where idCampana = '$id';");
  }

  public function getDemograClienteConf($doc, $data) {

      $this->db = $this->load->database($data, TRUE);
      $query =  $this->db->query("select telefono from  14_telefonos where documento = AES_ENCRYPT('$doc', '$this->key') and idActivo = '1';");
      return $query->result_array();
  }

  public function insertSmsAdmin($telefono, $campana, $hoy, $documento) {
      $this->db = $this->load->database('sms', TRUE);

      $query = $this->db->query("insert into basedeenvio (numero, idCampana, fechacargue, fechaenvio, enviado, idAsesorCargue, opcion1, opcion2, opcion3, opcion4, documento)
                                  values ('$telefono', '$campana', '$hoy', '0000-00-00 00:00:00', '0', '0', NULL, NULL, NULL, NULL, '$documento') on duplicate key update enviado = '0';");
  }

  public function saveSmsHist($num, $msj) {
      $this->db = $this->load->database('sms', TRUE);

      $this->db->query("insert into sms_hist (numero, mensaje, tipo) values('$num', '$msj', 'Salida');");
  }

  public function getCampanaAuto($fecha, $campana) {

      $this->db = $this->load->database('sms', TRUE);

      $query = $this->db->query("select * from basedeenvio where fechacargue = '$fecha' and idCampana = '$campana' and enviado = '0';");
      return $query->result_array();
  }

  public function getCampanaUno($id) {
      $this->db = $this->load->database('sms', TRUE);

      $query = $this->db->query("select * from campanas where idCampana = '$id';");
      return $query->result_array();
  }

  public function setConsulta($sql, $data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query($sql);
      return $query->result_array();
  }


  public function getGestionTotal($hoy, $anterior) {

    $this->db = $this->load->database('bbva', TRUE);

    $query = $this->db->query("select  AES_DECRYPT(documento,  '$this->key') as documento, idResultado, fechagestion from 7_callhist where date(fechaGestion) >= '$anterior' and date(fechaGestion) <= '$hoy';");
    return $query->result_array();
  }

  public function getBaseCamposUno($numero, $id, $hoy) {
      $this->db = $this->load->database('sms', TRUE);

      $query = $this->db->query("select * from basedeenvio where numero = '$numero' and idCampana = '$id' and fechacargue = '$hoy';");
      return $query->result_array();
  }

  public function setMensaje($numero,$campana, $msj, $hoy) {

      $data = $this->getBaseCamposUno($numero, $campana, $hoy);

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


  public function markSingestion180() {
    $this->db = $this->load->database('bbva', TRUE);
    $query = $this->db->query("update 10_clientes set mejorgestion180 = '0';");
  }

  public function getMejorCl180($doc) {
    $this->db = $this->load->database('bbva', TRUE);
    $query = $this->db->query("select mejorgestion180 from 10_clientes where documento = AES_ENCRYPT('$doc',  '$this->key')");
    return $query->result_array();
  }


  public function getGestionMes($hoy, $inicial) {
    $this->db = $this->load->database('bbva', TRUE);
    $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documentodos from 7_callhist where date(fechaGestion) >= '$inicial' and date(fechaGestion) <= '$hoy';");
    return $query->result_array();
  }

  public function getMejorCl($doc) {
    $this->db = $this->load->database('bbva', TRUE);
    $query = $this->db->query("select idCliente, mejorgestionmes from 10_clientes where documento = AES_ENCRYPT('$doc',  '$this->key')");
    return $query->result_array();
  }

  public function markMejorGestion($doc, $id) {
      $this->db = $this->load->database('bbva', TRUE);
      $query = $this->db->query("update 10_clientes set mejorgestionmes = '$id' where documento = AES_ENCRYPT('$doc',  '$this->key');;");
  }

  public function markMejorGestion180($doc, $id, $fecha) {
    $this->db = $this->load->database('bbva', TRUE);
    $query = $this->db->query("update 10_clientes set mejorgestion180 = '$id', fechamejorgestion180 = '$fecha' where documento = AES_ENCRYPT('$doc',  '$this->key')");
  }

  public function markSingestion() {
    $this->db = $this->load->database('bbva', TRUE);
    $query = $this->db->query("update 10_clientes set mejorgestionmes = '0';");
  }


  public function getNivel($id) {
    $this->db = $this->load->database('bbva', TRUE);
    $query = $this->db->query("select nivel from 4_resultado where idCodres = '$id'");
    return $query->result_array();
  }


  public function getIntesidadDoc($doc) {
    $this->db = $this->load->database('bbva', TRUE);
    $query = $this->db->query("select intesidadmes from 10_clientes where documento = AES_ENCRYPT('$doc',  '$this->key');");
    return $query->result_array();
  }

  public function setIntesidadDoc($doc, $nueva) {
    $this->db = $this->load->database('bbva', TRUE);
    $query = $this->db->query("update 10_clientes set intesidadmes = '$nueva' where documento = AES_ENCRYPT('$doc',  '$this->key');");
  }

  public function resetIntensidad() {
    $this->db = $this->load->database('bbva', TRUE);
    $query = $this->db->query("update 10_clientes set intesidadmes = '0';");
  }

  public function getObligaciones($doc) {

    $this->db = $this->load->database('bbva_especial', TRUE);

    $query = $this->db->query("select *, AES_DECRYPT(obligacion,  '" . $this->key . "') as obligacion from 9_creditos where documento = AES_ENCRYPT('$doc',  '" . $this->key . "');");
    return $query->result_array();
  }

  public function getClienteUno($doc) {

    $this->db = $this->load->database('bbva_especial', TRUE);

    $query = $this->db->query("select * from 10_clientes where documento = AES_ENCRYPT('$doc',  '" . $this->key . "');");
    return $query->result_array();
  }

  public function getTelefonoUno($doc) {

    $this->db = $this->load->database('bbva_especial', TRUE);

    $query = $this->db->query("select * from 14_telefonos where documento = AES_ENCRYPT('$doc',  '" . $this->key . "');");
    return $query->result_array();
  }

  public function getObsCall($oh) {

    $this->db = $this->load->database('bbva_especial', TRUE);

    $query = $this->db->query("select *, AES_DECRYPT(documento,  '" . $this->key . "') as documento from 7_callhist where idCallhist = (select max(idCallhist) as idCallhist from 7_callhist where ohacuerdo = '$oh' and fechaAcuerdo != '-0-');");
    return $query->result_array();
  }

  public function getClientesAprobacion($hoy) {

    $this->db = $this->load->database('bbva_especial', TRUE);

    $query = $this->db->query("select AES_DECRYPT(documento,  '" . $this->key . "') as documento from 7_callhist where idResultado  = '1' and date(fechaGestion) = '$hoy' and revisado = '1' group by documento;");
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

  public function saveGestionDos($documento, $fecha, $hora, $tele, $accion, $contac, $motiv, $resultado, $fecacu, $valor, $txt, $txtgest, $id, $time, $data, $casa) {

      $this->db = $this->load->database($data, TRUE);

      $this->db->query("insert into 7_callhist (documento, fechaGestion, hora, telefono, idAccion, idContacto, idMotivo, idResultado, fechaAcuerdo, vlAcuerdo, complemento, textoGestion, idAsesor, tiempo)"
              . "values (AES_ENCRYPT('$documento',  '$this->key'), '$fecha', '$hora', '$tele', '$accion', '$contac', '$motiv', '$resultado', '$fecacu', '$valor', '$txt', '$txtgest', '$id', '$time');");
  }

}

?>
