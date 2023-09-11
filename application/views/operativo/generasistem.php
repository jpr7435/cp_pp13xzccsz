<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$flag = 0;
$documentos = "";



$nombre = "informeSistemcobro-";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('rutalocal') . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$l = 0;

$linea .= "fechagestion;idrazonnopago;idparentesco;cedula;obligacion;telefono_marcado;codusuario;observacion;fechapago;valorpago;fechaagendamiento;nombretercero;idtipificacion" . "\n";

foreach ($llamadas as $c) {
		
    $fechag1 = explode(" ", $c['fechaGestion']);
	$fechag2 = explode("-", $fechag1[0]);
	$fechag = $fechag2[2]."/".$fechag2[1]."/".$fechag2[0];
	
	
    $resu = $ci2->vista->getResultado($c['idResultado'], $session['proyecto_activo']);
    $mot = $ci2->vista->getMotivo($c['idMotivo'], $session['proyecto_activo']);
	$gestxt = $ci2->vista->cleanText($c['textoGestion'], $session['proyecto_activo']);
	$oh = $ci2->vista->getObligaciones($c['documento'], $session['proyecto_activo']);
	
	if($c['complemento'] == "0"){
		$c['complemento'] = "";
	}
	
	foreach($oh as $o){
		$actual = $fechag . ";" . $mot[0]['homologacion']. ";" . $c['complemento'] . ";" . $c['documento'] . ";" . $o['obligacion'] . ";" . $c['telefono'] . ";AL_INFINITY;" . $gestxt . ";;;;" . $c['complemento']  . ";" . $resu[0]['homologacion']  . "\n";
		$linea .= $actual;
	}
    


    $l+=1;
}


fputs($fp, $linea);
fclose($fp);

header("Content-Disposition: attachment; filename=$short");
header("Content-Type: application/octet-stream");
header("Content-Length: " . filesize($filename));
readfile($filename);
?>