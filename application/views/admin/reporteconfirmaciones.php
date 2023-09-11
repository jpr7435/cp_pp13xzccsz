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

$nombre = "ReporteConfirmaciones_".$proyecto;

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/nocturno/" . $nombre . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Cartera;Obligacion;Documento;Tipo Confirmacion;Fecha Confirmacion;Fecha Pago;Importe;Nombre Asesor;Usuario Asesor"."\n";
//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;

foreach ($confirmaciones as $c) {


    $asesor = $ci2->vista->getusuario($c['idAsesor'], $proyecto);
    $cliente = $ci2->vista->getDataClienteDoc($c['documento'], $proyecto);

    $actual = $proyecto . ";" . $c['ohacuerdo'] . ";" . $c['documento'] . ";" . $c['Tipo_Confirmacion'] . ";" . $c['fechaGestion'] . ";" . $c['fechaAcuerdo']  . ";" . $c['vlAcuerdo'] . ";" . $asesor[0]['nombre'] . ";" . $asesor[0]['usuario'];

    $actual .= "\n";
    str_replace(",", ".", $actual);
    $linea .= $actual;

    $l+=1;
}

fputs($fp, $linea);
fclose($fp);

?>
