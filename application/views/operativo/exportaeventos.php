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

$nombre = "InformeEventos";
$fecha = date("Ymd");

function conversorSegundosHoras($tiempo_en_segundos) {
  $horas = floor($tiempo_en_segundos / 3600);
  $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
  $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);

  return $horas . ':' . $minutos . ":" . $segundos;
}

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item("ruta_local")."/uploads"."/"."informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";
$campos = "";
$campos2 = "";
$tiempos = "";
$dead = "00:00:00";

$linea .= "Evento;Usuario;Fecha;Hora;Direccion Ip"."\n";


$l = 0;

foreach ($informe as $c) {

    $asesor = $ci2->vista->getusuario($c['idUser'], $session['proyecto_activo']);


    $actual = $c['evento']. ";" . $asesor[0]['usuario'] . ";" . $c['fecha'] . ";" . $c['hora'] . ";" . $c['ip'] ."\n";

    str_replace(",", ".", $actual);
    $linea .= $actual;


    $l+=1;
}

fwrite($fp, $linea);
fclose($fp);

header("Content-Disposition: attachment; filename=$short");
header("Content-Type: application/octet-stream");
header("Content-Length: " . filesize($filename));
readfile($filename);
unlink($filename);
?>
