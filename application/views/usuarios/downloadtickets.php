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

$nombre = "DetalleTicketsAbiertos";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';

$linea .= "Id Ticket;Descripcion;Fecha Creacion;Creado;Tipo;Gerente;Usuario afectado;Grupo;Estado Ticket;Respuesta Gerente;Respuesta RH" . "\n";

$l = 0;


foreach ($ticketList as $u) {


    $perfil = $ci2->vista->getPerfilName($u['idPerfil'], $session['proyecto_activo']);
    $estado = "";
    if($u['idestado'] == 1){
      $estado = "Abierto";
    }else{
      $estado = "Cerrado";
    }
    $empresa = $ci2->vista->getTiposUno($u['idtipo']);
    $grupo = $ci2->vista->getGruposUno($u['idgrupo']);
    $nivel = $ci2->vista->getNivelUno($u['idnivel']);
    $gerente = $ci2->vista->getusuario($u['idgerente']);
    $afectado = $ci2->vista->getusuario($u['idusuarioticket']);
    $creado = $ci2->vista->getusuario($u['idUsuarioCreado']);
    $subtipo = $ci2->vista->getsubtipo($u['idsubtipo']);

    $respG = "Pendiente";
    $respR = "Pendiente";

    if($u['respgerente'] == 1){
      $respG = "Aprobado";
    }else if($u['respgerente'] == 2){
      $respG = "Rechazo";
    }

    if($u['resptalento'] == 1){
      $respR = "Aprobado";
    }else if($u['resptalento'] == 2){
      $respR = "Rechazo";
    }

    $actual = $u['idTicket'] . ";" . $u['descripcion']. ";" . $u['fechacreacion'] . ";" . $creado[0]['nombre'] . ";" . $subtipo[0]['descripcion']
     . ";" . $gerente[0]['nombre'] . ";" . $afectado[0]['nombre'] . ";" .  $grupo[0]['descripcion']  . ";" .  $estado  . ";" .  $respG  . ";" .  $respR . "\n";

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
