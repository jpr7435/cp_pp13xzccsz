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
      <div class="row">
        <div class="panel panel-flat">
          <div class="panel-body" style="overflow-x: auto;">
            <table class="table-bordered" style="width: 250% !important;">
              <thead>
                <tr>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Acuerdo</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Subproducto</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dias Vencidos</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dias Actual</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Frana Obligacion</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Capital Activo</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Mora</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Mora Actual</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo Total</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Castigo</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Minimo Negociacion</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Pago a 3 Cuotas</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Pago a 12 Cuotas</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Campaña</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Franja Actual</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Estado Evolutivo</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Evolutivo</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Desembolso</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Segmento Libranzas</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Convenio</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Placa</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Marca</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Modelo</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cliente Fallecido</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Estado Reclamacion</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Codigo Estrategia</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Maxcalgtia</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Refis Cliente</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Etapa Procesal</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Abogado Externo</th>
                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Macro Etapa Matriz</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $totalmora = 0;
                $totalcapital = 0;
                $totalsaldo = 0;
                $totaldesem = 0;
                $totalvlmin = 0;
                $maxdias = 0;
                $totalpiso = 0;
                $totalacuo = 0;
                $totalacuodoce = 0;
                $diasActuTotal = 0;
                $moraActuTotal = 0;
                $maxdiasActu = 0;

                foreach ($creditos as $cr) {

                  $totalmora += $cr['valormora'];
                  $totalcapital += $cr['capitalactivo'];
                  $totalsaldo += $cr['saldototal'];
                  $totaldesem += $cr['valordesembolso'];


                  if ($maxdias < $cr['diasvencidos']) {
                    $maxdias = $cr['diasvencidos'];
                  }

                  if ($maxdiasActu < $cr['dias_mora_actual']) {
                    $maxdiasActu = $cr['dias_mora_actual'];
                  }


                  /*  Descuento */
                  $capiacti = $cr['capitalactivo']; //$cliente[0]['saldoPareto'];
                  $anocas = $cr['anocastigo'];
                  $precincomillvl = 0;
                  $cincomillvl = 0;


$totalvlmin += $cincomillvl;

$totalpiso += $cr['pisonegociacion'];
$totalacuo += $cr['pagoacuotas'];
$totalacuodoce += $cr['pagoa12cuotas'];

$diasActuTotal += $cr['dias_mora_actual'];
$moraActuTotal += $cr['valor_mora_actual'];

/* FIN Descuento */
?>
<tr>
  <td style="text-align: center; cursor: pointer;" capital="<?php echo $cr['capitalactivo']; ?>" piso="<?php echo $cr['pisonegociacion']; ?>" cuotas="<?php  echo $cr['pagoacuotas']; ?>" oh="<?php echo $cr['obligacion']; ?>" class="add-acuerdo"><i class="icon icon-plus22"></i></td>
  <td style="text-align: center;"><?php echo $cr['obligacion']; ?></td>
  <td style="text-align: center;"><?php echo $cr['lineasubproducto']; ?></td>
  <td style="text-align: center;"><?php echo number_format($cr['diasvencidos'],0); ?></td>
  <td style="text-align: center;"><?php echo number_format($cr['dias_mora_actual'],0); ?></td>
  <td style="text-align: center;"><?php echo $cr['franjaobligacion']; ?></td>
  <td style="text-align: center;"><?php echo number_format($cr['capitalactivo'], 0); ?></td>
  <td style="text-align: center;"><?php echo number_format($cr['valormora'], 0); ?></td>
  <td style="text-align: center; background-color: #F5F6CE;"><?php echo number_format($cr['valor_mora_actual'], 0); ?></td>
  <td style="text-align: center;"><?php echo number_format($cr['saldototal'], 0); ?></td>
  <td style="text-align: center;"><?php echo $cr['fechacastigo']; ?></td>
  <td style="text-align: center; background-color: #F5F6CE;"><?php echo number_format($cr['pisonegociacion'], 0); ?></td>
  <td style="text-align: center; background-color: #F5F6CE;"><?php echo number_format($cr['pagoacuotas'], 0); ?></td>
  <td style="text-align: center; background-color: #F5F6CE;"><?php echo number_format($cr['pagoa12cuotas'], 0); ?></td>
  <td style="text-align: center;"><?php echo $cr['campana']; ?></td>
  <td style="text-align: center;"><?php echo $cr['franja_obligacion_actual']; ?></td>
  <td style="text-align: center;  background-color: #F5F6CE;"><?php echo $cr['estado_evolutivo']; ?></td>
  <td style="text-align: center;  background-color: #F5F6CE;"><?php echo $cr['fechaevolutivo2']; ?></td>
  <td style="text-align: center;"><?php echo number_format($cr['valordesembolso'], 0); ?></td>
  <td style="text-align: center;"><?php echo $cr['segmentolbz']; ?></td>
  <td style="text-align: center;"><?php echo $cr['convenio']; ?></td>
  <td style="text-align: center;"><?php echo $cr['placa']; ?></td>
  <td style="text-align: center;"><?php echo $cr['marca']; ?></td>
  <td style="text-align: center;"><?php echo $cr['modelo']; ?></td>
  <td style="text-align: center;"><?php echo $cr['cliente_fallecido']; ?></td>
  <td style="text-align: center;"><?php echo $cr['estado_reclamacion']; ?></td>
  <td style="text-align: center;"><?php echo $cr['codigoestrategia']; ?></td>
  <td style="text-align: center;"><?php echo $cr['maxcalgtia']; ?></td>
  <td style="text-align: center;"><?php echo $cr['marcarefis']; ?></td>
  <td style="text-align: center;"><?php echo $cr['etapaprocesal']; ?></td>
  <td style="text-align: center;"><?php echo $cr['abogadoexterno']; ?></td>
  <td style="text-align: center;"><?php echo $cr['macroetapamatriz']; ?></td>
</tr>
<?php } ?>
<tr style="background-color: #a4a4a4;">
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"><?php echo number_format($maxdias, 0); ?></td>
  <td style="text-align: center; font-weight: bold;"><?php echo number_format($maxdiasActu, 0); ?></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"><?php echo number_format($totalcapital, 0); ?></td>
  <td style="text-align: center; font-weight: bold;"><?php echo number_format($totalmora, 0); ?></td>
  <td style="text-align: center; font-weight: bold;"><?php echo number_format($moraActuTotal, 0); ?></td>
  <td style="text-align: center; font-weight: bold;"><?php echo number_format($totalsaldo, 0); ?></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"><?php echo number_format($totalpiso, 0); ?></td>
  <td style="text-align: center; font-weight: bold;"><?php echo number_format($totalacuo, 0); ?></td>
  <td style="text-align: center; font-weight: bold;"><?php echo number_format($totalacuodoce, 0); ?></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"><?php echo number_format($totaldesem, 0); ?></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
  <td style="text-align: center; font-weight: bold;"></td>
