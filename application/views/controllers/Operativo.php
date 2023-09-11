<?php

class Operativo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('OperativoModel');
        $this->load->library('session');
        $this->load->library('utilidades');
    }

    public function validavectores() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $tramo = $this->input->post('tramos');
        $descuento = $this->input->post('descuentos');
        $vlDescuento = $this->input->post('vlDescuentos');
        $modalidad = $this->input->post('modalidads');
        $nuevocap = $this->input->post('nuevocaps');

        $apruebavl = "";
        $apruebapor = "";
        $nivelvl = "";
        $nivelpor = "";
        $aprueba = "";
        $mejor = array("Negociador" => "1", "Supervisor" => "2", "Coordinador-Director" => "3", "GerenteAva" => "3", "GerenteCob" => "4");

        $producto = "";

        if ($modalidad == 1) {
            $producto = "comercial";
        } else if ($modalidad == 2) {
            $producto = "Consumo";
        } else if ($modalidad == 3) {
            $producto = "hipotecario";
        } else if ($modalidad == 4) {
            $producto = "micro";
        }

        $nuevod = 0;
        if ($descuento < 21) {
            $nuevod = 20;
        } else if ($descuento > 20 && $descuento < 26) {
            $nuevod = 25;
        } else if ($descuento > 25 && $descuento < 31) {
            $nuevod = 30;
        } else if ($descuento > 30 && $descuento < 36) {
            $nuevod = 35;
        } else if ($descuento > 35 && $descuento < 41) {
            $nuevod = 40;
        } else if ($descuento > 40 && $descuento < 51) {
            $nuevod = 50;
        }

        if ($tramo == 3) {
            if ($descuento > 40 && $descuento < 46) {
                $nuevod = 45;
            } else if ($descuento > 45 && $descuento < 51) {
                $nuevod = 50;
            }
        }


        $attr = $this->OperativoModel->getAtribuciones($tramo, $producto, $data['session']['proyecto_activo']);

        foreach ($attr as $at) {
            if ($vlDescuento <= $at['montomaximo']) {
                $apruebavl = $at['nivel'];
            }

            if ($descuento <= $at['porcentaje']) {
                $apruebapor = $at['nivel'];
            }
        }

        $nivelvl = $mejor[$apruebavl];
        $nivelpor = $mejor[$apruebapor];

        if ($nivelvl > $nivelpor) {
            $aprueba = $apruebavl;
        } else {
            $aprueba = $apruebapor;
        }

        $nuevo = $nuevocap - $vlDescuento;

        echo $vlDescuento . "-" . $nuevo . "-" . $aprueba;
    }

    public function importarinicial() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('operativo/baseinicial', $data);
        $this->load->view('templates/footer', $data);
    }

    public function importaractualizacion($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('operativo/importaractualizacion', $data);
        $this->load->view('templates/footer', $data);
    }

    public function uploadactualizacion() {

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

                while (($datos = fgetcsv($archivo, 5000, "\t")) !== FALSE) {
                    $numero = count($datos);

                    $oh = $datos[26];
                    $diasven = $datos[82];
                    $vlmora = $datos[81];
                    $estado = $datos[45];
                    $franja = $datos[91];

                    $fecha_actual = date("Y-m-d");
                    $fecha = date("Y-m-d",strtotime($fecha_actual."- 1 days"));

                    $this->OperativoModel->updateActualizacion($oh, $diasven, $vlmora, $estado, $franja, $fecha, $data['session']['proyecto_activo']);
                }
                fclose($archivo);
                //die();
//unlink($filesname);
            }
        }


        $this->utilidades->saveEvent("carga Asignacion BBVA", $data['session']['id'], $data['session']['proyecto_activo']);

        echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/resumen-asignacion/" . $data['session']['proyecto_activo'] . "';</script>";
    }

    public function uploadbaseinicial() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $mi_archivo = 'file';
        $config['upload_path'] = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/";
        $config['file_name'] = "baseInicial";
        $config['allowed_types'] = "*";
        $config['max_size'] = "50000";

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($mi_archivo)) {
//*** ocurrio un error
            $data['uploadError'] = $this->upload->display_errors();

            echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
            echo "<script>location.href='http://]" . $_SERVER['HTTP_HOST'] . "/index.php/importarinicial/" . $data['session']['proyecto_activo'] . "'</script>";
            return;
        } else {
//$data['uploadSuccess'] = $this->upload->data();
            $this->utilidades->saveEvent("cargue base inicial", $data['session']['id'], $data['session']['proyecto_activo']);
            $datas = array('upload_data' => $this->upload->data());
            $fila = 1;

            $filesname = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $datas['upload_data']['file_name'];
            if (($archivo = fopen("/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $datas['upload_data']['file_name'], "r")) !== false) {

                while (($datos = fgetcsv($archivo, 5000, ";")) !== FALSE) {
                    $numero = count($datos);

                    $campos = $datos;
                    break;
                }
                fclose($archivo);

//unlink($filesname);
            }
        }


        $data['archivo'] = $datas['upload_data']['file_name'];
        $data['campos'] = $campos;
        $data['creditos'] = $this->OperativoModel->getTablaCreditos($data['session']['proyecto_activo']);


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('operativo/upbaseinicial', $data);
        $this->load->view('templates/footer', $data);
    }

    public function executebasebcsc() {
        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $fecha = date("Y-m-d");

        $slug = $data['session']['proyecto_activo'];

        $fila = 1;

        $filesname = "/var/www/html/puntualmentecomco/modulo_cobranzas/front/files/actualizacion/GMA_PUNTUAL_AND_T1_DIARIA.txt";
        $directorio = "/var/www/html/puntualmentecomco/modulo_cobranzas/front/files/actualizacion";

        $iden = scandir($directorio);
        //$this->OperativoModel->inactivarClientesbcsc($slug);
        //$this->OperativoModel->inactivarObligacionesbcsc($slug);
        $this->OperativoModel->borraReferencias($data['session']['proyecto_activo']);

        $this->OperativoModel->borraPromesasBCSC($data['session']['proyecto_activo']);
        $this->OperativoModel->borraProcesosJuridicosbcsc($data['session']['proyecto_activo']);
        $this->OperativoModel->borraGestionJuridicabcsc($data['session']['proyecto_activo']);
        $this->OperativoModel->borraVisitasbcsc($data['session']['proyecto_activo']);
        $this->OperativoModel->borraMarcasClientebcsc($data['session']['proyecto_activo']);
        $this->OperativoModel->borraMarcasObligacionbcsc($data['session']['proyecto_activo']);
        $this->OperativoModel->borraMorosidad($data['session']['proyecto_activo']);


        foreach ($iden as $fichero) {
            $archivo = "/var/www/html/puntualmentecomco/modulo_cobranzas/front/files/actualizacion/" . $fichero;
            if ($fichero != "." && $fichero != "..") {
                $nomFile = explode("_", $fichero);
            } else {
                $nomFile [4] = "";
            }


            if ($nomFile[4] == "DIARIA.txt") {

                if (($archivo = fopen("/var/www/html/puntualmentecomco/modulo_cobranzas/front/files/actualizacion/" . $fichero, "r")) !== false) {

                    while (($datos = fgetcsv($archivo, 1000, "|")) !== FALSE) {

                        $numero = count($datos);

                        $fila++;


                        if ($datos[1] == 1) {

                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $sexo = $datos[4];
                            $estado = $datos[5];
                            $nombre = $datos[8] . " " . $datos[9] . " " . $datos[6] . " " . $datos[7];
                            $nombre = $this->utilidades->cleanText($nombre);
                            $fechaproxAcc = $datos[10];
                            $fechaNac = $datos[13];
                            $ultimoContacto = $datos[15];
                            $definicionUsuario = $datos[20];
                            $scoring = $datos[21];
                            $estrategia = $datos[22];
                            $entraaestrategia = $datos[23];
                            $salidaestrategia = $datos[24];
                            $grupo = $datos[27];
                            $obligaciones = $datos[30];
                            $fechaasignacionusuario = $datos[37];
                            $ultimousuario = $datos[42];
                            $calificacion = $datos[43];
                            $visitasrotas = $datos[47];
                            $gestContDirect = $datos[49];
                            $gestContInd = $datos[50];
                            $ultimoefecto = $datos[51];
                            $marcadelcliente = $datos[52];
                            $fchexpirasig = $datos[53];
                            $vectormax = $datos[54];
                            $vectoract = $datos[55];



                            $this->OperativoModel->insertClientesbcsc($doc, $entidad, $sexo, $estado, $nombre, $fechaproxAcc, $fechaNac, $ultimoContacto, $definicionUsuario, $scoring, $estrategia, $entraaestrategia, $salidaestrategia, $grupo, $obligaciones, $fechaasignacionusuario, $ultimousuario, $calificacion, $visitasrotas, $gestContDirect, $gestContInd, $ultimoefecto, $marcadelcliente, $fchexpirasig, $vectormax, $vectoract, $slug);
                        } else if ($datos[1] == 2) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $dir2 = $datos[4];
                            $dir = $this->utilidades->cleanText($dir2);
                            $zona = $datos[6];
                            $ciudad = $datos[7];
                            $dpto = $datos[8];
                            $tipoDir = $datos[9];
                            $estrato = $datos[10];
                            $pais = $datos[11];
                            $estado = $datos[13];
                            $dircorresp = $datos[15];

                            $this->OperativoModel->insertDireccionesbcsc($doc, $entidad, $dir, $zona, $ciudad, $dpto, $tipoDir, $estrato, $pais, $estado, $dircorresp, $slug);
                        } else if ($datos [1] == 3) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $tel = $datos[4];
                            $extension = $datos[5];
                            $codigoPais = $datos[6];
                            $indicativo = $datos[7];
                            $estado = $datos[8];
                            $secuencia = $datos[9];
                            $deudDatDem = $datos[10];
                            $tipoTel = $datos[11];
                            $tipoDir = $datos[12];
                            $califPositiva = $datos[13];

                            $this->OperativoModel->insertTelefonosbcsc($doc, $entidad, $tel, $extension, $codigoPais, $indicativo, $estado, $secuencia, $deudDatDem, $tipoTel, $tipoDir, $califPositiva, $slug);
                        } else if ($datos [1] == 4) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $subEntidad = $datos[4];
                            $producto = $datos[5];
                            $numObliga = $datos[6];
                            $fchAper = $datos[7];
                            $plazo = $datos[8];
                            $diaFact = $datos [9];
                            $dias = $datos[10];
                            $fchPago = $datos[12];
                            $fchVto = $datos[15];
                            $fchPag = $datos[16];
                            $fchCast = $datos[17];
                            $fchAct = $datos[18];
                            $oficina = $datos[22];
                            $sldOrig = $datos[24];
                            $sldCap = $datos[25];
                            $intCtes = $datos[26];
                            $sldTotal = $datos[27];
                            $vlrCuota = $datos[28];
                            $opCompra = $datos[29];
                            $capMora = $datos[30];
                            $intMora = $datos[31];
                            $carCob = $datos[32];
                            $cantDisp = $datos[33];
                            $sldMora = $datos[34];
                            $tasaInt = $datos[42];
                            $vlrSeg = $datos[41];
                            $vlrProv = $datos[43];
                            $califOblig = $datos[49];
                            $zona = $datos[50];
                            $region = $datos[51];
                            $ciudad = $datos[52];
                            $comFNG = $datos[53];
                            $otros = $datos[54];
                            $marcasFoc = $datos[55];

                            $this->OperativoModel->insertObligacionesbcsc($doc, $entidad, $subEntidad, $producto, $numObliga, $fchAper, $plazo, $diaFact, $dias, $fchPago, $fchVto, $fchPag, $fchCast, $fchAct, $oficina, $sldOrig, $sldCap, $intCtes, $sldTotal, $vlrCuota, $opCompra, $capMora, $intMora, $carCob, $cantDisp, $sldMora, $tasaInt, $vlrSeg, $vlrProv, $califOblig, $zona, $region, $ciudad, $comFNG, $otros, $marcasFoc, $slug);
                            if ($fchCast == "") {
                                $marca = 'DDR';
                            } else {
                                $marca = "Castigo";
                            }

                            $this->OperativoModel->insertInventarios($doc, $numObliga, $sldCap, $marca, $dias, $marcasFoc, $zona, $fechaNac, $fchCast, $grupo, $sldMora, $slug);
                        } else if ($datos [1] == 6) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $fchPago = $datos[4];
                            $numObliga = $datos[5];
                            $producto = $datos[6];
                            $vlrPago = $datos[7];
                            $tipoPago = $datos[8];
                            $tipoTrans = $datos[9];



                            $this->OperativoModel->insertPagosbcsc($doc, $entidad, $fchPago, $numObliga, $producto, $vlrPago, $tipoPago, $tipoTrans, $slug);
                        } else if ($datos [1] == 7) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $fchVto = $datos[4];
                            $vlrACanc = $datos[5];
                            $estado = $datos[6];
                            $numObliga = $datos[8];
                            $producto = $datos[9];
                            $entSecundaria = $datos[11];



                            $this->OperativoModel->insertPromesasbcsc($doc, $entidad, $fchVto, $vlrACanc, $estado, $numObliga, $producto, $entSecundaria, $slug);
                        } else if ($datos [1] == 10) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $proceso = $datos[4];
                            $codigo = $datos[5];
                            $abogado = $datos[6];
                            $juzgado = $datos[7];
                            $liquidacion = $datos[8];
                            $pagoReal = $datos[9];
                            $codFolio2 = $datos[10];
                            $codFolio = $this->utilidades->cleanText($$codFolio2);
                            $codExp = $datos[11];
                            $observ = $datos[12];
                            $numCuenta = $datos[13];
                            $entSecundaria = $datos[14];
                            $producto = $datos[15];
                            $camp1 = $datos[16];
                            $camp2 = $datos[17];
                            $camp3 = $datos[18];
                            $estadoEtapa = $datos[19];
                            $fchCreacion = $datos[20];
                            $fchAsigAbog = $datos[21];


                            $this->OperativoModel->insertProcesosJuridicosbcsc($doc, $entidad, $proceso, $codigo, $abogado, $juzgado, $liquidacion, $pagoReal, $codFolio, $codExp, $observ, $numCuenta, $entSecundaria, $producto, $camp1, $camp2, $camp3, $estadoEtapa, $fchCreacion, $fchAsigAbog, $slug);
                        } else if ($datos [1] == 11) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $proceso = $datos[4];
                            $codigo = $datos[5];
                            $estado = $datos[6];
                            $fchEntrada = $datos[7];
                            $fchSalida = $datos[8];
                            $observ2 = $datos[9];
                            $observ = $this->utilidades->cleanText($observ2);
                            $entSecundaria = $datos[10];
                            $producto = $datos[11];
                            $codEstado = $datos[12];
                            $estadoEatapa = $datos[13];



                            $this->OperativoModel->insertGestionJuridicabcsc($doc, $entidad, $proceso, $codigo, $estado, $fchEntrada, $fchSalida, $observ, $entSecundaria, $producto, $codEstado, $estadoEatapa, $slug);
                        } else if ($datos [1] == 17) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $persVisita = $datos[4];
                            $tipoDir = $datos[5];
                            $direccion = $datos[6];
                            $fchSolic = $datos[7];
                            $fchVisita = $datos[8];
                            $visitEfe = $datos[9];
                            $destVisita = $datos[11];
                            $timeIni = $datos[12];
                            $timeFin = $datos[13];
                            $estadoVisi = $datos[14];
                            $efectoVisi = $datos[15];



                            $this->OperativoModel->insertVisitasbcsc($doc, $entidad, $persVisita, $tipoDir, $direccion, $fchSolic, $fchVisita, $visitEfe, $destVisita, $timeIni, $timeFin, $estadoVisi, $efectoVisi, $slug);
                        } else if ($datos [1] == 21) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $chardefined1 = $datos[4];
                            $chardefined2 = $datos[5];
                            $chardefined3 = $datos[6];
                            $chardefined4 = $datos[7];
                            $chardefined5 = $datos[8];
                            $chardefined6 = $datos[9];
                            $chardefined7 = $datos[10];
                            $chardefined8 = $datos[11];
                            $chardefined9 = $datos[12];
                            $chardefined10 = $datos[13];
                            $numberdefined1 = $datos[14];
                            $datedefined1 = $datos[24];
                            $datedefined2 = $datos[25];
                            $datedefined3 = $datos[26];


                            $this->OperativoModel->insertMarcasClientebcsc($doc, $entidad, $chardefined1, $chardefined2, $chardefined3, $chardefined4, $chardefined5, $chardefined6, $chardefined7, $chardefined8, $chardefined9, $chardefined10, $numberdefined1, $datedefined1, $datedefined2, $datedefined3, $slug);
                        } else if ($datos [1] == 22) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $credito = $datos[4];
                            $producto = $datos[5];
                            $entidad = $datos[6];
                            $chardefined1 = $datos[7];
                            $chardefined2 = $datos[8];
                            $chardefined3 = $datos[9];
                            $chardefined4 = $datos[10];
                            $chardefined5 = $datos[11];
                            $chardefined6 = $datos[12];
                            $chardefined7 = $datos[13];
                            $chardefined8 = $datos[14];
                            $chardefined9 = $datos[15];
                            $chardefined10 = $datos[16];
                            $numberdefined1 = $datos[17];
                            $numberdefined2 = $datos[18];
                            $numberdefined3 = $datos[19];
                            $numberdefined4 = $datos[20];
                            $numberdefined5 = $datos[21];
                            $numberdefined6 = $datos[22];
                            $numberdefined7 = $datos[23];
                            $numberdefined8 = $datos[24];
                            $numberdefined9 = $datos[25];
                            $numberdefined10 = $datos[26];
                            $datedefined1 = $datos[27];
                            $datedefined2 = $datos[28];
                            $datedefined3 = $datos[29];
                            $datedefined4 = $datos[30];
                            $datedefined5 = $datos[31];
                            $datedefined6 = $datos[32];
                            $datedefined7 = $datos[33];
                            $datedefined8 = $datos[34];
                            $datedefined9 = $datos[35];
                            $datedefined10 = $datos[36];




                            $this->OperativoModel->insertMarcasObligacionbcsc($doc, $entidad, $credito, $producto, $entidad, $chardefined1, $chardefined2, $chardefined3, $chardefined4, $chardefined5, $chardefined6, $chardefined7, $chardefined8, $chardefined9, $chardefined10, $numberdefined1, $numberdefined2, $numberdefined3, $numberdefined4, $numberdefined5, $numberdefined6, $numberdefined7, $numberdefined8, $numberdefined9, $numberdefined10, $datedefined1, $datedefined2, $datedefined3, $datedefined4, $datedefined5, $datedefined6, $datedefined7, $datedefined8, $datedefined9, $datedefined10, $slug);
                        } else if ($datos [1] == 19) {


                            $documento = $datos[2];
                            $entidad = $datos[3];
                            $entidad_obligacion = $datos[4];
                            $producto = $datos[5];
                            $obligacion = $datos[6];
                            $saldoenMora = $datos[7];
                            $capitalMora = $datos[8];
                            $diasMora = $datos[9];
                            $diasMoraSistema = $datos[10];
                            $fch_factura = $datos[11];
                            $edadMora = $datos[12];
                            $moraSinIntMoraPagada = $datos[13];
                            $montoIntCuotaenMora = $datos[14];
                            $montoIntCuotaenMoraPagada = $datos[15];
                            $montoComisionCuotaenMora = $datos[16];
                            $montoComisionCuotaenMora2 = $datos[17];
                            $montoSegCuotaenMora = $datos[18];
                            $montoSegCuotaenMoraPagada = $datos[19];
                            $montoSegIncCuotaenMora = $datos[20];
                            $montoSegIncCuotaenMoraPagada = $datos[21];
                            $montootroCampoCuotaenMora = $datos[22];
                            $montootroCampoCuotaenMoraPagada = $datos[23];
                            $causaEstado = $datos[24];
                            $estadoCuota = $datos[25];
                            $fch_act_pago = $datos[26];
                            $montoPago = $datos[27];
                            $fch_ingreso_cuota = $datos[28];
                            $fch_castigado_cuota = $datos[29];



                            $this->OperativoModel->insertMorosidad($documento, $entidad, $entidad_obligacion, $producto, $obligacion, $saldoenMora, $capitalMora, $diasMora, $diasMoraSistema, $fch_factura, $edadMora, $moraSinIntMoraPagada, $montoIntCuotaenMora, $montoIntCuotaenMoraPagada, $montoComisionCuotaenMora, $montoComisionCuotaenMora2, $montoSegCuotaenMora, $montoSegCuotaenMoraPagada, $montoSegIncCuotaenMora, $montoSegIncCuotaenMoraPagada, $montootroCampoCuotaenMora, $montootroCampoCuotaenMoraPagada, $causaEstado, $estadoCuota, $fch_act_pago, $montoPago, $fch_ingreso_cuota, $fch_castigado_cuota, $slug);
                        }
                    }

