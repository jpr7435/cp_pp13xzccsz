<?php

class Operativo extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->model('OperativoModel');
    $this->load->library('session');
    $this->load->library('utilidades');
  }

  public function restarFechas($fechaAntigua, $hoy) {

    $segundos = strtotime($hoy) - strtotime($fechaAntigua);
    $diferencia = intval($segundos / 60 / 60 / 24);

    return $diferencia;
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

  public function cargaPredictivo() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();
    $this->session->validaPerfilCoordinador($data['session']['perfil']);




    $data['proyectos'] = $this->OperativoModel->permisosespeciales($data['session']['id']);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('operativo/fechaPredictivo', $data);
    $this->load->view('templates/footer', $data);
  }

  public function uploadPredictivo() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();
    $this->session->validaPerfilCoordinador($data['session']['perfil']);

    $prefechaini = explode("/", $this->input->post("fechaIni"));
    $prefechafin = explode("/", $this->input->post("fechaFin"));

    $fechaini = $prefechaini[2] . "-" . $prefechaini[0] . "-" . $prefechaini[1];
    $fechafin = $prefechafin[2] . "-" . $prefechafin[0] . "-" . $prefechafin[1];


    //*Selecciona Gestion del Predictivo//**

    $this->OperativoModel->borraPredictivo($data['session']['proyecto_activo']);



    $predictivo = $this->OperativoModel->cargaPredictivo($fechaini,$fechafin);

    //*Carga Gestion Tabla gesttion_predictivo//**

    foreach($predictivo as $pr){
      $this->OperativoModel->guardaPredictivo($pr['id_call'],$pr['value'],$pr['phone'],$pr['status'],$pr['fecha_llamada']);
    }


    $predictivo2 = $this->OperativoModel->insertaPredictivo();

    foreach($predictivo2 as $pr2){

      $hora = date("H", strtotime($pr2['fecha_llamada']));
      $fecha2 = date("Y-m-d", strtotime($pr2['fecha_llamada']));

      $fechasola = explode(" ", $pr2['fecha_llamada']);

      $this->OperativoModel->insertaPreCallh($pr2['documento'],$pr2['telefono'],$pr2['fecha_llamada'],$hora,$fecha2,$pr2['idLlamada']);


      $this->OperativoModel->updateultimapred($pr2['documento'], $fechasola[0]);
      

    }



    echo "<script>location.href='https://consulegalab.com/modulo_cobranzas/index.php/dashboard/bbva'</script>";
  }




  public function generainformePre() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();


    $prefechaini = explode("/", $this->input->post("fechaIni"));
    $prefechafin = explode("/", $this->input->post("fechaFin"));

    $fechaini = $prefechaini[2] . "-" . $prefechaini[0] . "-" . $prefechaini[1];
    $fechafin = $prefechafin[2] . "-" . $prefechafin[0] . "-" . $prefechafin[1];

    $data['fechaini'] = $fechaini;
    $data['fechafin'] = $fechafin;
    $data['llamadas'] = $this->OperativoModel->cargaPredictivo($fechaini, $fechafin, $data['session']['proyecto_activo']);


    $this->load->view('operativo/fechaPredictivo', $data);
  }



  public function importaractualizacion($slug) {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('operativo/importaractualizacion', $data);
    $this->load->view('templates/footer', $data);
  }

  public function importarevolutivo($slug) {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('operativo/importarevolutivo', $data);
    $this->load->view('templates/footer', $data);
  }



  public function importarasignacionini($slug) {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('operativo/importarasignacionini', $data);
    $this->load->view('templates/footer', $data);
  }

  public function uploadevolutivo() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();





    $mi_archivo = 'file';
    $config['upload_path'] = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/";
    $config['file_name'] = "evolutivo";
    $config['allowed_types'] = "*";
    $config['max_size'] = "150000";

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload($mi_archivo)) {
      //*** ocurrio un error
      $data['uploadError'] = $this->upload->display_errors();

      echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
      echo "<script>location.href='http://]" . $_SERVER['HTTP_HOST'] . "/index.php/importarevolutivo/" . $data['session']['proyecto_activo'] . "'</script>";
      return;
    } else {
      //$data['uploadSuccess'] = $this->upload->data();
      $this->utilidades->saveEvent("carga tarea", $data['session']['id'], $data['session']['proyecto_activo']);
      $datas = array('upload_data' => $this->upload->data());
      $fila = 1;

      $filesname = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $datas['upload_data']['file_name'];

      $this->OperativoModel->borraEvolutivo($data['session']['proyecto_activo']);

      $this->OperativoModel->loadArchivo($filesname, $data['session']['proyecto_activo']);

      $this->OperativoModel->encriptarEvolutivo($data['session']['proyecto_activo']);

    }


    $this->utilidades->saveEvent("carga Evolutivo BBVA", $data['session']['id'], $data['session']['proyecto_activo']);

    echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/resumen-asignacion/" . $data['session']['proyecto_activo'] . "';</script>";
  }


  public function uploadasignacionini() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();





    $mi_archivo = 'file';
    $config['upload_path'] = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/";
    $config['file_name'] = "asignacion";
    $config['allowed_types'] = "*";
    $config['max_size'] = "150000";

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload($mi_archivo)) {
      //*** ocurrio un error
      $data['uploadError'] = $this->upload->display_errors();

      echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
      echo "<script>location.href='http://]" . $_SERVER['HTTP_HOST'] . "/index.php/importarevolutivo/" . $data['session']['proyecto_activo'] . "'</script>";
      return;
    } else {
      //$data['uploadSuccess'] = $this->upload->data();
      $this->utilidades->saveEvent("carga asignacion ini", $data['session']['id'], $data['session']['proyecto_activo']);
      $datas = array('upload_data' => $this->upload->data());
      $fila = 1;

      $filesname = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $datas['upload_data']['file_name'];

      $this->OperativoModel->borraAsignacion($data['session']['proyecto_activo']);

      $this->OperativoModel->loadArchivoAsignacion($filesname, $data['session']['proyecto_activo']);

      $this->OperativoModel->encriptarAsignaccion($data['session']['proyecto_activo']);

    }


    $this->utilidades->saveEvent("carga Asignacion Inicial BBVA", $data['session']['id'], $data['session']['proyecto_activo']);

    //echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/resumen-asignacion/" . $data['session']['proyecto_activo'] . "';</script>";
  }





  public function uploadevolutivoAnterior() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();


    $this->OperativoModel->borraEvolutivo($data['session']['proyecto_activo']);


    $mi_archivo = 'file';
    $config['upload_path'] = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/";
    $config['file_name'] = "evolutivo";
    $config['allowed_types'] = "*";
    $config['max_size'] = "150000";

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload($mi_archivo)) {
      //*** ocurrio un error
      $data['uploadError'] = $this->upload->display_errors();

      echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
      echo "<script>location.href='http://]" . $_SERVER['HTTP_HOST'] . "/index.php/importarevolutivo/" . $data['session']['proyecto_activo'] . "'</script>";
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

          $tipo_documento = $datos[0];
          $identificacion = $datos[1];
          $nombre = $datos[2];
          $territorial_mayor = $datos[3];
          $zona_mayor = $datos[4];
          $centro_mayor = $datos[5];
          $departamento_mayor = $datos[6];
          $banca = $datos[7];
          $calificacion = $datos[8];
          $califica7 = $datos[9];
          $cal_subjet = $datos[10];
          $tipologia_gestion_cli = $datos[11];
          $alternativa_normalizacion = $datos[12];
          $tipo_reparto = $datos[13];
          $tipo_cobro = $datos[14];
          $tipo_judicial = $datos[15];
          $tipo_judicial_actual = $datos[16];
          $refis_cliente = $datos[17];
          $marca_1 = $datos[18];
          $tipo_franja = $datos[19];
          $franja_gestion = $datos[20];
          $dias_pareto = $datos[21];
          $capital_pareto = $datos[22];
          $cap_pareto_act = $datos[23];
          $cap_pareto_tp_car = $datos[24];
          $capital_vigente_afectado = $datos[25];
          $marca_vip = $datos[26];
          $cons_prod2 = $datos[27];
          $obligacion = $datos[28];
          $fecha_formalizacion = $datos[29];
          $fecha_final = $datos[30];
          $porc_max_condona = $datos[31];
          $valor_desembolso = $datos[32];
          $plazo = $datos[33];
          $tasa_ea = $datos[34];
          $producto = $datos[35];
          $tipo_cartera = $datos[36];
          $tipo_producto = $datos[37];
          $subproducto = $datos[38];
          $linea_producto = $datos[39];
          $linea_producto_c = $datos[40];
          $linea_subproducto = $datos[41];
          $marca_refis = $datos[42];
          $normalizacion = $datos[43];
          $marca = $datos[44];
          $fecha_mora = $datos[45];
          $dias_vencidos = $datos[46];
          $franja_obligacion = $datos[47];
          $estado_inicial_objetivo = $datos[48];
          $valor_mora = $datos[49];
          $capital_activo = $datos[50];
          $saldo_total = $datos[51];
          $reest_particulares = $datos[52];
          $reestructurados_comercial = $datos[53];
          $reestructurados_leasing = $datos[54];
          $rediferidos = $datos[55];
          $congelada = $datos[56];
          $provision_capital = $datos[57];
          $provision_interes = $datos[58];
          $total_intereses = $datos[59];
          $intereses_contg = $datos[60];
          $cxc_tdc = $datos[61];
          $tipo_libranza = $datos[62];
          $cod_em = $datos[63];
          $convenio = $datos[64];
          $segmento_lbz = $datos[65];
          $indicador_actual = $datos[66];
          $causal_no_descuento = $datos[67];
          $cuota_ini = $datos[68];
          $cuota_actual = $datos[69];
          $porcentaje = $datos[70];
          $guion_libranza = $datos[71];
          $cuotas_en_corr = $datos[72];
          $cuotas_a_corr = $datos[73];
          $efectiva_nueva = $datos[74];
          $plazo_ini = $datos[75];
          $plazo_res = $datos[76];
          $plazo_trans = $datos[77];
          $plazo_requerido = $datos[78];
          $plazo_total = $datos[79];
          $t_cuotas_corr = $datos[80];
          $alternativa_norm = $datos[81];
          $etapa_procesal = $datos[82];
          $abogado_externo = $datos[83];
          $detalle_tipo_judicial = $datos[84];
          $macro_etapa_matriz = $datos[85];
          $situacion_gestion = $datos[86];
          $capitala = $datos[87];
          $valormor = $datos[88];
          $diasven = $datos[89];
          $estado = $datos[90];
          $dias_actuales = $datos[91];
          $franja_obligacion_saneamiento = $datos[92];
          $estado_actual_objetivo = $datos[93];
          $estado_cartera = $datos[94];
          $estado_evaluacion = $datos[95];
          $evaluacion_actual_estado = $datos[96];
          $prioridad_mes = $datos[97];
          $fecha_vto_actual = $datos[98];
          $dia_vto = $datos[99];
          $franja_obligacion_actual = $datos[100];
          $franja_riesgo = $datos[101];
          $proximo_a_vencer = $datos[102];
          $tipo_gestor = $datos[103];
          $gestor = $datos[104];
          $responsable = $datos[105];
          $codigo_exclusion = $datos[106];
          $codigo_estrategia = $datos[107];
          $estrategia_comercial = $datos[108];
          $forzaje = $datos[109];
          $estado_gest = $datos[110];
          $gestion = $datos[111];
          $efectividad_gestion = $datos[112];
          $actividad_principal = $datos[113];
          $fecha_actividad_principal = $datos[114];
          $n_actividades = $datos[115];
          $resultado_contacto = $datos[116];
          $motivo_no_pago = $datos[117];
          $mecanismo_norm = $datos[118];
          $etapa_norm = $datos[119];
          $ultima_actividad = $datos[120];
          $fecha_compromiso_pago = $datos[121];
          $fecha_ult_actividad = $datos[122];
          $texto_gestion = $datos[123];
          $fecha_venc_pdp = $datos[124];
          $detalle_gestor = $datos[125];
          $detalle_marca = $datos[126];
          $detalle_responsable = $datos[127];
          $detalle_tipo_gestor = $datos[128];
          $tipo_garantia = $datos[129];
          $tipo_activo = $datos[130];
          $marca_garantia = $datos[131];
          $max_cal_gtia = $datos[132];
          $estado_gtia_fondos = $datos[133];
          $porcentaje_fng = $datos[134];
          $indicativo = $datos[135];
          $telefono_ubicacion1 = $datos[136];
          $fecha_asignacion = $datos[137];
          $centro_gestor = $datos[138];
          $nombre_centro_gestor = $datos[139];
          $tipo_reparto_1 = $datos[140];
          $territorial = $datos[141];
          $probabilidad_pago = $datos[142];
          $probabilidad_pago_py = $datos[143];
          $puntaje_sector = $datos[144];
          $tipo_persona = $datos[145];
          $segmento_ii = $datos[146];
          $segmentacion_asignacion = $datos[147];
          $semana = $datos[148];
          $castigos = $datos[149];
          $tipo_attrition = $datos[150];
          $grupo = $datos[151];
          $waste_management = $datos[152];
          $contactabilidad = $datos[153];
          $c_collection_score = $datos[154];
          $estado_cuenta = $datos[155];
          $entidad_embargo = $datos[156];
          $seguro_desempleo = $datos[157];
          $numero_poliza = $datos[158];
          $cliente_fallecido = $datos[159];
          $estado_reclamacion = $datos[160];
          $base_ifrs9 = $datos[161];
          $saldo_activo_ifrs9 = $datos[162];
          $provision_total_ifrs9 = $datos[163];
          $provision_faltante_ifrs9 = $datos[164];
          $stage_final_ifrs9 = $datos[165];
          $campaña = $datos[166];
          $franja_obligacion_mia = $datos[167];
          $franja_obligacion_actual_mia = $datos[168];
          $indicador_mia = $datos[169];
          $estado_aplicación_alivio = $datos[170];
          $fecha_solicitud_alivio = $datos[171];
          $contactado = $datos[172];
          $acepta_alivio = $datos[173];
          $gestor_alivio = $datos[174];
          $plazo_gracia = $datos[175];
          $status_aplicacion = $datos[176];
          $cliente_con_linea_comercial = $datos[177];
          $segmento_circular_007 = $datos[178];
          $linea_problema = $datos[179];
          $ofertable_alivio = $datos[180];
          $fecha_final_alivio = $datos[181];
          $segmento_emerge = $datos[182];
          $prioridad_gestion_emerge = $datos[183];
          $motivo_gestion_emerge = $datos[184];
          $foco_gestion = $datos[185];
          $fecha_max_contacto = $datos[186];
          $celular_cir_022 = $datos[187];
          $correo_electronico_022 = $datos[188];
          $estado_contacto_pad = $datos[189];
          $estado_aplicacion_red = $datos[190];
          $fecha_aplicacion = $datos[191];
          $franja_gestion_actual = $datos[192];
          $meses_vencidos = $datos[193];
          $valor_primer_recibo = $datos[194];


          $fecha_actual = date("Y-m-d");
          $fecha = date("Y-m-d",strtotime($fecha_actual."- 1 days"));

          $this->OperativoModel->uploadEvolutivo($tipo_documento,	$identificacion,	$nombre,	$territorial_mayor,	$zona_mayor,	$centro_mayor,	$departamento_mayor,	$banca,	$calificacion,	$califica7,	$cal_subjet,	$tipologia_gestion_cli,	$alternativa_normalizacion,	$tipo_reparto,	$tipo_cobro,	$tipo_judicial,	$tipo_judicial_actual,	$refis_cliente,	$marca_1,	$tipo_franja,	$franja_gestion,	$dias_pareto,	$capital_pareto,
          	$cap_pareto_act,	$cap_pareto_tp_car,	$capital_vigente_afectado,	$marca_vip,	$cons_prod2,	$obligacion,	$fecha_formalizacion,	$fecha_final,	$porc_max_condona,	$valor_desembolso,	$plazo,	$tasa_ea,	$producto,	$tipo_cartera,	$tipo_producto,	$subproducto,	$linea_producto,	$linea_producto_c,	$linea_subproducto,	$marca_refis,	$normalizacion,	$marca,	$fecha_mora,	$dias_vencidos,	$franja_obligacion,
            $estado_inicial_objetivo,	$valor_mora,	$capital_activo,	$saldo_total,	$reest_particulares,	$reestructurados_comercial,	$reestructurados_leasing,	$rediferidos,	$congelada,	$provision_capital,	$provision_interes,	$total_intereses,	$intereses_contg,	$cxc_tdc,	$tipo_libranza,	$cod_em,	$convenio,	$segmento_lbz,	$indicador_actual,	$causal_no_descuento,	$cuota_ini,	$cuota_actual,	$porcentaje,	$guion_libranza,	$cuotas_en_corr,
            $cuotas_a_corr,	$efectiva_nueva,	$plazo_ini,	$plazo_res,	$plazo_trans,	$plazo_requerido,	$plazo_total,	$t_cuotas_corr,	$alternativa_norm,	$etapa_procesal,	$abogado_externo,	$detalle_tipo_judicial,	$macro_etapa_matriz,	$situacion_gestion,	$capitala,	$valormor,	$diasven,	$estado,	$dias_actuales,	$franja_obligacion_saneamiento,	$estado_actual_objetivo,	$estado_cartera,	$estado_evaluacion,	$evaluacion_actual_estado,	$prioridad_mes,
            $fecha_vto_actual,	$dia_vto,	$franja_obligacion_actual,	$franja_riesgo,	$proximo_a_vencer,	$tipo_gestor,	$gestor,	$responsable,	$codigo_exclusion,	$codigo_estrategia,	$estrategia_comercial,	$forzaje,	$estado_gest,	$gestion,	$efectividad_gestion,	$actividad_principal,	$fecha_actividad_principal,	$n_actividades,	$resultado_contacto,	$motivo_no_pago,	$mecanismo_norm,	$etapa_norm,	$ultima_actividad,	$fecha_compromiso_pago,	$fecha_ult_actividad,
            $texto_gestion,	$fecha_venc_pdp,	$detalle_gestor,	$detalle_marca,	$detalle_responsable,	$detalle_tipo_gestor,	$tipo_garantia,	$tipo_activo,	$marca_garantia,	$max_cal_gtia,	$estado_gtia_fondos,	$porcentaje_fng,	$indicativo,	$telefono_ubicacion1,	$fecha_asignacion,	$centro_gestor,	$nombre_centro_gestor,	$tipo_reparto_1,	$territorial,	$probabilidad_pago,	$probabilidad_pago_py,	$puntaje_sector,	$tipo_persona,	$segmento_ii,	$segmentacion_asignacion,
            $semana,	$castigos,	$tipo_attrition,	$grupo,	$waste_management,	$contactabilidad,	$c_collection_score,	$estado_cuenta,	$entidad_embargo,	$seguro_desempleo,	$numero_poliza,	$cliente_fallecido,	$estado_reclamacion,	$base_ifrs9,	$saldo_activo_ifrs9,	$provision_total_ifrs9,	$provision_faltante_ifrs9, $stage_final_ifrs9, $campaña,	$franja_obligacion_mia,	$franja_obligacion_actual_mia,	$indicador_mia,	$estado_aplicación_alivio,	$fecha_solicitud_alivio,	$contactado,
            $acepta_alivio, $gestor_alivio,	$plazo_gracia,	$status_aplicacion,	$cliente_con_linea_comercial,	$segmento_circular_007,	$linea_problema,	$ofertable_alivio,	$fecha_final_alivio,	$segmento_emerge,	$prioridad_gestion_emerge,	$motivo_gestion_emerge,	$foco_gestion,	$fecha_max_contacto,	$celular_cir_022,	$correo_electronico_022,	$estado_contacto_pad,	$estado_aplicacion_red,	$fecha_aplicacion,	$franja_gestion_actual,	$meses_vencidos, $valor_primer_recibo, $fecha, $data['session']['proyecto_activo']);
        }
        fclose($archivo);
        unlink($filesname);
      }
    }


    $this->utilidades->saveEvent("carga Evolutivo BBVA", $data['session']['id'], $data['session']['proyecto_activo']);

    //echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/resumen-asignacion/" . $data['session']['proyecto_activo'] . "';</script>";
  }




  /*public function uploadactualizacion() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $mi_archivo = 'file';
  $config['upload_path'] = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/";
  $config['file_name'] = "tarea";
  $config['allowed_types'] = "*";
  $config['max_size'] = "150000";

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

if($data['session']['proyecto_activo'] == 'bbva'){
while (($datos = fgetcsv($archivo, 5000, "\t")) !== FALSE) {
$numero = count($datos);

$oh = $datos[28];
$diasven = $datos[89];
$vlmora = str_replace(",", ".", $datos[88]);
$estado = $datos[90];
$franja = $datos[92];

$fecha_actual = date("Y-m-d");
$fecha = date("Y-m-d",strtotime($fecha_actual."- 1 days"));

$this->OperativoModel->updateActualizacion($oh, $diasven, $vlmora, $estado, $franja, $fecha, $data['session']['proyecto_activo']);
}
}else if($data['session']['proyecto_activo'] == 'credivalores_pre'){
$this->OperativoModel->unactivateClientes($data['session']['proyecto_activo']);
while (($datos = fgetcsv($archivo, 5000, "\t")) !== FALSE) {
$numero = count($datos);
echo $numero;
die();
$oh = $datos[28];

$diasven = $datos[89];
$vlmora = str_replace(",", ".", $datos[88]);
$estado = $datos[90];
$franja = $datos[92];

$fecha_actual = date("Y-m-d");
$fecha = date("Y-m-d",strtotime($fecha_actual."- 1 days"));

$this->OperativoModel->updateActualizacion($oh, $diasven, $vlmora, $estado, $franja, $fecha, $data['session']['proyecto_activo']);
}

}

fclose($archivo);
//die();
//unlink($filesname);
}
}


$this->utilidades->saveEvent("carga Asignacion BBVA", $data['session']['id'], $data['session']['proyecto_activo']);

echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/resumen-asignacion/" . $data['session']['proyecto_activo'] . "';</script>";
}*/



