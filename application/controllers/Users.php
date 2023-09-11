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

		echo "<script>location.href='https://".$this->config->item('host_cobranzas')."/index.php/dashboard'</script>";

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

	public function validatePass($passPost, $passDB, $user) {
		$this -> load -> helper('cookie');

		$passcryp = md5($passPost);

		if ($passcryp == $passDB) {
			return 0;
		} else {

			$intentos = $this -> input -> cookie("intentos");

			$evento = "02 - Password Incorrecto intento: " . $intentos;
			$this -> setLog("0", $user, $evento);
			return 1;
		}

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

		$valor = $veintidos;

		return $valor;

	}


	public function setLog($idU, $user, $evento) {

		$ip = $_SERVER['REMOTE_ADDR'];
		$fecha = date("Y-m-d H:i:s");

		$this -> Usuarios -> saveEvento($idU, $user, $evento, $ip, $fecha);

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

			echo "<script>location.href='https://" . $this->config->item('host_cobranzas') . "/index.php/user-list'</script>";
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

	public function validatelogin(){

		$this -> session -> valida();
		$data['session'] = $this -> session -> getSessionData();

		$this->load->helper('cookie');
		$user3 = $this -> input -> post('usuario');
		$pass = $this -> input -> post('pass');
		$inten = $this -> input -> post('inten');
		$fecha = date("Y-m-d H:i:s");
		$fechaSola = date("Y-m-d");
		$ip = $_SERVER['REMOTE_ADDR'];


		$user2 = str_replace(" ", "", $user3);
		$user4 = trim($user2);
		$user = $this -> cleanText($user4);
		$datos = $this -> Usuarios -> getUserData($user);
		$bandera = 0;


		if (count($datos) > 0) {

			$bandera = $this -> validatePass($pass, $datos[0]['password'], $user);

			if ($bandera == 1) {
				echo "Usuario o contraseña incorrecta.";
			} else {

				$this -> load -> helper('cookie');


				$cookie4 = array(
					'name' => 'bloqueo',
					'value' => '0',
					'expire' => '86500',
					'domain' => '.consulegalab.com',
					'path' => '/',
					'prefix' => '',
					'secure' => FALSE
				);

				$this->input->set_cookie($cookie4);
				$pausa = $this->input->cookie('pausa');
				$this -> setLog($datos[0]['idUsuario'], $datos[0]['usuario'], "Ingreso al sistema");
				$this->utilidades->saveEventPausa("Fin de Pausa", $datos[0]['idUsuario'], $datos[0]['usuario'], $pausa, $inten);
				echo "666";

			}

		} else {
			$evento = "01 - Usuario no Encontrado.";
			$this -> setLog("0", $user, $evento);
			echo "Usuario o contraseña incorrecta.";
		}

		//echo $bandera;



	}

	public function unlock($slug){

	    		$this -> session -> valida();
	    		$data['session'] = $this -> session -> getSessionData();
	    		$this -> session -> validaPerfilCoordinador($data['session']['proyecto_activo']);
	    		$hoy = date("Y-m-d");
	    		$this -> Usuarios -> unlockUser($slug, $hoy);


	    		echo "<script>location.href='https://" . $this->config->item('host_cobranzas') . "/index.php/user-list'</script>";
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
