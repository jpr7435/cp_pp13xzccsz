<?php

class Sms extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('SmsModel');
        $this->load->library('session');
        $this->load->library('utilidades');
    }

    public function smsentrada() {

        print_r($_GET);

    }

    public function campanas() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $data['campanas'] = $this->SmsModel->getCampanas();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('sms/campanas', $data);
        $this->load->view('templates/footer', $data);

    }

    public function createcampana() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $data['campanas'] = $this->SmsModel->getCampanas();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('sms/createcampana', $data);
        $this->load->view('templates/footer', $data);

    }

     public function envio($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $data['base'] = $this->SmsModel->getBaseEnvio($slug);
        $data['campana'] = $this->SmsModel->getCampanaUno($slug);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('sms/enviosms', $data);
        $this->load->view('templates/footer', $data);

    }

    public function uploadsms() {

       $this->session->valida();
       $data['session'] = $this->session->getSessionData();

       $campana = $this->input->post('campana-activa-base');
       $fecha = date("Y-m-d");

       $data['base'] = $this->SmsModel->getBaseEnvio($campana);
       $data['campana'] = $this->SmsModel->getCampanaUno($campana);

       $mi_archivo = 'file-envio';
       $config['upload_path'] = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/";
       $config['file_name'] = "sms";
       $config['allowed_types'] = "*";
       $config['max_size'] = "50000";

       $this->load->library('upload', $config);

       if (!$this->upload->do_upload($mi_archivo)) {
//*** ocurrio un error
           $data['uploadError'] = $this->upload->display_errors();

           echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
           //echo "<script>location.href='http://]" . $_SERVER['HTTP_HOST'] . "/index.php/importarinicial/" . $data['session']['proyecto_activo'] . "'</script>";
           return;
       } else {
//$data['uploadSuccess'] = $this->upload->data();
           //$this->utilidades->saveEvent("cargue base sms", $data['session']['id'], $data['session']['proyecto_activo']);
           $datas = array('upload_data' => $this->upload->data());
           $fila = 1;

           $filesname = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $datas['upload_data']['file_name'];
           if (($archivo = fopen("/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $datas['upload_data']['file_name'], "r")) !== false) {

               while (($datos = fgetcsv($archivo, 50000, ";")) !== FALSE) {
                   $numero = count($datos);

                   $numero = $datos[0];
                   $documento = $datos[1];
                   $opcion1 = $datos[2];
                   $opcion2 = $datos[3];
                   $opcion3 = $datos[4];
                   $opcion4 = $datos[5];

                   $this->SmsModel->uploadBase($numero, $documento, $opcion1, $opcion2, $opcion3, $opcion4, $fecha, $data['session']['id'], $campana);
               }
               fclose($archivo);
               //unlink($archivo);
           }
       }
       echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/smsdetallecampana/" . $campana . "'</script>";

   }


   public function saverespuesta() {

      $this->session->valida();
      $data['session'] = $this->session->getSessionData();

      $campana = $this->input->post('campana-activa-respuesta');
      $codigo = $this->input->post('codigo-new-sms');
      $respuesta = $this->input->post('respuesta-new-sms');
      $fecha = date("Y-m-d");

      $data['campana'] = $this->SmsModel->getCampanaUno($campana);

      $this->SmsModel->saveRespuesta($codigo, $respuesta, $campana);


      echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/smsdetallecampana/" . $campana . "'</script>";

  }

    public function savemsg() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $msg = $this->input->post('mensaje');
        $campa = $this->input->post('campana');

        $this->SmsModel->saveMsg($msg, $campa);
    }

    public function savecampana() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $nombre = $this->input->post('nombre-campana');
        $desc = $this->input->post('desc-campana');
        $fecha = date("Y-m-d H:i:s");
        $this->SmsModel->saveCampana($nombre, $desc, $data['session']['id'],$fecha);

        echo "<script>location.href='http://".$_SERVER['HTTP_HOST']."/index.php/sms/campana';</script>";

    }

    public function setMensaje($msj,$campana) {

        $data = $this->SmsModel->getBaseCamposUno($campana);

        if(isset($data[0]['opcion1'])){
          if($data[0]['opcion1'] != ""){
            $msj = str_replace("<<opcion1>>", $data[0]['opcion1'], $msj);
          }
        }
        if(isset($data[0]['opcion2'])){
          if($data[0]['opcion1'] != ""){
            $msj = str_replace("<<opcion2>>", $data[0]['opcion2'], $msj);
          }
        }
        if(isset($data[0]['opcion3'])){
          if($data[0]['opcion3'] != ""){
            $msj = str_replace("<<opcion3>>", $data[0]['opcion3'], $msj);
          }
        }
        if(isset($data[0]['opcion4'])){
          if($data[0]['opcion4'] != ""){
            $msj = str_replace("<<opcion4>>", $data[0]['opcion4'], $msj);
          }
        }

        return $msj;
    }

    public function detallecampana($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $data['campana'] = $this->SmsModel->getCampanaUno($slug);
        $data['respuestas'] = $this->SmsModel->getRespuestasCampana($slug);
        $data['preview'] = $this->setMensaje($data['campana'][0]['mensaje'], $slug);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('sms/detalle', $data);
        $this->load->view('templates/footer', $data);

    }

    public function exportainformeabandonadas() {

      $this->session->valida();
      $data['session'] = $this->session->getSessionData();


      $data['ini'] = $this->input->post('fechaIni');
      $data['fin'] = $this->input->post('fechaFin');
      // $this -> load -> library('Estadocartera');

      $prefechaini = explode("/", $data['ini']);
      $fechaini = $prefechaini[2]."-".$prefechaini[0]."-".$prefechaini[1];
      $prefechafin = explode("/", $data['fin']);
      $fechafin = $prefechafin[2]."-".$prefechafin[0]."-".$prefechafin[1];
      $tipo = "Salida";

      $data['informe'] = $this->Issabel->getTotalInformeAbandonadas($tipo, $fechaini, $fechafin, $data['session']['proyecto_activo']);
      $this->load->view('operativo/exportainformeabandonadas', $data);
    }

    /*
     *
     *
     * Funciones de template
     *
     *
     */

    public function sidebaruserprofile() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->view('blocks/sidebar-user-profile', $data);
    }

    public function materialsidebar() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->view('blocks/menus/material-sidebar', $data);
    }

    public function appsdropdown() {

        $this->session->valida();

        $this->load->view('blocks/navbar/apps-dropdown');
    }

    public function userdropdown() {

        $this->session->valida();

        $this->load->view('blocks/navbar/user-dropdown');
    }
    public function ticketsdropdown() {

        $this->session->valida();

        $this->load->view('blocks/navbar/tickets-dropdown');
    }

    public function rightbar() {

        $this->session->valida();

        $this->load->view('blocks/rightbar/rightbar');
    }

    public function chat() {

        $this->session->valida();

        $this->load->view('blocks/rightbar/chat');
    }

    public function notifications() {

        $this->session->valida();

        $this->load->view('blocks/rightbar/notifications');
    }

    public function activities() {

        $this->session->valida();

        $this->load->view('blocks/rightbar/activities');
    }

    public function cart() {

        $this->session->valida();

        $this->load->view('blocks/rightbar/cart');
    }

    public function settings() {

        $this->session->valida();

        $this->load->view('blocks/rightbar/settings');
    }

    /*
     *
     *
     * FIN Funciones de template
     *
     *
     */
}

?>
