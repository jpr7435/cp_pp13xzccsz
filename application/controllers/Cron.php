<?php

class Cron extends CI_Controller {

    private $key;

  public function __construct() {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->model('CronModel');
    $this->load->library('session');
    $this->load->library('utilidades');
    $this->key = $this->config->item('encript');
  }


  public function uploadPredictivo() {

    $fechaini = date("Y-m-d");
    $fechafin = date("Y-m-d");

    $this->CronModel->borraPredictivo('movistar');

    $predictivo = $this->CronModel->cargaPredictivo($fechaini,$fechafin, 'call_center');

    foreach($predictivo as $pr){
      $this->CronModel->guardaPredictivo($pr['id_call'],$pr['value'],$pr['phone'],$pr['status'],$pr['fecha_llamada']);
    }

    $predictivo2 = $this->CronModel->insertaPredictivo();
    foreach($predictivo2 as $pr2){

      $hora = date("H", strtotime($pr2['fecha_llamada']));
      $fecha2 = date("Y-m-d", strtotime($pr2['fecha_llamada']));

      $fechasola = explode(" ", $pr2['fecha_llamada']);

      $this->CronModel->insertaPreCallh($pr2['documento'],$pr2['telefono'],$pr2['fecha_llamada'],$hora,$fecha2,$pr2['idLlamada']);
      $this->CronModel->updateultimapred($pr2['documento'], $fechasola[0]);

    }


        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'mail.clover-team.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@clover-team.com';
        $mail->Password = '-5.Rj;84gi~6';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->setFrom('info@clover-team.com', 'Polaris BBVA Movistar');

        // Add a recipient
        $mail->addAddress('mvega@puntualmente.com.co');
        $mail->AddAttachment($rutaCompleta);


        // Email subject
        $mail->Subject = "Proceso Automatico Predictivo";
        $message = "Proceso de automatico de cargue predictivo se completo.";
        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<p>".$message."</p>";
        $mail->Body = $mailContent;

        // Send email
        if(!$mail->send()){
          echo 'Message could not be sent.';
          echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
          echo 'Message has been sent';
        }


  }












