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


$nombre = "ExportReferencias_".$session['proyecto_activo'];
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Documento; Documento Referencia; Nombre;Tipo Referencia;Relacion;telefonoRef;telefono2Ref;telefono3Ref;direccionRef;ciudadRef;colonia;municipio;departamento;zona;activo"."\n";

$l = 0;


foreach ($info as $c) {

    if($c['activo'] == 1){
        $activo = "Activo";
    }else{
        $activo = "Inactivo";
    }

    $gestion = $c['documento'].";".$c['docReferencia'].";".$c['nombre'].";".$c['tipoReferencia'].";".$c['relacion'].";".$c['telefonoRef'].";".$c['telefono2Ref'].";".$c['telefono3Ref'].";".$c['direccionRef'].";".$c['ciudadRef'].";".$c['colonia'].";".$c['municipio'].";".$c['departamento'].";".$c['zona'].";".$activo;

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
