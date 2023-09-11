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

$nombre = "InformeV2_";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = "/var/www/html/puntualmentecomco/modulo_cobranzas/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Fecha Reporte;Fecha Llamada;Hora Gestion Inicial;Hora Gestion Final;Identificacion;N Producto/Credito;Numero Marcado;Tipificacion;Razon Mora;Gestion;Franja;Fecha Promesa;Valor Promesa;Asesor;Mes Asignado;Agencia;Producto;Caso;Rediferido" . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;


foreach ($llamadas as $c) {


    /*$asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);
    $resu = $ci2->vista->getResultado($c['idResultado'], $session['proyecto_activo']);
    $cont = $ci2->vista->getContacto($c['idContacto'], $session['proyecto_activo']);
    $acc = $ci2->vista->getAccion($c['idAccion'], $session['proyecto_activo']);
    $mot = $ci2->vista->getMotivo($c['idMotivo'], $session['proyecto_activo']);
    $txt = $ci2->vista->cleanText($c['textoGestion']);*/

    $oh = $ci2->vista->getObligaciones($c['documentodos'], $session['proyecto_activo']);
    $resu = $ci2->vista->getResultado($c['idResultado'], $session['proyecto_activo']);
    $mot = $ci2->vista->getMotivo($c['idMotivo'], $session['proyecto_activo']);
    $txt = $ci2->vista->cleanText($c['textoGestion']);
    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);

    if(!isset($oh[0]['obligacion'])){
      $oh[0]['obligacion'] = '0';
      $oh[0]['franja'] = '';
      $oh[0]['producto'] = '';
    }

    $fechaReporte = date("d/m/Y");

    $mes = "";
    $mesNum = date("m");

    if($mesNum == "01"){
      $mes = "ENERO";
    }else if($mesNum == "02"){
      $mes = "FEBRERO";
    }else if($mesNum == "03"){
      $mes = "MARZO";
    }else if($mesNum == "04"){
      $mes = "ABRIL";
    }else if($mesNum == "05"){
      $mes = "MAYO";
    }else if($mesNum == "06"){
      $mes = "JUNIO";
    }else if($mesNum == "07"){
      $mes = "JULIO";
    }else if($mesNum == "08"){
      $mes = "AGOSTO";
    }else if($mesNum == "09"){
      $mes = "SEPTIEMBRE";
    }else if($mesNum == "10"){
      $mes = "OCTUBRE";
    }else if($mesNum == "11"){
      $mes = "NOVIEMBRE";
    }else if($mesNum == "12"){
      $mes = "DICIEMBRE";
    }

    $fechaPartida = explode(" ",$c['fechaGestion']);

    if($c['fechaAcuerdo'] == '0000-00-00'){
      $c['fechaAcuerdo'] = "";
    }

    $actual = $fechaReporte . ";" . $fechaPartida[0]. ";" . $fechaPartida[1] . ";" . $fechaPartida[1] . ";" . $c['documentodos'] . ";" . $oh[0]['obligacion'] . ";" . $c['telefono']
    . ";" . $resu[0]['homologacion'] . ";" . $mot[0]['descripcion'] . ";" . $txt . ";" . $oh[0]['franja_mora'] . ";" . $c['fechaAcuerdo'] . ";" . $c['vlAcuerdo']
    . ";" . $asesor[0]['nombre'] . ";" . $mes . ";" . "PUNTUALMENTE" . ";" . $oh[0]['producto'] . "\n";
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
