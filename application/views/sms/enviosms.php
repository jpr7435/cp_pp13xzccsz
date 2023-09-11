<?php
header("Access-Control-Allow-Origin: *");
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vistasms");

$carteras = explode(";", $session['carteras']);

$fila = 0;
$pr = 0;
/*
*
* user: "contacto@puntualmente.com.co",
password: "P6tsd4f1Ig"
*/
//https://sistemasmasivos.com/envio/api/sendsms/send.php?user=miusuario@hotmail.com&password=miclave&GSM=573117807125,57111,573802338546,573002333333&SMSText=mensaje de prueba enviado por metodo WEB
?>

<section class="main-container">

  <!-- Page header -->
  <div class="header">
    <div class="header-content">
      <div class="page-title">
        <i class="icon-file-empty position-left"></i> Envio de Campa&ntilde;a
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">
    <div style="clear: both; height: 25px;"></div>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">

          <?php

          $curl = curl_init();
           foreach ($base as $b) {

            $msj = $ci2->vistasms->setMensaje($b['numero'], $campana[0]['idCampana'], $campana[0]['mensaje']);
            ?>

            <?php
            header("Access-Control-Allow-Origin: *");
            /* * To change this template, choose Tools | Templates * and open the template in the editor. */
            $ci2 = &get_instance();
            //$us = $ci3->load->model("usuarios");
            //$ci2 = &get_instance();
            $ci2->load->model("vistasms");

            $carteras = explode(";", $session['carteras']);

            $fila = 0;
            $pr = 0;


            $credenciales = 'UHVudHVhbG1lbnRlRTpQdW50dWFsbWVudGUyMDE5Kg==';

            $url = "https://apitellit.aldeamo.com/SmsiWS/smsSendGet?mobile=".$b['numero']."&country=57&message=".urlencode($msj)."&messageFormat=1";
            //echo $url;
            //die();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: UHVudHVhbG1lbnRlRTpQdW50dWFsbWVudGUyMDE5Kg==','Content-Type: multipart/form-data'));
            curl_setopt($curl, CURLOPT_VERBOSE,true);
            curl_setopt($curl, CURLOPT_HEADER, true);
            //curl_setopt($curl, CURLOPT_POST, true);
            /*curl_setopt($curl, CURLOPT_POSTFIELDS,
            array(
            'routes-file' => '@' . $rutaCompleta
            )
          );*/
          //curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_exec($curl);
          ?>

          <?php
          $userEv = $ci2->vistasms->saveSmsHist($b['numero'], $campana[0]['mensaje']);
          echo $b['numero']; ?>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
</section>
