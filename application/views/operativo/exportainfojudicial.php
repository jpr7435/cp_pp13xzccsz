<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', 0);
error_reporting(1);
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
$ci2->load->model("vista");


$nombre = "ExporteJudicial";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = "/var/www/html/puntualmentecomco/modulo_cobranzas/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Cedula;Nombre;Credito;Primer Fecha Judicial;Mejor Estado Judicial;Ultima Fecha Judicial;Ultimo Estado Judicial;Memo"."\n";

$l = 0;

foreach ($clientes as $cl) {

    
    //$mail = $ci2->vista->cleanText($c['email']);
    $mejor = $ci2->vista->getResultado($cl['mejor_estado_judicial'], $session['proyecto_activo']);
    $ultimo = $ci2->vista->getResultado($cl['ultimo_estado_judicial'], $session['proyecto_activo']);
    $gest = $ci2->vista->getGestionJudicial($cl['documento'], $session['proyecto_activo']);
    $memo = '';

    foreach($gest as $gg){
      $res = $ci2->vista->getResultado($gg['idResultado'], $session['proyecto_activo']);
       $memo .= $gg['fechaGestion']." - ".$res[0]['descripcion']." - ".$gg['textoGestion']. " // ";
    }

    $memo = $ci2->vista->cleanText($memo);

    $actual = $cl['documento'].";".$cl['nombre'].";".$cl['documento'].";".$cl['primer_fecha_judicial'].";".$mejor[0]['descripcion'].";".$cl['ultima_fecha_judicial'].";".$ultimo[0]['descripcion'].";".$memo;

    $actual .= "\n";
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
