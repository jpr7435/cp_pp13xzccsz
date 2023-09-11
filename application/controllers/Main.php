<?php
header('Content-Type: text/html; charset=UTF-8');
class Main extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->model('Principal');
    $this->load->model('Issabel');
    $this->load->library('session');
    $this->load->library('utilidades');
  }


  public function showevolutivo() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $obligacion = $this->input->post('oh');

    $oh = $this->Principal->getEvolutivo($obligacion, $data['session']['proyecto_activo']);

    //$html = '<script src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/lib/js/core/site.js"></script>';
    $html = '';


    $html .= '
    <table style="width: 100%;  border: 1px solid #000; border-collapse: collapse;">
    <tr style="border: 1px solid #000; border-collapse: collapse;">
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Tipo_Documento</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_documento'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Identificación</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;"></td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">TIPO PERSONA</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_persona'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">NOMBRE</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['nombre'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Capital_Pareto</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['capital_pareto']).'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Cap_pareto_act</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['cap_pareto_act']).'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Capital_Vigente_Afectado</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['capital_vigente_afectado']).'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Cap_Pareto_Tp_Car</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['cap_pareto_tp_car']).'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Dias_Pareto</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['dias_pareto']).'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Marca_Vip</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['marca_vip'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Segmento_II</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['segmento_ii'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Cons_Prod2</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['cons_prod2'].'</td>
    </tr>
    <tr>
      <th colspan="8">DATOS CREDITO</th>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Obligación</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['marca_vip'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">CAPITALA</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['capitala']).'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Valor_Mora</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['valor_mora']).'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">VALORMOR</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['valormor']).'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Dias_Vencidos</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['dias_vencidos']).'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Tipo_Producto</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_producto'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Provision_Capital</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['provision_capital']).'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">LINEA_subproducto</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['linea_subproducto'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Tipo_Cartera</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_cartera'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Producto</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['producto'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Provision_Interes</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['provision_interes']).'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Subproducto</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['subproducto'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">LINEA_PRODUCTO</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['linea_producto'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">LINEA_PRODUCTO_C</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['linea_producto'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">CXC_TDC</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['cxc_tdc']).'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Plazo_Total</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['plazo_total'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Fecha_Formalización</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_formalizacion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Fecha_Final</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_final'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Cuotas_en_corr</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['cuotas_en_corr'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Plazo</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['plazo']).'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Valor_desembolso</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['valor_desembolso'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Tasa_EA</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tasa_ea'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Cuotas_a_Corr</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['cuotas_a_corr'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">TIPO_ACTIVO</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_activo'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Marca_Garantia</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['marca_garantia'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">max_Cal_Gtia</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['max_cal_gtia'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Plazo_Requerido</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['plazo_requerido'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Tipo_Garantia</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_garantia'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Fecha_Mora</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_mora'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">PLAZO_Ini</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['plazo_ini'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Intereses_Contg</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['intereses_contg']).'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Capital_Activo</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['capital_activo']).'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Estado_Gtia_Fondos</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estado_gtia_fondos'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">PLAZO_RES</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['plazo_res'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">T_Cuotas_corr</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['t_cuotas_corr'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Total_intereses</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['total_intereses']).'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Castigos</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['castigos'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">PLAZO_TRANS</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['plazo_trans'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Tipo_Attritión</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_attrition'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Saldo_total</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.number_format($oh[0]['saldo_total']).'</td>
    </tr>
    <tr>
      <td colspan="8">DATOS MEDICIÓN</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Fraja_Gestión</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['franja_gestion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Franja_Obligacion</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['franja_obligacion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Indicador_MIA </th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['indicador_mia'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Franja_Obligación_Actual</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['franja_obligacion_actual'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">DIASVEN</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['diasven'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">DIAS_ACTUALES</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['dias_actuales'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">SEGMENTACION_ASIGNACIÓN</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['segmentacion_asignacion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Estado_Inicial_Objetivo</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estado_inicial_objetivo'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Franja_obligación_Saneamiento</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['franja_obligacion_saneamiento'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Estado_Actual_Objetivo</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estado_actual_objetivo'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Franja_Obligacion_Mia</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['franja_obligacion_mia'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Estado</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estado'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">prioridad_mes</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['prioridad_mes'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Evaluación_Actual_Estado</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['evaluacion_actual_estado'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Franja_Obligación_Actual_MIA</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['franja_obligacion_actual_mia'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">ESTADO_CARTERA</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estado_cartera'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">fecha_Vto_Actual</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_vto_actual'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">DIA_VTO</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['dia_vto'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">TIPO_FRANJA</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_franja'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">ESTADO_EVALUACIÓN</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estado_evaluacion'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">FRANJA_RIESGO</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['franja_riesgo'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Proximo_a_vencer</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['proximo_a_vencer'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Meses_Vencidos</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['meses_vencidos'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Franja_Gestión_Actual</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['franja_gestion_actual'].'</td>
    </tr>
    <tr>
      <td colspan="8">DATOS ASIGNACIÓN</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">territorial_Mayor</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['territorial_mayor'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">TERRITORIAL</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['territorial'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Codigo_Exclusión </th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['codigo_exclusion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Tipo_Reparto</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_reparto'].'</td>
    </tr>
    <tr>
      <th  style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Centro_Mayor</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['centro_mayor'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Zona_Mayor</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['zona_mayor'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Gestor</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['gestor'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Tipo_Reparto_1</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_reparto_1'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">CALIFICACIÓN</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['calificacion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Departamento_Mayor</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['departamento_mayor'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Tipo_Gestor</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_gestor'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Tipo_Cobro</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_cobro'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">CAL_SUBJET</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['cal_subjet'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">califica7</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['califica7'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Detalle_tipo_Gestor</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['detalle_tipo_gestor'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Banca</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['banca'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Detalle_marca</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['detalle_marca'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Responsable</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['responsable'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Centro_Gestor</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['centro_gestor'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Marca_1</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['marca_1'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Nombre_Centro_Gestor</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['nombre_centro_gestor'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Detalle_Responsable</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['detalle_responsable'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Detalle_Gestor</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['detalle_gestor'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Marca</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['marca'].'</td>
    </tr>
    <tr>
      <td colspan="8">DATOS GESTIÓN ANTERIOR</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Fecha_asignación</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_asignacion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Actividad_Pricipal</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['actividad_principal'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Fecha_ult_actividad</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_ult_actividad'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Resultado_Contacto</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['resultado_contacto'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Indicativo</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['indicativo'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Efectividad_Gestión</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['efectividad_gestion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Fecha_Actividad_Principal</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_actividad_principal'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Motivo_No_Pago</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['motivo_no_pago'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Teléfono_Ubicación1</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['telefono_ubicacion1'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">N_Actividades</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['n_actividades'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Fecha_Compromiso_pago</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_compromiso_pago'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Mecanismo_Norm</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['mecanismo_norm'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Ultima_actividad</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['ultima_actividad'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Gestión</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['gestion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">CONTACTABILIDAD</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['contactabilidad'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Etapa_Nom</th>
    <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['etapa_norm'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Texto_gestión</th>
      <td colspan="7" style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['texto_gestion'].'</td>
    </tr>
    <tr>
      <td colspan="8">DATOS PARA RECUPERACIÓN</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Alternativa_Normalización</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['alternativa_normalizacion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Alternativa_Norm</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['alternativa_norm'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Campaña</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['campana'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Rediferidos</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['rediferidos'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Porc_Max_Condona</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['porc_max_condona'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Efectiva_nueva</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['efectiva_nueva'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">NORMALIZACIÓN</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['normalizacion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">CONGELADA</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['congelada'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Tipologia_Gestión_Cli</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipologia_gestion_cli'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Probabilidad_pago_PY</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['probabilidad_pago_py'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">REEST_PARTICULARES</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['reest_particulares'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Codigo_Estrategia</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['codigo_estrategia'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">C_Collection_Score</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['c_collection_score'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">PUNTAJE_SECTOR</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['puntaje_sector'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">REESTRUCTURADOS_COMERCIAL</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['reestructurados_comercial'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Grupo</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['grupo'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">REFIS_CLIENTE</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['refis_cliente'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">MARCAS_REFIS</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['marca_refis'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">REESTRUCTURADOS_LEASING</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['reestructurados_leasing'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">WASTE_MANAGEMENT</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['waste_management'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">ESTRATEGIA_COMERCIAL</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estrategia_comercial'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">probabilidad_pago</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['probabilidad_pago'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">SEMANA</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['semana'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Base_IFRS9</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['base_ifrs9'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Forzaje</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['forzaje'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Estado_Gest</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estado_gest'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Fecha_Venc_PDP</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_venc_pdp'].'</td>
    </tr>
    <tr>
      <td colspan="8">DATOS LIBRANZAS</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">TIPO_LIBRANZA</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_libranza'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">COD_EM</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['cod_em'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Convenio</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['convenio'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">SEGMENTO_LBZ</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['segmento_lbz'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Causal_No_Descuento</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['causal_no_descuento'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Indicador_Actual</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['indicador_actual'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Cuota_Ini</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['cuota_ini'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Cuota_Actual</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['cuota_actual'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Porcentaje</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['porcentaje'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Guión_Libranza</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['guion_libranza'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Porcentaje_FNG</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['porcentaje_fng'].'</td>
    </tr>
    <tr>
      <td colspan="8">DATOS ALIVIO</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Estado_Aplicación_Alivio</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estado_aplicacion_alivio'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Fecha_Solicitud_Alivio</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_solicitud_alivio'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Contactado</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['contactado'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Acepta_Alivio</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['acepta_alivio'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Gestor_Alivio</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['gestor_alivio'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Plazo_Gracia</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['plazo_gracia'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">STATUS_APLICACIÓN</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['status_aplicacion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Segmento_circular_007</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['segmento_circular_007'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Linea_Problema</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['linea_problema'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Ofertable_Alivio</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['ofertable_alivio'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Fecha_Final_Alivio</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_final_alivio'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Segmento_EMERGE</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['segmento_emerge'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Prioridad_Gestión_EMERGE</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['prioridad_gestion_emerge'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Motivo_Gestión_EMERGE</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['motivo_gestion_emerge'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Foco_Gestión</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['foco_gestion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Fecha_Max_Contacto</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_max_contacto'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Celular_Cir_022</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['celular_cir_022'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Correo_Electronico_022</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['correo_electronico_022'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">ESTADO_CONTACTO_PAD</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estado_contacto_pad'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">ESTADO_APLICACIÓN_RED</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estado_aplicacion_red'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">FECHA_APLICACIÓN</th>
      <td colspan="7" style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['fecha_aplicacion'].'</td>
    </tr>
    <tr>
      <td colspan="8">DATOS JUDICIAL</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">TIPO_JUDICIAL</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_judicial'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">TIPO_JUDICIAL_ACTUAL</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['tipo_judicial_actual'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">CLIENTE_CON_LINEA_COMERCIAL</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['cliente_con_linea_comercial'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">ETAPA_PROCESAL</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['etapa_procesal'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">ABOGADO_EXTERNO</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['abogado_externo'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">DETALLE_TIPO_JUDICIAL</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['detalle_tipo_judicial'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">MACRO_ETAPA_MATRIZ</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['macro_etapa_matriz'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">SITUACIÓN_GESTIÓN</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['situacion_gestion'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">ESTADO_CUENTA</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estado_cuenta'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">ENTIDAD_EMBARGO</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['entidad_embargo'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Numero_Poliza</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['numero_poliza'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">seguro_Desempleo</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['seguro_desempleo'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">CLIENTE_FALLECIDO</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['cliente_fallecido'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">ESTADO_RECLAMACIÓN</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['estado_reclamacion'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Saldo_Activo_IFRS9</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['saldo_activo_ifrs9'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Provision_Total_IFRS9</th>
      <td style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['provision_total_ifrs9'].'</td>
    </tr>
    <tr>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Provision_Faltante_IFRS9</th>
      <td  style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['provision_faltante_ifrs9'].'</td>
      <th style="border: 1px solid #000; border-collapse: collapse; background-color: #DFDFDF;">Valor_Primer_Recibo</th>
      <td colspan="6" style="border: 1px solid #000; border-collapse: collapse; text-align: center;">'.$oh[0]['valor_primer_recibo'].'</td>
    </tr>
    </table>';

    echo $html;
  }


//INICIA ASIGNACION TOTAL //

  public function showasignaciontotal() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $obligacion = $this->input->post('oh');

    $oh = $this->Principal->getAsignacionTotal($obligacion, $data['session']['proyecto_activo']);

    //$html = '<script src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/lib/js/core/site.js"></script>';
    $html = '';


    $html .= '
    <style type="text/css">
      html { font-family:Calibri, Arial, Helvetica, sans-serif; font-size:11pt; background-color:white }
      a.comment-indicator:hover + div.comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em }
      a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em }
      div.comment { display:none }
      table { border-collapse:collapse; page-break-after:always }
      .gridlines td { border:1px dotted black }
      .gridlines th { border:1px dotted black }
      .b { text-align:center }
      .e { text-align:center }
      .f { text-align:right }
      .inlineStr { text-align:left }
      .n { text-align:right }
      .s { text-align:left }
      td.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:11pt; background-color:white }
      th.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:11pt; background-color:white }
      td.style1 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:11pt; background-color:white }
      th.style1 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:11pt; background-color:white }
      td.style2 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-size:11pt; background-color:#C0C0C0 }
      th.style2 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#C0C0C0 }
      td.style3 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      th.style3 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      td.style4 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      th.style4 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      td.style5 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      th.style5 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      td.style6 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      th.style6 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      td.style7 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:10pt; background-color:white }
      th.style7 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:10pt; background-color:white }
      td.style8 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      th.style8 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      td.style9 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      th.style9 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      td.style10 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#FFF2CB }
      th.style10 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#FFF2CB }
      td.style11 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#BDD6EE }
      th.style11 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#BDD6EE }
      td.style12 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#C5DEB5 }
      th.style12 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#C5DEB5 }
      td.style13 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#F7CAAC }
      th.style13 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#F7CAAC }
      td.style14 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#FF9999 }
      th.style14 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#FF9999 }
      td.style15 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:#C0C0C0 }
      th.style15 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:#C0C0C0 }
      td.style16 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; color:#000000;  font-size:11pt; background-color:#FFF2CB }
      th.style16 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; color:#000000;  font-size:11pt; background-color:#FFF2CB }
      td.style17 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:11pt; background-color:#FFF2CB }
      th.style17 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:11pt; background-color:#FFF2CB }
      td.style18 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#FFF2CB }
      th.style18 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:#FFF2CB }
      td.style19 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:2px solid #000000 !important; border-right:none #000000; color:#000000;  font-size:11pt; background-color:white }
      th.style19 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:2px solid #000000 !important; border-right:none #000000; color:#000000;  font-size:11pt; background-color:white }
      td.style20 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:11pt; background-color:white }
      th.style20 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:11pt; background-color:white }
      td.style21 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      th.style21 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      td.style22 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:none #000000; color:#000000;  font-size:11pt; background-color:white }
      th.style22 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:none #000000; color:#000000;  font-size:11pt; background-color:white }
      td.style23 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:11pt; background-color:white }
      th.style23 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:11pt; background-color:white }
      td.style24 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      th.style24 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:2px solid #000000 !important; color:#000000;  font-size:11pt; background-color:white }
      td.style25 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:white }
      th.style25 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:white }
      td.style26 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:#FFF2CB }
      th.style26 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:#FFF2CB }
      td.style27 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:#BDD6EE }
      th.style27 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:#BDD6EE }
      td.style28 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:#C5DEB5 }
      th.style28 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:#C5DEB5 }
      td.style29 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:#F7CAAC }
      th.style29 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:#F7CAAC }
      td.style30 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:#FF9999 }
      th.style30 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000;  font-size:20pt; background-color:#FF9999 }
      table.sheet0 col.col0 { width:27.1111108pt }
      table.sheet0 col.col1 { width:113.86666536pt }
      table.sheet0 col.col2 { width:8.13333324pt }
      table.sheet0 col.col3 { width:96.24444334pt }
      table.sheet0 col.col4 { width:8.13333324pt }
      table.sheet0 col.col5 { width:178.93333128pt }
      table.sheet0 col.col6 { width:8.13333324pt }
      table.sheet0 col.col7 { width:116.57777644pt }
      table.sheet0 col.col8 { width:8.13333324pt }
      table.sheet0 col.col9 { width:127.42222076pt }
      table.sheet0 col.col10 { width:27.1111108pt }
      table.sheet0 tr { height:15pt }
      table.sheet0 tr.row1 { height:25.2pt }
      table.sheet0 tr.row3 { height:25.2pt }
      table.sheet0 tr.row4 { height:15pt }
      table.sheet0 tr.row5 { height:15pt }
      table.sheet0 tr.row6 { height:15pt }
      table.sheet0 tr.row7 { height:15pt }
      table.sheet0 tr.row8 { height:15pt }
      table.sheet0 tr.row9 { height:15pt }
      table.sheet0 tr.row10 { height:15pt }
      table.sheet0 tr.row11 { height:15pt }
      table.sheet0 tr.row12 { height:15pt }
      table.sheet0 tr.row13 { height:15pt }
      table.sheet0 tr.row14 { height:15pt }
      table.sheet0 tr.row16 { height:25.2pt }
      table.sheet0 tr.row17 { height:15pt }
      table.sheet0 tr.row18 { height:15pt }
      table.sheet0 tr.row19 { height:15pt }
      table.sheet0 tr.row20 { height:15pt }
      table.sheet0 tr.row21 { height:15pt }
      table.sheet0 tr.row22 { height:15pt }
      table.sheet0 tr.row23 { height:15pt }
      table.sheet0 tr.row24 { height:15pt }
      table.sheet0 tr.row25 { height:15pt }
      table.sheet0 tr.row26 { height:15pt }
      table.sheet0 tr.row27 { height:15pt }
      table.sheet0 tr.row28 { height:15pt }
      table.sheet0 tr.row29 { height:15pt }
      table.sheet0 tr.row30 { height:15pt }
      table.sheet0 tr.row31 { height:15pt }
      table.sheet0 tr.row32 { height:15pt }
      table.sheet0 tr.row33 { height:15pt }
      table.sheet0 tr.row34 { height:15pt }
      table.sheet0 tr.row35 { height:15pt }
      table.sheet0 tr.row36 { height:15pt }
      table.sheet0 tr.row37 { height:15pt }
      table.sheet0 tr.row38 { height:15pt }
      table.sheet0 tr.row39 { height:15pt }
      table.sheet0 tr.row41 { height:25.2pt }
      table.sheet0 tr.row42 { height:15pt }
      table.sheet0 tr.row43 { height:15pt }
      table.sheet0 tr.row44 { height:15pt }
      table.sheet0 tr.row45 { height:15pt }
      table.sheet0 tr.row46 { height:15pt }
      table.sheet0 tr.row47 { height:15pt }
      table.sheet0 tr.row48 { height:15pt }
      table.sheet0 tr.row49 { height:15pt }
      table.sheet0 tr.row50 { height:15pt }
      table.sheet0 tr.row51 { height:15pt }
      table.sheet0 tr.row52 { height:15pt }
      table.sheet0 tr.row53 { height:15pt }
      table.sheet0 tr.row54 { height:15pt }
      table.sheet0 tr.row55 { height:15pt }
      table.sheet0 tr.row56 { height:15pt }
      table.sheet0 tr.row57 { height:15pt }
      table.sheet0 tr.row58 { height:15pt }
      table.sheet0 tr.row59 { height:15pt }
      table.sheet0 tr.row60 { height:15pt }
      table.sheet0 tr.row61 { height:15pt }
      table.sheet0 tr.row62 { height:15pt }
      table.sheet0 tr.row63 { height:15pt }
      table.sheet0 tr.row64 { height:15pt }
      table.sheet0 tr.row65 { height:15pt }
      table.sheet0 tr.row66 { height:15pt }
      table.sheet0 tr.row68 { height:25.2pt }
      table.sheet0 tr.row69 { height:15pt }
      table.sheet0 tr.row70 { height:15pt }
      table.sheet0 tr.row71 { height:15pt }
      table.sheet0 tr.row72 { height:15pt }
      table.sheet0 tr.row73 { height:15pt }
      table.sheet0 tr.row74 { height:15pt }
      table.sheet0 tr.row75 { height:15pt }
      table.sheet0 tr.row76 { height:15pt }
      table.sheet0 tr.row77 { height:15pt }
      table.sheet0 tr.row78 { height:15pt }
      table.sheet0 tr.row79 { height:15pt }
      table.sheet0 tr.row81 { height:25.2pt }
      table.sheet0 tr.row82 { height:15pt }
      table.sheet0 tr.row83 { height:15pt }
      table.sheet0 tr.row84 { height:15pt }
      table.sheet0 tr.row85 { height:15pt }
      table.sheet0 tr.row86 { height:15pt }
      table.sheet0 tr.row87 { height:15pt }
      table.sheet0 tr.row88 { height:15pt }
      table.sheet0 tr.row89 { height:15pt }
      table.sheet0 tr.row90 { height:15pt }
      table.sheet0 tr.row91 { height:15pt }
      table.sheet0 tr.row92 { height:15pt }
      table.sheet0 tr.row93 { height:15pt }
      table.sheet0 tr.row94 { height:15pt }
      table.sheet0 tr.row95 { height:15pt }
      table.sheet0 tr.row96 { height:15pt }
      table.sheet0 tr.row97 { height:15pt }
      table.sheet0 tr.row98 { height:15pt }
      table.sheet0 tr.row100 { height:25.2pt }
      table.sheet0 tr.row101 { height:15pt }
      table.sheet0 tr.row102 { height:15pt }
      table.sheet0 tr.row103 { height:15pt }
      table.sheet0 tr.row104 { height:15pt }
      table.sheet0 tr.row105 { height:15pt }
      table.sheet0 tr.row106 { height:15pt }
      table.sheet0 tr.row107 { height:15pt }
      table.sheet0 tr.row108 { height:15pt }
      table.sheet0 tr.row109 { height:15pt }
      table.sheet0 tr.row110 { height:15pt }
      table.sheet0 tr.row111 { height:15pt }
      table.sheet0 tr.row112 { height:15pt }
      table.sheet0 tr.row113 { height:15pt }
      table.sheet0 tr.row114 { height:15pt }
      table.sheet0 tr.row115 { height:15pt }
      table.sheet0 tr.row116 { height:15pt }
      table.sheet0 tr.row117 { height:15pt }
      table.sheet0 tr.row118 { height:15pt }
      table.sheet0 tr.row119 { height:15pt }
    </style>
  </head>

  <body>
<style>
@page { margin-left: 0.7in; margin-right: 0.7in; margin-top: 0.75in; margin-bottom: 0.75in; }
body { margin-left: 0.7in; margin-right: 0.7in; margin-top: 0.75in; margin-bottom: 0.75in; }
</style>
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0" style="width: 100%;  border: 1px solid #000; border-collapse: collapse;" >
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <col class="col7">
        <col class="col8">
        <col class="col9">
        <col class="col10">
        <tbody>
          <tr class="row0">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row1">
            <td class="column0">&nbsp;</td>
            <td class="column1 style25 s style25" colspan="9">INFORMACION TOTAL ARCHIVO DE ASIGNACION</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row2">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row3">
            <td class="column0">&nbsp;</td>
            <td class="column1 style26 s style26" colspan="9">DATOS CLIENTE</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row4">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row5">
            <td class="column0">&nbsp;</td>
            <td class="column1 style10 s">tipo_documento</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style10 s">tipo_persona</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style10 s">nuip</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style10 s">nombre</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style10 s">cons_prod2</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row6">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 n">'.$oh[0]['tipo_documento'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['tipo_persona'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['nuip'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style6 s">'.$oh[0]['nombre'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['cons_prod2'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row7">
            <td class="column0">&nbsp;</td>
            <td class="column1 style10 s">mes_pareto</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style10 s">dias_pareto</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style10 s">capital_global</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style10 s">capital_pareto</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style10 s">vr_mora_pareto</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row8">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 n">'.$oh[0]['mes_pareto'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 n">'.$oh[0]['dias_pareto'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style4 n">$ '.number_format($oh[0]['capital_global']).'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style4 n">$ '.number_format($oh[0]['capital_pareto']).'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style4 n">$ '.number_format($oh[0]['vr_mora_pareto']).'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row9">
            <td class="column0">&nbsp;</td>
            <td class="column1 style10 s">puntaje_sector</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style10 s">cliente_mixto</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style10 s">rango_part_castigo</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style10 s">capital_vigente_afectado</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style10 s">tipologia_gestion_cli</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row10">
            <td class="column0">&nbsp;</td>
            <td class="column1 style8 s">'.$oh[0]['puntaje_sector'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style8 s">'.$oh[0]['cliente_mixto'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style8 s">'.$oh[0]['rango_part_castigo'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style9 n">$ '.number_format($oh[0]['capital_vigente_afectado']).'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['tipologia_gestion_cli'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row11">
            <td class="column0">&nbsp;</td>
            <td class="column1 style16 s style18" colspan="7">texto_gestion</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style10 s">fecha_compromiso_de_pago</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row12">
            <td class="column0">&nbsp;</td>
            <td class="column1 style19 s style24" colspan="7" rowspan="3">'.$oh[0]['texto_gestion'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['fecha_compromiso_de_pago'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row13">
            <td class="column0">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style10 s">marca_vip</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row14">
            <td class="column0">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style5 null">'.$oh[0]['marca_vip'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row15">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row16">
            <td class="column0">&nbsp;</td>
            <td class="column1 style27 s style27" colspan="9">DATOS OBLIGACION</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row17">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row18">
            <td class="column0">&nbsp;</td>
            <td class="column1 style11 s">tipo_cartera</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style11 s">radicado</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style11 s">tipo_producto</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style11 s">linea_subproducto</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style11 s">subproducto</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row19">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['tipo_cartera'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['radicado'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['tipo_producto'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['linea_subproducto'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['subproducto'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row20">
            <td class="column0">&nbsp;</td>
            <td class="column1 style11 s">fecha_formalizacion</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style11 s">fecha_final</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style11 s">valor_desembolso</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style11 s">producto</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style11 s">marca</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row21">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['fecha_formalizacion'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['fecha_final'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 n">'.$oh[0]['valor_desembolso'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['producto'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['marca'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row22">
            <td class="column0">&nbsp;</td>
            <td class="column1 style11 s">dias_vencidos</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style11 s">meses_vencidos</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style11 s">diavto</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style11 s">fecha_mora</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style11 s">tipo_franja</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row23">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 n">'.$oh[0]['dias_vencidos'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 n">'.$oh[0]['meses_vencidos'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 n">'.$oh[0]['diavto'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['fecha_mora'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['tipo_franja'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row24">
            <td class="column0">&nbsp;</td>
            <td class="column1 style11 s">ano_castigo</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style11 s">fecha_castigo</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style11 s">franja_obligacion</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style11 s">franja_gestion</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style11 s">efectiva_nueva</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row25">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['ano_castigo'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['fecha_castigo'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['franja_obligacion'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['franja_gestion'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['efectiva_nueva'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row26">
            <td class="column0">&nbsp;</td>
            <td class="column1 style11 s">puntuacion_mia</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style11 s">objetivo_mia</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style11 s">estado_inicial_objetivo</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style11 s">franja_mia</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style11 s">valor_para_negociar</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row27">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 n">'.$oh[0]['puntuacion_mia'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 n">'.$oh[0]['objetivo_mia'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['estado_inicial_objetivo'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['franja_mia'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 n">'.$oh[0]['valor_para_negociar'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row28">
            <td class="column0">&nbsp;</td>
            <td class="column1 style11 s">saldo_total</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style11 s">capital_activo</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style11 s">valor_mora</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style11 s">int_ctes_vencidos</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style11 s">total_cxc</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row29">
            <td class="column0">&nbsp;</td>
            <td class="column1 style4 n">$ '.number_format($oh[0]['saldo_total']).'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style4 n">$ '.number_format($oh[0]['capital_activo']).'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style4 n">$ '.number_format($oh[0]['valor_mora']).'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style4 n">$ '.number_format($oh[0]['int_ctes_vencidos']).'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style4 n">$ '.number_format($oh[0]['total_cxc']).'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row30">
            <td class="column0">&nbsp;</td>
            <td class="column1 style11 s">cxc_vencidas1</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style11 s">total_intereses</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style11 s">total_capital</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style11 s">intereses_activo</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style11 s">intereses_contg</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row31">
            <td class="column0">&nbsp;</td>
            <td class="column1 style4 n">$ '.number_format($oh[0]['cxc_vencidas1']).'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style4 n">$ '.number_format($oh[0]['total_intereses']).'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style4 n">$ '.number_format($oh[0]['total_capital']).'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style4 n">$ '.number_format($oh[0]['intereses_activo']).'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style4 n">$ '.number_format($oh[0]['intereses_contg']).'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row32">
            <td class="column0">&nbsp;</td>
            <td class="column1 style11 s">provision_capital</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style11 s">provision_interes</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style11 s">capital_vencido</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style11 s">int_ctes_activo</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style11 s">comisiones</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row33">
            <td class="column0">&nbsp;</td>
            <td class="column1 style4 n">$ '.number_format($oh[0]['provision_capital']).'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style4 n">$ '.number_format($oh[0]['provision_interes']).'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style4 n">$ '.number_format($oh[0]['capital_vencido']).'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style4 n">$ '.number_format($oh[0]['int_ctes_activo']).'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style4 n">$ '.number_format($oh[0]['comisiones']).'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row34">
            <td class="column0">&nbsp;</td>
            <td class="column1 style11 s">capital_contg</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style11 s">int_mora_activo</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style11 s">plazo_ini</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style11 s">plazo_res</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style11 s">plazo_trans</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row35">
            <td class="column0">&nbsp;</td>
            <td class="column1 style4 n">$ '.number_format($oh[0]['capital_contg']).'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style4 n">$ '.number_format($oh[0]['int_mora_activo']).'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['plazo_ini'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['plazo_res'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style5 null">'.$oh[0]['plazo_trans'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row36">
            <td class="column0">&nbsp;</td>
            <td class="column1 style11 s">plazo_requerido</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style11 s">plazo_total</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style11 s">t_cuotas_corr</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style11 s">cuotas_en_corr</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style11 s">cuotas_a_corr</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row37">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['plazo_requerido'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['plazo_total'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['t_cuotas_corr'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['cuotas_en_corr'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['cuotas_a_corr'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row38">
            <td class="column0">&nbsp;</td>
            <td class="column1 style11 s">periodicidad_capital</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style11 s">periodicidad_inter</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style11 s">estrategia_comercial</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style11 s">segmento</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style11 s">pareto_leasing</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row39">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['periodicidad_capital'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['periodicidad_inter'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['estrategia_comercial'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['segmento'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style4 s">'.$oh[0]['pareto_leasing'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row40">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row41">
            <td class="column0">&nbsp;</td>
            <td class="column1 style28 s style28" colspan="9">DATOS DEMOGRAFICOS</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row42">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row43">
            <td class="column0">&nbsp;</td>
            <td class="column1 style12 s">telefono_ubicacion1</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style12 s">celular_alivios</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style12 s">direccion_ubicacion</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style12 s">mail</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style12 s">direccion_inmueble</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row44">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['telefono_ubicacion1'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 n">'.$oh[0]['celular_alivios'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['direccion_ubicacion'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['mail'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['direccion_inmueble'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row45">
            <td class="column0">&nbsp;</td>
            <td class="column1 style12 s">indicativo</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style12 s">telefono</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style12 s">telefono1</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style12 s">telefono2</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style12 s">celular1</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row46">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['indicativo'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['telefono'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['telefono1'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['telefono2'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style5 null">'.$oh[0]['celular1'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row47">
            <td class="column0">&nbsp;</td>
            <td class="column1 style12 s">telefono_ubicacion</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style12 s">telefono_movil</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style12 s">telefono_trabajo</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style12 s">tel_ult_gestion</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style12 s">telefono_data_1</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row48">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['telefono_ubicacion'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['telefono_movil'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['telefono_trabajo'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 n">'.$oh[0]['tel_ult_gestion'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['telefono_data_1'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row49">
            <td class="column0">&nbsp;</td>
            <td class="column1 style12 s">indicativo_tel_1</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style12 s">numero_telefonico_1</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style12 s">extension_telefono_1</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style12 s">telefono_personas1</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style12 s">telefono_data_2</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row50">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['indicativo_tel_1'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['numero_telefonico_1'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['extension_telefono_1'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['telefono_personas1'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['telefono_data_2'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row51">
            <td class="column0">&nbsp;</td>
            <td class="column1 style12 s">indicativo_tel_2</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style12 s">numero_telefonico_2</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style12 s">extension_telefono_2</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style12 s">telefono_personas2</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style12 s">direccion_gestion</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row52">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['indicativo_tel_2'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['numero_telefonico_2'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['extension_telefono_2'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['telefono_personas2'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['direccion_gestion'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row53">
            <td class="column0">&nbsp;</td>
            <td class="column1 style12 s">indicativo_tel_3</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style12 s">numero_telefonico_3</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style12 s">extension_telefono_3</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style12 s">telefono_personas3</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style12 s">direccion_personas</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row54">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['indicativo_tel_3'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['numero_telefonico_3'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['extension_telefono_3'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['telefono_personas3'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['direccion_personas'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row55">
            <td class="column0">&nbsp;</td>
            <td class="column1 style12 s">indicativo_tel_4</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style12 s">numero_telefonico_4</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style12 s">extension_telefono_4</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style12 s">telefono_personas4</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style12 s">direccion_data_1</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row56">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['indicativo_tel_4'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['numero_telefonico_4'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['extension_telefono_4'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['telefono_personas4'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['direccion_data_1'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row57">
            <td class="column0">&nbsp;</td>
            <td class="column1 style12 s">indicativo_tel_5</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style12 s">numero_telefonico_5</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style12 s">extension_telefono_5</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style12 s">telefono_personas5</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style12 s">direccion</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row58">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['indicativo_tel_5'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['numero_telefonico_5'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['extension_telefono_5'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['telefono_personas5'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['direccion'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row59">
            <td class="column0">&nbsp;</td>
            <td class="column1 style12 s">indicativo_tel_6</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style12 s">numero_telefonico_6</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style12 s">extension_telefono_6</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style12 s">telefono_personas6</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style12 s">direccion_data_2</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row60">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['indicativo_tel_6'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['numero_telefonico_6'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['extension_telefono_6'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['telefono_personas6'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['direccion_data_2'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row61">
            <td class="column0">&nbsp;</td>
            <td class="column1 style12 s">indicativo_tel_7</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style12 s">numero_telefonico_7</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style12 s">extension_telefono_7</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style12 s">telefono_personas7</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row62">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['indicativo_tel_7'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['numero_telefonico_7'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['extension_telefono_7'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['telefono_personas7'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row63">
            <td class="column0">&nbsp;</td>
            <td class="column1 style12 s">indicativo_tel_8</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style12 s">numero_telefonico_8</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style12 s">extension_telefono_8</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style12 s">nombre_municipio</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row64">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['indicativo_tel_8'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['extension_telefono_8'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['extension_telefono_8'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['nombre_municipio'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row65">
            <td class="column0">&nbsp;</td>
            <td class="column1 style12 s">indicativo_tel_9</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style12 s">numero_telefonico_9</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style12 s">extension_telefono_9</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style12 s">nombre_departamento</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row66">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['indicativo_tel_9'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['numero_telefonico_9'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['extension_telefono_9'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['nombre_departamento'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row67">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row68">
            <td class="column0">&nbsp;</td>
            <td class="column1 style30 s style30" colspan="9">DATOS JUDICIAL - GARANTIAS Y SEGUROS</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row69">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row70">
            <td class="column0">&nbsp;</td>
            <td class="column1 style14 s">etapa_procesal</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style14 s">abogado_externo</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style14 s">detalle_tipo_judicial</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style14 s">macro_etapa_matriz</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style14 s">situacion_gestion</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row71">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['etapa_procesal'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['abogado_externo'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['detalle_tipo_judicial'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['macro_etapa_matriz'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['situacion_gestion'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row72">
            <td class="column0">&nbsp;</td>
            <td class="column1 style14 s">estado_cuenta</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style14 s">entidad_embargo</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style14 s">tipo_garantia</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style14 s">tipo_activo</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style14 s">marca_garantia</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row73">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['estado_cuenta'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['entidad_embargo'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['tipo_garantia'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['tipo_activo'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['marca_garantia'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row74">
            <td class="column0">&nbsp;</td>
            <td class="column1 style14 s">estado_gtia_fondos</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style14 s">max_cal_gtia</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style14 s">placa</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style14 s">mar_ca</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style14 s">modelo</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row75">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['estado_gtia_fondos'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['max_cal_gtia'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['placa'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['mar_ca'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['modelo'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row76">
            <td class="column0">&nbsp;</td>
            <td class="column1 style14 s">matricula</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style14 s">direccion_gtia</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style14 s">valor_p_gtia</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style14 s">informe_general_gtia</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style14 s">seguro_desempleo</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row77">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['matricula'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['direccion_gtia'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['valor_p_gtia'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['informe_general_gtia'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['seguro_desempleo'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row78">
            <td class="column0">&nbsp;</td>
            <td class="column1 style14 s">numero_poliza</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style14 s">estado_reclamacion</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style14 s">amparo</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style14 s">cliente_fallecido</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style14 s">periodo_cotizado</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row79">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['numero_poliza'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['estado_reclamacion'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['amparo'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['cliente_fallecido'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['periodo_cotizado'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row80">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row81">
            <td class="column0">&nbsp;</td>
            <td class="column1 style29 s style29" colspan="9">DATOS ASIGNACION Y LIBRANZAS</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row82">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row83">
            <td class="column0">&nbsp;</td>
            <td class="column1 style13 s">marca_1</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style13 s">tipo_gestor</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style13 s">codigo_exclusion</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style13 s">gestor</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style13 s">zona</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row84">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['marca_1'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['tipo_gestor'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['codigo_exclusion'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['gestor'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['zona'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row85">
            <td class="column0">&nbsp;</td>
            <td class="column1 style13 s">territorial</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style13 s">responsable</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style13 s">codigo_estrategia</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style13 s">tipo_judicial</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style13 s">territorial_mayor</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row86">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['territorial'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['responsable'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['codigo_estrategia'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['tipo_judicial'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['territorial_mayor'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row87">
            <td class="column0">&nbsp;</td>
            <td class="column1 style13 s">tipo_cobro</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style13 s">tipo_reparto_1</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style13 s">tipo_reparto</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style13 s">fecha_asignacion</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style13 s">fecha_corte</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row88">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['tipo_cobro'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['tipo_reparto_1'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['tipo_reparto'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style7 null">'.$oh[0]['fecha_asignacion'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style7 null">'.$oh[0]['fecha_corte'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row89">
            <td class="column0">&nbsp;</td>
            <td class="column1 style13 s">segmentacion_asignacion</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style13 s">ciudad</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style13 s">zona_mayor</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style13 s">centro_mayor</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style13 s">departamento_mayor</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row90">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['segmentacion_asignacion'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['ciudad'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['zona_mayor'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['centro_mayor'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['departamento_mayor'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row91">
            <td class="column0">&nbsp;</td>
            <td class="column1 style13 s">cambio_reparto</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style13 s">forzaje</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style13 s">centro_gestor</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style13 s">nombre_centro_gestor</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style13 s">tipo_attrition</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row92">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['cambio_reparto'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['forzaje'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 n">'.$oh[0]['centro_gestor'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['nombre_centro_gestor'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['tipo_attrition'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row93">
            <td class="column0">&nbsp;</td>
            <td class="column1 style13 s">tipo_libranza</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style13 s">cod_em</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style13 s">convenio</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style13 s">segmento_lbz</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style13 s">indicador_actual</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row94">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['tipo_libranza'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['cod_em'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['convenio'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['segmento_lbz'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['indicador_actual'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row95">
            <td class="column0">&nbsp;</td>
            <td class="column1 style13 s">causal_no_descuento</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style13 s">cuota_ini</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style13 s">cuota_actual</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style13 s">porcentaje_dto_libranza</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style13 s">alternativa_norm</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row96">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['causal_no_descuento'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['cuota_ini'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['cuota_actual'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['porcentaje_dto_libranza'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['alternativa_norm'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row97">
            <td class="column0">&nbsp;</td>
            <td class="column1 style13 s">|</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style13 s">cli_lib</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style13 s">pagador_soi</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row98">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s"></td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['cli_lib'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['pagador_soi'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row99">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row100">
            <td class="column0">&nbsp;</td>
            <td class="column1 style15 s style15" colspan="9">DATOS ESTRATEGIAS</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row101">
            <td class="column0">&nbsp;</td>
            <td class="column1">&nbsp;</td>
            <td class="column2">&nbsp;</td>
            <td class="column3">&nbsp;</td>
            <td class="column4">&nbsp;</td>
            <td class="column5">&nbsp;</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row102">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s">vector_mora_6m</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style2 s">collection_score</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style2 s">calificacion</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style2 s">alternativa_normalizacion</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style2 s">con_estrategia</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row103">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 n">'.$oh[0]['vector_mora_6m'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 n">'.$oh[0]['collection_score'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['calificacion'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['alternativa_normalizacion'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['con_estrategia'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row104">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s">c_collection_score</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style2 s">semana</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style2 s">segmento_ii</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style2 s">refis_cliente</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style2 s">reest_particulares</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row105">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['c_collection_score'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['semana'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['segmento_ii'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['refis_cliente'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['reest_particulares'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row106">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s">rediferidos</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style2 s">congelada</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style2 s">probabilidad_pago</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style2 s">puntuacion</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style2 s">percentil_probabilidad</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row107">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['rediferidos'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['congelada'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['probabilidad_pago'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['puntuacion'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['percentil_probabilidad'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row108">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s">probabilidad_pago_py</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style2 s">puntuacion_t</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style2 s">probabilidad_pago_t</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style2 s">situacion_subjetiva</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style2 s">pas_diferido</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row109">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['probabilidad_pago_py'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['puntuacion_t'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['probabilidad_pago_t'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['situacion_subjetiva'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['pas_diferido'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row110">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s">constructor</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style2 s">entrada_ndod</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style2 s">marca_refis</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style2 s">codigo_identificacion</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style2 s">identificacion1</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row111">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['constructor'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['entrada_ndod'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['marca_refis'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['codigo_identificacion'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['identificacion1'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row112">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s">centro_altamira</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style2 s">admon_publica</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style2 s">banca_satelite</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style2 s">clientes</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style2 s">pareto_constructor</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row113">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['centro_altamira'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['admon_publica'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['banca_satelite'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 n">'.$oh[0]['clientes'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['pareto_constructor'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row114">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s">ciudad_cobro_comer</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style2 s">stage_final_ifrs9</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style2 s">saldo_activo_ifrs9</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style2 s">provision_total_ifrs9</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style2 s">base_ifrs9</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row115">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['ciudad_cobro_comer'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 s">'.$oh[0]['stage_final_ifrs9'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['saldo_activo_ifrs9'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 s">'.$oh[0]['provision_total_ifrs9'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 s">'.$oh[0]['base_ifrs9'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row116">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s">provision_faltante_ifrs9</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style2 s">max_dv</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style2 s">f_refis</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style2 s">m_reest</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style2 s">m_mod</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row117">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['provision_faltante_ifrs9'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 n">'.$oh[0]['max_dv'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['f_refis'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7 style3 n">'.$oh[0]['m_reest'].'</td>
            <td class="column8">&nbsp;</td>
            <td class="column9 style3 n">'.$oh[0]['m_mod'].'</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row118">
            <td class="column0">&nbsp;</td>
            <td class="column1 style2 s">estado_hoy</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style2 s">cli_comercial</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style2 s">nivel_ventas2</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
          <tr class="row119">
            <td class="column0">&nbsp;</td>
            <td class="column1 style3 s">'.$oh[0]['estado_hoy'].'</td>
            <td class="column2">&nbsp;</td>
            <td class="column3 style3 n">'.$oh[0]['cli_comercial'].'</td>
            <td class="column4">&nbsp;</td>
            <td class="column5 style3 s">'.$oh[0]['nivel_ventas2'].'</td>
            <td class="column6">&nbsp;</td>
            <td class="column7">&nbsp;</td>
            <td class="column8">&nbsp;</td>
            <td class="column9">&nbsp;</td>
            <td class="column10">&nbsp;</td>
          </tr>
        </tbody>
    </table>
  </body>';

    echo $html;
  }













  public function getTelefonos($tipo, $doc) {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $telefonos = $this->Principal->getTelefonos($doc, $tipo, $data['session']['proyecto_activo']);

    $html = '<script src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/lib/js/core/site.js"></script>';
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
    <th style="text-align: center;"><img src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/img/add.png" style="cursor: pointer;" id="addPhone" alt="Agregar" title="Agregar"/></th>
    <th style="text-align: center;"><img src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/img/active.png" class="' . $imgact . '" style="cursor: pointer;" id="seeActivos" alt="Activos" title="Activos"/></th>
    <th style="text-align: center;"><img src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/img/disbled.png" class="' . $imgiact . '" style="cursor: pointer;" id="seeInactivos" alt="Inactivos" title="inactivos"/></th>
    <th style="text-align: center;"><img src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/img/incomingcall.png" style="cursor: pointer;" alt="Recibir Llamada" title="Recibir Llamada"/></th>
    </tr>
    <tr class="bg-primary">
    <th>Telefono</th>
    <th>Ciudad</th>
    <th>Intensidad</th>
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

      $claseInt = "";
      if($tel['intensidad'] == 0){
        $claseInt = 'style="background: #fedbdb; !important"';
      }

      if($tel['nivelContacto'] < 400){
        $claseInt = 'style="background: #d9ffdc; !important"';
      }

      $html .= '<tr style="cursor: pointer;" id="selectTel" tel="' . $tel['telefono'] . '" idtel="' . $tel['idTelefono'] . '">
      <td '. $claseInt.'><a href="sip:'.$tel['telefono'].'@172.16.0.3">' . $tel['telefono'] . '</a></td>
      <td '. $claseInt.'>' . $tel['idCiudad'] . '</td>
      <td '. $claseInt.'>' . $tel['intensidad'] . '</td>
      <td '. $claseInt.'>' . $agregado . '</td>
      <td '. $claseInt.'><img src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/img/' . $img . '" class="' . $class . '" tel="' . $tel['telefono'] . '" idtel="' . $tel['idTelefono'] . '" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/>&nbsp;&nbsp;&nbsp;<img src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/img/call.png" class="makecall" tel="' . $tel['telefono']
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

    $html = '<script src="https://' . $_SERVER['HTTP_HOST'] . '/modulo_cobranzas/front/lib/js/core/site.js"></script>';
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
      <td>';
      if( $tipo != 0){
        $html .= '<img src="https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/front/img/disbled.png" class="unactiveMail" mail="'.$corr['email'].'" iddir="'.$corr['idEmail'].'" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/>
        &nbsp;&nbsp;&nbsp;<img src="https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/front/img/acuerdo_icon.png" class="sendMailAcuerdo" direccion="'.$corr['email'].'" style="cursor: pointer; width: 20px;" alt="Acuerdo de Pago" title="Acuerdo de Pago"/>
      &nbsp;&nbsp;&nbsp; <img src="https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/front/img/propuesta_icon.png" class="sendMailPropuesta" direccion="'.$corr['email'].'" style="cursor: pointer; width: 20px;" alt="Propuesta de Pago" title="Propuesta de Pago"/>
    &nbsp;&nbsp;&nbsp;<img src="https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/front/img/desistimiento.png" class="sendMailDesistimiento" direccion="'.$corr['email'].'" style="cursor: pointer; width: 20px;" alt="Desisitimiento" title="Desisitimiento"/>';
  }else if( $tipo == 0){
    $html .= '<img src="https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/front/img/active.png" class="activeMail" mail="'.$corr['email'].'" iddir="'.$corr['idEmail'].'" style="cursor: pointer;" alt="Desactivar" title="Desactivar"/>';
  }


  $html .= '</td>
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
    <option value="Bogota">Bogota</option>
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

      if($data['session']['perfil'] < 4){
        $result = $this->Principal->buscarxdocinactivo($valor, "0", $data['session']['proyecto_activo']);
      }else{
        $result = $this->Principal->buscarxdoc($valor, "0", $data['session']['proyecto_activo']);
      }
      //$result = $this->Principal->buscarxdoc($valor, $lastEvent[0]['ultimo'], $data['session']['proyecto_activo']);
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

  public function saveinfocl() {


    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $doc = $this->input->post('docu');
    $txt = $this->input->post('txt');

    $this->utilidades->saveEvent("Actualiza info cliente: ".$doc." -> " . $txt, $data['session']['id'], $data['session']['proyecto_activo'], NULL, NULL, NULL);
    $lastEvent = $this->Principal->getLastEvent($data['session']['proyecto_activo']);

    $this->Principal->updateinfocliente($doc, $txt, $data['session']['proyecto_activo']);


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
      echo "<script>location.href ='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/cliente/" . $result[0]['idCliente']."';</script>";
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

    $data['proy'] = $this->Principal->getProyectDataTxt($data['session']['proyecto_activo']);

    $data['usuariosPr'] = $this->Principal->getUserPr($data['proy'][0]['idProyecto']);
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
    if($data['session']['proyecto_activo'] == "bbva_especial"){
      $this->load->view('templates/dashboardEspecial', $data);
    }else{
      $this->load->view('templates/dashboard', $data);
    }
    $this->load->view('templates/footer', $data);
  }

  public function cliente($slug) {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();
    $data['slug'] = $slug;

    $this->utilidades->saveEvent("Consulta cliente ", $data['session']['id'], $data['session']['proyecto_activo']);
    $lastEvent = $this->Principal->getLastEvent($data['session']['proyecto_activo']);


    if($data['session']['perfil'] < '4'){
      $data['cliente'] = $this->Principal->getDataClienteInactivo($slug, $lastEvent[0]['ultimo'], $data['session']['proyecto_activo']);
    }else{
      $data['cliente'] = $this->Principal->getDataCliente($slug, $lastEvent[0]['ultimo'], $data['session']['proyecto_activo']);
    }

 
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
    $data['poderes'] = $this->Principal->getPoderes($data['cliente'][0]['documento'], $data['session']['proyecto_activo']);
    $data['feedback'] = $this->Principal->getFeedback($data['cliente'][0]['documento'], $data['session']['proyecto_activo']);

    if($data['session']['proyecto_activo'] == 'bbva'){
      $data['ratificaciones'] = $this->Principal->getRatificaciones($data['cliente'][0]['documento'], $data['session']['proyecto_activo']);
      $data['cotitulares'] = $this->Principal->getCotitulares($data['cliente'][0]['documento'], $data['session']['proyecto_activo']);
    }
    
    $data['correos'] = $this->Principal->getCorreos($data['cliente'][0]['documento'], '1', $data['session']['proyecto_activo']);
    $data['referencias'] = $this->Principal->getReferencias($data['cliente'][0]['documento'],  $data['session']['proyecto_activo']);
    $data['dinamicos'] = $this->Principal->getDinamicos($data['session']['proyecto_activo']);
    $data['ciudades'] = $this->Principal->getCiudades($data['session']['proyecto_activo']);
    $data['actividades'] = $this->Principal->getActividadCl($data['session']['proyecto_activo']);
    $data['archivoscl'] = $this->Principal->getArchivosCliente($data['cliente'][0]['documento'], $data['session']['proyecto_activo']);


    if($data['session']['proyecto_activo'] == "credivalores"){
      $data['juridicos'] = $this->Principal->getJuridicos($data['cliente'][0]['documento'], $data['session']['proyecto_activo']);
    }else{
      $data['juridicos'] = "";
    }

    $this->utilidades->saveEvent("Consulta cliente: " . $data['cliente'][0]['documento'], $data['session']['id'], $data['session']['proyecto_activo']);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);

    if($data['session']['perfil'] == "8"){
      $this->load->view($data['session']['proyecto_activo'] . '/clienteRemoto', $data);
      $this->load->view('templates/actionRemoto', $data);
    }else{
      $this->load->view($data['session']['proyecto_activo'] . '/cliente', $data);
      $this->load->view('templates/action', $data);
    }

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

  public function unactivatemail() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();
    $dire = $this->input->post('dire');
    $iddire = $this->input->post('iddir');

    $this->Principal->unactivatemail($iddire, $data['session']['proyecto_activo']);
    $doc = $this->Principal->getdocmail($iddire, $data['session']['proyecto_activo']);

    $this->utilidades->saveEvent("Inactiva direccion: " . $dire, $data['session']['id'], $data['session']['proyecto_activo']);

    $this->getMails('0', $doc[0]['documento']);
  }

  public function detallepagos() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    if($data['session']['perfil'] < 5){
        $data['totalPagos'] = $this->Principal->getTotalPagosList('0', $data['session']['proyecto_activo']);
    }else{
        $data['totalPagos'] = $this->Principal->getTotalPagosList($data['session']['id'], $data['session']['proyecto_activo']);
    }

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('pages/detallepagos', $data);
    $this->load->view('templates/footer', $data);
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


  public function activatemail() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();
    $dir = $this->input->post('dire');
    $iddire = $this->input->post('iddir');

    $this->Principal->activatemail($iddire, $data['session']['proyecto_activo']);
    $doc = $this->Principal->getdocmail($iddire, $data['session']['proyecto_activo']);

    $this->utilidades->saveEvent("Activa direccion: " . $dir, $data['session']['id'], $data['session']['proyecto_activo']);

    $this->getMails('1', $doc[0]['documento']);
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

  public function inactivosmail() {

    $doc = $this->input->post("docu");
    $this->getMails('0', $doc);
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
    $fec = date("Y-m-d H:i:s");

    //Valida si ya lo tomo
     
    $verifica = $this->Principal->getlogasignacion($doc, $data['session']['id'], $data['session']['proyecto_activo']);
    if(!isset($verifica[0]['documento'])){

      $this->Principal->markasignacion($doc, $data['session']['id'], $data['session']['proyecto_activo']);
      $dataCl = $this->Principal->getClientesDoc($doc, $data['session']['proyecto_activo']);
      $res = 0;
      if(isset($dataCl[0]['ultimaGestion'])){
        $res = $dataCl[0]['ultimaGestion'];
      }
      $this->Principal->savelogasignacion($fec, $data['session']['id'], $doc, $res, $data['session']['proyecto_activo']);

      echo "1";

    }else{
      echo substr($verifica[0]['fecha'], 0, 10);
    }
    

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
    $memo = utf8_decode($this->input->post('memog'));
    $documento = $this->input->post('docu');
    $prom = $this->input->post('prom');
    $flag = $this->input->post('flag');
    $dinamica = $this->input->post('dinamica');
    $fecha = date("Y-m-d H:i:s");
    $fechaSola = date("Y-m-d");
    $hora = date("H");

    $txtgest = $this->utilidades->cleanText($memo);


    $nivelNuevo = $this->Principal->getResultadoUno($resultado, $data['session']['proyecto_activo']);


    /*$prefec = explode("/", $fecacu);
    $fecacuerdo = $prefec[2] . "-" . $prefec[0] . "-" . $prefec[1];
    $valoracu = str_replace("$", "", $valor);*/
    $valoracu = "";
    $grabacion = 0;

    if($prom != ""){
      $uno = explode("!", $prom);
      $tama = sizeof($uno);
      $tama = $tama - 1;

      for($i = 0; $i<$tama; $i++){
        $pr = explode("&", $uno[$i]);
        $m = explode("/",$pr[1]);
        if(isset($m[2])){
          $fecp = $m[2]."-".$m[0]."-".$m[1];
        }else{
          $fecp = $pr[1];
        }
        $mespr = $m[0];
        if($pr[0] != ""){
          $this->Principal->saveGestion($documento, $fecha, $hora, $tele, $accion, $contac, $motiv, $resultado, $pr[0], $fecp, $pr[2], $txt, $txtgest, $data['session']['id'], $time, $grabacion[0]['recordingfile'], $activ, $nivelNuevo[0]['nivel'], $data['session']['proyecto_activo']);
          $this->Principal->saveGestionDia($documento, $fecha, $hora, $tele, $accion, $contac, $motiv, $resultado, $pr[0], $fecp, $pr[2], $txt, $txtgest, $data['session']['id'], $time, $grabacion[0]['recordingfile'], $activ, $data['session']['proyecto_activo']);
          $this->Principal->savePromesas($fecp, $pr[2], $mespr, $documento, $pr[0], $data['session']['proyecto_activo']);
          $this->Principal->updateFecPromesa($fecp, $pr[2], $documento, $data['session']['proyecto_activo']);
          $valoracu += $pr[2];
          $fecacuerdo = $fecp;
          $maxCall = $this->Principal->getMaxCall($documento, $data['session']['proyecto_activo']);

          if ($dinamica != "") {
            $preD = explode("|", $dinamica);
            $tamara = sizeof($preD) - 1;
            for ($is = 0; $is < $tamara; $is++) {
              $postD = explode(":", $preD[$is]);
              $this->Principal->updateDinamic($postD[0], $postD[1], $maxCall[0]['max'], $data['session']['proyecto_activo']);
            }
          }
        }

      }
    }else{
      $this->Principal->saveGestion($documento, $fecha, $hora, $tele, $accion, $contac, $motiv, $resultado, NULL, NULL, NULL, $txt, $txtgest, $data['session']['id'], $time, $grabacion[0]['recordingfile'], $activ, $nivelNuevo[0]['nivel'], $data['session']['proyecto_activo']);
      $this->Principal->saveGestionDia($documento, $fecha, $hora, $tele, $accion, $contac, $motiv, $resultado, NULL, NULL, NULL, $txt, $txtgest, $data['session']['id'], $time, $grabacion[0]['recordingfile'], $activ, $data['session']['proyecto_activo']);
      $maxCall = $this->Principal->getMaxCall($documento, $data['session']['proyecto_activo']);

      if ($dinamica != "") {
        $preD = explode("|", $dinamica);
        $tamara = sizeof($preD) - 1;
        for ($is = 0; $is < $tamara; $is++) {
          $postD = explode(":", $preD[$is]);
          $this->Principal->updateDinamic($postD[0], $postD[1], $maxCall[0]['max'], $data['session']['proyecto_activo']);
        }
      }
    }


    $cliente = $this->Principal->getDataClienteDoc($documento, $data['session']['proyecto_activo']);


    $nivelActual = $this->Principal->getResultadoUno($cliente[0]['mejorGestion'], $data['session']['proyecto_activo']);
    
    $nivelTelefono = $this->Principal->getTelefonoUno($tele, $data['session']['proyecto_activo']);

    if ($cliente[0]['mejorGestion'] == 0) {
      $this->Principal->saveMejorGestion($documento, $resultado, $resultado, $fechaSola, $data['session']['proyecto_activo']);
    } else if ($nivelNuevo[0]['nivel'] < $nivelActual[0]['nivel']) {
      $this->Principal->saveMejorGestion($documento, $resultado, $resultado, $fechaSola, $data['session']['proyecto_activo']);
    }



    $intensidad = $nivelTelefono[0]['intensidad'];

    $intensidad += 1;

    $this->Principal->setIntensidad($tele, $intensidad, $data['session']['proyecto_activo']);

    //mejor gestion 180

    $nivelActual180 = $this->Principal->getResultadoUno($cliente[0]['mejorgestion180'], $data['session']['proyecto_activo']);


    if ($cliente[0]['mejorgestion180'] == 0) {
      $this->Principal->saveMejorGestion180($documento, $resultado, $resultado, $fechaSola, $data['session']['proyecto_activo']);
    } else if ($nivelNuevo[0]['nivel'] < $nivelActual180[0]['nivel']) {
      $this->Principal->saveMejorGestion180($documento, $resultado, $resultado, $fechaSola, $data['session']['proyecto_activo']);
    }


    //mejor gestion mes

    $nivelActualMes = $this->Principal->getResultadoUno($cliente[0]['mejorgestionmes'], $data['session']['proyecto_activo']);


    if ($cliente[0]['mejorgestionmes'] == 0) {
      $this->Principal->saveMejorGestionMes($documento, $resultado, $resultado, $fechaSola, $data['session']['proyecto_activo']);
    } else if ($nivelNuevo[0]['nivel'] < $nivelActualMes[0]['nivel']) {
      $this->Principal->saveMejorGestionMes($documento, $resultado, $resultado, $fechaSola, $data['session']['proyecto_activo']);
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
    $asignado = '';
    if(isset($contactoUno[0]['idGrupo'])){
      if($contactoUno[0]['idGrupo'] == '1'){
        if(isset($cliente[0]['idAsesor'])){
          if($cliente[0]['idAsesor'] > "199" && $cliente[0]['idAsesor'] < "301"){
              $asignado = '1';
          }
        }
      }
    }

    $nivel180 = $this->Principal->getResultadoUno($cliente[0]['mejorgestion180'], $data['session']['proyecto_activo']);

    if($asignado != 1){
      if($resultado == 26 || $resultado == 12 || $resultado == 13 || $resultado == 11|| $resultado == 101){
        if(isset($cliente[0]['idAsesor'])){
          if($cliente[0]['idAsesor'] > "199" && $cliente[0]['idAsesor'] < "301"){
              $asignado = '1';
          }
        }
      }
    }

    echo $asignado;

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
    }else if ($filtro == 2) {
      $gestion = $this->Principal->getGestionJudicial($doc, $data['session']['proyecto_activo']);
    }else if ($filtro == 3) {
      $gestion = $this->Principal->getGestionSms($doc, $data['session']['proyecto_activo']);
    }else if ($filtro == 4) {
      $gestion = $this->Principal->getGestionHistorico($doc, $data['session']['proyecto_activo']);
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
      }
      if ($cont[0]['idGrupo'] == 2) {
        $color = 'style="background-color:  #fedbdb;"';
      }
      if ($ges['idResultado'] == 46) {
        $color = 'style="background-color:  #ffc81b;"';
      }

      if ($ges['idResultado'] > 99) {
        $color = 'style="background-color:  #85c1e9;"';
      }

      if ($ges['idAccion'] == 11) {
        $color = 'style="background-color: #e8daef;"';
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

        unlink($filesname);
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


    if($data['session']['perfil'] < 4){
      $result = $this->Principal->buscarxdocinactivo($valor, "0", $data['session']['proyecto_activo']);
    }else{
      $result = $this->Principal->buscarxdoc($valor, "0", $data['session']['proyecto_activo']);
    }


    


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


    if(!isset($siguiente[0]['idTareas'])){
      $this->session->unsetTarea();
      echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/fintarea';</script>";
    }else{
      $this->Principal->markTarea($siguiente[0]['idTareas'], $data['session']['id'], $data['session']['proyecto_activo']);

      $dos = $this->Principal->getNextTareaDos($data['session']['id'], $data['session']['tarea'], $data['session']['proyecto_activo']);
      $id = $this->Principal->getDataClienteDoc($dos[0]['documento'], $data['session']['proyecto_activo']);

      if(isset($id[0]['idCliente'])){
        echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/cliente/" . $id[0]['idCliente'] . "';</script>";
      }else{
        echo "<script>location.href='https://" . $_SERVER['HTTP_HOST'] . "/modulo_cobranzas/index.php/fintarea';</script>";
      }

    }


  }

  public function logout() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();
    $this->session->unsetsession();



    echo "<script>location.href='https://" . $this->config->item('host_usuarios') . "/index.php/logout/".$data['session']['id']."';</script>";
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
        $html .= '<tr style="cursor: pointer;" onclick="location.href=\'https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/index.php/fastsearchurl/'.$ca['documento'].'\'">'
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


  public function preexportainfojudicial($slug) {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('operativo/preexportainfojudicial', $data);
    $this->load->view('templates/footer', $data);
  }

  public function exportainfojudicial() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $data['clientes'] = $this->Principal->getClientes($data['session']['proyecto_activo']);
    $this->load->view('operativo/exportainfojudicial', $data);
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


  public function preexportarinformev1() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('operativo/preexportev1', $data);
    $this->load->view('templates/footer', $data);
  }

  public function exportarinformev1() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();


    $data['ini'] = $this->input->post('fechaIni');
    $data['fin'] = $this->input->post('fechaFin');
    // $this -> load -> library('Estadocartera');

    /*$prefechaini = explode("/", $data['ini']);
    $fechaini = $prefechaini[2]."-".$prefechaini[0]."-".$prefechaini[1];
    $prefechafin = explode("/", $data['fin']);
    $fechafin = $prefechafin[2]."-".$prefechafin[0]."-".$prefechafin[1];*/


    //$this -> estadocartera -> export($data['session']['proyecto_activo']);
    //$data['llamadas'] = $this->Principal->getTotalCalls($fechaini, $fechafin, $data['session']['proyecto_activo']);
    $data['llamadas'] = $this->Principal->getListAsignaciones($data['session']['proyecto_activo']);
    $this->load->view('operativo/exportav1', $data);
  }

  public function exportarinformev2() {

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
    $this->load->view('operativo/exportav2', $data);
  }

  public function preexportarinformev2() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('operativo/preexportev2', $data);
    $this->load->view('templates/footer', $data);
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

    $this->Principal->unactivateAcuerdo($oh, $data['session']['proyecto_activo']);
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
    <body style="border-collapse: collapse; border: 1px solid #000;">
    <div style="width: 90%; border-collapse: collapse; border: 1px solid #000;">
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
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">1. El presente Acuerdo de Pago no implica novación ni reestructuración de(los) contrato(s) objeto de esta negociación. Deberá ser presentado en la sucursal al momento del pago.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">2. EL DEUDOR efectuará los pagos a los créditos únicamente en las Sucursales de  EL BANCO y dentro de los horarios autorizados. En consecuencia, los funcionarios de LA AGENCIA o los Abogados Externos no están facultados para recibir dineros, salvo que se trate del pago de honorarios profesionales. En caso que EL DEUDOR excepcionalmente realice el pago de honorarios directamente a la AGENCIA y/o Abogado Externo, deberá exigir la expedición del correspondiente recibo por ese concepto.  El(a) deudor(a) se obliga a entregar al día siguiente del pago copia de los recibos a la AGENCIA o al Funcionario del Banco.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">3. El incumplimiento del acuerdo en todo o en parte lo deja sin valor ni efecto y faculta al BANCO para revocar automáticamente  los  beneficios y/o descuentos negociados si hubiere lugar a ello. Los pagos serán  aplicados como simples abonos. Adicionalmente, dará lugar a que el BANCO inicie o impulse el proceso judicial, según corresponda, hasta lograr el pago  total de la deuda. De manera general, la forma en que se aplique cada  uno de  los pagos, se indicará en los comprobantes de pago que expida y entregue el BANCO.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">4. En el evento de existir un proceso judicial, es necesario que para suspender el proceso, se suscriba memorial de común acuerdo. Es de cargo del(los) demandado(s) autenticar el  memorial dirigido al Juez de conocimiento y devolverlo al funcionario con el cual se celebró el acuerdo o al abogado externo que adelanta el proceso judicial. El memorial será presentado al Juzgado una vez se cumpla con el Primer abono. Es de conocimiento de las partes que la suspensión es autorizada  por el Juez, de acuerdo a las etapas procesales y su criterio.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">5. El BANCO solicitará la terminación del proceso judicial siempre y cuando el acuerdo  sea cumplido integralmente. Si dentro de la suspensión del proceso se llegara a cancelar la totalidad de la (s) Obligación (es), se reconocerán honorarios de abogado sobre las sumas recibidas acorde al anexo tarifario.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">6. En el evento de existir un proceso judicial y tratarse de un pago total, será de cargo del(los) demandado(s) con posterioridad al cumplimiento del Acuerdo de pago, acercarse(n) al juzgado de conocimiento a fin de obtener a su cargo, oficio de desembargo y el desglose de los documentos (pagaré y escritura pública de hipoteca o prenda).</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">7. Si el deudor cuenta con otras obligaciones como titular, cotitular o codeudor, que presentan moras, contará con un plazo de 5 días hábiles para la normalización y evitar que se genere el incumplimiento sobre todo el acuerdo y la pérdida de sus beneficios, los cuales pueden comprender condonaciones.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">8. Cuando se trate de pago total de crédito hipotecario o prendario los pasivos que registre el inmueble o el vehículo y los gastos y tramites de levantamiento de hipoteca o prenda, según corresponda, debe asumirlos EL DEUDOR y /o propietario.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">9. EL DEUDOR y/o demandado(s), interesado(s), reconoce y acepta que adeuda honorarios y/o gastos derivados de la gestión de cobranza y por ende acuerda pagarlos. Estos valores están debidamente incorporados en el presente Acuerdo de pago.  En caso de incumplimiento los costos por concepto de Honorarios Abogado y gastos de proceso serán asumidos directamente por EL DEUDOR, pudiendo modificar lo pactado inicialmente en este acuerdo de pago.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">10. El DEUDOR reconoce y acepta que las tarjetas de crédito y/o cupos rotativos que hagan parte del acuerdo, serán dadas de baja, cancelando el contrato y el plástico.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">11. Hacer uso de las tarjetas de crédito y/o cupos rotativos una vez cumplido el acuerdo de pago deja sin efecto y pierde los beneficios otorgados en el presente acuerdo.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">12. EL DEUDOR autoriza a la AGENCIA para ser contactado vía WhatsApp a los números de celulares confirmados en este acuerdo de pago a efectos realizar  seguimiento y gestión de cobro.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">13. En el evento en que el deudor cuente con garantías FNG o FAG que hayan sido debidamente cobradas, tendrá la obligación de realizar acuerdo de pago con esas entidades. En todo los casos en que existe un proceso judicial, este no podrá ser terminado, ni levantadas las medidas cautelares, sin que exista orden de del FNG (En los casos donde existe venta a CISA esta será la entidad que se subrogue)  FAG.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">14. EL DEUDOR y sus apoderados, desisten y/o renuncian a ejercer o continuar toda acción o pretensión, llamamiento en garantía, queja o reclamo judicial o extrajudicial, administrativa, indemnización por actuación de parte civil dentro de un proceso penal, y en general desisten y/o renuncian a toda reclamación de cualquier índole o naturaleza que pudiera entablar o hubiesen entablado por los hechos relacionados con sus créditos, o los que estuvieran indirectamente relacionados con los fundamentos expuestos en los pleitos, declarando a paz y salvo por todo concepto al Grupo BBVA COLOMBIA S.A, a sus Apoderados Judiciales y  Agencia de Cobranza.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">15. Durante la vigencia del plan de pagos establecido en el presente compromiso, la(s) obligación(es) podrá(n) ser castigada(s) contablemente, con lo que ello implique.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">16. En caso de existir negociaciones con títulos judiciales las partes deberán firmar la solicitud de forma conjunta y estarán sujetos a los tiempos procesales, entendiendo que no corresponde a gestiones propias del Banco.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">17. El reporte ante centrales de riesgo, será actualizado según lo dispuesto por Ley 1266 de 2008 y demás normas que lo regulen.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">18. El proceso judicial no podrá ser suspendido en más de 2 oportunidades y por más de 6 meses. El presente documento presta mérito ejecutivo.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">19. No será respetado el acuerdo de pago si no es remitido con las respectivas firmas.</p></td>
    </tr>
    <tr>
    <td style="text-align: left; border-collapse: collapse; border-bottom: 2px solid #000;"><p style="font-size: 6px;">20. Una vez cumplido el acuerdo e informado al Banco, se emitirá el Paz y Salvo a los 15 días hábiles a través de sus oficinas.</p></td>
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

  public function ranking() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();
    //$data['slug'] = $slug;
    //$hoy = date("Y-m-d");
    $data['proyecto_activo']=$data['session']['proyecto_activo'];
    //$mesActual=date("m");

    //select * from proyecto where descripcion = '$id';
    $data['proy'] = $this->Principal->getProyectDataTxt($data['session']['proyecto_activo']);

    //select * from permisosespeciales where carteras like '%$pr%';
    $data['usuariosPr'] = $this->Principal->getUserPr($data['proy'][0]['idProyecto']);

    //$data['productividad'] = $this->Principal->getProductividadHoyUser($hoy, $data['session']['id'], $data['session']['proyecto_activo']);

    //select AES_DECRYPT(documento,  '$this->key') as documento, idAsesor, fechaGestion, idAccion, idContacto, idResultado from 7_callhist_dia where date(fechaGestion) = '$hoy';
    //$data['productividad'] = $this->Principal->getProductividadHoy($hoy, $data['session']['proyecto_activo']);


    
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/ranking', $data);
    $this->load->view('templates/footer', $data);
  }


    public function localizacion() {

    $this->session->valida();
    $data['session'] = $this->session->getSessionData();
    //$data['slug'] = $slug;
    //$hoy = date("Y-m-d");
    $data['proyecto_activo']=$data['session']['proyecto_activo'];
    //$mesActual=date("m");

    //select * from proyecto where descripcion = '$id';
    $data['proy'] = $this->Principal->getProyectDataTxt($data['session']['proyecto_activo']);

    //select * from permisosespeciales where carteras like '%$pr%';
    $data['usuariosPr'] = $this->Principal->getUserPr($data['proy'][0]['idProyecto']);

    //$data['productividad'] = $this->Principal->getProductividadHoyUser($hoy, $data['session']['id'], $data['session']['proyecto_activo']);

    //select AES_DECRYPT(documento,  '$this->key') as documento, idAsesor, fechaGestion, idAccion, idContacto, idResultado from 7_callhist_dia where date(fechaGestion) = '$hoy';
    //$data['productividad'] = $this->Principal->getProductividadHoy($hoy, $data['session']['proyecto_activo']);


    
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/localizacion', $data);
    $this->load->view('templates/footer', $data);
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
