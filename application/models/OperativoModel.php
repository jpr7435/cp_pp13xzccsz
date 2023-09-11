<?php

/*
* AES_DECRYPT(documento, 'S1cc0l2017!!')
*
* $this -> config -> item('empresa')
*
*
* AES_ENCRYPT('$doc', 'S1cc0l2017!!')
*/

class OperativoModel extends CI_Model {

  private $key;

  public function __construct() {
    $this->key = $this->config->item('encript');
  }

  public function getKey() {
    return $this->key;
  }

  public function getAllIp() {
    $query = $this->db->query("select * from autorizacion");
    return $query->result_array();
  }

  public function permisosespeciales($id) {

    $this->db = $this->load->database('users', TRUE);

    $query = $this->db->query("select * from permisosespeciales where idUsuario = '$id'");
    return $query->result_array();
  }


  public function insertInventarios($doc, $numObliga, $sldCap, $marca, $dias, $marcasFoc, $zona, $fechaNac, $fchCast, $grupo, $sldMora, $database) {
    $this->db = $this->load->database($database, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into inventarios (documento,obligacion,capital_inicial,segmento_inicial,dmora_ini,foco_ini,fch_asignacion,fch_desasignacion,zona,fch_nacimiento,fch_castigo,grupo, mora_inicial,nuip, radicado)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),AES_ENCRYPT('$numObliga',  '" . $this->key . "'),'$sldCap','$marca','$dias','$marcasFoc','$fecha','','$zona','$fechaNac','$fchCast','$grupo','$sldMora','$doc','$numObliga' ) on duplicate key update grupo = '$grupo', zona = '$zona', fch_nacimiento = '$fechaNac'");
  }

  public function insertMorosidad($documento, $entidad, $entidad_obligacion, $producto, $obligacion, $saldoenMora, $capitalMora, $diasMora, $diasMoraSistema, $fch_factura, $edadMora, $moraSinIntMoraPagada, $montoIntCuotaenMora, $montoIntCuotaenMoraPagada, $montoComisionCuotaenMora, $montoComisionCuotaenMora2, $montoSegCuotaenMora, $montoSegCuotaenMoraPagada, $montoSegIncCuotaenMora, $montoSegIncCuotaenMoraPagada, $montootroCampoCuotaenMora, $montootroCampoCuotaenMoraPagada, $causaEstado, $estadoCuota, $fch_act_pago, $montoPago, $fch_ingreso_cuota, $fch_castigado_cuota, $database) {
    $this->db = $this->load->database($database, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into morosidad_edades (documento,entidad,entidad_obligacion,producto,obligacion,saldoenMora,capitalMora,diasMora,diasMoraSistema,fch_factura,edadMora,moraSinIntMoraPagada,montoIntCuotaenMora,montoIntCuotaenMoraPagada,montoComisionCuotaenMora,montoComisionCuotaenMora2,montoSegCuotaenMora,montoSegCuotaenMoraPagada,montoSegIncCuotaenMora,montoSegIncCuotaenMoraPagada,montootroCampoCuotaenMora,montootroCampoCuotaenMoraPagada,causaEstado,estadoCuota,fch_act_pago,montoPago,fch_ingreso_cuota,fch_castigado_cuota,nuip,radicado)"
    . "values (AES_ENCRYPT('$documento',  '" . $this->key . "'),'$entidad','$entidad_obligacion','$producto',AES_ENCRYPT('$obligacion',  '" . $this->key . "'),'$saldoenMora','$capitalMora','$diasMora','$diasMoraSistema','$fch_factura','$edadMora','$moraSinIntMoraPagada','$montoIntCuotaenMora','$montoIntCuotaenMoraPagada','$montoComisionCuotaenMora','$montoComisionCuotaenMora2','$montoSegCuotaenMora','$$montoSegCuotaenMoraPagada','$$montoSegIncCuotaenMora','$montoSegIncCuotaenMoraPagada','$montootroCampoCuotaenMora','$montootroCampoCuotaenMoraPagada','$causaEstado','$estadoCuota','$fch_act_pago','$montoPago','$fch_ingreso_cuota','$fch_castigado_cuota','$documento','$obligacion') on duplicate key update nuip = '$documento'");
  }

  public function insertClientesbcsc($doc, $entidad, $sexo, $estado, $nombre, $fechaproxAcc, $fechaNac, $ultimoContacto, $definicionUsuario, $scoring, $estrategia, $entraaestrategia, $salidaestrategia, $grupo, $obligaciones, $fechaasignacionusuario, $ultimousuario, $calificacion, $visitasrotas, $gestContDirect, $gestContInd, $ultimoefecto, $marcadelcliente, $fchexpirasig, $vectormax, $vectoract, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into 10_clientes (documento,entidad,sexo,estado,nombre,fechaProximaAccion,fechaNacimiento,ultimoContacto,definicionusuario,scoring,estrategia,entraAestrategia,salidadeEstrategia,grupo,obligaciones,fechaAsignacionUsuario,ultimoUsuario,calificacion,visitasRotas,gestionesContactoDirecto,gestionesContactoIndirecto,ultimoEfecto,marcadelCliente,fechadeexpiraciondelaasignacion,vectorMaximo,vectorActual,saldoPareto,idAsesor,idResultado,ultimaGestion,ciudad,fechaIngreso,activo,nuip)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$sexo','$estado','$nombre','$fechaproxAcc','$fechaNac','$ultimoContacto','$definicionUsuario','$scoring','$estrategia','$entraaestrategia','$salidaestrategia','$grupo','$obligaciones','$fechaasignacionusuario','$ultimousuario','$calificacion','$visitasrotas','$gestContDirect','$gestContInd','$ultimoefecto','','$fchexpirasig','$vectormax','$vectoract','0','4020','0','0000-00-00','','$fecha','1','$doc') on duplicate key update estado = '$estado', grupo = '$grupo', fechaProximaAccion = '$fechaproxAcc',ultimoContacto ='$ultimoContacto',entraAestrategia = '$entraaestrategia', salidadeEstrategia ='$salidaestrategia',obligaciones = '$obligaciones',ultimoUsuario = '$ultimousuario',ultimoEfecto = '$ultimoefecto',fechadeexpiraciondelaasignacion='$fchexpirasig',vectorMaximo='$vectormax',vectorActual = '$vectoract',activo = '1'");
  }


  public function insertClientespic($doc, $entidad, $sexo, $estado, $nombre, $fechaproxAcc, $fechaNac, $ultimoContacto, $definicionUsuario, $scoring, $estrategia, $entraaestrategia, $salidaestrategia, $grupo, $obligaciones, $fechaasignacionusuario, $ultimousuario, $calificacion, $visitasrotas, $gestContDirect, $gestContInd, $ultimoefecto, $marcadelcliente, $fchexpirasig, $vectormax, $vectoract, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into 10_clientes (documento,entidad,sexo,estado,nombre,fechaProximaAccion,fechaNacimiento,ultimoContacto,definicionusuario,scoring,estrategia,entraAestrategia,salidadeEstrategia,grupo,obligaciones,fechaAsignacionUsuario,ultimoUsuario,calificacion,visitasRotas,gestionesContactoDirecto,gestionesContactoIndirecto,ultimoEfecto,marcadelCliente,fechadeexpiraciondelaasignacion,vectorMaximo,vectorActual,saldoPareto,idAsesor,idResultado,ultimaGestion,ciudad,fechaIngreso,activo,nuip)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$sexo','$estado','$nombre','$fechaproxAcc','$fechaNac','$ultimoContacto','$definicionUsuario','$scoring','$estrategia','$entraaestrategia','$salidaestrategia','$grupo','$obligaciones','$fechaasignacionusuario','$ultimousuario','$calificacion','$visitasrotas','$gestContDirect','$gestContInd','$ultimoefecto','','$fchexpirasig','$vectormax','$vectoract','0','4020','0','0000-00-00','','$fecha','1','$doc') on duplicate key update estado = '$estado', grupo = '$grupo', fechaProximaAccion = '$fechaproxAcc',ultimoContacto ='$ultimoContacto',entraAestrategia = '$entraaestrategia', salidadeEstrategia ='$salidaestrategia',obligaciones = '$obligaciones',ultimoUsuario = '$ultimousuario',ultimoEfecto = '$ultimoefecto',fechadeexpiraciondelaasignacion='$fchexpirasig',vectorMaximo='$vectormax',vectorActual = '$vectoract',activo = '1'");
  }


  public function insertDireccionesbcsc($doc, $entidad, $dir, $zona, $ciudad, $dpto, $tipoDir, $estrato, $pais, $estado, $dircorresp, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into 13_direcciones (documento,entidad,direccion,zona,idCiudad,departamento,tipoDireccion,estrato,pais,estado,direccionesparaCorrespondencia,barrio,idActivo,agregado)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$dir','$zona','$ciudad','$dpto','$tipoDir','$estrato','$pais','$estado','$dircorresp','0','1','0') on duplicate key update estado = '$estado'");
  }

  public function borraEvolutivo($slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("truncate table evolutivo;");
  }

  public function borraAsignacion($slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("truncate table asignacion_bbva;");
  }

  public function uploadEvolutivo($tipo_documento,	$identificacion,	$nombre,	$territorial_mayor,	$zona_mayor,	$centro_mayor,	$departamento_mayor,	$banca,	$calificacion,	$califica7,	$cal_subjet,	$tipologia_gestion_cli,	$alternativa_normalizacion,	$tipo_reparto,	$tipo_cobro,	$tipo_judicial,	$tipo_judicial_actual,	$refis_cliente,	$marca_1,	$tipo_franja,	$franja_gestion,	$dias_pareto,	$capital_pareto,
    $cap_pareto_act,	$cap_pareto_tp_car,	$capital_vigente_afectado,	$marca_vip,	$cons_prod2,	$obligacion,	$fecha_formalizacion,	$fecha_final,	$porc_max_condona,	$valor_desembolso,	$plazo,	$tasa_ea,	$producto,	$tipo_cartera,	$tipo_producto,	$subproducto,	$linea_producto,	$linea_producto_c,	$linea_subproducto,	$marca_refis,	$normalizacion,	$marca,	$fecha_mora,	$dias_vencidos,	$franja_obligacion,
    $estado_inicial_objetivo,	$valor_mora,	$capital_activo,	$saldo_total,	$reest_particulares,	$reestructurados_comercial,	$reestructurados_leasing,	$rediferidos,	$congelada,	$provision_capital,	$provision_interes,	$total_intereses,	$intereses_contg,	$cxc_tdc,	$tipo_libranza,	$cod_em,	$convenio,	$segmento_lbz,	$indicador_actual,	$causal_no_descuento,	$cuota_ini,	$cuota_actual,	$porcentaje,	$guion_libranza,	$cuotas_en_corr,
    $cuotas_a_corr,	$efectiva_nueva,	$plazo_ini,	$plazo_res,	$plazo_trans,	$plazo_requerido,	$plazo_total,	$t_cuotas_corr,	$alternativa_norm,	$etapa_procesal,	$abogado_externo,	$detalle_tipo_judicial,	$macro_etapa_matriz,	$situacion_gestion,	$capitala,	$valormor,	$diasven,	$estado,	$dias_actuales,	$franja_obligacion_saneamiento,	$estado_actual_objetivo,	$estado_cartera,	$estado_evaluacion,	$evaluacion_actual_estado,	$prioridad_mes,
    $fecha_vto_actual,	$dia_vto,	$franja_obligacion_actual,	$franja_riesgo,	$proximo_a_vencer,	$tipo_gestor,	$gestor,	$responsable,	$codigo_exclusion,	$codigo_estrategia,	$estrategia_comercial,	$forzaje,	$estado_gest,	$gestion,	$efectividad_gestion,	$actividad_principal,	$fecha_actividad_principal,	$n_actividades,	$resultado_contacto,	$motivo_no_pago,	$mecanismo_norm,	$etapa_norm,	$ultima_actividad,	$fecha_compromiso_pago,	$fecha_ult_actividad,
    $texto_gestion,	$fecha_venc_pdp,	$detalle_gestor,	$detalle_marca,	$detalle_responsable,	$detalle_tipo_gestor,	$tipo_garantia,	$tipo_activo,	$marca_garantia,	$max_cal_gtia,	$estado_gtia_fondos,	$porcentaje_fng,	$indicativo,	$telefono_ubicacion1,	$fecha_asignacion,	$centro_gestor,	$nombre_centro_gestor,	$tipo_reparto_1,	$territorial,	$probabilidad_pago,	$probabilidad_pago_py,	$puntaje_sector,	$tipo_persona,	$segmento_ii,	$segmentacion_asignacion,
    $semana,	$castigos,	$tipo_attrition,	$grupo,	$waste_management,	$contactabilidad,	$c_collection_score,	$estado_cuenta,	$entidad_embargo,	$seguro_desempleo,	$numero_poliza,	$cliente_fallecido,	$estado_reclamacion,	$base_ifrs9,	$saldo_activo_ifrs9,	$provision_total_ifrs9,	$provision_faltante_ifrs9, $stage_final_ifrs9, $campaña,	$franja_obligacion_mia,	$franja_obligacion_actual_mia,	$indicador_mia,	$estado_aplicación_alivio,	$fecha_solicitud_alivio,	$contactado,	$acepta_alivio,
    $gestor_alivio,	$plazo_gracia, $status_aplicacion,	$cliente_con_linea_comercial,	$segmento_circular_007,	$linea_problema,	$ofertable_alivio,	$fecha_final_alivio,	$segmento_emerge,	$prioridad_gestion_emerge,	$motivo_gestion_emerge,	$foco_gestion,	$fecha_max_contacto,	$celular_cir_022,	$correo_electronico_022,	$estado_contacto_pad,	$estado_aplicacion_red,	$fecha_aplicacion,	$franja_gestion_actual,	$meses_vencidos, $valor_primer_recibo, $fecha, $slug){
    $this->db = $this->load->database($slug, TRUE);

    $query = $this->db->query("insert into evolutivo (tipo_documento,identificacion,nombre,territorial_mayor,zona_mayor,centro_mayor,departamento_mayor,banca,calificacion,califica7,cal_subjet,tipologia_gestion_cli,alternativa_normalizacion,tipo_reparto,tipo_cobro,tipo_judicial,tipo_judicial_actual,refis_cliente,marca_1,tipo_franja,franja_gestion,dias_pareto,capital_pareto,cap_pareto_act,cap_pareto_tp_car,capital_vigente_afectado,marca_vip,cons_prod2,obligacion,fecha_formalizacion,fecha_final,porc_max_condona,valor_desembolso,
    plazo,tasa_ea,producto,tipo_cartera,tipo_producto,subproducto,linea_producto,linea_producto_c,linea_subproducto,marca_refis,normalizacion,marca,fecha_mora,dias_vencidos,franja_obligacion,estado_inicial_objetivo,valor_mora,capital_activo,saldo_total,reest_particulares,reestructurados_comercial,reestructurados_leasing,rediferidos,congelada,provision_capital,provision_interes,total_intereses,intereses_contg,cxc_tdc,tipo_libranza,cod_em,convenio,segmento_lbz,indicador_actual,
    causal_no_descuento,cuota_ini,cuota_actual,porcentaje,guion_libranza,cuotas_en_corr,cuotas_a_corr,efectiva_nueva,plazo_ini,plazo_res,plazo_trans,plazo_requerido,plazo_total,t_cuotas_corr,alternativa_norm,etapa_procesal,abogado_externo,detalle_tipo_judicial,macro_etapa_matriz,situacion_gestion,capitala,valormor,diasven,estado,dias_actuales,franja_obligacion_saneamiento,estado_actual_objetivo,estado_cartera,estado_evaluacion,evaluacion_actual_estado,prioridad_mes,fecha_vto_actual,
    dia_vto,franja_obligacion_actual,franja_riesgo,proximo_a_vencer,tipo_gestor,gestor,responsable,codigo_exclusion,codigo_estrategia,estrategia_comercial,forzaje,estado_gest,gestion,efectividad_gestion,actividad_principal,fecha_actividad_principal,n_actividades,resultado_contacto,motivo_no_pago,mecanismo_norm,etapa_norm,ultima_actividad,fecha_compromiso_pago,fecha_ult_actividad,texto_gestion,fecha_venc_pdp,detalle_gestor,detalle_marca,detalle_responsable,detalle_tipo_gestor,tipo_garantia,
    tipo_activo,marca_garantia,max_cal_gtia,estado_gtia_fondos,porcentaje_fng,indicativo,telefono_ubicacion1,fecha_asignacion,centro_gestor,nombre_centro_gestor,tipo_reparto_1,territorial,probabilidad_pago,probabilidad_pago_py,puntaje_sector,tipo_persona,segmento_ii,segmentacion_asignacion,semana,castigos,tipo_attrition,grupo,waste_management,contactabilidad,c_collection_score,estado_cuenta,entidad_embargo,seguro_desempleo,numero_poliza,cliente_fallecido,estado_reclamacion,base_ifrs9,
    saldo_activo_ifrs9,provision_total_ifrs9,provision_faltante_ifrs9, stage_final_ifrs9,
    campana, franja_obligacion_mia, franja_obligacion_actual_mia,indicador_mia,estado_aplicacion_alivio,fecha_solicitud_alivio,contactado,acepta_alivio,gestor_alivio,plazo_gracia,status_aplicacion,cliente_con_linea_comercial,segmento_circular_007,linea_problema,ofertable_alivio,fecha_final_alivio,segmento_emerge,prioridad_gestion_emerge,motivo_gestion_emerge,foco_gestion,fecha_max_contacto,celular_cir_022,correo_electronico_022,
    estado_contacto_pad,estado_aplicacion_red,fecha_aplicacion,franja_gestion_actual,meses_vencidos, valor_primer_recibo, documento,credito) values ('$tipo_documento',	AES_ENCRYPT('$identificacion',  '" . $this->key . "'),	'$nombre',	'$territorial_mayor',	'$zona_mayor',	'$centro_mayor',	'$departamento_mayor',	'$banca',	'$calificacion',	'$califica7',	'$cal_subjet',	'$tipologia_gestion_cli',	'$alternativa_normalizacion',	'$tipo_reparto',	'$tipo_cobro',	'$tipo_judicial',	'$tipo_judicial_actual',
    '$refis_cliente',	'$marca_1',	'$tipo_franja',
    '$franja_gestion',
    	'$dias_pareto',	'$capital_pareto',	'$cap_pareto_act',	'$cap_pareto_tp_car',	'$capital_vigente_afectado',	'$marca_vip',	'$cons_prod2',	AES_ENCRYPT('$obligacion',  '" . $this->key . "'),	'$fecha_formalizacion',	'$fecha_final',	'$porc_max_condona',	'$valor_desembolso',	'$plazo',	'$tasa_ea',	'$producto',	'$tipo_cartera',	'$tipo_producto',	'$subproducto',	'$linea_producto',	'$linea_producto_c',	'$linea_subproducto',	'$marca_refis',	'$normalizacion',	'$marca',	'$fecha_mora',
      '$dias_vencidos','$franja_obligacion',	'$estado_inicial_objetivo', '$valor_mora',
    	'$capital_activo',	'$saldo_total',	'$reest_particulares',	'$reestructurados_comercial',	'$reestructurados_leasing',	'$rediferidos',	'$congelada',	'$provision_capital',	'$provision_interes',	'$total_intereses',	'$intereses_contg',	'$cxc_tdc',	'$tipo_libranza',	'$cod_em',	'$convenio',	'$segmento_lbz',	'$indicador_actual',	'$causal_no_descuento',	'$cuota_ini',	'$cuota_actual',	'$porcentaje',	'$guion_libranza',	'$cuotas_en_corr',	'$cuotas_a_corr',	'$efectiva_nueva',	'$plazo_ini',
      '$plazo_res',	'$plazo_trans',	'$plazo_requerido',	'$plazo_total',
      '$t_cuotas_corr',	'$alternativa_norm',
    	'$etapa_procesal',	'$abogado_externo',	'$detalle_tipo_judicial',	'$macro_etapa_matriz',	'$situacion_gestion',	'$capitala',	'$valormor',	'$diasven',	'$estado',	'$dias_actuales',	'$franja_obligacion_saneamiento',	'$estado_actual_objetivo',	'$estado_cartera',	'$estado_evaluacion',	'$evaluacion_actual_estado',	'$prioridad_mes',	'$fecha_vto_actual',	'$dia_vto',	'$franja_obligacion_actual',	'$franja_riesgo',	'$proximo_a_vencer',	'$tipo_gestor',
      '$gestor',	'$responsable',
    	'$codigo_exclusion',	'$codigo_estrategia',	'$estrategia_comercial',	'$forzaje',	'$estado_gest',	'$gestion',	'$efectividad_gestion',	'$actividad_principal',	'$fecha_actividad_principal',	'$n_actividades',	'$resultado_contacto',	'$motivo_no_pago',	'$mecanismo_norm',	'$etapa_norm',	'$ultima_actividad',	'$fecha_compromiso_pago',	'$fecha_ult_actividad',	'$texto_gestion',	'$fecha_venc_pdp',	'$detalle_gestor',	'$detalle_marca',	'$detalle_responsable',	'$detalle_tipo_gestor',
    	'$tipo_garantia',	'$tipo_activo',	'$marca_garantia',	'$max_cal_gtia',	'$estado_gtia_fondos',	'$porcentaje_fng',	'$indicativo',	'$telefono_ubicacion1',
      '$fecha_asignacion',
    	'$centro_gestor',	'$nombre_centro_gestor',	'$tipo_reparto_1',	'$territorial',	'$probabilidad_pago',	'$probabilidad_pago_py',	'$puntaje_sector',	'$tipo_persona',	'$segmento_ii',	'$segmentacion_asignacion',	'$semana',	'$castigos',	'$tipo_attrition',	'$grupo',	'$waste_management',	'$contactabilidad',	'$c_collection_score',	'$estado_cuenta',	'$entidad_embargo',	'$seguro_desempleo',	'$numero_poliza',	'$cliente_fallecido',	'$estado_reclamacion',	'$base_ifrs9',
      '$saldo_activo_ifrs9',
    	'$provision_total_ifrs9',	'$provision_faltante_ifrs9', '$stage_final_ifrs9',	'$campaña',	'$franja_obligacion_mia',	'$franja_obligacion_actual_mia',	'$indicador_mia',	'$estado_aplicación_alivio',	'$fecha_solicitud_alivio',	'$contactado',	'$acepta_alivio',	'$gestor_alivio',	'$plazo_gracia',	'$status_aplicacion',	'$cliente_con_linea_comercial',	'$segmento_circular_007',	'$linea_problema',	'$ofertable_alivio',	'$fecha_final_alivio',	'$segmento_emerge',	'$prioridad_gestion_emerge',
      '$motivo_gestion_emerge',
    	'$foco_gestion',	'$fecha_max_contacto',	'$celular_cir_022',	'$correo_electronico_022',	'$estado_contacto_pad',	'$estado_aplicacion_red',	'$fecha_aplicacion',	'$franja_gestion_actual',	'$meses_vencidos', '$valor_primer_recibo', '$identificacion', '$obligacion');");
  }

  public function insertDireccionespic($doc, $entidad, $dir, $zona, $ciudad, $dpto, $tipoDir, $estrato, $pais, $estado, $dircorresp, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into 13_direcciones (documento,entidad,direccion,zona,idCiudad,departamento,tipoDireccion,estrato,pais,estado,direccionesparaCorrespondencia,barrio,idActivo,agregado)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$dir','$zona','$ciudad','$dpto','$tipoDir','$estrato','$pais','$estado','$dircorresp','0','1','0') on duplicate key update estado = '$estado'");
  }




  public function insertObligacionesbcsc($doc, $entidad, $subEntidad, $producto, $numObliga, $fchAper, $plazo, $diaFact, $dias, $fchPago, $fchVto, $fchPag, $fchCast, $fchAct, $oficina, $sldOrig, $sldCap, $intCtes, $sldTotal, $vlrCuota, $opCompra, $capMora, $intMora, $carCob, $cantDisp, $sldMora, $tasaInt, $vlrSeg, $vlrProv, $califOblig, $zona, $region, $ciudad, $comFNG, $otros, $marcasFoc, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into 9_creditos (documento,obligacion,entidad,subEntidad,producto,fechaApertura,plazo,diaFacturacion,diasMora,fechaPago,fechaVencimiento,frecuenciaPago,fechaCastigo,fechaActualizacion,oficina,saldoOriginal,saldoACapital,interesesSobreSaldo,saldoTotal,valorCuota,opcionCompra,capitalEnMora,interesesMora,valorCuotaCargoCobranzas,cantidadDisputada,saldoMora,valorSeguro,tasaInteres,valorProvisionado,calificacionDeObligacion,zona,region,ciudad,comisionesFNGFogafin,otrosCargos,marcasFocalizacion,fechacargue,activo,nuip,radicado)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),AES_ENCRYPT('$numObliga',  '" . $this->key . "'),'$entidad','$subEntidad','$producto','$fchAper','$plazo','$diaFact','$dias','$fchPago','$fchVto','$fchPag','$fchCast','$fchAct','$oficina','$sldOrig','$sldCap','$intCtes','$sldTotal','$vlrCuota','$opCompra','$capMora','$intMora','$carCob','$cantDisp','$sldMora','$vlrSeg','$tasaInt','$vlrProv','$califOblig','$zona','$region','$ciudad','$comFNG','$otros','$marcasFoc','$fecha','1','$doc','$numObliga') on duplicate key update diasMora = '$dias', fechaActualizacion = '$fchAct', saldoACapital = '$sldCap', interesesSobreSaldo = '$intCtes', saldoTotal = '$sldTotal', capitalEnMora = '$capMora', interesesMora = '$intMora', valorCuotaCargoCobranzas = '$carCob', cantidadDisputada = '$cantDisp', saldoMora = '$sldMora', valorSeguro ='$vlrSeg', tasaInteres = '$tasaInt', valorProvisionado = '$vlrProv', calificacionDeObligacion = '$califOblig', marcasFocalizacion = '$marcasFoc', fechaCastigo = '$fchCast', activo = '1';");
  }

  public function insertObligacionespic($doc, $entidad, $subEntidad, $producto, $numObliga, $fchAper, $plazo, $diaFact, $dias, $fchPago, $fchVto, $fchPag, $fchCast, $fchAct, $oficina, $sldOrig, $sldCap, $intCtes, $sldTotal, $vlrCuota, $opCompra, $capMora, $intMora, $carCob, $cantDisp, $sldMora, $tasaInt, $vlrSeg, $vlrProv, $califOblig, $zona, $region, $ciudad, $comFNG, $otros, $marcasFoc, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into 9_creditos (documento,obligacion,entidad,subEntidad,producto,fechaApertura,plazo,diaFacturacion,diasMora,fechaPago,fechaVencimiento,frecuenciaPago,fechaCastigo,fechaActualizacion,oficina,saldoOriginal,saldoACapital,interesesSobreSaldo,saldoTotal,valorCuota,opcionCompra,capitalEnMora,interesesMora,valorCuotaCargoCobranzas,cantidadDisputada,saldoMora,valorSeguro,tasaInteres,valorProvisionado,calificacionDeObligacion,zona,region,ciudad,comisionesFNGFogafin,otrosCargos,marcasFocalizacion,fechacargue,activo,nuip,radicado)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),AES_ENCRYPT('$numObliga',  '" . $this->key . "'),'$entidad','$subEntidad','$producto','$fchAper','$plazo','$diaFact','$dias','$fchPago','$fchVto','$fchPag','$fchCast','$fchAct','$oficina','$sldOrig','$sldCap','$intCtes','$sldTotal','$vlrCuota','$opCompra','$capMora','$intMora','$carCob','$cantDisp','$sldMora','$vlrSeg','$tasaInt','$vlrProv','$califOblig','$zona','$region','$ciudad','$comFNG','$otros','$marcasFoc','$fecha','1','$doc','$numObliga') on duplicate key update diasMora = '$dias', fechaActualizacion = '$fchAct', saldoACapital = '$sldCap', interesesSobreSaldo = '$intCtes', saldoTotal = '$sldTotal', capitalEnMora = '$capMora', interesesMora = '$intMora', valorCuotaCargoCobranzas = '$carCob', cantidadDisputada = '$cantDisp', saldoMora = '$sldMora', valorSeguro ='$vlrSeg', tasaInteres = '$tasaInt', valorProvisionado = '$vlrProv', calificacionDeObligacion = '$califOblig', marcasFocalizacion = '$marcasFoc', fechaCastigo = '$fchCast', activo = '1';");
  }

  public function loadArchivo($ruta, $data) {

      $this->db = $this->load->database($data, TRUE);
      $query = $this->db->query("load data local infile '$ruta' into table evolutivo fields terminated by ';' optionally enclosed by '\"' lines terminated by '\\r\\n';");
  }


  public function loadArchivoAsignacion($ruta, $data) {

    $this->db = $this->load->database($data, TRUE);
    $query = $this->db->query("load data local infile '$ruta' into table asignacion_bbva fields terminated by ';' optionally enclosed by '\"' lines terminated by '\\r\\n';");
}


  public function encriptarEvolutivo($data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query("update evolutivo set identificacion = AES_ENCRYPT(documento, '" . $this->key . "'), obligacion = AES_ENCRYPT(credito, '" . $this->key . "');");
  }

  public function encriptarAsignaccion($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("update asignacion_bbva set identificacion = AES_ENCRYPT(nuip, '" . $this->key . "'), obligacion = AES_ENCRYPT(radicado, '" . $this->key . "');");
}




  public function insertPagosbcsc($doc, $entidad, $fchPago, $numObliga, $producto, $vlrPago, $tipoPago, $tipoTrans, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into pagos (identificacion,entidad,fecha,obligacion,producto,valor,tipodePago,tipoTransaccion,idAsesor,nuip,radicado)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$fchPago',AES_ENCRYPT('$numObliga',  '" . $this->key . "'),'$producto','$vlrPago','$tipoPago','$tipoTrans','4020','$doc','$numObliga') on duplicate key update fecha = '$fchPago'");
  }

  public function insertPagospic($doc, $entidad, $fchPago, $numObliga, $producto, $vlrPago, $tipoPago, $tipoTrans, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into pagos (identificacion,entidad,fecha,obligacion,producto,valor,tipodePago,tipoTransaccion,idAsesor,nuip,radicado)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$fchPago',AES_ENCRYPT('$numObliga',  '" . $this->key . "'),'$producto','$vlrPago','$tipoPago','$tipoTrans','4020','$doc','$numObliga') on duplicate key update fecha = '$fchPago'");
  }

  public function savePagoCredivalores($doc, $credito, $valor, $fechaAplica, $fechaPago, $concepto, $medio, $entidad, $producto, $abogadoG, $abogado, $fechaCargue, $asesor, $data) {
    $this->db = $this->load->database($data, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into pagos (identificacion, obligacion, valor, fecha_aplicacion_recaudo, fecha, concepto_recaudo, medio_pago, entidad, producto, abogado_gc, abogado, idasesor, fechacarguepolaris, nuip, radicado)"
    . "values (AES_ENCRYPT('$doc','" .$this->key."'), AES_ENCRYPT('$credito','" .$this->key."'), '$valor', '$fechaAplica', '$fechaPago', '$concepto', '$medio', '$entidad', '$producto', '$abogadoG', '$abogado', '$asesor', '$fechaCargue', '$doc', '$credito') on duplicate key update fecha = '$fechaPago';");
  }

  public function insertGestionpic($doc, $entidad,$usuario,$fechGestion,$accion,$observacion,$proxGestion,$telefono,$grupo,$efecto,$entidadSec,$numOblig,$proOblig,$motivoNo,$slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into gestionIcs (documento,entidad,usuario,fechaGestion,accion,observacion,proximaGestion,telefono,grupo,efecto,contacto,entidadSecundaria,obligacion,productoObligacion,motivoNoPago)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$usuario','$fechGestion','$accion','$observacion','$proxGestion','$telefono','$grupo','$efecto','$contacto','$entidadSec','$numOblig','$proOblig','$motivoNo') on duplicate key update contacto = '$contacto'");
  }

  public function insertCodeudorespic($doc,$entidad,$docCod,$nommbreCod,$entidad2,$prodOblig,$numOblig,$slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into codeudores (documento,entidad,documentoCode,nombreCode,entidad2,producto,obligacionRespaldada)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$docCod','$nommbreCod','$entidad2','$prodOblig','$numOblig') on duplicate key update entidad2 = '$entidad2'");
  }


  public function insertDesasignados($doc, $entidad, $credito, $causaEstado, $fecha, $diasMora, $fechaPago, $tipoPago, $tipoTrans, $valorPago, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into desasignaciones (documento,entidad,obligacion,causaEstado,fecha,diasdeMora,fechadePago,tipoPago,tipoTransaccion,valordePago,nuip,radicado)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad',AES_ENCRYPT('$credito',  '" . $this->key . "'),'$causaEstado','$fecha','$diasMora','$fechaPago','$tipoPago','$tipoTrans','$valorPago','$doc','$credito') on duplicate key update causaEstado = '$causaEstado'");
  }

  public function insertReferencias($doc, $nombreReferencia, $relacion, $ciudad, $indicativo, $telefonoFijo, $telefonoCelular, $grupo, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into referencias (documento,nombreReferencia,relacion,ciudad,indicativo,telefonoFijo,telefonoCelular,grupo,nuip)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$nombreReferencia','$relacion','$ciudad','$indicativo','$telefonoFijo','$telefonoCelular','$grupo','$doc') on duplicate key update nuip = '$$doc'");
  }

  public function insertPromesasbcsc($doc, $entidad, $fchVto, $vlrACanc, $estado, $numObliga, $producto, $entSecundaria, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into promesas (documento,entidad,fechaVencimiento,valoraCancelar,estado,obligacion,producto,entidadSecundaria,nuip,radicado)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$fchVto','$vlrACanc','$estado',AES_ENCRYPT('$numObliga',  '" . $this->key . "'),'$producto','$entSecundaria','$doc','$numObliga' ) on duplicate key update nuip = '$doc'");
  }

  public function insertPromesaspic($doc, $entidad, $fchVto, $vlrACanc, $estado, $numObliga, $producto, $entSecundaria, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into promesas (documento,entidad,fechaVencimiento,valoraCancelar,estado,obligacion,producto,entidadSecundaria,nuip,radicado)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$fchVto','$vlrACanc','$estado',AES_ENCRYPT('$numObliga',  '" . $this->key . "'),'$producto','$entSecundaria','$doc','$numObliga' ) on duplicate key update nuip = '$doc'");
  }


  public function desactivaTareas($database) {
    $this->db = $this->load->database($database, TRUE);

    $query = $this->db->query("update 15_tareas a, 10_clientes b set a.idResultado = '666' where a.documento = b.documento and b.activo = '0'");
  }

  public function desactivaProgramados($database) {
    $this->db = $this->load->database($database, TRUE);

    $query = $this->db->query("update 17_programallamadas a, 10_clientes b set a.estado = '1' where a.documento = b.documento and b.activo = '0'");
  }

  public function insertProcesosJuridicosbcsc($doc, $entidad, $proceso, $codigo, $abogado, $juzgado, $liquidacion, $pagoReal, $codFolio, $codExp, $observ, $numCuenta, $entSecundaria, $producto, $camp1, $camp2, $camp3, $estadoEtapa, $fchCreacion, $fchAsigAbog, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into procesosJuridicos (documento,entidad,proceso,codigo,abogado,juzgado,liquidacion,pagoReal,codigoFolio,codigoExpediente,observacion,numerodeCuenta,entidadSecundaria,producto,campopordefinir1,campopordefinir2,campopordefinir3,estadoEtapa,fechadeCreacion,fechaAsignacionabogado)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$proceso','$codigo','$abogado','$juzgado','$liquidacion','$pagoReal','$codFolio','$codExp','$observ','$numCuenta','$entSecundaria','$producto','$camp1','$camp2','$camp3','$estadoEtapa','$fchCreacion','$fchAsigAbog')");
  }

  public function insertGestionJuridicabcsc($doc, $entidad, $proceso, $codigo, $estado, $fchEntrada, $fchSalida, $observ, $entSecundaria, $producto, $codEstado, $estadoEatapa, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into gestionJuridica (documento,entidad,proceso,codigo,estado,fechaEntradaestado,fechaSalidaestado,observacion,entidadSecundaria,producto,codigodelEstado,estadoEtapa)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$proceso','$codigo','$estado','$fchEntrada','$fchSalida','$observ','$entSecundaria','$producto','$codEstado','$estadoEatapa')");
  }

  public function insertVisitasbcsc($doc, $entidad, $persVisita, $tipoDir, $direccion, $fchSolic, $fchVisita, $visitEfe, $destVisita, $timeIni, $timeFin, $estadoVisi, $efectoVisi, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into visitas_ics (documento,entidad,personaAvisitar,tipoDireccion,direccion,fechaSolicitud,fechaVisita,visitaEfectuada,destinoVisita,tiempodeInicio,tiempoFinal,estadoVisita,efectodelaVisita)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$persVisita','$tipoDir','$direccion','$fchSolic','$fchVisita','$visitEfe','$destVisita','$timeIni','$timeFin','$estadoVisi','$efectoVisi')");
  }

  public function insertVisitaspic($doc, $entidad, $persVisita, $tipoDir, $direccion, $fchSolic, $fchVisita, $visitEfe, $destVisita, $timeIni, $timeFin, $estadoVisi, $efectoVisi, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into visitas_ics (documento,entidad,personaAvisitar,tipoDireccion,direccion,fechaSolicitud,fechaVisita,visitaEfectuada,destinoVisita,tiempodeInicio,tiempoFinal,estadoVisita,efectodelaVisita)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$persVisita','$tipoDir','$direccion','$fchSolic','$fchVisita','$visitEfe','$destVisita','$timeIni','$timeFin','$estadoVisi','$efectoVisi')");
  }



  public function insertMarcasClientebcsc($doc, $entidad, $chardefined1, $chardefined2, $chardefined3, $chardefined4, $chardefined5, $chardefined6, $chardefined7, $chardefined8, $chardefined9, $chardefined10, $numberdefined1, $datedefined1, $datedefined2, $datedefined3, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into marcasCliente (doumento,entidad,Char_defined1,Char_defined2,Char_defined3,Char_defined4,Char_defined5,Char_defined6,Char_defined7,Char_defined8,Char_defined9,Char_defined10,Number_defined1,Date_defined1,Date_defined2,Date_defined3,nuip)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad','$chardefined1','$chardefined2','$chardefined3','$chardefined4','$chardefined5','$chardefined6','$chardefined7','$chardefined8','$chardefined9','$chardefined10','$numberdefined1','$datedefined1','$datedefined2','$datedefined3','$doc') on duplicate key update nuip = '$doc'");
  }

  public function insertMarcasObligacionbcsc($doc, $entidad, $credito, $producto, $entidad2, $chardefined1, $chardefined2, $chardefined3, $chardefined4, $chardefined5, $chardefined6, $chardefined7, $chardefined8, $chardefined9, $chardefined10, $numberdefined1, $numberdefined2, $numberdefined3, $numberdefined4, $numberdefined5, $numberdefined6, $numberdefined7, $numberdefined8, $numberdefined9, $numberdefined10, $datedefined1, $datedefined2, $datedefined3, $datedefined4, $datedefined5, $datedefined6, $datedefined7, $datedefined8, $datedefined9, $datedefined10, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("insert into marcasObligacion (documento,entidad,obligacion,producto,entidad2,char_defined1,char_defined2,char_defined3,char_defined4,char_defined5,char_defined6,char_defined7,char_defined8,char_defined9,char_defined10,number_defined1,number_defined2,number_defined3,number_defined4,number_defined5,number_defined6,number_defined7,number_defined8,number_defined9,number_defined10,date_defined1,date_defined2,date_defined3,date_defined4,date_defined5,date_defined6,date_defined7,date_defined8,date_defined9,date_defined10,nuip,radicado)"
    . "values (AES_ENCRYPT('$doc',  '" . $this->key . "'),'$entidad',AES_ENCRYPT('$credito',  '" . $this->key . "'),'$producto','$entidad2','$chardefined1','$chardefined2','$chardefined3','$chardefined4','$chardefined5','$chardefined6','$chardefined7','$chardefined8','$chardefined9','$chardefined10','$numberdefined1','$numberdefined2','$numberdefined3','$numberdefined4','$numberdefined5','$numberdefined6','$numberdefined7','$numberdefined8','$numberdefined9','$numberdefined10','$datedefined1','$datedefined2','$datedefined3','$datedefined4','$datedefined5','$datedefined6','$datedefined7','$datedefined8','$datedefined9','$datedefined10','$doc','$credito')on duplicate key update nuip = '$doc'");
  }

  public function inactivarClientesbcsc($slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("update 10_clientes set activo = '0'");
  }

  public function inactivarObligacionesbcsc($slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("update 9_creditos set activo = '0'");
  }

  public function actualizaAceleracion($datedefined6, $slug) {
    $this->db = $this->load->database($slug, TRUE);
    $fecha = date('Y-m-d');
    $query = $this->db->query("update 9_creditos a, marcasObligacion b set a.fch_acelerado = b.date_defined6 where a.obligacion = b.obligacion");
  }

  public function buscarxdoc($doc, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 10_clientes where documento = AES_ENCRYPT('$doc', '$this->key') and activo = '1';");
    return $query->result_array();
  }

  public function getabogados($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 35_abogadoscuenta order by nombre asc;");
    return $query->result_array();
  }

  public function gethonorarios($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 35_honorariosabogado order by etapaprocesal asc;");
    return $query->result_array();
  }

  public function getdiaspr($pr, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 34_grupoproductos where grupoproductos = '$pr';");
    return $query->result_array();
  }

  public function getclientesdoc($doc, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 10_clientes where documento = AES_ENCRYPT('$doc', '$this->key');");
    return $query->result_array();
  }

  public function acuerdorxdoc($doc, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 22_acuerdos where idAcuerdo = (select max(idAcuerdo) from 22_acuerdos where documento = AES_ENCRYPT('$doc', '$this->key'));");
    return $query->result_array();
  }

  public function updateCorreoAcuerdo($r, $correo, $doc, $data) {

    $this->db = $this->load->database($data, TRUE);
    $query = $this->db->query("update 22_acuerdos set correo = '$correo', archivo = '$r' where documento =  AES_ENCRYPT('$doc',  '$this->key') and activo = '1';");
  }

  public function saveGestion($documento, $fecha, $hora, $tele, $accion, $contac, $motiv, $resultado, $fecacu, $valor, $txt, $txtgest, $id, $time, $data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("insert into 7_callhist (documento, fechaGestion, hora, telefono, idAccion, idContacto, idMotivo, idResultado, fechaAcuerdo, vlAcuerdo, complemento, textoGestion, idAsesor, tiempo)"
    . "values (AES_ENCRYPT('$documento',  '$this->key'), '$fecha', '$hora', '$tele', '$accion', '$contac', '$motiv', '$resultado', '$fecacu', '$valor', '$txt', '$txtgest', '$id', '$time')");
  }


  public function getTablaCreditos($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("describe 9_creditos;");
    return $query->result_array();
  }

  public function getTablaEvolutivo($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("describe evolutivo;");
    return $query->result_array();
  }

  public function unactivateClientes($data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("update 10_clientes set activo = '0';");
  }

  public function borraCreditos($data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("truncate table 9_creditos;");
  }

  public function uploadClientes($documento, $nombre, $data) {

    $this->db = $this->load->database($data, TRUE);
    $fecha = date("Y-m-d");
    echo "insert into 10_clientes (documento, nombre, saldoPareto, idAsesor, mejorGestion, ultimaGestion, FecUltimaGestion, fechaIngreso, activo, nuip)"
    . "values (AES_ENCRYPT('$documento',  '" . $this->key . "'),'$nombre', '0', '0', '0', '0', '0000-00-00', '$fecha', '1', '$documento') on duplicate key update activo = '1';"."</br>";

    $this->db->query("insert into 10_clientes (documento, nombre, saldoPareto, idAsesor, mejorGestion, ultimaGestion, FecUltimaGestion, fechaIngreso, activo, nuip)"
    . "values (AES_ENCRYPT('$documento',  '" . $this->key . "'),'$nombre', '0', '0', '0', '0', '0000-00-00', '$fecha', '1', '$documento') on duplicate key update activo = '1';");
  }

  public function uploadCreditos($query, $data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query($query);
  }

  public function getNumClientes($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select count(documento) as cuantos from 10_clientes where activo = '1'", TRUE);

    return $query->result_array();
  }

  public function getNumCreditos($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select count(documento) as cuantos from 9_creditos where activo = '1'", TRUE);

    return $query->result_array();
  }

  public function getEventosFecha($fecha, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 16_logEventos where fecha = '$fecha'", TRUE);

    return $query->result_array();
  }

  public function getEventosDocu($doc, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 16_logEventos where documento = '$doc'", TRUE);

    return $query->result_array();
  }

  public function getEventosASeso($id, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 16_logEventos where idUser = '$id'", TRUE);

    return $query->result_array();
  }

  public function getEventosIp($ip, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 16_logEventos where ip = '$ip'", TRUE);

    return $query->result_array();
  }

  public function getAcciones($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 1_acciones where activo = '1' order by idAccion asc", TRUE);
    return $query->result_array();
  }

  public function saveAcciones($accion, $guion, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("insert into 1_acciones (descripcion, guion, activo) values ('$accion', '$guion', '1') on duplicate key update activo = '1'", TRUE);
  }

  public function editAcciones($accion, $guion, $id, $data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("update ignore 1_acciones set descripcion = '$accion', guion = '$guion' where idAccion = '$id'", TRUE);
  }

  public function getContacto($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 2_contacto where activo = '1' order by idContacto asc", TRUE);
    return $query->result_array();
  }


  public function getResponsableNombre($resp, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from responsable where responsable = '$resp';", TRUE);
    return $query->result_array();
  }



  public function saveContacto($contacto, $grupo, $guion, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("insert into 2_contacto (descripcion, idGrupo, guion, activo) values ('$contacto', '$grupo','$guion', '1') on duplicate key update activo = '1'", TRUE);
  }

  public function desactivaAcuerdo($oh, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("update 22_acuerdos set activo = '0' where obligacion =  AES_ENCRYPT('$oh', '$this->key');");
  }

  public function getAcuerdoFechaDocumento($doc, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select fechapago from 22_acuerdos where documento = AES_ENCRYPT('$doc', '$this->key') and activo = '1' group by fechapago order by fechapago asc;", TRUE);
    return $query->result_array();
  }

  public function getAcuerdoValorTotal($doc, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select sum(valor) as total from 22_acuerdos where documento = AES_ENCRYPT('$doc', '$this->key') and activo = '1' group by documento;", TRUE);
    return $query->result_array();
  }

  public function getPagosFecha($oh, $fecha, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 22_acuerdos where obligacion = AES_ENCRYPT('$oh', '$this->key') and activo = '1' and fechapago = '$fecha';", TRUE);
    return $query->result_array();
  }

  public function gettarifa($id, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from tarifas where idtarifas = '$id';", TRUE);
    return $query->result_array();
  }

  public function saveAcuerdo($r, $oh, $docu, $id, $completa, $cuotasT, $fec, $valor, $cuotas, $correo, $territo, $zona, $responsable, $capital, $piso, $subpr, $tipo, $estrategia, $tipodoc, $capacti, $totalint, $totalcxc, $intconting, $tipopr, $lineasub, $tipojudi, $franja, $abogado, $cuenta, $etapa, $porc, $hono, $vlhonocasa, $base, $prob, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("insert into 22_acuerdos (archivo, obligacion, cuotasTotales, documento, idasesor, fecha, fechapago, valor, cuotas, correo, territorial_mayor, zona_mayor, radicado, nuip, responsable, capitalactivo, pisonegociacion, subproducto, tipocartera, estrategia, valor_honorarios_casa, valor_cuota_contrato, tipo_documento, capital_activo_newbf, total_intereses_newbf, total_cxc_newbf, int_contingentes,	tipo_producto, linea_subproducto, tipo_judicial, franja_obligacion_actual, abogado, cuenta, etapaproceso, porcentaje, honorarios, probabilidadpago) 
    values ('$r',  AES_ENCRYPT('$oh', '$this->key'), '$cuotasT',  AES_ENCRYPT('$docu', '$this->key'), '$id', '$completa', '$fec', '$valor', '$cuotas', '$correo', '$territo', '$zona', '$oh', '$docu', '$responsable', '$capital', '$piso', '$subpr', '$tipo', '$estrategia', '$vlhonocasa', '$base', '$tipodoc', '$capacti', '$totalint', '$totalcxc', '$intconting', '$tipopr', '$lineasub', '$tipojudi', '$franja', '$abogado', '$cuenta', '$etapa', '$porc', '$hono', '$prob');");
  }

  public function editContacto($contacto, $grupo, $guion, $id, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("update ignore 2_contacto set descripcion = '$contacto', idGrupo = '$grupo', guion = '$guion' where idContacto = '$id'", TRUE);
  }

  public function getGruposContactoUno($id, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 2_grupos_contacto where idGrupo = '$id'");
    return $query->result_array();
  }

  public function getResultado($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 4_resultado where activo = '1' order by idCodres asc", TRUE);
    return $query->result_array();
  }

  public function saveResultado($resultados, $nivel, $fecha, $valor, $texto, $guion, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("insert into 4_resultado (descripcion, nivel, fecha, valor, texto, guion, activo) values ('$resultados', '$nivel', '$fecha', '$valor', '$texto','$guion', '1') on duplicate key update activo = '1'", TRUE);
  }

  public function editResultado($resultados, $nivel, $fecha, $valor, $texto, $guion, $id, $data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("update ignore 4_resultado set descripcion = '$resultados', nivel = '$nivel', fecha = '$fecha', valor = '$valor', texto = '$texto', guion = '$guion' where idCodres = '$id'", TRUE);
  }

  public function getMotivos($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 3_motivos_no_pago where activo = '1' order by idMotivo asc", TRUE);
    return $query->result_array();
  }

  public function saveMotivos($motivo, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("insert into 3_motivos_no_pago (descripcion, activo) values ('$motivo', '1') on duplicate key update activo = '1'", TRUE);
  }

  public function editMotivos($motivo, $id, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("update ignore 3_motivos_no_pago set descripcion = '$motivo' where idMotivo = '$id'", TRUE);
  }

  public function getRelaciones($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 5_relacion_codigos order by idAccion asc", TRUE);
    return $query->result_array();
  }

  public function saveRelacion($accion, $contacto, $resultado, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("insert into 5_relacion_codigos (idAccion, idContacto, idResultado) values ('$accion', '$contacto', '$resultado') on duplicate key update idAccion = '$accion'", TRUE);
  }

  public function getAccionUno($id, $data) {

    $this->db = $this->load->database($data, TRUE);

    if ($id == 0) {
      return $data = array("0" => array("descripcion" => "Sin Accion"));
    } else {
      $query = $this->db->query("select * from 1_acciones where idAccion = '$id'");
      return $query->result_array();
    }
  }

  public function getContactoUno($id, $data) {

    $this->db = $this->load->database($data, TRUE);

    if ($id == 0) {
      return $data = array("0" => array("descripcion" => "Sin Contacto"));
    } else {
      $query = $this->db->query("select * from 2_contacto where idContacto = '$id'");
      return $query->result_array();
    }
  }

  public function getResultadoUno($id, $data) {

    $this->db = $this->load->database($data, TRUE);

    if ($id == 0) {
      return $data = array("0" => array("descripcion" => "Sin Resultado"));
    } else {
      $query = $this->db->query("select * from 4_resultado where idCodres = '$id'");
      return $query->result_array();
    }
  }

  public function getUserPr($pr) {

    $this->db = $this->load->database('users', TRUE);
    echo "select idUsuario from usuarios where idProyecto = '$pr' and idPerfil > '3';";
    $query = $this->db->query("select idUsuario from usuarios where idProyecto = '$pr' and idPerfil > '3';");
    return $query->result_array();
  }

  public function getProductividadHoy($hoy, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select AES_DECRYPT(documento,  '$this->key') as documento, idAsesor, fechaGestion, idAccion, idContacto, idResultado from 7_callhist where date(fechaGestion) = '$hoy'");
    return $query->result_array();
  }

  public function deleteAcciones($accion, $data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("update 1_acciones set activo = '0' where idAccion = '$accion'", TRUE);
    $this->db->query("delete from 5_relacion_codigos where idAccion = '$accion'", TRUE);
  }

  public function deleteContacto($contacto, $data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("update 2_contacto set activo = '0' where idContacto = '$contacto'", TRUE);
    $this->db->query("delete from 5_relacion_codigos where idContacto = '$contacto'", TRUE);
  }

  public function deleteResultado($resultado, $data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("update 4_resultado set activo = '0' where idCodres = '$resultado'", TRUE);
    $this->db->query("delete from 5_relacion_codigos where idResultado = '$resultado'", TRUE);
  }

  public function deleteMotivos($motivo, $data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("update 3_motivos_no_pago set activo = '0' where idMotivo = '$motivo'", TRUE);
  }

  public function getTelefonos($doc, $tipo, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 14_telefonos where documento = AES_ENCRYPT('$doc',  '$this->key') and idActivo = '$tipo' order by agregado, nivelContacto");
    return $query->result_array();
  }

  public function getDirecciones($doc, $tipo, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 13_direcciones where documento = AES_ENCRYPT('$doc',  '$this->key') and idActivo = '$tipo' order by agregado");
    return $query->result_array();
  }

  public function uploadTelefonos($documento, $telefono1, $ciudadOri, $data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("insert into 14_telefonos (telefono, documento, idCiudad, nivelContacto, personaContacto, parentesco, idActivo, agregado)"
    . "values ('$telefono1', AES_ENCRYPT('$documento', '$this->key'), '$ciudadOri', '999', NULL, NULL, '1', '0') on duplicate key update telefono = '$telefono1'", TRUE);
  }

  public function getGestionesInforme($fechaini, $fechafin, $data) {

    $this->db = $this->load->database($data, TRUE);
    
    $fechaini = $fechaini." "."00:00:00";
    $fechafin = $fechafin." "."23:00:00";
    

    $query = $this->db->query("select AES_DECRYPT(documento,  '$this->key') as documento from 7_callhist where fechaGestion >= '$fechaini' and  fechaGestion <='$fechafin' group by documento;", TRUE);
    return $query->result_array();
  }

  public function getGestionesInformeTabla($fechaini, $fechafin, $data) {

    $this->db = $this->load->database($data, TRUE);
    
    $fechaini = $fechaini." "."00:00:00";
    $fechafin = $fechafin." "."23:00:00";
    $this->db->query("truncate table feedbacklocal;");  
    $query = $this->db->query("insert into feedbacklocal (nuip, radicado ) select AES_DECRYPT(a.documento, '$this->key') as documento, AES_DECRYPT(b.obligacion, '$this->key') as obligacion from 7_callhist a, 9_creditos b where a.fechaGestion >= '$fechaini' and a.fechaGestion <='$fechafin' and a.documento = b.documento group by obligacion;", TRUE);
    //$query = $this->db->query("select AES_DECRYPT(a.documento, '$this->key') as documento, AES_DECRYPT(b.obligacion, '$this->key') as obligacion from 7_callhist a, 9_creditos b where a.fechaGestion >= '$fechaini' and a.fechaGestion <='$fechafin' and a.documento = b.documento group by obligacion;", TRUE);
    //return $query->result_array();
  }

  public function createTemp0($fechaini, $fechafin, $data) {

    $this->db = $this->load->database($data, TRUE);
    
    $fechaini = $fechaini." "."00:00:00";
    $fechafin = $fechafin." "."23:00:00";
    $this->db->query("truncate table feedbacklocal_temp0;");  
    $query = $this->db->query("insert into feedbacklocal_temp0 select *, AES_DECRYPT(documento, '$this->key') from 7_callhist where fechaGestion >= '$fechaini' and fechaGestion <= '$fechafin';", TRUE);
  }

  public function getGestionesTotal($fechaini, $fechafin, $data) {

    $this->db = $this->load->database($data, TRUE);
    $fechaini = $fechaini." "."00:00:00";
    $fechafin = $fechafin." "."23:00:00";
    
    $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 7_callhist where fechaGestion >= '$fechaini' and  fechaGestion <='$fechafin' and idContacto <> '11';", TRUE);
    return $query->result_array();
  }

  public function markasignacion($documento, $usuario, $data) {
    $this->db = $this->load->database($data, TRUE);

    $this->db->query("update 10_clientes set idAsesor = '$usuario' where documento = AES_ENCRYPT('$documento',  '$this->key')");
  }

  public function getasignaciontable($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select idAsesor, count(documento) as cuantos from 10_clientes group by idAsesor");
    return $query->result_array();
  }

  public function getusuario($id) {

    $this->db = $this->load->database('users', TRUE);

    $query = $this->db->query("select * from usuarios where usuario = '$id'");
    return $query->result_array();
  }

  public function getusuarioId($id) {

    $this->db = $this->load->database('users', TRUE);

    $query = $this->db->query("select * from usuarios where idUsuario = '$id'");
    return $query->result_array();
  }

  public function borraTareasRapi($data) {

    $this->db = $this->load->database($data, TRUE);
    $this->db->query("delete from 15_tareas where tarea like '%Firmas%' ");
  }

  public function buscarxobligIn($todas, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select *, AES_DECRYPT(obligacion,  '$this->key') as obligacion, AES_DECRYPT(documento,  '$this->key') as documento from 9_creditos where AES_DECRYPT(obligacion,  '$this->key') in (".$todas.") order by obligacion asc;");
    return $query->result_array();
  }

  public function buscarxobligInAcuerdos($todas, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select *, AES_DECRYPT(obligacion,  '$this->key') as obligacion, AES_DECRYPT(documento,  '$this->key') as documento from 22_acuerdos where activo = '1' and AES_DECRYPT(obligacion,  '$this->key') in (".$todas.") order by cuotas asc;");
    return $query->result_array();
  }

  public function fechasAcuerdoAgrupadas($todas, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select fechapago from 22_acuerdos where activo = '1' and AES_DECRYPT(obligacion,  '$this->key') in (".$todas.") group by fechapago order by cuotas asc;");
    return $query->result_array();
  }

  public function buscarxobligAcuerdos($oh, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select *, AES_DECRYPT(obligacion,  '$this->key') as obligacion, AES_DECRYPT(documento,  '$this->key') as documento from 22_acuerdos where activo = '1' and AES_DECRYPT(obligacion,  '$this->key') = '$oh' order by cuotas asc;");
    return $query->result_array();
  }

  public function getOhTodas($ohs, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select *, AES_DECRYPT(obligacion,  '$this->key') as obligacion from 9_creditos where obligacion = AES_ENCRYPT('$ohs',  '$this->key')  order by obligacion asc;");
    return $query->result_array();
  }


  public function getOhDoc($doc, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select AES_DECRYPT(obligacion,  '$this->key') as obligacion from 9_creditos where documento = AES_ENCRYPT('$doc',  '$this->key')  order by obligacion asc;");
    return $query->result_array();
  }

  public function getNoContacto($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select AES_DECRYPT(a.documento,  '$this->key') as documento from 10_clientes a, 9_creditos b where a.mejorGestion > '7' and a.mejorGestion < '11' and a.documento = b.documento and a.activo = '1' order by obligacion asc");
    return $query->result_array();
  }

  public function getSinGestion($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select AES_DECRYPT(a.documento,  '$this->key') as documento from 10_clientes a, 9_creditos b where a.mejorGestion = '0' and a.documento = b.documento and a.activo = '1' order by radicado asc");
    return $query->result_array();
  }

  public function insertarea($documento, $tarea, $asesor, $data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("insert into 15_tareas (documento, tarea, idResultado, fecha) values (AES_ENCRYPT('$documento',  '$this->key'), '$tarea', '0', NULL,)");
  }

  public function getAtribuciones($tramo, $producto, $data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from vectores where tramo = '$tramo' and producto = '$producto' order by idVector desc");
    return $query->result_array();
  }

  public function markDesasignaciones($data) {

    $this->db = $this->load->database($data, TRUE);

    $this->db->query("update inventarios a, desasignaciones b set a.fch_desasignacion = b.fecha, a.motivo_desasignado = b.causaEstado where a.radicado = b.radicado");
  }

  public function updateActualizacion($oh, $diasven, $vlmora, $estado, $franja, $fecha, $data) {

    $this->db = $this->load->database($data, TRUE);
    //echo "update creditos set dias_mora_actual = '$diasven', valor_mora_actual = '$vlmora', estado_evolutivo = '$estado', fechaevolutivo2 = '$fecha' where obligacion = AES_ENCRYPT('$oh',  '$this->key');";
    //echo "</br>";
    $this->db->query("update 9_creditos set dias_mora_actual = '$diasven', valor_mora_actual = '$vlmora', estado_evolutivo = '$estado', fechaevolutivo2 = '$fecha', franja_obligacion_actual = '$franja' where obligacion = AES_ENCRYPT('$oh',  '$this->key');");
  }



  public function getListadoSms($data) {

    $this->db = $this->load->database($data, TRUE);

    $query = $this->db->query("select * from 27_admin_sms where idestado = '1' order by prioridad asc;");
    return $query->result_array();
  }

  public function getCampanas() {
      $this->db = $this->load->database('sms', TRUE);

      $query = $this->db->query("select * from campanas order by idCampana desc;");
      return $query->result_array();
  }

  public function createSms($nombre, $peridiocidad, $usuario, $fechacreacion, $prioridad, $campana, $hora, $data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query("insert into 27_admin_sms (nombre, peridiocidad, idusuario, fechacreacion, idestado, prioridad, campana, hora) values ('$nombre', '$peridiocidad', '$usuario', '$fechacreacion', '1', '$prioridad', '$campana', '$hora');");
  }

  public function getSmsUno($slug, $data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query("select * from 27_admin_sms where idEstado = '1' and idtareas = '$slug';");
      return $query->result_array();
  }

  public function truncateCampana($id) {
      $this->db = $this->load->database('sms', TRUE);

      $query = $this->db->query("delete from basedeenvio where idCampana = '$id';");
  }

  public function getDemograClienteConf($doc, $data) {

      $this->db = $this->load->database($data, TRUE);
      $query =  $this->db->query("select telefono from  14_telefonos where documento = AES_ENCRYPT('$doc', '$this->key') and confirmado = '1';");
      return $query->result_array();
  }

  public function insertSmsAdmin($telefono, $campana, $hoy, $documento) {
      $this->db = $this->load->database('sms', TRUE);

      $query = $this->db->query("insert into basedeenvio (numero, idCampana, fechacargue, fechaenvio, enviado, idAsesorCargue, opcion1, opcion2, opcion3, opcion4, documento)
                                  values ('$telefono', '$campana', '$hoy', '0000-00-00 00:00:00', '0', '0', NULL, NULL, NULL, NULL, '$documento') on duplicate key update set enviado = '0';");
  }

  public function getSmsDetalle($slug, $data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query("select * from 28_criterios_sms where idtarea = '$slug' order by idcriterio asc;");
      return $query->result_array();
  }

  public function getDescribeCreditos($data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query("describe 9_creditos;");
      return $query->result_array();
  }

  public function getDescribeClientes($data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query("describe 10_clientes;");
      return $query->result_array();
  }

  public function saveCriteriosms($campo, $operador, $valor, $tarea, $data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query("insert into 28_criterios_sms (idtarea, campo, operador, valor) values ('$tarea', '$campo', '$operador', '$valor');");
  }

  public function getTareaDetallesms($slug, $data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query("select * from 28_criterios_sms where idtarea = '$slug' order by idcriterio asc;");
      return $query->result_array();
  }

  public function setConsulta($sql, $data) {

      $this->db = $this->load->database($data, TRUE);

      $query = $this->db->query($sql);
      return $query->result_array();
  }

  public function getusuariosall() {

      $this->db = $this->load->database('users', TRUE);

      $query = $this->db->query("select * from usuarios;");
      return $query->result_array();
  }


  public function borraPagosBCSC($data) {

    $this->db = $this->load->database($data, TRUE);
    $this->db->query("truncate table pagos");
  }

  public function borraPromesasBCSC($data) {

    $this->db = $this->load->database($data, TRUE);
    $this->db->query("truncate table promesas");
  }

  public function borraProcesosJuridicosbcsc($data) {

    $this->db = $this->load->database($data, TRUE);
    $this->db->query("truncate table procesosJuridicos");
  }

  public function borraGestionJuridicabcsc($data) {

    $this->db = $this->load->database($data, TRUE);
    $this->db->query("truncate table gestionJuridica");
  }

  public function borraVisitasbcsc($data) {

    $this->db = $this->load->database($data, TRUE);
    $this->db->query("truncate table visitas_ics");
  }

  public function borraMarcasClientebcsc($data) {

    $this->db = $this->load->database($data, TRUE);
    $this->db->query("truncate table marcasCliente");
  }

  public function borraMarcasObligacionbcsc($data) {

    $this->db = $this->load->database($data, TRUE);
    $this->db->query("truncate table marcasObligacion");
  }

  public function borraMorosidad($data) {

    $this->db = $this->load->database($data, TRUE);
    $this->db->query("truncate table morosidad_edades");
  }

  public function borraReferencias($data) {

    $this->db = $this->load->database($data, TRUE);
    $this->db->query("truncate table referencias");
  }




  public function getCamposDinamicos($database) {
    $this->db = $this->load->database($database, TRUE);

    $query = $this->db->query("select * from 26_camposDinamicos order by idCampos asc");
    return $query->result_array();
  }

  public function saveCamposDinamicos($campo, $database) {
    $this->db = $this->load->database($database, TRUE);

    $query = $this->db->query("insert into 26_camposDinamicos (nombreCampo) values ('$campo')");
  }

  public function saveCamposDinamicosHist($campo, $database) {
    $this->db = $this->load->database($database, TRUE);

    $query = $this->db->query("alter table 7_callhist add ".$campo." varchar(100) null;");
  }

  public function saveOptionsField($campo, $options, $database) {
    $this->db = $this->load->database($database, TRUE);

    $query = $this->db->query("update 26_camposDinamicos set contenido = '$options' where idCampos = '$campo'");
  }

  public function dropOptionsField($campo, $database) {
    $this->db = $this->load->database($database, TRUE);

    $query = $this->db->query("delete from 26_camposDinamicos where idCampos = '$campo'");
  }

  public function cargaPredictivo($fechaini,$fechafin) {

    $this->db = $this->load->database('call_center', TRUE);


    $query= $this->db->query("select a.*, b.phone, b.status, b.fecha_llamada from call_attribute a, calls b where a.id_call = b.id and a.column_number = '1' and date(b.fecha_llamada) >= '$fechaini' and date(b.fecha_llamada) <= '$fechafin';");
    return $query->result_array();

  }

  public function guardaPredictivo($id_call,$value,$phone,$status,$fecha_llamada) {

    $this->db = $this->load->database('movistar', TRUE);
    $query= $this->db->query("INSERT INTO gestion_predictivo (idLlamada,documento,telefono,fecha_llamada,status,cargado) values ('$id_call','$value','$phone','$fecha_llamada','$status','0') on duplicate key update idLlamada = '$id_call'");


  }

  public function insertaPredictivo() {

    $this->db = $this->load->database('movistar', TRUE);

    $query= $this->db->query("SELECT gestion_predictivo.documento, gestion_predictivo.telefono, gestion_predictivo.fecha_llamada, gestion_predictivo.idLlamada FROM 10_clientes JOIN gestion_predictivo ON gestion_predictivo.documento = 10_clientes.nuip");
    return $query->result_array();

  }

  public function insertaPreCallh($documento,$telefono,$fecha_llamada,$hora,$idLlamada) {

    $this->db = $this->load->database('movistar', TRUE);
    $query= $this->db->query("INSERT INTO 7_callhist (documento,fechaGestion,hora,telefono,idAccion,idContacto,idMotivo,idResultado,ohacuerdo,fechaAcuerdo,vlAcuerdo,complemento,textoGestion,idAsesor,tiempo,grabacion,actividad) values
    (AES_ENCRYPT('$documento',  '" . $this->key . "'),'$fecha_llamada','$hora','$telefono','1','6','0','17',NULL,NULL,'0','0','Llamada predictivo no contestada','54',NULL,NULL,NULL) on duplicate key update hora = '$hora';");
  }

  public function updateultimapred($uno, $dos) {

    $this->db = $this->load->database('movistar', TRUE);
    $this->db-> query("update 10_clientes set FecUltimaGestion = '$dos' where nuip = '$uno' and FecUltimaGestion < '$dos';");

  }

  public function borraPredictivo($data) {

    $this->db = $this->load->database('movistar', TRUE);

    $this->db->query("truncate table gestion_predictivo;");
  }






}

?>
