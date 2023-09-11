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

$nombre = "AsignacionUsuarios_".$proyecto;

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/nocturno/" . $nombre . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Documento;Obligacion;Nombre;idAsesor;Mejor Gestion;Ultima Gestion;Fecha Ultima Gestion" . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;


foreach ($llamadas as $c) {


    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);
    $mejorG = $ci2->vista->getResultado($c['mejorGestion'], $session['proyecto_activo']);
    $ultimaG = $ci2->vista->getResultado($c['ultimaGestion'], $session['proyecto_activo']);


    $actual = $c['documentodos'] . ";" . $c['obligaciondos']. ";" . $c['nombre'] . ";" . $asesor[0]['usuario']. ";" . $mejorG[0]['descripcion'] . ";" . $ultimaG[0]['descripcion']
    . ";" . $c['FecUltimaGestion']. "\n";
    str_replace(",", ".", $actual);
    $linea .= $actual;


    $l+=1;
}

fputs($fp, $linea);
fclose($fp);
?>