public function uploadactualizacion() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $mi_archivo = 'file';
  $config['upload_path'] = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/";
  $config['file_name'] = "baseActualizacion";
  $config['allowed_types'] = "*";
  $config['max_size'] = "150000";

  $this->load->library('upload', $config);

  if (!$this->upload->do_upload($mi_archivo)) {
    //*** ocurrio un error
    $data['uploadError'] = $this->upload->display_errors();

    echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
    echo "<script>location.href='http://]" . $_SERVER['HTTP_HOST'] . "/index.php/importarinicial/" . $data['session']['proyecto_activo'] . "'</script>";
    return;
  } else {
    //$data['uploadSuccess'] = $this->upload->data();
    $this->utilidades->saveEvent("cargue base actualizacion", $data['session']['id'], $data['session']['proyecto_activo']);
    $datas = array('upload_data' => $this->upload->data());
    $fila = 1;

    $filesname = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $datas['upload_data']['file_name'];
    if (($archivo = fopen("/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $datas['upload_data']['file_name'], "r")) !== false) {

      if($data['session']['proyecto_activo'] == "bbva"){
        while (($datos = fgetcsv($archivo, 5000, ";")) !== FALSE) {
          $numero = count($datos);

          $campos = $datos;
          break;
        }
      }else if($data['session']['proyecto_activo'] == "credivalores"){
        while (($datos = fgetcsv($archivo, 5000, "\t")) !== FALSE) {
          $numero = count($datos);

          $campos = $datos;
          break;
        }
      }else if($data['session']['proyecto_activo'] == "credivalores_pre"){
        while (($datos = fgetcsv($archivo, 5000, "\t")) !== FALSE) {
          $numero = count($datos);

          $campos = $datos;
          break;
        }
      }else{
        while (($datos = fgetcsv($archivo, 5000, ";")) !== FALSE) {
          $numero = count($datos);

          $campos = $datos;
          break;
        }
      }

      fclose($archivo);
      unlink($archivo);
    }
  }


  $data['archivo'] = $datas['upload_data']['file_name'];
  $data['campos'] = $campos;
  /*if($data['session']['proyecto_activo'] == "bbva"){
    $data['creditos'] = $this->OperativoModel->getTablaEvolutivo($data['session']['proyecto_activo']);
  }else{
    $data['creditos'] = $this->OperativoModel->getTablaCreditos($data['session']['proyecto_activo']);
  }*/

  $data['creditos'] = $this->OperativoModel->getTablaCreditos($data['session']['proyecto_activo']);

  $this->load->view('templates/header', $data);
  $this->load->view('templates/sidebar', $data);
  $this->load->view('operativo/upactualizacion', $data);
  $this->load->view('templates/footer', $data);
}

public function uploadbaseinicial() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $mi_archivo = 'file';
  $config['upload_path'] = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/";
  $config['file_name'] = "baseInicial";
  $config['allowed_types'] = "*";
  $config['max_size'] = "150000";

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




public function setpausa()
    {
        $this->session->valida();
        $data['session'] = $this->session->getSessionData();

        $this->load->helper('cookie');
        $pausa = $this->input->post('tareas');

        $cookie4 = [
            'name' => 'bloqueo',
            'value' => '1',
            'expire' => '86500',
            'domain' => '.consulegalab.com',
            'path' => '/',
            'prefix' => '',
            'secure' => false,
        ];

        $this->input->set_cookie($cookie4);

        $cookie5 = [
            'name' => 'pausa',
            'value' => $pausa,
            'expire' => '86500',
            'domain' => '.consulegalab.com',
            'path' => '/',
            'prefix' => '',
            'secure' => false,
        ];

        $this->input->set_cookie($cookie5);

        $this->utilidades->saveEventPausa(
            'Inicio de Pausa',
            $data['session']['id'],
            $data['session']['usuario'],
            $pausa,
            '1'
        );
    }

public function executebaseinicial() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $fecha = date("Y-m-d");

  $this->OperativoModel->unactivateClientes($data['session']['proyecto_activo']);
  $this->OperativoModel->borraCreditos($data['session']['proyecto_activo']);
  $key = $this->OperativoModel->getKey();
  $archivo = $this->input->post('archivos');


  $fila = 1;

  $file = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $archivo;

  if (($archivo = fopen("/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $archivo, "r")) !== false) {

    while (($datos = fgetcsv($archivo, 500000, ";")) !== FALSE) {
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
        $consultaCreditos .= ",fechacargue, activo, fechaActualizacion, estadoActual, equipo) values (";


        
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

        $consultaCreditos .= ",'$fecha', '1', '$fecha', 'MORA', '00_Equipo_Cosecha_Mes') on duplicate key update activo = '1';";

        //echo $consultaCreditos;


       

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
    fclose($archivo);

    unlink($file);
    $this->utilidades->saveEvent("procesa base inicial", $data['session']['id'], $data['session']['proyecto_activo']);
  }

  $this->OperativoModel->setNovaciones($data['session']['proyecto_activo']);
  $data['clientes'] = $this->OperativoModel->getNumClientes($data['session']['proyecto_activo']);
  $data['cuentas'] = $this->OperativoModel->getNumCreditos($data['session']['proyecto_activo']);


  $this->load->view('templates/header', $data);
  $this->load->view('templates/sidebar', $data);
  $this->load->view('operativo/resumentablas', $data);
  $this->load->view('templates/footer', $data);
}


public function executeactualizacion() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $fecha = date("Y-m-d");

  //$this->OperativoModel->unactivateClientes($data['session']['proyecto_activo']);
  //$this->OperativoModel->borraCreditos($data['session']['proyecto_activo']);
  $key = $this->OperativoModel->getKey();
  $archivo = $this->input->post('archivos');

  $fila = 1;

  $file = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $archivo;

  if (($archivo = fopen("/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $archivo, "r")) !== false) {

    /*if($data['session']['proyecto_activo'] == "bbva"){
      $sep = "\t";
    }else{
      $sep = ";";
    }*/
    $sep = ";";
    while (($datos = fgetcsv($archivo, 500000, $sep)) !== FALSE) {
      $numero = count($datos);

      $valormors = "";
      $diasven = "";
      $estado = "";
      $franja = "";

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

            /*$oh = $datos[28];
            $diasven = $datos[89];
            $vlmora = str_replace(",", ".", $datos[88]);
            $estado = $datos[90];
            $franja = $datos[92];*/

            if ($clave == "diasven") {
              $diasven = $datos[$valor];
            }

            if ($clave == "valormor") {
              $valormors = str_replace(",", ".",$datos[$valor]);
            }

            if ($clave == "estado") {
              $estado = $datos[$valor];
            }

            if ($clave == "franja_obligacion_saneamiento") {
              $franja = $datos[$valor];
            }


          }
        }

        if ($data['session']['proyecto_activo'] == "bbva2") {
          $fecha_actual = date("Y-m-d");
          $fecha = date("Y-m-d",strtotime($fecha_actual."- 1 days"));
          //$actualizar = ", dias_mora_actual = '" . $diasven . "', valor_mora_actual = '". $valormors . "', estado_evolutivo = '". $estado . "', franja_obligacion_actual = '". $franja ."', fechaevolutivo2 = '". $fecha ."'";
          $actualizar = ",  fechaevolutivo2 = '". $fecha ."'";
        } else {
          $actualizar = "";
        }

        $consultaCreditos = substr($consultaCreditos, 0, -1);

        $consultaCreditos .= ",'$fecha', '1', '$fecha', 'MORA') on duplicate key update  activo = '1' " . $actualizar . ";";

        echo $consultaCreditos."</br>";
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
    $this->utilidades->saveEvent("procesa Actualizacion ", $data['session']['id'], $data['session']['proyecto_activo']);
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

public function generarcuotasacuerdo() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $valor = $this->input->post('valor');
  $fec = $this->input->post('fecha');
  $cuotas = $this->input->post('cuota');
  $obl = $this->input->post('obl');
  $piso = $this->input->post('piso');
  $judicial = $this->input->post('judi');
  $saldototal = $this->input->post('saldototal');
  $tarifa = $this->input->post('idtarifa');
  $proba = $this->input->post('prob');
  $hoy = date("Y-m-d");

  $abogados = $this->OperativoModel->getabogados($data['session']['proyecto_activo']);
  $honorarios = $this->OperativoModel->gethonorarios($data['session']['proyecto_activo']);

  $cuotaSola = $valor/$cuotas;
  $html = '<script src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/lib/js/core/acuerdo.js"></script> ';
  $dias = 31;
  $nuevaFecha = $fec;
  for($i = 1; $i <= $cuotas; $i++){

    $html .= '
    <div class="form-group col-sm-2">
    <label>Couta:</label>
    <input type="text" class="form-control" id="cuotaModal'.$i.'" name="cuotaModal'.$i.'" value="'.$i.'" />
    </div>
    <div class="form-group col-sm-5">
    <label>Fecha:</label>
    <input type="date" class="form-control" id="fechaModal'.$i.'" name="fechaModal'.$i.'" min="'.date('Y-m-d').'"  value="'.$nuevaFecha.'" />
    </div>
    <div class="form-group col-sm-5">
    <label>Valor Cuota:</label>
    <input type="text" class="form-control" id="valorModal'.$i.'" name="valorModal'.$i.'" value="'.ceil($cuotaSola).'" />
    </div>';

    $dias2 = $dias * $i;

    $nuevaFecha = date("Y-m-d",strtotime($nuevaFecha."+ 30 days"));
    $semana = date($nuevaFecha);
    $dia = date('N', strtotime($semana));
    if($dia == 6){
      $nuevaFecha = date("Y-m-d",strtotime($nuevaFecha."- 1 days"));
    }elseif($dia == 7){
      $nuevaFecha = date("Y-m-d",strtotime($nuevaFecha."- 2 days"));
    }
  }
  if($judicial == 1){
    $html .= '<div class="row">
    <div class="form-group col-sm-6">
    <label>Abogado:</label>
    <select name="cuenta-abogado" id="cuenta-abogado" class="form-control">
    <option value="0">Seleccione.....</option>';
    foreach($abogados as $ab){
      $html .= '<option value="'.$ab['nombre'].';'.$ab['tipodecuenta'].';'.$ab['numerodecuenta'].'">'.$ab['nombre'].'</option>';
    }
    $html .= '</select>
    </div>
    <div class="form-group col-sm-6">
    <label>Etapa Procesal:</label>
    <select name="honorarios" id="honorarios" class="form-control">
    <option value="0">Seleccione.....</option>';
    foreach($honorarios as $hn){
      $html .= '<option value="'.$hn['porcentajehonorarios'].';'.$hn['etapaprocesal'].'">'.$hn['etapaprocesal'].'</option>';
    }
    $html .= '</select>
    </div>
    </div>';
    
  }
  $html .= '<div class="row">
  <input type="hidden" name="vldescuentoAcuerdo" id="vldescuentoAcuerdo" value="'.$piso.'"/>
  <input type="hidden" name="vlsaldototal" id="vlsaldototal" value="'.$saldototal.'"/>
  <input type="hidden" name="ohcuotasacuerdo" id="ohcuotasacuerdo" value="'.$obl.'"/>
  <input type="hidden" name="esjudicialdos" id="esjudicialdos" value="'.$judicial.'"/>
  <input type="hidden" name="idtarifa" id="idtarifa" value="'.$tarifa.'"/>
  <input type="hidden" name="probafield" id="probafield" value="'.$proba.'"/>
  <button class="btn btn-success" id="generaAcuerdo">Guardar</button>
  </div>';
  echo $html;
}

public function generaracuerdo() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $valor = $this->input->post('valor');
  $fec = $this->input->post('fecha');
  $cuotas = $this->input->post('cuota');
  $docu = $this->input->post('docu');
  $correo = $this->input->post('correo');
  $cadena = $this->input->post('cadena');
  $abogado = $this->input->post('abo');
  $honorarios = $this->input->post('hono');
  $judicial = $this->input->post('judi');
  $idtarifa = $this->input->post('idtarifa');
  $proba = $this->input->post('prob');
  $oh = $this->input->post('obl');
  $hoy = date("Y-m-d");


  

  
  $tarifa = $this->OperativoModel->gettarifa($idtarifa, $data['session']['proyecto_activo']);
  $cliente = $this->OperativoModel->buscarxdoc($docu, $data['session']['proyecto_activo']);
  $aseso = $this->OperativoModel->getusuario($data['session']['usuario']);
  $ohdata = $this->OperativoModel->getOhTodas($oh, $data['session']['proyecto_activo']);
  $acuerdo = explode("|", $cadena);

  $tipodoc = $ohdata[0]['tipo_documento'];
  $capacti = $ohdata[0]['capitalactivo'];
  $totalint = $ohdata[0]['saldototal'] - $ohdata[0]['capitalactivo'] - $ohdata[0]['totalcxc']  - $ohdata[0]['interesescontg'];
  $totalcxc = $ohdata[0]['totalcxc'];
  $intconting = $ohdata[0]['interesescontg'];
  $tipopr = $ohdata[0]['tipoproducto'];
  $lineasub = $ohdata[0]['lineasubproducto'];
  $tipojudi = $ohdata[0]['tipojudicial'];
  $franja = $ohdata[0]['franja_obligacion_actual'];


  $vlhonocasa = 0;
  


  $completa = date("Y-m-d H:i:s");
  $hora = date("H");
  $this->OperativoModel->desactivaAcuerdo($oh, $data['session']['proyecto_activo']);
  for($x = 0; $x < $cuotas; $x++){
    $detal = explode(";", $acuerdo[$x]);
    if(!isset($ohdata[0]['zona_mayor'])){
      $ohdata[0]['zona_mayor'] = '';
      $ohdata[0]['territorial_mayor'] = '';
    }

    $base = $detal[2] / (1 + $tarifa[0]['tarifa']);
    $vlhonocasa = $detal[2] - $base;

    if($judicial == 1){
      $aboarray = explode(";", $abogado);
      $honoarray = explode(";", $honorarios);
      $honovl = ($base * $honoarray[0])/100;
      $cuentaarray = $aboarray[1]." ".$aboarray[2];
    }else{
      $aboarray[0] = 0;
      $cuentaarray = NULL;
      $honoarray[0] = 0;
      $honoarray[1] = 0;
      $honovl = 0;
    }

   

    $this->OperativoModel->saveAcuerdo(
      '',
      $oh,
      $docu,
      $data['session']['id'],
      $completa,
      $cuotas,
      $detal[1],
      $detal[2],
      $detal[0],
      $correo,
      $ohdata[0]['territorial_mayor'],
      $ohdata[0]['zona_mayor'],
      $ohdata[0]['responsable'],
      $ohdata[0]['capitalactivo'],
      $ohdata[0]['pisonegociacion'],
      $ohdata[0]['subproducto'],
      $ohdata[0]['tipocartera'],
      $cliente[0]['estrategia'],
      $tipodoc,
      $capacti,
      $totalint,
      $totalcxc,
      $intconting,
      $tipopr,
      $lineasub,
      $tipojudi,
      $franja,
      $aboarray[0],
      $cuentaarray,
      $honoarray[1],
      $honoarray[0],
      $honovl,
      $vlhonocasa,
      $base,
      $proba,
      $data['session']['proyecto_activo']);
  }

  $html = "";

  $this->OperativoModel->saveGestion($docu, $completa, $hora, "", '1', '1', '24', '5', $fec, $valor, '', 'Se realizo acuerdo de pago incluido en el MOCA', $data['session']['id'], '', $data['session']['proyecto_activo']);

  $html .= '<div class="alert alert-success alert-bordered">
  El acuerdo se ha agreado con exito <a href="javascript:window.location.href=window.location.href" class="alert-link"><strong>CERRAR...</strong></a>.
  </div>';

  echo $html;
}



public function generaracuerdopdf() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $this->load->library('Pdf');


  $docu = $this->input->post('docu');
  $correo = $this->input->post('correo');
  $ohs = $this->input->post('enviarPdfAcuerdo[]');
  $todas = "";
  foreach($ohs as $clave => $valor){
    $todas .= "'".$valor."',";
  }

  $todas = substr($todas, 0 ,-1);



  $hoy = date("Y-m-d");
  $fechaMostar = date("d/m/Y");

  $cliente = $this->OperativoModel->buscarxdoc($docu, "bbva");
  $direcciones = $this->OperativoModel->getDirecciones($docu, '1', "bbva");
  $telefonos = $this->OperativoModel->getTelefonos($docu, '1', "bbva");
  $ohTodas = $this->OperativoModel->buscarxobligIn($todas, "bbva");
  $ohAcuerdoTodas = $this->OperativoModel->buscarxobligInAcuerdos($todas, "bbva");
  $fechaAcuerdo = $this->OperativoModel->fechasAcuerdoAgrupadas($todas, "bbva");
  $productocl = $this->OperativoModel->getdiaspr($cliente[0]['grupoproductos'], 'bbva');
  $asesor = $this->OperativoModel->getusuarioId($ohAcuerdoTodas[0]['idasesor']);


  $multi = 0;
  $macfecha = "";
  $flag = 0;



  foreach($ohAcuerdoTodas as $acuall){
    if($acuall['cuotas'] > $flag){
      $multi += 1;
      $macfecha = $acuall['fechapago'];
      $flag = $acuall['cuotas'];
    }
    
  }

  if(!isset($direcciones[0]['direccion'])){
    $direcciones[0]['direccion'] = "";
    $direcciones[0]['idCiudad'] = "";
  }

  if(!isset($telefonos[0]['telefono'])){
    $telefonos[0]['telefono'] = "";
  }

  if(!isset($telefonos[1]['telefono'])){
    $telefonos[1]['telefono'] = "";
  }

  if(!isset($telefonos[2]['telefono'])){
    $telefonos[2]['telefono'] = "";
  }

  $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

  $pdf->SetTitle('Acuerdo de Pago');
  $pdf->SetAutoPageBreak(true);
  $pdf->SetAuthor('Consulegal AB BBVA');
  $pdf->SetDisplayMode('real', 'default');

  $fechasTabla = $this->OperativoModel->getAcuerdoFechaDocumento($cliente[0]['documento'], "bbva");
  $valTot = $this->OperativoModel->getAcuerdoValorTotal($cliente[0]['documento'], "bbva");
  $cuotasTotAc = count($fechasTabla);

  if(isset($productocl[0]['dias'])){
    $diaspaz = $productocl[0]['dias'];
  }else{
    $diaspaz = 36;
  }
  

  $resp = $this->OperativoModel->getResponsableNombre($ohTodas[0]['responsable'], "bbva");
  
  if(!isset($resp[0]['nombre_responsable'])){
    $resp[0]['nombre_responsable'] = "Sin Responsable"; 
  }

  $html0 ='<!DOCTYPE html>
          <html lang="es">
          <head>
            <meta charset="UTF-8">
            <title>Acuerdo de Pago</title>
        </head>
        <body style="border: 2px solid #000; font-size: 9px; margin: 5px auto;">
            <table style="width: 100%;">
              <tr>
                <td><img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/bbva.png" width="80" alt=""/></td>
                <td><p style="font-size: 10px;">ACUERDO DE PAGO - PAGO TOTAL</p></td>
                <td><img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/logoAB.png" width="80" alt=""/></td>
              </tr>
            </table>
            <p style="clear: both; height: 20px;"></p> 
            <table style="width: 100%;">
              <tr>
                  <td style="width: 50%; margin-top: 20px;"><span style="font-weight: bold;">Nombre completo:</span> '.$cliente[0]['nombre'].'</td>
                  <td style="width: 50%;"><span style="font-weight: bold;">En Calidad de:</span> Titular (X) Avalista () Codeudor () Demandado</td>
                </tr>
              </table>    
              <p style="clear: both; height: 20px;"></p> 
                <p style="font-size: 14px;">TÉRMINOS GENERALES DEL ACUERDO DE PAGO TOTAL </p>
              <hr>
                <h4 style="font-size: 11px; margin-top: 20px; margin-bottom: 20px;">1. CONDICIONES GENERALES</h4>
                <p style="font-size: 7px; text-align: justify;">1.1. EL DEUDOR efectuará los pagos a los créditos únicamente en las Sucursales de EL BANCO y dentro de los horarios autorizados. En consecuencia, los funcionarios de LA AGENCIA o los Abogados Externos no están facultados para recibir dineros,
                    salvo que se trate del pago de honorarios profesionales. En caso que EL DEUDOR excepcionalmente realice el pago de honorarios directamente a la AGENCIA y/o Abogado Externo, deberá exigir la expedición del correspondiente recibo por
                    ese concepto. 1.2. EL DEUDOR se obliga a entregar al día siguiente del pago copia de los recibos a la AGENCIA o al Funcionario de EL BANCO. 1.3. El presente Acuerdo de Pago no implica novación ni reestructuración de los contratos objeto
                    de esta negociación. 1.4. Si EL DEUDOR cuenta con otras obligaciones como titular, cotitular o codeudor, que presentan moras, contará con un plazo de cinco (5) días hábiles para la normalización y evitar que se genere el incumplimiento
                    del acuerdo. 1.5. EL DEUDOR acepta firmar nuevos pagarés cuando se realicen acuerdos sobre pago de la mora. 1.6. EL DEUDOR reconoce y acepta que las tarjetas de crédito y/o cupos rotativos que hagan parte del acuerdo, serán dadas de
                    baja, cancelando el contrato y el plástico. El uso de tarjetas de crédito y/o cupos rotativos, antes del proceso operativo que cancela y bloquea los productos, generará el incumplimiento del acuerdo. 1.7. EL DEUDOR autoriza a la AGENCIA
                    para ser contactado vía WhatsApp a los números de celulares confirmados en este acuerdo de pago a efectos realizar seguimiento y gestión de cobro. 1.8. Durante la vigencia del plan de pagos establecido en el presente compromiso, las
                    obligaciones podrán ser sujetas al castigo contable, con lo que ello implique. 1.9. El BANCO podrá recibir pagos fuera de los términos de plazo, monto y/o fechas acordadas dentro del presente Acuerdo de Pago Total. Sin embargo, esto
                    no podrá entenderse como la modificación a las condiciones aceptadas.
                </p>
                <h4 style="font-size: 11px; margin-top: 20px; margin-bottom: 20px;">2. CONSECUENCIAS EN EL INCUMPLIMIENTO EN EL ACUERDO</h4>
                <p style="font-size: 7px; text-align: justify;">2.1. El incumplimiento del acuerdo en las fechas, valores o cualquier otra condición establecida, ya sea de forma parcial o total, dejará sin valor ni efecto el acuerdo y faculta al BANCO para revocar automáticamente los beneficios y/o
                    descuentos negociados si hubiere lugar a ello. 2.2. En caso de incumplimiento los pagos realizados, serán aplicados como simples abonos y dará lugar a que EL BANCO inicie o impulse el proceso judicial, según corresponda, hasta lograr
                    el pago total de la deuda. De manera general la forma en que se aplique cada uno de los pagos, se indicará en los comprobantes de pago que expida y entregue EL BANCO.
                </p>
                <h4 style="font-size: 11px; margin-top: 20px; margin-bottom: 20px;">3. CONDICIONES SOBRE LAS GARANTÍAS FNG/FAG, HIPOTECARIAS, PRENDARIAS Y LEASING HABITACIONAL Y FINANCIERO.
                </h4>
                <p style="font-size: 7px; text-align: justify;">3.1. Los gastos y trámites de levantamiento de hipoteca o prenda, pago de parqueaderos o cualquier otra que se genere, serán asumidos por EL DEUDOR y/o propietario. 3.2. Es obligación del locatario, gestionar y radicar la documentación
                    necesaria para ejercer la opción de compra. Los valores que se generen de forma posterior al pago total del crédito, por cuenta de los gastos propios del bien como administración, impuestos y cualquier otra, serán trasladados al deudor,
                    de acuerdo con lo aceptado en el contrato de leasing. 3.3. Es obligación del locatario ejercer la opción de compra, de acuerdo a lo acordado dentro del contrato de Leasing, no hacerlo puede dar lugar a iniciar acciones legales con
                    los gastos y honorarios que ello genere. 3.4. Cuando la obligación cancelada, cuente con garantías FNG o FAG que hayan sido debidamente cobradas, EL DEUDOR tendrá la obligación de realizar acuerdo de pago con esas entidades. Los procesos
                    judiciales no podrán ser terminados, ni tampoco levantadas las medidas cautelares, hasta que exista aprobación y orden de esas entidades o de las que se subroguen a su nombre. 3.5. EL BANCO adelantará directamente las negociaciones
                    sobre las garantías pagadas por el FAG, con sus Agencias de Cobranza y Abogados Externos. EL DEUDOR realizará el pago en las cuentas y entidades financieras que el FAG determine y acepta el pago de honorarios y gastos de cobranza por
                    esa gestión.
                </p>
                <h4 style="font-size: 11px; margin-top: 20px; margin-bottom: 20px;">4. CONDICIONES SOBRE LOS PROCESOS JUDICIALES Y EJECUCIÓN DE PAGO DIRECTO</h4>
                <p style="font-size: 7px; text-align: justify;">4.1. Es a cargo de los demandados con posterioridad al cumplimiento del Acuerdo de pago total y la terminación del proceso, acercarse al juzgado de conocimiento a fin de obtener el oficio de desembargo y el desglose de los documentos -
                    pagaré y escritura pública de hipoteca o prenda. 4.2. Cuando sea necesario suspender el proceso judicial, se debe suscribir memorial de forma conjunta. Es a cargo de los demandados autenticar el memorial dirigido al Juez de conocimiento
                    y devolverlo al funcionario con el cual se celebró el acuerdo o al abogado externo que adelanta el proceso judicial. 4.3. El memorial será presentado al Juzgado una vez se cumpla con el _______ abono. Es de conocimiento de las partes
                    que la suspensión es autorizada por el Juez, de acuerdo a las etapas procesales y su criterio. 4.4. EL BANCO solicitará la terminación del proceso judicial siempre y cuando el acuerdo sea cumplido integralmente. 4.5. Si dentro de la
                    suspensión del proceso se llegara a cancelar la totalidad de las Obligaciones, se reconocerán honorarios de abogado sobre las sumas recibidas acorde al anexo tarifario. EL DEUDOR y/o demandados, interesados, reconocen y aceptan que
                    adeudan honorarios y/o gastos derivados de la gestión de cobranza y por ende acuerda pagarlos. Estos valores están debidamente incorporados en el presente Acuerdo de pago. 4.6. El proceso judicial no podrá ser suspendido en más de
                    2 oportunidades ni por más de 6 meses. 4.7. En caso de existir negociaciones con títulos judiciales las partes deberán firmar la solicitud de forma conjunta y estarán sujetos a los tiempos procesales, entendiendo que no corresponde
                    a gestiones propias de EL BANCO. 4.8. Cuando se trate de Procesos Ejecutivos en donde existan embargos sobre automotores, o Procesos de Ejecución de Pago Directo de Vehículos ante Confecamaras, EL DEUDOR conoce y acepta, que sólo podrá
                    poner en circulación el automotor, una vez la autoridad judicial haya expedido el oficio que cancela la medida cautelar y/o la orden de inmovilización, según corresponda. De no ser atendida esta condición, se podría dar lugar a gastos
                    adicionales por parqueaderos, grúas u otras, derivadas de una inmovilización que serán asumidas por el demandado.
                </p>
                <h4 style="font-size: 11px; margin-top: 20px; margin-bottom: 20px;">5. CONDICIONES SOBRE REPORTES ANTE CENTRALES DE RIESGO Y PAZ Y SALVO</h4>
                <p style="font-size: 7px; text-align: justify;">5.1. EL DEUDOR y sus apoderados, desisten y/o renuncian a ejercer o continuar toda acción o pretensión, llamamiento en garantía, queja o reclamo judicial o extrajudicial, administrativa, indemnización por actuación de parte civil dentro
                    de un proceso penal, y en general desisten y/o renuncian a toda reclamación de cualquier índole o naturaleza que pudiera entablar o hubiesen entablado por los hechos relacionados con sus créditos, o los que estuvieran indirectamente
                    relacionados con los fundamentos expuestos en los pleitos, declarando a paz y salvo por todo concepto al Grupo BBVA COLOMBIA S.A, a sus Apoderados Judiciales y Agencia de Cobranza. 5.2. El reporte ante centrales de riesgo, será actualizado
                    según lo dispuesto por Ley 1266 de 2008 y demás normas que lo regulen. 5.3. El presente documento presta mérito ejecutivo. 5.4. Una vez cumplido el acuerdo e informado al Banco, se emitirá el Paz y Salvo a los '.$diaspaz.' dias hábiles a través
                    de sus oficinas.
                </p><p style="clear: both; height: 10px;"></p><p style="clear: both; font-size: 5px;">1/3</p>';

                $html1 = '<p style="font-size: 14px;">ESTADO GENERAL DE LA DEUDA</p>
                <hr>
                <p style="clear: both; height: 20px;"></p> 
                <table style="width: 100%;">
                  <tr>
                      <td style="width: 50%; font-size: 7px;"><span style="font-weight: bold;">Fecha:</span>'.substr($ohAcuerdoTodas[0]['fecha'], 0, 10).'</td>
                      <td style="width: 50%; font-size: 7px;"><span style="font-weight: bold;">Ciudad:</span>'.$ohTodas[0]['ciudad'].'</td>
                  </tr>
                </table>  
                <p style="font-size: 7px; text-align: justify;">Entre los suscritos a saber, Consultores Legales AB quien en adelante se denominará
                    <b>AGENCIA</b> obrando en calidad de Agente de Cobranza externo para BBVA COLOMBIA S.A. quien en adelante se denominará <b>EL BANCO</b> y de otra parte el <b>DEUDOR</b> y/o
                    <b>TERCERO</b>:
                </p>
                <table style="width: 100%;">
                  <tr>
                      <td style="width: 50%; font-size: 7px;"><span style="font-weight: bold;">Nombre Completo:</span> '.$cliente[0]['nombre'].'</td>
                      <td style="width: 50%; font-size: 7px;"><span style="font-weight: bold;">Identificado con: C.C. (X) C.E. () NIT () No.</span>'.$cliente[0]['documento'].'</td>
                  </tr>
                </table>  
                <table style="width: 100%;">
                  <tr>
                      <td style="width: 50%; font-size: 7px;"><span style="font-weight: bold;">Dirección Correspondencia:</span> '.$direcciones[0]['direccion'].'</td>
                      <td style="width: 50%; font-size: 7px;"><span style="font-weight: bold;">Ciudad Correspondencia:</span> '.$direcciones[0]['idCiudad'].'</td>
                  </tr>
                </table> 
                
                <table style="width: 100%;">
                <tr>
                <td style="width: 50%; font-size: 7px;"><span style="font-weight: bold;">Teléfono Fijo: </span>'.$telefonos[0]['telefono'].'</td>
                <td style="width: 50%; font-size: 7px;"><span style="font-weight: bold;">Celular No. 1: </span>'.$telefonos[1]['telefono'].'</td>
                </tr>
                </table>
                <table style="width: 100%;">
                <tr>
                  <td style="width: 50%; font-size: 7px;"><span style="font-weight: bold;">Celular No. 2: </span>'.$telefonos[2]['telefono'].'</td>
                  <td style="width: 50%; font-size: 7px;"><span style="font-weight: bold;">Correo Electrónico: </span> '.$correo.'</td>
                  </tr>
                  </table>
                  <p style="clear: both; height: 20px;"></p> 
                <hr>
                <p style="font-size: 7px; text-align: justify;"><b><i>En caso de que el pago no lo realice el titular de la obligaciòn diligencie la siguiente
                            información</i></b></p>
                <p style="font-size: 7px; text-align: justify;">Nombre Completo de quien esta realizando el pago: ____________________________________ En Calidad de: Avalista ( ) Codeudor ( ) Demandado ( ) Tercero ( )</p>
                <p style="font-size: 7px; text-align: justify;">Identificado con: C.C. ( ) C.E. ( ) NIT ( ) No.___________________________</p>
                <p style="font-size: 7px; text-align: justify;">Dirección Correspondencia: _____________________________________________ Ciudad Correspondencia: _________________________________ </p>
                <hr>
                <p style="font-size: 7px; text-align: justify;">Deudor del (los) Contrato(s) relacionados a continuación, quien en adelante se denominará <b>EL
                        DEUDOR</b>.</p>
                <p style="clear: both; height: 20px;"></p>         
                <table border="1">
                        <tr>
                            <th style="font-size: 7px; text-align: center; font-weight: bold;">No. Contrato</th>
                            <th style="font-size: 7px; text-align: center; font-weight: bold;">Tipo Producto</th>
                            <th style="font-size: 7px; text-align: center; font-weight: bold;">Marca</th>
                            <th style="font-size: 7px; text-align: center; font-weight: bold;">Estado Judicial</th>
                            <th style="font-size: 7px; text-align: center; font-weight: bold;">Capital Total</th>
                            <th style="font-size: 7px; text-align: center; font-weight: bold;">Saldo Total</th>
                        </tr>';
                        $totalcapi = 0;
                        $totalsaldo = 0;
                   foreach($ohTodas as $oh1){     
              $html1 .='<tr>
                            <td style="font-size: 7px; text-align: center;">'.$oh1['obligacion'].'</td>
                            <td style="font-size: 7px; text-align: center;">'.$oh1['tipoproducto'].'</td>
                            <td style="font-size: 7px; text-align: center;">'.$oh1['marca'].'</td>
                            <td style="font-size: 7px; text-align: center;">'.$oh1['tipojudicial'].'</td>
                            <td style="font-size: 7px; text-align: center;">'.number_format($oh1['capitalactivo'], 0).'</td>
                            <td style="font-size: 7px; text-align: center;">'.number_format($oh1['saldototal'], 0).'</td>
                        </tr>';
                        $totalcapi += $oh1['capitalactivo'];
                        $totalsaldo += $oh1['saldototal'];
                      }
              $html1 .='<tr>
                            <td style="font-size: 7px; text-align: justify;" colspan="4"><b>VALOR TOTAL</b></td>
                            <td style="font-size: 7px; text-align: center;">'.number_format($totalcapi, 0).'</td>
                            <td style="font-size: 7px; text-align: center;">'.number_format($totalsaldo, 0).'</td>
                        </tr>
                </table>
                <p style="clear: both; height: 20px;"></p>';
                $totalVlAcuerdo = 0;
                $cuotas = $ohAcuerdoTodas[0]['cuotas'];
                $prefec = explode("-", $ohAcuerdoTodas[0]['fechapago']);
                $xuno = "";
                $xdos = "";
                $fecha2 = "";
                if($multi > '1'){
                  $xdos = "X";
                }else{
                  $xuno = "X";
                }
                if($multi > '1'){
                  $fecha2 = $macfecha;
                }else{
                  $fecha2 = $ohAcuerdoTodas[0]['fechapago'];
                }
                foreach($ohAcuerdoTodas as $ohacu){
                  $totalVlAcuerdo += $ohacu['valor'];
                  $totalVlAcuerdo += $ohacu['honorarios'];
                }
                $html1 .= '<p style="font-size: 7px; text-align: justify;">Manifestamos que hemos llegado a un <b>ACUERDO DE PAGO</b> sobre el total de endeudamiento por la suma de:  $'.number_format($totalVlAcuerdo, 0).'</p>
                <p style="font-size: 7px; text-align: justify;">al corte '.date("d").' de '.date("m").' de '.date("Y").' en las siguientes condiciones:</p>
                <br>
                <table style="width: 100%;">
                  <tr>
                    <td style="font-size: 7px; width: 30%; font-weight: bold;">TIPO DE ACUERDO DE PAGO:</td>
                    <td style="font-size: 7px; width: 10%; text-align: justify;"></td>
                    <td style="font-size: 7px; width: 20%; text-align: justify; font-weight: bold;">PAGO ÚNICO</td>
                    <td style="font-size: 7px; width: 10%; text-align: justify;">'.$xuno.'</td>
                    <td style="font-size: 7px; width: 20%; text-align: justify; font-weight: bold;">PAGO EN CUOTAS</td>
                    <td style="font-size: 7px; width: 10%; text-align: justify;">'.$xdos.'</td>
                  </tr>
                </table>
                <p style="clear: both; height: 30px;"></p>
                <table style="width: 100%;">
                  <tr>
                    <td style="font-size: 8px; width: 40%; text-align: justify; font-weight: bold;">Fecha de Inicio del acuerdo</td>
                    <td style="font-size: 7px; width: 10%; text-align: justify;">'.$ohAcuerdoTodas[0]['fechapago'].'</td>
                    <td style="font-size: 8px; width: 40%; text-align: justify; font-weight: bold;">Fecha de terminaciòn del acuerdo</td>
                    <td style="font-size: 7px; width: 10%; text-align: justify;">'.$fecha2.'</td>
                  </tr>
                </table>
                <p style="clear: both; height: 40px;"></p>
                <table style="width: 100%;">
                <tr>
                    <th style="width: 50%;  text-align: center;"><img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/firmaAlejo.png" width="80" alt=""/></th>
                    <th style="width: 50%;  text-align: center;"></th>
                  </tr>
                  <tr>
                    <th style="width: 50%;  text-align: center;">___________________________</th>
                    <th style="width: 50%;  text-align: center;">___________________________</th>
                  </tr>
                  <tr>
                    <th style="width: 50%; text-align: center; font-size: 7px; font-weight: bold;">Firma Agencia</th>
                    <th style="width: 50%; text-align: center; font-size: 7px; font-weight: bold;">Firma Cliente</th>
                  </tr>
                </table>
                <table style="width: 100%;">
                  <tr>
                    <td style="width: 50%;">
                      <p style="font-size: 7px;">
                        <span style=" font-weight: bold;">Nombre: </span>Alejandro Useche Gil<br>
                        <span style=" font-weight: bold;">Cargo Agencia: </span>Coordinador BBVA<br>
                        <span style=" font-weight: bold;">NIT: 900.691.502</span><br>
                        <span style=" font-weight: bold;">Dirección: </span>Carrera 29 # 75 A -26<br>
                        <span style=" font-weight: bold;">Telefono: </span>(601)7435603 - Ext: '.$asesor[0]['extension'].'<br>
                        <span style=" font-weight: bold;">Asesor: </span>'.$asesor[0]['nombre'].'</p>
                    </td>
                    <td style="width: 50%;">
                      <p style="font-size: 7px;">
                        <span style=" font-weight: bold;">Nombre: </span><br>
                        <span style=" font-weight: bold;">Documento: </span><br>
                        <span style=" font-weight: bold;">Dirección: </span><br>
                        <span style=" font-weight: bold;">Telefono: </span></p>
                    </td>
                  </tr>
                </table>
                <p style="font-size: 9px; text-align: justify; font-weight: bold;">***Acuerdo de pago aprobado en gestión de profesional <span style="color: #FF0000;">'.strtoupper($resp[0]['nombre_responsable']).'</span></p><p style="clear: both; height: 10px;"></p><p style="clear: both; font-size: 5px;">2/3</p>';
                $fecha0 = "";
                $fecha1 = "";
                $fecha2 = "";
                $fecha3 = "";
                $fecha4 = "";
                $fecha5 = "";

                if(isset($fechaAcuerdo[0]['fechapago'])){ $fecha0 = $fechaAcuerdo[0]['fechapago']; }
                if(isset($fechaAcuerdo[1]['fechapago'])){ $fecha1 = $fechaAcuerdo[1]['fechapago']; }
                if(isset($fechaAcuerdo[2]['fechapago'])){ $fecha2 = $fechaAcuerdo[2]['fechapago']; }
                if(isset($fechaAcuerdo[3]['fechapago'])){ $fecha3 = $fechaAcuerdo[3]['fechapago']; }
                if(isset($fechaAcuerdo[4]['fechapago'])){ $fecha4 = $fechaAcuerdo[4]['fechapago']; }
                if(isset($fechaAcuerdo[5]['fechapago'])){ $fecha5 = $fechaAcuerdo[5]['fechapago']; }       
      $html2 = '
      <p style="font-size: 14px;">DESPRENDIBLE PAGO CAJERO</p>
      <hr>
      <p style="clear: both; height: 30px;"></p> 
      <table style="width: 100%;">
        <tr>
          <td style="width: 50%; font-size: 7px; font-weight: bold;">Nombre Completo (Titular de la Obligación): '.$cliente[0]['nombre'].'</td>
          <td style="width: 50%; font-size: 7px; font-weight: bold;">Identificado con: C.C. (X) C.E. ( ) NIT ( ) No. '.$cliente[0]['documento'].'</td>
        </tr>
      </table>

      <table style="width: 100%;">
        <tr>
          <td style="width: 50%; font-size: 7px; font-weight: bold;">Dirección Correspondencia: '.$direcciones[0]['direccion'].'</td>
          <td style="width: 50%; font-size: 7px; font-weight: bold;">Ciudad Correspondencia: '.$direcciones[0]['idCiudad'].'</td>
        </tr>
      </table>

      <table style="width: 100%;">
        <tr>
          <td style="width: 50%; font-size: 7px; font-weight: bold;">Teléfono Fijo:'.$telefonos[0]['telefono'].'</td>
          <td style="width: 50%; font-size: 7px; font-weight: bold;">Celular No. 1: '.$telefonos[1]['telefono'].'</td>
        </tr>
      </table>
      <p style="clear: both; height: 20px;"></p> 
      <hr>
      <p style="clear: both; height: 20px;"></p> 
      <p style="font-size: 7px; text-align: center; width: 100%;"><b><i>Si la marca se encuentra registrada con CAS o CAS_LEAS y/o contiene honorarios de abogado se debe ejecutar pago CONTENCIOSO</i></b></p>
      <p style="clear: both; height: 20px;"></p> 

      <p style="font-size: 7px;"><b>PRIMERO: EL DEUDOR</b> se compromete a cancelar a <b>EL BANCO</b> por concepto de Saldo Total del (los) Contrato(s) anteriormente mencionados, la suma de: $'.number_format($totalVlAcuerdo, 0).' en sus oficinas directamente al (los) número(s) de contrato(s), conforme al siguiente plan de pagos acordado con la AGENCIA</p>

            <table border="1" style="width: 100%;">
                    <tr>
                        <th rowspan="2" style="font-size: 7px; text-align: justify;">Concepto</th>
                        <th rowspan="2" style="font-size: 7px; text-align: justify;">Marca</th>
                        <th style="font-size: 7px; text-align: justify;">'.$fecha0.'</th>
                        <th style="font-size: 7px; text-align: justify;">'.$fecha1.'</th>
                        <th style="font-size: 7px; text-align: justify;">'.$fecha2.'</th>
                        <th style="font-size: 7px; text-align: justify;">'.$fecha3.'</th>
                        <th style="font-size: 7px; text-align: justify;">'.$fecha4.'</th>
                        <th style="font-size: 7px; text-align: justify;">'.$fecha5.'</th>
                        
                        <th style="font-size: 7px; text-align: justify;" rowspan="2">Total</th>
                    </tr>
                    <tr>
                        <th style="font-size: 7px; text-align: justify;">Cuota 1</th>
                        <th style="font-size: 7px; text-align: justify;">Cuota 2</th>
                        <th style="font-size: 7px; text-align: justify;">Cuota 3</th>
                        <th style="font-size: 7px; text-align: justify;">Cuota 4</th>
                        <th style="font-size: 7px; text-align: justify;">Cuota 5</th>
                        <th style="font-size: 7px; text-align: justify;">Cuota 6</th>
                        
                    </tr>';
                    $totalhn0 = 0;
                    $totalhn1 = 0;
                    $totalhn2 = 0;
                    $totalhn3 = 0;
                    $totalhn4 = 0;
                    $totalhn5 = 0;

                    $totalcu0 = 0;
                    $totalcu1 = 0;
                    $totalcu2 = 0;
                    $totalcu3 = 0;
                    $totalcu4 = 0;
                    $totalcu5 = 0;

                    foreach($ohs as $clave => $valor){
                      $ohdata = $this->OperativoModel->buscarxobligAcuerdos($valor, "bbva");
                      $marca = $this->OperativoModel->getOhTodas($valor, "bbva");

                      $valor0 = 0;
                      $valor1 = 0;
                      $valor2 = 0;
                      $valor3 = 0;
                      $valor4 = 0;
                      $valor5 = 0;

                      if(isset($ohdata[0]['valor'])){ $valor0 = $ohdata[0]['valor']; }
                      if(isset($ohdata[1]['valor'])){ $valor1 = $ohdata[1]['valor']; }
                      if(isset($ohdata[2]['valor'])){ $valor2 = $ohdata[2]['valor']; }
                      if(isset($ohdata[3]['valor'])){ $valor3 = $ohdata[3]['valor']; }
                      if(isset($ohdata[4]['valor'])){ $valor4 = $ohdata[4]['valor']; }
                      if(isset($ohdata[5]['valor'])){ $valor5 = $ohdata[5]['valor']; }

                      if(!isset($ohdata[0]['honorarios'])){ $ohdata[0]['honorarios'] = 0; }
                      if(!isset($ohdata[1]['honorarios'])){ $ohdata[1]['honorarios'] = 0; }
                      if(!isset($ohdata[2]['honorarios'])){ $ohdata[2]['honorarios'] = 0; }
                      if(!isset($ohdata[3]['honorarios'])){ $ohdata[3]['honorarios'] = 0; }
                      if(!isset($ohdata[4]['honorarios'])){ $ohdata[4]['honorarios'] = 0; }
                      if(!isset($ohdata[5]['honorarios'])){ $ohdata[5]['honorarios'] = 0; }

                      $totalCuo = $valor0 + $valor1 + $valor2 + $valor3 + $valor4 + $valor5;

                      

                      $totalcu0 += $valor0 + $ohdata[0]['honorarios'];
                      $totalcu1 += $valor1 + $ohdata[1]['honorarios'];
                      $totalcu2 += $valor2 + $ohdata[2]['honorarios'];
                      $totalcu3 += $valor3 + $ohdata[3]['honorarios'];
                      $totalcu4 += $valor4 + $ohdata[4]['honorarios'];
                      $totalcu5 += $valor5 + $ohdata[5]['honorarios'];

                      $totalhn0 += $ohdata[0]['honorarios'];
                      $totalhn1 += $ohdata[1]['honorarios'];
                      $totalhn2 += $ohdata[2]['honorarios'];
                      $totalhn3 += $ohdata[3]['honorarios'];
                      $totalhn4 += $ohdata[4]['honorarios'];
                      $totalhn5 += $ohdata[5]['honorarios'];
                    
                        $html2 .= '<tr>
                            <td style="font-size: 6px; text-align: center;">'.$ohdata[0]['obligacion'].'</td>
                            <td style="font-size: 7px; text-align: center;">'.$marca[0]['marca'].'</td>
                            <td style="font-size: 7px; text-align: center;">'.number_format($valor0).'</td>
                            <td style="font-size: 7px; text-align: center;">'.number_format($valor1).'</td>
                            <td style="font-size: 7px; text-align: center;">'.number_format($valor2).'</td>
                            <td style="font-size: 7px; text-align: center;">'.number_format($valor3).'</td>
                            <td style="font-size: 7px; text-align: center;">'.number_format($valor4).'</td>
                            <td style="font-size: 7px; text-align: center;">'.number_format($valor5).'</td>
                            <td style="font-size: 7px; text-align: center;">'.number_format($totalCuo).'</td>
                        </tr>';
                    }
                    $totaltotal = $totalcu0 + $totalcu1 + $totalcu2 + $totalcu3 + $totalcu4 + $totalcu5;
                    $totalhntotal = $totalhn0 + $totalhn1 + $totalhn2 + $totalhn3 + $totalhn4 + $totalhn5;

                    $html2 .= '<tr style="background-color: #88AFCF;">
                        <th colspan="2" style="font-size: 6px; text-align: left;">Honorarios Agencia de Cobranza**</th>
                        <th style="font-size: 7px; text-align: center;">0</th>
                        <th style="font-size: 7px; text-align: center;">0</th>
                        <th style="font-size: 7px; text-align: center;">0</th>
                        <th style="font-size: 7px; text-align: center;">0</th>
                        <th style="font-size: 7px; text-align: center;">0</th>
                        <th style="font-size: 7px; text-align: center;">0</th>
                        <th style="font-size: 7px; text-align: center;">0</th>
                    </tr>
                    <tr style="background-color: #ADD8E6;">
                        <th colspan="2" style="font-size: 6px; text-align: left;">Honorarios Abogado Externo ** '.$ohAcuerdoTodas[0]['cuenta'].'</th>
                        <th style="font-size: 7px; text-align: center;">'.number_format($totalhn0, 0).'</th>
                        <th style="font-size: 7px; text-align: center;">'.number_format($totalhn1, 0).'</th>
                        <th style="font-size: 7px; text-align: center;">'.number_format($totalhn2, 0).'</th>
                        <th style="font-size: 7px; text-align: center;">'.number_format($totalhn3, 0).'</th>
                        <th style="font-size: 7px; text-align: center;">'.number_format($totalhn4, 0).'</th>
                        <th style="font-size: 7px; text-align: center;">'.number_format($totalhn5, 0).'</th>
                        <th style="font-size: 7px; text-align: center;">'.number_format($totalhntotal, 0).'</th>
                    </tr>
                    <tr  style="background-color: #6993d1;">
                        <th  colspan="2" style="font-size: 6px; text-align: left; font-weight: bold;">Valor total Cuota</th>
                        <th style="font-size: 7px; text-align: center; font-weight: bold;">'.number_format($totalcu0, 0).'</th>
                        <th style="font-size: 7px; text-align: center; font-weight: bold;">'.number_format($totalcu1, 0).'</th>
                        <th style="font-size: 7px; text-align: center; font-weight: bold;">'.number_format($totalcu2, 0).'</th>
                        <th style="font-size: 7px; text-align: center; font-weight: bold;">'.number_format($totalcu3, 0).'</th>
                        <th style="font-size: 7px; text-align: center; font-weight: bold;">'.number_format($totalcu4, 0).'</th>
                        <th style="font-size: 7px; text-align: center; font-weight: bold;">'.number_format($totalcu5, 0).'</th>
                        <th style="font-size: 7px; text-align: center; font-weight: bold;">'.number_format($totaltotal, 0).'</th>
                    </tr>
            </table>
            <p style="font-size: 7px; width: 100%; text-align: center;"><b><i>** En caso de tener valores manuales a pagar se deben consignar en las cuentas del Abogado o Agencia de cobranza, información detallada mas adelante.</i></b></p>
            <hr>
            <p style="clear: both; height: 20px;"></p>
            <table style="width: 100%;">
              <tr style="background-color: #88AFCF;">
                <td style="font-size: 7px; text-align: justify; font-weight: bold;">Nombre Agencia de Cobranza:</td>
                <td style="font-size: 7px; text-align: justify; font-weight: bold;">No. Cuenta en BBVA Agencia Ext</td>
              </tr>
            </table>
                
            <table  style="width: 100%;">
              <tr style="background-color: #ADD8E6;">
                <td style="font-size: 7px; text-align: justify;"><span style="font-weight: bold;">Nombre Abogado Externo: </span>'.$ohAcuerdoTodas[0]['abogado'].'</td>
                <td style="font-size: 7px; text-align: justify;"><span style="font-weight: bold;">No. Cuenta en BBVA Abogado Ext: </span>'.$ohAcuerdoTodas[0]['cuenta'].'</td>
              </tr>
            </table>
            <p style="font-size: 7px; width: 100%; text-align: center;">El BANCO puede recibir pagos fuera de los términos de plazo, monto y/o fechas acordadas dentro del presente Acuerdo de Pago Total. Sin embargo, esto no podrá entenderse como la modificación a las condiciones aceptadas e indicadas en la páginas 1 y 2 del presente acuerdo.</p><p style="clear: both; height: 10px;"></p><p style="clear: both; font-size: 5px;">3/3</p>';

  $html8 = '
  </body>
  </html>';

  $pdf->AddPage();
  $pdf->writeHTML($html0,true,0,true,0);
  $pdf->AddPage();
  $pdf->writeHTML($html1,true,0,true,0);
  $pdf->AddPage();
  $pdf->writeHTML($html2,true,0,true,0);
  $pdf->writeHTML($html8,true,0,true,0);
  //$pdf->AddPage();
  /*$pdf->writeHTML($html2,true,0,true,0);
  $pdf->writeHTML($html3,true,0,true,0);
  $pdf->writeHTML($html4,true,0,true,0);
  $pdf->writeHTML($html5,true,false,false,0);
  $pdf->writeHTML($html6,true,0,true,0);
  $pdf->writeHTML($html7,true,0,true,0);
  $pdf->Ln();
  $pdf->writeHTML($html8,true,0,true,0);*/

  $pdf->lastPage();
  $r = "Acuerdo_".$docu."_".date("YmdHis").".pdf";
  $nombreArchivo = "/var/www/html/puntualmentecomco/modulo_cobranzas/acuerdos/".$r;
  $pdf->Output($nombreArchivo, 'F');
  $ruts = "https://consulegalab.com/modulo_cobranzas/acuerdos/".$r;
  $this->OperativoModel->updateCorreoAcuerdo($r, $correo, $docu, "bbva");
  echo '<script src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/lib/js/core/acuerdo.js"></script><a href="'.$ruts.'" class="btn btn-warning" target="_blank">Revisar</a>&nbsp;&nbsp;&nbsp;&nbsp;<button id="enviaAcuerdoFinal" class="btn btn-primary" type="button">Enviar</button>';
  
}




/* FORMATO ANTERIOR DE ACUERDO DE PAGO */

public function generaracuerdopdfAnterior() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $this->load->library('Pdf');


  $docu = $this->input->post('docu');
  $correo = $this->input->post('correo');
  $ohs = $this->input->post('enviarPdfAcuerdo[]');
  $todas = "";
  foreach($ohs as $clave => $valor){
    $todas .= "'".$valor."',";
  }

  $todas = substr($todas, 0 ,-1);



  $hoy = date("Y-m-d");

  //  $this->OperativoModel->updateCorreoAcuerdo($correo, $docu, "bbva");
  $cliente = $this->OperativoModel->buscarxdoc($docu, "bbva");
  $direcciones = $this->OperativoModel->getDirecciones($docu, '1', "bbva");
  $telefonos = $this->OperativoModel->getTelefonos($docu, '1', "bbva");
  $ohTodas = $this->OperativoModel->buscarxobligIn($todas, "bbva");
  $ohAcuerdoTodas = $this->OperativoModel->buscarxobligInAcuerdos($todas, "bbva");
  $productocl = $this->OperativoModel->getdiaspr($cliente[0]['grupoproductos'], 'bbva');
  //$casa = $this->OperativoModel->getCasaUsuario($aseso[0]['idCasa']);
  //$coordina = $this->OperativoModel->getusuarioid($casa[0]['idCoordinador']);

  if(!isset($direcciones[0]['direccion'])){
    $direcciones[0]['direccion'] = "";
    $direcciones[0]['idCiudad'] = "";
  }

  if(!isset($telefonos[0]['telefono'])){
    $telefonos[0]['telefono'] = "";
  }

  if(!isset($telefonos[1]['telefono'])){
    $telefonos[1]['telefono'] = "";
  }

  if(!isset($telefonos[2]['telefono'])){
    $telefonos[2]['telefono'] = "";
  }

  //$acuerdo = explode("|", $cadena);

  //$dias = $this->restarFechas($oh[0]['fechavencimiento'], $hoy);

  $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

  $pdf->SetTitle('Acuerdo de Pago');
  $pdf->SetAutoPageBreak(true);
  $pdf->SetAuthor('Puntualmente BBVA');
  $pdf->SetDisplayMode('real', 'default');

  $fechasTabla = $this->OperativoModel->getAcuerdoFechaDocumento($cliente[0]['documento'], "bbva");
  $valTot = $this->OperativoModel->getAcuerdoValorTotal($cliente[0]['documento'], "bbva");
  $cuotasTotAc = count($fechasTabla);

  if(isset($productocl[0]['dias'])){
    $diaspaz = $productocl[0]['dias'];
  }else{
    $diaspaz = 36;
  }
  

  $html0 ='
  <html>
  <body style="border-collapse: collapse; border: 1px solid black;">
    <table>
      <tr>
        <th style="width: 27%; text-align: center;"><img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/bbva.png" width="200" alt="Bbva Logo" title="Bbva logo"/></th>
        <th style="width: 40%; text-align: center; font-size: 12px;">ACUERDO DE PAGO - PAGO TOTAL</th>
        <th style="width: 27%; text-align: center;"><img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/ablogo.png" width="200" alt="AB Logo" title="AB logo"/></th>
      </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td>
                <p style="font-size: 7px;"><strong>Fecha:</strong>'.date("d/m/Y").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Ciudad:</strong> Bogota
                    <br>Entre los suscritos a saber, Consultores Legales AB quien en adelante se denominará AGENCIA obrando en calidad de Agente de Cobranza externo para BBVA COLOMBIA S.A. quien en adelante se denominará&nbsp;&nbsp;<strong>EL BANCO</strong>&nbsp;&nbsp; y de otra
                    parte:
                    <br><strong>Nombre Completo:</strong>&nbsp;&nbsp;'.$cliente[0]['nombre'].'&nbsp;&nbsp;<strong>Calidad de:</strong> Titular(X) &nbsp;Avalista( ) &nbsp;Codeudor( )&nbsp; Demandado( ) &nbsp;Tercero( )
                    <br><strong>Identificado con:</strong> C.C. ( X ) C.E. ( ) NIT ( ) No. '.$cliente[0]['documento'].'
                </p>
            </td>
        </tr>
    </table>
    <p style="font-size: 6px;">Dirección Corresponden&nbsp;&nbsp;
        <storng>___________________________________________</storng>&nbsp;&nbsp;&nbsp;Ciudad Correspondencia:&nbsp;&nbsp;
        <storng>___________________________</storng>&nbsp;&nbsp;&nbsp;Teléfono Fijo: ________________
        <br>Celular No. 1:______________________&nbsp;Celular No. 2:_____________________ &nbsp; Correo Electrónico: _________________________<br>Deudor del (los) Contrato(s) relacionados a continuación, quien en adelante se denominará <strong>EL DEUDOR</strong></p>';
  $html1 = '
  <table style="width: 100%;">
    <tr>
      <td style="width: 15%;"></td>
      <td style="width: 70%;">


      <table>
      <tr>
          <td style="border-collapse: collapse; font-weight: bold; border: 1px solid black; text-align: center; font-size: 6px;">No. Contrato</td>
          <td style="border-collapse: collapse; font-weight: bold; border: 1px solid black; text-align: center; font-size: 6px;">Tipo Producto</td>
          <td style="border-collapse: collapse; font-weight: bold; border: 1px solid black; text-align: center; font-size: 6px;">Marca</td>
          <td style="border-collapse: collapse; font-weight: bold; border: 1px solid black; text-align: center; font-size: 6px;">Estado Judicial</td>
          <td style="border-collapse: collapse; font-weight: bold; border: 1px solid black; text-align: center; font-size: 6px;">Centro Gestor</td>
          <td style="border-collapse: collapse; font-weight: bold; border-right: 1px solid black; text-align: center; font-size: 6px;"></td>
          <td style="border-collapse: collapse; font-weight: bold; border: 1px solid black; text-align: center; font-size: 6px;">Saldo Total</td>
      </tr>';
    $ff = 0;
    $totalTotal = 0;
    foreach($ohTodas as $toh){
      $ff += 1;
      $totalTotal += $toh['saldototal'];
      $html1 .= '
      <tr>
        <td style="border-collapse: collapse; border: 1px solid black; text-align: center; font-size: 6px;">'.$toh['obligacion'].'</td>
        <td style="border-collapse: collapse; border: 1px solid black; text-align: center; font-size: 6px;">'.$toh['tipoproducto'].'</td>
        <td style="border-collapse: collapse; border: 1px solid black; text-align: center; font-size: 6px;">'.$toh['marca'].'</td>
        <td style="border-collapse: collapse; border: 1px solid black; text-align: center; font-size: 6px;">'.$toh['tipojudicial'].'</td>
        <td style="border-collapse: collapse; border: 1px solid black; text-align: center; font-size: 4px;">'.$toh['nombrecentrogestor'].'</td>
        <td style="border-collapse: collapse; border-right: 1px solid black; text-align: center; font-size: 6px;"></td>
        <td style="border-collapse: collapse; border: 1px solid black; text-align: right; font-size: 6px;"> $ '.number_format($toh['saldototal'], 0).'</td>
      </tr>
    ';
    }
    $html1 .= '
            <tr>
              <td style="border-collapse: collapse; font-weight: bold; border: 1px solid black; font-size: 6px;"></td>
              <td style="border-collapse: collapse; font-weight: bold; border: 1px solid black; font-size: 6px;"></td>
              <td style="border-collapse: collapse; font-weight: bold; border: 1px solid black; font-size: 6px;"></td>
              <td style="border-collapse: collapse; font-weight: bold; border: 1px solid black; font-size: 6px;"></td>
              <td style="border-collapse: collapse; font-weight: bold; border: 1px solid black; font-size: 6px;">Valor Total:</td>
              <td style="border-collapse: collapse; font-weight: bold; border-right: 1px solid black; font-size: 6px;"></td>
              <td style="border-collapse: collapse; border: 1px solid black; text-align: right; font-size: 6px;">$ '.number_format($totalTotal, 0).'</td>
            </tr>
        </table>

          </td>
          <td style="width: 15%;"></td>
        </tr>
      </table>';
  $xcuotas = "";
  $xunico = "";
  if($cuotasTotAc > 1){
    $xcuotas = "X";
  }else{
    $xunico = "X";
  }
  $html2 = '
  <table>
        <tr>
            <td style="font-size: 6px; width: 100%;">Manifestamos que hemos llegado a un ACUERDO DE PAGO sobre el total de endeudamiento por la suma de: $ '.number_format($totalTotal, 0).' <strong style="font-size: 6px;">al corte ('.date("d").') de ('.date("m").') de ('.date("Y").') en las siguientes condiciones</strong></td>
        </tr>
    </table>
  <table>
  <tr>
  <td style="font-size: 6px;">TIPO DE ACUERDO DE PAGO:</td>
  <td style="font-size: 6px;">PAGO ÚNICO</td>
  <td style="font-size: 6px; width: 60px;">'.$xunico.'</td>
  <td style="font-size: 6px;">PAGO EN CUOTAS</td>
  <td tyle="font-size: 6px; width: 60px;">'.$xcuotas.'</td>
  </tr>
  </table>
  <p style="width: 100%; text-align: center; font-size: 6px; font-weight: bold;">CLAUSULAS</p>
  <p style="font-size: 6px;"><strong>PRIMERO: EL DEUDOR</strong> se compromete a cancelar a <strong>EL BANCO</strong> por concepto de Saldo Total del (los) Contrato(s), la suma de: &nbsp;&nbsp;$'.number_format($valTot[0]['total']).' en sus oficinas directamente al (los) número(s) de contrato(s), conforme al siguiente plan de pagos acordado con la <strong>Consultores Legales AB</strong></p>';


  $html3 = '
  <table style="width: 100%">
    <tr>
      <td style="width: 10%"></td>
      <td style="width: 80%">
      
      <table style="border-collapse: collapse;">
      <tr>
      <th style="font-size: 6px; font-weight: bold; border-collapse: collapse; border:1px solid black; text-align: center;">No. Contrato</th>
      <th style="font-size: 6px; font-weight: bold; border-collapse: collapse; border:1px solid black; text-align: center;">No. Cuota</th>
      <th style="font-size: 6px; font-weight: bold; border-collapse: collapse; border:1px solid black; text-align: center;">Fecha de Pago</th>
      <th style="font-size: 6px; font-weight: bold; border-collapse: collapse; border:1px solid black; text-align: center;">Vr Pago Contrato</th>
      <th style="font-size: 6px; font-weight: bold; border-collapse: collapse; border:1px solid black; text-align: center;">Vr Honor Cobranza **</th>
      <th style="font-size: 6px; font-weight: bold; border-collapse: collapse; border:1px solid black; text-align: center;">Vr Honor Abogado Ext</th>
      <th style="font-size: 6px; font-weight: bold; border-collapse: collapse; border:1px solid black; text-align: center;">Vr Total Pago</th>
      </tr>';
    
      $totalObligaciones = 0;
      $totalhono = 0;
    
      foreach($ohAcuerdoTodas as $ohAc){
        $total1 = $ohAc['honorarios'] + $ohAc['valor'];
        $html3 .= '
        <tr>
          <td style="font-size: 6px; border-collapse: collapse; border:1px solid black; text-align: center;">'.$ohAc['obligacion'].'</td>
          <td style="font-size: 6px; border-collapse: collapse; border:1px solid black; text-align: center;">'.$ohAc['cuotas'].'</td>
          <td style="font-size: 6px; border-collapse: collapse; border:1px solid black; text-align: center;">'.$ohAc['fechapago'].'</td>
          <td style="font-size: 6px; border-collapse: collapse; border:1px solid black; text-align: center;">$'.number_format($ohAc['valor'],0).'</td>
          <td style="font-size: 6px; border-collapse: collapse; border:1px solid black; text-align: center;">0</td>
          <td style="font-size: 6px; border-collapse: collapse; border:1px solid black; text-align: center;">$'.number_format($ohAc['honorarios'],0).'</td>
          <td style="font-size: 6px; border-collapse: collapse; border:1px solid black; text-align: center;">$'.number_format($total1,0).'</td>
        </tr>';
        $totalObligaciones += $total1;
        $totalhono += $ohAc['honorarios'];
      }
      $html3 .= '
      <tr>
      <th colspan="4" style="font-size: 7px; font-weight: bold; border-collapse: collapse; border:1px solid black; text-align: center;"></th>
      <th style="font-size: 5px; font-weight: bold; border-collapse: collapse; border:1px solid black; text-align: center;">VALOR A PAGAR</th>
      <th style="font-size: 7px; font-weight: bold; border-collapse: collapse; border:1px solid black; text-align: center;">$'.number_format($totalhono,0).'</th>
      <th style="font-size: 7px; font-weight: bold; border-collapse: collapse; border:1px solid black; text-align: center;">$'.number_format($totalObligaciones,0).'</th>
      </tr>
      </table>
      
      
      
      </td>
      <td style="width: 10%"></td>
    </tr>
  </table>';
  $html4 = '
  <p style="font-size: 6px;">Nombre Abogado Externo:&nbsp;&nbsp;&nbsp;<span style="font-size: 6px; background-color: #d6dce4; width: 15px;">'.$ohAcuerdoTodas[0]['abogado'].'</span>&nbsp;No. Cuenta en BBVA Abogado Ext:&nbsp;<span style="font-size: 5px; background-color: #d6dce4;">'.$ohAcuerdoTodas[0]['cuenta'].'</span>';

  $html5 = '<p style="font-size: 5px; font-weight: bold;"><strong>SEGUNDO: CONDICIONES GENERALES</strong></p>
  <table>
  <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">1. El presente Acuerdo de Pago no implica novación ni reestructuración de(los) contrato(s) objeto de esta negociación. Deberá ser presentado en la sucursal al momento del pago.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">2. EL DEUDOR efectuará los pagos a los créditos únicamente en las Sucursales de  EL BANCO y dentro de los horarios autorizados. En consecuencia, los funcionarios de LA AGENCIA o los Abogados Externos no están facultados para recibir dineros, salvo que se trate del pago de honorarios profesionales. En caso que EL DEUDOR excepcionalmente realice el pago de honorarios directamente a la AGENCIA y/o Abogado Externo, deberá exigir la expedición del correspondiente recibo por ese concepto.  El(a) deudor(a) se obliga a entregar al día siguiente del pago copia de los recibos a la AGENCIA o al Funcionario del Banco.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">3. El incumplimiento del acuerdo en todo o en parte lo deja sin valor ni efecto y faculta al BANCO para revocar automáticamente  los  beneficios y/o descuentos negociados si hubiere lugar a ello. Los pagos serán  aplicados como simples abonos. Adicionalmente, dará lugar a que el BANCO inicie o impulse el proceso judicial, según corresponda, hasta lograr el pago  total de la deuda. De manera general, la forma en que se aplique cada  uno de  los pagos, se indicará en los comprobantes de pago que expida y entregue el BANCO.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">4. En el evento de existir un proceso judicial, es necesario que para suspender el proceso, se suscriba memorial de común acuerdo. Es de cargo del(los) demandado(s) autenticar el  memorial dirigido al Juez de conocimiento y devolverlo al funcionario con el cual se celebró el acuerdo o al abogado externo que adelanta el proceso judicial. El memorial será presentado al Juzgado una vez se cumpla con el Primer abono. Es de conocimiento de las partes que la suspensión es autorizada  por el Juez, de acuerdo a las etapas procesales y su criterio.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">5. El BANCO solicitará la terminación del proceso judicial siempre y cuando el acuerdo  sea cumplido integralmente. Si dentro de la suspensión del proceso se llegara a cancelar la totalidad de la (s) Obligación (es), se reconocerán honorarios de abogado sobre las sumas recibidas acorde al anexo tarifario.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">6. En el evento de existir un proceso judicial y tratarse de un pago total, será de cargo del(los) demandado(s) con posterioridad al cumplimiento del Acuerdo de pago, acercarse(n) al juzgado de conocimiento a fin de obtener a su cargo, oficio de desembargo y el desglose de los documentos (pagaré y escritura pública de hipoteca o prenda).</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">7. Si el deudor cuenta con otras obligaciones como titular, cotitular o codeudor, que presentan moras, contará con un plazo de 5 días hábiles para la normalización y evitar que se genere el incumplimiento sobre todo el acuerdo y la pérdida de sus beneficios, los cuales pueden comprender condonaciones.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">8. Cuando se trate de pago total de crédito hipotecario o prendario los pasivos que registre el inmueble o el vehículo y los gastos y tramites de levantamiento de hipoteca o prenda, según corresponda, debe asumirlos EL DEUDOR y /o propietario.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">9. EL DEUDOR y/o demandado(s), interesado(s), reconoce y acepta que adeuda honorarios y/o gastos derivados de la gestión de cobranza y por ende acuerda pagarlos. Estos valores están debidamente incorporados en el presente Acuerdo de pago.  En caso de incumplimiento los costos por concepto de Honorarios Abogado y gastos de proceso serán asumidos directamente por EL DEUDOR, pudiendo modificar lo pactado inicialmente en este acuerdo de pago.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">10. El DEUDOR reconoce y acepta que las tarjetas de crédito y/o cupos rotativos que hagan parte del acuerdo, serán dadas de baja, cancelando el contrato y el plástico.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">11. Hacer uso de las tarjetas de crédito y/o cupos rotativos una vez cumplido el acuerdo de pago deja sin efecto y pierde los beneficios otorgados en el presente acuerdo.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">12. EL DEUDOR autoriza a la AGENCIA para ser contactado vía WhatsApp a los números de celulares confirmados en este acuerdo de pago a efectos realizar  seguimiento y gestión de cobro.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">13. En el evento en que el deudor cuente con garantías FNG o FAG que hayan sido debidamente cobradas, tendrá la obligación de realizar acuerdo de pago con esas entidades. En todo los casos en que existe un proceso judicial, este no podrá ser terminado, ni levantadas las medidas cautelares, sin que exista orden de del FNG (En los casos donde existe venta a CISA esta será la entidad que se subrogue)  FAG.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">14. EL DEUDOR y sus apoderados, desisten y/o renuncian a ejercer o continuar toda acción o pretensión, llamamiento en garantía, queja o reclamo judicial o extrajudicial, administrativa, indemnización por actuación de parte civil dentro de un proceso penal, y en general desisten y/o renuncian a toda reclamación de cualquier índole o naturaleza que pudiera entablar o hubiesen entablado por los hechos relacionados con sus créditos, o los que estuvieran indirectamente relacionados con los fundamentos expuestos en los pleitos, declarando a paz y salvo por todo concepto al Grupo BBVA COLOMBIA S.A, a sus Apoderados Judiciales y  Agencia de Cobranza.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">15. Durante la vigencia del plan de pagos establecido en el presente compromiso, la(s) obligación(es) podrá(n) ser castigada(s) contablemente, con lo que ello implique.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">16. En caso de existir negociaciones con títulos judiciales las partes deberán firmar la solicitud de forma conjunta y estarán sujetos a los tiempos procesales, entendiendo que no corresponde a gestiones propias del Banco.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">17. El reporte ante centrales de riesgo, será actualizado según lo dispuesto por Ley 1266 de 2008 y demás normas que lo regulen.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">18. El proceso judicial no podrá ser suspendido en más de 2 oportunidades y por más de 6 meses. El presente documento presta mérito ejecutivo.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">19. No será respetado el acuerdo de pago si no es remitido con las respectivas firmas.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">20. Una vez cumplido el acuerdo e informado al Banco, se emitirá el Paz y Salvo a los '.$diaspaz.' días hábiles a través de sus oficinas.</p></td>
    </tr>
    <tr>
    <td style="text-align: left;"><p style="font-size: 4px;">21. El cliente podrá ser sujeto de castigo o judicialización de su cartera de acuerdo a las políticas del Banco.</p></td>
    </tr>
  </table>';

  //
  $resp = $this->OperativoModel->getResponsableNombre($ohTodas[0]['responsable'], "bbva");
  
  if(!isset($resp[0]['nombre_responsable'])){
    $resp[0]['nombre_responsable'] = "Sin Responsable"; 
  }

  $html6 = '<p style="height: 9px; background-color: #aeaaaa; width: 100%; font-size: 6px; font-weight: bold; margin: 3px; padding-top: 3px;">Para constancia se firma en la ciudad de &nbsp;&nbsp;&nbsp;Bogotá&nbsp;&nbsp;&nbsp;  a los (&nbsp;'.date("d").'&nbsp;) días del mes (&nbsp;'.date("m").'&nbsp;) del año (&nbsp;'.date("Y").'&nbsp;), con destino a las partes.</p>';
  $html7 = '

  <table>
    <tr>
        <td style="font-size: 7px; width: 150px;">EL DEUDOR</td>
        <td style="width: 12px; "></td>
        <td style="font-size: 7px; ">AGENCIA</td>
        <td style="width: 60px; "></td>
        <td style="font-size: 7px; ">EL BANCO</td>
    </tr>
    <tr>
        <td style="font-size: 7px; width: 150px; ">
            <hr style="margin-top: 20px;"> Nombres y Apellidos<br> No. Identificación:<br></td>
        <td style="width: 12px; "></td>
        <td style="font-size: 7px; ">Jose Alejandro useche Gil
            <hr> Nombres y Apellidos<br> No. Identificación: 1014179211<br>
        </td>
        <td style="width: 60px; "></td>
        <td style="font-size: 7px; ">'.$resp[0]['nombre_responsable'].'
            <hr style="margin-top: 20px;"> Nombres y Apellidos<br> Cargo: Profesional Especializado<br></td>
    </tr>

    <tr>
        <td style="font-size: 5px; height: 30px; border-bottom: 1px solid black;"></td>
        <td style="width: 12px; "></td>
        <td style="font-size: 5px; height: 30px; border-bottom: 1px solid black; ">
          <img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/firmaUseche.png" height="30" alt="Forma Useche" title="Alejandro Useche"/>
        </td>
        <td style="width: 30px; "></td>
        <td>
        </td>
    </tr>

    <tr>
        <td style="font-size: 7px; text-align: center; ">Firma</td>
        <td style="width: 12px; "></td>
        <td style="font-size: 7px; text-align: center; ">Firma</td>
        <td style="width: 60px; "></td>
        <td></td>
    </tr>
  </table>';
  $html8 = '
  </body>
  </html>';

  $pdf->AddPage();

  //$pdf->SetMargins(10, 10, 10, true); // set the margins
  $pdf->Ln();
  $pdf->writeHTML($html0,true,0,true,0);
  //$pdf->writeHTML('<p style="margin-top: 5px; height: 20px;"></p>',true,0,true,0);
  //  $pdf->Ln();
  $pdf->writeHTML($html1,true,0,true,0);
  //  $pdf->Ln();
  $pdf->writeHTML($html2,true,0,true,0);
  //$pdf->writeHTML('<p style="margin-top: 5px; height: 20px;"></p>',true,0,true,0);
  //  $pdf->Ln();
  $pdf->writeHTML($html3,true,0,true,0);
  $pdf->writeHTML($html4,true,0,true,0);
  $pdf->writeHTML($html5,true,false,false,0);
  $pdf->writeHTML($html6,true,0,true,0);
  //  $pdf->Ln();
  $pdf->writeHTML($html7,true,0,true,0);
  //$pdf->writeHTML('<p style="margin-top: 20px; height: 15px;"></p>',true,0,true,0);
  //  $pdf->Ln();
  $pdf->Ln();
  $pdf->writeHTML($html8,true,0,true,0);

  $pdf->lastPage();
  $r = "Acuerdo_".$docu."_".date("YmdHis").".pdf";
  $nombreArchivo = "/var/www/html/puntualmentecomco/modulo_cobranzas/acuerdos/".$r;
  $pdf->Output($nombreArchivo, 'F');
  $ruts = "https://consulegalab.com/modulo_cobranzas/acuerdos/".$r;
  $this->OperativoModel->updateCorreoAcuerdo($r, $correo, $docu, "bbva");
  echo '<script src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/lib/js/core/acuerdo.js"></script><a href="'.$ruts.'" class="btn btn-warning" target="_blank">Revisar</a>&nbsp;&nbsp;&nbsp;&nbsp;<button id="enviaAcuerdoFinal" class="btn btn-primary" type="button">Enviar</button>';
  //echo $link;
  //echo '<script src="https://' . $_SERVER['HTTP_HOST'] . '/front/lib/js/core/acuerdo.js"></script> <button id="enviaAcuerdoFinal" class="btn btn-primary" type="button">Enviar</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-success" href="'.$ruts.'" target="blank">Revisar</a>';
  //$pdf->Output('pazysalvo.pdf', 'I');
}






public function generarpropuestapdf() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $this->load->library('Pdf');


  $docu = $this->input->post('docu');
  $correo = $this->input->post('correo');
  $fec = $this->input->post('fec');
  $val = $this->input->post('val');

  $hoy = date("Y-m-d");

  $cliente = $this->OperativoModel->buscarxdoc($docu, "bbva");

  $usuarioDatos = $this->OperativoModel->getusuario($data['session']['usuario']);

  $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

  $pdf->SetTitle('Propuesta');
  $pdf->SetAutoPageBreak(true);
  $pdf->SetAuthor('Consultores Legales AB');
  $pdf->SetDisplayMode('real', 'default');

  $mm = date('n');

  if($mm == 1){
    $mes = "Enero";
  }else if($mm == 2){
    $mes = "Febrero";
  }else if($mm == 3){
    $mes = "Marzo";
  }else if($mm == 4){
    $mes = "Abril";
  }else if($mm == 5){
    $mes = "Mayo";
  }else if($mm == 6){
    $mes = "Junio";
  }else if($mm == 7){
    $mes = "Julio";
  }else if($mm == 8){
    $mes = "Agosto";
  }else if($mm == 9){
    $mes = "Septiembre";
  }else if($mm == 10){
    $mes = "Octubre";
  }else if($mm == 11){
    $mes = "Noviembre";
  }else if($mm == 12){
    $mes = "Diciembre";
  }

  $html0 ='
  <html>
  <body style="border-collapse: collapse; border: 1px solid black;">
  <p>'.$mes.' de '.date('Y').'</p><br>
  <p>Buen día, señor (a)  <strong>'.$cliente[0]['nombre'].'</strong></p><br><br>
  <p>Apreciado Cliente</p><br>';
  $html1 = '  <p>El Banco BBVA quiere que acabe <span style="text-decoration: underline; font-weight: bold;">'.$mes.'</span> sin deudas, por lo mismo lo invita a aprovechar un ÚNICO descuento para saldar la TOTALIDAD de sus OBLIGACIONES EN MORA. Cancele antes del <span style="text-decoration: underline; font-weight: bold; color:#002060;">'.$fec.'</span> el valor de <span style="text-decoration: underline; font-weight: bold; color:#002060;">$'.number_format($val, 0).'</span> e inicie trámite de PAZ Y SALVO. Este documento no es válido para formalizar la propuesta, para ello, se debe comunicar con los teléfonos de la agencia y firmar un acuerdo para acceder al descuento.<br>En caso de tener adelantos de nómina, sobregiros o cuentas por cobrar, no se incluyen dentro del valor informado anteriormente.</p><br>
  <h4>¡NO PIERDAS ESTA EXCELENTE OPORTUNIDAD!</h4>
  <h4>DESCUENTO EXTRAORDINARIO POR TIEMPO LIMITADO</h4><br>
  <p>Comuníquese a nuestra línea de atención en Bogotá <span style="text-decoration: underline; font-weight: bold; color:#002060;">(601)7435603 -  (601)7432238 - 3022907495 –  3330333137</span> opción <span style="text-decoration: underline;">'.$usuarioDatos[0]['extension'].'</span>, horarios de atención de <span style="text-decoration: underline; font-weight: bold; color:#002060;">lunes</span> a <span style="text-decoration: underline; font-weight: bold; color:#002060;">viernes</span> de 7:00 a.m. a 6:00 p.m. y sábados de 8:00 a.m. a 12:00 p.m., también podrá acercarse a nuestras oficinas en la dirección Cra. 29 # 75a - 26 Barrio Santa Sofía en Bogotá.<br><br>Lo invitamos a realizar los abonos en las fechas acordadas, únicamente a través de la Red de oficinas de BBVA a nivel Nacional o por nuestros canales alternos (www.bbva.com.co, BBVA móvil, corresponsales Bancarios).</p><br>
  <h5 style="text-align: center; font-weight: bold; ">RECUERDE QUE</h5><br>
  <h6 style="font-weight: bold;">"Ningún asesor de la casa de cobranzas está autorizado para recibir directa o indirectamente dineros. Todo pago deberá ser realizado en las cajas de las sucursales del Banco BBVA"</h6><br><br><br><br><br>';

  $html2 = '
  <p><img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/ablogo.png" width="100" alt="AB Logo" title="AB logo"/></p>
  <p style="font-size: 13px;">'.$usuarioDatos[0]['nombre'].'</p>
  <p style="font-size: 11px;">Gestión Cartera Castigada<br>Consultores Legales AB<br>Agencia Externa Banco BBVA<br>Pbx (601)7432238 - (601)7435603 Ext '.$usuarioDatos[0]['extension'].'<br>Cra 29 #75ª-26 Barrio Santa Sofia<br>Bogota - Colombia</p>';
  $html3 = '
  </body>
  </html>';

  $pdf->AddPage();

  //$pdf->SetMargins(10, 10, 10, true); // set the margins
  $pdf->Ln();
  $pdf->writeHTML($html0,true,0,true,0);
  $pdf->writeHTML($html1,true,0,true,0);
  $pdf->writeHTML($html2,true,0,true,0);
  $pdf->writeHTML($html3,true,0,true,0);
  $pdf->lastPage();
  $r = "Propuesta_".$docu."_".date("YmdHis").".pdf";
  $nombreArchivo = "/var/www/html/puntualmentecomco/modulo_cobranzas/propuestas/".$r;
  $pdf->Output($nombreArchivo, 'F');

  $this->load->library('phpmailer_lib');

  $txtgest = "Se envia propuesta de pago por valor: ".$val.", para la fecha: ".$fec.", el archivo: ".$r." al correo: ".$correo;

  $fechaToda = date("Y-m-d H:i:s");
  $hora = date("H");

  $mail = $this->phpmailer_lib->load();
  $mail->isSMTP();
  //$mail->SMTPDebug = 3; //Alternative to above constant
  $mail->Host     = '172.16.20.214';
  $mail->SMTPOptions = array(
    'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
    )
  );
  $mail->SMTPAuth = true;
  $mail->Username = 'propuestas.bbva@consulegalab.co';
  $mail->Password = 'UZpYXeQL3pBwA42';
  $mail->SMTPSecure = 'ssl';
  $mail->Port     = 465;
  $mail->CharSet = 'UTF-8';
  $mail->setFrom("infobbva@consulegalab.co", "Consultores Legales AB");

  $mail->addAddress($correo);
  $mail->addBCC('copiainfobbva@puntualmente.com.co');
  $mail->addBCC('infobbva@consulegalab.co');
  $mail->AddAttachment($nombreArchivo);

  // Email subject
  $mail->Subject = "Propuesta de pago BBVA.";
  $message = "
  <html>
  <body>
  <p>Señor(a): ".$cliente[0]['nombre']."</p>
  <p>Adjunto propuesta de pago para cancelar su(s) obligación(es) con el banco BBVA, por favor una vez reciba el documento, comuníquese con el asesor encargado al teléfono (601)7432238 - (601)7435603.</p>
  <p>Cordial Saludo,</p>
  <p>Consultores Legales AB<br>Agencia Externa Banco BBVA<br>Carrea 29 # 75a-26 Barrio Santa Sofía<br>PBX. (601)7432238 - (601)7435603</p>
  </body>
  </html>";
  // Set email format to HTML
  $mail->isHTML(true);

  // Email body content
  $mailContent = $message;
  $mail->Body = $mailContent;

  // Send email
  if(!$mail->send()){
    echo "Error";
  }else{
    $this->OperativoModel->saveGestion($docu, $fechaToda, $hora, $correo, '5', '6', '0', '61', '', '0', '', $txtgest, $data['session']['id'], '', $data['session']['proyecto_activo']);
    echo "1";
  }
}