  public function smsHora() {
    $this->load->library('phpmailer_lib');
    $proyectos = $this->CronModel->getProyectos();


    foreach ($proyectos as $pr) {
      $campa = $pr['descripcion'];
      $smss = $this->CronModel->getSmsAdmin($pr['descripcion']);
      $hoy = date("Y-m-d");
      $fechaHora = date("Y-m-d H:i:s");
      $hora = date("H");
      foreach($smss as $sm){

        $diaSemana = date("N");
        $horaActual = date("H");

        $ejecutar = explode(";", $sm['peridiocidad']);
        $f = $diaSemana - 1;

        //echo $sm['hora'];
        if($ejecutar[$f] == 1 && $horaActual ==  $sm['hora']){
          echo $sm['nombre']."<br>".$sm['idtareas']."<br>";




          $condiciones = $this->CronModel->getSmsDetalle($sm['idtareas'], $pr['descripcion']);

          $sql = "select AES_DECRYPT(10_clientes.documento,  '$this->key') as documento, 10_clientes.idAsesor  from 9_creditos, 10_clientes where ";

          foreach($condiciones as $cond){

            if($cond['operador'] == 'like'){
              $valor = "'%".$cond['valor']."%'";
            }else{
              $valor = "'".$cond['valor']."'";
            }

            if($cond['valor'] == "hoy"){
              $valor = "'".date("Y-m-d")."'";
            }else if($cond['valor'] == "ayer"){
              $fecha = date("Y-m-d");
              $y =  strtotime('-1 day', strtotime($fecha));
              $valor = "'".date('Y-m-d', $y)."'";
            }else if($cond['valor'] == "menos3"){
              $fecha = date("Y-m-d");
              $y =  strtotime('-3 day', strtotime($fecha));
              $valor = "'".date('Y-m-d', $y)."'";
            }else if($cond['valor'] == "menos5"){
              $fecha = date("Y-m-d");
              $y =  strtotime('-5 day', strtotime($fecha));
              $valor = "'".date('Y-m-d', $y)."'";
            }else if($cond['valor'] == "mesanterior"){
              $fecha = date("Y-m")."-01";
              $y =  strtotime('-5 day', strtotime($fecha));
              $valor = "'".date('Y-m-d', $y)."'";
            }else if($cond['valor'] == "manana"){
              $fecha = date("Y-m")."-01";
              $y =  strtotime('+1 day', strtotime($fecha));
              $$valor = "'".date('Y-m-d', $y)."'";
            }else if($cond['valor'] == "mesanterior"){
              $fecha = date("Y-m")."-01";
              $valor = "'".$fecha."'";
            }


            $sql .= $cond['campo'].' '.$cond['operador'].' '.$valor.' and ';
          }

          $sql .= " 9_creditos.activo = '1' and 10_clientes.documento = 9_creditos.documento;";

          $result = $this->CronModel->setConsulta($sql, $pr['descripcion']);
          $usuarios = $this->CronModel->getusuariosall();
          $tareaUno = $this->CronModel->getSmsUno($sm['idtareas'], $pr['descripcion']);

          $masTarea = $tareaUno[0]['campana'];

          $this->CronModel->truncateCampana($tareaUno[0]['campana']);

          $nombreTarea = str_replace(" ", "_", $tareaUno[0]['nombre']).'_';

          foreach($result as $r){
          $tel = $this->CronModel->getDemograClienteConf($r['documento'], $pr['descripcion']);
            if(isset($tel[0]['telefono'])){
              foreach($tel as $tels){
                if(strlen($tels['telefono']) == 10){
                  $hoy = date("Y-m-d");
                  $this->CronModel->insertSmsAdmin($tels['telefono'], $tareaUno[0]['campana'], $hoy, $r['documento']);
                }
              }
            }
          }



          $nombre_archivo = "envioSMSAutomaticoAutoma".date("YmdHis")."_2.csv";
          $rutaCompleta = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/".$nombre_archivo;

          if(file_exists($rutaCompleta)) {
            $mensaje = "El Archivo $nombre_archivo se ha modificado";
          }else{
            $mensaje = "El Archivo $nombre_archivo se ha creado";
          }

          $tels = $this->CronModel->getCampanaAuto($hoy, $masTarea);
          $fh = fopen($rutaCompleta, 'w');

          $curl = curl_init();
          $cadena = 'Numero;Mensaje;Campana;Fecha;Documento'."\n";
          $contador = 0;
          $campana = $this->CronModel->getCampanaUno($tareaUno[0]['campana']);


          foreach ($tels as $b) {

            $msj = $this->CronModel->setMensaje($b['numero'], $campana[0]['idCampana'], $campana[0]['mensaje'], $hoy);


            //header("Access-Control-Allow-Origin: *");

            $fila = 0;
            $pr = 0;

            //$credenciales = 'UHVudHVhbG1lbnRlRTpQdW50dWFsbWVudGUyMDE5Kg==';
            //$url = "https://apitellit.aldeamo.com/SmsiWS/smsSendGet?mobile=".$b['numero']."&country=57&message=".urlencode($msj)."&messageFormat=1";
            //echo $url;
            //die();

            $url = 'https://dashboard.360nrs.com/api/rest/sms';
            
            $numero = "57".$b['numero'];
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic UHVudHVhbEJCVkE6TEp4bDcxISQ='));
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($curl, CURLOPT_VERBOSE,true);
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS,
            json_encode(
                        array(
                        'to' => [$numero],
                        'from' => "Rapicredit",
                        'message' => $msj
                        )
                      )
            );
          curl_exec($curl);

            $userEv = $this->CronModel->saveSmsHist($b['numero'], $campana[0]['mensaje']);
            $contador += 1;
            echo $b['numero'];

            $clean = trim(preg_replace('/\s+/', ' ', $msj));
            $cadena .= $b['numero'].";".$clean.";". $campana[0]['idCampana'].";".$hoy.";".$b['documento']."\n";


            $this->CronModel->saveGestionDos($b['documento'], $fechaHora, $hora, $b['numero'], '6', '3', '0', $sm['codigocallhist'], NULL, NULL, NULL, $clean, '130', NULL, $campa, '1');


          }

          fputs($fh, $cadena);
          fclose($fh);

        }
      }



    }







    // PHPMailer object
    $mail = $this->phpmailer_lib->load();

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host     = 'mail.clover-team.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@clover-team.com';
    $mail->Password = 'Tecnoancla2012';
    $mail->SMTPSecure = 'ssl';
    $mail->Port     = 465;

    $mail->setFrom('info@clover-team.com', 'Polaris Rapicredit');

