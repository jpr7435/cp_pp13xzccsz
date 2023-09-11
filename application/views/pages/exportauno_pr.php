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

$nombre = "ProyeccionPromesas";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Documento;Obligacion;Fecha Promesa;Valor Promesa;Mes Promesa; Estado; Asesor" . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;


foreach ($listado as $c) {


    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);
    $estado = $ci2->vista->getCumplido($c['idCumplido'], $session['proyecto_activo']);


    $actual = $c['documentodos'] . ";" . $c['obligaciondos']. ";" . $c['fechaPromesa'] . ";" . $c['valorpromesa'] . ";" . $c['mespromesa'] . ";" . $estado[0]['descripcion'] . ";"
    . $asesor[0]['usuario'] . "\n";
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
?>
