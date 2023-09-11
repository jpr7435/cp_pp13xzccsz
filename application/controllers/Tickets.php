<?php

class Tickets extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Ticketsmodel');
        $this->load->library('session');
        $this->load->library('utilidades');
    }

    public function addticket() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $data['tipo'] = $this->Ticketsmodel->gettipo();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/addtickets', $data);
        $this->load->view('templates/footer', $data);
    }

    public function saveticket() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $titulo = $this->input->post('titulo');
        $desc = $this->input->post('descripcion');
        $tipo = $this->input->post('tipo');
        $fecha = date("Y-m-d H:i:s");

        $copias = $this->Ticketsmodel->getTipoUno($tipo);
        $coordi = $this->Ticketsmodel->getEmailCoordinador($data['session']['proyecto'], $data['session']['proyecto_activo']);
        $asig = "";


        foreach ($coordi as $valor2) {
            $asig .= $valor2['idUsuario'] . ",";
        }
            //$asig .= $resp[0]['encargado'];
            $asig = substr($asig, 0, -1);

        $this->Ticketsmodel->saveTicket($titulo, $desc, $tipo, $data['session']['proyecto'], $data['session']['id'], $fecha, '1', $asig,$data['session']['proyecto_activo']);
        $id = $this->Ticketsmodel->getLastTicket();

        $rutaTotal = $this->config->item('rutalocal') . $id[0]['maximo'];

        if (!file_exists($rutaTotal)) {
            mkdir($rutaTotal, 0777, true);
            chmod($rutaTotal, 0777);
        }

        $rutaTotal .= "/";

        $mi_archivo = 'archivo';
        $config['upload_path'] = $rutaTotal;
        $config['allowed_types'] = "*";
        $config['max_size'] = "50000";

        $this->load->library('upload', $config);
        if (!empty($_FILES['adjunto1']['name'])) {
            if (!$this->upload->do_upload('adjunto1')) {
                //*** ocurrio un error
                $data['uploadError'] = $this->upload->display_errors();

                echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
                return;
            } else {
                $datas = array('upload_data' => $this->upload->data());
                $this->Ticketsmodel->savebilioteca($id[0]['maximo'], $datas['upload_data']['file_name'], $datas['upload_data']['file_ext'], $fecha, $data['session']['id'], $data['session']['proyecto']);
                $this->utilidades->saveEvent("carga archivo" . $datas['upload_data']['file_name'], $data['session']['id'], '0');
            }
        }
        if (!empty($_FILES['adjunto2']['name'])) {
            if (!$this->upload->do_upload('adjunto2')) {
                //*** ocurrio un error
                $data['uploadError'] = $this->upload->display_errors();

                echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
                return;
            } else {
                $datas = array('upload_data' => $this->upload->data());
                $this->Ticketsmodel->savebilioteca($id[0]['maximo'], $datas['upload_data']['file_name'], $datas['upload_data']['file_ext'], $fecha, $data['session']['id'], $data['session']['proyecto']);
                $this->utilidades->saveEvent("carga archivo" . $datas['upload_data']['file_name'], $data['session']['id'], '0');
            }
        }
        if (!empty($_FILES['adjunto3']['name'])) {
            if (!$this->upload->do_upload('adjunto3')) {
                //*** ocurrio un error
                $data['uploadError'] = $this->upload->display_errors();

                echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
                return;
            } else {
                $datas = array('upload_data' => $this->upload->data());
                $this->Ticketsmodel->savebilioteca($id[0]['maximo'], $datas['upload_data']['file_name'], $datas['upload_data']['file_ext'], $fecha, $data['session']['id'], $data['session']['proyecto']);
                $this->utilidades->saveEvent("carga archivo" . $datas['upload_data']['file_name'], $data['session']['id'], '0');
            }
        }
        if (!empty($_FILES['adjunto4']['name'])) {
            if (!$this->upload->do_upload('adjunto4')) {
                //*** ocurrio un error
                $data['uploadError'] = $this->upload->display_errors();

                echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
                return;
            } else {
                $datas = array('upload_data' => $this->upload->data());
                $this->Ticketsmodel->savebilioteca($id[0]['maximo'], $datas['upload_data']['file_name'], $datas['upload_data']['file_ext'], $fecha, $data['session']['id'], $data['session']['proyecto']);
                $this->utilidades->saveEvent("carga archivo" . $datas['upload_data']['file_name'], $data['session']['id'], '0');
            }
        }

        //$data['session']


        $todose = explode(",", $copias[0]['encargado']);
        $mail1 = "";
        $premail1 = "";
        $mail2 = "";

        foreach ($todose as $valor) {
            //$premail1 = $this->Ticketsmodel->getEmailUser($valor, $data['session']['proyecto_activo']);
            $mail1 .= $valor . ",";
        }



        foreach ($coordi as $valor) {
            $mail2 .= $valor['email'] . ",";
        }



        $mail2 = substr($mail2, 0, -1);

        $mail1 = substr($mail1, 0, -1);

        $create =  $this->Ticketsmodel->getEmailUser($data['session']['id'], $data['session']['proyecto_activo']);

        $this->load->library('email');


        $subject = 'Se ha creado el ticket No: ' . $id[0]['maximo'];
        $message = '<h1>' . $titulo . '</h1>'
                . '<p>' . $desc . '</p></br>'
                . '<p>Enviado por: '.$create[0]['nombre'].' </p></br>'
                . '<p>Cartera: '.$data['session']['proyecto_activo'].'</p></br>'
                . '<p>Coordinador: '.$coordi[0]['nombre']."</p>";

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
// Also, for getting full html you may use the following internal method:
//$body = $this->email->full_html($subject, $message);
        //$mailes = "andresl.vargasduarte@gmail.com,av.solucionsistemas@gmail.com";

        $result = $this->email
                ->from('ticketspuntualmente.com.co')
                //->to($mail1[0]['email'])
                ->to($mail2)
                ->cc($mail1)
                ->subject($subject)
                ->message($body)
                ->send();

        var_dump($result);
        //echo '<br />';
        //echo $this->email->print_debugger();


        echo "<script>location.href='" . $this->config->item("host_cobranzas") . "/index.php/opentickets';</script>";
    }

    public function opentickets() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $data['tickets'] = $this->Ticketsmodel->getTickets("1", $data['session']['id']);
        $data['estado'] = "1";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/ticketlist', $data);
        $this->load->view('templates/footer', $data);
    }

    public function closedtickets() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $data['tickets'] = $this->Ticketsmodel->getTickets("2", $data['session']['id']);
        $data['estado'] = "2";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/ticketlist', $data);
        $this->load->view('templates/footer', $data);
    }

    public function tasktickets() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        if($data['session']['perfil'] == 2){

          $data['tipot'] = $this->Ticketsmodel->gettipo();

          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('pages/ticketlistadmin', $data);
          $this->load->view('templates/footer', $data);

        }else{

          $data['tickets'] = $this->Ticketsmodel->getTicketsTask("1", $data['session']['id']);
          $data['estado'] = "2";

          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('pages/ticketlist', $data);
          $this->load->view('templates/footer', $data);

        }


    }

    public function detalleticket($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $data['ticket'] = $this->Ticketsmodel->getTicketUno($slug);
        $data['archivoscl'] = $this->Ticketsmodel->getArchivosCliente($slug);
        $data['actividades'] = $this->Ticketsmodel->getActividades($slug);
        $data['slug'] = $slug;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/detalleticket', $data);
        $this->load->view('templates/footer', $data);
    }

    public function saverespuesta() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $desc = $this->input->post('respuesta');
        $id = $this->input->post('ticket');
        $fecha = date("Y-m-d H:i:s");

        $resp = $this->Ticketsmodel->getTicketUno($id);


        $this->Ticketsmodel->saveRespuesta($desc, $id, $fecha, $data['session']['id'], $resp[0]['desc_proyecto']);

        $rutaTotal = $this->config->item('rutalocal') . $id;

        if (!file_exists($rutaTotal)) {
            mkdir($rutaTotal, 0777, true);
            chmod($rutaTotal, 0777);
        }

        $rutaTotal .= "/";

        $mi_archivo = 'archivo';
        $config['upload_path'] = $rutaTotal;
        $config['allowed_types'] = "*";
        $config['max_size'] = "50000";

        $this->load->library('upload', $config);
        if (!empty($_FILES['adjunto1']['name'])) {
            if (!$this->upload->do_upload('adjunto1')) {
                //*** ocurrio un error
                $data['uploadError'] = $this->upload->display_errors();

                echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
                return;
            } else {
                $datas = array('upload_data' => $this->upload->data());
                $this->Ticketsmodel->savebilioteca($id[0]['maximo'], $datas['upload_data']['file_name'], $datas['upload_data']['file_ext'], $fecha, $data['session']['id'], $data['session']['proyecto']);
                $this->utilidades->saveEvent("carga archivo" . $datas['upload_data']['file_name'], $data['session']['id'], '0');
            }
        }
        if (!empty($_FILES['adjunto2']['name'])) {
            if (!$this->upload->do_upload('adjunto2')) {
                //*** ocurrio un error
                $data['uploadError'] = $this->upload->display_errors();

                echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
                return;
            } else {
                $datas = array('upload_data' => $this->upload->data());
                $this->Ticketsmodel->savebilioteca($id[0]['maximo'], $datas['upload_data']['file_name'], $datas['upload_data']['file_ext'], $fecha, $data['session']['id'], $data['session']['proyecto']);
                $this->utilidades->saveEvent("carga archivo" . $datas['upload_data']['file_name'], $data['session']['id'], '0');
            }
        }
        if (!empty($_FILES['adjunto3']['name'])) {
            if (!$this->upload->do_upload('adjunto3')) {
                //*** ocurrio un error
                $data['uploadError'] = $this->upload->display_errors();

                echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
                return;
            } else {
                $datas = array('upload_data' => $this->upload->data());
                $this->Ticketsmodel->savebilioteca($id[0]['maximo'], $datas['upload_data']['file_name'], $datas['upload_data']['file_ext'], $fecha, $data['session']['id'], $data['session']['proyecto']);
                $this->utilidades->saveEvent("carga archivo" . $datas['upload_data']['file_name'], $data['session']['id'], '0');
            }
        }
        if (!empty($_FILES['adjunto4']['name'])) {
            if (!$this->upload->do_upload('adjunto4')) {
                //*** ocurrio un error
                $data['uploadError'] = $this->upload->display_errors();

                echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
                return;
            } else {
                $datas = array('upload_data' => $this->upload->data());
                $this->Ticketsmodel->savebilioteca($id[0]['maximo'], $datas['upload_data']['file_name'], $datas['upload_data']['file_ext'], $fecha, $data['session']['id'], $data['session']['proyecto']);
                $this->utilidades->saveEvent("carga archivo" . $datas['upload_data']['file_name'], $data['session']['id'], '0');
            }
        }

        //$mail1 = $this->Ticketsmodel->getEmailUser($resp[0]['idUsuarioAsignado']);
        $mail3 = $this->Ticketsmodel->getEmailUser($resp[0]['idUsuarioCreado'], $resp[0]['desc_proyecto']);

        $coordi = $this->Ticketsmodel->getEmailCoordinador($resp[0]['idProyecto'], $resp[0]['desc_proyecto']);

        $todose = explode(",", $resp[0]['idUsuarioAsignado']);
        $mail1 = "";
        $premail1 = "";
        $mail2 = "";

        foreach ($todose as $valor) {
            $premail1 = $this->Ticketsmodel->getEmailUser($valor, $resp[0]['desc_proyecto']);
            $mail1 .= $premail1[0]['email'] . ",";
        }

        foreach ($coordi as $valor) {
            $mail2 .= $valor['email'] . ",";
        }

        $mail2 .= $mail3[0]['email'];

        $mail1 = substr($mail1, 0, -1);

        $this->load->library('email');

        $subject = 'Nueva actividad en el ticket No: ' . $id;
        $message = '<p>' . $desc . '</p></br></br>';

        $message .= '<h1>' . $resp[0]['titulo'] . '</h1>'
                . '<p>' . $resp[0]['descripcion'] . '</p></br>'
                . '<p>Fecha de creacion: '. $resp[0]['fechacreacion'] .' </p></br>';


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
// Also, for getting full html you may use the following internal method:
//$body = $this->email->full_html($subject, $message);

        $result = $this->email
                ->from('ticketspuntualmente.com.co')
                ->to($mail1)
                ->cc($mail2)
                ->subject($subject)
                ->message($body)
                ->send();

        var_dump($result);
        //echo '<br />';
        //echo $this->email->print_debugger();

        echo "<script>location.href='" . $this->config->item("host_cobranzas") . "/index.php/detalleticket/" . $id . "';</script>";
    }

    public function closeticket() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $id = $this->input->post('ticketid');
        $fecha = date("Y-m-d H:i:s");

        $resp = $this->Ticketsmodel->getTicketUno($id);

        $this->Ticketsmodel->closeTicket($id, $fecha, $data['session']['id']);
        $todose = explode(",", $resp[0]['idUsuarioAsignado']);
        $mail1 = "";
        $premail1 = "";

        foreach ($todose as $valor) {
            $premail1 = $this->Ticketsmodel->getEmailUser($valor, $resp[0]['desc_proyecto']);
            $mail1 .= $premail1[0]['email'] . ",";
        }
        //$mail1 = $this->Ticketsmodel->getEmailUser($resp[0]['idUsuarioAsignado'], $data['session']['proyecto_activo']);
        $mail2 = $this->Ticketsmodel->getEmailUser($resp[0]['idUsuarioCreado'], $resp[0]['desc_proyecto']);

        $mail1 = substr($mail1, 0, -1);
        echo $mail1;
        $this->load->library('email');

        $subject = 'Se ha cerrado el ticket No: ' . $id;
        $message = '<p>El ticket No: ' . $id . ' ha sido cerrado.</p>';

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
// Also, for getting full html you may use the following internal method:
//$body = $this->email->full_html($subject, $message);

        $result = $this->email
                ->from('ticketspuntualmente.com.co')
                ->to($mail1)
                ->cc($mail2[0]['email'])
                ->subject($subject)
                ->message($body)
                ->send();

        var_dump($result);
        //echo '<br />';
        //echo $this->email->print_debugger();

        echo "<script>location.href='" . $this->config->item("host_cobranzas") . "/index.php/detalleticket/" . $id . "';</script>";
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
