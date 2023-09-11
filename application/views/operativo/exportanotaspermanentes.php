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

$nombre = "notaspermanentes";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Documento;Nombre;Nota" . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;


foreach ($clientes as $cl) {

        $actual = $cl['documento'] . ";" . $cl['nombre']. ";" . $cl['notapermanente']  . "\n";
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
