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
$fila = 0;
$pr = 0;
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
            <div class="col-md-6">
                <div class="panel panel-flat borde-azul" style="height: 300px; overflow: auto;">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Datos
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="2">Cuenta Ahorros Bancolombia. No 00589747411</th>
                            </tr>
                            <tr>
                                <td colspan="2">Convenio N°: 50407. A Nombre de Compañía de Créditos Rápidos.</td>
                            </tr>
                            <tr>
                                <th colspan="2">Cuenta Ahorros Davivienda – Formato de Convenios Empresariales </th>
                            </tr>
                            <tr>
                                <td colspan="2">No 452900076244 A Nombre de Compañía de Créditos Rápidos</td>
                            </tr>
                            <tr>
                                <th colspan="2">Pago en Puntos Baloto # Convenio: 951060 Referencia: # Crédito </th>
                            </tr>
                            <tr>
                                <th>Ultima Gestion:</th>
                                <th>Fecha Ultima Gestion:</th>
                            </tr>
                            <tr>
                                <td><?php echo $ultima[0]['descripcion']; ?></td>
                                <td><?php echo $cliente[0]['FecUltimaGestion']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
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
                                        <td><?php echo $ev['evento']; ?></td>
                                        <td><?php echo $ev['fecha']; ?></td>
                                        <td><?php echo $userEv[0]['usuario']." - ".$userEv[0]['extension']; ?></td>
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
                    <table class="table-bordered" style="width: 120% !important;">
                        <thead>
                            <tr>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Estado Credito</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dias Mora</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Desembolso</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Plazo</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Vencimiento</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo al Dia</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Asesor</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor con Descuento</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Credito</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor a Pagar</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Actualizacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $hoy = date("Y-m-d");
                            foreach ($creditosv as $cr) {
                              $dias = $this->vista->restarFechas($cr['fechavencimiento'], $hoy);
                              $usuarios = $this->vista->getusuario($cr['idAsesor'], $session['proyecto_activo']);
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $cr['obligacion']; ?></td>
                                    <td style="text-align: center;"><?php echo $cr['estadocredito']; ?></td>
                                    <td style="text-align: center;"><?php echo number_format($dias, 0); ?></td>
                                    <td style="text-align: center;"><?php echo $cr['fechadesembolso']; ?></td>
                                    <td style="text-align: center;"><?php echo $cr['plazo']; ?></td>
                                    <td style="text-align: center;"><?php echo $cr['fechavencimiento']; ?></td>
                                    <td style="text-align: center; font-weight: bold;"><?php echo number_format($cr['saldoaldia'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo $usuarios[0]['usuario']; ?></td>
                                    <td style="text-align: center; font-weight: bold;"><?php echo number_format($cr['descuento'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo number_format($cr['credito'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo number_format($cr['valorapagaralvencimiento'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo $cr['fechaActualizacion']; ?></td>
                                </tr>
                            <?php } ?>
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
                                        <a data-toggle="collapse" data-parent="#accordion-styled" href="#pagos">Creditos Pagados</a>
                                    </div>
                                </div>
                                <div id="pagos" class="panel-collapse collapse">
                                    <div class="panel-body" style="overflow-x: auto;">
                                      <table class="table-bordered" style="width: 150% !important;">
                                          <thead>
                                              <tr>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Estado Credito</th>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dias Mora</th>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Desembolso</th>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Plazo</th>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Vencimiento</th>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo al Dia</th>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Asesor</th>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor a pagar con Descuento</th>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Credito</th>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor a Pagar</th>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Actualizacion</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php
                                              foreach ($creditosp as $cr) {
                                                  $usuario = $this->vista->getusuario($cr['idAsesor'], $session['proyecto_activo']);
                                                  ?>
                                                  <tr>
                                                      <td style="text-align: center;"><?php echo $cr['obligacion']; ?></td>
                                                      <td style="text-align: center;"><?php echo $cr['estadocredito']; ?></td>
                                                      <td style="text-align: center;"></td>
                                                      <td style="text-align: center;"><?php echo $cr['fechadesembolso']; ?></td>
                                                      <td style="text-align: center;"><?php echo $cr['plazo']; ?></td>
                                                      <td style="text-align: center;"><?php echo $cr['fechavencimiento']; ?></td>
                                                      <td style="text-align: center;"><?php echo number_format($cr['saldoaldia'], 0); ?></td>
                                                      <td style="text-align: center;"><?php echo $usuario[0]['usuario']; ?></td>
                                                      <td style="text-align: center;"><?php echo number_format($cr['saldoaldia'], 0); ?></td>
                                                      <td style="text-align: center;"><?php echo number_format($cr['credito'], 0); ?></td>
                                                      <td style="text-align: center;"><?php echo number_format($cr['valorapagaralvencimiento'], 0); ?></td>
                                                      <td style="text-align: center;"><?php echo $cr['fechaActualizacion']; ?></td>
                                                  </tr>
                                              <?php } ?>
                                          </tbody>
                                      </table>
                                    </div>
                                </div>
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
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Descripcion</th>
                                                  <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Asesor</th>
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
                                                      <td style="text-align: center;"><?php echo $pg['descripcion']; ?></td>
                                                      <td style="text-align: center;"><?php echo $asesorP[0]['usuario']; ?></td>
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
                        Biblioteca de Archivos
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                      <form name="subir-archivo" id="subir-archivo" method="post" enctype="multipart/form-data" action="https://<?php echo $this->config->item("host_cobranzas"); ?>/modulo_cobranzas/index.php/subirarchivo">
                       <label class="control-label col-lg-4">Cargar Archivo</label>
                       <div class="col-lg-8">
                           <input type="file" name="archivo" id="archivo" class="file-styled-primary-icon">
                           <input type="hidden" id="documentoArchivo" name="documentoArchivo" value="<?php echo $cliente[0]['documento']; ?>"/>
                           <input type="hidden" id="idArchivo" name="idArchivo" value="<?php echo $cliente[0]['idCliente']; ?>"/>
                       </div>
                     </form>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-labeled" id="upload-file-action" type="button"><b><i class="icon-floppy-disk"></i></b>Cargar</button>
                    </div>
                    <div id="carrousel" class="file-carrousel">
                      <ul style="list-style: none;">
                      <?php foreach($archivoscl as $fi){
                          $imgfl = "text.png";
                          if($fi['extension'] == ".xls" || $fi['extension'] == ".xlsx"){
                            $imgfl = "excel.png";
                          }else if($fi['extension'] == ".doc" || $fi['extension'] == ".docx"){
                            $imgfl = "word.png";
                          }else if($fi['extension'] == ".ppt" || $fi['extension'] == ".pptx"){
                            $imgfl = "powerpoint.png";
                          }else if($fi['extension'] == ".pdf"){
                            $imgfl = "pdf.png";
                          }else if($fi['extension'] == ".rar" || $fi['extension'] == ".zip"){
                            $imgfl = "zip.png";
                          }else if($fi['extension'] == ".jpg" || $fi['extension'] == ".jepg" || $fi['extension'] == ".tif" || $fi['extension'] == ".bmp" || $fi['extension'] == ".png"){
                            $imgfl = "image.png";
                          }
                          ?>
                          <li style="float: left; text-align: center; margin-right: 10px;"><a target="_blank" href="<?php echo $this->config->item("host_cobranzas"); ?>/modulo_cobranzas/uploads/clientes/<?php echo $cliente[0]['documento']; ?>/<?php echo $fi['archivo']; ?>"><img src="<?php echo $this->config->item("host_cobranzas"); ?>/front/img/<?php echo $imgfl; ?>" alt="<?php echo $fi['extension']; ?>" title="<?php echo $fi['extension']; ?>"/></br><?php echo $fi['archivo']; ?></a></li>
                      <?php } ?>
                    </ul>
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
                                        <a <?php echo $class; ?> data-toggle="collapse" data-parent="#accordion-styled" href="#<?php echo $ges['idCallhist']; ?>"><?php echo $ges['fechaGestion'] . " - " . $user[0]['usuario'] . " - Tel: " . $ges['telefono'] . " - " . $result[0]['descripcion'] . " - " . $fecacu ?></a>
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
