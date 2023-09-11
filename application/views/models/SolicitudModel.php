<?php

class SolicitudModel extends CI_Model {

    public function __construct() {
        $this->db = $this->load->database('users', TRUE);
    }

    public function saveEvent($event, $iduser, $user, $fecha, $hora, $ip) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("insert into operativolog (evento, idusuario, fecha, hora, ip, usuario)
        values ('$event', '$iduser', '$fecha', '$hora', '$ip', '$user');");
    }

    public function saveNotificacion($descripcion, $solicitud, $url, $iduser, $fecha) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("insert into notificaciones (descripcion, idsolicitud, url, leida, idusuario, fechacreacion, fechaleido)
        values ('$descripcion', '$solicitud', '$url', '0', '$iduser', '$fecha', null);");
    }
    public function updateFechaCierre($solicitud, $fecha, $hora) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("update solicitudes set fechacierre = '$fecha', horacierre = '$hora' where idsolicitud = '$solicitud';");
    }

    public function getUsuariosAll() {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from usuarios;");
        return $query->result_array();
    }

    public function getJefe($area) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from area where idarea = '$area';");
        return $query->result_array();
    }

    public function getTalentoUsers() {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from usuarios where idarea = '9';");
        return $query->result_array();
    }

    public function getTalentoUsersNotifica() {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from usuarios where idusuario in ('67', '87', '137', '140', '1');");
        return $query->result_array();
    }

    public function getVacaciones($cedula) {
        $this->db = $this->load->database('users', TRUE);
        $query = $this->db->query("select * from vacaciones where cedula = '$cedula';");
        return $query->result_array();
    }

    public function getRespuestas($solicitud) {
        $this->db = $this->load->database('users', TRUE);
        $query = $this->db->query("select * from respuestasevaluaciones where idsolicitud = '$solicitud';");
        return $query->result_array();
    }

    public function getPreguntaUno($id) {
        $this->db = $this->load->database('users', TRUE);
        $query = $this->db->query("select * from preguntasevaluacion where idpregunta = '$id';");
        return $query->result_array();
    }

    public function getOtras() {
        $this->db = $this->load->database('users', TRUE);
        $query = $this->db->query("select * from otrassolicitudes;");
        return $query->result_array();
    }

    public function getPostulacionUno($user, $solic) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from convocatorias where idusuario = '$user' and idsolicitud = '$solic';");
        return $query->result_array();
    }

    public function savePostulacion($idusuario, $usuario, $nombre, $solicitud, $fecha) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("insert into convocatorias (idusuario, usuario, nombre, idpostulado, idseleccionado, idsolicitud, fechacreacion)
                                  values ('$idusuario', '$usuario', '$nombre', '0', '0', '$solicitud', '$fecha');");
    }

    public function saveAplicante($idconvocatoria) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("update convocatorias set idpostulado = '1' where idconvocatoria = '$idconvocatoria';");
    }

    public function selectCandidato($idconvocatoria) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("update convocatorias set idseleccionado = '1' where idconvocatoria = '$idconvocatoria';");
    }

    public function getConvocatoriaId($idconvocatoria) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from convocatorias where idconvocatoria = '$idconvocatoria';");

        return $query->result_array();
    }

    public function getPostulaciones($solicitud) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from convocatorias where idpostulado = '0' and idsolicitud = '$solicitud';");

        return $query->result_array();
    }

    public function getAplicantes($solicitud) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from convocatorias where idpostulado = '1' and idsolicitud = '$solicitud';");
        return $query->result_array();
    }

    public function getdataempleado($documento) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from talentohumano where cedula = '$documento';");

        return $query->result_array();
    }

    public function gettiposolicitud($modulo) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from tiposolicitud where idmodulo = '$modulo' order by descripcion asc;");

        return $query->result_array();
    }

    public function getEstadoInicial($tipo) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select min(idestadosolicitud) as estado from estadossolicitudes where idtiposolicitud = '$tipo';");

        return $query->result_array();
    }

    public function getSolicitudesUsuario($user) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from solicitudes where idusuario = '$user' order by idsolicitud desc;");

        return $query->result_array();
    }

    public function getNotificacionesUsuario($user) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from notificaciones where idusuario = '$user' and leida = '0' order by idnotificacion desc;");

        return $query->result_array();
    }

    public function getSolicitudesTipo($tipo) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from solicitudes where idtiposolicitud = '$tipo' order by idsolicitud desc;");

        return $query->result_array();
    }

    public function getSolicitudesTipoAll() {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from solicitudes order by idsolicitud desc;");

        return $query->result_array();
    }

    public function getSolicitudesTipoUser($tipo, $user) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from solicitudes where idtiposolicitud = '$tipo' and idusuario = '$user' order by idsolicitud desc;");

        return $query->result_array();
    }

    public function getSolicitudesTipoAllUser($user) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from solicitudes wher idusuario = '$user' order by idsolicitud desc;");

        return $query->result_array();
    }

    public function getSolicitudesTipoJefe($tipo, $area) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from solicitudes where idtiposolicitud = '$tipo' and idarea = '$area' order by idsolicitud desc;");

        return $query->result_array();
    }

    public function getSolicitudesTipoAllJefe($area) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from solicitudes wher idarea = '$area' order by idsolicitud desc;");

        return $query->result_array();
    }

    public function getSolicitudesActivas() {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from solicitudes order by idsolicitud desc;");

        return $query->result_array();
    }

    public function getSolicitudUno($id) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from solicitudes where idsolicitud = '$id' order by idsolicitud desc;");

        return $query->result_array();
    }

    public function getSeguimientoSolicitud($id) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from seguimientosolicitudes where idsolicitud = '$id' order by idseguimientosolicitud desc;");

        return $query->result_array();
    }

    public function getEstadosLimite($tipo, $estado) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from estadossolicitudes where idtiposolicitud = '$tipo' and idestadosolicitud > '$estado' order by idestadosolicitud asc;");

        return $query->result_array();
    }


    public function getTipoSolicitudUno($tipo) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from tiposolicitud where idtiposolicitud = '$tipo';");
        return $query->result_array();
    }

    public function getUsuarioUno($id) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from usuarios where idusuario = '$id';");
        return $query->result_array();
    }

    public function getModuloUno($id) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from modulos where idmodulo = '$id';");
        return $query->result_array();
    }

    public function getModulos() {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from modulos order by idmodulo asc;");
        return $query->result_array();
    }

    public function getFormacion() {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from formacion order by idformacion asc;");
        return $query->result_array();
    }

    public function getEstadoUno($id) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from estadossolicitudes where idestadosolicitud = '$id';");
        return $query->result_array();
    }

    public function getMaxSolicitud() {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select max(idsolicitud) as ultimo from solicitudes;");
        return $query->result_array();
    }


    public function saveSolicitud($tiposolicitud, $descripcion, $estado, $modulo, $usuario, $fecha, $hora, $complemento1, $complemento2, $complemento3, $complemento4, $area) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("insert into solicitudes (idtiposolicitud, descripcion, idusuario, fechacreacion, idmodulo, idestado, horacreacion, fechacierre, horacierre, complemento1, complemento2, complemento3, complemento4, idarea) values
        ('$tiposolicitud', '$descripcion', '$usuario', '$fecha', '$modulo', '$estado', '$hora', null, null, '$complemento1', '$complemento2', '$complemento3', '$complemento4', '$area');");

        return $query;
    }

    public function saveEventoSolicitud($solicitud, $descripcion, $estado, $usuario, $fecha, $hora) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("insert into seguimientosolicitudes (idsolicitud, observacion, idestado, idusuario, fecha, hora) values
        ('$solicitud', '$descripcion', '$estado', '$usuario', '$fecha', '$hora');");

        return $query;
    }

    public function guardarSeguimiento($solicitud, $idestado, $descripcion, $fecha, $hora, $usuario) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("insert into seguimientosolicitudes (idsolicitud, observacion, idestado, idusuario, fecha, hora) values
        ('$solicitud', '$descripcion', '$idestado', '$usuario', '$fecha', '$hora');");

        return $query;
    }

    public function setEstadoSolicitud($solicitud, $idestado) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("update solicitudes set idestado = '$idestado' where idsolicitud = '$solicitud';");

        return $query;
    }

    public function saveRespuestaEvaluacion($form, $pregun, $punta, $resp, $sol, $usuario) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("insert into respuestasevaluaciones (idformulario, idpregunta, puntaje, respuesta, idsolicitud, idusuario) values ('$form', '$pregun', '$punta', '$resp', '$sol', '$usuario');");

        return $query;
    }

    public function cleanNotificacion($idusuario, $solicitud, $fecha) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("update notificaciones set leida = '1', fechaleido = '$fecha' where idsolicitud = '$solicitud' and idusuario = '$idusuario';");

        return $query;
    }

    public function cleanNotificacionCierre($solicitud, $fecha) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("update notificaciones set leida = '1', fechaleido = '$fecha' where idsolicitud = '$solicitud' and leida = '0';");

        return $query;
    }

    public function cleanNotificacionAuto($idusuario, $fecha) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("update notificaciones set leida = '1', fechaleido = '$fecha' where descripcion::text like '%autoevaluaci%' and idsolicitud = '0' and idusuario = '$idusuario';");

        return $query;
    }
}

?>