public function smsadmin($slug) {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();
  $this->session->validaPerfilCoordinador($data['session']['perfil']);

  $data['sms'] = $this->OperativoModel->getListadoSms($slug);

  $this->load->view('templates/header', $data);
  $this->load->view('templates/sidebar', $data);
  $this->load->view('smsadmin/listado', $data);
  $this->load->view('templates/footer', $data);
}

public function agregarsmsadmin() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();
  $this->session->validaPerfilCoordinador($data['session']['perfil']);

  $data['sms'] = $this->OperativoModel->getListadoSms($data['session']['proyecto_activo']);
  $data['campanas'] = $this->OperativoModel->getCampanas();

  $this->load->view('templates/header', $data);
  $this->load->view('templates/sidebar', $data);
  $this->load->view('smsadmin/agregarsms', $data);
  $this->load->view('templates/footer', $data);
}

public function savesmsadmin() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();
  $this->session->validaPerfilCoordinador($data['session']['perfil']);

  $nombre = $this->input->post('nombretarea');
  $prioridad = $this->input->post('prioridadtarea');
  $campana = $this->input->post('campana-sms');
  $hora = $this->input->post('hora-sms');
  $dias = $this->input->post('dias[]');

  $prioridad = $prioridad + 1;

  $lunes = '0';
  $martes = '0';
  $miercoles = '0';
  $jueves = '0';
  $viernes = '0';
  $sabado = '0';
  $domingo = '0';

  $peridiocidad = '';
  foreach($dias as $d){
    if($d == "Lunes"){
      $lunes = '1';
    }
    if($d == "Martes"){
      $martes = '1';
    }
    if($d == "Miercoles"){
      $miercoles = '1';
    }
    if($d == "Jueves"){
      $jueves = '1';
    }
    if($d == "Viernes"){
      $viernes = '1';
    }
    if($d == "Sabado"){
      $sabado = '1';
    }
    if($d == "Domingo"){
      $domingo = '1';
    }
  }

  $peridiocidad = $lunes.";".$martes.";".$miercoles.";".$jueves.";".$viernes.";".$sabado.";".$domingo;

  $this->OperativoModel->createSms($nombre, $peridiocidad, $data['session']['id'], date("Y-m-d H:i:s"), $prioridad, $campana, $hora, $data['session']['proyecto_activo']);

  echo "<script>location.href='https://consulegalab.com/modulo_cobranzas/index.php/sms/admin/".$data['session']['proyecto_activo']."'</script>";

}

