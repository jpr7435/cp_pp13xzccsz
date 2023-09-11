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

$nombre = "exportnomina";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Proyecto;Supervisor;Usuario;Nombre Asesor;Meta;Cuentas Asignadas;Saldo Asignado" . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;


foreach ($proyectos as $prs) {


      $coord = $ci2->vista->getusuario($prs['idCoordinador'], $session['proyecto_activo']);
      $gestores = $ci2->vista->getGestores($prs['idProyecto'], $session['proyecto_activo']);

      foreach($gestores as $ges){

        $g = $ci2->vista->getMetaUSer($ges['idUsuario'], $prs['idProyecto']);
        $g2 = $ci2->vista->getusuario($ges['idUsuario'], $session['proyecto_activo']);
        $asig = $ci2->vista->getAsignaDatos($ges['idUsuario'], $prs['campoSaldo'], $prs['descripcion']);

        $actual = $prs['descripcion'] . ";" . $coord[0]['usuario']. ";" . $g2[0]['usuario'] . ";" . $g2[0]['nombre'] . ";" . $g[0]['valor'] . ";" . $asig[0]['cuantos'] . ";"
        . $asig[0]['total']  . "\n";
        str_replace(",", ".", $actual);

        $linea .= $actual;


      $l+=1;

      }

}

fputs($fp, $linea);
fclose($fp);

header("Content-Disposition: attachment; filename=$short");
header("Content-Type: application/octet-stream");
header("Content-Length: " . filesize($filename));
readfile($filename);
unlink($filename);
?>
