<?php

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Principal');
        $this->load->model('Issabel');
        $this->load->library('session');
        $this->load->library('utilidades');
    }

    public function getTelefonos($tipo, $doc) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $telefonos = $this->Principal->getTelefonos($doc, $tipo, $data['session']['proyecto_activo']);

        $html = '<script src="http://' . $_SERVER['HTTP_HOST'] . '/front/lib/js/core/site.js"></script>';
        if ($tipo == 0) {
            $img = "active.png";
            $class = "activeTel";
            $imgiact = "img_selected";
            $imgact = "";
        } else {
            $img = "disbled.png";
            $class = "unactiveTel";
            $imgact = "img_selected";
            $imgiact = "";
        }

        $html .= '
                    <div class="addtelPanel" class="form-group" style="display: none;">
                        <label class="control-label col-lg-4">Télefono: <span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" style="margin-bottom: 10px;" data-validation="number" maxlength="10" class="form-control" name="telefono-nuevo" id="telefono-nuevo" required="required" placeholder="Ingrese solo números." aria-required="true" aria-invalid="true"/>
                        </div>
                        <div style="clear: both;"></div>
                        <label class="control-label col-lg-4">Ciudad: <span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <select class="form-control" style="margin-bottom: 10px;" name="ciudadTel" id="ciudadTel">
                                <option value="0">Seleccione..</option>
                                <option value="Bogota">Bogota</option>
                            </select>
                        </div>
                        <div style="clear: both;"></div>
                        <button class="btn btn-success" id="saveNewTel" style="margin-left: 10px; margin-right: 10px;" type="button">Guardar</button>
                        <button class="btn btn-danger" type="button" id="cancelarAddPhone">Cancelar</button>
                    </div>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/add.png" style="cursor: pointer;" id="addPhone" alt="Agregar" title="Agregar"/></th>
                                    <th style="text-align: center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/active.png" class="' . $imgact . '" style="cursor: pointer;" id="seeActivos" alt="Activos" title="Activos"/></th>
                                    <th style="text-align: center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/disbled.png" class="' . $imgiact . '" style="cursor: pointer;" id="seeInactivos" alt="Inactivos" title="inactivos"/></th>
                                    <th style="text-align: center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/incomingcall.png" style="cursor: pointer;" alt="Recibir Llamada" title="Recibir Llamada"/></th>
                                </tr>
                                <tr class="bg-primary">
                                    <th>Telefono</th>
                                    <th>Ciudad</th>
                                    <th>Agregado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>';
        foreach ($telefonos as $tel) {
            if ($tel['agregado'] == "1") {
                $agregado = "Si";
            } else {
                $agregado = "No";
            }

            $html .= '<tr style="cursor: pointer;" id="selectTel" tel="' . $tel['telefono'] . '" idtel="' . $tel['idTelefono'] . '">
                                    <td><a href="sip:'.$tel['telefono'].'@172.16.0.3">' . $tel['telefono'] . '</a></td>
                                    <td>' . $tel['idCiudad'] . '</td>
                                    <td>' . $agregado . '</td>
                                    <td><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/' . $img . '" class="' . $class . '" tel="' . $tel['telefono'] . '" idtel="' . $tel['idTelefono'] . '" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/>&nbsp;&nbsp;&nbsp;<img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/call.png" class="makecall" tel="' . $tel['telefono']
                                     . '" idtel="' . $tel['idTelefono'] . '" style="cursor: pointer;" alt="Llamar" title="Llamar"/></td>
                                </tr>';
        }
        $html .= '</tbody>
                        </table>';

        echo $html;
    }

    public function getMails($tipo, $doc) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $correos = $this->Principal->getCorreos($doc, $tipo, $data['session']['proyecto_activo']);

        $html = '<script src="http://' . $_SERVER['HTTP_HOST'] . '/front/lib/js/core/site.js"></script>';
        if ($tipo == 0) {
            $img = "active.png";
            $class = "activeMail";
            $imgiact = "img_selected";
            $imgact = "";
        } else {
            $img = "disbled.png";
            $class = "unactiveMail";
            $imgact = "img_selected";
            $imgiact = "";
        }

        $html .= '
        <div class="addmailPanel" class="form-group" style="display: none;">
            <label class="control-label col-lg-4">Correo: <span class="text-danger">*</span></label>
            <div class="col-lg-8">
                <input type="text" style="margin-bottom: 10px;" class="form-control" name="mail-nuevo" id="mail-nuevo" required="required"/>
            </div>
            <div style="clear: both;"></div>
            <button class="btn btn-success" id="saveNewMail" style="margin-left: 10px; margin-right: 10px;" type="button">Guardar</button>
            <button class="btn btn-danger" type="button" id="cancelarAddMail">Cancelar</button>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="text-align: center;"><img src="https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/front/img/add.png" style="cursor: pointer;" id="addMail" alt="Agregar" title="Agregar"/></th>
                    <th style="text-align: center;"><img src="https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/front/img/active.png" style="cursor: pointer;" class="img_selected" id="seeActivos-mail" a-dirlt="Activos" title="Activos"/></th>
                    <th style="text-align: center;"><img src="https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/front/img/disbled.png" style="cursor: pointer;" alt="Inactivos" id="seeInactivos-mail" title="inactivos"/></th>
                </tr>
                <tr class="bg-primary">
                    <th>E-Mail</th>
                    <th>Agregado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>';

                foreach ($correos as $corr) {
                    if ($corr['agregado'] == "1") {
                        $agregado = "Si";
                    } else {
                        $agregado = "No";
                    }
            $html .='<tr id="selectMail" dir="'.$corr['email'].'" idmail="'.$corr['idEmail'].'">
                        <td>'.$corr['email'].'</td>
                        <td>'.$agregado.'</td>
                        <td><img src="https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/front/img/disbled.png" class="unactiveMail" mail="'.$corr['email'].'" iddir="'.$corr['idEmail'].'" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/></td>
                    </tr>';
                }
          $html .='</tbody>
        </table>';

        echo $html;
    }

    public function getDirecciones($tipo, $doc) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $direcciones = $this->Principal->getDirecciones($doc, $tipo, $data['session']['proyecto_activo']);

        $html = '<script src="http://' . $_SERVER['HTTP_HOST'] . '/front/lib/js/core/site.js"></script>';
        if ($tipo == 0) {
            $img = "active.png";
            $class = "activeDir";
            $imgiact = "img_selected";
            $imgact = "";
        } else {
            $img = "disbled.png";
            $class = "unactiveDir";
            $imgact = "img_selected";
            $imgiact = "";
        }

        $html .= '
                    <div class="addtelPanel" class="form-group" style="display: none;">
                        <label class="control-label col-lg-4">Direccion: <span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" style="margin-bottom: 10px;"  class="form-control" name="direccion-nuevo" id="direccon-nuevo" required="required" placeholder="Ingrese solo números." aria-required="true" aria-invalid="true"/>
                        </div>
                        <div style="clear: both;"></div>
                        <label class="control-label col-lg-4">Ciudad: <span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <select class="form-control" style="margin-bottom: 10px;" name="ciudadDir" id="ciudadDir">
                                <option value="0">Seleccione..</option>
                                <option value="Tocancipa">Bogota</option>
                            </select>
                        </div>
                        <div style="clear: both;"></div>
                        <button class="btn btn-success" id="saveNewDir" style="margin-left: 10px; margin-right: 10px;" type="button">Guardar</button>
                        <button class="btn btn-danger" type="button" id="cancelarAddDir">Cancelar</button>
                    </div>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/add.png" style="cursor: pointer;" id="addDir" alt="Agregar" title="Agregar"/></th>
                                    <th style="text-align: center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/active.png" class="' . $imgact . '" style="cursor: pointer;" id="seeActivos-dir" alt="Activos" title="Activos"/></th>
                                    <th style="text-align: center;"><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/disbled.png" class="' . $imgiact . '" style="cursor: pointer;" id="seeInactivos-dir" alt="Inactivos" title="inactivos"/></th>
                                </tr>
                                <tr class="bg-primary">
                                    <th>Direccion</th>
                                    <th>Ciudad</th>
                                    <th>Agregado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>';
        foreach ($direcciones as $dir) {
            if ($dir['agregado'] == "1") {
                $agregado = "Si";
            } else {
                $agregado = "No";
            }

            $html .= '<tr style="cursor: pointer;" id="selectTel" dir="' . $dir['direccion'] . '" iddir="' . $dir['idDireccion'] . '">
                                    <td>' . $dir['direccion'] . '</td>
                                    <td>' . $dir['idCiudad'] . '</td>
                                    <td>' . $agregado . '</td>
                                    <td><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/' . $img . '" class="' . $class . '" dir="' . $dir['direccion'] . '" iddir="' . $dir['idDireccion'] . '" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/></td>
                                </tr>';
        }
        $html .= '</tbody>
                        </table>';

        echo $html;
    }

    public function landing() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        if ($data['session']['perfil'] < 4) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('landing', $data);
            $this->load->view('templates/footer', $data);
        }else{

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('landing', $data);
            $this->load->view('templates/footer', $data);
        }
    }

    public function buscar() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $this->utilidades->saveEvent("Ingresa al modulo de busqueda", $data['session']['id'], $data['session']['proyecto_activo']);


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/buscar', $data);
        $this->load->view('templates/footer', $data);
    }

    public function resultadobuscar() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $criter = $this->input->post('crit');
        $valor = $this->input->post('val');

        $this->utilidades->saveEvent("Realiza busqueda del dato: " . $valor, $data['session']['id'], $data['session']['proyecto_activo'], NULL, NULL, NULL);
        $lastEvent = $this->Principal->getLastEvent($data['session']['proyecto_activo']);


        if ($criter == "DOC") {
            $result = $this->Principal->buscarxdoc($valor, $lastEvent[0]['ultimo'], $data['session']['proyecto_activo']);
        } elseif ($criter == "OBL") {
            $result = $this->Principal->buscarxoblig($valor, $lastEvent[0]['ultimo'], $data['session']['proyecto_activo']);
        } elseif ($criter == "NOM") {
            $result = $this->Principal->buscarxnom($valor, $lastEvent[0]['ultimo'], $data['session']['proyecto_activo']);
        } elseif ($criter == "TEL") {
            $result = $this->Principal->buscarxtel($valor, $lastEvent[0]['ultimo'], $data['session']['proyecto_activo']);
        }



        $html = "";

        if (count($result) == 0) {
            $html .= '<div class="alert alert-warning alert-bordered">
						<span class="text-semibold">Oops!</span> No se encontraron coincidencias.
					  </div>';
        } else {
            $html .= '<div class="table-responsive">
				<table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
					<thead>
						<tr>
							<th class="footable-visible footable-first-column" data-toggle="true">Documento</th>
							<th class="footable-visible footable-first-column" data-toggle="true">Nombre</th>
							<th class="footable-visible footable-first-column" data-toggle="true">Saldo Pareto</th>
							<th class="footable-visible footable-first-column" data-toggle="true">Asesor</th>
						</tr>
					</thead>
					';

            foreach ($result as $r) {

                $asesor = $this->Principal->getusuario($r['idAsesor']);

                $html .= '<tbody>
						<tr style="cursor: pointer;" onclick="location.href=\'https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/index.php/cliente/' . $r['idCliente'] . '\'">
							<td class="footable-visible footable-first-column">' . $r['documento'] . '</td>
							<td class="footable-visible footable-first-column">' . $r['nombre'] . '</td>
							<td class="footable-visible footable-first-column">' . number_format($r['saldoPareto'], 0) . '</td>
							<td class="footable-visible footable-first-column">' . $asesor[0]['nombre'] . '</td>
						</tr>';
            }
            $html .= '</table>
			</div>';
        }



        echo $html;
    }

    public function setpractivo($slug) {

        $this->session->valida();
        $this->session->setActivo($slug);

        echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/dashboard/" . $slug . "'</script>";
    }

    public function predictivo($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();


        $result = $this->Principal->buscarxtelpredictivo($slug, $data['session']['proyecto_activo']);


        if($result[0]['documento']){
            echo "<script>location.href ='http://" . $_SERVER['HTTP_HOST'] . "/index.php/cliente/" . $result[0]['idCliente']."';</script>";
        }else{
            echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/errorbusqueda';</script>";
        }
    }

    public function getdataacuerdooh() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $oh = $this->input->post('obligacion');

        $result = $this->Principal->getDataAcuerdoOh($oh, $data['session']['proyecto_activo']);
        echo $result[0]['pisonegociacion']."-".$result[0]['pagoacuotas']."-".$result[0]['valor_mora_actual'];
    }

    public function dashboard($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $data['slug'] = $slug;
        $hoy = date("Y-m-d");

        $data['usuariosPr'] = $this->Principal->getUserPr($data['session']['proyecto']);
    		//$data['productividad'] = $this->Principal->getProductividadHoyUser($hoy, $data['session']['id'], $data['session']['proyecto_activo']);
    		$data['productividad'] = $this->Principal->getProductividadHoy($hoy, $data['session']['proyecto_activo']);

    		if($data['session']['perfil'] < 5){
    				//$data['productividad'] = $this->Principal->getProductividadHoy('0', $hoy, $data['session']['proyecto_activo']);
    				$data['totalPagos'] = $this->Principal->getTotalPagos('0', $data['session']['proyecto_activo']);
    		}else{

    				$data['totalPagos'] = $this->Principal->getTotalPagos($data['session']['id'], $data['session']['proyecto_activo']);
    		}


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/dashboard', $data);
        $this->load->view('templates/footer', $data);
    }

    public function cliente($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $data['slug'] = $slug;

        $this->utilidades->saveEvent("Consulta cliente ", $data['session']['id'], $data['session']['proyecto_activo']);
        $lastEvent = $this->Principal->getLastEvent($data['session']['proyecto_activo']);


        $data['cliente'] = $this->Principal->getDataCliente($slug, $lastEvent[0]['ultimo'], $data['session']['proyecto_activo']);
        $data['creditos'] = $this->Principal->getObligaciones($data['cliente'][0]['documento'], $data['session']['proyecto_activo']);
        $data['telefonos'] = $this->Principal->getTelefonos($data['cliente'][0]['documento'], '1', $data['session']['proyecto_activo']);
        $data['direcciones'] = $this->Principal->getDirecciones($data['cliente'][0]['documento'], '1', $data['session']['proyecto_activo']);
        $data['accionesPanel'] = $this->Principal->getAccionesPanel($data['session']['proyecto_activo']);
        $data['accionesSelect'] = $this->Principal->getAccionesSelect($data['session']['proyecto_activo']);
        $data['motivos'] = $this->Principal->getMotivos($data['session']['proyecto_activo']);
        $data['gestion'] = $this->Principal->getGestion($data['cliente'][0]['documento'], $data['session']['proyecto_activo']);
        $data['eventos'] = $this->Principal->getEventos($data['cliente'][0]['documento'], $data['session']['proyecto_activo']);
        $data['pagos'] = $this->Principal->getPagos($data['cliente'][0]['documento'], $data['session']['proyecto_activo']);
        $data['acuerdos'] = $this->Principal->getAcuerdos($data['cliente'][0]['documento'], $data['session']['proyecto_activo']);
        $data['correos'] = $this->Principal->getCorreos($data['cliente'][0]['documento'], '1', $data['session']['proyecto_activo']);
        $data['referencias'] = $this->Principal->getReferencias($data['cliente'][0]['documento'],  $data['session']['proyecto_activo']);
        $data['ciudades'] = $this->Principal->getCiudades($data['session']['proyecto_activo']);
        $data['actividades'] = $this->Principal->getActividadCl($data['session']['proyecto_activo']);
        $data['archivoscl'] = $this->Principal->getArchivosCliente($data['cliente'][0]['documento'], $data['session']['proyecto_activo']);

        $this->utilidades->saveEvent("Consulta cliente: " . $data['cliente'][0]['documento'], $data['session']['id'], $data['session']['proyecto_activo']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view($data['session']['proyecto_activo'] . '/cliente', $data);
        $this->load->view('templates/action', $data);
        $this->load->view('templates/footer', $data);
    }

    public function asignacion($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $data['slug'] = $slug;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/asignacion', $data);
        $this->load->view('templates/footer', $data);
    }

    public function getlistado() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $preasignacion = $this->Principal->getAsignacion($data['session']['id'], $data['session']['proyecto_activo']);

        $flag = 0;
        foreach ($preasignacion as $asi2) {

            $mej = $this->Principal->getResultadoUno($asi2['mejorGestion'], $data['session']['proyecto_activo']);
            $preasignacion[$flag]['mejorGestion'] = $mej[0]['descripcion'];

            $ult = $this->Principal->getResultadoUno($asi2['ultimaGestion'], $data['session']['proyecto_activo']);
            $preasignacion[$flag]['ultimaGestion'] = $ult[0]['descripcion'];

            $flag += 1;
        }


        foreach ($preasignacion as $asi) {
            $arreglo['data'][] = array_map("utf8_encode", $asi);
        }


        $data['arreglo'] = $arreglo;

        $this->load->view('pages/jsonlistado', $data);
    }

    public function unactivatetel() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $tel = $this->input->post('tele');
        $idtel = $this->input->post('idtele');

        $this->utilidades->saveEvent("Inactiva telefono: " . $tel, $data['session']['id'], $data['session']['proyecto_activo']);
        $lastEvent = $this->Principal->getLastEvent($data['session']['proyecto_activo']);

        $this->Principal->unactivatetel($idtel, $lastEvent[0]['ultimo'], $data['session']['proyecto_activo']);
        $doc = $this->Principal->getdoctel($idtel, $data['session']['proyecto_activo']);

        $this->utilidades->saveEvent("Inactiva telefono: " . $tel, $data['session']['id'], $data['session']['proyecto_activo']);

        $this->getTelefonos('0', $doc[0]['documento']);
    }

    public function activatetel() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $tel = $this->input->post('tele');
        $idtel = $this->input->post('idtele');

        $this->utilidades->saveEvent("Activa telefono: " . $tel, $data['session']['id'], $data['session']['proyecto_activo']);
        $lastEvent = $this->Principal->getLastEvent($data['session']['proyecto_activo']);

        $this->Principal->activatetel($idtel, $lastEvent[0]['ultimo'], $data['session']['proyecto_activo']);
        $doc = $this->Principal->getdoctel($idtel, $data['session']['proyecto_activo']);

        $this->utilidades->saveEvent("Activa telefono: " . $tel, $data['session']['id'], $data['session']['proyecto_activo']);

        $this->getTelefonos('1', $doc[0]['documento']);
    }

    public function inactivostel() {

        $doc = $this->input->post("docu");
        $this->getTelefonos('0', $doc);
    }

    public function activostel() {

        $doc = $this->input->post("docu");
        $this->getTelefonos('1', $doc);
    }

    public function savenuevotel() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $tel = $this->input->post('tele');
        $doc = $this->input->post('docu');
        $ciu = $this->input->post('ciu');

        $this->Principal->saveTelefono($tel, $ciu, $doc, $data['session']['proyecto_activo']);

        $this->utilidades->saveEvent("Agrega telefono: " . $tel, $data['session']['id'], $data['session']['proyecto_activo'], $doc);

        $this->getTelefonos('1', $doc);
    }





    public function unactivatedir() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $dire = $this->input->post('dire');
        $iddire = $this->input->post('iddire');

        $this->Principal->unactivatedir($iddire, $data['session']['proyecto_activo']);
        $doc = $this->Principal->getdocdir($iddire, $data['session']['proyecto_activo']);

        $this->utilidades->saveEvent("Inactiva direccion: " . $dire, $data['session']['id'], $data['session']['proyecto_activo']);

        $this->getDirecciones('0', $doc[0]['documento']);
    }
    public function savenuevomail() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $mail = $this->input->post('maile');
        $doc = $this->input->post('docu');

        $this->Principal->saveCorreos($mail, $doc, $data['session']['proyecto_activo']);

        $this->utilidades->saveEvent("Agrega mail: " . $mail, $data['session']['id'], $data['session']['proyecto_activo'], $doc);

        $this->getMails('1', $doc);
    }


    public function activatedir() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $dir = $this->input->post('dire');
        $iddire = $this->input->post('iddire');

        $this->Principal->activatedir($iddire, $data['session']['proyecto_activo']);
        $doc = $this->Principal->getdocdir($iddire, $data['session']['proyecto_activo']);

        $this->utilidades->saveEvent("Activa direccion: " . $dir, $data['session']['id'], $data['session']['proyecto_activo']);

        $this->getDirecciones('1', $doc[0]['documento']);
    }

    public function inactivosdir() {

        $doc = $this->input->post("docu");
        $this->getDirecciones('0', $doc);
    }

    public function activosdir() {

        $doc = $this->input->post("docu");
        $this->getDirecciones('1', $doc);
    }

    public function activosmail() {

        $doc = $this->input->post("docu");
        $this->getMails('1', $doc);
    }

    public function savenuevodir() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $dir = $this->input->post('dirre');
        $doc = $this->input->post('docu');
        $ciu = $this->input->post('ciudad');

        $this->Principal->saveDireccion($dir, $ciu, $doc, $data['session']['proyecto_activo']);

        $this->utilidades->saveEvent("Agrega direccion: " . $tel, $data['session']['id'], $data['session']['proyecto_activo'], $doc);

        $this->getDirecciones('1', $doc);
    }


    public function getcontactogestion() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $accion = $this->input->post('accion');

        $contactos = $this->Principal->getContactoRelacion($accion, $data['session']['proyecto_activo']);

        $html = "";

        foreach ($contactos as $cont) {
            $uno = $this->Principal->getContactoUno($cont['idContacto'], $data['session']['proyecto_activo']);
            $html .= '<option value="' . $uno[0]['idContacto'] . '">' . $uno[0]['descripcion'] . '</option>';
        }

        echo $html;
    }

    public function getresultadogestion() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $accion = $this->input->post('accion');
        $contacto = $this->input->post('conta');

        $resultados = $this->Principal->getResultadoRelacion($accion, $contacto, $data['session']['proyecto_activo']);

        $html = "";

        foreach ($resultados as $res) {
            $uno = $this->Principal->getResultadoUno($res['idResultado'], $data['session']['proyecto_activo']);
            $html .= '<option value="' . $uno[0]['idCodres'] . '">' . $uno[0]['descripcion'] . '</option>';
        }

        echo $html;
    }

    public function makememo() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $html = "";
        $accion = $this->input->post('accion');
        $contacto = $this->input->post('conta');
        $motivo = $this->input->post('motiv');
        $resultado = $this->input->post('result');
        $telefono = $this->input->post('tele');
        $memo = $this->input->post('memo');

        $accMemo = $this->Principal->getAccionUno($accion, $data['session']['proyecto_activo']);

        $html .= $accMemo[0]['guion'] . " " . $telefono . " ";

        if ($contacto > 0) {
            $contMemo = $this->Principal->getContactoUno($contacto, $data['session']['proyecto_activo']);

            $html .= $contMemo[0]['guion'] . " ";
        }
        if ($contacto == 1 && $motivo > 0) {
            $motiMemo = $this->Principal->getMotivoUno($motivo, $data['session']['proyecto_activo']);
            $html .= $motiMemo[0]['descripcion'] . " ";
        }

        if ($resultado > 0) {
            $restMemo = $this->Principal->getResultadoUno($resultado, $data['session']['proyecto_activo']);
            $html .= $restMemo[0]['guion'] . " ";
        }

        echo $html;
    }

    public function getfingestion() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $html = "";
        $resultado = $this->input->post('resu');
        $restMemo = $this->Principal->getResultadoUno($resultado, $data['session']['proyecto_activo']);

        $html = $restMemo[0]['fecha'] . "-" . $restMemo[0]['valor'] . "-" . $restMemo[0]['texto'];

        echo $html;
    }

    public function gestionasignacion() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();


        $doc = $this->input->post('docu');

        $this->Principal->markasignacion($doc, $data['session']['id'], $data['session']['proyecto_activo']);


    }

    public function savegestion() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $accion = $this->input->post('accion');
        $contac = $this->input->post('conta');
        $resultado = $this->input->post('result');
        $motiv = $this->input->post('motiv');
        $activ = $this->input->post('acti');
        $tele = $this->input->post('tele');
        $fecacu = $this->input->post('fec');
        $valor = $this->input->post('vlo');
        $txt = $this->input->post('txt');
        $time = $this->input->post('time');
        $memo = $this->input->post('memog');
        $documento = $this->input->post('docu');
        $prom = $this->input->post('prom');
        $flag = $this->input->post('flag');
        $fecha = date("Y-m-d H:i:s");
        $fechaSola = date("Y-m-d");
        $hora = date("H");

        $txtgest = $this->utilidades->cleanText($memo);

        /*$prefec = explode("/", $fecacu);
        $fecacuerdo = $prefec[2] . "-" . $prefec[0] . "-" . $prefec[1];
        $valoracu = str_replace("$", "", $valor);*/

        $grabacion = 0;

        if($prom != ""){
          $uno = explode("!", $prom);
          $tama = sizeof($uno);
          $tama = $tama - 1;

            for($i = 0; $i<$tama; $i++){
                $pr = explode("&", $uno[$i]);
                $m = explode("/",$pr[1]);
                $fecp = $m[2]."-".$m[0]."-".$m[1];

                $mespr = $m[0];
                if($pr[0] != ""){
                    $this->Principal->saveGestion($documento, $fecha, $hora, $tele, $accion, $contac, $motiv, $resultado, $pr[0], $fecp, $pr[2], $txt, $txtgest, $data['session']['id'], $time, $grabacion[0]['recordingfile'], $data['session']['proyecto_activo']);
                    $this->Principal->savePromesas($fecp, $pr[2], $mespr, $documento, $pr[0], $data['session']['proyecto_activo']);
                    $valoracu += $pr[2];
                    $fecacuerdo = $fecp;
                }

            }
      }else{
        $this->Principal->saveGestion($documento, $fecha, $hora, $tele, $accion, $contac, $motiv, $resultado, NULL, NULL, NULL, $txt, $txtgest, $data['session']['id'], $time, $grabacion[0]['recordingfile'], $data['session']['proyecto_activo']);
      }


        $cliente = $this->Principal->getDataClienteDoc($documento, $data['session']['proyecto_activo']);


        $nivelActual = $this->Principal->getResultadoUno($cliente[0]['mejorGestion'], $data['session']['proyecto_activo']);
        $nivelNuevo = $this->Principal->getResultadoUno($resultado, $data['session']['proyecto_activo']);
        $nivelTelefono = $this->Principal->getTelefonoUno($tele, $data['session']['proyecto_activo']);

        if ($cliente[0]['mejorGestion'] == 0) {
            $this->Principal->saveMejorGestion($documento, $resultado, $resultado, $fechaSola, $data['session']['proyecto_activo']);
        } else if ($nivelNuevo[0]['nivel'] < $nivelActual[0]['nivel']) {
            $this->Principal->saveMejorGestion($documento, $resultado, $resultado, $fechaSola, $data['session']['proyecto_activo']);
        }

        if ($activ != 0) {
            $this->Principal->saveActividad($documento, $activ, $data['session']['proyecto_activo']);
        }

        if ($nivelTelefono[0]['nivelContacto'] == 99) {
            $this->Principal->saveMejorTelefono($tele, $nivelNuevo[0]['nivel'], $data['session']['proyecto_activo']);
        }if ($nivelNuevo[0]['nivel'] < $nivelTelefono[0]['nivelContacto']) {
            $this->Principal->saveMejorTelefono($tele, $nivelNuevo[0]['nivel'], $data['session']['proyecto_activo']);
        }
        $this->Principal->saveUltimaGestion($documento, $resultado, $fechaSola, $data['session']['proyecto_activo']);
        $this->Principal->unsetTarea($documento, $resultado, $fecha, $data['session']['proyecto_activo']);
        $this->Principal->unsetProgCall($documento, $data['session']['proyecto_activo']);

        $contactoUno = $this->Principal->getContactoUno($contac, $data['session']['proyecto_activo']);
        //print_r($contactoUno);
        if(isset($contactoUno[0]['idGrupo'])){
          if($contactoUno[0]['idGrupo'] == '1'){
            if(isset($cliente[0]['idAsesor'])){
              if($cliente[0]['idAsesor'] == "200"){
                echo "1";
              }
            }
          }
        }


        $this->utilidades->saveEvent("Ingresa Gestion: " . $nivelNuevo[0]['descripcion'], $data['session']['id'], $data['session']['proyecto_activo'], $documento);
    }

    public function getGestion() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $html = "";
        $doc = $this->input->post('docu');
        $filtro = $this->input->post('flag');

        if ($filtro == 0) {
            $gestion = $this->Principal->getGestion($doc, $data['session']['proyecto_activo']);
        }else if ($filtro == 1) {
            $gestion = $this->Principal->getGestionEfectiva($doc, $data['session']['proyecto_activo']);
        }

        $flag = 0;
        foreach ($gestion as $ges) {

            $class = "";
            $class2 = "in";
            $color = "";
            if ($flag > 0) {
                $class = 'class="collapsed"';
                $class2 = "";
            }
            $result = $this->Principal->getResultadoUno($ges['idResultado'], $data['session']['proyecto_activo']);
            $user = $this->Principal->getusuario($ges['idAsesor'], $data['session']['proyecto_activo']);
            $cont = $this->Principal->getContactoUno($ges['idContacto'], $data['session']['proyecto_activo']);

            if ($cont[0]['idGrupo'] == 1) {
                $color = 'style="background-color:  #d9ffdc;"';
            }if ($cont[0]['idGrupo'] == 2) {
                $color = 'style="background-color:  #fedbdb;"';
            }

            $fecacu = "";

            if($ges['fechaAcuerdo'] != "0000-00-00" && $ges['fechaAcuerdo'] != ""){
                $fecacu = $ges['fechaAcuerdo'];
            }

            $html .= '<div class="panel">
                                    <div class="panel-heading" ' . $color . '>
                                        <div class="panel-title">
                                            <a ' . $class . ' data-toggle="collapse" data-parent="#accordion-styled" href="#' . $ges['idCallhist'] . '">' . $ges['fechaGestion']." - ".$user[0]['usuario']
                                            . " - Tel: " . $ges['telefono'] . " - " . $result[0]['descripcion'] . " - " . $fecacu . '</a>
                                        </div>
                                    </div>
                                    <div id="' . $ges['idCallhist'] . '" class="panel-collapse collapse ' . $class2 . '">
                                        <div class="panel-body">' .
                    $ges['textoGestion'] . '
                                        </div>
                                    </div>
                               </div>';
            $flag += 1;
        }

        echo $html;
    }

    public function importartareas() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/tareas', $data);
        $this->load->view('templates/footer', $data);
    }

    public function uploadtareas() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $mi_archivo = 'file';
        $config['upload_path'] = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/";
        $config['file_name'] = "tarea";
        $config['allowed_types'] = "*";
        $config['max_size'] = "50000";

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($mi_archivo)) {
            //*** ocurrio un error
            $data['uploadError'] = $this->upload->display_errors();

            echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
            echo "<script>location.href='http://]" . $_SERVER['HTTP_HOST'] . "/index.php/importartareas/" . $data['session']['proyecto_activo'] . "'</script>";
            return;
        } else {
            //$data['uploadSuccess'] = $this->upload->data();
            $this->utilidades->saveEvent("carga tarea", $data['session']['id'], $data['session']['proyecto_activo']);
            $datas = array('upload_data' => $this->upload->data());
            $fila = 1;

            $filesname = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $datas['upload_data']['file_name'];
            if (($archivo = fopen("/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $datas['upload_data']['file_name'], "r")) !== false) {

                while (($datos = fgetcsv($archivo, 5000, ";")) !== FALSE) {
                    $numero = count($datos);

                    $doc = $datos[0];
                    $tarea = $datos[1];
                    $responsable = $datos[2];
                    $tarea2 = $this->utilidades->cleanText($tarea);


                    $this->Principal->insertarea($doc, $tarea2, $responsable, $data['session']['proyecto_activo']);
                }
                fclose($archivo);

                //unlink($filesname);
            }
        }

        echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/resumen-asignacion/" . $data['session']['proyecto_activo'] . "';</script>";
    }

    public function subirarchivo  () {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $fecha = date("Y-m-d");
        $doc = $this->input->post("documentoArchivo");
        $nameF = $this->input->post("nombreFiles");
        $ida = $this->input->post("idArchivo");

        $rutaTotal = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/clientes/".$doc;
        if(!file_exists($rutaTotal)){
          mkdir($rutaTotal, 0777, true);
          chmod($rutaTotal, 0777);
        }

        $rutaTotal .= "/";

        $mi_archivo = 'archivo';
        $config['upload_path'] = $rutaTotal;
        $config['allowed_types'] = "*";
        $config['file_name'] = $nameF;
        $config['max_size'] = "50000";

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($mi_archivo)) {
            //*** ocurrio un error
            $data['uploadError'] = $this->upload->display_errors();

            echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
            echo "<script>location.href='http://]" . $_SERVER['HTTP_HOST'] . "/index.php/importartareas/" . $data['session']['proyecto_activo'] . "'</script>";
            return;
        } else {
            //$data['uploadSuccess'] = $this->upload->data();
            $datas = array('upload_data' => $this->upload->data());
            $nameF2 = $nameF.$datas['upload_data']['file_ext'];
            $this->Principal->savebilioteca($doc, $nameF2, $datas['upload_data']['file_ext'], $fecha, $data['session']['id'], $data['session']['proyecto_activo']);
            $this->utilidades->saveEvent("carga archivo".$datas['upload_data']['file_name'], $data['session']['id'], $data['session']['proyecto_activo']);
        }

        echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/cliente/" . $ida . "';</script>";
    }

    public function resumentareas($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $data['tareas'] = $this->Principal->getTareasActivasGenerales($data['session']['perfil'], $data['session']['proyecto_activo']);
        $data['tareasU'] = $this->Principal->getTareasActivasUsuario($data['session']['id'],$data['session']['perfil'], $data['session']['proyecto_activo']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/resumentareas', $data);
        $this->load->view('templates/footer', $data);
    }

    public function fintarea() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/fintarea', $data);
        $this->load->view('templates/footer', $data);
    }

    public function fastsearch() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();


        $valor = $this->input->post('fast-search');

        $result = $this->Principal->buscarxdoc($valor, "0", $data['session']['proyecto_activo']);


        if(sizeof($result) > 0){
            echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/cliente/" . $result[0]['idCliente'] . "';</script>";
        }else{
            echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/errorbusqueda';</script>";
        }

    }
    public function fastsearchurl($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();


        $valor = $slug;

        $result = $this->Principal->buscarxdoc($valor, "0", $data['session']['proyecto_activo']);


        if(sizeof($result) > 0){
            echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/cliente/" . $result[0]['idCliente'] . "';</script>";
        }else{
            echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/errorbusqueda';</script>";
        }

    }

    public function errorbusqueda() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/errorbusqueda', $data);
        $this->load->view('templates/footer', $data);
    }

    public function deletetarea($tarea) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->Principal->deleteTarea($tarea, $data['session']['proyecto_activo']);

        echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/resumen-tareas/" . $data['session']['proyecto_activo'] . "';</script>";
    }

    public function settarea($tarea) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->session->setTarea($tarea);


        echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/nexttarea';</script>";
    }

    public function nexttarea() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();



        $siguiente = $this->Principal->getNextTarea($data['session']['tarea'], $data['session']['id'], $data['session']['proyecto_activo']);


        if(count($siguiente) == 0){
            $this->session->unsetTarea();
            echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/fintarea';</script>";
        }else{
            $this->Principal->markTarea($siguiente[0]['idTareas'], $data['session']['id'], $data['session']['proyecto_activo']);

            $dos = $this->Principal->getNextTareaDos($data['session']['id'], $data['session']['tarea'], $data['session']['proyecto_activo']);
            $id = $this->Principal->getDataClienteDoc($dos[0]['documento'], $data['session']['proyecto_activo']);

            echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/cliente/" . $id[0]['idCliente'] . "';</script>";
        }


    }

    public function logout() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        $this->session->unsetsession();



        echo "<script>location.href='http://" . $this->config->item('host_usuarios') . "/index.php/logout/".$data['session']['id']."';</script>";
    }

    public function saveprogcall() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $fec = explode(" ", $this->input->post("fecha"));
        $doc = $this->input->post("docu");

        $prefecha = explode("/", $fec[0]);
        $fecha = $prefecha[2]."-".$prefecha[0]."-".$prefecha[1]." ".$fec[1];


        $this->Principal->saveProgCall($fecha, $data['session']['id'], $doc, $data['session']['proyecto_activo']);

        echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/resumen-tareas/" . $data['session']['proyecto_activo'] . "';</script>";
    }

    public function getprogcall() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $fecha = date("Y-m-d H:i:s");
        $calls = $this->Principal->getprogcall($fecha, $data['session']['id'], $data['session']['proyecto_activo']);

        $html = "";
        if(sizeof($calls) == 0){
            $html = "0";
        }else{
            $html .= ''
                    . '<table class="table">'
                    . '<tr>'
                    . '<th>Documento</th>'
                    . '<th>Nombre</th>'
                    . '<th>Fecha</th>'
                    . '</tr>';
            foreach($calls as $ca){
            $name = $this->Principal->buscarxdoc($ca['documento'], "0", $data['session']['proyecto_activo']);
            $html .= '<tr style="cursor: pointer;" onclick="location.href=\'http://'.$_SERVER['HTTP_HOST'].'/index.php/fastsearchurl/'.$ca['documento'].'\'">'
                    . '<td>'.$ca['documento'].'</td>'
                    . '<td>'.$name[0]['nombre'].'</td>'
                    . '<td>'.$ca['fecha'].'</td>'
                    . '</tr>';
            }

            $html .= '</table>';
        }


        echo $html;
    }

    public function exportaestadoclientes($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        //$this -> load -> library('Estadocartera');
	      //$this -> estadocartera -> export($data['session']['proyecto_activo']);
        $data['clientes'] = $this->Principal->getTotalClientes($data['session']['proyecto_activo']);

        $this->load->view('operativo/exportacartera', $data);
    }

    public function preexportadetallellamadas() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('operativo/preexportellamadas', $data);
        $this->load->view('templates/footer', $data);
    }

    public function exportadetallellamadas() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();


       $data['ini'] = $this->input->post('fechaIni');
       $data['fin'] = $this->input->post('fechaFin');
       // $this -> load -> library('Estadocartera');

        $prefechaini = explode("/", $data['ini']);
        $fechaini = $prefechaini[2]."-".$prefechaini[0]."-".$prefechaini[1];
        $prefechafin = explode("/", $data['fin']);
        $fechafin = $prefechafin[2]."-".$prefechafin[0]."-".$prefechafin[1];


	//$this -> estadocartera -> export($data['session']['proyecto_activo']);
        $data['llamadas'] = $this->Principal->getTotalCalls($fechaini, $fechafin, $data['session']['proyecto_activo']);
        $this->load->view('operativo/exportadetallegestion', $data);
    }


    public function resultadotarea() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $tarea = $this->input->post('tareas');

        $works = $this->Principal->getResultadoTarea($tarea, $data['session']['proyecto_activo']);

        $html = '<script src="http://' . $_SERVER['HTTP_HOST'] . '/front/lib/js/core/tareas.js"></script>';

        $total = 0;
        foreach($works as $w2){
            $total += $w2['cuantos'];
        }

        $html .= '<table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Resultado</th>
                                    <th style="text-align: center;">No Cedulas</th>
                                    <th style="text-align: center;">%</th>
                                    <th style="text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>';
                                foreach($works as $w){
                                    $proc1 = $w['cuantos']/$total;
                                    $porc = $proc1 * 100;

                                    $resul = $this->Principal->getResultadoUno($w['idResultado'], $data['session']['proyecto_activo']);


                               $html .= '
                                <tr>
                                    <td>'.$resul[0]['descripcion'].'</td>
                                    <td style="text-align: center;">'.$w['cuantos'].'</td>
                                    <td style="text-align: center;">'.number_format($porc,2).' %</td>
                                    <td style="text-align: center;"></th>
                                </tr>';
                                }
                $html .= '</tbody>
                        </table>';

        echo $html;
    }

    public function sumardias($fecha, $dias){
      $days = "+".$dias."day";
      $nuevafecha = strtotime ( $days , strtotime ( $fecha ) ) ;
      $nuevafechas = date ( 'Y-m-d' , $nuevafecha );

      $diaSemana =  date("w",strtotime($nuevafechas));

      if($diaSemana == 0){

        $days = "-2day";
        $nuevafecha3 = strtotime ( $days , strtotime ( $nuevafechas ) ) ;
        $nuevafechas = date ( 'Y-m-d' , $nuevafecha3 );

      }else if($diaSemana == 6){

        $days = "-1day";
        $nuevafecha3 = strtotime ( $days , strtotime ( $nuevafechas ) ) ;
        $nuevafechas = date ( 'Y-m-d' , $nuevafecha3 );

      }

      return $nuevafechas;
    }

    public function generaacuotas() {


        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $valor = $this->input->post('valor');
        $cuotas = $this->input->post('cuotas');
        $fecha = $this->input->post('fec');
        $oh = $this->input->post('oh');

        $fecFormato = explode("/",$fecha);

        $fecha = $fecFormato[2]."-".$fecFormato[0]."-".$fecFormato[1];



        $valorCuotas = $valor/$cuotas;
        $valorCuota = round($valorCuotas, 2);
        $html = '<script src="http://' . $_SERVER['HTTP_HOST'] . '/front/lib/js/core/acuerdos.js"></script>
                 <script src="https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/front/lib/js/forms/datepicker.min.js"></script>
                 <script src="https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/front/lib/js/forms/datepicker.en.js"></script>';

        $html .= '
        <form name="save-cuotas-acuerdos" id="save-cuotas-acuerdos" method="post" action="#">
        <table class="table">
            <thead>
                <tr>
                    <th>Numero de Cuota</th>
                    <th>Fecha Cuota</th>
                    <th>Valor Cuota</th>
                </tr>
            </thead>
            <tbody>';

        for ($i = 1; $i<= $cuotas; $i++) {

          if($i == 1){
            $sumaD = 0 * $i;
          }else{
            $e = $i - 1;
            $sumaD = 30 * $e;
          }



          $nuevaFecha = $this->sumardias($fecha, $sumaD);


          $html .= '<tr>
                <td>'.$i.'</td>
                <td><input type="text" value="'.$nuevaFecha.'" name="fecha-cuota-acuerdo'.$i.'" id="fecha-cuota-acuerdo'.$i.'" class="form-control" /></td>
                <td><input type="text" name="valor-cuota'.$i.'" id="valor-cuota'.$i.'" class="form-control" value="'.$valorCuota.'"/></td>
            </tr>';
        }

        $html .= '
                <tr>
                  <td><button class="btn btn-success" id="saveAcuerdoCuotas" type="button">Guardar Acuerdo</button></td>
                  <td><button class="btn btn-danger" id="cancelarAcuerdoCuotas" type="button">Cancelar Acuerdo</button></td>
                  <td></td>
                </tr>
                  </tbody>
                        </table>
          </form>';

        echo $html;
    }


    public function creaacuerdo() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();


       $fecha = $this->input->post('fecha');
       $valor = $this->input->post('valor');
       $cuotas = $this->input->post('cuotas');
       $docu = $this->input->post('docu');
       $totenv = $this->input->post('env');
       $oh = $this->input->post('oh');

       $nuev = explode(".",$fecha);

       $nuevFec = $nuev[2]."-".$nuev[1]."-".$nuev[0];

      $this->Principal->unactivateAcuerdo($docu, $data['session']['proyecto_activo']);
      $this->Principal->insertAcuerdo($docu, $nuevFec, $valor, $cuotas, $oh, $data['session']['id'], $data['session']['proyecto_activo']);
      $active = $this->Principal->getAcuerdo($docu, $data['session']['proyecto_activo']);

      $totenv = substr($totenv, 0, -1);

      $detalle = explode("!", $totenv);

      foreach($detalle as $clave=>$valor){

          $deta = explode(";", $valor);
          $this->Principal->insertDetalleAcuerdo($active[0]['idAcuerdo'], $deta[0], $deta[2], $deta[1], $data['session']['proyecto_activo']);
      }

    }

    public function generapdf($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $acuPrin = $this->Principal->getAcuerdoId($slug, $data['session']['proyecto_activo']);
        $dataCl = $this->Principal->getDataClienteDoc($acuPrin[0]['documento'], $data['session']['proyecto_activo']);

        $this->load->library('Pdf');

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetTitle('Acuerdo de Pago');

        $pdf->SetTopMargin("20");
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_TOP);
        $pdf->SetAuthor('Puntualmente S.A.S');
        $pdf->SetDisplayMode('real', 'default');

        $html = '<!DOCTYPE html>
                  <!--
                  To change this license header, choose License Headers in Project Properties.
                  To change this template file, choose Tools | Templates
                  and open the template in the editor.
                  -->
                  <html>
                      <head>
                          <title>Acuerdo de Pago</title>
                          <meta charset="UTF-8">
                          <meta name="viewport" content="width=device-width, initial-scale=1.0">
                      </head>
                      <body>
                          <div style="width: 80%;">
                              <table style="width: 100%; border-top: 2px solid #000; border-collapse: collapse; border-left: 2px solid #000; border-right: 2px solid #000; border-bottom: 2px solid #000;">
                                  <tr>
                                      <th colspan="2" style="text-align: center; border-collapse: collapse; border-bottom: 2px solid #000;">Acuerdo de Pago</th>
                                  </tr>
                                  <tr>
                                      <td style="width: 50%;" rowspan="10">BBVA</td>
                                      <td style="font-size: 10px; width: 50%; text-align: left; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><span style="font-weight: bold; font-size: 7px;">Nombre Titular: </span> <span style="font-size: 7px;">'.$dataCl[0]['nombre'].'</span></td>
                                  </tr>
                                  <tr>
                                      <td style="font-size: 10px; width: 50%; text-align: left; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><span style="font-weight: bold; font-size: 7px;">No Identificación: </span><span style="font-size: 7px;">'.$dataCl[0]['documento'].'</span></td>
                                  </tr>
                                  <tr>
                                      <td style="font-size: 10px; width: 50%; text-align: left; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><span style="font-weight: bold; font-size: 7px;">Nombre Interesado: </span><span style="font-size: 7px;">'.$dataCl[0]['nombre'].'</span></td>
                                  </tr>
                                  <tr>
                                      <td style="font-size: 10px; width: 50%; text-align: left; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><span style="font-weight: bold; font-size: 7px;">No Identificación: </span><span style="font-size: 7px;">'.$dataCl[0]['documento'].'</span></td>
                                  </tr>
                                  <tr>
                                      <td style="font-size: 10px; width: 50%; text-align: left; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><span style="font-weight: bold; font-size: 7px;">Direccion Residencia: </span></td>
                                  </tr>
                                  <tr>
                                      <td style="font-size: 10px; width: 50%; text-align: left; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><span style="font-weight: bold; font-size: 7px;">Teléfono Residencia: </span></td>
                                  </tr>
                                  <tr>
                                      <td style="font-size: 10px; width: 50%; text-align: left; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><span style="font-weight: bold; font-size: 7px;">Direccion Oficina o Trabajo: </span></td>
                                  </tr>
                                  <tr>
                                      <td style="font-size: 10px; width: 50%; text-align: left; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><span style="font-weight: bold; font-size: 7px;">Teléfono Oficina o Trabajo: </span></td>
                                  </tr>
                                  <tr>
                                      <td style="font-size: 10px; width: 50%; text-align: left; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><span style="font-weight: bold; font-size: 7px;">Teléfono Celular: </span></td>
                                  </tr>
                                  <tr>
                                      <td style="font-size: 10px; width: 50%; text-align: left; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;"><span style="font-weight: bold; font-size: 7px;">Correo Electronico: </span></td>
                                  </tr>
                              </table>
                              <table style="width: 100%; border-top: 2px solid #000; border-collapse: collapse; border-left: 2px solid #000; border-right: 2px solid #000; border-bottom: 2px solid #000;">
                                  <tr>
                                      <th style="text-align: center; border-collapse: collapse; border-bottom: 2px solid #000;">PAGO TOTAL</th>
                                  </tr>
                                  <tr>
                                      <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><span style="font-size: 8px;">En mi(nuestra) calidad de deudor(es) de BBVA Colombia y/o demandado(s), interesado(s) me(nos ) obligo(amos) a cumplir el presente compromiso de pago en los términos y condiciones que se detallan a continuación:</span></td>
                                  </tr>
                              </table>
                              <table style="width: 100%; border-top: 2px solid #000; border-collapse: collapse; border-left: 2px solid #000; border-right: 2px solid #000; border-bottom: 2px solid #000;">
                                  <tr>
                                      <th colspan="7" style="background-color: #A4A4A4; font-size: 13px; text-align: center; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 9px;">INFORMACION DE TODOS L(OS) CREDITO(S)</p></th>
                                  </tr>
                                  <tr>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;" rowspan="2"><span style="font-size: 8px; font-weight: bold;">No Obligación</span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;" rowspan="2"><span style="font-size: 8px; font-weight: bold;">Tipo de Cartera</span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;" colspan="2"><span style="font-size: 8px; font-weight: bold;">Marca</span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;" colspan="2"><span style="font-size: 8px; font-weight: bold;">Para créditos al cobro judicial</span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 2px solid #000; border-bottom: 2px solid #000;" rowspan="2"><span style="font-size: 8px; font-weight: bold;">Oficina Gestora</span></td>
                                  </tr>

                                  <tr>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;"><span style="font-size: 8px; font-weight: bold;">BBVA</span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;"><span style="font-size: 8px; font-weight: bold;">Administrada</span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;"><span style="font-size: 8px; font-weight: bold;">Nombre abogado externo</span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;"><span style="font-size: 8px; font-weight: bold;">Cuenta abogado externo</span></td>
                                  </tr>

                                  <tr>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;">1234</td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 2px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;">4563</td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000;font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 2px solid #000; border-bottom: 1px solid #000;font-size: 7px;"></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;">4563</td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 2px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                  </tr>
                              </table>
                              <table style="width: 100%; border-top: 2px solid #000; border-collapse: collapse; border-left: 2px solid #000; border-right: 2px solid #000; border-bottom: 2px solid #000;">
                                  <tr>
                                      <th colspan="8" style="background-color: #A4A4A4; font-size: 13px; text-align: center; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 9px;">DETALLE GENERAL DE CUOTAS, GASTOS Y HONORARIOS</p></th>
                                  </tr>
                                  <tr>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;"><span style="font-size: 8px; font-weight: bold;">Fecha de pago</span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;"><span style="font-size: 8px; font-weight: bold;"></span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;"><span style="font-size: 8px; font-weight: bold;">Pago Obligacion</span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;"><span style="font-size: 8px; font-weight: bold;"></span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;"><span style="font-size: 8px; font-weight: bold;"></span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;"><span style="font-size: 8px; font-weight: bold;"></span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 2px solid #000;"><span style="font-size: 8px; font-weight: bold;"></span></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 2px solid #000; border-bottom: 2px solid #000;"><span style="font-size: 8px; font-weight: bold;">Total Pago</span></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;">1234</td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 2px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 2px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;">4563</td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                      <td style="text-align: center; border-collapse: collapse; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 2px solid #000; border-bottom: 1px solid #000; font-size: 7px;"></td>
                                  </tr>
                              </table>
                              <table style="width: 100%; border-top: 2px solid #000; border-collapse: collapse; border-left: 2px solid #000; border-right: 2px solid #000; border-bottom: 2px solid #000;">
                                  <tr>
                                      <th style="text-align: center; border-collapse: collapse; border-bottom: 2px solid #000;">CONDICIONES</th>
                                  </tr>
                                  <tr>
                                      <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">1- El incumplimiento del acuerdo en todo o en parte lo deja sin valor ni efecto y faculta al Banco para revocar automáticamente los beneficios y/o descuentos negociados si hubiere lugar a ello. Los pagos serán aplicados como simples abonos. Adicionalmente, dará lugar a que el Banco inicie o impulse el proceso ejecutivo, según corresponda, hasta lograr el pago total de la deuda. De manera general, la forma en que se aplique cada uno de los pagos, se indicará en los comprobantes de pago que expida y entregue el Banco.</p></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">2- El(los) deudor(es) efectuará(n) los pagos a las obligaciones únicamente en las Sucursales del BBVA Colombia, en los horarios establecidos por la Entidad. En consecuencia, los funcionarios de Casas de Cobranzas o los Abogados Externos no están facultados para recibir dineros, salvo que se trate del pago de honorarios profesionales. En caso que el(la) deudor(a) excepcionalmente realice el pago de honorarios directamente a la Casa de Cobranza o al abogado externo, éllos expedirán el correspondiente recibo el cual será exclusivamente por este concepto. El(la) deudor(a) se obliga a entregar copia del recibo al Grupo de Gestión Judicial de BBVA Colombia al día siguiente de su expedición.</p></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">3- El presente compromiso de pago no implica novación ni reestructuración de la(s) obligación(es) objeto de esta negociación. Para suspender el proceso de común acuerdo, es de cargo del(los) demandado(s) suscribir y auntenticar memorial dirigido al Juez de conocimiento y devolverlo al funcionario con el cual se celebró el acuerdo o al abogado externo que adelanta el proceso judicial. El memorial será presentado al Juzgado una vez se cumpla con el primer abono. El Banco solicitarà la terminaciòn del proceso siempre y cuando se cumpla ìntegramente el presente compromiso de pago.</p></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">4- En caso de existir proceso ejecutivo y tratarse de un pago total, será de cargo del(los) demandado(s) con posterioridad al cumplimiento del compromiso de pago, acercarse(n) al juzgado de conocimiento a fin de obtener el oficio de desembargo y el desglose de los documentos (pagaré y escritura pública de hipoteca o prenda).</p></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">5-Cuando se trate de pago total de crédito hipotecario o prendario los pasivos que registre el inmueble o el vehículo y los gastos de levantamiento de hipoteca o prenda, según corresponda, debe asumirlos el(los) deudor(es) y /o propietario.</p></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">6- El(los) deudor(es) y/o demandado(s), interesado(s), reconoce y acepta que adeuda honorarios y/o gastos derivados de la gestiòn de cobranza y por ende acuerda pagarlos. Estos valores están debidamente incorporados en el presente compromiso de pago.</p></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">7- El(los) deudor y/o demandado(s), interesado(s) con el cumplimiento del presente acuerdo renuncia a cualquier reclamación o acción judicial, extrajudicial y/o administrativa en contra del Banco, originada en la(s) obligación(es) materia del mismo.</p></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">8.- En caso de incumplimiento en los pagos y fecha aquí pactados se continúa con el proceso jurídico. Los costos por concepto de honorarios de abogado y gastos de proceso serán asumidos directamente por el cliente, modificando los pactos inicialmente en este acuerdo.</p></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">Se firma en la ciudad de el día de </p></td>
                                  </tr>
                              </table>
                              <table style="width: 100%; border-top: 2px solid #000; border-collapse: collapse; border-left: 2px solid #000; border-right: 2px solid #000; border-bottom: 2px solid #000;">
                                  <tr>
                                      <td style="text-align: center; width: 25%; height: 55px; border-collapse: collapse;"></td>
                                      <td style="text-align: center; width: 50%; height: 55px; border-collapse: collapse;"></td>
                                      <td style="text-align: center; width: 25%; height: 55px; border-collapse: collapse;"></td>
                                  </tr>
                                  <tr>
                                      <td style="text-align: center; width: 25%; border-collapse: collapse; border-top: 2px solid #000;"><p style="font-size: 10px;">Firma: </p></td>
                                      <td style="text-align: left; width: 50%; border-collapse: collapse; border-top: 1px solid #A4A4A4;"><p style="font-size: 10px;"></p></td>
                                      <td style="text-align: left; width: 25%; border-collapse: collapse; border-top: 2px solid #000;"><p style="font-size: 10px;">Firma nombre y apellido Gestor Negocio juridico</p></td>
                                  </tr>

                              </table>
                          </div>

                      </body>
                  </html>';

        $pdf->SetMargins(15, 15, 15, true); // put space of 10 on top
        $pdf->AddPage();
        $pdf->writeHTML($html,true,0,true,0);

        $pdf->lastPage();
        //$ruta = "/var/www/html/app/pdfs/".$empresa[0]['nit']."2.pdf";
        //$pdf->Output($ruta, 'F');
        $pdf->Output("acuerdodepago.pdf", 'I');

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
