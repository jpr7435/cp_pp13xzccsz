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


$nombre = "ReportePromesas";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Cartera;Obligacion;Documento;Nombre;Asesor Promeso;Usuario Asesor Actual;Asesor Actual;Fecha Registro;Fecha a Pagar;Importe;Estatus Promesa"."\n";
//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;

foreach ($promesas as $c) {


    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);
   
    $cliente = $ci2->vista->getDataClienteDoc($c['documento'], $session['proyecto_activo']);
    $asesor2 = $ci2->vista->getusuario($cliente[0]['idAsesor'], $session['proyecto_activo']);
    $estado = $ci2->vista->getCumplido($c['idCumplido'], $session['proyecto_activo']);
    

    $actual = $session['proyecto_activo'] . ";" . $c['obligacion'] . ";" . $c['documento'] . ";" . $cliente[0]['nombre'] . ";" . $asesor[0]['nombre'] . ";" . $asesor2[0]['usuario']  . ";" . $asesor2[0]['nombre'] . ";" . $c['fechaCreacion'] . ";" . $c['fechaPromesa'] . ";" . $c['valorpromesa' ] . ";" . $estado[0]['descripcion'];

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
