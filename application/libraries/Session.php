<?php
session_start();
if (!defined('BASEPATH'))
	exit('No se permite el acceso directo al script');

class Session {
	//funciones que queremos implementar en Miclase.
	function valida() {

		$flag = 0;

		if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "") {
			$flag += 1;
		}
		if (!isset($_SESSION['id']) || $_SESSION['id'] == "") {
			$flag += 1;
		}
		if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] == "") {
			$flag += 1;
		}

		if (!isset($_SESSION['proyecto']) || $_SESSION['proyecto'] == "") {
			$flag += 1;
		}
		if (!isset($_SESSION['proyecto_activo']) || $_SESSION['proyecto_activo'] == "") {
			$flag += 1;
		}

		if($flag > 0){
			echo "<script>location.href='https://consulegalab.com/modulo_usuarios'</script>";
		}



	}

        function unsetsession() {

		$_SESSION['usuario'] = "";
		$_SESSION['id'] = "";
                $_SESSION['perfil'] = "";
		$_SESSION['proyecto'] = "";
		$_SESSION['proyecto_activo'] = "";

	}
        function setTipo($tipo){
            $_SESSION['tipo'] = $tipo;
        }

        function getTipo(){
            return $_SESSION['tipo'];
        }

	function getSessionData(){

		$data = array(
		"usuario" => $_SESSION['usuario'],
		"id" => $_SESSION['id'],
		"meta" => $_SESSION['meta'],
		"perfil" => $_SESSION['perfil'],
		"proyecto" => $_SESSION['proyecto'],
		"imagen" => $_SESSION['imagen'],
		"carteras" => $_SESSION['carteras'],
                "tarea" => $_SESSION['tarea'],
		"proyecto_activo" => $_SESSION['proyecto_activo']
		);

		return $data;

	}

	function setActivo($pr) {

		$flag = 0;


		$_SESSION['proyecto_activo'] = $pr;


	}

        function setTarea($tarea) {


		$_SESSION['tarea'] = $tarea;


	}

        function unsetTarea() {


		$_SESSION['tarea'] = "";


	}


	function validaPerfilCoordinador($perfil) {

		$flag = 0;


		if ($_SESSION['perfil'] > 5) {
			$flag += 1;
		}



		if($flag > 0){
			echo "<script>location.href='http://".$_SERVER['HTTP_HOST']."/index.php/error-permisos'</script>";
		}


	}

}
?>
