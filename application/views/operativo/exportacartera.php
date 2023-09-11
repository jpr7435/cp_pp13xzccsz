<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 error_reporting(0);
 ini_set('display_errors', '1');
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
$ci2->load->model("vista");


$nombre = "InformePlanoCartera";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = "/var/www/html/puntualmentecomco/modulo_cobranzas/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Documento;Nombre;Saldo Pareto;Asesor;Mejor Gestion;Homologacion Mejor;Ultima Gestion;Homologacion Ultima;Fecha Gestion;Total Gestiones;Fecha Acuerdo;Valor Acuerdo" . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;


foreach ($clientes as $c) {


    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);
    $mejor = $ci2->vista->getResultado($c['mejorGestion'], $session['proyecto_activo']);
    $ultima = $ci2->vista->getResultado($c['ultimaGestion'], $session['proyecto_activo']);
    //$totalcalls = $ci2->vista->getTotalCalls($c['documento'], $session['proyecto_activo']);
    $totalcalls[0]['total'] = 0;
    $fec = "";
    $valo = "";
    /*if($c['mejorGestion'] < 6){
        $dataprom = $ci2->vista->getUltimaPromesa($c['documento'], $c['mejorGestion'], $session['proyecto_activo']);
        $prom = $ci2->vista->getCallId($dataprom[0]['id'], $session['proyecto_activo']);

        $fec = $prom[0]['fechaAcuerdo'];
        $valo = $prom[0]['vlAcuerdo'];
    }*/

    $actual = $c['documento'] . ";" . $c['nombre'] . ";" . $c['saldoPareto'] . ";" . $asesor[0]['usuario'] . ";" . $mejor[0]['descripcion'] . ";" ."0"
    . ";"  . $ultima[0]['descripcion'] . ";"  . "0" . ";" . $c['FecUltimaGestion'] . ";" . $totalcalls[0]['total']. ";" . $fec . ";" . $valo . "\n";
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
