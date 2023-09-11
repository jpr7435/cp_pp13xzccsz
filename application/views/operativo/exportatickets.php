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

$nombre = "InformeTickets";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item("ruta_local")."/uploads"."/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";
$campos = "";
$campos2 = "";

$linea .= "Asociado;Producto;Ticket;Campana;Subcampana;Fecha Cierre;Estado USA;Como se entero;Fecha Cargue;Estado;Tipo;Asesor;Nombre;Fecha Vencimiento;". "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);


$l = 0;


foreach ($tickets as $c) {

    $campos2 = "";
    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);
    $estad = $ci2->vista->getContacto($c['activo'], $session['proyecto_activo']);
    $tipo = $ci2->vista->getTipo($c['idtipo'], $session['proyecto_activo']);
    $usa = $ci2->vista->getusa($c['usa'], $session['proyecto_activo']);
    $campana = $ci2->vista->getCampana($c['campana'], $session['proyecto_activo']);
    $como = $ci2->vista->getcomoseentero($c['como'], $session['proyecto_activo']);
    $subcate = $ci2->vista->getMotivo($c['subCate'], $session['proyecto_activo']);
    $txt = $ci2->vista->cleanText($c['textoGestion']);
    $txt = str_replace(";","",$txt);
    $txt = str_replace(",","",$txt);
    $actual = $c['documento'] . ";" . $c['obligacion']. ";" . $c['ticket'] . ";" . $campana[0]['descripcion'] . ";" . $subcate[0]['descripcion']
     . ";" . $c['fechaCierre'] . ";" . $usa[0]['descripcion']   . ";" . $como[0]['descripcion']
     . ";" . $c['fechacargue'] . ";" . $estad[0]['descripcion'] . ";" . $tipo[0]['descripcion'] . ";" . $asesor[0]['usuario']
     . ";" . $c['nombre']. ";" . $c['fechaVencimiento']. "\n";

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
