<?php

class NotificacionesModel extends CI_Model {

    public function __construct() {
        $this->db = $this->load->database('users', TRUE);
    }

    public function saveEvent($event, $iduser, $user, $fecha, $hora, $ip) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("insert into operativolog (evento, idusuario, fecha, hora, ip, usuario)
        values ('$event', '$iduser', '$fecha', '$hora', '$ip', '$user');");
    }

    public function getUsuariosAll() {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select * from usuarios;");
        return $query->result_array();
    }

    public function getNumNotificaciones($user) {
        $this->db = $this->load->database('default', TRUE);
        $query = $this->db->query("select count(idnotificacion) as cuantos from notificaciones where idusuario = '$user' and leida = '0' group by idusuario;");

        return $query->result_array();
    }
}

?>
