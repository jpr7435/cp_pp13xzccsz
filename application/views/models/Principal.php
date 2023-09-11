<?php

/*
 * AES_DECRYPT(documento, 'S1cc0l2017!!')
 *
 * $this -> config -> item('empresa')
 *
 *
 * AES_ENCRYPT('$doc', 'S1cc0l2017!!')
 */

class Principal extends CI_Model {

    private $key;

    public function __construct() {
        $this->key = $this->config->item('encript');
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

    public function buscarxdoc($doc, $event, $data) {

        $this->db = $this->load->database($data, TRUE);

        $consulta = "select *, AES_DECRYPT(documento,  '$this->key') as documento from 10_clientes where documento = AES_ENCRYPT('$doc', '$this->key') and activo = '1'";

        $this->savequery($consulta, $event, $data);

        $query = $this->db->query($consulta);
        return $query->result_array();
    }

    public function buscarxoblig($oh, $event, $data) {

        $this->db = $this->load->database($data, TRUE);

        $consulta = "select a.*, AES_DECRYPT(a.documento,  '$this->key') as documento  from 10_clientes a, 9_creditos b where a.documento = b.documento and b.obligacion = AES_ENCRYPT('$oh', '$this->key') and a.activo = '1'";
        $this->savequery($consulta, $event, $data);
        $query = $this->db->query($consulta);
        return $query->result_array();
    }

    public function getAccionesSelect($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 1_acciones where idAccion > '3' order by idAccion asc");
        return $query->result_array();
    }

    public function buscarxtelpredictivo($tel, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from predictivo where telefono like '%$tel%';");
        return $query->result_array();
    }

    public function buscarxtelpredictivo2($tel, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 14_telefonos where telefono like '%$tel%';");
        return $query->result_array();
    }

    public function buscarxnom($nom, $event, $data) {

        $this->db = $this->load->database($data, TRUE);


        $consulta = "select *, AES_DECRYPT(documento,  '$this->key') as documento from 10_clientes where nombre like '%$nom%' and activo = '1'";

        $this->savequery($consulta, $event, $data);

        $query = $this->db->query($consulta);
        return $query->result_array();
    }

    public function getArchivosCliente($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 20_biblioteca where documento = AES_ENCRYPT('$id',  '$this->key')");
        return $query->result_array();
    }

    public function getActividadCl($data) {

        $this->db = $this->load->database($data, TRUE);

        $consulta = "select * from actividadEconomica order by idActividad asc";
        $query = $this->db->query($consulta);
        return $query->result_array();
    }

    public function getCiudades($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 11_ciudades");
        return $query->result_array();
    }

    public function getCorreos($doc, $tipo, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from mails where documento = AES_ENCRYPT('$doc',  '$this->key') and idActivo = '$tipo'");
        return $query->result_array();
    }

    public function saveCorreos($mail, $doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("insert into mails (email, documento, agregado, idActivo)"
                . "values ('$mail', AES_ENCRYPT('$doc',  '$this->key'), '1', '1') on duplicate key update idActivo = '1' ");
    }

    public function getusuario($id) {

        $this->db = $this->load->database('users', TRUE);

        if ($id == 0) {
            return $data = array("0" => array("nombre" => "Sin Asesor"));
        } else {
            $query = $this->db->query("select * from usuarios where idUsuario = '$id'");
            return $query->result_array();
        }
    }

    public function getTotalPagos($asesor, $data) {

        $this->db = $this->load->database($data, TRUE);
        $fechaIni = date("Y") . "-" . date("m") . "-" . "01";
        $fechaFin = date("Y") . "-" . date("m") . "-" . "31";

        if ($asesor != 0) {
            $query = $this->db->query("select sum(valor) as total from pagos where idAsesor = '$asesor' and fecha >= '$fechaIni' and fecha <= '$fechaFin'");
        } else {
            $query = $this->db->query("select sum(valor) as total from pagos where fecha >= '$fechaIni' and fecha <= '$fechaFin'");
        }


        return $query->result_array();
    }

    public function getTotalPagosList($asesor, $data) {

        $this->db = $this->load->database($data, TRUE);
        $fechaIni = date("Y") . "-" . date("m") . "-" . "01";
        $fechaFin = date("Y") . "-" . date("m") . "-" . "31";

        if ($asesor != 0) {
            $query = $this->db->query("select *, AES_DECRYPT(identificacion,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from pagos where idAsesor = '$asesor' and fecha >= '$fechaIni' and fecha <= '$fechaFin'");
        } else {
            $query = $this->db->query("select *, AES_DECRYPT(identificacion,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from pagos where fecha >= '$fechaIni' and fecha <= '$fechaFin'");
        }


        return $query->result_array();
    }

    public function getDataCliente($id, $event, $data) {

        $this->db = $this->load->database($data, TRUE);

        $consulta = "select *, AES_DECRYPT(documento,  '$this->key') as documento from 10_clientes where idCliente = '$id' and activo = '1'";

        $this->savequery($consulta, $event, $data);

        $query = $this->db->query($consulta);
        return $query->result_array();
    }

    public function getDataClienteDoc($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 10_clientes where documento = AES_ENCRYPT('$id',  '$this->key') and activo = '1'");
        return $query->result_array();
    }

    public function getObligaciones($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from 9_creditos where documento = AES_ENCRYPT('$doc',  '$this->key') and activo = '1'");
        return $query->result_array();
    }

    public function getDataAcuerdoOh($oh, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select pisonegociacion, pagoacuotas, valor_mora_actual from 9_creditos where obligacion = AES_ENCRYPT('$oh',  '$this->key');");
        return $query->result_array();
    }

    public function getAsignacion($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 10_clientes where idAsesor = '$id' and activo = '1'");
        return $query->result_array();
    }

    public function getTelefonos($doc, $tipo, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 14_telefonos where documento = AES_ENCRYPT('$doc',  '$this->key') and idActivo = '$tipo' order by agregado, nivelContacto");
        return $query->result_array();
    }

    public function getDirecciones($doc, $tipo, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 13_direcciones where documento = AES_ENCRYPT('$doc',  '$this->key') and idActivo = '$tipo' order by agregado");
        return $query->result_array();
    }

    public function unactivatetel($idtel, $event, $data) {

        $this->db = $this->load->database($data, TRUE);

        $consulta = "update 14_telefonos set idActivo = '0', nivelContacto = '99' where idTelefono = '$idtel'";

        $this->savequery($consulta, $event, $data);

        $query = $this->db->query($consulta);
    }

    public function activatetel($idtel, $event, $data) {

        $this->db = $this->load->database($data, TRUE);

        $consulta = "update 14_telefonos set idActivo = '1' where idTelefono = '$idtel'";

        $this->savequery($consulta, $event, $data);

        $query = $this->db->query($consulta);
    }

    public function getdoctel($idtel, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select AES_DECRYPT(documento,  '$this->key') as documento from 14_telefonos where idTelefono = '$idtel'");
        return $query->result_array();
    }

    public function saveTelefono($tel, $ciu, $doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("insert into 14_telefonos (telefono, documento, idCiudad, nivelContacto, personaContacto, parentesco, idActivo, agregado)"
                . "values ('$tel', AES_ENCRYPT('$doc',  '$this->key'), '$ciu', '99', '', '', '1', '1') on duplicate key update idActivo = '1' ");
    }

    public function unactivateAcuerdo($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("update 18_acuerdos_pago set idActivo = '0' where documento = AES_ENCRYPT('$doc',  '$this->key')");
    }

    public function getAcuerdo($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 18_acuerdos_pago where idActivo = '1' and documento = AES_ENCRYPT('$doc',  '$this->key')");
        return $query->result_array();
    }

    public function getAcuerdoId($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from 18_acuerdos_pago where idAcuerdo = '$id'");
        return $query->result_array();
    }

    public function insertAcuerdo($doc, $fecha, $valor, $cuotas, $oh, $asesor, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("insert into 18_acuerdos_pago (documento, obligacion, fecha, valor, cuotas, idActivo, idAsesor)"
                . "values (AES_ENCRYPT('$doc',  '$this->key'), AES_ENCRYPT('$oh',  '$this->key'), '$fecha', '$valor', '$cuotas', '1', '$asesor')");
    }

    public function insertDetalleAcuerdo($acu, $cuo, $valor, $fecha, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("insert into 19_detalle_acuerdos (idAcuerdo, cuota, valor, fecha)"
                . "values ($acu, '$cuo', '$valor', '$fecha')");
    }

    public function savebilioteca($doc, $file_name, $file_ext, $fecha, $asesor, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("insert into 20_biblioteca (documento, archivo, extension, fechacargue, idAsesor, nuip)"
                . "values (AES_ENCRYPT('$doc',  '$this->key'), '$file_name', '$file_ext', '$fecha', '$asesor', '$doc')");
    }

    public function unactivatedir($iddir, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("update 13_direcciones set idActivo = '0' where idDireccion = '$iddir'");
    }

    public function activatedir($iddir, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("update 13_direcciones set idActivo = '1' where idDireccion = '$iddir'");
    }

    public function getdocdir($iddir, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select AES_DECRYPT(documento,  '$this->key') as documento from 13_direcciones where idDireccion = '$iddir'");
        return $query->result_array();
    }

    public function saveDireccion($dir, $ciu, $doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("insert into 13_direcciones (direccion, documento, idCiudad, barrio, idActivo, agregado)"
                . "values ('$dir', AES_ENCRYPT('$doc',  '$this->key'), '$ciu', NULL, '1', '1') on duplicate key update idActivo = '1' ");
    }

    public function getAccionesPanel($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 1_acciones where panel = '1'");
        return $query->result_array();
    }

    public function getContactoRelacion($accion, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select idContacto from 5_relacion_codigos where idAccion = '$accion' group by idContacto");
        return $query->result_array();
    }

    public function getAccionUno($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 1_acciones where idAccion = '$id'");
        return $query->result_array();
    }

    public function getContactoUno($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 2_contacto where idContacto = '$id'");
        return $query->result_array();
    }

    public function getResultadoUno($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        if ($id == 0) {
            return $data = array("0" => array("descripcion" => "Sin Resultado"));
        }if ($id == 666) {
            return $data = array("0" => array("descripcion" => "En Gestion"));
        } else {
            $query = $this->db->query("select * from 4_resultado where idCodres = '$id'");
            return $query->result_array();
        }
    }

    public function savePromesas($fecha, $valor, $mespr, $documento, $oh, $data) {

        $this->db = $this->load->database($data, TRUE);

        $this->db->query("insert into 6_promesas (fechaPromesa, valorpromesa, mespromesa, documento, obligacion, idCallhist, idCumplido)"
                . "values ('$fecha', '$valor', '$mespr', AES_ENCRYPT('$documento',  '$this->key'), AES_ENCRYPT('$oh',  '$this->key'), '0', '0')");
    }

    public function getMotivoUno($id, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 3_motivos_no_pago where idMotivo = '$id'");
        return $query->result_array();
    }

    public function getMotivos($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 3_motivos_no_pago order by idMotivo asc");
        return $query->result_array();
    }

    public function getResultadoRelacion($accion, $contacto, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select idResultado from 5_relacion_codigos where idAccion = '$accion' and idContacto = '$contacto' group by idResultado order by idResultado asc");
        return $query->result_array();
    }

    public function buscarxtel($tel, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select a.*, AES_DECRYPT(a.documento,  '$this->key') as documento from 10_clientes a, 14_telefonos b where b.telefono like '%$tel%' and a.documento = b.documento");
        return $query->result_array();
    }

    public function saveGestion($documento, $fecha, $hora, $tele, $accion, $contac, $motiv, $resultado, $ohacu, $fecacu, $valor, $txt, $txtgest, $id, $time, $grabacion, $data) {

        $this->db = $this->load->database($data, TRUE);

        $this->db->query("insert into 7_callhist (documento, fechaGestion, hora, telefono, idAccion, idContacto, idMotivo, idResultado, ohacuerdo, fechaAcuerdo, vlAcuerdo, complemento, textoGestion, idAsesor, tiempo, grabacion)"
                . "values (AES_ENCRYPT('$documento',  '$this->key'), '$fecha', '$hora', '$tele', '$accion', '$contac', '$motiv', '$resultado', '$ohacu', '$fecacu', '$valor', '$txt', '$txtgest', '$id', '$time', '$grabacion')");
    }

    public function getGestion($documento, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 7_callhist where documento = AES_ENCRYPT('$documento',  '$this->key') order by fechaGestion desc");
        return $query->result_array();
    }

    public function getGestionEfectiva($documento, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select a.* from 7_callhist a, 2_contacto b where a.documento = AES_ENCRYPT('$documento',  '$this->key') and a.idContacto = b.idContacto and b.idGrupo = '1' order by fechaGestion desc");
        return $query->result_array();
    }

    public function saveMejorGestion($documento, $resultado, $mejor, $fecha, $data) {

        $this->db = $this->load->database($data, TRUE);

        $this->db->query("update 10_clientes set mejorGestion = '$mejor' where documento = AES_ENCRYPT('$documento',  '$this->key')");
    }

    public function saveActividad($documento, $activ, $data) {

        $this->db = $this->load->database($data, TRUE);

        $this->db->query("update 10_clientes set actividadEconomica = '$activ' where documento = AES_ENCRYPT('$documento',  '$this->key')");
    }

    public function saveUltimaGestion($documento, $resultado, $fecha, $data) {

        $this->db = $this->load->database($data, TRUE);

        $this->db->query("update 10_clientes set ultimaGestion = '$resultado', fecUltimaGestion = '$fecha' where documento = AES_ENCRYPT('$documento',  '$this->key')");
    }

    public function getTelefonoUno($telefono, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 14_telefonos where telefono = '$telefono'");
        return $query->result_array();
    }

    public function saveMejorTelefono($tele, $nivel, $data) {

        $this->db = $this->load->database($data, TRUE);

        $this->db->query("update 14_telefonos set nivelContacto = '$nivel' where telefono = '$tele'");
    }

    public function insertarea($documento, $tarea, $responsable, $data) {

        $this->db = $this->load->database($data, TRUE);

        $this->db->query("insert into 15_tareas (documento, tarea, idResultado, fecha, idAsesor,asignado) values (AES_ENCRYPT('$documento',  '$this->key'), '$tarea', '0', NULL,'0', '$responsable') on duplicate key update tarea = '$tarea';");
    }

    public function getTareasActivasGenerales($id, $data) {
        $this->db = $this->load->database($data, TRUE);

        if ($id < 4) {
            $query = $this->db->query("select tarea, count(documento) as total from 15_tareas group by tarea");
        } else {
            $query = $this->db->query("select tarea, count(documento) as total from 15_tareas where asignado = '0' group by tarea");
        }



        return $query->result_array();
    }

    public function getTareasActivasUsuario($user, $perfil, $data) {
        $this->db = $this->load->database($data, TRUE);

        if ($perfil < 4) {
            $query = $this->db->query("select tarea, count(documento) as total from 15_tareas where asignado != '0' group by tarea");
        } else {
            $query = $this->db->query("select tarea, count(documento) as total from 15_tareas where asignado = '$user' group by tarea");
        }



        return $query->result_array();
    }
    public function getTareasActivas($data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select tarea, count(documento) as total from 15_tareas group by tarea");


        return $query->result_array();
    }

    public function deleteTarea($tarea, $data) {
        $this->db = $this->load->database($data, TRUE);
        $this->db->query("delete from 15_tareas WHERE tarea = '$tarea'");
    }

    public function getNextTarea($tarea, $user, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select AES_DECRYPT(documento,  '$this->key') as documento, idTareas from 15_tareas where idResultado = '0' and tarea = '$tarea' order by idTareas limit 0,1");
        return $query->result_array();
    }

    public function getNextTareaDos($user, $tarea, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select AES_DECRYPT(documento,  '$this->key') as documento, idTareas from 15_tareas where tarea = '$tarea' and idResultado = '666' and idAsesor = '$user' order by idTareas limit 0,1");
        return $query->result_array();
    }

    public function markTarea($id, $user, $data) {
        $this->db = $this->load->database($data, TRUE);

        $this->db->query("update 15_tareas set idResultado = '666', idAsesor = '$user' where idTareas = '$id'");
    }

    public function unsetTarea($documento, $resultado, $fecha, $data) {
        $this->db = $this->load->database($data, TRUE);

        $this->db->query("update 15_tareas set idResultado = '$resultado', fecha = '$fecha' where documento = AES_ENCRYPT('$documento',  '$this->key')");
    }

    public function unsetProgCall($documento, $data) {
        $this->db = $this->load->database($data, TRUE);

        $this->db->query("update 17_programallamadas set estado = '1' where documento = AES_ENCRYPT('$documento',  '$this->key')");
    }

    public function saveProgCall($fec, $id, $doc, $data) {
        $this->db = $this->load->database($data, TRUE);

        $this->db->query("insert into 17_programallamadas (documento, fecha, idAsesor, estado)"
                . "values (AES_ENCRYPT('$doc',  '$this->key'), '$fec', '$id', '0');");
    }

    public function getUserPr($pr) {

        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select idUsuario from usuarios where idProyecto = '$pr' and idEstado < '3'");
        return $query->result_array();
    }

    public function getprogcall($fec, $id, $data) {
        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 17_programallamadas where fecha < '$fec' and idAsesor = '$id' and estado = '0'");
        return $query->result_array();
    }

    public function getTotalClientes($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select AES_DECRYPT(documento,  '$this->key') as documento, nombre, saldoPareto, idAsesor, mejorGestion, ultimaGestion, FecUltimaGestion from 10_clientes where activo = '1'");
        return $query->result_array();
    }

    public function getTotalCalls($ini, $fin, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documentodos from 7_callhist where DATE(fechaGestion) >= '$ini' and DATE(fechaGestion) <= '$fin' order by fechaGestion asc");
        return $query->result_array();
    }

    public function markasignacion($documento, $usuario, $data) {
        $this->db = $this->load->database($data, TRUE);

        $this->db->query("update 10_clientes set idAsesor = '$usuario' where documento = AES_ENCRYPT('$documento',  '$this->key')");
    }

    public function getasignaciontable($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select idAsesor, count(documento) as cuantos from 10_clientes group by idAsesor");
        return $query->result_array();
    }

    public function getProductividadHoy($hoy, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select AES_DECRYPT(documento,  '$this->key') as documento, idAsesor, fechaGestion, idAccion, idContacto, idResultado from 7_callhist where date(fechaGestion) = '$hoy'");
        return $query->result_array();
    }

    public function getProductividadHoyUser($hoy, $asesor, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select count(documento) as productividad from 7_callhist where date(fechaGestion) = '$hoy' and idAsesor = '$asesor'");
        return $query->result_array();
    }

    public function getEventos($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select * from 16_logEventos where documento = '$doc' order by idLog desc");
        return $query->result_array();
    }

    public function getEstadoCartera($asesor, $hoy, $data) {

        $this->db = $this->load->database($data, TRUE);
        if ($asesor == 0) {

            $query = $this->db->query("select idResultado, count(documento) as cuantos from 7_callhist where date(fechaGestion) = '$hoy' group by idResultado");
        } else {
            $query = $this->db->query("select idResultado, count(documento) as cuantos from 7_callhist where date(fechaGestion) = '$hoy' and idAsesor = '$asesor' group by idResultado");
        }

        return $query->result_array();
    }

    public function getResultadoTarea($tarea, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select idResultado, count(documento) as cuantos from 15_tareas where tarea = '$tarea' group by idResultado");

        return $query->result_array();
    }

    public function getPagos($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(identificacion,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from pagos where identificacion = AES_ENCRYPT('$doc',  '$this->key')");

        return $query->result_array();
    }

    public function getReferencias($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from referencias where documento = AES_ENCRYPT('$doc', '$this->key')");

        return $query->result_array();
    }

    public function getAcuerdos($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from 18_acuerdos_pago where documento = AES_ENCRYPT('$doc',  '$this->key') order by idAcuerdo desc");

        return $query->result_array();
    }

}

?>
