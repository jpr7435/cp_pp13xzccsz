<?php

class Users extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('Usuarios');
		$this -> load -> library('session');
		$this -> load -> library('utilidades');
	}

	public function register() {

		$this -> load -> helper('cookie');

		$id = $this -> input -> cookie('identidad');


		$datos = $this -> Usuarios -> getSessionInfo($id);

		$host = $this -> Usuarios -> getHost($id);

		$this->config->set_item('host_principal', $host[0]['host']);
		$this->config->set_item('host_usuarios', $host[1]['host']);
		$this->config->set_item('host_cobranzas', $host[2]['host']);

		/*$this->config->item('host_principal');
		$this->config->item('host_usuarios');
		$this->config->item('host_cobranzas');*/

		$_SESSION['usuario'] = $datos[0]['usuario'];
		$_SESSION['id'] = $datos[0]['idUsuario'];
		$_SESSION['meta'] = $datos[0]['meta'];
		$_SESSION['perfil'] = $datos[0]['idPerfil'];
		$_SESSION['proyecto'] =  $datos[0]['idProyecto'];
		$_SESSION['imagen'] =  $datos[0]['imagen'];
		$_SESSION['carteras'] = $datos[0]['especiales'];
		$_SESSION['proyecto_activo'] = $datos[0]['proyecto'];
                $_SESSION['tarea'] = "";

		echo "<script>location.href='http://".$this->config->item('host_cobranzas')."/index.php/dashboard'</script>";

		//echo $this->session->userdata('usuario');


	}


	public function listado(){

		$this -> session -> valida();
		$data['session'] = $this -> session -> getSessionData();
		$this -> session -> validaPerfilCoordinador($data['session']['proyecto_activo']);
		$data['usuariosList'] = $this -> Usuarios -> getUsuarios();


		$this -> load -> view('templates/header', $data);
		$this -> load -> view('templates/sidebar', $data);
		$this -> load -> view('usuarios/listado', $data);
		$this -> load -> view('templates/footer', $data);

	}



	public function saveuser() {


			$this->session->valida();
			$data['session'] = $this->session->getSessionData();

			$nombre = $_POST['nombre'];
			$apellido = $_POST['apellido'];
			$documento = $_POST['documento'];
			$email = $_POST['email'];
			$meta = $_POST['meta'];
			$perfil = $_POST['perfil'];
			$carteras = $_POST['carteras'];
			$password = $_POST['password'];

			$proyectos = "";

			foreach ($carteras as $key => $value) {
					$proyectos .= $value . ";";
			}

			$proyectos = substr($proyectos, 0, -1);

			$passcryp = md5($password);

			$partname = explode(" ", $nombre);
			$partapel = explode(" ", $apellido);


			$usuario = strtolower($partname[0] . "." . $partapel[0]);



			$nomtotal = $nombre . " " . $apellido;

			$fecha = date("Y-m-d");


			$ante = $this->Usuarios->getUsuarioDoc($documento);

			if(isset($ante[0]['documento'])){
					$du = $documento."-1";
					//$this->Usuarios->markDocumento($du);
			}

			$this->Usuarios->saveuser($usuario, $passcryp, $nomtotal, $documento, $perfil, $carteras[0], $email, $meta, $fecha);

			$nuevo = $this->Usuarios->getUserData($usuario);



			$this->Usuarios->savePermisosEspeciales($proyectos, $nuevo[0]['idUsuario']);

			echo "<script>location.href='http://" . $this->config->item('host_cobranzas') . "/index.php/user-list'</script>";
	}



  public function adduser(){

		$this -> session -> valida();
		$data['session'] = $this -> session -> getSessionData();
		$this -> session -> validaPerfilCoordinador($data['session']['proyecto_activo']);

                $data['perfiles'] = $this -> Usuarios -> getPerfiles();
		$data['proyectos'] = $this -> Usuarios -> getProyectos();


		$this -> load -> view('templates/header', $data);
		$this -> load -> view('templates/sidebar', $data);
		$this -> load -> view('usuarios/adduser', $data);
		$this -> load -> view('templates/footer', $data);

	}

	public function unlock($slug){

	    		$this -> session -> valida();
	    		$data['session'] = $this -> session -> getSessionData();
	    		$this -> session -> validaPerfilCoordinador($data['session']['proyecto_activo']);
	    		$hoy = date("Y-m-d");
	    		$this -> Usuarios -> unlockUser($slug, $hoy);


	    		echo "<script>location.href='http://" . $this->config->item('host_cobranzas') . "/index.php/user-list'</script>";
	}

	public function editarusuario($slug){

		$this -> session -> valida();
		$data['session'] = $this -> session -> getSessionData();
		$this -> session -> validaPerfilCoordinador($data['session']['proyecto_activo']);
		$data['user'] = $this -> Usuarios -> getUsuarioUno($slug);


		$this -> load -> view('templates/header', $data);
		$this -> load -> view('templates/sidebar', $data);
		$this -> load -> view('usuarios/edit-user', $data);
		$this -> load -> view('templates/footer', $data);

	}


	public function errorpermisos() {

		$this -> session -> valida();
		$data['session'] = $this -> session -> getSessionData();



		$this -> load -> view('templates/header', $data);
		$this -> load -> view('errors/permisos', $data);
		$this -> load -> view('templates/footer', $data);

	}

}
?>
