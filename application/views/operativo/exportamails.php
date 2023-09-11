<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', 0);
error_reporting(1);
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
$ci2->load->model("vista");


$nombre = "ExporteEmail";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Email;Documento;Activo;Agregado Asesor;Confirmado"."\n";

$l = 0;

foreach ($demograficos as $c) {

    $activo = "";
    $agregado = "";
    $confirmado = "";

    if($c['idActivo'] == 1){
       $activo = "Si";
    }else{
       $activo = "No";
    }

    if($c['agregado'] == 1){
       $agregado = "Si";
    }else{
       $agregado = "No";
    }

    if($c['confirmado'] == 1){
       $confirmado = "Si";
    }else{
       $confirmado = "No";
    }

    $mail = $ci2->vista->cleanText($c['email']);

    $actual = $mail.";".$c['documento'].";".$activo.";".$agregado.";".$confirmado;

    $actual .= "\n";
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