public function editarsmsadmin($slug) {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();
  $this->session->validaPerfilCoordinador($data['session']['perfil']);

  $data['smss'] = $this->OperativoModel->getSmsUno($slug, $data['session']['proyecto_activo']);
  $data['condiciones'] = $this->OperativoModel->getSmsDetalle($slug, $data['session']['proyecto_activo']);
  $data['creditos'] = $this->OperativoModel->getDescribeCreditos($data['session']['proyecto_activo']);
  $data['clientes'] = $this->OperativoModel->getDescribeClientes($data['session']['proyecto_activo']);


  $this->load->view('templates/header', $data);
  $this->load->view('templates/sidebar', $data);
  $this->load->view('smsadmin/editarsmsadmin', $data);
  $this->load->view('templates/footer', $data);
}

public function savecriteriotareasadminsms() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();
  $this->session->validaPerfilCoordinador($data['session']['perfil']);


  $campo = $this->input->post('campos');
  $operador = $this->input->post('operadors');
  $valor = $this->input->post('valors');
  $tarea = $this->input->post('tareas');

  $this->OperativoModel->saveCriteriosms($campo, $operador, $valor, $tarea, $data['session']['proyecto_activo']);


  $condiciones = $this->OperativoModel->getTareaDetallesms($tarea, $data['session']['proyecto_activo']);

  $html = '';

  $html .= '<table class="table data-table table-bordered">
  <thead>
  <tr>
  <th>Campo</th>
  <th>Operador</th>
  <th>Valor</th>
  </tr>
  </thead>
  <tbody>';
  foreach($condiciones as $con){
    $html .= '<tr>
    <td>'.$con['campo'].'</td>
    <td>'.$con['operador'].'</td>
    <td>'.$con['valor'].'</td>
    </tr>';
  }
  $html .= '</tbody>
  </table>';


  echo $html;
}

