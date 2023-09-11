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


$nombre = "PagosBancos";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Documento;Obligacion;Fecha Pago;Valor;Descripcion;Asesor Asignado;Fecha Cargue;Asesor Cargue"."\n";
//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;


foreach ($pagos as $c) {


    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);
    $asesor2 = $ci2->vista->getusuario($c['AsesorCargue'], $session['proyecto_activo']);

    $actual = $c['documento'] . ";" . $c['obligacion'] .  ";" . $c['fecha'] . ";" . $c['valor' ]. ";" . $c['descripcion'] . ";" . $asesor[0]['usuario'] . ";"
    . $c['fechaCargue'] . ";" . $asesor2[0]['usuario'];

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
?>
