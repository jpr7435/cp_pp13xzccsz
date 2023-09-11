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


$nombre = "ReporteAsignacion";
$fecha = date("YmdHis");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$hoy = date("Y-m-")."01";
$linea = '';
$activo = "";
$agregado = "";
$pr = $ci2->vista->getProyectDataPr($slug);


$linea .= "Cartera;Documento;Obligacion;Nombre;Saldo Principal;Saldo Actual;Asesor;Usuario Asesor;Clase Mejor Logro;Mejor Logro;Ultimo Estatus;Ultimo Logro;Dias Para Degradar;Fecha Ultima Gestion;Total Gestiones;Dias Gestion;Fecha Promesa; Valor Promesa; Cancelado";


foreach($grilla as $g1){
    $linea .= $g1['campo'].";";
}
$linea .= "\n";
//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);

$l = 0;


foreach ($clientes as $c) {


    $asesor = $ci2->vista->getusuario($c['idAsesor'], $slug);
    $mejor = $ci2->vista->getResultado($c['mejorGestion'], $slug);
    $claseMe = $ci2->vista->getClaseUno($mejor[0]['idClase'], $slug);
    $ultima = $ci2->vista->getResultado($c['ultimaGestion'], $slug);
    $status = $ci2->vista->getContacto($c['ultimostatus'], $slug);
    $totalcalls = $ci2->vista->getTotalCalls($c['documentodos'], $slug);
    $prediasGest = $ci2->vista->getDiasGest($c['documentodos'], $hoy, $slug);
    $diasGest = count($prediasGest);
    $cancelado = "";

    if($c['cancelado'] == 1){
        $cancelado = "Obligacion Cancelada";
    }

    $fec = "";
    $valo = "";
    if($c['mejorGestion'] < 6){
        //$dataprom = $ci2->vista->getUltimaPromesaOh($c['obligaciondos'], $c['mejorGestion'], $slug);
        //$prom = $ci2->vista->getCallId($dataprom[0]['id'], $slug);

        //$fec = $prom[0]['fechaAcuerdo'];
        //$valo = $prom[0]['vlAcuerdo'];

        $fec = 0;
        $valo = 0;
    }

    $actual = $slug . ";" .$c['documentodos'] . ";" . $c['obligaciondos'] .  ";" . $c['nombre'] . ";" . $c[$pr[0]['campoSaldo']] . ";" . $c['saldoActualizado'] . ";" .
    $asesor[0]['nombre'] . ";" . $asesor[0]['usuario'] . ";" . $claseMe[0]['descripcion'] . ";" . $mejor[0]['descripcion'] . ";" . $status[0]['descripcion'] . ";"  . $ultima[0]['descripcion'] . ";"  . $mejor[0]['diasadegradar'] . ";" . $c['FecUltimaGestion'] . ";" . $totalcalls[0]['total'] . ";" . $diasGest . ";" . $fec . ";" . $valo . ";" . $cancelado;
    /*foreach($grilla as $g2){
        $actual .= $c[$g2['campo']].";";
    }*/
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
?>
