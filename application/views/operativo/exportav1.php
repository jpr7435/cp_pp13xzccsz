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

$nombre = "InformeV1_";
$fecha = date("Ymd");
$fechaActual = date("d/m/Y");

$short = $nombre . $fecha . ".csv";
$filename = "/var/www/html/puntualmentecomco/modulo_cobranzas/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Identificacion;Nombre;Casa de Cobro;Fecha Asignacion;Mes Asignado;Fecha de Envio;Asesor;Fecha Gestion;Gestion;Razon Mora;Telefono Fijo;Telefono Celular;Direccion;Barrio;Tipo Vivienda;Ciudad;Departamento;Actividad Laboral;Telefono Laboral;Email;Tipificacion Consolidada;Producto" . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;


foreach ($llamadas as $c) {


    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);
    //$resu = $ci2->vista->getResultado($c['idResultado'], $session['proyecto_activo']);
    /*$cont = $ci2->vista->getContacto($c['idContacto'], $session['proyecto_activo']);
    $acc = $ci2->vista->getAccion($c['idAccion'], $session['proyecto_activo']);
    $mot = $ci2->vista->getMotivo($c['idMotivo'], $session['proyecto_activo']);
    $txt = $ci2->vista->cleanText($c['textoGestion']);*/

  if(!isset($asesor[0]['nombre'])){
    $asesor[0]['nombre'] = "Sin Asesor";
  }

    $fechaInicial = "01/".date("m")."/".date("Y");
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

    if($c['FecUltimaGestion'] == '0000-00-00'){
      $c['FecUltimaGestion'] = "";
    }


    $ohs = $ci2->vista->getObligaciones($c['documento'], $session['proyecto_activo']);

    if(!isset($ohs[0]['producto'])){
      $ohs[0]['producto'] = "";
    }

    $activ = $ci2->vista->getActividad($c['actividad'], $session['proyecto_activo']);

    if(!isset($activ[0]['actividad'])){
      $activ[0]['actividad'] = "";
    }
    $telefo = $ci2->vista->getTelefonos($c['documento'], $session['proyecto_activo']);
    $fijo = "";
    $cel = "";

    if(isset($telefo[0]['telefono'])){
      foreach($telefo as $te){
        if(strlen($te['telefono']) == 10){
          $cel = $te['telefono'];
        }else if(strlen($te['telefono']) == 7){
          $fijo = $te['telefono'];
        }
      }
    }else{
      $fijo = "";
      $cel = "";
    }

    $direcc = $ci2->vista->getDirecciones($c['documento'], $session['proyecto_activo']);

    if(!isset($direcc[0]['direccion'])){
      $direcc[0]['direccion'] = "";
      $direcc[0]['departamento'] = "";
      $direcc[0]['barrio'] = "";
      $direcc[0]['idCiudad'] = "";
    }

    $mail = $ci2->vista->getEmails($c['documento'], $session['proyecto_activo']);

    if(!isset($mail[0]['mail'])){
      $mail[0]['mail'] = "";
    }



    $mesNum2 = intval($mesNum);
    $prem = explode("-",$c['FecUltimaGestion']);
    $mesUlt = intval($prem[1]);

    $mot[0]['descripcion'] = "";
    $gest[0]['textoGestion'] = "";
    $resu[0]['descripcion'] = "";
    $resu[0]['homologacion'] = "";


    if($mesUlt < $mesNum2){
      $c['FecUltimaGestion'] = "";
      $gestion = "";
    }else{
      //$gest = $ci2->vista->getLastCall($c['documento'], $session['proyecto_activo']);
      //$gestion = $ci2->vista->cleanText($gest[0]['textoGestion']);
      if($gest[0]['idMotivo'] == 0){
        $mot[0]['descripcion'] = "";
      }else{
        $mot = $ci2->vista->getMotivo($gest[0]['idMotivo'], $session['proyecto_activo']);
        $resu = $ci2->vista->getResultado($gest[0]['idResultado'], $session['proyecto_activo']);
      }
      if($c['mejorGestion'] == 0){
        $resu[0]['descripcion'] = "";
        $mejorTxt[0]['textoGestion'] = "";
      }else{
        $resu = $ci2->vista->getResultado($c['mejorGestion'], $session['proyecto_activo']);
        $mejorTxt = $ci2->vista->getMejorCall($c['mejorGestion'], $c['documento'], $session['proyecto_activo']);
        $gestion =  $ci2->vista->cleanText($mejorTxt[0]['textoGestion']);
      }
    }


    $actual = $c['documento'] . ";" . $c['nombre'] . ";" . "PUNTUALMENTE" . ";" . $fechaInicial . ";" . $mes . ";" . $fechaActual . ";" . $asesor[0]['nombre']
     . ";" . $c['FecUltimaGestion'] . ";" . $gestion . ";" . $mot[0]['descripcion'] . ";" . $fijo . ";" . $cel . ";" . $direcc[0]['direccion']
     . ";" . $direcc[0]['barrio'] . ";" . ""  . ";" . $direcc[0]['idCiudad']  . ";" . $direcc[0]['departamento'] . ";" . $activ[0]['actividad'] . ";" . ""
     . ";" . $mail[0]['mail'] . ";" . $resu[0]['homologacion'] . ";" . $ohs[0]['producto'] . "\n";
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
