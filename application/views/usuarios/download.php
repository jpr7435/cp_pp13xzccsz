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

$nombre = "DetalleUsuarios";
$fecha = date("Ymd");

$short = $nombre . $fecha . ".csv";
$filename = $this->config->item('ruta_local')."/informes/" . $nombre . $fecha . ".csv";

$archivo = $filename;
$fp = fopen($archivo, "w");

$linea = '';

$linea .= "Id Usuario;Usuario;Nombre;Perfil;Meta;Fecha Ultimo Ingreso;Fecha Actualizacion;Fecha Creacion;Fecha Desactivacion;Estado;Usuario App;Grupo;Empresa;Nivel;Codigo Empleado;Fecha Ingreso;Jefe" . "\n";

$l = 0;


foreach ($usuariosList as $u) {


    $perfil = $ci2->vista->getPerfilName($u['idPerfil'], $session['proyecto_activo']);
    $estado = $ci2->vista->getEstados($u['idEstado'], $session['proyecto_activo']);
    $empresa = $ci2->vista->getTiposUno($u['idtipo']);
    $grupo = $ci2->vista->getGruposUno($u['idgrupo']);
    $nivel = $ci2->vista->getNivelUno($u['idnivel']);
    $jefe = $ci2->vista->getusuario($u['idjefe']);

    $actual = $u['idUsuario'] . ";" . $u['usuario']. ";" . $u['nombre'] . ";" . $perfil[0]['descripcion'] . ";" . $u['meta'] . ";" . $u['fechaUltimoIngreso']
     . ";" . $u['fechaActualizacion'] . ";" . $u['fechaCreacion'] . ";" . $u['fechaDesactivacion']  . ";" . $estado[0]['descripcion'] . ";" . $u['usuario_app'] . ";" . $grupo[0]['descripcion']
     . ";" . $empresa[0]['descripcion'] . ";" . $nivel[0]['descripcion'] . ";" . $u['codigoempleado'] . ";" . $u['fechaContratacion'] . ";" . $jefe[0]['nombre'] . "\n";

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
