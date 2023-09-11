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


$nombre = "ExporteGestionConcatenada";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Documento;Nombre;Texto Gestion"."\n";

$l = 0;


foreach ($documentos as $c) {
    $gestion = "";
    $totalcalls = $ci2->vista->getClienteCalls($c['documento'], $session['proyecto_activo']);
    $clData = $ci2->vista->getDataClienteDoc($c['documento'], $session['proyecto_activo']);

    $actual = $c['documento'] . ";" . $clData[0]['nombre'] . ";";
    foreach($totalcalls as $tc){
        $asesor = $ci2->vista->getusuario($tc['idAsesor'], $session['proyecto_activo']);
        $txt = $ci2->vista->cleanText($tc['textoGestion']);
        $txt = str_replace(";","",$txt);
        $txt = str_replace(",","",$txt);
        $gestion .= $tc['fechaGestion']." - ".$asesor[0]['usuario']." - ".$txt." //// ";
    }
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
