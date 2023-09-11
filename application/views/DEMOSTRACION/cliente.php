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
            <div class="col-md-12">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <buton type="button" class="btn btn-success" id="acuerdoBtn">Agregar Acuerdo</button>
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
                                <td><?php echo $userG[0]['nombre']; ?></td>
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
            <div class="col-md-12 col-sm-12">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Informacion Financiera
                        </div>
                    </div>

                    <div class="panel-body" style="overflow-x: auto;">

                        <div class="tabbable">
                            <ul class="nav nav-tabs nav-tabs-highlight">
                                <?php
                                $activo = 0;
                                $flagtab = 0;
                                $saltoActualTotal = 0;
                                foreach ($creditos as $cr2) {
                                    if ($activo == 0) {
                                        $clases = 'class="active"';
                                    } else {
                                        $clases = '';
                                    }
                                    ?>
                                    <li <?php echo $clases; ?>><a href="#<?php echo $cr2['obligacion']; ?>" data-toggle="tab"><?php echo $cr2['obligacion']; ?></a></li>
                                    <?php $activo += 1;
                                }
                                ?>
                            </ul>

                            <div class="tab-content">
                                <?php
                                $activoss = 0;
                                $totales = "";
                                $saltoActualTotal = 0;
                                foreach ($creditos as $cr) {

                                    if ($activoss == 0) {
                                        $active = 'active';
                                    } else {
                                        $active = '';
                                    }
                                    ?>
                                    <div class="tab-pane <?php echo $active; ?>" id="<?php echo $cr['obligacion']; ?>">
                                        <div class="form-group">
                                            <button flag="<?php echo $cr['obligacion']; ?>" pr="<?php echo $session['proyecto_activo']; ?>" class="btn btn-warning ver-historico">Ver Historico</button>
                                        </div>
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs nav-tabs-highlight">
                                                <li class="active"><a href="#financiera<?php echo $flagtab; ?>" data-toggle="tab">Financiera</a></li>
                                                <li><a href="#otros<?php echo $flagtab; ?>" data-toggle="tab">Otros</a></li>
                                                <li><a href="#fechas<?php echo $flagtab; ?>" data-toggle="tab">Fechas</a></li>
                                            </ul>

                                            <div class="tab-content">
                                                <div class="tab-pane active" id="financiera<?php echo $flagtab; ?>">
                                                    <ul style="width: 100%; list-style: none;">
                                                        <?php
                                                        foreach ($grilla as $g1) {
                                                            if ($g1['ubicacion'] == "valores") {
                                                                if (isset($totales[$g1['campo']])) {
                                                                    $totales[$g1['campo']] += $cr[$g1['campo']];
                                                                } else {
                                                                    $totales[$g1['campo']] = $cr[$g1['campo']];
                                                                }
                                                                ?>
                                                                <li style="float: left; width: 10%;  margin-right: 4px; text-align: center;"><label style="font-weight: bold; font-size: 14px; background-color: #F78181; color: #FFF; width: 100%; text-align: center;"><?php echo $g1['campo']; ?></label></br><?php echo number_format($cr[$g1['campo']], 2); ?></li>
                                                            <?php }
                                                        }
                                                        $saltoActualTotal += $cr['saldoActualizado'];
                                                        ?>
                                                                <li style="float: left; width: 10%;  margin-right: 4px; text-align: center;"><label style="font-weight: bold; font-size: 14px; background-color: #c39bd3; color: #FFF; width: 100%; text-align: center;">Saldo Actual</label></br><span style='background-color: #e5e8e8;'><?php echo number_format($cr['saldoActualizado'], 2); ?></span></li>
                                                    </ul>
                                                </div>

                                                <div class="tab-pane" id="otros<?php echo $flagtab; ?>">
                                                    <ul style="width: 100%; list-style: none;">
                                                        <?php
                                                        foreach ($grilla as $g1) {
                                                            if ($g1['ubicacion'] == "otros") {
                                                                ?>
                                                                <li style="float: left; width: 15%; margin-right: 4px; text-align: center;"><label style="font-weight: bold; font-size: 14px; background-color: #F78181; color: #FFF; width: 100%; text-align: center;"><?php echo $g1['campo']; ?></label></br><?php echo $cr[$g1['campo']]; ?></li>
        <?php }
    }
    ?>
                                                    </ul>
                                                </div>

                                                <div class="tab-pane" id="fechas<?php echo $flagtab; ?>">
                                                    <ul style="width: 100%; list-style: none;">
                                                        <?php
                                                        foreach ($grilla as $g1) {
                                                            if ($g1['ubicacion'] == "fechas") {
                                                                ?>
                                                                <li style="float: left; width: 15%; margin-right: 4px; text-align: center;"><label style="font-weight: bold; font-size: 14px; background-color: #F78181; color: #FFF; width: 100%; text-align: center;"><?php echo $g1['campo']; ?></label></br><?php echo $cr[$g1['campo']]; ?></li>
        <?php }
    }
    ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    <?php
    $flagtab += 1;
    $activoss += 1;
}
?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div style="clear: both; height: 15px;"></div>

        <div class="row">
            <div class="panel panel-flat" >
                <div class="panel-heading">
                    <div class="panel-title">
                        Suma de totales
                    </div>
                </div>
                <div class="panel-body">

                    <ul style="width: 100%; list-style: none;">
