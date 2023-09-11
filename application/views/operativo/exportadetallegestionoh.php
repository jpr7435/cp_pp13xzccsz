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

$nombre = "InformeDetalleLLamadasObligacion";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';
$activo = "";
$agregado = "";
$campos = "";
$campos2 = "";

foreach($camposAdi as $camp){

  $campos .= $camp['nombreCampo'].";";

}
$campos = substr($campos, 0, -1);

$linea .= "Documento;Obligacion;Estado Obligacion;Fecha Gestion;Hora;Telefono;Accion; Contacto; Motivo; Resultado; Fecha Acuerdo; Valor Acuerdo; Complemento; Texto Gestion; Asesor;Tiempo;".$campos . "\n";

//$cartera = $ci2->vista->getTelefonosCasa($casa, $nameproyect);


$l = 0;


foreach ($llamadas as $c) {

    $campos2 = "";
    $asesor = $ci2->vista->getusuario($c['idAsesor'], $session['proyecto_activo']);
    $ohs = $ci2->vista->getCreditos($c['documentodos'], $session['proyecto_activo']);
    $resu = $ci2->vista->getResultado($c['idResultado'], $session['proyecto_activo']);
    $cont = $ci2->vista->getContacto($c['idContacto'], $session['proyecto_activo']);
    $acc = $ci2->vista->getAccion($c['idAccion'], $session['proyecto_activo']);
    $mot = $ci2->vista->getMotivo($c['idMotivo'], $session['proyecto_activo']);
    $txt = $ci2->vista->cleanText($c['textoGestion']);
    $txt = str_replace(";","",$txt);
    $txt = str_replace(",","",$txt);

    foreach($ohs as $obl){
      $actoh = 'Obligacion Inactiva';
      if($obl['activo'] == 1){
        $actoh = 'Obligacion Activa';
      }

        $actual = $c['documentodos'] . ";" . $obl['obligacion']. ";" . $actoh . ";" . $c['fechaGestion']. ";" . $c['hora'] . ";" . $c['telefono'] . ";" . $acc[0]['descripcion'] . ";" . $cont[0]['descripcion']
         . ";" . $mot[0]['descripcion'] . ";" . $resu[0]['descripcion'] . ";" . $c['fechaAcuerdo']  . ";" . $c['vlAcuerdo']  . ";" . $c['complemento']  . ";" . $txt
         . ";" . $asesor[0]['usuario']  . ";" . $c['tiempo']. ";" ;

         foreach($camposAdi as $camp1){
           $campos2 .= $c[$camp1['nombreCampo']].";";
         }
         $campos2 = substr($campos2, 0, -1);

          $actual .= $campos2 . "\n";
        str_replace(",", ".", $actual);
        $linea .= $actual;

    }
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