//fclose($archivo);
//unlink($filesname);
                }

//fin Diaria
            } else if ($nomFile[4] == "DESASIGNACION.txt") {

                if (($archivo = fopen("/var/www/html/puntualmentecomco/modulo_cobranzas/front/files/actualizacion/" . $fichero, "r")) !== false) {

                    while (($datos = fgetcsv($archivo, 1000, "|")) !== FALSE) {

                        $numero = count($datos);

                        $fila++;

                        $doc = $datos[0];
                        $entidad = $datos[1];
                        $credito = $datos[2];
                        $causaEstado = $datos[3];
                        $fecha = $datos[4];
                        $diasMora = $datos[5];
                        $fechaPago = $datos[6];
                        $tipoPago = $datos[7];
                        $tipoTrans = $datos[8];
                        $valorPago = $datos[9];

                        $this->OperativoModel->insertDesasignados($doc, $entidad, $credito, $causaEstado, $fecha, $diasMora, $fechaPago, $tipoPago, $tipoTrans, $valorPago, $slug);
                    }
                }
            } else if ($nomFile[4] == "REFERENCIAS.txt") {

                if (($archivo = fopen("/var/www/html/puntualmentecomco/modulo_cobranzas/front/files/actualizacion/" . $fichero, "r")) !== false) {

                    while (($datos = fgetcsv($archivo, 1000, "|")) !== FALSE) {

                        $numero = count($datos);

                        $fila++;

                        $doc = $datos[0];
                        $nombreReferencia = $datos[1];
                        $relacion = $datos[2];
                        $ciudad = $datos[3];
                        $indicativo = $datos[4];
                        $telefonoFijo = $datos[5];
                        $telefonoCelular = $datos[6];
                        $grupo = $datos[7];



                        $this->OperativoModel->insertReferencias($doc, $nombreReferencia, $relacion, $ciudad, $indicativo, $telefonoFijo, $telefonoCelular, $grupo, $slug);
                    }
                }
            }
        }
        //$this->OperativoModel->desactivaTareas($slug);
        //$this->OperativoModel->desactivaProgramados($slug);
        //$this->OperativoModel->markDesasignaciones;
        echo "<script>location.href='https://consulegalab.com/modulo_cobranzas/index.php/dashboard/bcsc'</script>";
    }

    public function executebasepic() {
        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $fecha = date("Y-m-d");

        $slug = $data['session']['proyecto_activo'];

        $fila = 1;

        $filesname = "/var/www/html/puntualmentecomco/modulo_cobranzas/front/files/actualizacion/PROM_GPROM_PUNTUALMENTE.TXT";
        $directorio = "/var/www/html/puntualmentecomco/modulo_cobranzas/front/files/actualizacion";

        $iden = scandir($directorio);
        //$this->OperativoModel->inactivarClientesbcsc($slug);
        //$this->OperativoModel->inactivarObligacionesbcsc($slug);

        foreach ($iden as $fichero) {
            $archivo = "/var/www/html/puntualmentecomco/modulo_cobranzas/front/files/actualizacion/" . $fichero;
            if ($fichero != "." && $fichero != "..") {
                $nomFile = explode("_", $fichero);
            } else {
                $nomFile [2] = "";
            }


            if ($nomFile[2] == "PUNTUALMENTE.TXT") {

                if (($archivo = fopen("/var/www/html/puntualmentecomco/modulo_cobranzas/front/files/actualizacion/" . $fichero, "r")) !== false) {

                    while (($datos = fgetcsv($archivo, 1000, "|")) !== FALSE) {

                        $numero = count($datos);

                        $fila++;


                        if ($datos[1] == 1) {

                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $sexo = $datos[4];
                            $estado = $datos[5];
                            $nombre = $datos[8] . " " . $datos[9] . " " . $datos[6] . " " . $datos[7];
                            $nombre = $this->utilidades->cleanText($nombre);
                            $fechaproxAcc = $datos[10];
                            $fechaNac = $datos[13];
                            $ultimoContacto = $datos[15];
                            $definicionUsuario = $datos[20];
                            $scoring = $datos[21];
                            $estrategia = $datos[22];
                            $entraaestrategia = $datos[23];
                            $salidaestrategia = $datos[24];
                            $grupo = $datos[27];
                            $obligaciones = $datos[30];
                            $fechaasignacionusuario = $datos[37];
                            $ultimousuario = $datos[42];
                            $calificacion = $datos[43];
                            $visitasrotas = $datos[47];
                            $gestContDirect = $datos[49];
                            $gestContInd = $datos[50];
                            $ultimoefecto = $datos[51];
                            $marcadelcliente = $datos[52];
                            $fchexpirasig = $datos[53];
                            $vectormax = $datos[54];
                            $vectoract = $datos[55];



                            $this->OperativoModel->insertClientespic($doc, $entidad, $sexo, $estado, $nombre, $fechaproxAcc, $fechaNac, $ultimoContacto, $definicionUsuario, $scoring, $estrategia, $entraaestrategia, $salidaestrategia, $grupo, $obligaciones, $fechaasignacionusuario, $ultimousuario, $calificacion, $visitasrotas, $gestContDirect, $gestContInd, $ultimoefecto, $marcadelcliente, $fchexpirasig, $vectormax, $vectoract, $slug);
                        } else if ($datos[1] == 2) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $dir2 = $datos[4];
                            $dir = $this->utilidades->cleanText($dir2);
                            $zona = $datos[6];
                            $ciudad = $datos[7];
                            $dpto = $datos[8];
                            $tipoDir = $datos[9];
                            $estrato = $datos[10];
                            $pais = $datos[11];
                            $estado = $datos[13];
                            $dircorresp = $datos[15];

                            $this->OperativoModel->insertDireccionespic($doc, $entidad, $dir, $zona, $ciudad, $dpto, $tipoDir, $estrato, $pais, $estado, $dircorresp, $slug);
                        } else if ($datos [1] == 3) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $tel = $datos[4];
                            $extension = $datos[5];
                            $codigoPais = $datos[6];
                            $indicativo = $datos[7];
                            $estado = $datos[8];
                            $secuencia = $datos[9];
                            $deudDatDem = $datos[10];
                            $tipoTel = $datos[11];
                            $tipoDir = $datos[12];
                            $califPositiva = $datos[13];

                            $this->OperativoModel->insertTelefonospic($doc, $entidad, $tel, $extension, $codigoPais, $indicativo, $estado, $secuencia, $deudDatDem, $tipoTel, $tipoDir, $califPositiva, $slug);
                        } else if ($datos [1] == 4) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $subEntidad = $datos[4];
                            $producto = $datos[5];
                            $numObliga = $datos[6];
                            $fchAper = $datos[7];
                            $plazo = $datos[8];
                            $diaFact = $datos [9];
                            $dias = $datos[10];
                            $fchPago = $datos[12];
                            $fchVto = $datos[15];
                            $fchPag = $datos[16];
                            $fchCast = $datos[17];
                            $fchAct = $datos[18];
                            $oficina = $datos[22];
                            $sldOrig = $datos[24];
                            $sldCap = $datos[25];
                            $intCtes = $datos[26];
                            $sldTotal = $datos[27];
                            $vlrCuota = $datos[28];
                            $opCompra = $datos[29];
                            $capMora = $datos[30];
                            $intMora = $datos[31];
                            $carCob = $datos[32];
                            $cantDisp = $datos[33];
                            $sldMora = $datos[34];
                            $tasaInt = $datos[42];
                            $vlrSeg = $datos[41];
                            $vlrProv = $datos[43];
                            $califOblig = $datos[49];
                            $zona = $datos[50];
                            $region = $datos[51];
                            $ciudad = $datos[52];
                            $comFNG = $datos[53];
                            $otros = $datos[54];
                            $marcasFoc = $datos[55];

                            $this->OperativoModel->insertObligacionespic($doc, $entidad, $subEntidad, $producto, $numObliga, $fchAper, $plazo, $diaFact, $dias, $fchPago, $fchVto, $fchPag, $fchCast, $fchAct, $oficina, $sldOrig, $sldCap, $intCtes, $sldTotal, $vlrCuota, $opCompra, $capMora, $intMora, $carCob, $cantDisp, $sldMora, $tasaInt, $vlrSeg, $vlrProv, $califOblig, $zona, $region, $ciudad, $comFNG, $otros, $marcasFoc, $slug);
                        } else if ($datos [1] == 6) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $fchPago = $datos[4];
                            $numObliga = $datos[5];
                            $producto = $datos[6];
                            $vlrPago = $datos[7];
                            $tipoPago = $datos[8];
                            $tipoTrans = $datos[9];

                            $this->OperativoModel->insertPagospic($doc, $entidad, $fchPago, $numObliga, $producto, $vlrPago, $tipoPago, $tipoTrans, $slug);
                        } else if ($datos [1] == 7) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $fchVto = $datos[4];
                            $vlrACanc = $datos[5];
                            $estado = $datos[6];
                            $numObliga = $datos[8];
                            $producto = $datos[9];
                            $entSecundaria = $datos[11];



                            $this->OperativoModel->insertPromesaspic($doc, $entidad, $fchVto, $vlrACanc, $estado, $numObliga, $producto, $entSecundaria, $slug);
                        } else if ($datos [1] == 8) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $usuario = $datos[4];
                            $fechGestion = $datos[5];
                            $accion = $datos[6];
                            $observacion2 = $datos[7];
							$observacion = $this->utilidades->cleanText($observacion2);
                            $proxGestion = $datos[8];
                            $telefono = $datos[9];
                            $grupo = $datos[10];
                            $efecto = $datos[11];
							$contacto = $datos[12];
                            $entidadSec = $datos[13];
                            $numOblig = $datos[14];
                            $proOblig = $datos[15];
                            $motivoNo = $datos[16];

                            $this->OperativoModel->insertGestionpic($doc, $entidad,$usuario,$fechGestion,$accion,$observacion,$proxGestion,$telefono,$grupo,$efecto,$entidadSec,$numOblig,$proOblig,$motivoNo,$slug);
                        } else if ($datos [1] == 17) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $persVisita = $datos[4];
                            $tipoDir = $datos[5];
                            $direccion = $datos[6];
                            $fchSolic = $datos[7];
                            $fchVisita = $datos[8];
                            $visitEfe = $datos[9];
                            $destVisita = $datos[11];
                            $timeIni = $datos[12];
                            $timeFin = $datos[13];
                            $estadoVisi = $datos[14];
                            $efectoVisi = $datos[15];



                            $this->OperativoModel->insertVisitaspic($doc, $entidad, $persVisita, $tipoDir, $direccion, $fchSolic, $fchVisita, $visitEfe, $destVisita, $timeIni, $timeFin, $estadoVisi, $efectoVisi, $slug);
                        } else if ($datos [1] == 18) {


                            $doc = $datos[2];
                            $entidad = $datos[3];
                            $docCod = $datos[4];
                            $nombreCod = $datos[5];
                            $entidad2 = $datos[6];
                            $prodOblig = $datos[7];
                            $numOblig = $datos[8];

                            $this->OperativoModel->insertCodeudorespic($doc,$entidad,$docCod,$nommbreCod,$entidad2,$prodOblig,$numOblig,$slug);
                        }
                    }

