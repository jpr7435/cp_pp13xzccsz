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
        <span style="float: right;"><?php echo $cliente[0]['marcaestrategiacliente']; ?></span>
      </div>
    </div>
  </div>
  <!-- /Page header -->

  <div class="container-fluid page-content">
    <div style="clear: both; height: 60px;"></div>
    <div class="row">
      <div class="col-md-4">
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
                <td><?php echo $userG[0]['usuario']." EXT-".$userG[0]['extension']; ?></td>
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
      <div class="col-md-3">
        <div class="panel panel-flat borde-azul" style="height: 300px; margin-bottom: 5px !important; overflow: auto;">
          <div class="panel-heading">
            <div class="panel-title">
              Informacion del cliente
            </div>
          </div>
          <div class="panel-body">
            <textarea class="form-control" id="infocl-box" style="height: 180px; margin-bottom: 20px;"><?php echo $cliente[0]['informacion']; ?></textarea>
            <button class="btn btn-success" id="saveinfo-cl">Guardar</button>
          </div>
        </div>
      </div>
      <div class="col-md-5">
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
          <table class="table-bordered" style="width: 80% !important;">
            <thead>
              <tr>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Referncia de Pago</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Acuerdo de pago</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Referencia Equipo</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Cuota</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dias Mora</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dias Refr</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Rango Mora</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Rango Rfr</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo Mora</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Total a Pagar Ref</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dia de Pago</th>             
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo Capital</th>                
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Salda Total</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">% Desc</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Pago Descuento</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Descuento</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Ciclo</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Factura Movistar</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Credito</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Nombre del Credito</th>
                <th nowrap style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Refresque</th>

              </tr>
            </thead>
            <tbody>
              <?php
              $vlcuota = 0;
              $saldomora = 0;
              $capital = 0;
              $totalpagar = 0;
              $descuento = 0;
              $factura = 0;
              $moraref = 0;
            foreach ($creditos as $cr) {

                $vlcuota += $cr['valorcuota'];
                $saldomora += $cr['saldomora'];
                $capital += $cr['saldodecapital'];
                $totalpagar += $cr['totalapagar'];
                $descuento += $cr['descuento'];
                $moraref += $cr['refresquetotalapagar'];
               
                ?>
                <tr>
                  <td nowrap style="text-align: center;"><?php echo $cr['obligacion']; ?></td>
                  <td style="text-align: center; cursor: pointer;" oh="<?php echo $cr['obligacion']; ?>" pago="<?php echo $cr['totalapagar']; ?>" class="add-acuerdo2"><i class="icon icon-plus22"></i></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['referenciaequipo']; ?></td>
                  <td nowrap style="text-align: center; background-color: #d5f5e3;"><?php echo number_format($cr['valorcuota'],0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['diasmora']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['refresquedias']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['rangomora']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['refresquerango']; ?></td>
                  <td nowrap style="text-align: center; background-color: #d5f5e3;">  <?php echo number_format($cr['saldomora'], 0); ?> </td>
                  <td nowrap style="text-align: center; background-color: #d5f5e3;">  <?php echo number_format($cr['refresquetotalapagar'], 0); ?>  </td>
                  <td nowrap style="text-align: center;"><?php echo $cr['fechalimitepago']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['saldodecapital'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['totalapagar'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['porcentajedescuento'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo number_format($cr['pagocondescuento'], 0); ?></td>
                  <td nowrap style="text-align: center; background-color: #d5f5e3;"><?php echo number_format($cr['descuento'], 0); ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['ciclo']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['facturamovistar']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['identificadormambu']; ?></td>
                  <td nowrap style="text-align: center;"><?php echo $cr['nombredelprestamo']; ?></td>                  
                  <td nowrap style="text-align: center;"><?php echo $cr['refresquefecha']; ?></td>
                  </tr>
              <?php } ?>
              <tr style="background-color: #a4a4a4;">
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"><?php echo number_format($vlcuota, 0); ?></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"><?php echo number_format($saldomora, 0); ?></td>
                <td style="text-align: center; font-weight: bold;"><?php echo number_format($moraref, 0); ?></td>
                <td style="text-align: center; font-weight: bold;"></td>
                <td style="text-align: center; font-weight: bold;"><?php echo number_format($capital, 0); ?></td>
                <td style="text-align: center; font-weight: bold;"><?php echo number_format($totalpagar, 0); ?></td>
                <td style="text-align: center; font-weight: bold;"><?php echo number_format($descuento, 0); ?></td>
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
            <nav class="tabs-cliente">
              <ul>
                <li class="click-tab" tab="pagos">PAGOS</li>
                <li class="click-tab" tab="acuerdos">ACUERDOS</li>
              </ul>
            </nav>
          </div>
      </div>
    </div>
    



    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">


          
              <div id="pagos" style="display: none;">
                <div style="overflow-x: auto;">
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
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Territorial</th>
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
                          <td style="text-align: center;"><?php echo $pg['territorial']; ?></td>
                          <td style="text-align: center;"><?php echo $asesorP[0]['usuario']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>




              <div id="acuerdos" style="display: none;">
                <div style="overflow-x: auto;">
                  <table class="table-bordered" style="width: 100% !important;">
                    <thead>
                      <tr>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Documento</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Estado Acuerdo</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Primer Pago</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Total</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Cuota</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cuotas</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Asesor</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Activo</th>
                        <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Creacion</th>
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
                          <td style="text-align: center;"><?php echo $acs['estado_acuerdo']; ?></td>
                          <td style="text-align: center;"><?php echo $acs['fechapago']; ?></td>
                          <td style="text-align: center;"><?php echo number_format($acs['total'], 0); ?></td>
                          <td style="text-align: center;"><?php echo number_format($acs['valor'], 0); ?></td>
                          <td style="text-align: center;"><?php echo $acs['cuotasTotales']; ?></td>
                          <td style="text-align: center;"><?php echo $asesorP[0]['usuario']; ?></td>
                          <td style="text-align: center;"><?php echo $activos; ?></td>
                          <td style="text-align: center;"><?php echo $acs['fecha']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
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
          <button type="button" id="gestionCompleta" class="btn btn-info btn-xs">Toda</button>&nbsp;&nbsp;&nbsp;<button type="button" id="gestionEfectiva" class="btn btn-success btn-xs">Efectiva</button>&nbsp;&nbsp;&nbsp;<button type="button" id="gestionSms" class="btn btn-warning btn-xs">SMS</button>&nbsp;&nbsp;&nbsp;<button type="button" id="gestionHistorico" class="btn btn-danger btn-xs">Historico</button></br></br>
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

              if ($ges['idAccion'] == 11) {
                $color = 'style="background-color: #e8daef;"';
              }

              if ($ges['idResultado'] > 89 && $ges['idResultado'] < 100) {
                $color = 'style="background-color: #85c1e9;"';
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
                    echo $ges['fechaGestion'] . " - " . $user[0]['usuario'] . " - Tel: " . $ges['telefono'] . " - " . $result[0]['descripcion'] . " - " . $fecacu;
                    if ($session['perfil'] < 6) {
                      if ($ges['grabacion'] != NULL) {
                        echo '<a href="http://172.16.20.3' . $archivoGarabacion . '"><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/speaker.png" alt="Grabacion" title="Grabacion" /></a>';
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
<input type="hidden" name="pisoGeneral" id="pisoGeneral" value="<?php echo $totalpiso; ?>"/>
