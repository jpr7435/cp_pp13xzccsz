<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(1);
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
$ci2->load->model("vista");

$nombre = "decargueTarea";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";
$campos = "";
$campos2 = "";

foreach($camposAdi as $camp){

  $campos .= $camp['nombreCampo'].";";

}
$campos = substr($campos, 0, -1);

$linea .= "Documento;Tarea;Resultado;Fecha;Asesor Gestion;Asesor Asignado;Cola Automaica" . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);


$l = 0;


foreach ($tarea as $c) {

    $campos2 = "";
    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);
    $asignado = $ci2->vista->getusuario($c['asignado'], $session['proyecto_activo']);
    $resu = $ci2->vista->getResultado($c['idResultado'], $session['proyecto_activo']);

    if($c['idAutomatica'] == 0){
      $automatica = "NO";
    }else{
      $automatica = "SI";
    }

    $actual = $c['documento'] . ";" . $c['tarea']. ";" . $resu[0]['descripcion'] . ";" . $c['fecha'] . ";" . $asesor[0]['usuario'] . ";" . $asignado[0]['usuario']
     . ";" . $automatica . "\n";

    $linea .= $actual;
}

fputs($fp, $linea);
fclose($fp);

header("Content-Disposition: attachment; filename=$short");
header("Content-Type: application/octet-stream");
header("Content-Length: " . filesize($filename));
readfile($filename);
?>
