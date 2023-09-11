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


$nombre = "ExportInmuebles_".$session['proyecto_activo'];
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Documento;Direccion;Municipio;Departamento;Matricula;Estado"."\n";

$l = 0;


foreach ($info as $c) {

    $municipio = $ci2->vista->getMunicipio($c['idMunicipio'], $session['proyecto_activo']);
    $departamento = $ci2->vista->getDepartamento($c['idDepartamento'], $session['proyecto_activo']);

    $gestion = $c['documento'].";".$c['direccion'].";".$municipio[0]['municipio'].";".$departamento[0]['departamento'].";".$c['matricula'].";".$c['estado'];

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
