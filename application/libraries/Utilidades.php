<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

class Utilidades {
   //funciones que queremos implementar en Miclase.
   public function cleanText($text) {

     $pre = utf8_encode($text);

		$uno = str_replace("DROP", "", $pre);
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
                $veintitres = str_replace("\\", "", $veintidos);


		$valor = $veintitres;

		$final2 = trim($valor);
                $final = preg_replace("[\n|\r|\n\r]", ' ', $final2);

		return $final;

	}

        public function saveEvent($event, $user, $database, $documento = NULL, $datoanterior = NULL, $query = NULL){

            $ci =& get_instance();
            $ci->load->model('Principal');

            $fecha = date("Y-m-d");
            $hora = date("H:i:s");
            $ip = $_SERVER['REMOTE_ADDR'];

            $ci->Principal->saveEvents($event, $user, $fecha, $hora, $ip, $database, $documento, $datoanterior, $query);

        }

		public function saveEventPausa($event, $user, $usuario, $pausa, $duracion = NULL){

            $ci =& get_instance();
            $ci->load->model('Principal');

            $fecha = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $ip = $_SERVER['REMOTE_ADDR'];

            $ci->Principal->saveEventsPausa($event, $user, $usuario, $fecha, $ip, $duracion, $pausa);

        }

}

?>
