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

$nombre = "InformeCallcenterSalientes";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item("ruta_local")."/uploads"."/"."informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";
$campos = "";
$campos2 = "";

$linea .= "Fecha Registro;Hora Inicio;Hora Fin;Duracion;Tiempo Muerto;Tipo de Gestion;Destino;Codigo Operador;Categoria;Estado;Rango hora de llamada;Motivo;Dia de la semana;Rango Duracion Llamada;Id Ticket;Num Ticket;ACW"."\n";


$l = 0;


foreach ($informe as $c) {

  $g = $ci2->vista->getTickets($c['noTicket'], $session['proyecto_activo']);
  $idTicket = "55".$g[0]['idCreditos'];

  $ca = $ci2->vista->getCallId($c['idCallhist'], $session['proyecto_activo']);
  $es = $ci2->vista->getContacto($ca[0]['idResultado'], $session['proyecto_activo']);

    $actual = $c['fechaRegistro']. ";" . $c['horaInicio'] . ";" . $c['horaFin'] . ";" . $c['duracion'] . ";" . $c['tiempoMuerto'] . ";"
    . $c['tipoLlamada']. ";" . str_replace("-", "", $c['origen']) . ";" . $c['codigoOperador'] . ";" . $c['proceso'] . ";"
    . $es[0]['descripcion'] . ";" . $c['rangoHoraLlamada'] .";" . $ca[0]['Motivo']  . ";" . $c['diaSemana'] . ";" . $c['RangoDuracionLlamada'] . ";"
    . $idTicket . ";" . $c['noTicket']. ";" . $c['tiempoMuerto'] ."\n";

    str_replace(",", ".", $actual);
    $linea .= $actual;


    $l+=1;
}

fwrite($fp, $linea);
fclose($fp);

header("Content-Disposition: attachment; filename=$short");
header("Content-Type: application/octet-stream");
header("Content-Length: " . filesize($filename));
readfile($filename);
unlink($filename);
?>
