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


$nombre = "ModuloSupervision_";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";

$linea .= "Cartera;Gestor;Hora Logueo;Hora Deslogueo;Gestiones;Hora Ultima Gestion;Tiempo Muerto"."\n";

$l = 0;

$hoy = date("Y-m-d");
$hoyHora = date("Y-m-d H:i:s");
foreach ($informe as $c) {

    $gest = $ci2->vista->getGestionesNumero($c['idUsuario'], $c['fechauno'], $c['proyecto']);
    $last = $ci2->vista->getUltimaGestion($c['idUsuario'], $c['fechauno'], $c['proyecto']);
    $ultHora = explode(" ", $last[0]['ultima']);
    $muerto = "";

    if($hoy == $c['fechauno']){
        if(isset($last[0]['ultima'])){
            $fecha1 = new DateTime($last[0]['ultima']);//fecha inicial
            $fecha2 = new DateTime($hoyHora);//fecha de cierre

            $intervalo = $fecha1->diff($fecha2);

            $muerto = $intervalo->format('%H:%i:%s');
        }else{
            $muerto = "";
        }
    }

    $gestion = $c['proyecto'].";".$c['usuario'].";".$c['fechaRegistro'].";".$c['fechaCierre'].";".$gest[0]['total'].";".$ultHora[1].";".$muerto;

    $actual = $gestion;
    $actual .= "\n";
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
unlink($filename);
?>