public function previewsmsadmin() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();
  $this->session->validaPerfilCoordinador($data['session']['perfil']);

  $tarea = $this->input->post('tareas');

  $condiciones = $this->OperativoModel->getSmsDetalle($tarea, $data['session']['proyecto_activo']);

  $sql = 'select count(9_creditos.idCreditos) as total from 9_creditos, 10_clientes where ';

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
    }


    $sql .= $cond['campo'].' '.$cond['operador'].' '.$valor.' and ';
  }

  $sql .= " 9_creditos.activo = '1' and 10_clientes.documento = 9_creditos.documento;";

  $result = $this->OperativoModel->setConsulta($sql, $data['session']['proyecto_activo']);
  echo "Se van a cargar: ".$result[0]['total']. " Registros.";
}

public function createsmsadmin() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();
  $this->session->validaPerfilCoordinador($data['session']['perfil']);

  $tarea = $this->input->post('tareas');




  $condiciones = $this->OperativoModel->getSmsDetalle($tarea, $data['session']['proyecto_activo']);

  $sql = "select AES_DECRYPT(10_clientes.documento,  '$this->key') as documento, 9_cobranzas.idAsesor  from 9_cobranzas, 10_clientes where ";

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
      $valor = "'".$fecha."'";
    }


    $sql .= $cond['campo'].' '.$cond['operador'].' '.$valor.' and ';
  }

  $sql .= " 9_cobranzas.activo = '1' and 10_clientes.documento = 9_cobranzas.documento;";

  $result = $this->OperativoModel->setConsulta($sql, $data['session']['proyecto_activo']);
  $usuarios = $this->OperativoModel->getusuariosall();
  $tareaUno = $this->OperativoModel->getSmsUno($tarea, $data['session']['proyecto_activo']);

  $this->OperativoModel->truncateCampana($tareaUno[0]['campana']);

  $nombreTarea = str_replace(" ", "_", $tareaUno[0]['nombre']).'_';

  foreach($result as $r){
    $tel = $this->OperativoModel->getDemograClienteConf($r['documento'], $data['session']['proyecto_activo']);
    if(isset($tel[0]['telefono'])){
      if(strlen($tel[0]['telefono']) == 10){
        $hoy = date("Y-m-d");
        $this->OperativoModel->insertSmsAdmin($tel[0]['telefono'], $tareaUno[0]['campana'], $hoy, $r['documento']);
      }

    }
  }

  $cargados = $this->OperativoModel->getCargadosSms($nombreTarea, $data['session']['proyecto_activo']);

  echo "Se cargaron: ".$cargados[0]['total'].' registros.';

}