    // Add a recipient
    $mail->addAddress('amvega@puntualmente.com.co');


    // Email subject
    $mail->Subject = "Proceso SMS Automatico";
    $message = "Proceso de creacion de SMS Automatico procesado";
    // Set email format to HTML
    $mail->isHTML(true);

    // Email body content
    $mailContent = "<p>".$message."</p>";
    $mail->Body = $mailContent;

    // Send email
    if(!$mail->send()){
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else{
      echo 'Message has been sent';
    }


  }


  public function mejorgestion() {
    $this->load->library('phpmailer_lib');
    $this->CronModel->markSingestion();
    $hoy = date("Y-m-d");
    $atras = date("Y-m")."-01";

    $gestionTotal = $this->CronModel->getGestionTotal($hoy, $atras);

    foreach($gestionTotal as $gt){
      //echo $gt['documento']." ..... "." </br>";
      if($gt['documento'] != ""){
        $mejorCL = $this->CronModel->getMejorCl($gt['documento']);

        if($mejorCL[0]['mejorgestionmes'] == 0){
          $this->CronModel->markMejorGestion($gt['documento'], $gt['idResultado']);
        }else{
          echo "mejor Cliente: ".$mejorCL[0]['mejorgestionmes']." ....... Id: ".$mejorCL[0]['idCliente']." </br>";
          $nivelCL = $this->CronModel->getNivel($mejorCL[0]['mejorgestionmes']);
          $nivelCALL = $this->CronModel->getNivel($gt['idResultado']);

          if($nivelCALL[0]['nivel'] < $nivelCL[0]['nivel']){
            $this->CronModel->markMejorGestion($gt['documento'], $gt['idResultado']);
          }
        }
      }
    }

    // PHPMailer object
    $mail = $this->phpmailer_lib->load();

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host     = 'mail.clover-team.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@clover-team.com';
    $mail->Password = 'Tecnoancla2012';
    $mail->SMTPSecure = 'ssl';
    $mail->Port     = 465;

    $mail->setFrom('info@clover-team.com', 'Polaris Rapicredit');

    // Add a recipient
    $mail->addAddress('mvega@puntualmente.com.co');


    // Email subject
    $mail->Subject = "Proceso Mejor Gestion";
    $message = "Proceso de mejor gestion procesado";
    // Set email format to HTML
    $mail->isHTML(true);

    // Email body content
    $mailContent = "<p>".$message."</p>";
    $mail->Body = $mailContent;

    // Send email
    if(!$mail->send()){
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else{
      echo 'Message has been sent';
    }


  }

  public function restarFechasMes() {
    $fecha = date("Y-m-d");
    $nuevafecha = strtotime ( '-30 day' , strtotime ( $fecha ) ) ;
    $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

    return $nuevafecha;
  }

  public function mejorgestion180() {
    $this->load->library('phpmailer_lib');

    $this->CronModel->markSingestion180();
    $hoy = date("Y-m-d");
    $atras = $this->restarFechas180();
    echo $hoy." ... ".$atras;
    $gestionTotal = $this->CronModel->getGestionTotal($hoy, $atras);
    //print_r($gestionTotal);
    //die();
    foreach($gestionTotal as $gt){
      $mejorCL = $this->CronModel->getMejorCl180($gt['documento']);

      if($mejorCL[0]['mejorgestion180'] == 0){
        $this->CronModel->markMejorGestion180($gt['documento'], $gt['idResultado'], $gt['fechagestion']);
      }else{
        echo "mejor Cliente: ".$mejorCL[0]['mejorgestion180']." ....... ".$gt['idResultado'];
        $nivelCL = $this->CronModel->getNivel($mejorCL[0]['mejorgestion180']);
        $nivelCALL = $this->CronModel->getNivel($gt['idResultado']);

        if($nivelCALL[0]['nivel'] < $nivelCL[0]['nivel']){
          $this->CronModel->markMejorGestion180($gt['documento'], $gt['idResultado'], $gt['fechagestion']);
        }
      }
    }
    // PHPMailer object
    $mail = $this->phpmailer_lib->load();

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host     = 'mail.clover-team.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@clover-team.com';
    $mail->Password = 'Tecnoancla2012';
    $mail->SMTPSecure = 'ssl';
    $mail->Port     = 465;

    $mail->setFrom('info@clover-team.com', 'Polaris BBVA');

    // Add a recipient
    $mail->addAddress('mvega@puntualmente.com.co');
    $mail->addAddress('judicial.bbva@consulegalab.co');


    // Email subject
    $mail->Subject = "Proceso Mejor Gestion 180 dias BBVA";
    $message = "Proceso de mejor gestion 180 dias BBVA procesado";
    // Set email format to HTML
    $mail->isHTML(true);

    // Email body content
    $mailContent = "<p>".$message."</p>";
    $mail->Body = $mailContent;

    // Send email
    if(!$mail->send()){
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else{
      echo 'Message has been sent';
    }

  }

  public function restarFechas180() {
    $fecha = date("Y-m-d");
    $nuevafecha = strtotime ( '-180 day' , strtotime ( $fecha ) ) ;
    $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

    return $nuevafecha;
  }



  public function setintensidad() {
    $this->load->library('phpmailer_lib');

    $this->CronModel->resetIntensidad();
    $hoy = date("Y-m-d");
    $inicio = date("Y-m")."-01";
    $gestionTotal = $this->CronModel->getGestionMes($hoy, $inicio);

    foreach($gestionTotal as $gt){
      $intesi = $this->CronModel->getIntesidadDoc($gt['documentodos']);
      $nueva = intval($intesi[0]['intesidadmes']) + 1;
      $this->CronModel->setIntesidadDoc($gt['documentodos'], $nueva);
    }
    // PHPMailer object
    $mail = $this->phpmailer_lib->load();

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host     = 'mail.clover-team.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@clover-team.com';
    $mail->Password = 'Tecnoancla2012';
    $mail->SMTPSecure = 'ssl';
    $mail->Port     = 465;

    $mail->setFrom('info@clover-team.com', 'Polaris BBVA');

    // Add a recipient
    $mail->addAddress('mvega@puntualmente.com.co');
    $mail->addAddress('judicial.bbva@consulegalab.co');


    // Email subject
    $mail->Subject = "Proceso Calculo Intesidad BBVA";
    $message = "Proceso de calculo intensidad BBVA procesado";
    // Set email format to HTML
    $mail->isHTML(true);

    // Email body content
    $mailContent = "<p>".$message."</p>";
    $mail->Body = $mailContent;

    // Send email
    if(!$mail->send()){
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else{
      echo 'Message has been sent';
    }

  }




  public function restarFechasGlobal($fechaAntigua, $hoy) {

    $segundos = strtotime($hoy) - strtotime($fechaAntigua);
    $diferencia = intval($segundos / 60 / 60 / 24);

    return $diferencia;
  }









  public function mailespecial() {
    $this->load->library('phpmailer_lib');
    $hoy = date("Y-m-d");
    $fechaH = date("Y-m-d H:i:s");
    $h = date("H");

    $clientes = $this->CronModel->getClientesEnvio();
    // PHPMailer object
    $mail = $this->phpmailer_lib->load();

    foreach($clientes as $cl){
      $correo = $this->CronModel->getMails($cl['documento']);

      if(isset($correo[0]['email'])){
        // SMTP configuration
        $mail->isSMTP();
        $mail->smtpConnect(
          array(
            "ssl" => array(
              "verify_peer" => false,
              "verify_peer_name" => false,
              "allow_self_signed" => true
            )
          )
        );
        $mail->Host     = '172.16.0.248';
        //$mail->SMTPDebug = '3';
        $mail->SMTPAuth = true;
        $mail->Username = 'coordinadorbbva@consulegalab.co';
        $mail->Password = 'ColombiaPuntual2020*-+';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('coordinadorbbva@consulegalab.co', 'CLAB BBVA');
        $mail->ClearAddresses();
        $mail->ClearAllRecipients();
        $mail->ClearAddresses();
        // Add a recipient
        $mail->addAddress($correo[0]['email']);


        // Email subject
        $mail->Subject = utf8_decode("Información Importante Banco BBVA");
        $message = "<h3>Apreciado Cliente BBVA</h3>
        <p>Soy Estephanny Galeano Asesor Especializado de CLAB para BBVA. Le informamos que hemos recibido su solicitud referente a los Alivios Financieros anunciados por el Gobierno Nacional. Le hemos intentado contactar pero no ha sido posible, por lo anterior, agradecemos nos proporcione por este medio un número de contacto para nuevamente llamarlo y brindarle mayor información al respecto.</br></br></p>
        <p><strong>Estephanny Galeano</strong></br>
        Asesor Especializado CLAB para BBVA.</br>
        Teléfono: (1)7435603
        </p>";

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = $message;
        $mail->Body = $mailContent;

        // Send email
        if(!$mail->send()){
          echo 'Message could not be sent.';
          echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{

          $this->CronModel->saveGestion($cl['documento'], $fechaH, $h, $correo[0]['email'], '5', '6', '0', '20', '', '', '', 'Se envia correo de contacto', '130', '00:00:00');

          echo 'Message has been sent';
        }

      }
    }

  }

  public function mailaprobacion() {
    $this->load->library('phpmailer_lib');
    $hoy = date("Y-m-d");
    //$hoy = "2020-03-28";
    $fechaH = date("Y-m-d H:i:s");
    $h = date("H");

    $clientes = $this->CronModel->getClientesAprobacion($hoy);


    // PHPMailer object
    $mail = $this->phpmailer_lib->load();

    foreach($clientes as $cl){
      $correo = $this->CronModel->getMails($cl['documento']);
      $ohs = $this->CronModel->getObligaciones($cl['documento']);
      $clis = $this->CronModel->getClienteUno($cl['documento']);
      $tels = $this->CronModel->getTelefonoUno($cl['documento']);

      $ohsDocu = null;
      $ohsDocu = array();

      foreach ($ohs as $ob) {
        $obsCall = $this->CronModel->getObsCall($ob['obligacion']);
        foreach ($obsCall as $callo) {
          if(isset($callo['idCallhist'])){
            $flag['obligacion'] = $callo['ohacuerdo'];
            $flag['gracia'] = str_replace("-", "", $callo['fechaAcuerdo']);
            $flag['linea'] = $ob['linea'];
            $flag['plazo'] = $callo['vlAcuerdo'];
            array_push($ohsDocu, $flag);
            $flag['obligacion'] = "";
            $flag['gracia'] = "";
            $flag['linea'] = "";
            $flag['plazo'] = "";
          }
        }
      }

      //print_r($ohsDocu);
      $tamano = sizeof($ohsDocu);
      $tamano = $tamano - 1;

      if(isset($correo[0]['email'])){
        // SMTP configuration
        $mail->isSMTP();
        $mail->smtpConnect(
          array(
            "ssl" => array(
              "verify_peer" => false,
              "verify_peer_name" => false,
              "allow_self_signed" => true
            )
          )
        );
        $mail->Host     = '172.16.0.248';
        //$mail->SMTPDebug = '3';
        $mail->SMTPAuth = true;
        $mail->Username = 'coordinadorbbva@consulegalab.co';
        $mail->Password = 'ColombiaPuntual2020*-+';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('coordinadorbbva@consulegalab.co', 'CLAB BBVA');
        $mail->ClearAddresses();
        $mail->ClearAllRecipients();
        $mail->ClearAddresses();
        // Add a recipient
        //$mail->addAddress($correo[0]['email']);
        $mail->addAddress($correo[0]['email']);
        $mail->addAddress("aliviobbva@consulegalab.co");

        // Email subject
        $mail->Subject = utf8_decode("Comunicado BBVA Correo_CE00720_".$cl['documento']);
        $message = '<!DOCTYPE html>
        <html lang="es" dir="ltr">
          <head>
            <meta charset="utf-8">
            <title></title>
          </head>
          <body>
            <div style="width: 1000px; margin: 0 auto;">
              <p style="width: 100%; text-align: center; font-size: 18px; font-weight: bold;">COMUNICADO APROBACIÓN ALIVIO FINANCIERO BBVA</p>
              <p style="width: 100%; text-align: center; font-size: 16px; font-weight: bold;">Circular 007 SFC marzo 2020</p>
              <br>
              <br>
              <br>
              <p style="font-size: 13px;"><span style="font-weight: bold;">Señor(a):</span><br>
              '.$clis[0]['nombre'].'<br>
              '.$cl['documento'].'<br>
              '.$correo[0]['email'].'<br>
              '.$tels[0]['telefono'].'<br>
              </p>
              <br>
              <br>
              <br>
              <p style="font-size: 13px;">Apreciado Cliente BBVA,</p>
              <p style="width: 100%; font-size: 13px;">Nos alegra informarle que su solicitud para obtener un periodo de gracia sobre la(s) siguiente(s) obligación(es), ha sido <span style="font-weight: bold;">Aprobada:</span></p>
              <table style="width: 800px; margin: 0 auto; border: 1px solid black; border-collapse: collapse;">
               <thead>
                 <tr style=" border: 1px solid black; border-collapse: collapse;">
                   <th style=" border: 1px solid black; border-collapse: collapse;">Producto</th>
                   <th style=" border: 1px solid black; border-collapse: collapse;">Línea crédito</th>
                   <th style=" border: 1px solid black; border-collapse: collapse;">Periodo de Gracia</th>
                   <th style=" border: 1px solid black; border-collapse: collapse;">Plazo Tarjeta</th>
                 </tr>
               </thead>
               <tbody>';
               for($i = 0; $i <= $tamano; $i++){
                 $message .= '<tr style=" border: 1px solid black; border-collapse: collapse;">
                  <td style=" border: 1px solid black; border-collapse: collapse; text-align: center;">'.$ohsDocu[$i]['obligacion'].'</td>
                   <td style=" border: 1px solid black; border-collapse: collapse; text-align: center;">'.$ohsDocu[$i]['linea'].'</td>
                   <td style=" border: 1px solid black; border-collapse: collapse; text-align: center;">'.$ohsDocu[$i]['gracia'].'</td>
                   <td style=" border: 1px solid black; border-collapse: collapse; text-align: center;">'.$ohsDocu[$i]['plazo'].'</td>
                 </tr>';
               }
               $message .= '</tbody>
              </table>
              <p style="font-size: 13px; text-align: justify;">Los pagarés y las garantías hipotecarias, mobiliarias y demás instrumentos que garanticen las obligaciones que aquí se prorrogan, modifican o amplían en su plazo total o que se nova, continuarán vigentes y garantizarán al Banco, incluso durante el periodo extendido por la presente solicitud.
                <br><br>Para sus créditos de hipotecario, consumo y/o vehículo, el periodo de gracia otorgado comprende el pago de capital, intereses y otros conceptos. Las cuotas objeto del beneficio, se trasladarán al final, extendiendo la vida del crédito, en el mismo número de meses en que se prorrogue.
                <br><br>En el caso de que usted tenga con nosotros tarjetas de crédito, se generará una transacción de rediferido que consolida el saldo total a la fecha de aplicación por los conceptos de capital, intereses y cuotas de manejo.
                <br><br>El Banco podrá instrumentar la operación con el pagaré en blanco con carta de instrucciones que se encuentra en su poder, quedando facultado para diligenciarlo de conformidad con la carta de instrucciones
                <br><br>La tasa de interés del préstamo será la misma que tenía vigente al pasado 29 de febrero y no habrá modificaciones en la calificación de su(s) crédito(s) reportado(s) en la misma fecha, ante las centrales de riesgo. La tasa de las Tarjetas de Crédito y cupos rotativos es el promedio ponderado de las compras registradas.
                <br><br>BBVA remitirá los extractos mensuales de manera informativa, situación que no implicará la solicitud del pago, por lo cual debe hacer caso omiso.
                <br><br>Contamos con su compromiso, para que al terminar el periodo de gracia, continúe atendiendo su crédito normalmente.
              </p>
              <br>
              <br>
              <br>
              <p style="font-size: 13px; text-align: justify;">Cordialmente,</p>
              <br>
              <br>
              <p style="font-size: 13px; text-align: justify; font-weight: bold;">BBVA Colombia<br>
                Creando Oportunidades
              </p>
              <br>
              <br>
              <p style="font-size: 11px; text-align: justify; font-weight: bold;">En caso de cualquier aclacración o rectificación por favor comuniquese en las siguientes 48 horas al teléfono: (1) 7435603.</p>
            </div>
          </body>
        </html>';

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = $message;
        $mail->Body = $mailContent;

        // Send email
        if(!$mail->send()){
          echo 'Message could not be sent.';
          echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{

          $this->CronModel->saveGestion($cl['documento'], $fechaH, $h, $correo[0]['email'], '5', '6', '0', '21', '', '', '', 'Se envia correo de soporte de alivio', '130', '00:00:00');

          echo 'Message has been sent';
        }

      }
    }

  }



  public function restarFechas() {
    $fecha = date("Y-m-d");
    $nuevafecha = strtotime ( '-25 day' , strtotime ( $fecha ) ) ;
    $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

    return $nuevafecha;
  }
}

?>