<?php foreach ($totales as $key => $valor) { ?>
                            <li style="float: left; width: 10%;  margin-right: 4px; text-align: center;"><label style="font-weight: bold; font-size: 14px; background-color: #F78181; color: #FFF; width: 100%; text-align: center;"><?php echo $key; ?></label></br><?php echo number_format($valor, 2); ?></li>
<?php } ?>
                            <li style="float: left; width: 10%;  margin-right: 4px; text-align: center;"><label style="font-weight: bold; font-size: 14px; background-color: #c39bd3; color: #FFF; width: 100%; text-align: center;">Saldo Actual</label></br><span style='background-color: #e5e8e8;'><?php echo number_format($saltoActualTotal, 2); ?></span></li>
                    </ul>
                </div>
            </div>
        </div>

        <div style="clear: both; height: 25px;"></div>

        <div class="row">
            <div class="panel panel-flat" style="max-height: 300px; overflow-y: auto;">
                <div class="panel-heading">
                    <div class="panel-title">
                        Campos Adicionales
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <!--<div style="width: 100%;">
                          <p><?php //echo $creditos[0]['nombreref1'];  ?></p>
                        </div>
                        <div style="clear: both; height: 20px; width:100%; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #A4A4A4;"></div>
                        <div style="width: 100%;">
                          <p><?php //echo $creditos[0]['nombreref2'];  ?></p>
                        </div>
                        <div style="clear: both; height: 20px; width:100%; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #A4A4A4;"></div>
                        <div style="width: 100%;">
                          <p><?php //echo $creditos[0]['nombreref3'];  ?></p>
                        </div>
                        <div style="clear: both; height: 20px; width:100%; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #A4A4A4;"></div>
                        <div style="width: 100%;">
                          <p><?php //echo $creditos[0]['nombreref4'];  ?></p>
                        </div>
                        <div style="clear: both; height: 20px; width:100%; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #A4A4A4;"></div>
                        <div style="width: 100%;">
                          <p><?php //echo $creditos[0]['nombreref5'];  ?></p>
                        </div>
                        <div style="clear: both; height: 20px; width:100%; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #A4A4A4;"></div>
                        <div style="width: 100%;">
                          <p><?php //echo $creditos[0]['nombreref6'];  ?></p>
                        </div>
                        <div style="clear: both; height: 20px; width:100%; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #A4A4A4;"></div>
                        <div style="width: 100%;">
                          <p><?php //echo $creditos[0]['nombreref7'];  ?></p>
                        </div>
                        <div style="clear: both; height: 20px; width:100%; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #A4A4A4;"></div>
                        <div style="width: 100%;">
                          <p><?php //echo $creditos[0]['nombreref8'];  ?></p>
                        </div>
                        <div style="clear: both; height: 20px; width:100%; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #A4A4A4;"></div>
                        <div style="width: 100%;">
                          <p><?php //echo $creditos[0]['nombreref9'];  ?></p>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both; height: 15px;"></div>

        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <div class="panel-title">
                        Biblioteca de Archivos
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <form name="subir-archivo" id="subir-archivo" method="post" enctype="multipart/form-data" action="https://<?php echo $this->config->item('host_cobranzas'); ?>/modulo_cobranzas/index.php/subirarchivo">
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
                <div class="panel-heading">
                    <div class="panel-title">
                        Nota permanente
                    </div>
                </div>
                <div class="panel-body">

                    <textarea name="nota-permanente" id="nota-permanente" class="form-control"><?php echo $cliente[0]['notapermanente']; ?></textarea>

                </div>
            </div>
        </div>
        <div style="clear: both; height: 15px;"></div>


        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="panel-group accordion" id="accordion-styled">
                        <div class="panel">

                            <div class="panel-heading">
                                <div class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion-styled" href="#referencias">Referencias</a>
                                </div>
                            </div>
                            <div id="referencias" class="panel-collapse collapse">
                                <div class="panel-body" style="overflow-x: auto;">
                                    <div class="form-group">
                                        <button class="btn btn-info" id="add-referencia-btn" name="add-referencia-btn">Agregar Referencia</button>
                                    </div>
                                    <table class="table dataTable table-bordered">
                                        <tr>
                                            <th style="background-color: #d5f5e3; font-size: 12px;">Documento</th>
                                            <th style="background-color: #d5f5e3; font-size: 12px;">Nombre</th>
                                            <th style="background-color: #d5f5e3; font-size: 12px;">Tipo</th>
                                            <th style="background-color: #d5f5e3; font-size: 12px;">Relacion</th>
                                            <th style="background-color: #d5f5e3; font-size: 12px;">Telefono 1</th>
                                            <th style="background-color: #d5f5e3; font-size: 12px;">Direccion</th>
                                            <th style="background-color: #d5f5e3; font-size: 12px;">Ciudad</th>
                                            <th style="background-color: #d5f5e3; font-size: 12px;">Colonia</th>
                                            <th style="background-color: #d5f5e3; font-size: 12px;">Municipio</th>
                                            <th style="background-color: #d5f5e3; font-size: 12px;">Departamento</th>
                                            <th style="background-color: #d5f5e3; font-size: 12px;">Zona</th>
                                            <?php  if($session['perfil'] < 4){ ?>
                                             <th style="background-color: #d5f5e3; font-size: 12px;">Accion</th>
                                            <?php } ?>
                                        </tr>
                                    <?php foreach ($referencias as $ref) {

                                        if($ref['activo'] == 0){
                                            if($session['perfil'] < 4){
                                        ?>
                                            <tr style="background-color: #2c3e50; color: #FFF;">
                                                <th style="background-color: #2c3e50; color: #FFF;"><?php echo $ref['docReferencia']; ?></th>
                                                <th style="background-color: #2c3e50; color: #FFF;"><?php echo $ref['nombre']; ?></th>
                                                <th style="background-color: #2c3e50; color: #FFF;"><?php echo $ref['tipoReferencia']; ?></th>
                                                <th style="background-color: #2c3e50; color: #FFF;"><?php echo $ref['relacion']; ?></th>
                                                <th style="background-color: #2c3e50; color: #FFF;"><?php echo $ref['telefonoRef']; ?></th>
                                                <th style="background-color: #2c3e50; color: #FFF;"><?php echo $ref['direccionRef']; ?></th>
                                                <th style="background-color: #2c3e50; color: #FFF;"><?php echo $ref['ciudadRef']; ?></th>
                                                <th style="background-color: #2c3e50; color: #FFF;"><?php echo $ref['colonia']; ?></th>
                                                <th style="background-color: #2c3e50; color: #FFF;"><?php echo $ref['municipio']; ?></th>
                                                <th style="background-color: #2c3e50; color: #FFF;"><?php echo $ref['departamento']; ?></th>
                                                <th style="background-color: #2c3e50; color: #FFF;"><?php echo $ref['zona']; ?></th>
                                                <th style="background-color: #2c3e50; color: #FFF;"><p style="color: #FFF; cursor: pointer;" flag="1" ref="<?php echo $ref['idReferencia']; ?>" class="cambia-estado-ref">Activar</p></th>
                                            </tr>
                                            <?php } }else{ ?>
                                            <tr>
                                                <td><?php echo $ref['docReferencia']; ?></td>
                                                <td><?php echo $ref['nombre']; ?></td>
                                                <td><?php echo $ref['tipoReferencia']; ?></td>
                                                <td><?php echo $ref['relacion']; ?></td>
                                                <td><?php echo $ref['telefonoRef']; ?></td>
                                                <td><?php echo $ref['direccionRef']; ?></td>
                                                <td><?php echo $ref['ciudadRef']; ?></td>
                                                <td><?php echo $ref['colonia']; ?></td>
                                                <td><?php echo $ref['municipio']; ?></td>
                                                <td><?php echo $ref['departamento']; ?></td>
                                                <td><?php echo $ref['zona']; ?></td>
                                                <?php  if($session['perfil'] < 4){ ?>
                                                    <td><p style="cursor: pointer;" flag="0" ref="<?php echo $ref['idReferencia']; ?>" class="cambia-estado-ref">Desactivar</p></td>
                                                   <?php } ?>
                                            </tr>
                                            <?php } } ?>
                                    </table>
                                </div>
                            </div>

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
                                                    <td style="text-align: center;"><?php echo number_format($pg['valor'], 2); ?></td>
                                                    <td style="text-align: center;"><?php echo $pg['descripcion']; ?></td>
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
                                                    $pdf = '<a href="http://' . $this->config->item('host_cobranzas') . '/index.php/generapdf/' . $acs['idAcuerdo'] . '" target="blanck"><img src="http://' . $this->config->item('host_cobranzas') . '/front/img/pdf2.png" alt="Imprime Acuerdo" title="Imprime Acuerdo"/></a>';
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

                            <div class="panel-heading">
                                <div class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion-styled" href="#promesas">Promesas</a>
                                </div>
                            </div>
                            <div id="promesas" class="panel-collapse collapse">
                                <div class="panel-body" style="overflow-x: auto;">
                                    <table class="table-bordered" style="width: 100% !important;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
