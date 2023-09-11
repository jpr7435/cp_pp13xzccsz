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







$nombre = "ReporteGestiones";
$fecha = date("YmdHis");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local') . "/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";
$campos = "";
$campos2 = "";

foreach ($camposAdi as $camp) {

    $campos .= $camp['nombreCampo'] . ";";
}
$campos = substr($campos, 0, -1);

$linea .= "Cartera;Obligacion;Documento;Fecha Gestion;Hora;Telefono;Accion;Estatus;Resultado;Logro;Fecha Acuerdo;Valor Acuerdo;Obligacion Acuerdo;Complemento; Texto Gestion; Asesor;Tiempo;" . $campos . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);


$l = 0;


foreach ($llamadas as $c) {

    $campos2 = "";
    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);

    if ($c['ohactivas'] != "") {
        $ob = explode(";", $c['ohactivas']);
        $ob2 = "";
        foreach ($ob as $key => $value) {
            $ob2 .= "AES_ENCRYPT('" . $value . "','" . $this->config->item('encript') . "'),";
        }
    } else {
        $ob = $ci2->vista->getCreditos($c['documentodos'], $session['proyecto_activo']);
        $ob2 = "";
        if (count($ob) > 0) {
            foreach ($ob as $ff) {
                $ob2 .= "AES_ENCRYPT('" . $ff['obligacion'] . "','" . $this->config->item('encript') . "'),";
            }
        }else{
                $ob2 .= "AES_ENCRYPT('1','" . $this->config->item('encript') . "'),";
        }
    }


    $ob2 = substr($ob2, 0, -1);
    $ohs = $ci2->vista->getCreditosIn($ob2, $session['proyecto_activo']);
    $resu = $ci2->vista->getResultado($c['idResultado'], $session['proyecto_activo']);
    $cont = $ci2->vista->getContacto($c['idContacto'], $session['proyecto_activo']);
    $grup = $ci2->vista->getGruposContactoUno($cont[0]['idGrupo'], $session['proyecto_activo']);
    $acc = $ci2->vista->getAccion($c['idAccion'], $session['proyecto_activo']);
    $mot = $ci2->vista->getMotivo($c['idMotivo'], $session['proyecto_activo']);
    $txt = $ci2->vista->cleanText($c['textoGestion']);
    $txt = str_replace(";", "", $txt);
    $txt = str_replace(",", "", $txt);

    // $dias = $ci2->vista->restarFechas('2019-04-26', '2019-04-01'); 
    // -25


    foreach ($camposAdi as $camp1) {
        $campos2 .= $c[$camp1['nombreCampo']] . ";";
    }

    foreach ($ohs as $obl) {

        $actoh = 'Obligacion Inactiva';
        if ($obl['activo'] == 1) {
            $actoh = 'Obligacion Activa';
        }

        /* if ($obl['fechaDepuracion'] != NULL) {
          $diasDep = $ci2->vista->restarSegundos($c['fechaGestion'], $obl['fechaDepuracion']);
          } else {
          $diasDep2 = $ci2->vista->restarSegundos($c['fechaGestion'], $obl['fechaActualizacion']);
          // echo "FecGes: ". $c['fechaGestion']." fecActual ". $obl['fechaActualizacion']. "Segundos ".$diasDep2."</br>";
          if ($diasDep2 > 0 && $obl['fechaDepuracion'] == NULL) {
          $diasDep = -10;
          } else {
          $diasDep = 10;
          }
          } */


        $diasDep = 5;





        if ($diasDep > 0) {

            if ($c['ohacuerdo'] == "") {
                $actual = $session['proyecto_activo'] . ";" . $obl['obligacion'] . ";" . $c['documentodos'] . ";" . $c['fechaGestion'] . ";" . $c['hora'] . ";" . $c['telefono'] . ";" . $acc[0]['descripcion'] . ";" . $cont[0]['descripcion'] . ";" . $grup[0]['descripcion']
                        . ";" . $resu[0]['descripcion'] . ";" . $c['fechaAcuerdo'] . ";" . $c['vlAcuerdo'] . ";" . $c['ohacuerdo'] . ";" . $c['complemento'] . ";" . $txt
                        . ";" . $asesor[0]['nombre'] . ";" . $c['tiempo'] . ";";

                $campos2 = substr($campos2, 0, -1);
                $actual .= $campos2 . "\n";
                str_replace(",", ".", $actual);
                $linea .= $actual;
            } elseif ($c['ohacuerdo'] == $obl['obligacion']) {
                $actual = $session['proyecto_activo'] . ";" . $obl['obligacion'] . ";" . $c['documentodos'] . ";" . $c['fechaGestion'] . ";" . $c['hora'] . ";" . $c['telefono'] . ";" . $acc[0]['descripcion'] . ";" . $cont[0]['descripcion'] . ";" . $grup[0]['descripcion']
                        . ";" . $resu[0]['descripcion'] . ";" . $c['fechaAcuerdo'] . ";" . $c['vlAcuerdo'] . ";" . $c['ohacuerdo'] . ";" . $c['complemento'] . ";" . $txt
                        . ";" . $asesor[0]['nombre'] . ";" . $c['tiempo'] . ";";


                $campos2 = substr($campos2, 0, -1);
                $actual .= $campos2 . "\n";
                str_replace(",", ".", $actual);
                $linea .= $actual;
            }
        }
    }
    $l+=1;
}


fputs($fp, $linea);
fclose($fp);
//die();
header("Content-Disposition: attachment; filename=$short");
header("Content-Type: application/octet-stream");
header("Content-Length: " . filesize($filename));
readfile($filename);
?>
