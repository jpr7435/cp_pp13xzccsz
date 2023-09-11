<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);
$mejor1 = $this->vista->getResultado($cliente[0]['mejorGestion'], $session['proyecto_activo']);
$userG = $this->vista->getusuario($cliente[0]['idAsesor'], $session['proyecto_activo']);
$ultima = $this->vista->getResultado($cliente[0]['ultimaGestion'], $session['proyecto_activo']);
$extracto = $this->vista->getExtracto($cliente[0]['documento'], $session['proyecto_activo']);
$fila = 0;
$pr = 0;
?>

<section class="main-container">
  <h1 style="display:none"><?php echo $cliente[0]['nombre'] . " " . $cliente[0]['documento']; ?></h1>
  <input type="hidden" id="documentoActivo" name="documentoActivo" value="<?php echo $cliente[0]['documento']; ?>"/>
  <!-- Page header -->
  <div class="header bg-amarillo">
    <div class="header-content">
      <div style="font-weight: bold;" class="page-title">
        <i class="icon icon-user position-left"></i> <?php echo $cliente[0]['nombre'] . " - " . $cliente[0]['documento'] . " - $" . number_format($cliente[0]['saldoPareto'], 0) . " - <span style='color: #2E2EFE; font-weight: bold; font-size: 14px;'>" . $mejor1[0]['descripcion'] . "</span>"
        ."- <span style='color: #FF0000; font-weight: bold; font-size: 14px;'>".$cliente[0]['estrategia']."</span>"; ?>
        <?php
        if ($session['tarea'] != "") {
          echo '<button class="btn btn-success btn-labeled" id="next-tarea-btn" type="button"><b><i></i></b>Siguiente ' . $session['tarea'] . '</button>';
        }
        ?>
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">
    <div style="clear: both; height: 60px;"></div>
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-flat borde-azul" style="height: 300px; margin-bottom: 5px !important; overflow: auto;">
          <div class="panel-heading">
            <div class="panel-title">
              Datos de Cliente
            </div>
          </div>
          <div class="panel-body">
            <table class="table table-bordered">
              <tr>
                <th>Nombre:</th>
                <th>Documento:</th>
              </tr>
              <tr>
                <td><?php echo $cliente[0]['nombre']; ?></td>
                <td><?php echo $cliente[0]['documento']; ?></td>
              </tr>
              <tr>
                <th>Asesor:</th>
                <th>Fecha Ultima Gestion:</th>
              </tr>
              <tr>
                <td><?php echo $userG[0]['usuario']; ?></td>
                <td><?php echo $cliente[0]['FecUltimaGestion']; ?></td>
              </tr>
              <tr>
                <th>Mejor Gestion:</th>
                <th>Ultima Gestion:</th>
              </tr>
              <tr>
                <td><?php echo $mejor1[0]['descripcion']; ?></td>
                <td><?php echo $ultima[0]['descripcion']; ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-flat borde-amarillo" style="height: 300px; margin-bottom: 5px !important; overflow: auto;">
          <div class="panel-heading">
            <div class="panel-title">
              Biblioteca de archivos
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="form-group col-sm-8">
                <form name="subir-archivo" id="subir-archivo" method="post" enctype="multipart/form-data" action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/subirarchivo">

                  <label class="control-label col-lg-4">Nombre archivo:</label>
                  <div class="col-lg-8">
                    <input type="text" placeholder="Nombre del archivo" name="nombreFiles" id="nombreFiles" class="form-control" />
                  </div>
                  <label class="control-label col-lg-4">Cargar Archivo</label>
                  <div class="col-lg-8">
                    <input type="file" name="archivo" id="archivo" class="file-styled-primary-icon">
                    <input type="hidden" id="documentoArchivo" name="documentoArchivo" value="<?php echo $cliente[0]['documento']; ?>"/>
                    <input type="hidden" id="idArchivo" name="idArchivo" value="<?php echo $cliente[0]['idCliente']; ?>"/>
                  </div>
                </form>
              </div>
              <div class="form-group  col-sm-4">
                <button class="btn btn-success btn-labeled" id="upload-file-action" type="button"><b><i class="icon-floppy-disk"></i></b>Cargar</button>
              </div>
            </div>
            <div style="clear: both; height: 2px;"></div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tipo</th>
                  <th>Nombre</th>
                  <th>Fecha</th>
                  <th>Asesor</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($archivoscl as $fi) {
                  $imgfl = "text.png";
                  if ($fi['extension'] == ".xls" || $fi['extension'] == ".xlsx") {
                    $imgfl = "excel.png";
                  } else if ($fi['extension'] == ".doc" || $fi['extension'] == ".docx") {
                    $imgfl = "word.png";
                  } else if ($fi['extension'] == ".ppt" || $fi['extension'] == ".pptx") {
                    $imgfl = "powerpoint.png";
                  } else if ($fi['extension'] == ".pdf") {
                    $imgfl = "pdf.png";
                  } else if ($fi['extension'] == ".rar" || $fi['extension'] == ".zip") {
                    $imgfl = "zip.png";
                  } else if ($fi['extension'] == ".jpg" || $fi['extension'] == ".jepg" || $fi['extension'] == ".tif" || $fi['extension'] == ".bmp" || $fi['extension'] == ".png") {
                    $imgfl = "image.png";
                  }
                  $userBi = $this->vista->getusuario($fi['idAsesor']);
                  ?>
                  <tr>
                    <td><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/front/img/<?php echo $imgfl; ?>" width="20" alt="<?php echo $fi['extension']; ?>" title="<?php echo $fi['extension']; ?>"/></td>
                    <td><a target="_blank" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/uploads/clientes/<?php echo $cliente[0]['documento']; ?>/<?php echo $fi['archivo']; ?>"><?php echo $fi['archivo']; ?></a></td>
                    <td><?php echo $fi['fechacargue']; ?></td>
                    <td><?php echo $userBi[0]['usuario']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


  <?php if($cliente[0]['segundoalivio'] == 0){ ?>


    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body" style="overflow-x: auto;">
          <table class="table-bordered" style="width: 200% !important;">
            <thead>
              <tr>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Asginacion</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Solicitud</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Numero Cuotas</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fuente Solicitud</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Corte</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Estado Sms</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Grupo Producto</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Linea</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Tasa</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dias Vencidos</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Capital Activo</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo Total</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Mora</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Mora</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo Total</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Tipologia Alivio</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Califica Final 5</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Califica Final 7</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Tipo Gestor</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Gestor</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Territorial</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($creditos as $cr) {

                if($cr['capital_activo'] == ""){
                  $cr['capital_activo'] = 0;
                }
                if($cr['saldo_total'] == ""){
                  $cr['saldo_total'] = 0;
                }

                if($cr['valor_mora'] == ""){
                  $cr['valor_mora'] = 0;
                }

                ?>
                <tr>
                  <td style="text-align: center;"><?php echo $cr['obligacion']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['fecha_asignacion']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['fecha_solicitud']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['numero_cuotas']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['fuente_solicitud']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['corte']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['estado_sms']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['grupo_producto']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['linea']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['tasa_i_cte']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['dias_vencidos']; ?></td>
                  <td style="text-align: center;"><?php echo number_format($cr['capital_activo'],0); ?></td>
                  <td style="text-align: center;"><?php echo number_format($cr['saldo_total'],0); ?></td>
                  <td style="text-align: center;"><?php echo number_format($cr['valor_mora'],0); ?></td>
                  <td style="text-align: center;"><?php echo $cr['fecha_mora']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['tipologia_alivio']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['califica_final_5_niv']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['califica_final_7_niv']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['tipo_gestor']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['gestor']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['territorial']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body" style="overflow-x: auto;">
          <table class="table-bordered" style="width: 200% !important;">
            <thead>
              <tr>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Tipo Oferta</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Linea</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Tasa E.A</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Operacion</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Plazo Max Gracia</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Acepta Alivio GB</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Plazo Gracia GB</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Plazo Rediferido GB</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Meses Adicionales GB</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Estado Aplicacion Alvio GB</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Max Extension Plazo</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Fecha Operacion</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Meses Vencidos al Aplicar</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Valor Causado Total Periodo de G</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Valor Cuota</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Valor Dif Int Gastos</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Valor Total</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Valor Reintengro</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($creditos as $cr) {
                ?>
                <tr>
                  <td style="text-align: center;"><?php echo $cr['obligacion']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['tipo_oferta']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['linea']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['tasa_ea']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['operacion']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['plazo_max_gracia']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['acepta_alivio_gb']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['plazo_gracia_gb']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['plazo_rediferido_gb']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['meses_adicionales_gb']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['estado_aplicación_alivio_gb']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['max_extension_plazo']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['fecha_operacion']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['meses_vencidos_al_aplicar']; ?></td>
                  <td style="text-align: center;"><?php echo number_format($cr['valor_causado_total_periodo_de_g'],0); ?></td>
                  <td style="text-align: center;"><?php echo number_format($cr['valor_cuota'],0); ?></td>
                  <td style="text-align: center;"><?php echo number_format($cr['valor_dif_int_gastos'],0); ?></td>
                  <td style="text-align: center;"><?php echo number_format($cr['valor_total'],0); ?></td>
                  <td style="text-align: center;"><?php echo number_format($cr['valor_reintegro'],0); ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  <?php }else if($cliente[0]['segundoalivio'] == 1){ ?>

    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body" style="overflow-x: auto;">
          <table class="table-bordered" style="width: 200% !important;">
            <thead>
              <tr>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Fecha Solicitud</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Fecha Nueva Solicitud</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Grupo Producto</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Linea</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Tasa I CTE</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Operacion</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Dias Vencidos</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Capital Activo</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Saldo Total</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Valor Mora</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Fecha Mora</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Territorial</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Alternativa Normalizacion</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Operacion Cancelada</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Plazo Max Gracia</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Ofertable</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Acepta Alivio</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Meses Gracia Solicitado</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Plazo Diferir Solicitado</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Plazo Gracia GB</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Estado Aplicacion Alivio</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Fecha Fin UG</th>
                <th style="background-color: #34495e; text-align: center; color: #FFF; font-weight: lighter;">Guion Sugerido</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($creditos as $cr) {
                ?>
                <tr>
                  <td style="text-align: center;"><?php echo $cr['obligacion']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['fecha_solicitud']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['fecha_nueva_solicitud']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['grupo_producto']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['linea']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['tasa_i_cte']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['operacion']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['dias_vencidos']; ?></td>
                  <td style="text-align: center;"><?php echo number_format($cr['capital_activo'],0); ?></td>
                  <td style="text-align: center;"><?php echo number_format($cr['saldo_total'],0); ?></td>
                  <td style="text-align: center;"><?php echo number_format($cr['valor_mora'],0); ?></td>
                  <td style="text-align: center;"><?php echo $cr['fecha_mora']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['territorial']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['alternativa_normalizacion']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['operacion_cancelada']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['plazo_max_gracia']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['ofertable']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['acepta_alivio']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['meses_gracia_solicitado']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['plazo_diferir_solicitado']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['plazo_gracia_gb']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['estado_aplicación_alivio']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['fecha_fin_ug']; ?></td>
                  <td style="text-align: center;"><?php echo $cr['guion_sugerido']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  <?php } ?>

    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-heading">
          <div class="panel-title">
            Gestion Adelantada
          </div>
        </div>
        <div class="panel-body">
          <button type="button" id="gestionCompleta" class="btn btn-info btn-xs">Toda</button>&nbsp;&nbsp;&nbsp;<button type="button" id="gestionEfectiva" class="btn btn-success btn-xs">Efectiva</button></br></br>
          <div class="panel-group accordion gestionAdelantada" id="accordion-styled">
            <?php
            $flag = 0;
            foreach ($gestion as $ges) {


              $class = "";
              $class2 = "in";
              $color = "";
              if ($flag > 0) {
                $class = 'class="collapsed"';
                $class2 = "";
              }
              $result = $this->vista->getResultado($ges['idResultado'], $session['proyecto_activo']);
              $user = $this->vista->getusuario($ges['idAsesor'], $session['proyecto_activo']);
              $cont = $this->vista->getContacto($ges['idContacto'], $session['proyecto_activo']);

              if ($cont[0]['idGrupo'] == 1) {
                $color = 'style="background-color:  #d9ffdc;"';
              }
              if ($cont[0]['idGrupo'] == 2) {
                $color = 'style="background-color:  #fedbdb;"';
              }
              if ($ges['idResultado'] == 46) {
                $color = 'style="background-color:  #ffc81b;"';
              }

              $fecacu = "";

              if ($ges['fechaAcuerdo'] != "0000-00-00" && $ges['fechaAcuerdo'] != "") {
                $fecacu = $ges['fechaAcuerdo'];
              }

              ?>

              <div class="panel">
                <div class="panel-heading" <?php echo $color; ?>>
                  <div class="panel-title">
                    <a <?php echo $class; ?> data-toggle="collapse" data-parent="#accordion-styled" href="#<?php echo $ges['idCallhist']; ?>"><?php
                    echo $ges['fechaGestion'] . " - " . $user[0]['usuario'] . " - Tel: " . $ges['telefono'] . " - " . $result[0]['descripcion'] . " - Obligacion: " . $ges['ohacuerdo'] . " - Meses Alivio: " . $fecacu . " - Plazo: " . $ges['vlAcuerdo'];
                    ?></a>
                  </div>
                </div>
                <div id="<?php echo $ges['idCallhist'] ?>" class="panel-collapse collapse <?php echo $class2; ?>">
                  <div class="panel-body">
                    <?php echo $ges['textoGestion']; ?>
                  </div>
                </div>
              </div>
              <?php
              $flag += 1;
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div id="acuerdopago-modal">
  <table class="table">
    <thead>
      <tr>
        <th style="width: 180px;">Obligacion</th>
        <th style="width: 150px;">Fecha Pago</th>
        <th style="width: 150px;">Valor</th>
        <th>Cuotas</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <select name="ohacuer" id="ohacuer" class="form-control">
            <option value="0">Seleccione..</option>
            <?php foreach ($creditos as $cr2) { ?>
              <option value="<?php echo $cr2['obligacion']; ?>"><?php echo $cr2['obligacion']; ?></option>
            <?php } ?>
          </select>
        </td>
        <td><input type="text" readonly="readonly" style="color: #000;" name="fechas-acuerdos" id="fechas-acuerdos" class="form-control datepicker-here" data-position="bottom left" data-language='en'/></td>
        <td><input type="text" name="valor-acuerdo" id="valor-acuerdo" class="form-control"/></td>
        <td><input type="text" name="cuotas-acuerdo" id="cuotas-acuerdo" class="form-control"/></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="text" readonly="readonly" style="width: 50px; display: none;" name="vlminneg" id="vlminneg"/></td>
        <td><input type="text" readonly="readonly" style="width: 50px; display: none;" name="pagcuotasneg" id="pagcuotasneg"/></td>
        <td><input type="text" readonly="readonly" style="width: 50px; display: none;" name="saldototneg" id="saldototneg"/></td>
      </tr>
      <tr>
        <td><button class="btn btn-success" id="generaAcuerdoCuotas" type="button">Generar</button></td>
        <td><button class="btn btn-danger" id="CancelaAcuerdoCuotas" type="button">Cancelar</button></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  <div id="acuerdo-preliminar" style="width: 100%;"></div>
</div>