foreach ($proyeccion as $pro) {
    $cumpli = $this->vista->getCumplido($pro['idCumplido'], $session['proyecto_activo']);
    ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo $pro['obligaciondos'] ?></td>
                                                    <td style="text-align: center;"><?php echo $pro['fechaPromesa'] ?></td>
                                                    <td style="text-align: center;"><?php echo $pro['valorpromesa'] ?></td>
                                                    <td style="text-align: center;"><?php echo $cumpli[0]['descripcion'] ?></td>
                                                </tr>
<?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="panel-heading">
                                <div class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion-styled" href="#confirmaciones">Confirmaciones</a>
                                </div>
                            </div>
                            <div id="confirmaciones" class="panel-collapse collapse">
                                <div class="panel-body" style="overflow-x: auto;">
                                    <table class="table-bordered" style="width: 100% !important;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Obligacion</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Fecha</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Valor</th>
                                                <th style="background-color: #819FF7; text-align: center; color: #FFF; font-weight: lighter;">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
foreach ($confirmaciones as $confs) {
    $cumpli2 = $this->vista->getCumplido($confs['idCumplido'], $session['proyecto_activo']);
    ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo $confs['obligaciondos'] ?></td>
                                                    <td style="text-align: center;"><?php echo $confs['fechaPromesa'] ?></td>
                                                    <td style="text-align: center;"><?php echo $confs['valorpromesa'] ?></td>
                                                    <td style="text-align: center;"><?php echo $cumpli2[0]['descripcion'] ?></td>
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
                    <button type="button" id="gestionCompleta" class="btn btn-info btn-xs">Toda</button>&nbsp;&nbsp;&nbsp;<button type="button" id="gestionEfectiva" class="btn btn-success btn-xs">Efectiva</button>&nbsp;&nbsp;&nbsp;
                    <div style="float: right;" class="form-group">
                        <div class="input-group input-group-lg">
                            <input class="form-control input-xs" placeholder="Palabra clave" name="valor-filtro" id="valor-filtro" type="text">
                            <span class="input-group-btn">
                                <button class="btn btn-default" id="filtrarGest-btn" type="button">
                                    <i class="icon icon-search4"></i>
                                </button> </span>
                        </div>
                    </div>
                    </br></br>
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
                            $vlacu = "";

                            if ($ges['fechaAcuerdo'] != "0000-00-00" && $ges['fechaAcuerdo'] != "") {
                                $fecacu = $ges['fechaAcuerdo'];
                                $vlacu = $ges['vlAcuerdo'];
                            }
                            ?>

                            <div class="panel">
                                <div class="panel-heading" <?php echo $color; ?>>
                                    <div class="panel-title">
                                        <a <?php echo $class; ?> data-toggle="collapse" data-parent="#accordion-styled" href="#<?php echo $ges['idCallhist']; ?>"><?php echo $ges['fechaGestion'] . " - " . $user[0]['usuario'] . " - Tel: " . $ges['telefono'] . " - " . $cont[0]['descripcion'] . " - " . $result[0]['descripcion'] . " - " . $fecacu . " - " . $vlacu; ?></a>
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
<div id="acuerdopago-modal">
    <table class="table">
        <thead>
            <tr>
                <th>Obligacion</th>
                <th>Fecha Pago</th>
                <th>Valor</th>
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
                <td><input type="text" readonly="readonly" name="fechas-acuerdos" id="fechas-acuerdos" class="form-control datepicker-here" data-position="bottom left" data-language='en'/></td>
                <td><input type="text" name="valor-acuerdo" id="valor-acuerdo" class="form-control"/></td>
                <td><input type="text" name="cuotas-acuerdo" id="cuotas-acuerdo" class="form-control"/></td>
            </tr>
            <tr>
                <td><button class="btn btn-success" id="generaAcuerdoCuotas" type="button">Generar</button></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div id="acuerdo-preliminar" style="width: 100%;"></div>
</div>