/* Formatos Cartas */


public function generacartaaprobacion() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $this->load->library('Pdf');


  $docu = $this->input->post('docu');
  $correo = $this->input->post('mail');

  $hoy = date("Y-m-d");

  $cliente = $this->OperativoModel->buscarxdoc($docu, "bbva");

  $acuerdo = $this->OperativoModel->acuerdorxdoc($docu, "bbva");
  $obligaciones = $this->OperativoModel->getOhDoc($docu, "bbva");

  $ohspdf = '';
  foreach($obligaciones as $ohs){
    $o = substr($ohs['obligacion'], -4);
    $ohspdf .= $o." - ";
  }

  $ohspdf = substr($ohspdf, 0, -3);

  $usuarioDatos = $this->OperativoModel->getusuario($data['session']['usuario']);

  $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

  $pdf->SetTitle('Desistimiento');
  $pdf->SetAutoPageBreak(true);
  $pdf->SetAuthor('Consultores Legales AB');
  $pdf->SetDisplayMode('real', 'default');

  $mm = date('n');

  if($mm == 1){
    $mes = "Enero";
  }else if($mm == 2){
    $mes = "Febrero";
  }else if($mm == 3){
    $mes = "Marzo";
  }else if($mm == 4){
    $mes = "Abril";
  }else if($mm == 5){
    $mes = "Mayo";
  }else if($mm == 6){
    $mes = "Junio";
  }else if($mm == 7){
    $mes = "Julio";
  }else if($mm == 8){
    $mes = "Agosto";
  }else if($mm == 9){
    $mes = "Septiembre";
  }else if($mm == 10){
    $mes = "Octubre";
  }else if($mm == 11){
    $mes = "Noviembre";
  }else if($mm == 12){
    $mes = "Diciembre";
  }

  $html0 ='
  <html>
  <body style="border-collapse: collapse; border: 1px solid black;">
  <p><table>
  <tr>
  <th style="width: 27%; text-align: center;"><img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/bbva.png" width="200" alt="Bbva Logo" title="Bbva logo"/></th>
  <th style="width: 40%; text-align: center; font-size: 12px;"></th>
  <th style="width: 27%; text-align: center;"><img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/ablogo.png" width="200" alt="AB Logo" title="AB logo"/></th>
  </tr>
  </table></p>
  <p style="font-size: 11px;">Bogotá, '.date("d")." ".$mes." ".date("Y").'<br><br><strong>'.$cliente[0]['nombre'].'</strong></p><br>
  <p>Respetado (a) Señor (a):</p><br>';
  $html1 = '<p style="font-size: 11px; text-align: justify;">Consultores Legales AB SAS, agencia de cobranza externa autorizada por BBVA Colombia S.A, se permite informarle que desiste de la solicitud realizada por usted el '.$acuerdo[0]['fechapago'].', con relación a la(s) obligación(es) en la(s) que figura como responsable del pago ante la entidad, debido a que no cumplió con:<br><br>
  Teniendo en cuenta lo pactado, usted no genero el pago según las condiciones establecidas en el acuerdo para la(s) obligación(es) terminada(s) en:  '.$ohspdf.', por lo mismo, el Banco decidió hacer efectiva la cláusula que cita lo siguiente: El incumplimiento del acuerdo en todo o en parte lo deja sin valor ni efecto y faculta al BANCO para revocar automáticamente los beneficios y/o descuentos negociados si hubiere lugar a ello. Los pagos serán aplicados como simples abonos. Adicionalmente, dará lugar a que el BANCO inicie o impulse el proceso ejecutivo, según corresponda, hasta lograr el pago total de la deuda. De manera general, la forma en que se aplique cada uno de los abonos, se indicará en los comprobantes que expida y entregue el BANCO.<br><br>
  Igualmente estamos atentos a escucharlo con el fin de orientarle sobre una alternativa que le permita normalizar su portafolio en el menor tiempo posible, considerando entre otras, su situación y las políticas de la entidad. Para mayor información o inquietud acerca de esta comunicación, contáctenos al teléfono 7435603 Ext. '.$usuarioDatos[0]['extension'].' en Bogotá, donde con gusto lo atenderemos.<br><br>
  Por lo anterior, daremos impulso a las acciones de cobranza extrajudicial y/o judicial, con el correspondiente reporte ante centrales de riesgo y costos adicionales que se generan por la gestión de cobro que pueden ser consultados en https://www.bbva.com.co/personas/politicas-de-cobranzas.html.<br><br>
  Finalmente, certificamos que transcurridos dos (2) meses a partir del envío de esta comunicación, procederemos a la destrucción de todos los documentos entregados y/o firmados por usted para el trámite de la referencia.</p><br>
  ';
  $html2 = '
  <p><img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/firmaAlejo.png" width="100" alt="AB Logo" title="AB logo"/></p>
  <p style="font-size: 13px;">Alejandro Useche</p>
  <p style="font-size: 11px;">Consultores Legales AB</p>';
  $html3 = '
  </body>
  </html>';

  $pdf->AddPage();

  //$pdf->SetMargins(10, 10, 10, true); // set the margins
  $pdf->Ln();
  $pdf->writeHTML($html0,true,0,true,0);
  $pdf->writeHTML($html1,true,0,true,0);
  $pdf->writeHTML($html2,true,0,true,0);
  $pdf->writeHTML($html3,true,0,true,0);
  $pdf->lastPage();
  $r = "Desistimiento".$docu."_".date("YmdHis").".pdf";
  $nombreArchivo = "/var/www/html/puntualmentecomco/modulo_cobranzas/propuestas/".$r;
  $pdf->Output($nombreArchivo, 'F');

  $this->load->library('phpmailer_lib');

  $txtgest = "Se envia desistimiento,correo: ".$correo;

  $fechaToda = date("Y-m-d H:i:s");
  $hora = date("H");

  $mail = $this->phpmailer_lib->load();
  $mail->isSMTP();
  //  $mail->SMTPDebug = 2; //Alternative to above constant
  $mail->Host     = 'smtpout.secureserver.net';
  $mail->SMTPOptions = array(
    'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
    )
  );
  $mail->SMTPAuth = true;
  $mail->Username = 'infobbva@consulegalab.co';
  $mail->Password = 'Colombia1987*-+';
  $mail->SMTPSecure = 'ssl';
  $mail->Port     = 465;
  $mail->CharSet = 'UTF-8';
  $mail->setFrom("infobbva@consulegalab.co", "Consultores Legales AB");
  $mail->addBCC('copiainfobbva@puntualmente.com.co');

  $mail->addAddress($correo);
  //  $mail->addAddress('andresl.vargasduarte@gmail.com');
  $mail->AddAttachment($nombreArchivo);

  // Email subject
  $mail->Subject = "Desistimiento BBVA.";
  $message = "
  <html>
  <body>
  <p>Señor(a): ".$cliente[0]['nombre']."</p>
  <p>Debido al incumplimiento del acuerdo pactado para cancelar las obligaciones del BBVA, adjunto documento con el desistimiento de negociación.<br><br>
  Agradezco su atención,</p>
  <p>Cordial Saludo,</p>
  <p><strong>Alejandro Useche</strong><br>Coordinador Cartera Judicial Banco BBVA<br>Consultores Legales AB<br>Agencia Externa Banco BBVA<br>Carrea 29 # 75a-26 Barrio Santa Sofía<br>PBX. 7435603</p>
  </body>
  </html>";
  // Set email format to HTML
  $mail->isHTML(true);

  // Email body content
  $mailContent = $message;
  $mail->Body = $mailContent;

  // Send email
  if(!$mail->send()){
    echo "Error";
  }else{
    $this->OperativoModel->saveGestion($docu, $fechaToda, $hora, $correo, '5', '6', '0', '63', '', '0', '', $txtgest, $data['session']['id'], '', $data['session']['proyecto_activo']);
    echo "1";
  }
}



