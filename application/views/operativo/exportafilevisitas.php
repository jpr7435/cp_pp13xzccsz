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

$nombre = "ArchivoVisitas";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "cartera;cliente;dui;nit;salario;empresa;cuenta;saldototal;saldoenmora;saldocapital;producto;fechaotorgamiento;fechaseparacion;fup;vup;gestor;formulario;fecha;hora;tipodireccion;direccion;municipio;departamento;colonia;cel;tel;teltrabajo;madre;padre;conyuge;ref1;telref1;ref2;telref2;var1;var2;var3;var4;var5;comentario;vale;unico" . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;


foreach ($file as $c) {


    $asesor = $ci2->vista->getusuario($c['gestor'], $session['proyecto_activo']);

    $actual = $c['cartera'] . ";" . $c['cliente']. ";" . $c['dui']. ";" . $c['nit']. ";" . $c['salario']. ";" . $c['empresa'].
    ";" . $c['cuenta']. ";" . $c['saldototal']. ";" . $c['saldoenmora']. ";" . $c['saldocapital']. ";" . $c['producto']. ";" . $c['fechaotorgamiento'].
    ";" . $c['fechaseparacion']. ";" . $c['fup']. ";" . $c['vup'] . ";" . $asesor[0]['usuario']. ";" . $c['formulario'] . ";" . $c['fecha'] .
    ";" . $c['hora']. ";" . $c['tipodireccion'] . ";" . $c['direccion'] . ";" . $c['municipio'] . ";" . $c['departamento'] . ";" . $c['colonia'] .
    ";" . $c['cel'] . ";" . $c['tel'] . ";" . $c['teltrabajo'] . ";" . $c['madre'] . ";" . $c['padre'] . ";" . $c['conyuge']
    . ";" . $c['ref1'] . ";" . $c['telref1'] . ";" . $c['ref2'] . ";" . $c['telref2'] . ";" . $c['var1'] . ";" . $c['var2']
    . ";" . $c['var3'] . ";" . $c['var4'] . ";" . $c['var5'] . ";" . $c['comentario'] . ";" . $c['vale'] . ";" . $c['unico'] . "\n";
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
