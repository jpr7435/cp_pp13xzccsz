<?php

class Asterisk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Issabel');
        $this->load->library('session');
        $this->load->library('utilidades');
    }

    public function getCallEntry() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $tele = $_COOKIE['origen_activo'];
        $data['calls'] = $this->Issabel->getCalls($tele);

        print_r($data['calls']);
        die();

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