//fclose($archivo);
//unlink($filesname);
                }
}
}
//fin Diaria
        echo "<script>location.href='https://consulegalab.com/modulo_cobranzas/index.php/dashboard/promotora'</script>";
    }

    public function executebaseinicial() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $fecha = date("Y-m-d");

        //$this->OperativoModel->unactivateClientes($data['session']['proyecto_activo']);
        //$this->OperativoModel->borraCreditos($data['session']['proyecto_activo']);
        $key = $this->OperativoModel->getKey();
        $archivo = $this->input->post('archivos');

        if ($data['session']['proyecto_activo'] == "rapicredit") {
            $this->OperativoModel->borraTareasRapi($data['session']['proyecto_activo']);
        }

        $fila = 1;

        $file = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $archivo;

        if (($archivo = fopen("/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $archivo, "r")) !== false) {

            while (($datos = fgetcsv($archivo, 50000, ";")) !== FALSE) {
                $numero = count($datos);

                $fila++;
                if ($fila > 2) {
                    $documento = $datos[$this->input->post('documento')];
                    $nombre = $datos[$this->input->post('nombre')];

                    $this->OperativoModel->uploadClientes($documento, $nombre, $data['session']['proyecto_activo']);


                    $consultaCreditos = "insert into 9_creditos (";



                    foreach ($_REQUEST as $clave => $valor) {
                        if ($clave != "nombre" && $clave != "archivos" && $clave != "telefono1" && $clave != "telefono2" && $clave != "telefono3" && $clave != "telefono4" && $clave != "telefono5" && $clave != "telefono6" && $clave != "telefono7" && $clave != "telefono8" && $clave != "ciudadOri") {
                            $consultaCreditos .= $clave . ",";
                        }
                    }

                    $consultaCreditos = substr($consultaCreditos, 0, -1);
                    $consultaCreditos .= ",fechacargue, activo, fechaActualizacion, estadoActual) values (";

                    foreach ($_REQUEST as $clave => $valor) {
                        if ($clave == "documento" || $clave == "obligacion") {
                            $consultaCreditos .= "AES_ENCRYPT('" . $datos[$valor] . "', '" . $key . "'), ";
                        } else {
                            if ($clave != "archivos" && $clave != "nombre" && $clave != "telefono1" && $clave != "telefono2" && $clave != "telefono3" && $clave != "telefono4" && $clave != "telefono5" && $clave != "telefono6" && $clave != "telefono7" && $clave != "telefono8" && $clave != "ciudadOri") {
                                $consultaCreditos .= "'" . $this->utilidades->cleanText($datos[$valor]) . "',";
                            }
                        }
                    }

                    $consultaCreditos = substr($consultaCreditos, 0, -1);

                    $consultaCreditos .= ",'$fecha', '1', '$fecha', 'MORA') on duplicate key update activo = '1'; ";


                    $this->OperativoModel->uploadCreditos($consultaCreditos, $data['session']['proyecto_activo']);


                    $telefono1 = $datos[$this->input->post('telefono1')];
                    $telefono2 = $datos[$this->input->post('telefono2')];
                    $telefono3 = $datos[$this->input->post('telefono3')];
                    $telefono4 = $datos[$this->input->post('telefono4')];
                    $telefono5 = $datos[$this->input->post('telefono5')];
                    $telefono6 = $datos[$this->input->post('telefono6')];
                    $telefono7 = $datos[$this->input->post('telefono7')];
                    $telefono8 = $datos[$this->input->post('telefono8')];
                    $ciudadOri = $datos[$this->input->post('ciudadOri')];


                    $this->OperativoModel->uploadTelefonos($documento, $telefono1, $ciudadOri, $data['session']['proyecto_activo']);
                    $this->OperativoModel->uploadTelefonos($documento, $telefono2, $ciudadOri, $data['session']['proyecto_activo']);
                    $this->OperativoModel->uploadTelefonos($documento, $telefono3, $ciudadOri, $data['session']['proyecto_activo']);
                    $this->OperativoModel->uploadTelefonos($documento, $telefono4, $ciudadOri, $data['session']['proyecto_activo']);
                    $this->OperativoModel->uploadTelefonos($documento, $telefono5, $ciudadOri, $data['session']['proyecto_activo']);
                    $this->OperativoModel->uploadTelefonos($documento, $telefono6, $ciudadOri, $data['session']['proyecto_activo']);
                    $this->OperativoModel->uploadTelefonos($documento, $telefono7, $ciudadOri, $data['session']['proyecto_activo']);
                    $this->OperativoModel->uploadTelefonos($documento, $telefono8, $ciudadOri, $data['session']['proyecto_activo']);
                }
            }
            if ($data['session']['proyecto_activo'] == "rapicredit") {
                $nc = $this->OperativoModel->getNoContacto($data['session']['proyecto_activo']);
                foreach ($nc as $nct) {
                    $this->OperativoModel->insertarea($nct['documento'], "No_Contacto_Firmas", $data['session']['proyecto_activo']);
                }


                $singes = $this->OperativoModel->getSinGestion($data['session']['proyecto_activo']);


                foreach ($singes as $singest) {
                    $this->OperativoModel->insertarea($singest['documento'], "Sin_Gestion_Firmas", $data['session']['proyecto_activo']);
                }
            }
            fclose($archivo);

            unlink($file);
            $this->utilidades->saveEvent("procesa base inicial", $data['session']['id'], $data['session']['proyecto_activo']);
        }


        $data['clientes'] = $this->OperativoModel->getNumClientes($data['session']['proyecto_activo']);
        $data['cuentas'] = $this->OperativoModel->getNumCreditos($data['session']['proyecto_activo']);


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('operativo/resumentablas', $data);
        $this->load->view('templates/footer', $data);
    }

    public function visoreventos() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/visoreventos', $data);
        $this->load->view('templates/footer', $data);
    }

    public function resultadoeventosbuscar() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $criter = $this->input->post('crit');
        $valor = $this->input->post('val');

        if ($criter == "1") {
            $result = $this->OperativoModel->getEventosFecha($valor, $data['session']['proyecto_activo']);
        } elseif ($criter == "2") {
            $result = $this->OperativoModel->getEventosDocu($valor, $data['session']['proyecto_activo']);
        } elseif ($criter == "3") {
            $result = $this->OperativoModel->getEventosASeso($valor, $data['session']['proyecto_activo']);
        } elseif ($criter == "4") {
            $result = $this->OperativoModel->getEventosIp($valor, $data['session']['proyecto_activo']);
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
  							<th class="footable-visible footable-first-column" data-toggle="true">Evento</th>
  							<th class="footable-visible footable-first-column" data-toggle="true">Usuario</th>
  							<th class="footable-visible footable-first-column" data-toggle="true">Fecha</th>
  							<th class="footable-visible footable-first-column" data-toggle="true">Hora</th>
                <th class="footable-visible footable-first-column" data-toggle="true">Ip</th>
                <th class="footable-visible footable-first-column" data-toggle="true">Documento</th>
                <th class="footable-visible footable-first-column" data-toggle="true">Query</th>
  						</tr>
  					</thead>
  					';

            foreach ($result as $r) {

                $asesor = $this->OperativoModel->getusuarioId($r['idUser']);

                $html .= '<tbody>
  						<tr>
  							<td class="footable-visible footable-first-column">' . $r['evento'] . '</td>
  							<td class="footable-visible footable-first-column">' . $asesor[0]['nombre'] . '</td>
  							<td class="footable-visible footable-first-column">' . $r['fecha'] . '</td>
  							<td class="footable-visible footable-first-column">' . $r['hora'] . '</td>
                <td class="footable-visible footable-first-column">' . $r['ip'] . '</td>
                <td class="footable-visible footable-first-column">' . $r['documento'] . '</td>
                <td class="footable-visible footable-first-column">' . str_replace("4nd3rsV4g45", "", $r['query']) . '</td>
  						</tr>';
            }
            $html .= '</table>
  			</div>';
        }



        echo $html;
    }

    public function buscar() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/buscar', $data);
        $this->load->view('templates/footer', $data);
    }

    public function arbol() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $data['acciones'] = $this->OperativoModel->getAcciones($data['session']['proyecto_activo']);
        $data['contacto'] = $this->OperativoModel->getContacto($data['session']['proyecto_activo']);
        $data['resultado'] = $this->OperativoModel->getResultado($data['session']['proyecto_activo']);
        $data['motivos'] = $this->OperativoModel->getMotivos($data['session']['proyecto_activo']);
        $data['relaciones'] = $this->OperativoModel->getRelaciones($data['session']['proyecto_activo']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('operativo/arbol', $data);
        $this->load->view('templates/footer', $data);
    }

    public function savenewaction() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $acccion1 = $this->input->post("action");
        $guion1 = $this->input->post("guio");

        $accion = $this->utilidades->cleanText($acccion1);
        $guion = $this->utilidades->cleanText($guion1);

        $accion = ucwords($accion);


        $this->OperativoModel->saveAcciones($accion, $guion, $data['session']['proyecto_activo']);
        $this->utilidades->saveEvent("guarda nueva accion: " . $accion, $data['session']['id'], $data['session']['proyecto_activo']);

        $acciones = $this->OperativoModel->getAcciones($data['session']['proyecto_activo']);

        $html = "";

        $html .= '<table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Id Acción</th>
                                <th>Acción</th>
                                <th>Guión</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($acciones as $acc) {
            $html .= '<tr>
                                    <td>' . $acc['idAccion'] . '</td>
                                    <td>' . $acc['descripcion'] . '</td>
                                    <td>' . $acc['guion'] . '</td>';
            if ($acc['idAccion'] > 5) {
                $html .= '  <td><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/edit.png" class="editar" flag="' . $acc['idAccion'] . '" tabla="acciones" alt="Editar" title="Editar"/>&nbsp;&nbsp;&nbsp;<img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/delete.png" flag="' . $acc['idAccion'] . '" tabla="acciones" class="borrar" alt="Borrar" title="Borrar"/></td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>
                    </table>';

        echo $html;
    }

    public function editnewaction() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $acccion1 = $this->input->post("action");
        $guion1 = $this->input->post("guio");
        $id = $this->input->post("ids");

        $accion = $this->utilidades->cleanText($acccion1);
        $guion = $this->utilidades->cleanText($guion1);

        $accion = ucwords($accion);


        $this->OperativoModel->editAcciones($accion, $guion, $id, $data['session']['proyecto_activo']);
        $this->utilidades->saveEvent("edita accion: " . $accion, $data['session']['id'], $data['session']['proyecto_activo']);
    }

    public function savenewcontacto() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $contacto1 = $this->input->post("contact");
        $grupo = $this->input->post("group");
        $guion1 = $this->input->post("guio");

        $contactos = $this->utilidades->cleanText($contacto1);
        $guion = $this->utilidades->cleanText($guion1);

        $contactos = ucwords($contactos);


        $this->OperativoModel->saveContacto($contactos, $grupo, $guion, $data['session']['proyecto_activo']);
        $this->utilidades->saveEvent("guarda nuevo contacto: " . $contactos, $data['session']['id'], $data['session']['proyecto_activo']);

        $contacto = $this->OperativoModel->getContacto($data['session']['proyecto_activo']);

        $html = "";

        $html .= '<table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Id Contacto</th>
                                <th>Contacto</th>
                                <th>Grupo</th>
                                <th>Guión</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($contacto as $cont) {
            $grupoC = $this->OperativoModel->getGruposContactoUno($cont['idGrupo'], $data['session']['proyecto_activo']);

            $html .= '<tr>
                                    <td>' . $cont['idContacto'] . '</td>
                                    <td>' . $cont['descripcion'] . '</td>
                                    <td>' . $grupoC[0]['descripcion'] . '</td>
                                    <td>' . $cont['guion'] . '</td>
                                    <td><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/edit.png" class="editar" flag="' . $cont['idContacto'] . '" tabla="contacto" alt="Editar" title="Editar"/>&nbsp;&nbsp;&nbsp;<img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/delete.png" flag="' . $cont['idContacto'] . '" tabla="contacto" class="borrar" alt="Borrar" title="Borrar"/></td>
                                </tr>';
        }
        $html .= '</tbody>
                    </table>';

        echo $html;
    }

    public function editnewcontacto() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $contacto1 = $this->input->post("contact");
        $grupo = $this->input->post("group");
        $id = $this->input->post("ids");
        $guion1 = $this->input->post("guio");

        $contactos = $this->utilidades->cleanText($contacto1);
        $guion = $this->utilidades->cleanText($guion1);

        $contactos = ucwords($contactos);


        $this->OperativoModel->editContacto($contactos, $grupo, $guion, $id, $data['session']['proyecto_activo']);
        $this->utilidades->saveEvent("edita contacto: " . $contactos, $data['session']['id'], $data['session']['proyecto_activo']);
    }

    public function savenewresultado() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $resultado1 = $this->input->post("result");
        $nivel = $this->input->post("nive");
        $fecha = $this->input->post("fech");
        $valor = $this->input->post("valo");
        $texto = $this->input->post("text");
        $guion1 = $this->input->post("guio");

        $resultados = $this->utilidades->cleanText($resultado1);
        $guion = $this->utilidades->cleanText($guion1);

        $resultados = ucwords($resultados);


        $this->OperativoModel->saveResultado($resultados, $nivel, $fecha, $valor, $texto, $guion, $data['session']['proyecto_activo']);
        $this->utilidades->saveEvent("guarda nuevo resultado: " . $resultados, $data['session']['id'], $data['session']['proyecto_activo']);

        $resultado = $this->OperativoModel->getResultado($data['session']['proyecto_activo']);

        $html = "";

        $html .= '<table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Id Resultado</th>
                                <th>Resultado</th>
                                <th>Nivel</th>
                                <th>Fecha</th>
                                <th>Valor</th>
                                <th>Texto</th>
                                <th>Guion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';

        foreach ($resultado as $resu) {

            if ($resu['fecha'] == 1) {
                $fecha = "SI";
            } else {
                $fecha = "NO";
            }

            if ($resu['valor'] == 1) {
                $valor = "SI";
            } else {
                $valor = "NO";
            }

            if ($resu['texto'] == 1) {
                $texto = "SI";
            } else {
                $texto = "NO";
            }

            $html .= '  <tr>
                                    <td>' . $resu['idCodres'] . '</td>
                                    <td>' . $resu['descripcion'] . '</td>
                                    <td>' . $resu['nivel'] . '</td>
                                    <td>' . $fecha . '</td>
                                    <td>' . $valor . '</td>
                                    <td>' . $texto . '</td>
                                    <td>' . $resu['guion'] . '</td>
                                    <td><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/edit.png" class="editar" flag="' . $resu['idCodres'] . '" tabla="resultado" alt="Editar" title="Editar"/>&nbsp;&nbsp;&nbsp;<img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/delete.png" flag="' . $resu['idCodres'] . '" tabla="resultado" class="borrar" alt="Borrar" title="Borrar"/></td>
                                </tr>';
        }
        $html .= '</tbody>
                    </table>';

        echo $html;
    }

    public function editnewresultado() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $resultado1 = $this->input->post("result");
        $nivel = $this->input->post("nive");
        $fecha = $this->input->post("fech");
        $valor = $this->input->post("valo");
        $texto = $this->input->post("text");
        $guion1 = $this->input->post("guio");
        $id = $this->input->post("ids");

        $resultados = $this->utilidades->cleanText($resultado1);
        $guion = $this->utilidades->cleanText($guion1);

        $resultados = ucwords($resultados);


        $this->OperativoModel->editResultado($resultados, $nivel, $fecha, $valor, $texto, $guion, $id, $data['session']['proyecto_activo']);
        $this->utilidades->saveEvent("edita resultado: " . $resultados, $data['session']['id'], $data['session']['proyecto_activo']);
    }

    public function savenewmotivo() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $motivo1 = $this->input->post("motiv");

        $motivo = $this->utilidades->cleanText($motivo1);


        $motivo = ucwords($motivo);


        $this->OperativoModel->saveMotivos($motivo, $data['session']['proyecto_activo']);
        $this->utilidades->saveEvent("guarda nuevo motivo: " . $motivo, $data['session']['id'], $data['session']['proyecto_activo']);

        $motivos = $this->OperativoModel->getMotivos($data['session']['proyecto_activo']);

        $html = "";

        $html .= '<table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Id Motivo</th>
                                <th>Motivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($motivos as $moti) {
            $html .= '<tr>
                                    <td>' . $moti['idMotivo'] . '</td>
                                    <td>' . $moti['descripcion'] . '</td>
                                    <td><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/edit.png" class="editar" flag="' . $moti['idMotivo'] . '" tabla="motivos" alt="Editar" title="Editar"/>&nbsp;&nbsp;&nbsp;<img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/delete.png" flag="' . $moti['idMotivo'] . '" tabla="motivos" class="borrar" alt="Borrar" title="Borrar"/></td>
                                </tr>';
        }
        $html .= '</tbody>
                    </table>';

        echo $html;
    }

    public function editnewmotivo() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $motivo1 = $this->input->post("motiv");
        $id = $this->input->post("ids");

        $motivo = $this->utilidades->cleanText($motivo1);


        $motivo = ucwords($motivo);


        $this->OperativoModel->editMotivos($motivo, $id, $data['session']['proyecto_activo']);
        $this->utilidades->saveEvent("edita motivo: " . $motivo, $data['session']['id'], $data['session']['proyecto_activo']);
    }

    public function savenewrelacion() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $accion = $this->input->post("action");
        $contacto = $this->input->post("contact");
        $resultado = $this->input->post("result");

        $this->OperativoModel->saveRelacion($accion, $contacto, $resultado, $data['session']['proyecto_activo']);
        $this->utilidades->saveEvent("guarda nueva relacion: " . $accion . "-" . $contacto . "-" . $resultado, $data['session']['id'], $data['session']['proyecto_activo']);

        $relaciones = $this->OperativoModel->getRelaciones($data['session']['proyecto_activo']);

        $html = "";

        $html .= '<table class="table table-togglable table-hover footable-loaded footable tablet breakpoint">
                        <thead>
                            <tr>
                                <th>Id Relación</th>
                                <th>Accion</th>
                                <th>Contacto</th>
                                <th>Resultado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($relaciones as $rel) {
            $accionR = $this->OperativoModel->getAccionUno($rel['idAccion'], $data['session']['proyecto_activo']);
            $contactoR = $this->OperativoModel->getContactoUno($rel['idContacto'], $data['session']['proyecto_activo']);
            $resultadoR = $this->OperativoModel->getResultadoUno($rel['idResultado'], $data['session']['proyecto_activo']);

            $html .= '<tr>
                                    <td>' . $rel['idRelacion'] . '</td>
                                    <td>' . $accionR[0]['descripcion'] . '</td>
                                    <td>' . $contactoR[0]['descripcion'] . '</td>
                                    <td>' . $resultadoR[0]['descripcion'] . '</td>
                                    <td><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/delete.png" flag="' . $rel['idRelacion'] . '" tabla="contacto" class="borrar" alt="Borrar" title="Borrar"/></td>
                                </tr>';
        }
        $html .= '</tbody>
                    </table>';

        echo $html;
    }

    public function droparbol() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $id = $this->input->post("ids");
        $tabla = $this->input->post("tablas");

        if ($tabla == "acciones") {
            $this->OperativoModel->deleteAcciones($id, $data['session']['proyecto_activo']);
            $this->utilidades->saveEvent("elimina accion: " . $id, $data['session']['id'], $data['session']['proyecto_activo']);
        } else if ($tabla == "contacto") {
            $this->OperativoModel->deleteContacto($id, $data['session']['proyecto_activo']);
            $this->utilidades->saveEvent("elimina contacto: " . $id, $data['session']['id'], $data['session']['proyecto_activo']);
        } else if ($tabla == "resultado") {
            $this->OperativoModel->deleteResultado($id, $data['session']['proyecto_activo']);
            $this->utilidades->saveEvent("elimina resultado: " . $id, $data['session']['id'], $data['session']['proyecto_activo']);
        } else if ($tabla == "motivos") {
            $this->OperativoModel->deleteMotivos($id, $data['session']['proyecto_activo']);
            $this->utilidades->saveEvent("elimina motivo: " . $id, $data['session']['id'], $data['session']['proyecto_activo']);
        }
    }

    public function exportarinformebbva($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('operativo/fechainfobbva', $data);
        $this->load->view('templates/footer', $data);
    }

    public function generainformebbva() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();


        $prefechaini = explode("/", $this->input->post("fechaIni"));
        $prefechafin = explode("/", $this->input->post("fechaFin"));

        $fechaini = $prefechaini[2] . "-" . $prefechaini[0] . "-" . $prefechaini[1];
        $fechafin = $prefechafin[2] . "-" . $prefechafin[0] . "-" . $prefechafin[1];

        $data['fechaini'] = $fechaini;
        $data['fechafin'] = $fechafin;
        $data['gestiones'] = $this->OperativoModel->getGestionesInforme($fechaini, $fechafin, $data['session']['proyecto_activo']);

        $this->utilidades->saveEvent("Genera informe BBVA", $data['session']['id'], $data['session']['proyecto_activo']);

        $this->load->view('operativo/generabbva', $data);
    }

    public function importarasignacion() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/cargaAsignacion', $data);
        $this->load->view('templates/footer', $data);
    }

    public function resumenasignacion() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $data['asignacion'] = $this->OperativoModel->getasignaciontable($data['session']['proyecto_activo']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/resumenasignacion', $data);
        $this->load->view('templates/footer', $data);
    }

    public function uploadasignacion() {

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
                    $user = $datos[1];
                    $usua = $this->utilidades->cleanText($user);
                    $idU = $this->OperativoModel->getusuario($usua);


                    $this->OperativoModel->markasignacion($doc, $idU[0]['idUsuario'], $data['session']['proyecto_activo']);
                }
                fclose($archivo);

