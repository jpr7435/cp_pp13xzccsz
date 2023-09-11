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

$nombre = "InformeCallcenterEntrantes";
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
$tiempos = "";
$dead = "00:00:00";

$linea .= "Fecha Registro;Hora Inicio;Hora Fin;Duracion;Tiempo en ser atendido;Tipo Llamada;Proceso;Codigo Operador;Origen;conmutador;Estado Llamada;Tipo de Negocio;Rango Hora Llamada;Dia Semana;Rango Duracion Llamada;Tiempo de espera;Id Ticket;Num Ticket;Tiempo Muerto"."\n";


$l = 0;


foreach ($informe as $c) {
  $tipoNeg = "RN";
  if($c['proceso'] == "NO RELACIONADAS AL NEGOCIO"){
    $tipoNeg = "NRN";
  }

  /*if(isset($tiempos[$c['codigoOperador']][0])){
    if($c['fechaRegistro'] == $tiempos[$c['codigoOperador']][1]){
      $fechaUno=new DateTime($c['horaInicio']);
      $fechaDos=new DateTime($tiempos[$c['codigoOperador']][0]);

      $dateInterval = $fechaUno->diff($fechaDos);
      $dead = $dateInterval->format('%H:%i:%s');
      $tiempos[$c['codigoOperador']][0] = $c['horaFin'];
      $tiempos[$c['codigoOperador']][1] = $c['fechaRegistro'];

    }else{
      $tiempos[$c['codigoOperador']][1] = $c['fechaRegistro'];
      $dead = "00:00:00";
    }

  }else{
    $tiempos[$c['codigoOperador']][0] = $c['horaFin'];
    $tiempos[$c['codigoOperador']][1] = $c['fechaRegistro'];
  }*/





  $g = $ci2->vista->getTickets($c['noTicket'], $session['proyecto_activo']);
  $idTicket = "55".$g[0]['idCreditos'];

    $actual = $c['fechaRegistro']. ";" . $c['horaInicio'] . ";" . $c['horaFin'] . ";" . $c['duracion'] . ";"
    . $c['tiempoEnserAtendido'] . ";" . $c['tipoLlamada']. ";" . $c['proceso'] . ";" . $c['codigoOperador'] . ";" . str_replace("-", "", $c['origen']) . ";"
    . $c['conmutador'] . ";" . $c['estadoLlamada']. ";" . $tipoNeg . ";" . $c['rangoHoraLlamada'] . ";" . $c['diaSemana'] . ";" . $c['RangoDuracionLlamada'] . ";"
    . $c['tiempodeEspera']. ";" . $idTicket . ";" . $c['noTicket']. ";" . $c['tiempoMuerto'] ."\n";

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
