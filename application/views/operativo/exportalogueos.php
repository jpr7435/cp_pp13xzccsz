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

$nombre = "ReporteLogueos";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Usuario;Nombre;Proyecto;Ip;Fecha Ingreso;Fecha Salida"."\n";


$l = 0;

foreach ($sesiones as $c) {

    $asesor = $ci2->vista->getusuario($c['idUsuario'], $session['proyecto_activo']);


    $actual = $c['usuario']. ";" . $asesor[0]['nombre'] . ";" . $c['proyecto'] . ";" . $c['ip'] . ";" . $c['fechaRegistro'] . ";" . $c['fechaCierre'] ."\n";

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
