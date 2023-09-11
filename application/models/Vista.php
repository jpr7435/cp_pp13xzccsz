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

    public function getCampanaUno($id) {
        $this->db = $this->load->database('sms', TRUE);

        $query = $this->db->query("select * from campanas where idCampana = '$id';");
        return $query->result_array();
    }

    public function getpromesaCallhist($id, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("select * from 6_promesas where idCallhist = '$id';");
        return $query->result_array();
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

    public function getTemplatesList($data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 31_templates");
        $data = $query->result_array();

        return $data;
    }



    public function getplazos($linea, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 31_codigocreditos where linea = '$linea';");
        $data = $query->result_array();

        return $data;
    }




    public function createObligacion($data) {
        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("update feedbacklocal set obligacion = RPAD(concat('0013',radicado),'40',' ');");
    }

    public function borraFeedbackTemp1($data) {
        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("truncate table feedbacklocal_temp1;");
    }

    public function borraFeedbackTemp2($data) {
        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("truncate table feedbacklocal_temp2;");
    }

    public function descriptDoc($data) {
        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("update feedbacklocal_temp0 set documento2 = AES_DECRYPT(documento, '$this->key');");
    }


    
    public function createMemo($data) {

        $this->db = $this->load->database($data, TRUE);
        $this->db->query("update feedbacklocal a set a.memo = (SELECT group_concat(concat('Fecha: ', fechaGestion, ' Telefono: ', telefono, ' Gestion: ', textoGestion) ORDER BY fechaGestion desc SEPARATOR '//') FROM feedbacklocal_temp0 where a.nuip = feedbacklocal_temp0.documento2 GROUP BY documento2);", TRUE);
        $this->db->query("update feedbacklocal set memo=REPLACE(REPLACE(REPLACE(memo,CHAR(9),''),CHAR(10),''),CHAR(13),'');", TRUE);
    }


    public function createFeedbackTemp1($fechaini, $fechafin, $data) {
        $this->db = $this->load->database($data, TRUE);
        $fechaini = $fechaini." 00:00:00";
        $fechafin = $fechafin." 23:00:00";
        $this->db->query("insert into feedbacklocal_temp1 (nivelminimo, documento) select min(nivel), documento2 from feedbacklocal_temp0 group by documento;");
    }

    public function createfeedbackTempDos($fechaini, $fechafin, $data) {
        $this->db = $this->load->database($data, TRUE);
        $fechaini = $fechaini." 00:00:00";
        $fechafin = $fechafin." 23:00:00";

        $this->db->query("insert into feedbacklocal_temp2 (documento, idcallhist) (select b.documento2, max(b.idCallhist) from feedbacklocal_temp1 a, feedbacklocal_temp0 b where a.documento = b.documento2 and b.nivel = a.nivelminimo group by b.documento2);");
    }


    public function insertFeedbackObli($doc, $oh, $oh2, $data) {
        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("insert into feedbacklocal (obligacion, nuip, radicado) values ('$oh2', '$doc', '$oh');");
    }

    public function updateFeedbackResultado($data) {
        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("update feedbacklocal a set a.resultado = (select d.homologacion from 7_callhist b, feedbacklocal_temp2 c, 4_resultado d where b.idCallhist = c.idcallhist and b.idResultado = d.idCodres and a.nuip = c.documento);");
    }

    public function updateFeedbackContacto($data) {
        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("update feedbacklocal a set a.contacto = (select d.homologacion from 7_callhist b, feedbacklocal_temp2 c, 2_contacto d where b.idCallhist = c.idcallhist and b.idContacto = d.idContacto and a.nuip = c.documento);");
    }

    public function updateFeedbackMotivo($data) {
        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("update feedbacklocal a set a.motivo = (select d.homologacion from 7_callhist b, feedbacklocal_temp2 c, 3_motivos_no_pago d where b.idCallhist = c.idcallhist and b.idMotivo = d.idMotivo and a.nuip = c.documento);");
        $this->db->query("update feedbacklocal set motivo =  '0000' where motivo is null;");
    }

    public function updateFechaGestion($data) {
        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("update feedbacklocal a set a.fechagestion = (select replace(replace(b.fechaGestion, ' ', '-'), ':', '.') from 7_callhist b, feedbacklocal_temp2 c where b.idCallhist = c.idcallhist and a.nuip = c.documento);");
        
    }

    public function updateFechaPromesa($data) {
        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("update feedbacklocal a set a.fechapromesa = (select b.fechaAcuerdo from 7_callhist b, feedbacklocal_temp2 c where b.fechaAcuerdo != '0000-00-00' and b.idCallhist = c.idcallhist and a.nuip = c.documento);");
        $this->db->query("update feedbacklocal set fechapromesa = '0001-01-01' where fechapromesa = '';");
    }

    public function updateValorPromesa($data) {
        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("update feedbacklocal a set a.vlpromesa = (select b.vlAcuerdo from 7_callhist b, feedbacklocal_temp2 c where b.vlAcuerdo != '0' and b.idCallhist = c.idcallhist and a.nuip = c.documento);");
        $this->db->query("update feedbacklocal set vlpromesa = '00,0' where vlpromesa = '';");
    }
    public function updateValores($data) {
        $this->db = $this->load->database($data, TRUE);
        
        $this->db->query("update feedbacklocal set vlpromesa = rpad(vlpromesa, 19, ' '), importe1 = rpad(importe1, 19, ' '), importe2 = rpad(importe2, 19, ' '), costogestion = rpad(costogestion, 19, ' '), direccion = rpad(direccion, 200, ' '), ciudaddireccion = rpad(ciudaddireccion, 100, ' ');");
    }

    public function updateCentroGestor($data) {
        $this->db = $this->load->database($data, TRUE);
        
        $this->db->query("update feedbacklocal a, 9_creditos b set a.centrogestor = b.centrogestor, a.ciudaddireccion = b.ciudad where a.radicado = AES_DECRYPT(b.obligacion,  '$this->key');");
        $this->db->query("update feedbacklocal  set centrogestor = lpad(centrogestor, 4, '0');");
    }


    public function getGestionesTotales($fechaini, $fechafin, $data) {
        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("select a.*, AES_DECRYPT(a.documento,  '$this->key') as documento2 from 7_callhist a, feedbacklocal b where AES_DECRYPT(a.documento,  '$this->key') = b.nuip and a.fechaGestion >= '$fechaini' and  a.fechaGestion <='$fechafin' and a.idContacto <> '11';");
        return $query->result_array();
    }

    public function getFeedback($data) {
        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("select * from feedbacklocal;");
        return $query->result_array();
    }



    public function getCobranzasEvent($id, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("SELECT * FROM 16_logEventos WHERE idLog = '$id'");
        $data = $query->result_array();

        return $data;
    }

    public function getClientesHoy($fecha, $id, $data) {
        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("select min(idContacto) as idContacto, fechaGestion from 7_callhist WHERE idAsesor = '$id' and date(fechaGestion) = '$fecha' group by documento order by idCallhist asc;");
        $data = $query->result_array();

        return $data;
    }

    public function getResultadosTotales($data) {
        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("select * from 4_resultado;");
        $data = $query->result_array();

        return $data;
    }

    public function getContactosTotales($data) {
        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("select * from 2_contacto;");
        $data = $query->result_array();

        return $data;
    }

    public function getMotivosTotales($data) {
        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("select * from 3_motivos_no_pago;");
        $data = $query->result_array();

        return $data;
    }

    public function updateMejorData($radicado, $mejorResult, $mejorContacto, $mejorMotivo, $fechaMejor, $data) {
        $this->db = $this->load->database($data, TRUE);
        $query = $this->db->query("update feedbacklocal set resultado = '$mejorResult', contacto = '$mejorContacto', motivo = '$mejorMotivo', fechagestion = '$fechaMejor' where radicado = '$radicado';");
    }

    public function getPerfilName($id) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select * from perfiles where idPerfil = '$id'");
        $data = $query->result_array();

        return $data;
    }
    public function getLastevent($id, $hoy, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("SELECT max(idLog) as evento FROM 16_logEventos WHERE idUser = '$id' and fecha = '$hoy'");
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

  public function getlocalizacion($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from localizacion where activo = '1'");
    $data = $query->result_array();
  
    return $data;
  
  }


    public function getEventoLogeo($id, $hoy) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("SELECT min(idEvento) as evento FROM log_eventos WHERE idUsuario = '$id' and date(fecha) = '$hoy'");
        $data = $query->result_array();

        return $data;
    }

    public function getDataClienteDoc($id, $data) {

        $this->db = $this->load->database($data, TRUE);
    
        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 10_clientes where documento = AES_ENCRYPT('$id',  '$this->key') and activo = '1'");
        return $query->result_array();
      }

    public function getEvento($id) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("SELECT * FROM log_eventos WHERE idEvento = '$id'");
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

        $query = $this->db->query("select *, AES_DECRYPT(obligacion,  '$this->key') as obligacion from 9_creditos where documento = AES_ENCRYPT('$doc',  '" . $this->key . "')");

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

    public function getDataCliente($doc, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("select * from 10_clientes where documento = AES_ENCRYPT('$doc',  '$this->key');");
        return $query->result_array();
    }

    public function getDataClientes($database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 10_clientes;");
        return $query->result_array();
    }

    public function getCallCedula($documento, $fechaini, $fechafin, $data) {
        $this->db = $this->load->database($data, TRUE);
        $fechaini = $fechaini." "."00:00:00";
        $fechafin = $fechafin." "."23:00:00";

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 7_callhist where fechaGestion >= '$fechaini' and  fechaGestion <='$fechafin' and documento = AES_ENCRYPT('$documento',  '$this->key') and idContacto <> '11' order by fechaGestion desc;", TRUE);
        return $query->result_array();
    }

    public function getCallId($id, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 7_callhist where  idCallhist = '$id';", TRUE);
        return $query->result_array();
    }

    public function getMejorCall($id, $doc, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 7_callhist where idCallhist = (select max(idCallhist) from 7_callhist where idResultado = '$id' and documento = AES_ENCRYPT('$doc',  '$this->key'));", TRUE);
        return $query->result_array();
    }

    public function getTotalClientes($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select AES_DECRYPT(documento,  '$this->key') as documento, nombre, saldoPareto, idAsesor, mejorGestion, ultimaGestion, FecUltimaGestion, AES_DECRYPT(documento,  '$this->key') as documento2, mejorGestion as mej2, mejorGestion as mej3, mejorGestion as mej4   from 10_clientes where activo = '1'");
        return $query->result_array();
    }

    
  public function getGestionJudicial($documento, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 7_callhist where documento = AES_ENCRYPT('$documento',  '$this->key') and idResultado > '99' order by fechaGestion desc;");
    return $query->result_array();
  }

    public function getTotalCalls($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select count(idCallhist) as total from 7_callhist where documento = AES_ENCRYPT('$doc',  '$this->key') group by documento");
        return $query->result_array();
    }

    public function getLastCall($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select textoGestion, idMotivo, idResultado, actividad from 7_callhist where idCallhist = (select max(idCallhist) from 7_callhist where documento = AES_ENCRYPT('$doc',  '$this->key'));");
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

    public function getTelefonos($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 14_telefonos where documento = AES_ENCRYPT('$doc',  '$this->key');");
        return $query->result_array();
    }

    public function getDirecciones($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 13_direcciones where documento = AES_ENCRYPT('$doc',  '$this->key');");
        return $query->result_array();
    }

    public function getEmails($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from mails where documento = AES_ENCRYPT('$doc',  '$this->key');");
        return $query->result_array();
    }

    public function getEmailsAll($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from mails;");
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

    public function getActividad($act, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from actividadEconomica where homologacion = '$act';");
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

     public function getRecaudoMia($asesor, $data) {

        $this->db = $this->load->database($data, TRUE);
        $fechaIni = date("Y") . "-" . date("m") . "-" . "01";
        $fechaFin = date("Y") . "-" . date("m") . "-" . "31";
    
        if ($asesor != 0) {
          $query = $this->db->query("select sum(valor_banco) as total from pagos where idAsesor = '$asesor' and fecha >= '$fechaIni' and fecha <= '$fechaFin';");
        } else {
          $query = $this->db->query("select sum(valor_banco) as total from pagos where fecha >= '$fechaIni' and fecha <= '$fechaFin';");
        }
    
    
        return $query->result_array();
      }



}
