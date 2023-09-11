<?php error_reporting(E_ALL ^ E_NOTICE); ?> 


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
$estr = explode("_", $cliente[0]['estrategia']);
$tramo = $estr[4];
$fila = 0;
$pr = 0;

//print_r($morosidad);
?>







<section class="main-container">
    <h1 style="display:none"><?php echo $cliente[0]['nombre'] . " " . $cliente[0]['documento']; ?></h1>
    <input type="hidden" id="documentoActivo" name="documentoActivo" value="<?php echo $cliente[0]['documento']; ?>"/>
    <!-- Page header -->
    <div class="header bg-amarillo">
        <div class="header-content">
            <div class="page-title">
                <i class="icon icon-user position-left"></i> <?php echo $cliente[0]['nombre'] . " - " . $cliente[0]['documento'] . " - Tramo " . substr($cliente[0]['estrategia'],-1) . " - <span style='color: #2E2EFE;'>" . $mejor1[0]['descripcion'] . "</span>"; ?>
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

            <div class="alert alert-danger">

                <strong><?php echo $cliente[0]['estrategiaPuntual2']; ?></strong>
            </div>


        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-flat">
                    <!--<div class="panel-body">
                        <buton type="button" class="btn btn-success" id="acuerdoBtn">Agregar Acuerdo</button>
                    </div>-->
                    <div class="panel-body">
                        <buton type="button" class="btn btn-success" id="simuladorBtn">Simulador</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-flat borde-azul" style="height: 300px; overflow: auto;">
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
                                        <td><?php echo $userEv[0]['usuario']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; height: 25px;"></div>

        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <div class="panel-title">
                        Biblioteca de Archivos
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <form name="subir-archivo" id="subir-archivo" method="post" enctype="multipart/form-data" action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/modulo_cobranzas/index.php/subirarchivo">
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

                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; height: 15px;"></div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body" style="overflow-x: auto;">
                    <table class="table-bordered" style="width: 150% !important;">
                        <thead>
                            <tr>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Estrategia Puntualmente</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Apertura</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Producto</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Dias Mora</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo Total</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo Capital</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo en Mora</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Capital en Mora</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Intereses</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Interes Mora</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">GAC</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Seguro</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Desembolso</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cuota</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Plazo</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Apertura</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Castigo</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha Actualizacion</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Posible Retiro</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Focalizadas</th>
                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha de Aceleracion</th>







                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $is = 0;


                            foreach ($creditos as $crr) {
                                if ($is == 0) {
                                    $active = 'active';
                                } else {
                                    $active = "";
                                }

                                $calculo = 358;
                                $posibledia = $calculo - $crr['diasMora'];
                                $newdate = strtotime($crr['fechacargue']);
                                $newdate2 = date('Y-m-d', $newdate);
                                $newdate3 = strtotime($newdate2 . "+ $posibledia days");

                                if ($crr['marcasFocalizacion'] == "") {
                                    $dato[0]['descripcion'] = "Sin Focalizacion";
                                } else {
                                    $dato = $ci2->vista->getFocalizacion($crr['marcasFocalizacion'], $session['proyecto_activo']);
                                }
                                ?>
                                <tr>
                                    <td style="text-align: center; background-color: #F78181;"><?php echo $crr['estrategiaPuntual']; ?></td>
                                    <td style="text-align: center;"><?php echo $crr['obligacion']; ?></td>
                                    <td style="text-align: center;"><?php echo $crr['fechaApertura']; ?></td>
                                    <td style="text-align: center;"><?php echo $crr['producto']; ?></td>
                                    <td style="text-align: center;"><?php echo $crr['diasMora']; ?></td>
                                    <td style="text-align: center;"><?php echo "$" . " " . number_format($crr['saldoTotal'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo "$" . " " . number_format($crr['saldoACapital'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo "$" . " " . number_format($crr['saldoMora'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo "$" . " " . number_format($crr['capitalEnMora'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo "$" . " " . number_format($crr['interesesSobreSaldo'], 0); ?></td>
                                    <td style="text-align: center; background-color: #F5F6CE;"><?php echo "$" . " " . number_format($crr['interesesMora'], 0); ?></td>
                                    <td style="text-align: center; background-color: #F5F6CE;"><?php echo "$" . " " . number_format($crr['valorCuotaCargoCobranzas'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo "$" . " " . number_format($crr['valorSeguro'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo "$" . " " . number_format($crr['saldoOriginal'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo "$" . " " . number_format($crr['valorCuota'], 0); ?></td>
                                    <td style="text-align: center;"><?php echo $crr['plazo']; ?></td>
                                    <td style="text-align: center;"><?php echo $crr['fechaApertura']; ?></td>
                                    <td style="text-align: center;"><?php echo $crr['fechaCastigo']; ?></td>
                                    <td style="text-align: center;"><?php echo $crr['fechaActualizacion']; ?></td>
                                    <td style="text-align: center;"><?php echo date("Y-m-d", $newdate3) . "\n"; ?></td>
                                    <td style="text-align: center;"><?php echo $dato[0]['descripcion'];?></td>
                                    <td style="text-align: center;"><?php echo $crr['fch_acelerado']; ?></td>

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
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Descripcion</th>
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
                                                    <td style="text-align: center;"><?php echo $pg['tipodePago']; ?></td>
                                                    <td style="text-align: center;"><?php echo $asesorP[0]['usuario']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Inicio Referencias -->

                            <div class="panel-heading">
                                <div class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion-styled" href="#referencias">Referencias</a>
                                </div>
                            </div>
                            <div id="referencias" class="panel-collapse collapse">
                                <div class="panel-body" style="overflow-x: auto;">
                                    <table class="table-bordered" style="width: 100% !important;">
                                        <thead>
                                            <tr>

                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Nombre Referencia</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Relacion</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Ciudad</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Indicativo</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Telefono Fijo</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Telefono Celular</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($referencias as $rf) {
                                                ?>
                                                <tr>

                                                    <td style="text-align: center;"><?php echo $rf['nombreReferencia']; ?></td>
                                                    <td style="text-align: center;"><?php echo $rf['relacion']; ?></td>
                                                    <td style="text-align: center;"><?php echo $rf['ciudad']; ?></td>
                                                    <td style="text-align: center;"><?php echo $rf['indicativo']; ?></td>
                                                    <td style="text-align: center;"><?php echo $rf['telefonoFijo']; ?></td>
                                                    <td style="text-align: center;"><?php echo $rf['telefonoCelular']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <!-- Fin Referencias -->



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
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Acuerdo</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Cuotas</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Asesor</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Activo</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">PDF</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($acuerdos as $acs) {
                                                $asesorP = $this->vista->getusuario($acs['idAsesor'], $session['proyecto_activo']);
                                                $activos = "No";
                                                $odf = "";
                                                if ($acs['idActivo'] == 1) {
                                                    $activos = "Si";
                                                    $pdf = '<a href="http://' . $_SERVER['HTTP_HOST'] . '/index.php/generapdf/' . $acs['idAcuerdo'] . '" target="blanck"><img src="http://' . $_SERVER['HTTP_HOST'] . '/front/img/pdf2.png" alt="Imprime Acuerdo" title="Imprime Acuerdo"/></a>';
                                                }
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo $acs['documento']; ?></td>
                                                    <td style="text-align: center;"><?php echo $acs['obligacion']; ?></td>
                                                    <td style="text-align: center;"><?php echo $acs['fecha']; ?></td>
                                                    <td style="text-align: center;"><?php echo number_format($acs['valor'], 0); ?></td>
                                                    <td style="text-align: center;"><?php echo $acs['cuotas']; ?></td>
                                                    <td style="text-align: center;"><?php echo $asesorP[0]['usuario']; ?></td>
                                                    <td style="text-align: center;"><?php echo $activos; ?></td>
                                                    <td style="text-align: center;"><?php echo $pdf; ?></td>
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
                            }if ($cont[0]['idGrupo'] == 2) {
                                $color = 'style="background-color:  #fedbdb;"';
                            }

                            $fecacu = "";

                            if ($ges['fechaAcuerdo'] != "0000-00-00" && $ges['fechaAcuerdo'] != "") {
                                $fecacu = $ges['fechaAcuerdo'];
                            }
                            
                            $archivoGarabacion = "";
                            
                            $primer = substr($ges['grabacion'], 1);
                            
                            if($primer == ""){
                                $pre1 = explode('asterisk', $ges['grabacion']);
                                $archivoGarabacion = $pre1[1];
                            }else{
                                $preFe = explode(" ", $ges['fechaGestion']);
                                $preFec2 = explode("-", $preFe[0]);
                                $archivoGarabacion = "/monitor/".$preFec2[0]."/".$preFec2[1]."/".$preFec2[2]."/".$ges['grabacion'];
                            }
                            
                            ?>

                            <div class="panel">
                                <div class="panel-heading" <?php echo $color; ?>>
                                    <div class="panel-title">
                                        <a <?php echo $class; ?> data-toggle="collapse" data-parent="#accordion-styled" href="#<?php echo $ges['idCallhist']; ?>"><?php echo $ges['fechaGestion'] . " - " . $user[0]['usuario'] . " - Tel: " . $ges['telefono'] . " - " . $result[0]['descripcion'] . " - " . $ges['fechaAcuerdo'] . " - " . number_format($ges['vlAcuerdo'],0); if($session['perfil'] < 6){  if($ges['grabacion'] != NULL){ echo '<a href="http://172.16.0.3'.$archivoGarabacion.'"><img src="https://'.$_SERVER['HTTP_HOST'].'/modulo_cobranzas/front/img/speaker.png" alt="Grabacion" title="Grabacion" /></a>'; } } ?></a>
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
<div id="simulador-modal">
    <p class="cerrar-sim">X</p>
    <table class="table table-bordered" style="width: 50%; margin: 30px auto;">
        <thead>
            <tr>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Producto</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Saldo Total Hoy</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Acelerado</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">% Descuento</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Autoriza</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Descuento Capital</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor pago sin GAC</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">%GAC</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor GAC</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Total a pagar</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Beneficio</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Cuota 2 pagos</th>
                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Cuota 3 pagos</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $sald = 0;
            foreach ($creditos as $sim) {

                $sald += $sim['saldoTotal'];
                $fecAcel = $this->vista->getAcelerado($sim['obligacion'], $session['proyecto_activo']);

                if ($fecAcel[0]['date_defined6'] == "") {
                    $acelerado = "No";
                } else {
                    $acelerado = "Si";
                }
                $gac = explode(";", $fecAcel[0]['char_defined6']);

                $limite = 0;

                if ($tramo == 1) {
                    $limite = 40;
                } else if ($tramo == 2) {
                    $limite = 50;
                } else if ($tramo == 3) {
                    $limite = 50;
                }
                ?>
                <tr>
                    <td><?php echo $sim['obligacion']; ?></td>
                    <td><input type="text" style="border: none;text-align: center;" name="<?php echo $sim['obligacion']; ?>saldoTotal" id="<?php echo $sim['obligacion']; ?>saldoTotal" value="<?php echo number_format($sim['saldoTotal'], 0); ?>"/></td>
                    <td><input type="text" style="border: none;text-align: center;" name="<?php echo $sim['obligacion']; ?>acelerado" id="<?php echo $sim['obligacion']; ?>acelerado" value="<?php echo $acelerado; ?>"/></td>
                    <td><select class="form-control calculador" flag="<?php echo $sim['obligacion']; ?>" name="<?php echo $sim['obligacion']; ?>descuento" id="<?php echo $sim['obligacion']; ?>descuento">
                            <option value="0">Seleccione</option>    
                            <?php for ($i = 5; $i <= $limite; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i . " %"; ?></option>
                            <?php } ?>
                        </select></td>
                    <td><input type="text" style="border: none;text-align: center;" name="<?php echo $sim['obligacion']; ?>autoriza" id="<?php echo $sim['obligacion']; ?>autoriza" value="0"/></td>
                    <td><input type="text" style="border: none;text-align: center;" class="vlfinal" name="<?php echo $sim['obligacion']; ?>vlfinal" id="<?php echo $sim['obligacion']; ?>vlfinal" value="0"/></td>
                    <td><input type="text" style="border: none;text-align: center;" class="nuevocap" name="<?php echo $sim['obligacion']; ?>nuevocap" id="<?php echo $sim['obligacion']; ?>nuevocap" value="0"/></td>
                    <td><input type="text" style="border: none;text-align: center;" name="<?php echo $sim['obligacion']; ?>porcgac" id="<?php echo $sim['obligacion']; ?>porcgac" value="<?php echo $gac[2]; ?>"/></td>
                    <td><input type="text" style="border: none;text-align: center;" class="vlgac" name="<?php echo $sim['obligacion']; ?>vlgac" id="<?php echo $sim['obligacion']; ?>vlgac" value="0"/></td>
                    <td><input type="text" style="border: none;text-align: center;" class="vltotal" name="<?php echo $sim['obligacion']; ?>vltotal" id="<?php echo $sim['obligacion']; ?>vltotal" value="0"/></td>
                    <td style="background-color: #F5A9A9;"><input type="text" class="beneficio" style="border: none;text-align: center;" name="<?php echo $sim['obligacion']; ?>beneficio" id="<?php echo $sim['obligacion']; ?>beneficio" value="0"/></td>
                    <td><input type="text" style="border: none;text-align: center;" class="cuota2" name="<?php echo $sim['obligacion']; ?>cuota2" id="<?php echo $sim['obligacion']; ?>cuota2" value="0"/></td>
                    <td><input type="text" style="border: none;text-align: center;" class="cuota3" name="<?php echo $sim['obligacion']; ?>cuota3" id="<?php echo $sim['obligacion']; ?>cuota3" value="0"/></td>
                </tr>

            <input type="hidden" name="<?php echo $sim['obligacion']; ?>saldoTotal2" id="<?php echo $sim['obligacion']; ?>saldoTotal2" value="<?php echo $sim['saldoTotal']; ?>"/>
            <input type="hidden" name="<?php echo $sim['obligacion']; ?>dias" id="<?php echo $sim['obligacion']; ?>dias" value="<?php echo $sim['diasMora']; ?>"/>
            <input type="hidden" name="<?php echo $sim['obligacion']; ?>capTotal" id="<?php echo $sim['obligacion']; ?>capTotal" value="<?php echo $sim['saldoACapital']; ?>"/>
            <input type="hidden" name="<?php echo $sim['obligacion']; ?>capMora" id="<?php echo $sim['obligacion']; ?>capMora" value="<?php echo $sim['capitalEnMora']; ?>"/>
            <input type="hidden" name="<?php echo $sim['obligacion']; ?>modalida" id="<?php echo $sim['obligacion']; ?>modalida" value="<?php echo $fecAcel[0]['number_defined5']; ?>"/>

            <input type="hidden" name="tramos" id="tramos" value="<?php echo $tramo; ?>"/>
        <?php } ?>
        <tr>
            <td style="background-color: #E6E6E6;"></td>
            <td style="background-color: #E6E6E6; text-align: center; font-weight: bold;"><?php echo number_format($sald, 0); ?></td>
            <td style="background-color: #E6E6E6;"></td>
            <td style="background-color: #E6E6E6;"></td>
            <td style="background-color: #E6E6E6;"></td>
            <td style="background-color: #E6E6E6;"><input type="text" style="border: none;text-align: center;"  name="totalvlfinal" id="totalvlfinal" value=""/></td>
            <td style="background-color: #E6E6E6;"><input type="text" style="border: none;text-align: center;"  name="totalnuevocap" id="totalnuevocap" value=""/></td>
            <td style="background-color: #E6E6E6;"></td>
            <td style="background-color: #E6E6E6;"><input type="text" style="border: none;text-align: center;"  name="totalvlgac" id="totalvlgac" value="0"/></td>
            <td style="background-color: #E6E6E6;"><input type="text" style="border: none;text-align: center;"  name="totalvltotal" id="totalvltotal" value="0"/></td>
            <td style="background-color: #E6E6E6;"><input type="text"  style="border: none;text-align: center;" name="totalbeneficio" id="totalbeneficio" value="0"/></td>
            <td style="background-color: #E6E6E6;"><input type="text" style="border: none;text-align: center;"  name="totalcuota2" id="totalcuota2" value="0"/></td>
            <td style="background-color: #E6E6E6;"><input type="text" style="border: none;text-align: center;"  name="totalcuota3" id="totalcuota3" value="0"/></td>
        </tr>
        </tbody>
    </table>
    <?php
    ?>
    <table>
        <tr>
            <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
            <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Edad Mora</th>
            <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor Cuota</th>
        </tr>
        <?php
        foreach ($creditos as $eda) {
            $edadesl = $this->vista->getMorosidad($eda['obligacion'], $session['proyecto_activo']);

            foreach ($edadesl as $e) {
                $cuo = $e['saldoenMora'] * 1.21;
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $e['obligacion']; ?></td>
                    <td style="text-align: center;"><?php echo $e['edadMora']; ?></td>
                    <td style="text-align: center;"><?php echo number_format($cuo, 0); ?></td>
                </tr>
            <?php
            }
        }
        ?>
    </table>
    <div id="acuerdo-preliminar" style="width: 100%;"></div>
</div>
