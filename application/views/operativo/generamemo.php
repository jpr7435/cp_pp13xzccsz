<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

ini_set('memory_limit', '5048M');
ini_set('max_execution_time', 0);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model('vista');

$flag = 0;
$documentos = '';


$ci2->vista->descriptDoc($session['proyecto_activo']);
echo "2-";
$ci2->vista->borraFeedbackTemp1($session['proyecto_activo']);
echo "3-";
$ci2->vista->borraFeedbackTemp2($session['proyecto_activo']);
echo "4-";
//$ci2->vista->createFeedbackTemp1($fechaini, $fechafin, $session['proyecto_activo']);
echo "5-";
$ci2->vista->createMemo($session['proyecto_activo']);
echo "6- MEMO GENERADO";
?>