</tr>
</tbody>
</table>
</div>
</div>
</div>

<div class="row">
  <div class="panel panel-flat">
    <div class="panel-body">
      <div class="panel-group accordion" id="accordion-styled">
        <div class="panel">
          <div class="panel-heading">
            <div class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion-styled" href="#pagos">Pagos</a>
            </div>
          </div>
          <div id="pagos" class="panel-collapse collapse">
            <div class="panel-body" style="overflow-x: auto;">
              <table class="table-bordered" style="width: 100% !important;">
                <thead>
                  <tr>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Pago</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Pago</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Pago Banco</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Pago GAC</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Confirmacion Pago</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Tipo GAC</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Asesor</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($pagos as $pg) {
                    $asesorP = $this->vista->getusuario($pg['idAsesor'], $session['proyecto_activo']);
                    ?>
                    <tr>
                      <td style="text-align: center;"><?php echo $pg['obligacion']; ?></td>
                      <td style="text-align: center;"><?php echo $pg['fecha']; ?></td>
                      <td style="text-align: center;"><?php echo number_format($pg['valor'], 0); ?></td>
                      <td style="text-align: center;"><?php echo number_format($pg['valor_banco'], 0); ?></td>
                      <td style="text-align: center;"><?php echo number_format($pg['GAC'], 0); ?></td>
                      <td style="text-align: center;"><?php echo $pg['confirmacionpago']; ?></td>
                      <td style="text-align: center;"><?php echo $pg['tipogac']; ?></td>
                      <td style="text-align: center;"><?php echo $asesorP[0]['usuario']; ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="panel-heading">
              <div class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion-styled" href="#acuerdos">Acuerdos</a>
              </div>
            </div>
            <div id="acuerdos" class="panel-collapse collapse">
              <div class="panel-body" style="overflow-x: auto;">
                <table class="table-bordered" style="width: 100% !important;">
                  <thead>
                    <tr>
                      <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Documento</th>
                      <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                      <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Primer Pago</th>
                      <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Total</th>
                      <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Cuota</th>
                      <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cuotas</th>
                      <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Asesor</th>
                      <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Activo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($acuerdos as $acs) {
                      $asesorP = $this->vista->getusuario($acs['idasesor'], $session['proyecto_activo']);
                      $activos = "No";
                      $odf = "";
                      if ($acs['activo'] == 1) {
                        $activos = "Si";
                        //$pdf = '<a href="http://' . $_SERVER['HTTP_HOST'] . '/index.php/generapdf/' . $acs['idAcuerdo'] . '" target="blanck"><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/pdf2.png" alt="Imprime Acuerdo" title="Imprime Acuerdo"/></a>';
                      }
                      ?>
                      <tr>
                        <td style="text-align: center;"><?php echo $acs['documento']; ?></td>
                        <td style="text-align: center;"><?php echo $acs['obligacion']; ?></td>
                        <td style="text-align: center;"><?php echo $acs['fechapago']; ?></td>
                        <td style="text-align: center;"><?php echo number_format($acs['total'], 0); ?></td>
                        <td style="text-align: center;"><?php echo number_format($acs['valor'], 0); ?></td>
                        <td style="text-align: center;"><?php echo $acs['cuotasTotales']; ?></td>
                        <td style="text-align: center;"><?php echo $asesorP[0]['usuario']; ?></td>
                        <td style="text-align: center;"><?php echo $activos; ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


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

              $archivoGarabacion = "";

              $primer = substr($ges['grabacion'], 1);

              if ($primer == "/") {
                $pre1 = explode('asterisk', $ges['grabacion']);
                $archivoGarabacion = $pre1[1];
              } else {
                $preFe = explode(" ", $ges['fechaGestion']);
                $preFec2 = explode("-", $preFe[0]);
                $archivoGarabacion = "/monitor/" . $preFec2[0] . "/" . $preFec2[1] . "/" . $preFec2[2] . "/" . $ges['grabacion'];
              }
              ?>

              <div class="panel">
                <div class="panel-heading" <?php echo $color; ?>>
                  <div class="panel-title">
                    <a <?php echo $class; ?> data-toggle="collapse" data-parent="#accordion-styled" href="#<?php echo $ges['idCallhist']; ?>"><?php
                    echo $ges['fechaGestion'] . " - " . $user[0]['usuario'] . " - Tel: XXXXX" . substr($ges['telefono'], -3) . " - " . $result[0]['descripcion'] . " - " . $fecacu;
                    if ($session['perfil'] < 6) {
                      if ($ges['grabacion'] != NULL) {
                        echo '<a href="http://172.16.0.3' . $archivoGarabacion . '"><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/speaker.png" alt="Grabacion" title="Grabacion" /></a>';
                      }
                    }
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
