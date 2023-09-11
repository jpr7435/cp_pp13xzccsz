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

$nombre = "Comisiones_".$session['proyecto_activo']."_";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Proyecto;Grupo;Tipo Gestor;Gestor;Recuperacion;Meta;% Cumplimiento;Honorario;Honorarios;Piso Honorario;Honorario Piso;Tasa Comision;Total Comision" . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;


foreach ($factura as $fac) {


    $asesor = $ci2->vista->getusuario($fac['gestorSmart']);
    $grupo = $ci2->vista->getGruposUno($asesor[0]['idgrupo']);
    $nivel = $ci2->vista->getNivelUno($asesor[0]['idnivel']);
    $meta = $ci2->vista->getMetas($fac['gestorSmart'], $prId, $mes);

    if($meta[0]['valor'] == 0){
      $cumplimiento = 0;
      $hono = 0;
      $honpiso = 0;
      $tasa = 0;
      $total = 0;
    }else{
      $cumplimiento = $fac['recuperacion']/$meta[0]['valor'];
      $hono = $fac['honorarios'] / $fac['recuperacion'];
      $honpiso = $fac['honorarios'] - $nivel[0]['piso'];
      $tasa = '';
      $cum = $cumplimiento * 100;
      if($cum < 80){
        $tasa = 0;
      }else if($cum > 79 && $cum < 100){
        $tasa = $nivel[0]['88a99'];
      }else if($cum >= 100 && $cum < 110){
        $tasa = $nivel[0]['100a109'];
      }else if($cum >= 110 && $cum < 125){
        $tasa = $nivel[0]['110a124'];
      }else if($cum >= 125){
        $tasa = $nivel[0]['mas125'];
      }

      $tasac = $tasa / 100;

      $total = $honpiso * $tasac;

    }



    $cumplimiento = number_format($cumplimiento, 2);
    $hono = number_format($hono, 2);

    $actual = $session['proyecto_activo'] . ";" . $grupo[0]['descripcion'] . ";" . $nivel[0]['descripcion'] . ";" . $asesor[0]['nombre'] . ";" . $fac['recuperacion']
     . ";" . $meta[0]['valor'] . ";" . $cumplimiento  . ";" . $hono  . ";" . $fac['honorarios'] . ";" . $nivel[0]['piso'] . ";" . $honpiso . ";" . $tasac
     . ";" . $total . "\n";
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
