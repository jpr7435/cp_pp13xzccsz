<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

ini_set('memory_limit', '5048M');
ini_set('max_execution_time', 0);
/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$flag = 0;
$documentos = "";


$nombre = "informeBBVAEspejo-";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".txt";
$filename = "/var/www/html/puntualmentecomco/modulo_cobranzas/informes/" . $nombre . $fecha . ".txt";

$archivo = $filename;
$fp = fopen($archivo, "a+");

$linea = '';
$l = 0;

$blancodos = "0";
for($i = 1; $i <= 199; $i++){
  $blancodos .= " ";
}
//echo "si";
//print_r($gestiones);
//die();

foreach ($gestiones as $g) {

  $dataCl = $ci2->vista->getDataCliente($g['documento'], $session['proyecto_activo']);
  $email = $ci2->vista->getEmails($g['documento'], $session['proyecto_activo']);

  if(isset($dataCl[0]['estrategia'])){
    if($dataCl[0]['estrategia'] == "Balance"){
      $fechainiChange = date("Y-m-")."01";
    }else{
      $fechainiChange = $fechaini;
    }
  }else{
    $fechainiChange = $fechaini;
  }

  $call = $ci2->vista->getCallCedula($g['documento'], $fechainiChange, $fechafin, $session['proyecto_activo']);


  $mejor = 0;
  $nivelactual = 99999;
  $idMejor = "";
  $memoTotal = "";
  $memoTotal2 = "";
  $acciones = 0;
  $contactos = 0;
  $flagTxt = 0;
  $nuevo = '';

if(isset($call[0]['idResultado'])){


  foreach ($call as $cl) {

    $actual = $ci2->vista->getResultado($cl['idResultado'], $session['proyecto_activo']);
    if(!isset($actual[0]['nivel'])){
      $actual[0]['nivel'] = 666;
    }
    if ($actual[0]['nivel'] <= $nivelactual) {
      $nivelactual = $actual[0]['nivel'];
      $idMejor = $cl['idCallhist'];
    }

    if($flagTxt == 0){
      if(isset($email[0]['email'])){
        $nuevo = $email[0]['email'];
      }else{
        $nuevo = '';
      }
      
    }else{
      $nuevo = '';
    }

    $memoTotal2 .= $cl['fechaGestion']." ".$nuevo." TEL:".$cl['telefono']." ".$cl['textoGestion'] . " //";
    $acciones += 1;

    if($cl['idContacto'] == 1 || $cl['idContacto'] == 2){
      $contactos += 1;
    }

    $flag += 1;
  }

  $memoTotal4 = $ci2->vista->cleanText($memoTotal2);

  $memoTotal = substr($memoTotal4, 0, 2000);

  $gestionMejor = $ci2->vista->getCallId($idMejor, $session['proyecto_activo']);

  $planodoc = str_pad($g['documento'], 10, " ", STR_PAD_RIGHT);

  $norma = $ci2->vista->getResultado($gestionMejor[0]['idResultado'], $session['proyecto_activo']);
  $planoResultado = $norma[0]['homologacion'];

  $conta = $ci2->vista->getContacto($gestionMejor[0]['idContacto'], $session['proyecto_activo']);
  $planoContacto = $conta[0]['homologacion'];


  /* Actividad Economica */
  if($gestionMejor[0]['actividad'] == "" || $gestionMejor[0]['actividad'] == "0"){
    $gestionMejor[0]['actividad'] = '0000';
  }

  if($gestionMejor[0]['idContacto'] < 3){
    if($gestionMejor[0]['idMotivo'] == 0){
      $gestionMejor[0]['idMotivo'] = "1";
    }
    $motiv = $ci2->vista->getMotivo($gestionMejor[0]['idMotivo'], $session['proyecto_activo']);
    $planoMotivo = $motiv[0]['homologacion'];
    if($planoMotivo == '0235'){
      $planoResultado = '0000';
    }
  }else{
    $planoMotivo = "0000";
  }
  $prefecinf = explode(" ", $gestionMejor[0]['fechaGestion']);
  $horainf = str_replace(":", ".", $prefecinf[1]);

  //$planofechaGestion = $prefecinf[0] . "-" . $horainf . " ";
  if(isset($dataCl[0]['FecUltimaGestion'])){
    $planofechaGestion = $dataCl[0]['FecUltimaGestion'] . "-" . $horainf . " ";
  }else{
    $planofechaGestion = $prefecinf[0] . "-" . $horainf . " ";
  }


  $fecProm = "";
  $vlacuerdo = str_pad($gestionMejor[0]['vlAcuerdo'], 19, " ", STR_PAD_RIGHT);

  if($gestionMejor[0]['fechaAcuerdo'] == "0000-00-00" || $gestionMejor[0]['fechaAcuerdo'] == ""){
    $fecProm = "0001-01-01";
    $vlacuerdo = "0,00               ";
  }else{
    $fecProm = $gestionMejor[0]['fechaAcuerdo'];
    $prevlacuerdo = $gestionMejor[0]['vlAcuerdo'].",00";
    $vlacuerdo = str_pad($prevlacuerdo, 19, " ", STR_PAD_RIGHT);
  }

  $telMejor = str_pad($gestionMejor[0]['telefono'], 20, " ", STR_PAD_RIGHT);
  $accionesplano = str_pad($acciones, 4, " ", STR_PAD_LEFT);
  $contactosplano = str_pad($contactos, 4, " ", STR_PAD_LEFT);
  $telMejor = str_pad($gestionMejor[0]['telefono'], 20, " ", STR_PAD_RIGHT);

  $ohs = $ci2->vista->getObligaciones($g['documento'], $session['proyecto_activo']);

  foreach ($ohs as $ob) {

    $fechaCallhist = explode(" ", $cl['fechaGestion']);
    $hoyes = date("Y-m")."-01";
    $date1 = new DateTime($hoyes);
    $date2 = new DateTime($fechaCallhist[0]);
    $diff = $date1->diff($date2);

    if($diff->days >= 0){
      $oh2 = '0013'.str_pad($ob['obligacion'], 36, " ", STR_PAD_RIGHT);
      $ciu = str_pad($ob['ciudad'], 100, " ", STR_PAD_RIGHT);

      if($planoResultado == '0310' || $planoResultado == '0311' || $planoResultado == '0316' || $planoResultado == '0325' || $planoResultado == '0326'){

        if($fecProm == '0001-01-01'){
          $planoResultado = '0322';
        }
      }

      $actual = "0000000000" . $oh2 . $planoResultado . $planoContacto . $planoMotivo . $planofechaGestion . $ob['centrogestor'] . "1130" . "9006915024" . "N ". $fecProm . $vlacuerdo . "0,00               " . "0,00               " . "0,00               " . "N " . $blancodos
      . $ciu . "0         " . "0000" . $ciu . $telMejor . "0                   " . $gestionMejor[0]['actividad'] . "0000" . "0001-01-01" . "" . $accionesplano . $contactosplano . $memoTotal;
      $actual2 = str_pad($actual, 9999, " ", STR_PAD_RIGHT);
      $actual3 = substr($actual2, 0 , 10000);

      $linea = $actual3;
      //  echo $l." - ".$actual3."\n";
      fwrite($fp, $actual3.PHP_EOL);
      $l += 1;
    }
  }
  $linea = '';
  $flag += 1;
  }
}
fclose($fp);


header("Content-Disposition: attachment; filename=$short");
header("Content-Type: application/octet-stream");
header("Content-Length: " . filesize($filename));
readfile($filename);
unlink($filename);

?>
