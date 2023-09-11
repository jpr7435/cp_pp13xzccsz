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

$nombre = "InformeCallcenterAbandonadas";
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

$linea .= "Origen;Fecha Hora Terimacion;Status;Fecha Hora Entrada a Cola;Espera en Cola"."\n";


$l = 0;


foreach ($informe as $c) {

    $dura = conversorSegundosHoras($c['duration_wait']);


    $actual = $c['callerid']. ";" . $c['datetime_end'] . ";" . $c['status'] . ";" . $c['datetime_entry_queue'] . ";"
    . $dura ."\n";

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