//unlink($filesname);
            }
        }


        $this->utilidades->saveEvent("carga Asignacion BBVA", $data['session']['id'], $data['session']['proyecto_activo']);

        echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/resumen-asignacion/" . $data['session']['proyecto_activo'] . "';</script>";
    }

    public function cargartablasbcsc() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/bcsc/cargartablas', $data);
        $this->load->view('templates/footer', $data);
    }


    public function cargartablaspromotora() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/bcsc/cargartablas_promotora', $data);
        $this->load->view('templates/footer', $data);
    }

    public function uploadtablas() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $ruta = '/var/www/html/puntualmentecomco/modulo_cobranzas/front/files/actualizacion/';
        $i = 83;
        //print_r($_FILES['tablas']);


        for ($x = 0; $x <= $i; $x++) {
            $fichero_subido = $ruta . basename($_FILES['tablas']['name'][$x]);
            if (move_uploaded_file($_FILES['tablas']['tmp_name'][$x], $fichero_subido)) {
                echo "El fichero es válido y se subió con éxito.\n";
            } else {
                echo "¡Posible ataque de subida de ficheros!\n";
            }
        }

        echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/executebasebcsc/" . $data['session']['proyecto_activo'] . "';</script>";
    }

    public function uploadtablas_promotora() {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $ruta = '/var/www/html/puntualmentecomco/modulo_cobranzas/front/files/actualizacion/';
        $i = 0;
        //print_r($_FILES['tablas']);


        for ($x = 0; $x <= $i; $x++) {
            $fichero_subido = $ruta . basename($_FILES['tablas']['name'][$x]);
            if (move_uploaded_file($_FILES['tablas']['tmp_name'][$x], $fichero_subido)) {
                echo "El fichero es válido y se subió con éxito.\n";
            } else {
                echo "¡Posible ataque de subida de ficheros!\n";
            }
        }

        echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/executebasepic/" . $data['session']['proyecto_activo'] . "';</script>";
    }














    public function informeprodc($slug) {

        $this->session->valida();
        $data['session'] = $this->session->getSessionData();
        if ($slug == "h") {
            $data['hoy'] = date("Y-m-d");
        } else {
            $fec = $this->input->post('fechaIni');
            //echo $fec;
            $fec2 = explode("/", $fec);
            $data['hoy'] = $fec2[2] . "-" . $fec2[0] . "-" . $fec2[1];
        }
        $data['usuariosPr'] = $this->OperativoModel->getUserPr($data['session']['proyecto']);
        $data['productividad'] = $this->OperativoModel->getProductividadHoy($data['hoy'], $data['session']['proyecto_activo']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('operativo/informepr', $data);
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
