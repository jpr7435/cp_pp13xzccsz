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


$nombre = "ExporteGestionSugerida";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Documento; Accion; Complemento;Fecha Sugerida;Asesor;Fecha Guardado"."\n";

$l = 0;


foreach ($sugerida as $c) {

    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);
    $accion = $ci2->vista->getSugeridaAccion($c['idAccion'], $session['proyecto_activo']);

    $gestion = $c['documento'].";".$accion[0]['descripcion'].";".$c['complemento'].";".$c['fechasugerida'].";".$asesor[0]['usuario'].";".$c['fechaGuardado'];

    $actual .= $gestion;
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