/* FIN Formatos Cartas */


public function sendformatomail() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $this->load->library('Pdf');


  $formato = $this->input->post('texto');
  $docu = $this->input->post('docu');
  $correo = $this->input->post('mail');

  $hoy = date("Y-m-d");

  $cliente = $this->OperativoModel->buscarxdoc($docu, "bbva");

  $usuarioDatos = $this->OperativoModel->getusuario($data['session']['usuario']);


  $this->load->library('phpmailer_lib');

  $txtgest = "Se envia desistimiento,correo: ".$correo;

  $fechaToda = date("Y-m-d H:i:s");
  $hora = date("H");

  $mail = $this->phpmailer_lib->load();
  $mail->isSMTP();
  $mail->SMTPDebug = 3; //Alternative to above constant
  $mail->Host = '172.16.20.214';
  $mail->SMTPOptions = array(
    'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
    )
  );

  $mail->SMTPAuth = true;
  $mail->Username = 'propuestas.bbva@consulegalab.co';
  $mail->Password = 'UZpYXeQL3pBwA42';
  $mail->SMTPSecure = 'ssl';
  $mail->Port     = 465;
  $mail->CharSet = 'UTF-8';
  $mail->setFrom("propuestas.bbva@consulegalab.co", "Consultores Legales AB");
  $mail->addBCC('copiainfobbva@puntualmente.com.co');

  $mail->addAddress($correo);
  //  $mail->addAddress('andresl.vargasduarte@gmail.com');
  //$mail->AddAttachment($nombreArchivo);


if($formato == 'carta_impago'){
  $resultado = '67';
  $mail->Subject = "Carta Impago.";
  $message = '<!DOCTYPE html>
  <html lang="es">
    <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <style class="text/css">
        .margen {
        }
        .asunto {
          text-align: right;
        }
  
        .texto {
          font-size: 25px;
        }
        .agua {
          text-align: center;
          font-size: 15px;
          margin-top: 80px;
          color: darkgray;
        }
  
        #columna1 {
          top:0px;
          left:0px;
          width:200px;
          margin-top:10px;
      }
        #columna2 {
          margin-left: 50%;
          margin-top: -100px;
          position: absolute;
      }
      </style>
      <title></title>
    </head>
  
    <body>
  
  
      <div class="margen">
  
          <div id="columna1">
            <img src="http://192.155.92.243/formatos/img/logoBbvaCartas.png" alt="BBVA" title="BBVA" />
          </div>
          <div id="columna2">
              <img src="http://192.155.92.243/formatos/img/consultores_legales_mails.png" alt="">
          </div>
  
        <div class="logo" >
          
          
      </div>
        <div class="cabe" style="margin-top: 50px;">
        <span style="font-weight: bold; color: #2f5496; font-size: 20px;">Ciudad; '.date('d/m/Y').' </span>
        <p style="font-size: 20px;">Señor (a):</p>
        <span  style="font-weight: bold; color: #2f5496; font-size: 20px;">'.$cliente[0]['nombre'].' </span>
        <span style="font-weight: bold; color: #2f5496; font-size: 20px;">'.$correo.'</span>
        </div>
        
  
        <div class="asunto">
          <h4>ASUNTO: CARTA POR IMPAGO  DE  ACUERDO PAGO TOTAL</h4>
        </div>
  
        <div class="texto">
          <p>Respetado (a) Señor (a):</p>
          <p>
            <span style="font-weight: bold; color: #2f5496"></span>
            <span style="font-weight: bold; color: #2f5496">Consultores Legales AB,</span>
             agencia de cobranza externa autorizada por
            BBVA Colombia S.A., le informa que dados los IMPAGOS de 
            <span style="font-weight: bold; color: #2f5496">ACUERDO DE PAGO TOTAL</span>
            con relación a la(s) obligación(es) donde actualmente figura como responsable del pago ante la entidad, se encuentra 
            proxima al DESISTIMIENTO, debido al incumplimiento de las condiciones pactadas inicialmente.
          </p>
  
          <p>
              Igualmente estamos atentos a escucharlo con el fin de orientarle sobre una alternativa que le permita
               normalizar su portafolio en el menor tiempo posible, considerando entre otras, su situación y las 
               políticas de la entidad.
          </p>
  
          <p>
              Recuerde que el incumplimiento del acuerdo en todo o en parte lo deja sin valor ni efecto y faculta al 
              Banco para revocar automáticamente los beneficios y/o descuentos negociados si hubiere lugar a ello. 
              Los pagos serán aplicados como simples abonos. Adicionalmente, dará lugar a que el Banco inicie o 
              impulse el proceso ejecutivo, según corresponde, hasta lograr el pago total de la deuda. 
              <span style="font-weight: bold; color: #2f5496">CONSULTORES LEGALES AB,</span> a quienes puede contactar ante cualquier inquietud al <span style="font-weight: bold; color: #2f5496">6017435603 </span>
               en <span style="font-weight: bold; color: #2f5496">Bogotá,</span> o acérquese a <span style="font-weight: bold; color: #2f5496">Carrera 29 No. 75A – 26 en Bogotá.</span>
          </p>
  
  
      <div style="margin-top: 100px;">
  
          <p>Cordialmente,</p>
          <br /><br />
  
          <div style="position: absolute;margin-top: -55px;margin-left: 70px;">
              <img src="http://192.155.92.243/formatos/img/firma_mails.png" alt="" style="width: 60%;">
          </div>
          
          ___________________________________<br />
  
          <span style="font-weight: bold; color: #2f5496"
            >Supervisor Cartera Banco BBVA</span
          ><br />
          <span style="font-weight: bold; color: #2f5496">José Alejandro Useche Gil</span
          ><br />
          
          <span style="font-weight: bold; color: #2f5496"
            >Consultores Legales AB</span
          ><br /><br />

  
          <div class="agua">
            <p>Digitalízate</p>
            <p>Ahorra tiempo y esfuerzo con nuestros servicios digitales</p>
            <p>BBVA Net – BBVA Móvil</p>
          </div>
        </div>
      </div>
    </body>
  </html>';
}elseif($formato == 'propuesta_pago_total'){
  $resultado = '69';
  $mail->Subject = "Propuesta Pago Total.";
  $message = '<!DOCTYPE html>
  <html lang="es">
    <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <style class="text/css">
        .margen {
        }
        .asunto {
          text-align: right;
        }
  
        .texto {
          font-size: 25px;
        }
        .agua {
          text-align: center;
          font-size: 15px;
          margin-top: 80px;
          color: darkgray;
        }
  
        #columna1 {
          top:0px;
          left:0px;
          width:200px;
          margin-top:10px;
      }
        #columna2 {
          margin-left: 50%;
          margin-top: -100px;
          position: absolute;
      }
      </style>
      <title></title>
    </head>
  
    <body>
  
  
      <div class="margen">
  
      <div id="columna1">
        <img src="http://192.155.92.243/formatos/img/logoBbvaCartas.png" alt="BBVA" title="BBVA" />
      </div>
        <div id="columna2">
            <img src="http://192.155.92.243/formatos/img/consultores_legales_mails.png" alt="">
        </div>

  
        <div class="logo" >
          
          
      </div>
      
  
        <div class="cabe" style="margin-top: 50px;">
  
        <div class="cabe" style="margin-top: 50px;">
        <span style="font-weight: bold; color: #2f5496; font-size: 20px;">Ciudad; '.date('d/m/Y').' </span>
        <p style="font-size: 20px;">Señor (a):</p>
        <span  style="font-weight: bold; color: #2f5496; font-size: 20px;">'.$cliente[0]['nombre'].' </span>
        <span style="font-weight: bold; color: #2f5496; font-size: 20px;">'.$correo.'</span>
        </div>
  
        </div>
        
  
        <div class="asunto">
          <h4>ASUNTO: CARTA DE NEGACIÓN PAGO TOTAL</h4>
        </div>
  
        <div class="texto">
          <p>Respetado (a) Señor (a):</p>
          <p>
            <span style="font-weight: bold; color: #2f5496">Consultores Legales AB,</span>
            agencia de cobranza externa autorizada por BBVA Colombia S.A., dando respuesta a su solicitud de 
            <span style="font-weight: bold; color: #2f5496">PAGO TOTAL </span>
            con relación a la(s) obligación(es) que actualmente maneja con la entidad, se permite informarle que el Banco considero NEGADA la 
            propuesta, se aconseja mejorar la negociación.
          </p>
          <p>
              Lo invitamos a realizar los pagos en las fechas acordadas, únicamente a través de nuestra red de oficinas consúltelas a través de  www.bbva.com.co.
          </p>
  
  
      <div style="margin-top: 100px;">
  
          <p>Cordialmente,</p>
          <br /><br />
  
          <div style="position: absolute;margin-top: -55px;margin-left: 70px;">
            <img src="http://192.155.92.243/formatos/img/firma_mails.png" alt="" style="width: 60%;">
          </div>
          
          ___________________________________<br />
  
          <span style="font-weight: bold; color: #2f5496"
            >Supervisor Cartera Banco BBVA</span
          ><br />
          <span style="font-weight: bold; color: #2f5496">José Alejandro Useche Gil</span
          ><br />
          
          <span style="font-weight: bold; color: #2f5496"
            >Consultores Legales AB</span
          ><br /><br />

  
          <div class="agua">
            <p>Digitalízate</p>
            <p>Ahorra tiempo y esfuerzo con nuestros servicios digitales</p>
            <p>BBVA Net – BBVA Móvil</p>
          </div>
        </div>
      </div>
    </body>
  </html>';
}elseif($formato == 'pazysalvo'){
  $resultado = '68';
  $mail->Subject = "Cumplimiento Acuerdo de Pago.";
  $message = '<!DOCTYPE html>
  <html lang="es">
    <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <style class="text/css">
        .margen {
        }
        .asunto {
          text-align: right;
        }
  
        .texto {
          font-size: 25px;
        }
        .agua {
          text-align: center;
          font-size: 15px;
          margin-top: 80px;
          color: darkgray;
        }
  
        #columna1 {
          top:0px;
          left:0px;
          width:200px;
          margin-top:10px;
      }
        #columna2 {
          margin-left: 50%;
          margin-top: -100px;
          position: absolute;
      }
      </style>
      <title></title>
    </head>
  
    <body>
  
  
      <div class="margen">
  
      <div id="columna1">
        <img src="http://192.155.92.243/formatos/img/logoBbvaCartas.png" alt="BBVA" title="BBVA" />
      </div>
        <div id="columna2">
            <img src="http://192.155.92.243/formatos/img/consultores_legales_mails.png" alt="">
        </div>
  
        <div class="logo" >
          
          
      </div>
      
  
      <div class="cabe" style="margin-top: 50px;">
      <span style="font-weight: bold; color: #2f5496; font-size: 20px;">Ciudad; '.date('d/m/Y').' </span>
      <p style="font-size: 20px;">Señor (a):</p>
      <span  style="font-weight: bold; color: #2f5496; font-size: 20px;">'.$cliente[0]['nombre'].' </span>
      <span style="font-weight: bold; color: #2f5496; font-size: 20px;">'.$correo.'</span>
      </div>
        
  
        <div class="asunto">
          <h4>ASUNTO:<strong>ENTREGA PAZ Y SALVO</strong></h4>
        </div>
  
        <div class="texto">
          <p>Respetado (a) Señor (a):</p>
          <p>
            <span style="font-weight: bold; color: #2f5496">Consultores Legales AB,</span>
            agencia de cobranza externa autorizada por BBVA Colombia S.A., dado el cumplimiento de  
            <span style="font-weight: bold; color: #2f5496">ACUERDO DE PAGO TOTAL</span> con relación a la(s) obligación(es) que 
            actualmente maneja con la entidad, se permite informarle que el PAZ  Y SALVO puede ser 
            reclamado en la oficina gestora del Banco.
          </p>
  
          <p>
              Recuerde en caso de tener procesos jurídicos vigentes el abogado externo radicara el memorial de 
              terminación de proceso, pero usted debe radicar los oficios de desembargo y el desglose de las garantías según corresponda.
          </p>
  
  
      <div style="margin-top: 100px;">
  
          <p>Cordialmente,</p>
          <br /><br />
  
          <div style="position: absolute;margin-top: -55px;margin-left: 70px;">
            <img src="http://192.155.92.243/formatos/img/firma_mails.png" alt="" style="width: 60%;">
          </div>
          
          ___________________________________<br />
  
          <span style="font-weight: bold; color: #2f5496"
            >Supervisor Cartera Banco BBVA</span
          ><br />
          <span style="font-weight: bold; color: #2f5496">José Alejandro Useche Gil</span
          ><br />
          
          <span style="font-weight: bold; color: #2f5496"
            >Consultores Legales AB</span
          ><br /><br />

  
          <div class="agua">
            <p>Digitalízate</p>
            <p>Ahorra tiempo y esfuerzo con nuestros servicios digitales</p>
            <p>BBVA Net – BBVA Móvil</p>
          </div>
        </div>
      </div>
    </body>
  </html>';
}

  // Email subject
  
  // Set email format to HTML









  $mail->isHTML(true);

  // Email body content
  $mailContent = $message;
  $mail->Body = $mailContent;

  // Send email
  if(!$mail->send()){
    echo "Error";
  }else{
    $this->OperativoModel->saveGestion($docu, $fechaToda, $hora, $correo, '5', '6', '0', $resultado, '', '0', '', $formato, $data['session']['id'], '', $data['session']['proyecto_activo']);
    echo "1";
  }
}






