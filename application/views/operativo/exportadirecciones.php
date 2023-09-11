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


$nombre = "ExporteDirecciones";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Direccion;Documento;Colonia;Municipio;Departamento;Zona;Tipo Domicilio;Activo;Agregado;Confirmado"."\n";

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

    $tipoD = "Sin Tipo";

    if($c['tipoDomicilio'] != 0){
       $t = $ci2->vista->getTipoDomicilio($c['tipoDomicilio'], $session['proyecto_activo']);
       $tipoD = $t[0]['descripcion'];
    }else{
        $tipoD = "Sin Tipo";
    }

    $dir = $ci2->vista->cleanText($c['direccion']);
    $barrio = $ci2->vista->cleanText($c['barrio']);
    $muni = $ci2->vista->cleanText($c['municipio']);
    $depa = $ci2->vista->cleanText($c['departamento']);
    $zona = $ci2->vista->cleanText($c['zona']);

    $actual = $dir.";".$c['documento'].";".$barrio.";".$muni.";".$depa.";".$zona.";".$tipoD.";".$activo.";".$agregado.";".$confirmado;

    $actual .= "\n";

    $linea .= $actual;
}
fputs($fp, $linea);
fclose($fp);

header("Content-Disposition: attachment; filename=$short");
header("Content-Type: application/octet-stream");
header("Content-Length: " . filesize($filename));
readfile($filename);
unlink($filename);
?>
