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
error_reporting(E_ALL);
ini_set('display_errors', 1);
$nombre = "InformeDetalleLLamadas";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = "/var/www/html/puntualmentecomco/modulo_cobranzas/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Documento;Fecha Gestion;Hora;Telefono;Accion; Contacto; Motivo; Resultado; Fecha Acuerdo; Valor Acuerdo; Complemento; Texto Gestion; Asesor; Tiempo; Proyecto" . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;


foreach ($llamadas as $c) {


    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);
    $resu = $ci2->vista->getResultado($c['idResultado'], $session['proyecto_activo']);
    $cont = $ci2->vista->getContacto($c['idContacto'], $session['proyecto_activo']);
    $acc = $ci2->vista->getAccion($c['idAccion'], $session['proyecto_activo']);
    $mot = $ci2->vista->getMotivo($c['idMotivo'], $session['proyecto_activo']);
    $txt = $ci2->vista->cleanText($c['textoGestion']);

    $actual = $c['documentodos'] . ";" . $c['fechaGestion']. ";" . $c['hora'] . ";" . $c['telefono'] . ";" . $acc[0]['descripcion'] . ";" . $cont[0]['descripcion'] . ";" . $mot[0]['descripcion'] . ";" . $resu[0]['descripcion'] . ";" . $c['fechaAcuerdo']  . ";" . $c['vlAcuerdo']  . ";" . $c['complemento']  . ";" . $txt  . ";" . $asesor[0]['usuario']  . ";" . $c['tiempo']. ";" . $c['proyecto']  . "\n";
    str_replace(",", ".", $actual);
    $linea .= $actual;


    $l+=1;
}

fwrite($fp, $linea);
fclose($fp);
die();
header("Content-Disposition: attachment; filename=$short");
header("Content-Type: application/octet-stream");
header("Content-Length: " . filesize($filename));
readfile($filename);
?>