public function generardesistirpdf() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $this->load->library('Pdf');


  $docu = $this->input->post('docu');
  $correo = $this->input->post('mail');

  $hoy = date("Y-m-d");

  $cliente = $this->OperativoModel->buscarxdoc($docu, "bbva");

  $acuerdo = $this->OperativoModel->acuerdorxdoc($docu, "bbva");
  $obligaciones = $this->OperativoModel->getOhDoc($docu, "bbva");

  $ohspdf = '';
  foreach($obligaciones as $ohs){
    $o = substr($ohs['obligacion'], -4);
    $ohspdf .= $o." - ";
  }

  $ohspdf = substr($ohspdf, 0, -3);

  $usuarioDatos = $this->OperativoModel->getusuario($data['session']['usuario']);

  $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

  $pdf->SetTitle('Desistimiento');
  $pdf->SetAutoPageBreak(true);
  $pdf->SetAuthor('Consultores Legales AB');
  $pdf->SetDisplayMode('real', 'default');

  $mm = date('n');

  if($mm == 1){
    $mes = "Enero";
  }else if($mm == 2){
    $mes = "Febrero";
  }else if($mm == 3){
    $mes = "Marzo";
  }else if($mm == 4){
    $mes = "Abril";
  }else if($mm == 5){
    $mes = "Mayo";
  }else if($mm == 6){
    $mes = "Junio";
  }else if($mm == 7){
    $mes = "Julio";
  }else if($mm == 8){
    $mes = "Agosto";
  }else if($mm == 9){
    $mes = "Septiembre";
  }else if($mm == 10){
    $mes = "Octubre";
  }else if($mm == 11){
    $mes = "Noviembre";
  }else if($mm == 12){
    $mes = "Diciembre";
  }

  $html0 ='
  <html>
  <body style="border-collapse: collapse; border: 1px solid black;">
  <p><table>
  <tr>
  <th style="width: 27%; text-align: center;"><img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/bbva.png" width="200" alt="Bbva Logo" title="Bbva logo"/></th>
  <th style="width: 40%; text-align: center; font-size: 12px;"></th>
  <th style="width: 27%; text-align: center;"><img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/ablogo.png" width="200" alt="AB Logo" title="AB logo"/></th>
  </tr>
  </table></p>
  <p style="font-size: 11px;">Bogotá, '.date("d")." ".$mes." ".date("Y").'<br><br><strong>'.$cliente[0]['nombre'].'</strong></p><br>
  <p>Respetado (a) Señor (a):</p><br>';
  $html1 = '<p style="font-size: 11px; text-align: justify;">Consultores Legales AB SAS, agencia de cobranza externa autorizada por BBVA Colombia S.A, se permite informarle que desiste de la solicitud realizada por usted el '.$acuerdo[0]['fechapago'].', con relación a la(s) obligación(es) en la(s) que figura como responsable del pago ante la entidad, debido a que no cumplió con:<br><br>
  Teniendo en cuenta lo pactado, usted no genero el pago según las condiciones establecidas en el acuerdo para la(s) obligación(es) terminada(s) en:  '.$ohspdf.', por lo mismo, el Banco decidió hacer efectiva la cláusula que cita lo siguiente: El incumplimiento del acuerdo en todo o en parte lo deja sin valor ni efecto y faculta al BANCO para revocar automáticamente los beneficios y/o descuentos negociados si hubiere lugar a ello. Los pagos serán aplicados como simples abonos. Adicionalmente, dará lugar a que el BANCO inicie o impulse el proceso ejecutivo, según corresponda, hasta lograr el pago total de la deuda. De manera general, la forma en que se aplique cada uno de los abonos, se indicará en los comprobantes que expida y entregue el BANCO.<br><br>
  Igualmente estamos atentos a escucharlo con el fin de orientarle sobre una alternativa que le permita normalizar su portafolio en el menor tiempo posible, considerando entre otras, su situación y las políticas de la entidad. Para mayor información o inquietud acerca de esta comunicación, contáctenos al teléfono 7435603 Ext. '.$usuarioDatos[0]['extension'].' en Bogotá, donde con gusto lo atenderemos.<br><br>
  Por lo anterior, daremos impulso a las acciones de cobranza extrajudicial y/o judicial, con el correspondiente reporte ante centrales de riesgo y costos adicionales que se generan por la gestión de cobro que pueden ser consultados en https://www.bbva.com.co/personas/politicas-de-cobranzas.html.<br><br>
  Finalmente, certificamos que transcurridos dos (2) meses a partir del envío de esta comunicación, procederemos a la destrucción de todos los documentos entregados y/o firmados por usted para el trámite de la referencia.</p><br>
  ';
  $html2 = '
  <p><img src="/var/www/html/puntualmentecomco/modulo_cobranzas/front/img/firmaAlejo.png" width="100" alt="AB Logo" title="AB logo"/></p>
  <p style="font-size: 13px;">Alejandro Useche</p>
  <p style="font-size: 11px;">Consultores Legales AB</p>';
  $html3 = '
  </body>
  </html>';

  $pdf->AddPage();

  //$pdf->SetMargins(10, 10, 10, true); // set the margins
  $pdf->Ln();
  $pdf->writeHTML($html0,true,0,true,0);
  $pdf->writeHTML($html1,true,0,true,0);
  $pdf->writeHTML($html2,true,0,true,0);
  $pdf->writeHTML($html3,true,0,true,0);
  $pdf->lastPage();
  $r = "Desistimiento".$docu."_".date("YmdHis").".pdf";
  $nombreArchivo = "/var/www/html/puntualmentecomco/modulo_cobranzas/propuestas/".$r;
  $pdf->Output($nombreArchivo, 'F');

  $this->load->library('phpmailer_lib');

  $txtgest = "Se envia desistimiento,correo: ".$correo;

  $fechaToda = date("Y-m-d H:i:s");
  $hora = date("H");

  $mail = $this->phpmailer_lib->load();
  $mail->isSMTP();
  $mail->SMTPDebug = 3; //Alternative to above constant
  $mail->Host = '172.16.20.214';
  $mail->SMTPOptions = array(
    'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
    )
  );
  $mail->SMTPAuth = true;
  $mail->Username = 'desistimientos.bbva@consulegalab.co';
  $mail->Password = 'Colombia2017*-+';
  $mail->SMTPSecure = 'ssl';
  $mail->Port     = 465;
  $mail->CharSet = 'UTF-8';
  $mail->setFrom("desistimientos.bbva@consulegalab.co", "Consultores Legales AB");
  $mail->addBCC('copiainfobbva@puntualmente.com.co');

  $mail->addAddress($correo);
  //  $mail->addAddress('andresl.vargasduarte@gmail.com');
  $mail->AddAttachment($nombreArchivo);

  // Email subject
  $mail->Subject = "Desistimiento BBVA.";
  $message = "
  <html>
  <body>
  <p>Señor(a): ".$cliente[0]['nombre']."</p>
  <p>Debido al incumplimiento del acuerdo pactado para cancelar las obligaciones del BBVA, adjunto documento con el desistimiento de negociación.<br><br>
  Agradezco su atención,</p>
  <p>Cordial Saludo,</p>
  <p><strong>Alejandro Useche</strong><br>Coordinador Cartera Judicial Banco BBVA<br>Consultores Legales AB<br>Agencia Externa Banco BBVA<br>Carrea 29 # 75a-26 Barrio Santa Sofía<br>PBX. 7435603</p>
  </body>
  </html>";
  // Set email format to HTML
  $mail->isHTML(true);

  // Email body content
  $mailContent = $message;
  $mail->Body = $mailContent;

  // Send email
  if(!$mail->send()){
    echo "Error";
  }else{
    $this->OperativoModel->saveGestion($docu, $fechaToda, $hora, $correo, '5', '6', '0', '63', '', '0', '', $txtgest, $data['session']['id'], '', $data['session']['proyecto_activo']);
    echo "1";
  }
}

public function enviaracuerdofinal() {
  $this->load->library('phpmailer_lib');
  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $docu = $this->input->post('docu');
  $hoy = date("Y-m-d");

  $cliente = $this->OperativoModel->buscarxdoc($docu, "bbva");
  $acuerdo = $this->OperativoModel->acuerdorxdoc($docu, "bbva");

  $txtgest = "Se envia acuerdo por valor: ".$acuerdo[0]['valor'].", para la fecha: ".$acuerdo[0]['fechapago'].", el archivo: ".$acuerdo[0]['archivo']." al correo: ".$acuerdo[0]['correo'];


  $fechaToda = date("Y-m-d H:i:s");
  $hora = date("H");



  // PHPMailer object
  $mail = $this->phpmailer_lib->load();

  // SMTP configuration
  $mail->isSMTP();
  //$mail->SMTPDebug = 2; //Alternative to above constant
  $mail->Host     = 'smtpout.secureserver.net';
  $mail->SMTPOptions = array(
    'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
    )
  );
  $mail->SMTPAuth = true;
  $mail->Username = 'infobbva@consulegalab.com';
  $mail->Password = 'Samuel01192005*-+';
  $mail->SMTPSecure = 'ssl';
  $mail->Port     = 465;
  $mail->CharSet = 'UTF-8';


  $mail->setFrom("infobbva@consulegalab.com", "Consultores Legales AB");

  $rutaCompleta = "/var/www/html/puntualmentecomco/modulo_cobranzas/acuerdos/".$acuerdo[0]['archivo'];
  // Add a recipient
  $mail->addAddress($acuerdo[0]['correo']);
  $mail->addBCC('copiainfobbva@puntualmente.com.co');
  $mail->AddAttachment($rutaCompleta);


  // Email subject
  $mail->Subject = "Acuerdo BBVA.";
  $message = "
  <html>
  <body>
  <p>Respetado (a) Señor (a):</p>
  <p>Consultores Legales AB, agencia de cobranza externa autorizada por BBVA Colombia S.A., dando respuesta a su solicitud de Propuesta de Pago Total con relación a la(s) obligación(es) que actualmente maneja con la entidad, se permite informarle que el Banco la considero viable, bajo las condiciones establecidas en el acuerdo que le remitimos adjunto, el cual debe firmar en señal de aceptación y remitirnos a la mayor brevedad. 
  <br><br>Es importante mencionar que el incumplimiento de las condiciones relacionadas en el acuerdo generan las consecuencias indicadas en el numeral tercero del mencionado documento, los términos del acuerdo están sujetos a supervisión por parte de Consultores Legales AB, a quienes puede contactar ante cualquier inquietud al 6017435603 en Bogotá o acérquese a la Carrera 29 No75A-26 en Bogotá.
  <br><br>Lo invitamos a realizar los pagos en las fechas acordadas, únicamente a través de nuestra red de oficinas consúltelas a través de  www.bbva.com.co.
  <br><br>Una vez cumplidas las condiciones establecidas en el documento anexo, se dará inicio al trámite de paz y salvo.
  </p>
  <p>Cordialmente, </p>
  <p>Ricardo Jimenez<br>
  Supervisor de Cartera<br>
  Consultores Legales AB</p>
  </body>
  </html>";
  // Set email format to HTML
  $mail->isHTML(true);

  // Email body content
  $mailContent = $message;
  $mail->Body = $mailContent;

  // Send email
  if(!$mail->send()){
    echo "Error";
  }else{
    $this->OperativoModel->saveGestion($docu, $fechaToda, $hora, $acuerdo[0]['correo'], '5', '7', '0', '60', $acuerdo[0]['fechapago'], $acuerdo[0]['valor'], '', $txtgest, $data['session']['id'], '', $data['session']['proyecto_activo']);
    echo "Correo enviado!";
  }
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


public function prememo($slug) {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $this->load->view('templates/header', $data);
  $this->load->view('templates/sidebar', $data);
  $this->load->view('operativo/fechainfomemo', $data);
  $this->load->view('templates/footer', $data);
}

public function exportarinformebbvaespejo($slug) {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $this->load->view('templates/header', $data);
  $this->load->view('templates/sidebar', $data);
  $this->load->view('operativo/fechainfobbvaespejo', $data);
  $this->load->view('templates/footer', $data);
}

public function exportarinformebbvatabla($slug) {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $this->load->view('templates/header', $data);
  $this->load->view('templates/sidebar', $data);
  $this->load->view('operativo/fechainfobbvatabla', $data);
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
  $data['gestionestotal'] = $this->OperativoModel->getGestionesTotal($fechaini, $fechafin, $data['session']['proyecto_activo']);
  
  $this->utilidades->saveEvent("Genera informe BBVA", $data['session']['id'], $data['session']['proyecto_activo']);
  
  $this->load->view('operativo/generabbva', $data);
}

public function generainformebbvaespejo() {

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
  
  $this->load->view('operativo/generabbvaespejo', $data);
}



public function armamemo() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();


  $prefechaini = explode("/", $this->input->post("fechaIni"));
  $prefechafin = explode("/", $this->input->post("fechaFin"));

  $fechaini = $prefechaini[2] . "-" . $prefechaini[0] . "-" . $prefechaini[1];
  $fechafin = $prefechafin[2] . "-" . $prefechafin[0] . "-" . $prefechafin[1];

  $data['fechaini'] = $fechaini;
  $data['fechafin'] = $fechafin;
  $data['gestiones'] = $this->OperativoModel->getGestionesInformeTabla($fechaini, $fechafin, $data['session']['proyecto_activo']);
  $this->OperativoModel->createTemp0($fechaini, $fechafin, $data['session']['proyecto_activo']);
  
  $this->utilidades->saveEvent("Genera memo movistar", $data['session']['id'], $data['session']['proyecto_activo']);
  
  $this->load->view('operativo/generamemo', $data);
}


public function generainformebbvatabla() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();


  $prefechaini = explode("/", $this->input->post("fechaIni"));
  $prefechafin = explode("/", $this->input->post("fechaFin"));

  $fechaini = $prefechaini[2] . "-" . $prefechaini[0] . "-" . $prefechaini[1];
  $fechafin = $prefechafin[2] . "-" . $prefechafin[0] . "-" . $prefechafin[1];

  $data['fechaini'] = $fechaini;
  $data['fechafin'] = $fechafin;
  $data['gestiones'] = $this->OperativoModel->getGestionesInformeTabla($fechaini, $fechafin, $data['session']['proyecto_activo']);
  $this->OperativoModel->createTemp0($fechaini, $fechafin, $data['session']['proyecto_activo']);
  
  
  $this->utilidades->saveEvent("Genera informe BBVA", $data['session']['id'], $data['session']['proyecto_activo']);
  
  $this->load->view('operativo/generabbvatabla', $data);
}

public function importarasignacion() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $this->load->view('templates/header', $data);
  $this->load->view('templates/sidebar', $data);
  $this->load->view('pages/cargaAsignacion', $data);
  $this->load->view('templates/footer', $data);
}

public function cargarpagoscredivalores() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $this->load->view('templates/header', $data);
  $this->load->view('templates/sidebar', $data);
  $this->load->view('operativo/pagoscredivalores', $data);
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
  $config['max_size'] = "150000";

  $this->load->library('upload', $config);

  if (!$this->upload->do_upload($mi_archivo)) {
    //*** ocurrio un error
    $data['uploadError'] = $this->upload->display_errors();

    echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
    echo "<script>location.href='http://" . $_SERVER['HTTP_HOST'] . "/index.php/importartareas/" . $data['session']['proyecto_activo'] . "'</script>";
    return;
  } else {
    //$data['uploadSuccess'] = $this->upload->data();
    $this->utilidades->saveEvent("carga asignacion, usuarios", $data['session']['id'], $data['session']['proyecto_activo']);
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

      unlink($filesname);
    }
  }


  $this->utilidades->saveEvent("carga Asignacion BBVA", $data['session']['id'], $data['session']['proyecto_activo']);

  echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/resumen-asignacion/" . $data['session']['proyecto_activo'] . "';</script>";
}



public function uploadpagoscredivalores() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $mi_archivo = 'file';
  $config['upload_path'] = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/";
  $config['file_name'] = "pagosCredivalores";
  $config['allowed_types'] = "*";
  $config['max_size'] = "150000";

  $this->load->library('upload', $config);

  if (!$this->upload->do_upload($mi_archivo)) {
    //*** ocurrio un error
    $data['uploadError'] = $this->upload->display_errors();

    echo "<script>alert('ERROR: " . $this->upload->display_errors() . "');</script>";
    echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/index.php/cargarpagoscredivalores/" . $data['session']['proyecto_activo'] . "'</script>";
    return;
  } else {
    $datas = array('upload_data' => $this->upload->data());
    $fila = 1;

    $filesname = "/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $datas['upload_data']['file_name'];
    if (($archivo = fopen("/var/www/html/puntualmentecomco/modulo_cobranzas/uploads/" . $datas['upload_data']['file_name'], "r")) !== false) {

      while (($datos = fgetcsv($archivo, 50000, ";")) !== FALSE) {
        $numero = count($datos);



        $doc = $datos[0];
        $credito = $datos[1];
        $valor = $datos[2];
        $fechaAplica = $datos[3];
        $fechaPago = $datos[4];
        $concepto = $datos[5];
        $medio = $datos[6];
        $entidad = $datos[7];
        $producto = $datos[8];
        $abogadoG = $datos[9];
        $abogado = $datos[10];

        $fechaCargue = date("Y-m-d");
        $asesor = $this->OperativoModel->getclientesdoc($doc, $data['session']['proyecto_activo']);
        if(!isset($asesor[0]['idAsesor'])){
          $asesor[0]['idAsesor'] = 0;
        }
        $this->OperativoModel->savePagoCredivalores($doc, $credito, $valor, $fechaAplica, $fechaPago, $concepto, $medio, $entidad, $producto, $abogadoG, $abogado, $fechaCargue, $asesor[0]['idAsesor'], $data['session']['proyecto_activo']);

      }
      fclose($archivo);

      unlink($filesname);
    }
  }

  $this->utilidades->saveEvent("carga Pagos Credivalores", $data['session']['id'], $data['session']['proyecto_activo']);
  echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/dashboard/" . $data['session']['proyecto_activo'] . "';</script>";
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





/**** ADMINISTRATIVE */
public function camposdinamicos() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();


  $data['campos'] = $this->OperativoModel->getCamposDinamicos($data['session']['proyecto_activo']);

  $this->load->view('templates/header', $data);
  $this->load->view('templates/sidebar', $data);
  $this->load->view('admin/camposdinamicos', $data);
  $this->load->view('templates/footer', $data);
}

public function savefielddinamic() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $campo = $this->utilidades->cleanText($this->input->post("name-field"));

  $this->OperativoModel->saveCamposDinamicos($campo, $data['session']['proyecto_activo']);
  $this->OperativoModel->saveCamposDinamicosHist($campo, $data['session']['proyecto_activo']);



  $data['campos'] = $this->OperativoModel->getCamposDinamicos($data['session']['proyecto_activo']);

  $this->load->view('templates/header', $data);
  $this->load->view('templates/sidebar', $data);
  $this->load->view('admin/camposdinamicos', $data);
  $this->load->view('templates/footer', $data);
}

public function saveoptions() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $campo = $this->input->post("campo");
  $options = $this->input->post("options");

  $this->OperativoModel->saveOptionsField($campo, $options, $data['session']['proyecto_activo']);
}

public function dropcampo() {

  $this->session->valida();
  $data['session'] = $this->session->getSessionData();

  $campo = $this->input->post("campo");
  $options = $this->input->post("options");

  $this->OperativoModel->dropOptionsField($campo, $data['session']['proyecto_activo']);
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
