<?php

class Cron extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->model('CronModel');
    $this->load->library('session');
    $this->load->library('utilidades');
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
        $mail->Username = 'coordinadorbbva@consulegalab.com';
        $mail->Password = 'ColombiaPuntual2020*-+';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('coordinadorbbva@consulegalab.com', 'CLAB BBVA');
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

          $this->CronModel->saveGestion($cl['documento'], $fechaH, $h, $correo[0]['email'], '5', '6', '0', '20', '', '', '', 'Se envia correo de contacto', '1', '00:00:00');

          echo 'Message has been sent';
        }

      }
    }

  }

  public function mailaprobacion() {
    $this->load->library('phpmailer_lib');
    $hoy = date("Y-m-d");
    $fechaH = date("Y-m-d H:i:s");
    $h = date("H");

    $clientes = $this->CronModel->getClientesAprobacion($hoy);

    
    // PHPMailer object
    $mail = $this->phpmailer_lib->load();

    foreach($clientes as $cl){
      $correo = $this->CronModel->getMails($cl['documento']);
      $ohs = $this->CronModel->getObligaciones($cl['documento']);

      print_r($ohs);
      die();
      $ohsClientes = array();

      foreach ($ohs as $ob) {
        // code...
      }


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
        $mail->Username = 'coordinadorbbva@consulegalab.com';
        $mail->Password = 'ColombiaPuntual2020*-+';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('coordinadorbbva@consulegalab.com', 'CLAB BBVA');
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
        /*if(!$mail->send()){
          echo 'Message could not be sent.';
          echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{

          $this->CronModel->saveGestion($cl['documento'], $fechaH, $h, $correo[0]['email'], '5', '6', '0', '20', '', '', '', 'Se envia correo de contacto', '1', '00:00:00');

          echo 'Message has been sent';
        }*/

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
