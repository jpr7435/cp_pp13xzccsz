<?php

class Sms extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->library('utilidades');
    }
    

    public function sms2() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('herramientas/sms2', $data);
        $this->load->view('templates/footer', $data);

    }
    
    public function mail() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        
        $data['campanas'] = $this->SmsModel->getCampanas();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('herramientas/mail', $data);
        $this->load->view('templates/footer', $data);

    }
    
     public function virtual($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        
        $data['base'] = $this->SmsModel->getBaseEnvio($slug);
        $data['campana'] = $this->SmsModel->getCampanaUno($slug);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('herramientas/virtual', $data);
        $this->load->view('templates/footer', $data);

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
