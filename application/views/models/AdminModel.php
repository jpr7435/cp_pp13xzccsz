<?php

/*
 * AES_DECRYPT(documento, 'S1cc0l2017!!')
 *
 * $this -> config -> item('empresa')
 *
 *
 * AES_ENCRYPT('$doc', 'S1cc0l2017!!')
 */

class AdminModel extends CI_Model {

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

    public function getUserProyecto($pr) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select * from permisosespeciales where carteras like '%$pr%' order by idUsuario asc");
        return $query->result_array();
    }

    public function getUsersAdmin($pr) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select * from usuarios where idPerfil < '6' order by idUsuario asc;");
        return $query->result_array();
    }

    public function getCamposCreditos($pr) {
        $this->db = $this->load->database($pr, TRUE);

        $query = $this->db->query("describe 9_creditos;");
        return $query->result_array();
    }

    public function getProyectData($pr) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select * from proyecto where descripcion = '$pr';");
        return $query->result_array();
    }

    public function saveMeta($user, $proy, $valor, $mes) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("insert into metas_campanas (idProyecto, idUsuario, valor, mes) values ('$proy', '$user', '$valor', '$mes') on duplicate key update valor = '$valor';");

    }

    public function updateAdicionales($pr, $meta, $coordi, $saldo, $campoproducto, $campoEmails, $dui, $nit, $salario, $empresa, $slmora, $slcapital, $fecotor, $fecsepara, $fup, $vup, $var1, $var2, $var3, $var4) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("update proyecto set meta = '$meta', idCoordinador = '$coordi', campoSaldo = '$saldo', campoProducto = '$campoproducto', campoEmails = '$campoEmails', campoDUI = '$dui', campoNit = '$nit',
        salario = '$salario', empresa = '$empresa', saldoenmora = '$slmora', saldocapital = '$slcapital', fechaotorgamiento = '$fecotor', fechaseparacion = '$fecsepara', fup = '$fup', vup = '$vup', variable1 = '$var1', variable2 = '$var2', variable3 = '$var3', variable4 = '$var4' where descripcion = '$pr'");

    }

    public function updateImage($img, $pr) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("update proyecto set imagen = '$img' where descripcion = '$pr'");

    }

    public function getMetasUser($pr) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select * from metas_campanas where carteras like '%$pr%' order by idUsuario asc");
        return $query->result_array();
    }

    public function getProyectName($pr) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select * from proyecto where descripcion = '$pr'");
        return $query->result_array();
    }

    public function getProyectos() {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("select * from proyecto order by idProyecto asc");
        return $query->result_array();
    }

    public function saveProyect($proyecto) {
        $this->db = $this->load->database('users', TRUE);

        $query = $this->db->query("insert into proyecto (descripcion) values ('$proyecto')");
        $pr2 = "collector_".$proyecto;
        $query2 = $this->db->query("CREATE DATABASE ".$pr2." CHARACTER SET utf8 COLLATE utf8_spanish_ci");

    }

    public function setpermisos($proyecto) {
        $this->db = $this->load->database('users', TRUE);

        $this->db->query("grant all privileges on collector_".$proyecto.".* to 'smartautomatic'@'localhost'");
        $this->db->query("flush privileges");

    }

    public function updaloadData($output, $proyecto) {
        $this->db = $this->load->database($proyecto, TRUE);

        $this->db->query($output);


    }

    public function getFields($database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("describe 9_creditos");
        return $query->result_array();
    }

    public function getAccion($database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("select * from 1_acciones where activo = '1' order by idAccion asc");
        return $query->result_array();
    }

    public function getContacto($database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("select * from 2_contacto where activo = '1' order by idContacto asc");
        return $query->result_array();
    }

    public function getResultado($database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("select * from 4_resultado where activo = '1' order by idCodres asc");
        return $query->result_array();
    }

    public function getRelacion($database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("select * from 5_relacion_codigos order by idRelacion asc");
        return $query->result_array();
    }

    public function saveFields($name, $tipo, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("alter table 9_creditos add ".$name." ".$tipo." NULL after obligacion");

    }

    public function ubicaCampos($name, $ubica, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("insert into 25_grilla (campo, ubicacion) values ('$name', '$ubica') on duplicate key update ubicacion = '$ubica'");

    }

    public function saveStatus($status, $grupo, $predictiva, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("insert into 2_contacto (descripcion, idGrupo, idPredictiva, guion, activo, homologacion)
        values ('$status', '$grupo', '$predictiva', NULL, '1', NULL)");

    }

    public function saveLogros($logro, $nivel, $clase, $dias, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("insert into 4_resultado (descripcion, nivel, fecha, valor, texto, idClase, diasEntreGestion, idResultadoDegradar, diasadegradar, guion, activo, homologacion, esAcuerdo)
        values ('$logro', '$nivel', '0', '0', '0', '$clase', '$dias', NULL, NULL, NULL, '1', NULL, NULL)");

    }

    public function saveRelacion($accion, $status, $logro, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("insert into 5_relacion_codigos (idAccion, idContacto, idResultado)
        values ('$accion', '$status', '$logro')");

    }

    public function dropField($campo, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("alter table 9_creditos drop column ".$campo);
        $query = $this->db->query("delete from 25_grilla where campo = '$campo' ");

    }

    public function getCamposDinamicos($database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("select * from 26_camposDinamicos order by idCampos asc");
        return $query->result_array();
    }

    public function saveCamposDinamicos($campo, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("insert into 26_camposDinamicos (nombreCampo) values ('$campo')");
    }

    public function saveCamposDinamicosHist($campo, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("alter table 7_callhist add ".$campo." varchar(100) null;");
    }

    public function saveOptionsField($campo, $options, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("update 26_camposDinamicos set contenido = '$options' where idCampos = '$campo'");
    }

    public function dropOptionsField($campo, $database) {
        $this->db = $this->load->database($database, TRUE);

        $query = $this->db->query("delete from 26_camposDinamicos where idCampos = '$campo'");
    }


}

?>
