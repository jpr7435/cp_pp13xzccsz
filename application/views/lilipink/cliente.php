<?php
/* * To change this template, choose Tools | Templates * and open the template in the editor. */
$ci2 = &get_instance();
//$us = $ci3->load->model("usuarios");
//$ci2 = &get_instance();
$ci2->load->model("vista");

$carteras = explode(";", $session['carteras']);
$mejor1 = $this->vista->getResultado($cliente[0]['mejorGestion'], $session['proyecto_activo']);
$userG = $this->vista->getusuario($cliente[0]['idAsesor'], $session['proyecto_activo']);
$userG[0]['nombre'] = "Sin usuario";
$ultima = $this->vista->getResultado($cliente[0]['ultimaGestion'], $session['proyecto_activo']);
$casa[0]['descripcion'] ="Sin Casa";
$casa[0]['idcasa'] ="0";
$fila = 0;
$pr = 0;


$tiposimu ="";
if(isset($creditosv[0]['fechadesembolso'])){
  if($creditosv[0]['fechadesembolso'] < '2018-05-01'){
    $tiposimu = 'class="simula"';
  }else{
    $tiposimu = 'class="simulaaval"';
  }
}

?>

<section class="main-container">
  <h1 style="display:none"><?php echo $cliente[0]['nombre'] . " " . $cliente[0]['documento']; ?></h1>
  <input type="hidden" id="documentoActivo" name="documentoActivo" value="<?php echo $cliente[0]['documento']; ?>"/>
  <!-- Page header -->
  <div class="header bg-amarillo">
    <div class="header-content">
      <div class="page-title">
        <i class="icon icon-user position-left"></i> <?php echo $cliente[0]['nombre'] . " - " . $cliente[0]['documento'] . " - $" . number_format($cliente[0]['saldoPareto'], 0) . " - <span style='color: #2E2EFE;'>" . $mejor1[0]['descripcion'] . "</span>"; ?>
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
    <div class="row">
      <div style="clear: both; height: 80px;"></div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-flat borde-azul" style="height: 300px; overflow: auto;">
          <div class="panel-heading">
            <div class="panel-title">
              Datos
            </div>
          </div>
          <div class="panel-body">
            <table style="font-size: 9px;" class="table table-bordered">
              <tr>

                <th style="font-size: 9px;">Ultima Gestion:</th>
                <th style="font-size: 9px;">Fecha Ultima Gestion:</th>
                <th style="font-size: 9px;">Intensidad:</th>
              </tr>
              <tr>

                <td style="font-size: 9px;"><?php echo $ultima[0]['descripcion']; ?></td>
                <td style="font-size: 9px;"><?php echo $cliente[0]['FecUltimaGestion']; ?></td>
                <td style="font-size: 9px;"><?php echo $cliente[0]['intensidad']; ?></td>
              </tr>
              <tr>
                <th style="font-size: 9px;">Usuario:</th>
                <th style="font-size: 9px;">Casa:</th>
              </tr>
              <tr>
                <th style="font-size: 9px; background-color:#d5f5e3 "><?php echo $userG[0]['nombre']; ?></th>
                <th style="font-size: 9px; background-color:#d5f5e3 "><?php echo $casa[0]['descripcion']; ?></th>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-flat borde-amarillo" style="height: 300px; overflow: auto;">
          <div class="panel-heading">
            <div class="panel-title">
              Eventos Recientes
            </div>
          </div>
          <div class="panel-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Evento</th>
                  <th>Fecha</th>
                  <th>Usuario</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($eventos as $ev) {
                  $userEv = $this->vista->getusuario($ev['idUser'], $session['proyecto_activo']);
                  ?>
                  <tr>
                    <td style="font-size: 9px;"><?php echo $ev['evento']; ?></td>
                    <td style="font-size: 9px;"><?php echo $ev['fecha']; ?></td>
                    <td style="font-size: 9px;"><?php echo $userEv[0]['usuario']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-4">

        <div class="panel panel-flat borde-amarillo" style="height: 300px; margin-bottom: 5px !important; overflow: auto;">
          <div class="panel-heading">
            <div class="panel-title">
              Biblioteca de archivos
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="form-group col-sm-12">
                <form name="subir-archivo" id="subir-archivo" method="post" enctype="multipart/form-data" action="http://<?php echo $_SERVER['HTTP_HOST']; ?>/index.php/subirarchivo">
                  <div class="row">
                    <label class="control-label col-lg-4">Nombre:</label>
                    <div class="col-lg-8">
                      <input type="text" placeholder="Nombre del archivo" name="nombreFiles" id="nombreFiles" class="form-control" />
                    </div>
                  </div>
                  <div class="row">
                    <label class="control-label col-lg-4">Cargar Archivo</label>
                    <div class="col-lg-8">
                      <input type="file" name="archivo" id="archivo" class="file-styled-primary-icon">
                      <input type="hidden" id="documentoArchivo" name="documentoArchivo" value="<?php echo $cliente[0]['documento']; ?>"/>
                      <input type="hidden" id="idArchivo" name="idArchivo" value="<?php echo $cliente[0]['idCliente']; ?>"/>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group  col-sm-4">
                      <button class="btn btn-success btn-labeled" id="upload-file-action" type="button"><b><i class="icon-floppy-disk"></i></b>Cargar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div style="clear: both; height: 2px;"></div>
            <div class="row">
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
                      <td><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/front/img/<?php echo $imgfl; ?>" width="20" alt="<?php echo $fi['extension']; ?>" title="<?php echo $fi['extension']; ?>"/></td>
                      <td><a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uploads/clientes/<?php echo $cliente[0]['documento']; ?>/<?php echo $fi['archivo']; ?>"><?php echo $fi['archivo']; ?></a></td>
                      <td><?php echo $fi['fechacargue']; ?></td>
                      <td><?php echo $userBi[0]['usuario']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div><!-- Row Table -->

          </div><!-- Panel body -->
        </div><!-- Panel -->
      </div><!-- Col-md-4 -->
    </div><!-- Row Principal -->
      <div class="row">
        <div class="panel panel-flat">
          <div class="panel-body" style="overflow-x: auto;">
            <div style="margin: 6px;" class="row">
              <label>Clase de documento:</label>
              <select style="width: 250px;" id="filtro-grilla" name="filtro-grilla" class="form-control">
                <option value="0">Todos...</option>
                <?php foreach ($filtros as $value) { ?>
                  <option value="<?php echo $value['clase_de_documento']; ?>"><?php echo $value['clase_de_documento']; ?></option>
                <?php }  ?>
              </select>
            </div>
            <div id="resultado-filtro">
              <table class="table-bordered" style="width: 100% !important;">
                <thead>
                  <tr>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">No Documento</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Factura</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cuotas</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Meses</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Vlr Cuotas</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Aplicado</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cuotas Pagas</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Pareto Saldo</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Arrastre Dias</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dias Mora</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Rango1</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Rango Acumulado</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Rango2</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Expr1</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Base</th>
                    <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">CEBE Explicado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $hoy = date("Y-m-d");
                  $mNovado = 0;
                  $valortot = 0;
                  $credTot = "";
                  foreach ($creditos as $cr) {
                    $credTot .= $cr['obligacion'].",";
                    $valortot += $cr['valor_moneda_sociedad'];
                    ?>
                    <tr>
                      <td style="text-align: center;"><?php echo $cr['obligacion']; ?></td>
                      <td style="text-align: center;"><?php echo $cr['fechafactura']; ?></td>
                      <td style="text-align: center; font-weight: bold;"><?php echo number_format($cr['valor'], 0); ?></td>
                      <td style="text-align: center; font-weight: bold;"><?php echo number_format($cr['cuotas'], 0); ?></td>
                      <td style="text-align: center;"><?php echo $cr['meses']; ?></td>
                      <td style="text-align: center; font-weight: bold;"><?php echo number_format($cr['vrcuotas'], 0); ?></td>
                      <td style="text-align: center; font-weight: bold;"><?php echo number_format($cr['valoraplicado'], 0); ?></td>
                      <td style="text-align: center; font-weight: bold;"><?php echo number_format($cr['cuotaspagas'], 0); ?></td>
                      <td style="text-align: center; font-weight: bold;"><?php echo number_format($cr['saldo'], 0); ?></td>
                      <td style="text-align: center; font-weight: bold;"><?php echo number_format($cr['paretosaldo'], 0); ?></td>
                      <td style="text-align: center; font-weight: bold;"><?php echo number_format($cr['arrastredias'], 0); ?></td>
                      <td style="text-align: center; font-weight: bold;"><?php echo number_format($cr['diasmora'], 0); ?></td>
                      <td style="text-align: center;"><?php echo $cr['rango1']; ?></td>
                      <td style="text-align: center;"><?php echo $cr['rangoacumulado']; ?></td>
                      <td style="text-align: center;"><?php echo $cr['rango2']; ?></td>
                      <td style="text-align: center;"><?php echo $cr['expr1']; ?></td>
                      <td style="text-align: center;"><?php echo $cr['base']; ?></td>
                      <td style="text-align: center;"><?php echo $cr['cebeexplicado']; ?></td>
                    </tr>
                  <?php } ?>
                  <tr style="background-color: #a4a4a4;">
                    <td style="text-align: center; font-weight: bold;"></td>
                    <td style="text-align: center; font-weight: bold;"></td>
                    <td style="text-align: center; font-weight: bold;"></td>
                    <td style="text-align: center; font-weight: bold;"><?php echo number_format($valortot, 0); ?></td>
                    <td style="text-align: center; font-weight: bold;"></td>
                    <td style="text-align: center; font-weight: bold;"></td>
                    <td style="text-align: center; font-weight: bold;"></td>
                  </tr>
                </tbody>
              </table>
            </div>

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
                    <a data-toggle="collapse" data-parent="#accordion-styled" href="#pagos2">Pagos</a>
                  </div>
                </div>
                <div id="pagos2" class="panel-collapse collapse">
                  <div class="panel-body" style="overflow-x: auto;">
                    <table class="table-bordered" style="width: 100% !important;">
                      <thead>
                        <tr>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Pago</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Pago</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Tipo Pago</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Descripcion</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Interes Corriente</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Plataforma</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Interes Mora</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Gastos Cobranza</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Aval</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Iva</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Capital</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Asesor</th>
                          <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Gestion</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($pagos as $pg){
                          $asesorP = $this->vista->getusuario($pg['idAsesor'], $session['proyecto_activo']);
                          ?>
                          <tr>
                            <td style="text-align: center;"><?php echo $pg['obligacion']; ?></td>
                            <td style="text-align: center;"><?php echo $pg['fecha']; ?></td>
                            <td style="text-align: center;"><?php echo number_format($pg['valor'],0); ?></td>
                            <td style="text-align: center;"><?php echo $pg['tipopago']; ?></td>
                            <td style="text-align: center;"><?php echo $pg['descripcion']; ?></td>
                            <td style="text-align: center;"><?php echo number_format($pg['interescorriente'],0); ?></td>
                            <td style="text-align: center;"><?php echo number_format($pg['plataforma'],0); ?></td>
                            <td style="text-align: center;"><?php echo number_format($pg['interesmora'],0); ?></td>
                            <td style="text-align: center;"><?php echo number_format($pg['gastoscobra'],0); ?></td>
                            <td style="text-align: center;"><?php echo number_format($pg['aval'],0); ?></td>
                            <td style="text-align: center;"><?php echo number_format($pg['iva'],0); ?></td>
                            <td style="text-align: center;"><?php echo number_format($pg['capital'],0); ?></td>
                            <td style="text-align: center;"><?php echo $asesorP[0]['usuario']; ?></td>
                            <td style="text-align: center;"><?php echo $pg['gestion']; ?></td>
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
                $promeProm = $this->vista->getpromesaCallhist($ges['idCallhist'], $session['proyecto_activo']);

                if(isset($promeProm[0]['idCallhist'])){
                  $estProm = $this->vista->getPromDesc($promeProm[0]['idCumplido'], $session['proyecto_activo']);
                }else{
                  $estProm[0]['descripcion'] = 'Sin Estado';
                }


                if(count($cont) > 0){
                  if ($cont[0]['idGrupo'] == 1) {
                    $color = 'style="background-color:  #d9ffdc;"';
                  }if ($cont[0]['idGrupo'] == 2) {
                    $color = 'style="background-color:  #fedbdb;"';
                  }
                }else{
                  $color = 'style="background-color:  #fedbdb;"';
                }

                $fecacu = "";

                if ($ges['fechaAcuerdo'] != "0000-00-00" && $ges['fechaAcuerdo'] != "") {
                  $fecacu = $ges['fechaAcuerdo'];
                }
                ?>

                <div class="panel">
                  <div class="panel-heading" <?php echo $color; ?>>
                    <div class="panel-title">
                      <a <?php echo $class; ?> data-toggle="collapse" data-parent="#accordion-styled" href="#<?php echo $ges['idCallhist']; ?>"><?php echo $ges['fechaGestion'] . " - " . $user[0]['usuario'] . " - Tel: " . $ges['telefono']
                      . " - " . $result[0]['descripcion'] . " - " . $fecacu . " - ". number_format($ges['vlAcuerdo']) . " - " .  $estProm[0]['descripcion'] ?></a>
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
              <!--<div class="panel">
              <div class="panel-heading bg-success">
              <div class="panel-title">
              <a class="collapsed" data-toggle="collapse" data-parent="#accordion-styled" href="#accordion-styled-group2">Accordion Item #2</a>
            </div>
          </div>
          <div id="accordion-styled-group2" class="panel-collapse collapse">
          <div class="panel-body">
          Тon cupidatat skateboard dolor brunch. Тesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda.
        </div>
      </div>
    </div>

    <div class="panel">
    <div class="panel-heading bg-primary">
    <div class="panel-title">
    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-styled" href="#accordion-styled-group3">Accordion Item #3</a>
  </div>
</div>
<div id="accordion-styled-group3" class="panel-collapse collapse">
<div class="panel-body">
3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it.
</div>
</div>
</div>-->
</div>
</div>
</div>
</div>
</div>
</div>
</section>