<?php


class Usuarios extends CI_Model{

	public function __construct() {
        $this->db = $this->load->database('users', TRUE);
    }

		public function saveuser($usuario, $passcryp, $nomtotal, $documento, $perfil, $proyecto, $email, $meta, $fecha) {
				$query = $this->db->query("insert into usuarios (usuario, password, nombre, documento, idPerfil, idProyecto, email, meta, fechaUltimoIngreso, fechaActualizacion, fechaCreacion, idEstado)
				 values ('$usuario', '$passcryp', '$nomtotal', '$documento', '$perfil', '$proyecto', '$email', '$meta', '$fecha', '2018-01-01', '$fecha', '1') on duplicate key update idEstado = '1';");
		}

	public function getAllIp(){
    	$query = $this->db->query("select * from autorizacion");
    	return $query->result_array();
    }

	public function saveEvento($idU, $user, $evento, $ip, $fecha){
    	$query = $this->db->query("insert into log_eventos (evento, idUsuario, usuario, ip, fecha) values ('$evento', '$idU', '$user', '$ip', '$fecha');");

    }

	public function setUltimoIngreso($user, $hoy){
    	$query = $this->db->query("update usuarios set fechaUltimoIngreso = '$hoy' where usuario = '$user'");

    }

		public function savePermisosEspeciales($proyectos, $user) {
        $query = $this->db->query("insert into permisosespeciales (idUsuario, carteras)values('$user', '$proyectos')");
    }

	public function setBloqueo($user, $estado){
    	$query = $this->db->query("update usuarios set idEstado = '$estado' where usuario = '$user'");

    }

	public function getUserData($user){
    	$query = $this->db->query("select * from usuarios where usuario = '$user'");
		return $query->result_array();

    }

		public function unlockUser($id, $hoy){
	    	$query = $this->db->query("update usuarios set idEstado = '1', fechaActualizacion = '$hoy' where idusuario = '$id';");

	    }

	public function getHost(){
    	$query = $this->db->query("select * from host");
		return $query->result_array();

    }

	public function saveSession($usuario, $idUsuario,$meta,$idPerfil,$idProyecto, $fecha, $ip){
    	$query = $this->db->query("insert into sessiones (usuario, idUsuario, meta, idPerfil, idProyecto, ip, fechaRegistro, idEstadoSession, fechaCierre)
    	values ('$usuario','$idUsuario','$meta', '$idPerfil', '$idProyecto', '$ip', '$fecha', '1', NULL)");


    }

	public function getSessionInfo($id){
    	$query = $this->db->query("select * from sessiones where idSession = '$id' and idEstadoSession = '1'");
		return $query->result_array();

    }


	public function getProyectos(){
    	$query = $this->db->query("select * from proyecto order by idProyecto asc");
		return $query->result_array();

    }

    public function getPerfiles(){
    	$query = $this->db->query("select * from perfiles order by idPerfil asc");
		return $query->result_array();

    }

	public function getUsuarios(){
    	$query = $this->db->query("select * from usuarios order by nombre asc");
		return $query->result_array();

    }

	public function getUsuarioUno($id){
    	$query = $this->db->query("select * from usuarios where idUsuario = '$id'");
		return $query->result_array();

    }

		public function getUsuarioDoc($id){
	    	$query = $this->db->query("select * from usuarios where documento = '$id'");
			return $query->result_array();

	    }


}

?>
