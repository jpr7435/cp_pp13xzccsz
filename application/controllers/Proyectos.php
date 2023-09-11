<?php

class Proyectos extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->model('Projectmodel');
    $this->load->library('session');
    $this->load->library('utilidades');
  }

  public function addproject() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $data['usuarios'] = $this->Projectmodel->getusuarios();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('pages/addproject', $data);
    $this->load->view('templates/footer', $data);
  }

  public function saveproject() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $titulo = $this->input->post("titulo");
    $desc = $this->input->post("descripcion");
    $cola = $this->input->post("colaboradores");

    $users = "";
    foreach($cola as $clave => $valor){
      $users .= $valor.";";
    }

    $users .= $data['session']['id'];
    $hoy = date("Y-m-d H:i:s");


    $this->load->library('email');

    $this->Projectmodel->saveproject($titulo, $desc, $users, $data['session']['id'], $hoy);
    die();
    foreach($cola as $clave => $valor){

      $subject = 'Se ha creado el ticket No: ' . $id[0]['maximo'];
      $message = '<h1>' . $titulo . '</h1>'
      . '<p>' . $desc . '</p>';

      // Get full html:
      $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
          <meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
          <title>' . html_escape($subject) . '</title>
          <style type="text/css">
          body {
            font-family: Arial, Verdana, Helvetica, sans-serif;
            font-size: 16px;
          }
          </style>
        </head>
        <body>
        ' . $message . '
        </body>
      </html>';


      $result = $this->email
      ->from('ticketspuntualmente.com.co')
      //->to($mail1[0]['email'])
      ->to($mail1)
      ->subject($subject)
      ->message($body)
      ->send();

      //var_dump($result);
    }

    echo "<script>location.href='" . $this->config->item("host_cobranzas") . "/index.php/projectlist';</script>";


  }

  public function projectlist() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $data['proyectosactivos'] = $this->Projectmodel->getproyectos('1', $data['session']['id']);
    $data['proyectoscerrados'] = $this->Projectmodel->getproyectos('0', $data['session']['id']);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('pages/projectlist', $data);
    $this->load->view('templates/footer', $data);
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
