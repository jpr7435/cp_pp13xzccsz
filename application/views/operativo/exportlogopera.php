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


$nombre = "Log_operativo_".$proyecto."_";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "idEvento;evento;usuario;fecha;hora;ip;documento;query"."\n";

$l = 0;

$hoy = date("Y-m-d");
$hoyHora = date("Y-m-d H:i:s");
foreach ($sesiones as $c) {

    $asesor = $ci2->vista->getusuario($c['idUser']);

    $gestion = $c['idLog'].";".$c['evento'].";".$asesor[0]['nombre'].";".$c['fecha'].";".$c['hora'].";".$c['ip'].";".$c['documento'].";".$c['query'];

    $actual = $gestion;
    $actual .= "\n";
    str_replace(",", ".", $actual);
    $linea .= $actual;


    $l+=1;
}

fputs($fp, $linea);
fclose($fp);

header("Content-Disposition: attachment; filename=$short");
header("Content-Type: application/octet-stream");
header("Content-Length: " . filesize($filename));
readfile($filename);
unlink($filename);
?>
